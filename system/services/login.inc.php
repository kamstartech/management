<?php
class login {

	public $core;
	public $service;
	public $item = NULL;

	public function configService() {
		$this->service->output = TRUE;
		return $this->service;
	}

	public function runService($core) {
		$this->core = $core;
		$username = $_GET['username'];
   		$password = $_GET['password'];
		$domain = $_GET['domain'];

		$login = $this->authenticate($username,$password);


	}

	public function generateKey($length, $charset = 'abcdefghijklmnopqrstuvwxyz23456789') {
		$str = '';
		$count = strlen($charset);
		while ($length--) {
			$str .= $charset[mt_rand(0, $count - 1)];
		}
		return $str;
	}


	public function authenticate($username, $password) {

		if (isset($username) && isset($password) && $username != '' && $password != '') {

			if (!$this->authenticateLDAP($username, $password)) {

				if (!$this->authenticateSQL($username, $password)) {
					return FALSE;
				} else {
					return TRUE;
				}
			}else {
				return TRUE;
			}

		} else {
			$this->core->setViewError('Please enter all fields', 'Please <a href=".">return to the login page</a> and try again.');
			$this->core->builder->initView("fault");
			return FALSE; 
		}

		return FALSE;
	}

	private function authenticateLDAP($username, $password) {
		if ($this->core->conf['ldap']['ldapEnabled'] == TRUE && function_exists('ldap_connect')) {

			$adServer = "ldap://zcasdc01.zcas.edu.zm";

			$ldap = ldap_connect($adServer);
			$ldaprdn = $username . '@zcas.edu.zm';

			ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

			$ldapbind = ldap_bind($ldap, $ldaprdn, $password);

			if ($ldapbind) {
       	 	        	$filter="(sAMAccountName=$username)";
       	 	        	$result = ldap_search($ldap,"dc=zcas,dc=edu,dc=zm",$filter);
       	 	        	ldap_sort($ldap,$result,"sn");
       	 		        $info = ldap_get_entries($ldap, $result);
       	        		for ($i=0; $i<$info["count"]; $i++){
                        		if($info['count'] > 1){
		                	        break;
	                        	}

	                   		$surname = $info[$i]["sn"][0];
					$firstname = $info[$i]["givenname"][0];
					$userid = $info[$i]["samaccountname"][0];
	                   		$dn = $info[$i]["dn"];
	                    		$group = $info[$i]["primarygroupid"][0];

                        		if (strpos($dn, $this->core->conf['ldap']['studentou']) !== false) {
                                		$role = 10;
                        		} else {
                                		$role = 100; 
                        		}
	                	}
	                	@ldap_close($ldap);

				$this->core->logEvent("User '$username' authenticated successfully", "4");
				return $this->authenticateSession($username, $password, $role);
			} else {
				$this->core->logEvent("User '$username' authentication failed", "4");
				return FALSE;
			}

		} else {
			$this->core->logEvent("PHP-LDAP module missing or not enabled", "1");
		}

		return FALSE;
	}

	public function hashPassword($username, $password){
		$passwordHashed = hash('sha512', $password . $this->core->conf['conf']['hash'] . $username);
		return $passwordHashed;
	}

	private function authenticateSQL($username, $password, $nologin = FALSE) {
	
		$passwordHashed = hash('sha512', $password . $this->core->conf['conf']['hash'] . $username);

	
		$sql = "SELECT access.ID as UserID, RoleID, Status
			FROM `access` 
			LEFT JOIN `basic-information` 
			ON `basic-information`.`ID`=`access`.`ID` 
			WHERE `access`.Username = '$username' 
			AND `access`.Password = '$passwordHashed'";

		$run = $this->core->database->doSelectQuery($sql);
	
		if ($run->num_rows > 0) { //successful login
			$this->core->logEvent("User '$username' authenticated successfully", "4");
			
			while ($row = $run->fetch_assoc()) {
				$userID = $row['UserID'];
				$role = $row['RoleID'];
				$status = $row['Status'];

				$rolename = $this->role($role);
								
				if(empty($role) || $role==0) {
					// User does not have any permissions
					$this->core->setViewError('Unauthorized access', "You do not have permissions to access this system, please contact the academic office", "LOGIN");
					$this->core->builder->initView("fault");
				} 
		
				if($status == "New" || $status == "Approved" || $status == "Readmitted" || $status == "Requesting" || $status == "Employed" || $status == "Enrolled" ||  $status == "Applying"){
					// Student or Employee with access
				} else if($status == "Locked"){
					// User is locked
					$this->core->setViewError('STUDENT LOCKED', "You have not reported online and are no longer considered an active student. Write to the registrar for readmission to the university.", "LOGIN");
					$this->core->builder->initView("fault");
					return FALSE;
				} else {
					// User does not have any permissions
					$this->core->setViewError('ACCESS DENIED', "Your access to the system has been denied. Please contact ICT.", "LOGIN");
					$this->core->builder->initView("fault");
					return FALSE;
				}
			}
			
		} else {
			$this->core->logEvent("User '$username' authentication failed", "2");
			return FALSE;
		}

		return $this->authenticateSession($username, $password,  $nologin);
	}


	private function authenticateSession($username, $password, $nologin = FALSE) {
	

		$sql = "SELECT access.ID as UserID, RoleID, FirstName, Surname, Status FROM `access` 
			LEFT JOIN `basic-information` ON `basic-information`.`ID` = `access`.`ID` 
			WHERE `access`.Username = '$username'";

		$run = $this->core->database->doSelectQuery($sql);
		
		if ($run->num_rows > 0) { //successful login
			$this->core->logEvent("User '$username' authenticated successfully", "4");
			
			while ($row = $run->fetch_assoc()) {
				$userID = $row['UserID'];
				$role = $row['RoleID'];
				$status = $row['Status'];
				$name = $row['FirstName'] . ' ' .  $row['Surname'];

				$key = $this->generateKey(16);

				$output[0] = "AUTHORIZED";
				$output[1] = $userID;
				$output[2] = $role;
				$output[3] = $name;
				$output[4] = $status;
				$output[5] = $key; 

				$sqlx = "INSERT INTO `authentication` (`ID`, `StudentID`, `Login`, `Key`) VALUES (NULL, '$userID', NOW(), '$key')";
				$this->core->database->doInsertQuery($sqlx);

							
				if(empty($role) || $role==0) {
					$output = 'ACCESS DENIED - Your access to the system has been denied. Please contact ICT.';
				}

				if($status == "New" || $status == "Approved" || $status == "Requesting" || $status == "Employed" ||  $status == "Applying" || $status == ""){
					
				} else {
					$output = 'ACCESS DENIED - Your access to the system has been denied. Please contact ICT.';
				}
			}
			
		} else {
			$output = 'ACCESS DENIED - Your access to the system has been denied. Please contact ICT.';
		}

		echo json_encode($output);
	}
}

?>