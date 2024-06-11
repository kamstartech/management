<?php
class cards{

	public $core;
	public $view;

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


	public function requestCards($item) {
		include $this->core->conf['conf']['formPath'] . "requestcards.form.php";
	}


	public function rejectCards($item){
	
		$sql = "UPDATE `basic-information` SET  `Status` =  'Rejected' WHERE  `basic-information`.`ID` = '$item';";
		$run = $this->core->database->doInsertQuery($sql);

		$this->core->audit(__CLASS__, $item, $item, "Rejected grower $item");
	

		$this->core->redirect("information", "show", $item);

	}


	function allCards(){
		$path = $this->core->conf['conf']['dataStorePath'] . 'identities/pictures';
		foreach (glob("$path/*") as $filename) {
			$fn = explode(".", basename($filename));
			$sid = $fn[0];
		
			$this->printCards($sid);

		}
	}


	function imageCards($item){

		$district = $this->core->cleanGet['district'];

		$sql = "SELECT * FROM `basic-information` 
			WHERE `District` = '$district' 
			AND `basic-information`.ID NOT IN (SELECT `UserID` FROM `accesscards`) 
			AND `Status` IN ('Registered', 'Approved') 
			ORDER BY `basic-information`.ID ASC ";
	
	
		$run = $this->core->database->doSelectQuery($sql);

		while ($fetch = $run->fetch_assoc()) {

			$item = $fetch['ID'];
			$nrc = $fetch['GovernmentID'];


			if (file_exists("datastore/identities/pictures/$uid.png_final.png")) {
				$profile =  '<img width="100%" src="'.$this->core->conf['conf']['path'].'/datastore/identities/pictures/' . $uid . '.png_final.png">';
			} else 	if (file_exists("datastore/identities/pictures/$uid.png")) {
				$profile =  '<img width="100%" src="'.$this->core->conf['conf']['path'].'/datastore/identities/pictures/' . $uid . '.png">';
			} else {
				return;
			}

			echo'<div style="width: 150px; height: 220px; text-align: center; overflow: hidden; border: 2px solid #000; float: left; margin-top: 15px; ">'.$profile.'<br><a href="' . $this->core->conf['conf']['path'] . '/information/show/'.$item.'"><b>'.$item.'</b></a></div>';
		}
	}

	function frontbatchCards($item){

		$district = $this->core->cleanGet['district'];
		$province = $this->core->cleanGet['province'];

		if($district == ''){
			$district = '%';
		}
		if($province == ''){
			$province = '%';
		}


		$sql = "SELECT * FROM `basic-information` 
			WHERE `District` LIKE '$district' 
			AND `Province` LIKE '$province'
			AND `basic-information`.ID NOT IN (SELECT `UserID` FROM `accesscards`) 
			AND `Status` IN ('Registered', 'Approved') 
			ORDER BY `basic-information`.ID ASC LIMIT 100";
	
	
		$run = $this->core->database->doSelectQuery($sql);

		while ($fetch = $run->fetch_assoc()) {

			$item = $fetch['ID'];

			$uid = $item;
			$this->frontCards($uid);
		}
	}


	function backbatchCards($item){

		$district = $this->core->cleanGet['district'];
		$province = $this->core->cleanGet['province'];

		if($district == ''){
			$district = '%';
		}
		if($province == ''){
			$province = '%';
		}


		$sql = "SELECT * FROM `basic-information` 
			WHERE `District` LIKE '$district' 
			AND `Province` LIKE '$province'
			AND `basic-information`.ID NOT IN (SELECT `UserID` FROM `accesscards`) 
			AND `Status` IN ('Registered', 'Approved') 
			ORDER BY `basic-information`.ID ASC LIMIT 100";
	
	
		$run = $this->core->database->doSelectQuery($sql);

		while ($fetch = $run->fetch_assoc()) {

			$item = $fetch['ID'];

			$uid = $item;
		
			$this->backCards($uid);
		}
	}


	function printCards($item){
		$uid = $item;
		$this->frontCards($uid);
		$this->backCards($uid);

	}

	function frontCards($item){ 
		$sql = "SELECT *, `basic-information`.`StudyType` as ST, `study`.Name, `basic-information`.Status
			FROM `basic-information`
			LEFT JOIN `student-study-link` ON `basic-information`.`ID` = `student-study-link`.`StudentID`
			LEFT JOIN `study` ON `student-study-link`.`StudyID` = `study`.`ID`
			LEFT JOIN `access` ON  `basic-information`.ID = `access`.Username
			LEFT JOIN `schools` ON  `schools`.ID = `study`.ParentID
			WHERE `basic-information`.`ID` = '$item'
			ORDER BY `student-study-link`.ID DESC
			LIMIT 1";

		$run = $this->core->database->doSelectQuery($sql);

		while ($row = $run->fetch_assoc()) {
			$results = TRUE;
			$firstname = ucfirst($row["FirstName"]);
			$middlename = ucfirst($row["MiddleName"]);
			$surname = ucfirst($row["Surname"]);

			$namelen = strlen($surname);

			$sex = $row["Sex"];
			$uid = $row["StudentID"];
			$status = $row["Status"];

			$nrc = $row["GovernmentID"];
			$dob = $row["DateOfBirth"];

			$program = $row["Name"];



			if($namelen > 12){
				$fsize = '13pt';
				$padding = '10pt';
			}else{
				$fsize = '13pt';
				$padding = '20pt'; 
			}


			if($mode == "Company"){
				$mode = "Commercial";
			}

			$sstatus = $row["Status"]; 




			$nrc = str_replace("-", "/", $nrc);
	

			if($middlename != ''){
				$mn = substr($middlename,0,1). '.';
			}

			if($mode == ""){
				$mode = $sstatus;
				if($mode == "Employed"){
					$mode = "Staff";
				}
			}

			$date = date('d-M-Y', strtotime('+1 years'));
			//$date = '31<sup>st</sup> Dec 2020';

			if($mode == "Fulltime"){ $mode = "Full-time"; } 

			if($mode == "Staff" || $sstatus == "Employed"){
				$cardtype = "APEX STAFF ID";
				$xid = $item;
				$uid = $item;
			} else{
				$cardtype = "STUDENT ID";
				$xid = $this->core->ApexID($uid);
			}
			
			if (file_exists("datastore/identities/pictures/$uid.png_final.png")) {
				$profile =  '<img width="150" style="margin-top: -20px; margin-left: -5px;"src="'.$this->core->conf['conf']['path'].'/datastore/identities/pictures/' . $uid . '.png_final.png">';
			} else 	if (file_exists("datastore/identities/pictures/$uid.png")) {
				$profile =  '<img  width="155" src="'.$this->core->conf['conf']['path'].'/datastore/identities/pictures/' . $uid . '.png">';
			} else 	if (file_exists("datastore/identities/pictures/$item.png")) {
				$profile =  '<img  width="155" src="'.$this->core->conf['conf']['path'].'/datastore/identities/pictures/' . $item . '.png">';

			} else {
				return;
			}
			

			$firstname = explode(' ',trim($firstname));
			$surname = explode(' ',trim($surname));
			$surname = $surname[0];
			$firstname = $firstname[0];

			echo'<div style="padding: 15px; height: 250px; break-inside: avoid; text-align:center; width: 330pt;">
				<div class="university" style="font-size: 19pt; margin-right:37px; margin-bottom: 5px;  padding: 2pt; text-align: center; font-weight:bold; color: #FFF; font-family: arial; background-color: #2e164e;"> 
					'.$cardtype.'
				</div>
				<div class="subtitle" style="text-align: center; margin-right:27px; ">
					<span style="font-size: 14pt; font-weight:bold; margin-right:37px; color:#2e164e; text-align: center; font-family: arial; padding: 2pt; padding-bottom: 0px;"> LUSAKA APEX MEDICAL UNIVERSITY </span>   
				</div>

				<div style="width: 140px; height: 140px; text-align: center; overflow: hidden; border: 2px solid #2e164e; float: left; margin-top: 15px;  ">'.$profile.'</div>
					<div style="width: 200pt; float: left; padding-left: 20pt;">
					  <div style="width: 100px; float:left; text-align: center;  font-family: arial; padding-top: 15px;"><img width="92" src="/templates/edurole/images/header.png"></div>

					 
					<div class="name" style="padding-top: '.$padding.'; padding-left: 10px;  width: 150px;  float: left; padding-bottom: 10pt; font-weight: bold; font-size: 15pt; text-align: left;  font-family: arial; text-align: left; color:#2e164e;">' . strtoupper($firstname) . ' ' . $mn . '<br> <span style="font-size: '. $fsize .'; color:#2e164e; font-weight:bold;  ">' . strtoupper($surname) . '</span> </div>
					<div style="padding-top: 10px; clear: both;">
						<div class="id" style=" font-family: arial; color:#2e164e; float:left;  font-size: 13pt; width: 50pt; text-align: left;"> <b>ID:</b>  </div> <div class="studentid" style="width: 140px; font-size: 13pt; color:#2e164e; font-family: arial; font-weight: bold; float:left; text-align: left;">'.strtoupper($xid).' </div><br>
						<div class="date" style=" font-family: arial;  color:#2e164e; float:left; font-size: 13pt; width: 50pt; text-align: left;"> <b>EXP:</b>  </div> <div class="studentid" style=" font-size: 13pt; color:#2e164e;  font-family: arial; font-weight: bold;  float:left; width: 140px; text-align: left;">'.$date.' </div>
						<div class="date" style=" font-family: arial;  color:#2e164e; float:left; font-size: 13pt; width: 50pt; text-align: left;"> <b>NRC:</b>  </div> <div class="studentid" style="font-size: 13pt; color:#2e164e; font-family: arial; font-weight: bold; width: 140px; float:left; text-align: left;">'.$nrc.' </div>
						<div class="date" style=" width: 400px; margin-left: -170; font-family: arial;  color:#2e164e; float:left; font-size: 13pt; text-align: center; border-top: 2px solid #2e164e; margin-top: 4px; padding-top: 2px; font-weight: bold; "> '.$program.' </div>
					</div>
				</div>
			</div>';

		}
	}



	function backCards($item){ 

		$sql = "SELECT * FROM `basic-information`
			LEFT JOIN `access` ON  `basic-information`.ID = `access`.Username
			WHERE `basic-information`.`ID` = '$item'";

		$run = $this->core->database->doSelectQuery($sql);

		while ($row = $run->fetch_row()) {
			$results = TRUE;
			$firstname = ucfirst($row[0]);
			$middlename = ucfirst($row[1]);
			$surname = ucfirst($row[2]);
			
			

			$sex = $row[3];
			$uid = $row[4];
			$nrc = $row[5];
			$dob = $row[6];




			$mode = $row[19];

			if($mode == "Company"){
				$mode = "Commercial";
			}

			$sstatus = $row[20]; 
  
			if (file_exists("datastore/identities/pictures/$uid.png_final.png")) {
				$profile =  '<img width="100%" src="'.$this->core->conf['conf']['path'].'/datastore/identities/pictures/' . $uid . '.png_final.png">';
			} else 	if (file_exists("datastore/identities/pictures/$uid.png")) {
				$profile =  '<img width="100%" src="'.$this->core->conf['conf']['path'].'/datastore/identities/pictures/' . $uid . '.png">';
			} else {
				return;
			}


			if($mode == "Staff" || $sstatus == "Employed"){
				$cardtype = "APEX STAFF ID";
				$uid = $item;
			}

			$nrc = str_replace("-", "/", $nrc);


			$date = date('d-M-Y', strtotime('+4 years'));
			if($mode == "Fulltime"){ $mode = "Full-time"; } 

			echo'<div style="page-break-before: always; color:#2e164e; text-align: center; width: 350pt;">
				<br><br>
				<div style="font-size: 15pt;  font-family: arial; font-weight: bold;  color:#2e164e; padding-bottom: 0px;">
					<b>THIS CARD IS PROPERTY OF<br> LUSAKA APEX MEDICAL UNIVERSITY <br>IF FOUND PLEASE CONTACT:
					<br><b>+260 211 843034 or registrar@apex.edu.zm</b>
				</div>
				<br><img src="/lib/barcode/src/test.php?id='.strtoupper($this->core->ApexID($uid)).'"> <br><div style="font-size: 15pt;"> '.strtoupper($this->core->ApexID($uid)).'</div>
			</div>';
		}
	}



	function staffCards($item){ 
		$sql = "SELECT * FROM `basic-information`, `access`, `roles` WHERE `basic-information`.`ID` = '$item' AND `basic-information`.ID = `access`.ID AND `roles`.ID = `access`.RoleID";
		$run = $this->core->database->doSelectQuery($sql);

		while ($row = $run->fetch_row()) {
			$results = TRUE;
			$firstname = strtoupper($row[0]);
			$middlename = strtoupper($row[1]);
			$surname = strtoupper($row[2]);

			$sex = $row[3];
			$uid = $row[4];
			$nrc = $row[5];
			$dob = $row[6];
			$role = $row[26];

			$mode = $row[19];
			$sstatus = $row[20]; 

			if (file_exists("datastore/identities/pictures/$uid.png_final.png")) {
				$profile =  '<img width="100%" src="'.$this->core->conf['conf']['path'].'/datastore/identities/pictures/' . $uid . '.png_final.png">';
			} else 	if (file_exists("datastore/identities/pictures/$uid.png")) {
				$profile =  '<img width="100%" src="'.$this->core->conf['conf']['path'].'/datastore/identities/pictures/' . $uid . '.png">';
			} else {
				return;
			}

 
			$date = date('d-M');

			echo'<div style="padding: 15px; height: 250px; break-inside: avoid; text-align:center; width: 100%;">';

			echo '<div class="university" style="font-size: 19pt; font-weight:bold; color: #FFF;  text-align: center; font-family: arial; background-color: #0879ca; padding: 2pt;"> APEX UNIVERSITY</div>
				<div class="subtitle" style="text-align: left;"><span style="font-size: 14pt; font-weight:bold; text-align: left; font-family: arial; padding: 2pt;"> EduCard ID  |</span>   <span style=" font-size: 14pt; font-weight:bold; font-family: arial;color: red;">OFFICIAL STAFF IDENTITY CARD</span></div>';


			echo'<div style="width: 105pt; border: 2px solid #000; float: left; margin-top: 15px; ">'.$profile.'</div>';


			echo'<div style="width: 200pt; float: left; padding-left: 20pt;">
			<div style="width: 100%; height: 100pt;">
				<div style="width: 100%; float: left; width: 100pt; text-align: center;  font-family: arial; padding-top: 0px;"><img width="120" src="/edurole/templates/edurole/images/header.png"></div>
				<div class="studentname" style=" float: left; vertical-align: middle; height: 80pt; padding-top: 0pt; padding-bottom: 10pt; font-size: 15pt; font-weight:bold;  font-family: arial; text-align:center;"><br>' . $firstname . ' <br> <span style="font-size: 19pt;">' . $surname . ' </span></div>
			</div>
			<div class="studentid" style=" font-family: arial;  float:left; width: 85pt;  text-align: left;"> STAFF ID:  </div> <div class="studentid" style=" font-family: arial; font-weight: bold; float:left;">  '.$uid.' </div>
			<div class="studentid" style=" font-family: arial;  float:left; width: 85pt;  text-align: left;"> VALID UNTIL:  </div> <div class="studentid" style=" font-family: arial; font-weight: bold;  float:left;"> '.$date.'-2020 </div>
			<div class="studentid" style=" font-family: arial;  float:left; width: 85pt;  text-align: left;"> ROLE:  </div> <div class="studentid" style=" font-family: arial; font-weight: bold;  float:left;"> '.$role.' </div>';

			echo'</div>';


		}
	}

	
	function addCards() {
		include $this->core->conf['conf']['formPath'] . "addaccommodation.form.php";
	}

	function deleteCards($item) {
		$sql = 'DELETE FROM `accommodation` WHERE `ID` = "' . $item . '"';
		$run = $this->core->database->doInsertQuery($sql);

		$this->listAccomodation();
		$this->core->showAlert("The accommodation has been deleted");
	}

	function replaceCards() {
		$uid = $this->core->userID;
		$phone = $this->core->cleanPost['phone'];

		$sql = "INSERT INTO `accesscardsreplace` (`ID`, `StudentID`, `Phone`, `Payment`) VALUES (NULL, '$uid', '$phone', '', NOW());";
		$run = $this->core->database->doInsertQuery($sql);

		echo '<div class="successpopup">'. $this->core->translate("Succesfully submitted your request for ID card replacement.") .'</div>
		<div class="warningpopup">Please pay exactly 100 kwacha through ZANACO Billmuster to '.$this->core->conf['conf']['organization'].'.</div>';
	}


	function replacementsCards($item) {
		$uid = $this->core->subitem;

		if($item == "replaced"){
			$sql = "UPDATE `accesscardsreplace` SET `Payment` = '1' WHERE `StudentID` = '$uid';";
			$run = $this->core->database->doInsertQuery($sql);

			echo'<div class="successpopup">This card is marked as replaced</div>';
			return;
		} else if($item == "delete"){
			$sql = "DELETE FROM `accesscardsreplace` WHERE `StudentID` = '$uid';";
			$run = $this->core->database->doInsertQuery($sql);

			echo'<div class="successpopup">This request has been deleted</div>';
			return;
		}

		$sql = "SELECT DISTINCT `StudentID`, `DateTime`, `FirstName`, `Surname` 
			FROM `accesscardsreplace`, `basic-information`
			WHERE `accesscardsreplace`.StudentID = `basic-information`.ID
			AND `Payment` != '1'";

		$run = $this->core->database->doSelectQuery($sql);

		$results = FALSE;

		echo'<table id="results" class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th bgcolor="#EEEEEE" width="30px"></th>
					<th bgcolor="#EEEEEE"><b>StudentID</b></th>
					<th bgcolor="#EEEEEE"><b>Student Name</b></th>
					<th bgcolor="#EEEEEE"><b>Date Requested</b></th>
					<th bgcolor="#EEEEEE"><b>Action</b></th>
				</tr>
			</thead>
			<tbody>';

		while ($row = $run->fetch_assoc()) {
			$results = TRUE;

			$date= $row["DateTime"];
			$name = $row["FirstName"] . " " . $row["Surname"];
			$phone = $row["Phone"];
			$account = $row["StudentID"];

			echo'<tr>
				<td><img src="/edurole/templates/edurole/images/user.png"></td>
				<td> '.$account.'</td>
				<td> <a href="#">'.$name.'</a></td>
				<td> '.$date.'</td>
				<td> <a href="'.$this->core->conf['conf']['path'].'/cards/replacements/delete/'.$account.'">Delete</a> |
						 <a href="'.$this->core->conf['conf']['path'].'/cards/replacements/replaced/'.$account.'">Replaced</a></td>
				</tr>';

			$results = TRUE;
		}

		echo'</table>';
	}



	public function studentsCards($item) {
		$this->searchCards($item);
	}


	public function tokenCards($item){
		include $this->core->conf['conf']['formPath'] . "searchcard.form.php";


		if(!empty($this->core->cleanGet['userid'])){
			$userid = $this->core->cleanGet['userid'];
			$card = $this->core->cleanGet['card'];


			$sql = "INSERT INTO `accesscards` (`ID`, `UserID`, `CardID`, `Debit`, `DebitHash`, `CardNumber`, `CardCreated`) 
						   VALUES (NULL, '$userid', '$card', 0, '', '1', CURDATE());";
			$run = $this->core->database->doInsertQuery($sql);

			$this->core->throwSuccess("Card assigned.");
		}


		if(!empty($this->core->cleanGet['card'])){
			$card = $this->core->cleanGet['card'];

			if(!empty($this->core->cleanGet['token'])){
				$token = $this->core->cleanGet['token'];
				$this->addtokenCards($card, $token, "Account deposit");
			}

			include $this->core->conf['conf']['formPath'] . "addtokencard.form.php";

			echo'<div style="border: 1px solid #ccc; background-color: #fefefe; margin-top: 20px; padding: 10px; height: 270px; width: 740px">';
			$exists = $this->showCards(NULL, $card);

			if($exists == FALSE){
				include $this->core->conf['conf']['formPath'] . "addcard.form.php";
			}

			echo '</div>';
		}

	}



	public function confirmCards($item){
		include $this->core->conf['conf']['formPath'] . "searchcard.form.php";


		if(!empty($this->core->cleanGet['card'])){
			$userid =  $this->core->cleanGet['card'];
			$card = $this->core->cleanGet['card'];

			if(!empty($this->core->cleanGet['token'])){
				$token = $this->core->cleanGet['token'];
				$this->addtokenCards($card, $token, "Account deposit");
			}

			// include $this->core->conf['conf']['formPath'] . "addtokencard.form.php";

			echo'<div style="border: 1px solid #ccc; background-color: #fefefe; margin-top: 20px; padding: 10px; height: 270px; width: 740px">';
			$exists = $this->showCards(NULL, $card);

			if($exists == FALSE){
				$sql = "INSERT INTO `accesscards` (`ID`, `UserID`, `CardID`, `Debit`, `DebitHash`, `CardNumber`, `CardCreated`) VALUES (NULL, '$userid', '$card', '0', '0', '1', CURDATE());";
				$run = $this->core->database->doInsertQuery($sql);

				$this->core->throwSuccess("Card printed.");

			} else {
				
				echo '<br><div style="clear:both; width: 200px; text-align: center; color: #FFF; padding: 5px; background-color: red;"><a href="" style="color: #FFF; font-weight: bold; ">DELETE CARD</a></div><br>';

			}

			echo '</div>';
		}

	}

	private function addtokenCards($card, $token, $desc){
		$sql = "UPDATE `accesscards` SET  `Debit` =  Debit + $token WHERE  `CardID` = '$card';";
		$run = $this->core->database->doInsertQuery($sql);

		$userid = $this->core->userID;
		$sql = "INSERT INTO `tokens` (`ID`, `TokenAmount`, `Mutation`, `CardID`, `MutatorID`, `DateTime`, `Hash`, `Description`) VALUES (NULL, '$token', 'ADD', '$card', '$userid', NOW(), '', '$desc');";
		$run = $this->core->database->doInsertQuery($sql);
	}


	private function subtokenCards($card, $token, $desc){
		$sql = "UPDATE `accesscards` SET  `Debit` =  Debit - $token WHERE  `CardID` = '$card';";
		$run = $this->core->database->doInsertQuery($sql);

		$userid = $this->core->userID;
		$sql = "INSERT INTO `tokens` (`ID`, `TokenAmount`, `Mutation`, `CardID`, `MutatorID`, `DateTime`, `Hash`, `Description`) VALUES (NULL, '$token', 'SUB', '$card', '$userid', NOW(), '', '$desc');";
		$run = $this->core->database->doInsertQuery($sql);
	}

	public function submealCards($item){

		echo '<div style="text-align: center; border: 1px solid #ccc; background-color: #fefefe; font-size: 30px;  margin-top: 20px;"> SWIPE CARD TO PAY </div>';

		include $this->core->conf['conf']['formPath'] . "searchcardhidden.form.php";

		if(!empty($this->core->cleanGet['card'])){
			$card = $this->core->cleanGet['card'];

			echo '<div style="text-align: center; font-size: 25px; color: #2FB70D; margin-top: 20px; border: 1px solid #ccc; background-color: #fefefe; font-weight: bold; padding: 20px;">
			One meal - 2 tokens paid
			</div>';
			
			echo'<div style="border: 1px solid #ccc; background-color: #fefefe; margin-top: 20px; padding: 10px; height: 270px;">';
			$this->subtokenCards($card, 2, "Payment for meal");
			$this->showCards(NULL, $card);

			echo '</div>';

		}
	}

	public function saveCards($item){
		$this->core->throwSuccess($this->core->translate("The user account has been updated"));
		$this->editCards($item);
	}

	public function personalCards($item){
		$userid = $this->core->userID;

		$sql = "SELECT * FROM  `basic-information` as bi, `access` as ac WHERE ac.`ID` = '" . $userid . "' AND ac.`ID` = bi.`ID`";

		$this->showInfoProfile($sql, TRUE);
	}

	public function showCards($item, $card) {
		if(empty($item)){
			$item = $this->core->userID;
		}

		if(isset($card)){
			$sql = "SELECT * FROM `accesscards`, `basic-information` WHERE `CardID` LIKE '" . $card . "' AND `UserID` = `basic-information`.ID";
		}else{
			$sql = "SELECT * FROM `accesscards`, `basic-information` WHERE `UserID` LIKE '" . $item . "' AND `UserID` = `basic-information`.ID";
		}

		$run = $this->core->database->doSelectQuery($sql);
		$results = FALSE;

		while ($row = $run->fetch_row()) {
			$results = TRUE;
			$ID = $row[0];
			$UserID = $row[1];
			$CardID = $row[2];
			$Debit = $row[3];
			$DebitHash = $row[4];
			$CardNumber = $row[5];
			$CardCreated = $row[6];

			$fname = $row[7];
			$mname = $row[8];
			$lname = $row[9];
			$uid = $row[11];


			echo '<div class="profilepic">';

			if (file_exists("datastore/identities/pictures/$uid.png")) {
				echo '<img width="100%" src="'.$this->core->conf['conf']['path'].'/datastore/identities/pictures/' . $uid . '.png">';
			} else {
				echo '<img width="100%" src="'.$this->core->conf['conf']['path'].'/templates/default/images/noprofile.png">';
			}

			echo'</div>';

			echo '<div style="float: left;">';
			echo'<span class="label">Student</span> <span style="font-size: 24px;">' . $fname . ' '. $mname.' '. $lname.'</span><br/>';
			echo'<span class="label"><b>Card Debit</b></span> <span style="font-size: 20px;">' . $Debit . ' Kwacha</span><br/>';
			echo'<span class="label">Card ID</span> ' . $CardID . '<br/>';

			echo'</div>';

			echo '<div class="toolbar" style="float:left; width: 70%">'.
			'<a href="' . $this->core->conf['conf']['path'] . '/cards/transactions/'.$card.'">Show Transactions</a>'.
			'</div>';


			return true;
		}

		if($results == false){
			$this->core->throwSuccess("This user currently does not have an EduCard.");

			return false;
		}

	}


	public function userCards($item) {
		$sql = "SELECT * FROM `accesscards` WHERE `CardID` LIKE '" . $item . "'";

		$run = $this->core->database->doSelectQuery($sql);

		while ($row = $run->fetch_row()) {
			$results == TRUE;

			$ID = $row[0];
			$UserID = $row[1];
			$CardID = $row[2];

			include $this->core->conf['conf']['viewPath'] . "information.view.php";
			$information = new information($this->core);

			$sql = "SELECT * FROM `basic-information` WHERE `ID` LIKE '" . $UserID . "'";
			$information->showInfoProfile($sql, FALSE);

		}
	}



	public function transactionsCards($card) {

		if(empty($item)){
			$item = $this->core->userID;

			$sql = "SELECT * FROM `accesscards` WHERE `UserID` LIKE '" . $item . "'";

			$run = $this->core->database->doSelectQuery($sql);

			while ($row = $run->fetch_row()) {

				$card = $row[2];
			}

		}

		$sql = "SELECT * FROM tokens WHERE CardID = '$card'";

		$run = $this->core->database->doSelectQuery($sql);


		if(!isset($this->core->cleanGet['offset'])){

			echo'<table id="results" class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th bgcolor="#EEEEEE" width="30px"></th>
					<th bgcolor="#EEEEEE"><b>Date/Time</b></th>
					<th bgcolor="#EEEEEE"><b>Description</b></th>
					<th bgcolor="#EEEEEE"><b>Amount</b></th>
					<th bgcolor="#EEEEEE"><b>Account</b></th>
				</tr>
			</thead>
			<tbody>';
		}



		while ($row = $run->fetch_row()) {
			$results == TRUE;


			$date= $row[5];
			$description= $row[7];
			$amount = $row[1];
			$account = $row[4];

			echo'<tr>
				<td><img src="/edurole/templates/edurole/images/user.png"></td>
				<td> '.$date.'</td>
				<td> '.$description.'</td>
				<td> '.$amount.'</td>
				<td> '.$account.'</td>
				</tr>';
			$results = TRUE;


		}

		if($this->core->pager == FALSE){
			if ($results != TRUE) {
				$this->core->throwError('Your search did not return any results');
			}
		}


		if(!isset($this->core->cleanGet['offset'])){
			echo'</tbody>
			</table>';
		}


	}



}
?>
