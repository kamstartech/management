<?php
class users {

	public $core;
	public $view;
	public $item = NULL;

	public function configView() {
		$this->view->header = TRUE;
		$this->view->footer = TRUE;
		$this->view->menu = TRUE;
		$this->view->javascript = array();
		$this->view->css = array();

		return $this->view;
	}

	public function buildView($core) {
		$this->core = $core;
	}
	
	private function generatePassword($length, $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1') {
		$str = '';
		$count = strlen($charset);
		while ($length--) {
			$str .= $charset[mt_rand(0, $count - 1)];
		}
		return $str;
	}

	function withdrawUsers() {
		echo'Are you certain you wish to withdraw from the university. To confirm enter the code sent by SMS to your phone in the box below. (Wait up to 2 minutes)<br><br>';
		echo'<form><div class="label">SMS code: </div><input type="text" name="code"><br>
		<br><div class="label">Click to confirm: </div><input style="width: 300px;" type="submit" value="I CONFIRM I AM WITHDRAWING"></form>
		<p><br></p>';
	}

	function addUsers() {
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";

		$select = new optionBuilder($this->core);
		$roles = $select->showRoles();
		$users = $select->showUsers();
		$positions = $select->showPositions();

		include $this->core->conf['conf']['formPath'] . "adduser.form.php";
	}

	function saveUsers() {

		$password = $this->generatePassword(6);

		if ($this->core->cleanPost["otherdissability"]) {
			$dissabilitytype = $this->core->cleanPost["otherdissability"];
		}


		// ADDUSER QUERY NEEDS PREPARED STATEMENT

		// Fields user account
		$username = $this->core->cleanPost["username"];
		$firstname = $this->core->cleanPost["firstname"];
		$middlename = $this->core->cleanPost["middlename"];
		$surname = $this->core->cleanPost["surname"];
		$sex = $this->core->cleanPost["sex"];
		$id = $this->core->cleanPost["studentid"];
		$day = $this->core->cleanPost["day"];
		$month = $this->core->cleanPost["month"];
		$year = $this->core->cleanPost["year"];
		$pob = $this->core->cleanPost["pob"];
		$nationality = $this->core->cleanPost["nationality"];
		$streetname = $this->core->cleanPost["streetname"];
		$postalcode = $this->core->cleanPost["postalcode"];
		$town = $this->core->cleanPost["town"];
		$country = $this->core->cleanPost["country"];
		$homephone = $this->core->cleanPost["homephone"];
		$celphone = $this->core->cleanPost["celphone"];
		$dissability = $this->core->cleanPost["dissability"];
		$mstatus = $this->core->cleanPost["mstatus"];
		$email = $this->core->cleanPost["email"];
		$dissabilitytype = $this->core->cleanPost["dissabilitytype"];
		$status = $this->core->cleanPost["status"];
		$roleid = $this->core->cleanPost["role"];
		$studytype = $this->core->cleanPost["studytype"];
		
		$position = $this->core->cleanPost["position"];
		$engaged = $this->core->cleanPost["engaged"];
		$tpin = $this->core->cleanPost["tpin"];
		$napsa = $this->core->cleanPost["napsa"];
		$bank = $this->core->cleanPost["bank"];
		$account = $this->core->cleanPost["account"];
		$branch = $this->core->cleanPost["branch"];
		$enddate = $this->core->cleanPost["endcontract"];
		$empno = $this->core->cleanPost["empno"];
		
		$yeartoday = date("Y");
		$sql = "INSERT INTO `staff` (`ID`, `EmployeeNo`, `JobTitle`,`TaxID`,`SocialSecurity`, `Bank`,`BankAccount`,`BankBranch`,`EmploymentDate`,`EndDate`,`Grade`, `BasicPay`, `Leavedays`, `Gratuity`) 
				VALUES (NULL, '$empno', '$position', '$tpin','$napsa','$bank','$account', '$branch',  '$engaged', '$enddate', '', '0', '0', '0')";
				
		$run = $this->core->database->doInsertQuery($sql);
		
		$idx = $this->core->database->id();

		$sql = "INSERT INTO `basic-information` (`FirstName`, `MiddleName`, `Surname`, `Sex`,  `GovernmentID`, `DateOfBirth`, `PlaceOfBirth`, `Nationality`, `StreetName`, `PostalCode`, `Town`, `Country`, `HomePhone`, `MobilePhone`, `Disability`, `DissabilityType`, `PrivateEmail`, `MaritalStatus`, `StudyType`, `Status`) 
				VALUES ('$firstname', '$middlename', '$surname', '$sex', '$id', '$year-$month-$day', '$pob', '$nationality', '$streetname', '$postalcode', '$town', '$country', '$homephone', '$celphone', '$dissability', '$dissabilitytype', '$email', '$mstatus', 'Staff', 'Employed');";


	 
		if ($this->core->database->doInsertQuery($sql)) {

			$sql = "SELECT * FROM `basic-information` WHERE `ID` = '$idx'";

			$dms = $this->core->database->doSelectQuery($sql);

			while ($fetch = $dms->fetch_assoc()) {

				// $passenc = sha1($password);
				$passenc = $this->hashPassword($username, $password);
				$sql = "INSERT INTO `access` (`ID`, `Username`, `RoleID`, `Password`) VALUES ($idx, '$username', '$roleid', '$passenc');";

				$this->core->database->doInsertQuery($sql);

				echo '<div class="successpopup">The requested user account has been created.<br/> WRITE THE FOLLOWING INFORMATION DOWN OR REMEMBER IT!</div>';

				echo '<div class="successpopup">Username:  <b>' . $username . '</b><br>Password:  <b>' . $password . '</b></div>';
			}
		} else {

			$this->core->throwError('An error occurred with the information you have entered. Please return to the form and verify your information. <a a href="javascript:" onclick="history.go(-1); return false">Go back</a>');

		}

	}

	private function hashPassword($username, $password){
		$passwordHashed = hash('sha512', $password . $this->core->conf['conf']['hash'] . $username);
		return $passwordHashed;
	}

	function manageUsers() {

		if($this->core->pager == FALSE){
			echo '<div class="toolbar">
			<a href="' . $this->core->conf['conf']['path'] . '/users/add">Add new user account</a>
			</div>'; 

			echo '<table class="table table-striped" width="768" height="" border="0" cellpadding="3" cellspacing="0">
			<tr class="tableheader">
				<td><b> #</b></td>
				<td><b> Name</b></td>
				<td><b> Access role</b></td>
				<td><b> Username </b></td>
				<td><b> Status</b></td>		
				<td><b> Options</b></td>
			</tr>';
		}

		$sql = "SELECT *, `access`.ID as UID FROM `access`
			LEFT JOIN `roles` ON `access`.RoleID = `roles`.ID
			LEFT JOIN `basic-information` ON `access`.ID = `basic-information`.ID
			WHERE `access`.RoleID > 10 
			ORDER BY `access`.Username";


		$run = $this->core->database->doSelectQuery($sql);

		$sqlcount = "SELECT count(*)  FROM `basic-information`, `access`, `roles` 
			WHERE `access`.`ID` = `basic-information`.`ID` 
			AND `access`.`RoleID` = `roles`.`ID` 
			AND `access`.`RoleID` > 10 ORDER BY `basic-information`.Surname";

		$runcount = $this->core->database->doSelectQuery($sqlcount);

		while ($row = $runcount->fetch_row()) {
			$total = $row[0];
		}

		while ($row = $run->fetch_assoc()) {

			$firstname = $row['FirstName'];
			$middlename = $row['MiddleName'];
			$surname = $row['Surname'];

			$username = $row['Username'];
			
			if(empty($firstname) && empty($lastname)){
				$firstname = $username;
			}

			$sex = $row[3];

			$uid = $row['UID'];
			$nrc = $row['GovernmentID'];
			$role = $row['RoleName'];
			$status = $row['Status'];


			echo '<tr>
				<td>' . $uid . '</td>
				<td style=""> <img src="' . $this->core->fullTemplatePath . '/images/user.png"> <a href="' . $this->core->conf['conf']['path'] . '/information/show/' . $uid . '" style="'.$style.'"><b>' . $firstname . ' ' . $middlename . ' ' . $surname . '</b></a></td>
				<td style=""><i>' . $role . '</i></td>
				<td style=""><b>' .$username .'</b></td>
				<td style="">' . $status . '</td>
				<td style=""><a href="' . $this->core->conf['conf']['path'] . '/information/edit/' . $uid . '"><img src="' . $this->core->fullTemplatePath . '/images/edi.png"> edit</a>  <a href="' . $this->core->conf['conf']['path'] . '/users/delete/' . $uid . '" onclick="return confirm(\'Are you sure?\')"><img src="' . $this->core->fullTemplatePath . '/images/delete.gif"> delete</a></td>
			</tr>';
		}

		echo'</table>';

	}

	function studentsUsers() {

		if($this->core->pager == FALSE){

			echo '<table width="768" height="" border="0" cellpadding="3" cellspacing="0">
			<tr class="tableheader">
			<td></td>
			<td><b> Student Name</b></td>
			<td><b> Student ID</b></td>
			<td><b> Status</b></td>		
			<td><b> Options</b></td>
			</tr></table>';
		}

		$sql = "SELECT * FROM `basic-information` 
			LEFT JOIN `access` ON `access`.`ID` = `basic-information`.`ID` 
			LEFT JOIN `roles` ON `roles`.`ID` = `access`.`RoleID` 
			WHERE `basic-information`.`Status` = 'Distance' 
			OR `basic-information`.`StudyType` = 'Fulltime' 
			ORDER BY `Surname`";

		$sql = $sql . " LIMIT ". $this->core->limit ." OFFSET ". $this->core->offset;

		$run = $this->core->database->doSelectQuery($sql);

		$sqlcount = "SELECT count(*) FROM `basic-information` 
			WHERE `basic-information`.`Status` = 'Distance' 
			OR `basic-information`.`StudyType` = 'Fulltime'";

		$runcount = $this->core->database->doSelectQuery($sqlcount);

		while ($row = $runcount->fetch_row()) {
			$total = $row[0];
		}
		

		while ($row = $run->fetch_row()) {

			$firstname = $row[0];
			$middlename = $row[1];
			$surname = $row[2];
			$sex = $row[3];
			$uid = $row[4];
			$nrc = $row[5];
			$status = $row[20];

		echo '<div class="resultrow">
				<div style="width: 20px; float:left;"><img src="' . $this->core->fullTemplatePath . '/images/bullet_user.png"></div>
				<div style="width: 275px; float:left;"> <a href="' . $this->core->conf['conf']['path'] . '/information/show/' . $uid . '"><b>' . $firstname . ' ' . $middlename . ' ' . $surname . '</b></a></div>
				<div style="width: 190px; float:left;">' . $uid . '</div>
				<div style="width: 140px; float:left;">' . $status . '</div>
				<div style="width: 100px; float:left;"><a href="' . $this->core->conf['conf']['path'] . '/information/edit/' . $uid . '"><img src="' . $this->core->fullTemplatePath . '/images/edi.png"> edit</a>  <a href="' . $this->core->conf['conf']['path'] . '/users/delete/' . $uid . '" onclick="return confirm(\'Are you sure?\')"><img src="' . $this->core->fullTemplatePath . '/images/delete.gif"> delete</a></div>
		  	</div>';
		}

		if($this->core->pager == FALSE){
			echo'<div id="results">&zwnj;</div>';
			include $this->core->conf['conf']['libPath'] . "edurole/autoload.js";
		}

	}

	function deleteUsers($item) {
		$sql = 'UPDATE `basic-information` SET `Status` = "Locked" WHERE `ID` = "' . $item . '";';
		$run = $this->core->database->doInsertQuery($sql);

		$sql = 'DELETE FROM `access`  WHERE `ID` = "' . $item . '";';
		$run = $this->core->database->doInsertQuery($sql);

		$this->core->logEvent("Removed user $item", "4");

		$this->core->showAlert("The account has been deleted");
		
		$this->core->redirect("users", "manage", NULL);
	}
}

?>
