<?php
class users{

	public $core;
	
	function __construct($core){
		return $this->core = $core;
	}
	
	public function password($length, $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1') {
		$str = '';
		$count = strlen($charset);
		while ($length--) {
			$str .= $charset[mt_rand(0, $count - 1)];
		}
		return $str;
	}

	public function getStudent($id) {
		$sql = "SELECT * FROM `basic-information` WHERE `ID` = $id";

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $run->fetch_assoc();

		return $fetch;
	}

	/*public function addUser() {

		$password = $this->password(6);

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
		

		if(empty($id)){
			echo 'Please enter an NRC this field is required<a a href="javascript:" onclick="history.go(-1); return false">Go back</a>';
			return false;
		}

		$sql = "INSERT INTO `basic-information` (`FirstName`, `MiddleName`, `Surname`, `Sex`, `ID`, `GovernmentID`, `DateOfBirth`, `PlaceOfBirth`, `Nationality`, `StreetName`, `PostalCode`, `Town`, `Country`, `HomePhone`, `MobilePhone`, `Disability`, `DissabilityType`, `PrivateEmail`, `MaritalStatus`, `StudyType`, `Status`) VALUES ('$firstname', '$middlename', '$surname', '$sex', NULL, '$id', '$year-$month-$day', '$pob', '$nationality', '$streetname', '$postalcode', '$town', '$country', '$homephone', '$celphone', '$dissability', '$dissabilitytype', '$email', '$mstatus', '$studytype', 'Employed');";

		if ($this->core->database->doInsertQuery($sql)) {

			// Provide new user with access information

			$sql = "SELECT * FROM `basic-information` WHERE `GovernmentID` = '$id'";

			$dms = $this->core->database->doSelectQuery($sql);

			while ($fetch = $dms->fetch_row($dms)) {

				$passenc = sha1($password);
				$sql = "INSERT INTO `access` (`ID`, `Username`, `RoleID`, `Password`) VALUES ('$fetch[4]', '$username', '$roleid', '$passenc');";
				$this->core->database->doInsertQuery($sql);

				echo '<div class="successpopup">The requested user account has been created.<br/> WRITE THE FOLLOWING INFORMATION DOWN OR REMEMBER IT!</div>';

				echo '<div class="successpopup">Username:  <b>' . $username . '</b><br>Password:  <b>' . $password . '</b></div>';
			}
		} else {
			throwError('An error occurred with the information you have entered. Please return to the form and verify your information. <a a href="javascript:" onclick="history.go(-1); return false">Go back</a>');
		}
	}

		*/
		public function saveEdit($item, $access = TRUE) {

		$username = $this->core->cleanPost["username"];
		$roleid = $this->core->cleanPost["role"];
		$status = $this->core->cleanPost["status"];
		$nrc = $this->core->cleanPost["studentid"];
		$firstname = $this->core->cleanPost["firstname"];
		$middlename = $this->core->cleanPost["middlename"];
		$surname = $this->core->cleanPost["surname"];
		$sex = $this->core->cleanPost["sex"];

		$day = $this->core->cleanPost["day"];
		$month = $this->core->cleanPost["month"];
		$dobyear = $this->core->cleanPost["year"];
		$nationality = $this->core->cleanPost["nationality"];
		
		$streetname = $this->core->cleanPost["streetname"];
		$postalcode = $this->core->cleanPost["postalcode"];
		$town = $this->core->cleanPost["town"];
		$country = $this->core->cleanPost["country"];
		$homephone = $this->core->cleanPost["homephone"];
		$celphone = $this->core->cleanPost["celphone"];
		$dissability = $this->core->cleanPost["dissability"];
		$dissabilitytype = $this->core->cleanPost["dissabilitytype"];
		$email = $this->core->cleanPost["email"];
		$mstatus = $this->core->cleanPost["mstatus"];
		
		
		//Staff details
		$empno = $this->core->cleanPost["empno"];
		if($empno == "")
		{ $empno = 'NULL';}
		$basicPay = $this->core->cleanPost["basicpay"];
		$position = $this->core->cleanPost["position"];
		
		$engaged = $this->core->cleanPost["engaged"];
		$endcontract = $this->core->cleanPost["endcontract"];
		
		$tpin = $this->core->cleanPost["tpin"];
		$napsa = $this->core->cleanPost["napsa"];
		
		$bank = $this->core->cleanPost["bank"];
		$bankaccount = $this->core->cleanPost["account"]; 
		$bankBranch = $this->core->cleanPost["branch"];
		


		if($item == 'personal'  || $studentid == 'personal' || $this->core->role < 106){
			$studentid = $this->core->userID;
			$item = $studentid;
		}

		if(empty($nrc)){
			$this->core->throwError('Please enter an NRC this field is required <a a href="javascript:" onclick="history.go(-1); return false">Go back</a>');
			return false;
		}

		if($examcenter != '' ||$examcenter != ' ' ){
			$sql = "UPDATE `student-data-other` SET  `ExamCentre` =  '$examcenter' WHERE  `student-data-other`.`StudentID` = '$item';";
			$run = $this->core->database->doInsertQuery($sql);
		}

		$study = $this->core->cleanPost["study"];

		if($study != "00" && $study != ""){

			$sql = 'SELECT * FROM `student-study-link` WHERE StudentID = "'.$item.'"';
 			$run = $this->core->database->doSelectQuery($sql);

			if($run->num_rows == 0){
				$sql = 'INSERT INTO `student-study-link` (`ID`, `StudentID`, `StudyID`, `Status`) VALUES (NULL, "'.$item.'", "'.$study.'", "1")';
				$run = $this->core->database->doInsertQuery($sql);
			} else {
				while ($fetch = $run->fetch_array()){
					$sid = $fetch[0];
				}

				$sql = 'UPDATE `student-study-link` SET StudyID = "'.$study.'" WHERE ID = "'.$sid.'"';
				$run = $this->core->database->doInsertQuery($sql);
			}
		}

		if($dobyear == 'Year' || $day == 'Day' || $month == 'Month'){

		}  else {
			$dobq = "`DateOfBirth` = '$dobyear-$month-$day', ";
		}
		
		$sql = " INSERT INTO `basic-information` (`FirstName`, `MiddleName`, `Surname`, `Sex`, `ID`, `GovernmentID`, `DateOfBirth`, `PlaceOfBirth`, `Nationality`, `StreetName`, `PostalCode`, `Town`, `Country`, `HomePhone`, `MobilePhone`, `Disability`, `DissabilityType`, `PrivateEmail`, `MaritalStatus`, `StudyType`, `Status`) 
				VALUES ('$firstname', '$middlename', '$surname', '$sex', $item, '$nrc', '$dobyear-$month-$day', '$pob', '$nationality', '$streetname', '$postalcode', '$town', '$country', '$homephone', '$celphone', '$dissability', '$dissabilitytype', '$email', '$mstatus', 'Fulltime', '$status')
				ON DUPLICATE KEY 
				UPDATE `Surname` = '$surname', `FirstName` = '$firstname', `MiddleName` = '$middlename', `Sex` = '$sex', $dobq
				`GovernmentID` = '$nrc', `Nationality` = '$nationality ', `StreetName` = '$streetname ', `PostalCode` = '$postalcode', `Town` = '$town',
				`Country` = '$country', `HomePhone` = '$homephone', `MobilePhone` = '$celphone', `Disability` = '$dissability', `DissabilityType` = '$dissabilitytype', 
				`PrivateEmail` = '$email', `MaritalStatus` = '$mstatus', `Status` = '$status', `StudyType` = 'Fulltime' ";
		$run = $this->core->database->doInsertQuery($sql);

		$sqlx = "SELECT `ID` FROM `basic-information` WHERE `GovernmentID` = '$nrc'";
		$runx = $this->core->database->doSelectQuery($sqlx);

		while ($row = $runx->fetch_row()) {
			$id = $row[0];
		}
		
		
		if($access == TRUE){
			if($roleid != NULL && $roleid != 0){
				$sql = "INSERT INTO `access` (`ID`, `Username`, `RoleID`, `Password`) 
						VALUES ('$item', '$item', '$roleid', 'PASSWORD')
						ON DUPLICATE KEY UPDATE `RoleID` =  '$roleid', `Username` = '$username' ";
					
			} else {
				return true;
			}
			
			$run = $this->core->database->doInsertQuery($sql);
		}
		
		$staffSql = "INSERT INTO corelink.staff 
        (ID, EmployeeNo, JobTitle, SocialSecurity, EmploymentDate, EndDate, Grade, BasicPay, Leavedays, Gratuity, schoolID, Manager, TimeTableID, Bank, BankAccount, BankBranch, TaxID)
    VALUES 
        ('$id', $empno, '$position', '$napsa', '$engaged', '$endcontract', '$grade', '$basicPay', 0, 0, 0, 0, 0, '$bank', '$bankaccount', '$bankBranch', '$tpin')
    ON DUPLICATE KEY 
    UPDATE 
        `JobTitle` = '$position', 
        `SocialSecurity` = '$napsa', 
        `EmploymentDate` = '$engaged', 
        `EndDate` = '$endcontract', 
        `Grade` = '$grade', 
        `BasicPay` = '$basicPay', 
        `Leavedays` = 0, 
        `Gratuity` = 0, 
        `schoolID` = 0,
        `Manager` = 0,
        `TimeTableID` = 0,
        `Bank` = '$bank', 
        `BankAccount` = '$bankaccount', 
        `BankBranch` = '$bankBranch', 
        `TaxID` = '$tpin';";
		
		$this->core->database->doInsertQuery($staffSql);
		
		return true;
	}
}
	/* public function saveEdit($item, $access = TRUE) {

		$username = $this->core->cleanPost["username"];
		$firstname = $this->core->cleanPost["firstname"];
		$middlename = $this->core->cleanPost["middlename"];
		$surname = $this->core->cleanPost["surname"];
		$sex = $this->core->cleanPost["sex"];
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
		$nrc = $this->core->cleanPost["nationalid"];
		$studentid = $this->core->cleanPost["studentno"];
		$method = $this->core->cleanPost["method"];

		$study = $this->core->cleanPost["study"];
	
		$major = $this->core->cleanPost["major"];
		$minor = $this->core->cleanPost["minor"];

		$year = $this->core->cleanPost["year"];

		$examcenter = $this->core->cleanPost["examcenter"];
		
		
		//STAFF
		$position = $this->core->cleanPost["position"];
		$engaged = $this->core->cleanPost["engaged"];
		$tpin = $this->core->cleanPost["tpin"];
		$napsa = $this->core->cleanPost["napsa"];
		$bank = $this->core->cleanPost["bank"];
		$account = $this->core->cleanPost["account"];
		$branch = $this->core->cleanPost["branch"];
		$enddate = $this->core->cleanPost["endcontract"];
		
		if($position != "0" && $position != ""){
			
			$yeartoday = date("Y");
			$period = $this->core->getPeriod();
			
			//$sql = "UPDATE `staff` SET `JobTitle` = '$position', `TaxID` = '$tpin' , `SocialSecurity` = '$napsa',  `Bank` = '$bank',  `BankAccount` = '$account',  `BankBranch` = '$branch',  `EmploymentDate` = '$engaged',  `EndDate` = '$enddate'
			//		WHERE `ID` = '$item'";
			$sql = "REPLACE INTO `staff` (`ID`, `EmployeeNo`, `JobTitle`,`TaxID`,`SocialSecurity`, `Bank`,`BankAccount`,`BankBranch`,`EmploymentDate`,`EndDate`,`Grade`, `BasicPay`, `Leavedays`, `Gratuity`) 
				VALUES (NULL, '$empno', '$position', '$tpin','$napsa','$bank','$account', '$branch',  '$engaged', '$enddate', '', '0', '0', '0')";
		$run = $this->core->database->doInsertQuery($sql);
		
			$run = $this->core->database->doInsertQuery($sql);
		}
		
		



		

		if($item == 'personal'  || $studentid == 'personal' || $this->core->role < 100){
			$studentid = $this->core->userID;
			$item = $studentid;
		}



		if($year != "0"){
			$sql = "UPDATE `student-data-other` SET  `YearOfStudy` =  '$year' WHERE  `student-data-other`.`StudentID` = '$item';";
			$run = $this->core->database->doInsertQuery($sql);
		}
		

		$study = $this->core->cleanPost["study"];


		if($study != "00" && $study != ""){

			$sql = 'SELECT * FROM `student-study-link` WHERE StudentID = "'.$item.'"';
 			$run = $this->core->database->doSelectQuery($sql);

			if($run->num_rows == 0){
				$sql = 'INSERT INTO `student-study-link` (`ID`, `StudentID`, `StudyID`, `Status`) VALUES (NULL, "'.$item.'", "'.$study.'", "1")';
				$run = $this->core->database->doInsertQuery($sql);
			} else {
				while ($fetch = $run->fetch_array()){
					$sid = $fetch[0];
				}

				$year = date('Y');
				$sql = 'UPDATE `student-study-link` SET `StudyID` = "'.$study.'", `Year` = '.$year.' WHERE `StudentID` = "'.$item.'"';
				$run = $this->core->database->doInsertQuery($sql);
			}
		}

		if($method != ""){
			$smethod= ", `StudyType` = '$method'";
		}

		if($status != ""){
			$sstatus= ", `Status` = '$status'";
		}

		$sql = " INSERT INTO 
				`basic-information` (`FirstName`, `MiddleName`, `Surname`, `Sex`, `ID`, `GovernmentID`, `DateOfBirth`, `PlaceOfBirth`, `Nationality`, `StreetName`, `PostalCode`, `Town`, `Country`, `HomePhone`, `MobilePhone`, `Disability`, `DissabilityType`, `PrivateEmail`, `MaritalStatus`, `StudyType`, `Status`) 
				VALUES ('$firstname', '$middlename', '$surname', '$sex', '$item', '$nrc', '$year-$month-$day', '$pob', '$nationality', '$streetname', '$postalcode', '$town', '$country', '$homephone', '$celphone', '$dissability', '$dissabilitytype', '$email', '$mstatus', '$method', '$status')
				ON DUPLICATE KEY UPDATE `Surname` = '$surname', `FirstName` = '$firstname', `MiddleName` = '$middlename', `Sex` = '$sex', 
				`GovernmentID` = '$nrc', `Nationality` = '$nationality ', `StreetName` = '$streetname ', `PostalCode` = '$postalcode', `Town` = '$town',
				`Country` = '$country', `HomePhone` = '$homephone', `MobilePhone` = '$celphone', `Disability` = '$dissability', `DissabilityType` = '$dissabilitytype', 
				`PrivateEmail` = '$email', `MaritalStatus` = '$mstatus' $sstatus $smethod";


		$run = $this->core->database->doInsertQuery($sql);


		$sqlx = "SELECT `ID` FROM `basic-information` WHERE `GovernmentID` = '$nrc'";
		$runx = $this->core->database->doSelectQuery($sqlx);

		while ($row = $runx->fetch_row()) {
			$id = $row[0];
		}
		
		
		if($examcenter != "0" && $examcenter != ""){
			// $sql = "UPDATE `student-data-other` SET  `ExamCentre` = '$examcenter' WHERE  `student-data-other`.`StudentID` = '$item';";
			$yeartoday = date("Y");
			$period = $this->core->getPeriod();
			$sql = "INSERT INTO `student-data-other` (`ID`, `StudentID`, `YearOfStudy`, `ExamCentre`, `DateTime`, `PeriodID`) 
			VALUES (NULL, '$item', 1, '$examcenter',NOW(),$period)
			ON DUPLICATE KEY UPDATE `ExamCentre` =  '$examcenter'";
			$run = $this->core->database->doInsertQuery($sql);
		}




		if($access == TRUE){

			if($this->core->role == 1000){
				$username = $username;
			} else {
				return;
			}

			$sql = "INSERT INTO `access` (`ID`, `Username`, `RoleID`, `Password`) VALUES (NULL, '$username', '$roleid', 'PASSWORD')
				ON DUPLICATE KEY UPDATE `RoleID` =  '$roleid'";


			$run = $this->core->database->doInsertQuery($sql);
		}

		return true;
	}
}*/
?>