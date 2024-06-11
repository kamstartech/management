<?php
class auth {

	public $core;

	public function __construct($core) {
		$this->core = $core;
	}

	public function login() {
		$username = $this->core->cleanPost['username'];
		$password = $this->core->cleanPost['password'];

		if (isset($username) && isset($password) && $username != '' && $password != '') {
			
			if (!$this->authenticateSQL($username, $password)) {
				return FALSE;
			} else {
				return TRUE;
			}

		} else {
			$this->core->setViewError('Please enter all fields', 'Please <a href=".">return to the login page</a> and try again.');
			$this->core->builder->initView("fault");
			return FALSE; 
		}

		return FALSE;
	}

	private function authenticateAccess($username, $password, $nologin = FALSE, $role = FALSE) {

		$passwordHashed = $this->hashPassword($username, $password);

		$sql = "SELECT RoleID FROM `access` LEFT JOIN `roles` ON `access`.`RoleID` = `roles`.`ID` WHERE Username = '$username'";
		$run = $this->core->database->doSelectQuery($sql);

		if ($run->num_rows == 0) {

			$this->core->logEvent("User '$username' not present in ACCESS table, perhaps added through LDAP, now adding", "3");

			if (is_numeric($username) || $role == 10) {
				$roleID = "10";
				$sql = "INSERT INTO `access` (`ID`, `Username`, `RoleID`, `Password`) VALUES (NULL, '$username', '$roleID', '$passwordHashed');";
				$this->core->database->doInsertQuery($sql);
			} else {
				$roleID = "101";
				$sql = "INSERT INTO `access` (`ID`, `Username`, `RoleID`, `Password`) VALUES (NULL, '$username', '$roleID', '$passwordHashed');";
				$this->core->database->doInsertQuery($sql);
			}
		}

		$sql = "SELECT `access`.RoleID, `access`.ID, `access`.Username FROM `access` LEFT JOIN `roles` ON `access`.`RoleID` = `roles`.`ID` WHERE Username = '$username'";
		$mbs = $this->core->database->doSelectQuery($sql);

		while ($row = $mbs->fetch_assoc()) {

			$roleID = $row['RoleID'];
			$userID = $row['Username'];
			$rolename = $this->role($roleID);

			$sql = "SELECT * FROM `basic-information` WHERE `ID` = '$userID'";
			$mkb = $this->core->database->doSelectQuery($sql);

			if ($mkb->num_rows == 0) {
				$sql = "INSERT INTO `basic-information` (`FirstName`, `MiddleName`, `Surname`, `Sex`, `ID`, `GovernmentID`, `DateOfBirth`, `PlaceOfBirth`, `Nationality`, `StreetName`, `PostalCode`, `Town`, `Country`, `HomePhone`, `MobilePhone`, `Disability`, `DissabilityType`, `PrivateEmail`, `MaritalStatus`, `StudyType`, `Status`) 
					VALUES (NULL, NULL, NULL, NULL, NULL, '$id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Employed');";

				$this->core->database->doInsertQuery($sql);
			}

		}


		return $this->authenticateSession($username, $password, $userID, $roleID, $rolename, FALSE);

	}

	public function hashPassword($username, $password){
		$passwordHashed = hash('sha512', $password . $this->core->conf['conf']['hash'] . $username);
		return $passwordHashed;
	}

	public function mailNotice($userid, $role){
		
		if($role == 1000){
			$ip = $_SERVER['REMOTE_ADDR'];
			if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
				$ip = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
			}
	
			$sql = "SELECT * FROM `basic-information`
					WHERE `basic-information`.`ID` = '" . $userid . "'";
			$run = $this->core->database->doSelectQuery($sql);
			while ($fetch = $run->fetch_assoc()) {
				$recipient = $fetch["PrivateEmail"];
				$name = $fetch["FirstName"] . ' ' .  $fetch["Surname"];
				$study = $ip;

				include $this->core->conf['conf']['servicePath'] . "mailer.inc.php";

				$mailer = new mailer;
				$mailer->runService($this->core);
				$mailer->newMail("login", $recipient, $name, $study, NULL);
			}
		}
			
	}

	private function authenticateSQL($username, $password, $nologin = FALSE) {
	
		$passwordHashed = hash('sha512', $password . $this->core->conf['conf']['hash'] . $username);
		$passwordSHA = sha1($password);
		
		if($password == 'PASSWORD'){
			$passwordHashed  = 'PASSWORD';
		}
	
		$sql = "SELECT access.ID as UserID, RoleID, Status
			FROM `access` 
			LEFT JOIN `basic-information` 
			ON `basic-information`.`ID`=`access`.`ID` 
			WHERE `access`.Username = '$username' 
			AND (`access`.Password = '$passwordHashed' OR `access`.Password = '$username')";


		$run = $this->core->database->doSelectQuery($sql);
	
		if ($run->num_rows > 0) { //successful login
			$this->core->logEvent("User '$username' authenticated successfully", "4");
			
			while ($row = $run->fetch_assoc()) {
				$userID = $row['UserID'];
				$role = $row['RoleID'];
				$status = $row['Status'];
				
				//$this->mailNotice($userID, $role);

				$rolename = $this->role($role);
								
				if(empty($role) || $role==0) {
					// User does not have any permissions
					$this->core->setViewError('Unauthorized access', "You do not have permissions to access this system, please contact the academic office");
					$this->core->builder->initView("fault");
				} 
		
				if($status == "New" || $status == "Approved" || $status == "Readmitted" || $status == "Requesting" || $status == "Employed" || $status == "Enrolled" ||  $status == "Applying"){
					// Student or Employee with access
					$sql = "UPDATE `access` SET `PasswordMoodle` = '$passwordSHA' WHERE `Username` = '$username'";
					$this->core->database->doInsertQuery($sql);
				} else if($status == "Locked"){
					// User is locked
					$this->core->setViewError('STUDENT LOCKED', "You have not reported online and are no longer considered an active student. Write to the registrar for readmission to the university.");
					$this->core->builder->initView("fault");
					return FALSE;
				} else {
					// User does not have any permissions
					$this->core->setViewError('ACCESS DENIED', "Your access to the system has been denied. Please contact ICT.");
					$this->core->builder->initView("fault");
					return FALSE;
				}
			}
			
		} else {
			$this->core->logEvent("User '$username' authentication failed", "2");
			return FALSE;
		}

		return $this->authenticateSession($username, $password, $userID, $role, $rolename, $nologin);
	}

	private function authenticateSession($username, $password, $userID, $role, $rolename, $nologin = FALSE) {

		if($role == 1001){
			$role = 1000;
		}

		if(isset($username, $password, $userID, $role, $rolename) && $nologin == FALSE){
		
			$_SESSION['path'] = $this->core->conf['conf']['path'];
			$_SESSION['userid'] = $userID;
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			$_SESSION['role'] = $role;
			$_SESSION['rolename'] = $rolename;

			$_SESSION['saobjects'] = $this->getStudyInformation($userID);

			$this->core->setPath($this->core->conf['conf']['path']);
			$this->core->setUsername($username);
			$this->core->setUserID($userID);
			$this->core->setRoleName($rolename);
			$this->core->setRole($role);

			return TRUE;
		}else if($nologin == TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function getStudyInformation($userID){
		$sql = "SELECT `st`.Name,  `st`.ShortName, ProgramName, `sc`.Name FROM `access` as ac, `student-study-link` as ss, `study` as st, `student-program-link` as pl, `programmes` as pr, `schools` as sc, `basic-information` as bi
		WHERE ac.`ID` = '$userID' AND ac.`ID` = bi.`ID` AND bi.`GovernmentID` = ss.`StudentID` AND ss.`StudyID` = st.`ID`  AND bi.`GovernmentID` = pl.`StudentID` AND st.`ParentID` = sc.`ID` AND pl.`major` = pr.`id`
		OR  ac.`ID` = '$userID'  AND ac.`ID` = bi.`ID` AND bi.`GovernmentID` = ss.`StudentID` AND ss.`StudyID` = st.`ID`  AND bi.`GovernmentID` = pl.`StudentID` AND st.`ParentID` = sc.`ID` AND pl.`minor` = pr.`id`";

		$run = $this->core->database->doSelectQuery($sql);

		return $run->fetch_array(MYSQLI_NUM);
	}


	public function getUsername($item) {
		$sql = "SELECT * FROM `access` WHERE `ID` = $item";

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $run->fetch_assoc();

		return $fetch['Username'];
	}

	public function getUserID($item) {
		$sql = "SELECT * FROM `access` WHERE `Username` = '$item'";

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $run->fetch_assoc();

		return $fetch['ID'];
	}


	public function mysqlChangePass($username, $oldpass, $newpass, $admin) {

		if(!is_numeric($username)){
			$id = $this->getUserID($username);
		} else {
			$id = $username;
			$username = $this->getUsername($id);
			if(empty($username)){
				$username = $id;
			}
		}

		if($admin != TRUE){
			if(!$this->authenticateSQL($username, $oldpass)){
				return false;
			}
		}

		$password = hash('sha512', $newpass . $this->core->conf['conf']['hash'] . $username);
		$passwordSHA = sha1($newpass);

		$sql = "UPDATE `access` SET `Password` = '$password', `PasswordMoodle` = '$passwordSHA' WHERE `ID` = '$id'";
		$run = $this->core->database->doInsertQuery($sql);


		if($this->core->database->mysqli->affected_rows == 0){	
			$roleID = "10";
			$sql = "REPLACE INTO `access` (`ID`, `Username`, `RoleID`, `Password`) VALUES ('$id', '$username', '$roleID', '$password');";
			$run = $this->core->database->doInsertQuery($sql);
		}

		if ($run) {
			if($this->authenticateSQL($username, $newpass, TRUE)){
				$this->core->logEvent("User '$username' changed password", "4");
				$this->core->throwSuccess("Your password has been changed! The next time you log-in you will need to use your new password.");
				return TRUE;
			}
		} else {
			return false;
		}
	}

	private function role($access) {
		$sql = "SELECT * FROM `roles` WHERE ID LIKE '$access'";
		$run = $this->core->database->doSelectQuery($sql);

		while ($row = $run->fetch_assoc()) {
			return $row['RoleName'];
		}
	}


	function logout() {
		$username = $this->core->username;

		session_destroy();
		
		$this->core->setPath(NULL);
		$this->core->setUsername(NULL);
		$this->core->setUserID(NULL);
		$this->core->setRoleName(NULL);
		$this->core->setRole(NULL);

		$ip = $_SERVER['REMOTE_ADDR'];
		if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
			$ip = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
		}
		
		$sql = 'UPDATE acl SET `status`="LOGOUT" WHERE `user` = "'.$username.'" AND `ip` = "'.$ip.'" AND `date` = CURDATE()';
		$run = $this->core->database->doInsertQuery($sql);

		$this->core->setPage(NULL);
	}
}

?>
