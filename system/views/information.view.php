<?php
class information {

	public $core;
	public $view;
	public $limit;
	public $offset;
	public $pager = FALSE;

	public function configView() {
		$this->view->header = TRUE;
		$this->view->footer = TRUE;
		$this->view->menu = TRUE;
		$this->view->javascript = array('jquery.form-repeater');
		$this->view->css = array();

		return $this->view;
	}

	private function viewMenu(){
		echo '<div class="toolbar">'.
		'<a href="' . $this->core->conf['conf']['path'] . '/sms/manage">Manage SMS</a>'.
		'<a href="' . $this->core->conf['conf']['path'] . '/sms/new">Send SMS</a>'.
		'<a href="' . $this->core->conf['conf']['path'] . '/sms/balance">Balance</a>'.
		'</div>';
	}

	public function importInformation($item){
		$sql = "SELECT * FROM `basic-information`";
		$runx = $this->core->database->doSelectQuery($sql);
		while ($fetch = $runx->fetch_assoc()) {
			$uid = $fetch['ID'];

			echo '<b>IMPORTING COURSES FOR STUDENT: '.$uid.'</b><br>';

			$this->courseInformation($uid);
		}
	}
	
	
	public function clientInformation(){

			$uid = $this->core->userID;
			$url = "http://41.63.7.220:8080/client.php";

			if (!$content = file_get_contents($url)) {
 			     $error = error_get_last();
 			     echo "HTTP request failed. Error was: " . $error['message'];
			}	

			echo '<div class="successpopup">USERS PUSHED TO SAGE</div>';
			
			echo $content;
			
	}


	public function buildView($core) {
		$this->core = $core;

		$this->limit = 5000;
		$this->offset = 0;

		include $this->core->conf['conf']['classPath'] . "users.inc.php";


		if(empty($this->core->item)){
			if(isset($this->core->cleanGet['uid'])){
				$this->core->item = trim($this->core->cleanGet['uid']);
			}
		}
		if(isset($this->core->cleanGet['offset'])){
			$this->offset = $this->core->cleanGet['offset'];
		}
		if(isset($this->core->cleanGet['limit'])){
			$this->limit = $this->core->cleanGet['limit'];
			$this->pager = TRUE;
		}
	} 

	public function studentsInformation($item) {
		$this->searchInformation($item);
	}

	public function saveInformation($item){
		$users = new users($this->core);
		$users->saveEdit($this->core->item, TRUE);

		echo '<div class="toolbar"><a href="' . $this->core->conf['conf']['path'] . '/information/show/'.$item.'">RETURN TO PROFILE</a></div>'.
		$this->core->throwSuccess($this->core->translate("The user account has been updated"));

		$this->editInformation($item);
	}
	
	/*public function saveInformation($item){
		$users = new users($this->core);
		$users->saveEdit($this->core->item, TRUE);

		echo '<div class="toolbar"><a href="' . $this->core->conf['conf']['path'] . '/information/show/'.$item.'">RETURN TO PROFILE</a></div>'.
		$this->core->throwSuccess($this->core->translate("The user account has been updated"));



		$this->editInformation($item);
	}*/

	public function personalInformation($item){
		$userid = $this->core->userID;

		$sql = "SELECT * FROM  `basic-information` as bi, `access` as ac 
		WHERE ac.`Username` = '" . $userid . "' 
		AND ac.`Username` = bi.`ID`
		OR ac.`ID` = '" . $userid . "' 
		AND ac.`ID` = bi.`ID`";

		$this->showInfoProfile($sql, TRUE);
	}


	public function pictureInformation($item) {

		if($this->core->role < 100 && $item != $this->core->userID){
			$uid = 'xxxx';
		}
		
		$path = getcwd();
		

		$uid = $item;
		if (file_exists("datastore/identities/pictures/$uid.jpg")) {
			$filename = $path.'/datastore/identities/pictures/' . $uid . '.jpg';
		} else if (file_exists("datastore/identities/pictures/$uid.JPG")) {
			$filename = $path.'/datastore/identities/pictures/' . $uid . '.JPG';
		} else if (file_exists("datastore/identities/pictures/$uid.jpeg")) {
			$filename = $path.'/datastore/identities/pictures/' . $uid . '.jpeg';
		} else 	if (file_exists("datastore/identities/pictures/$uid.png")) {
			$filename = $path.'/datastore/identities/pictures/' . $uid . '.png';
		} else {
			$filename = $path.'/templates/default/images/noprofile.png';
		}
		


		$mime = mime_content_type($filename);

    		header("Content-type: $mime");
    		header('Content-Disposition: attachment; filename='.urlencode(basename($filename)));
    		header('Content-Length: ' . filesize($filename));

		$content = readfile($filename);

		exit;
	}



	public function searchInformation($item) {
		$listType = "list";

		if(isset($this->core->cleanGet['studies'])){
			$studies = $this->core->cleanGet['studies'];
		}
		if(isset($this->core->cleanGet['programmes'])){
			$programmes = $this->core->cleanGet['programmes'];
		}
		if(isset($this->core->cleanGet['search'])){
			$search = $this->core->cleanGet['search'];
		}
		if(isset($this->core->cleanGet['q'])){
			$q = $this->core->cleanGet['q'];
		}
		if(isset($this->core->cleanGet['active'])){
			$active = $this->core->cleanGet['active'];
		}


		if(isset($this->core->cleanGet['card'])){
			$card = $this->core->cleanGet['card'];
		}

		if(isset($this->core->cleanGet['group'])){
			$group = $this->core->cleanGet['group'];
		}

		if(isset($this->core->cleanGet['studentfirstname'])){
			$firstName = $this->core->cleanGet['studentfirstname'];
		}
		if(isset($this->core->cleanGet['studentlastname'])){
			$lastName = $this->core->cleanGet['studentlastname'];
		}
		if(isset($this->core->cleanGet['listtype'])){
			$listType = $this->core->cleanGet['listtype'];
		}
		if(isset($this->core->cleanGet['year'])){
			$year = $this->core->cleanGet['year'];
		}
		if(isset($this->core->cleanGet['mode'])){
			$mode = $this->core->cleanGet['mode'];
		}
		if(isset($this->core->cleanGet['examcenter'])){
			$center = $this->core->cleanGet['examcenter'];
		}
		if(isset($this->core->cleanGet['role'])){
			$role = $this->core->cleanGet['role'];
		}
		if(isset($this->core->cleanGet['period'])){
			$period = $this->core->cleanGet['period'];
		}
		if(isset($this->core->cleanGet['status'])){
			$status = $this->core->cleanGet['status'];
		}
		if(isset($this->core->cleanGet['nationality'])){
			$nationality = $this->core->cleanGet['nationality'];
		}


		if (isset($lastName) || isset($firstName)) {
			$this->bynameInformation($firstName, $lastName, $listType);
		}elseif (isset($center)){
			$this->bycenterInformation($center);
		} else if ($this->core->action == "search" && isset($q) && $search == "study" || $this->core->action == "students" && isset($q) && $search == "study") {
			$this->bystudyInformation($q, $listType);
		} else if ($this->core->action == "search" && isset($q) && $search == "programme" || $this->core->action == "students" && isset($q) && $search == "programme") {
			$this->byprogramInformation($q, $listType, $year, $mode);
		} else if ($this->core->action == "search" && isset($q) && $search == "course" || $this->core->action == "students" && isset($q) && $search == "course") {
			$this->bycourseInformation($q, $listType, $mode, $period);
		} else if ($this->core->action == "search" && isset($role)) {
			$this->showroleInformation($role);
		} else if ($this->core->action == "search" && isset($status)) {
			$this->bystatusInformation($status);
		} else if ($this->core->action == "search" && $search == "nationality") {
			$this->bynationalityInformation($nationality);
		} else if ($this->core->action == "search" && isset($card)) {
			$this->showcardInformation($card);
		} else if ($this->core->action == "search" && isset($year) && isset($mode)) {
			$this->byintakeInformation($year, $mode, $group);
		} else if (isset($active) && isset($mode)) {
			$this->byActive($mode);
		} else if ($this->core->action == "search" && isset($item)) {
			$this->showInformation($item);
		}else{
			include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";

			$select = new optionBuilder($this->core);

			$study = $select->showStudies(null);
			$program = $select->showPrograms(null, null, null);
			$courses = $select->showCourses(null);
			$centres = $select->showCentres(null);
			$roles   = $select->showRoles(null);
			$periods   = $select->showPeriods(null);

			if ($this->core->role >= 100) {
				include $this->core->conf['conf']['formPath'] . "searchform.form.php";
			} else {
				$this->core->throwError($this->core->translate("You do not have the authority to do system wide searches"));
			}
		}
	}

	public function showcardInformation($item) {
		if(empty($item)){
			$this->searchInformation();
		} else {
			$sql = "SELECT * FROM `basic-information` as `bi`, `accesscards` WHERE `CardID` LIKE '" . $item . "' AND UserID = `bi`.ID";
			$this->showInfoProfile($sql, FALSE);
		}
	}
	

	public function bystatusInformation($item) {
		if(empty($item)){
			$this->searchInformation();
		} else {
			$sql = "SELECT `basic-information`.* FROM `basic-information`, `student-study-link` 
			WHERE `basic-information`.ID = `student-study-link`.StudentID 
			AND `basic-information`.`Status` LIKE '" . $item . "'
			ORDER BY  `student-study-link`.StudyID";
			$this->showInfoList($sql, FALSE);
		}
	}

	public function unreportedInformation($item) {
		$period = $this->core->cleanGet['period'];
		$delivery = $this->core->cleanGet['delivery'];

		if(empty($item)){
			$this->searchInformation();
		} else {
		
			$sql = "SELECT * FROM `basic-information` WHERE `ID` LIKE  '%' AND `StudyType` = '$delivery' AND `Status` IN ('Requesting', 'Approved') AND `basic-information`.ID NOT IN (SELECT DISTINCT `StudentID` FROM `reporting` WHERE `periodID` = '$period')";
			$this->showInfoList($sql);
		}
	}

	public function showroleInformation($item) {
		if(empty($item)){
			$this->searchInformation();
		} else {
		
			$sql = "SELECT * FROM `basic-information` as `bi`, `access`, `roles` WHERE `roles`.`Username` = '" . $item . "' AND `access`.RoleID = `roles`.ID AND `access`.ID = `bi`.ID";
			$this->showInfoList($sql);
		}
	}


	public function showInformation($item) {
		if(empty($item)){
			$this->searchInformation();
		} else {
			$sql = "SELECT * FROM `basic-information` WHERE `ID` LIKE '" . $item . "'";
			$this->showInfoProfile($sql, FALSE);
		}
	}

	
	public function bynationalityInformation($item, $listType = "list") {
		$year = $this->core->cleanGet['year'];
		$period = $this->core->cleanGet['period'];
		
		if(empty($item)){
			$this->searchInformation();
		} else {
			if($item == 'ALL'){
				$country = "AND `basic-information`.Nationality != 'Zambian' ";
			} else {
				$country = "AND `basic-information`.Nationality = '$item' ";
			}
			
			if($period != ''){
				$filter  = " AND `StudentID` IN (SELECT `StudentID` FROM `course-electives` WHERE `PeriodID` = '$period')";
			} 
			
			if($year == 'all'){
				$year = '%';
			}
			
			$sql = "SELECT * FROM  `student-study-link`, `basic-information`
					WHERE `basic-information`.ID = `student-study-link`.StudentID
					$country
					AND `basic-information`.ID LIKE '$year%' 
					$filter
					GROUP BY `basic-information`.`ID`
					ORDER BY `StudyID`";
					

			if ($listType == "profiles") {
				$this->showInfoProfile($sql, FALSE);
			} elseif ($listType == "list") {
				$this->showInfoList($sql);
			}
		}
	}
	

	public function bycenterInformation($item, $listType = "list") {
		if(empty($item)){
			$this->searchInformation();
		} else {
			$year = $this->core->cleanGet['year'];
			$stype = $this->core->cleanGet['mode'];

			$sql = "SELECT * FROM `basic-information`, `student-data-other` WHERE `basic-information`.`ID` = `student-data-other`.StudentID AND `student-data-other`.ExamCentre = '$item' AND `student-data-other`.YearOfStudy = '$year' AND `basic-information`.StudyType = '$stype' GROUP BY `basic-information`.`ID`";

			if ($listType == "profiles") {
				$this->showInfoProfile($sql, FALSE);
			} elseif ($listType == "list") {
				$this->showInfoList($sql);
			}
		}
	}


	private function byActive($mode) {
		if($mode == "ALL"){
			$mode = '%';
		}
			
		$sql = "SELECT DISTINCT * FROM `basic-information`, `access` 
			WHERE `basic-information`.ID = `access`.Username 
			AND `StudyType` LIKE '$mode' AND `access`.RoleID <= 10
			ORDER BY `basic-information`.ID ASC  ";

		$this->showInfoList($sql);
	}


	private function bynameInformation($firstName, $lastName, $listType) {
		if (empty($firstName)) {
			$firstName = "%";
		}
		if (empty($lastName)) {
			$lastName = "%";
		}

		$sql = "SELECT * FROM `basic-information` WHERE `Surname` LIKE '" . $lastName . "' AND `Firstname` LIKE '" . $firstName . "'";

		if ($listType == "profiles") {
			$this->showInfoProfile($sql, FALSE);
		} elseif ($listType == "list") {
			$this->showInfoList($sql);
		}
	}

	private function byintakeInformation($year, $mode, $group) {

		if($mode == "Masters"){
			$master = TRUE;
			$mode = "Distance";
			$year = "1". $year;
		}

		if (is_numeric($year)) {
			$sql = "SELECT * FROM `basic-information` WHERE `ID` LIKE '" . $year . "%' AND `StudyType` LIKE '" . $mode . "'";
		}else if($master == TRUE){
			$sql = "SELECT * FROM `basic-information` WHERE `ID` LIKE '120%' AND `StudyType` LIKE '" . $mode . "'";
		} else {
			$sql = "SELECT * FROM `basic-information` WHERE `StudyType` LIKE '" . $mode . "'";
		}



		if(!empty($group)){
			$sql = "SELECT * FROM `basic-information`, `groups` 
				WHERE `basic-information`.`ID` LIKE '" . $year . "%' 
				AND `StudyType` LIKE '" . $mode . "' 
				AND `basic-information`.`ID` = `groups`.`StudentID` 
				AND `Group` = $group";
		}


		$this->showInfoList($sql);
	}

	private function bystudyInformation($study, $listType) {
		if ($study != "" && is_numeric($study)) {
			$sql = "SELECT * FROM `basic-information`, `student-study-link` WHERE `student-study-link`.StudentID = `basic-information`.ID AND StudyID = '" . $study . "'";
		}

		if ($listType == "profiles") {
			$this->showInfoProfile($sql, FALSE);
		} elseif ($listType == "list") {
			
			$this->showInfoList($sql);
		}
	}

	private function byprogramInformation($program, $listType, $year, $mode) {
		if ($program != "" && is_numeric($program)) {

			$sql ="SELECT DISTINCT * FROM `basic-information`, `student-study-link`, `study` 
			WHERE `basic-information`.`ID` = `student-study-link`.`StudentID`
			AND `study`.`ID` = `student-study-link`.StudyID
			AND `basic-information`.`ID` LIKE '" . $year . "%'
			AND `basic-information`.`StudyType` = '" . $mode . "'
			AND `study`.ID = '$program'";

		}

		if ($listType == "profiles") {
			$this->showInfoProfile($sql, FALSE);
		} elseif ($listType == "list") {
			$this->showInfoList($sql);
		}
	}


	private function bycourseInformation($course, $listType, $studytype,$period){

		$year = $this->core->cleanGet['year'];
		$semester = $this->core->cleanGet['semester'];
		
		if ($course != "" && is_numeric($course)) {

			if(empty($studytype)){ $studytype = "%"; }

			$sql = "SELECT count(DISTINCT `course-electives`.CourseID) AS Courses,`basic-information`.ID,
					`basic-information`.ID, `basic-information`.FirstName,`basic-information`.MiddleName,`basic-information`.Surname,
					`basic-information`.Sex,`basic-information`.MobilePhone,`basic-information`.PrivateEmail,`basic-information`.`Status`,`basic-information`.StudyType
					FROM `basic-information`, `course-electives` ,`student-study-link` ,`study`
					WHERE `basic-information`.ID = `course-electives`.StudentID 
					AND `course-electives`.CourseID = '$course' 
					AND `course-electives`.Year='$year'
					AND `course-electives`.Semester='$semester'
					AND `course-electives`.Approved IN (0,1)
					AND `basic-information`.`StudyType` LIKE '$studytype'
					AND `student-study-link`.StudentID=`basic-information`.ID
					AND `study`.ID=`student-study-link`.StudyID
					GROUP BY `course-electives`.`StudentID` 
					ORDER BY `study`.ParentID,`student-study-link`.StudyID,`basic-information`.Surname,`basic-information`.Firstname
					";

			if(empty($_GET['offset'])){
				/* adding period
					
				*/
				$sqlp = "SELECT * FROM `periods`
					WHERE `periods`.ID = '$period'";
				$runp = $this->core->database->doSelectQuery($sqlp);
				$rowp = $runp->fetch_assoc();
				
				///end
				$sqlx = "SELECT * FROM `courses`
					WHERE `courses`.ID = '$course'";
	
				$runx = $this->core->database->doSelectQuery($sqlx); 
	
				while ($row = $runx->fetch_assoc()) {
					echo '<div class="heading"><h2>'.$row['Name'].' - '.$row['CourseDescription'].' (Year '.$year.' Term '.$semester.' )</h2>  </div>';
				}
			}

			$this->showInfoList($sql);
		} else {
			$this->core->throwError($this->core->translate("You have not selected a course"));
		}
	
	
	}

	private function showInfoProfile($sql, $personal) {
		$other = '';

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
			$pob = $row[7];
			$nationality = $row[8];

			$streetname = $row[9];
			$postalcode = $row[10];
			$town = $row[11];
			$country = $row[12];
			$homephone = $row[13];
			$mobilephone = $row[14];

			$disability = $row[15];
			$disabilitytype = $row[16];
			$email = $row[17];
			$maritalstatus = $row[18];
			$mode = $row[19];
			$sstatus = $row[20];


			$sqlx = "SELECT * FROM `access` WHERE `Username` = '$uid'";
			$runx = $this->core->database->doSelectQuery($sqlx);

			while ($rowx = $runx->fetch_assoc()) {
				$role = $rowx['RoleID'];
			}


			if( $sstatus=="Deregistered"){ 
				$style = "background-color: #000;"; 
				$activate = "Deregistered account";
				$links =  $this->core->conf['conf']['path'] . '/admission/activate/'.$uid;
			} else if( $sstatus=="Graduated"){ 
				$style = "background-color: #62ab3b;";
				$activate = "GRADUATE ACCOUNT";
				$links =  $this->core->conf['conf']['path'] . '/admission/activate/'.$uid;
			} else if( $sstatus=="Enrolled"){ 
				$style = "background-color: #6297C3;";
				$activate = "REGISTERED ACCOUNT";
				$links =  $this->core->conf['conf']['path'] . '/admission/deactivate/'.$uid;
			} else if( $sstatus=="Requesting"){ 
				$style = "background-color: #6297C3;";
				$activate = "ACTIVATE ACCOUNT";
				$links =  $this->core->conf['conf']['path'] . '/admission/activate/'.$uid;
			} else if( $sstatus=="Suspended"){ 
				$style = "background-color: #c362bd;";
				$activate = "ACTIVATE ACCOUNT";
				$links =  $this->core->conf['conf']['path'] . '/admission/activate/'.$uid;
			} else if( $sstatus=="Approved" || $sstatus=="New"){ 
				$style = "background-color: #4b9625;";
				$activate = "ACTIVE UNILUS STUDENT";
				$links =  $this->core->conf['conf']['path'] . '/admission/deactivate/'.$uid;
			}

			
			$sql = 'SELECT `study`.Name, `schools`.Name as school, `schools`.ID as SID
				FROM `student-study-link`, `study`, `schools`
				WHERE `student-study-link`.StudentID = "'.$uid.'"
				AND `student-study-link`.StudyID = `study`.ID
				AND `study`.ParentID = `schools`.ID
				LIMIT 1';

			$rund = $this->core->database->doSelectQuery($sql);
			$applicant = FALSE;

			while ($row = $rund->fetch_row()) {
				$schoolid = $row[2];
			}
				
			if($this->core->role == 1000){
				$links =  $links;
			}


			if($sstatus == "Deceased"){
				$style = "background-color: #000;";
				$firstname = "&#10014; " . $firstname;
			}

			echo '<div class="student" style="">
			<div class="studentname" style="clear:both; '.$style.'"> ' . $firstname . ' ' . $middlename . ' ' . $surname . ' </div>';

 

			echo '<div class="profilepic">';

			if(isset($this->core->cleanGet['payid'])){
				$payid = $this->core->cleanGet['payid'];
				$other = "?payid=".$this->core->cleanGet['payid'];
				$date = $this->core->cleanGet['date'];

				echo'<div style="background-color: #DFDFDF; font-weight: bold; font-size: 14px; border: 1px solid #0098FF; text-align: center; padding: 10px;">
				<a href="' . $this->core->conf['conf']['path'] . '/payments/modify/'.$payid.'?uid='.$uid.'&date='.$date.'">ASSIGN PAYMENT</a>
				</div>';
			}
	
	
			if($sstatus == "Employed"){	
				$num = "System number"; 	
				echo'<div style="background-color: #DFDFDF; font-weight: bold; font-size: 14px; border: 1px solid #ccc; text-align: center; padding: 3px;">Employee</div>';
				
				echo '<div  class="studentsubmenu" style="background-color: #ffe049;"><b><a href="' . $this->core->conf['conf']['path'] . '/attendance/show/' . $uid . '">Attendance Log</a></b></div>';
				
			}else{
				
				echo'<a href="'.$links.'">
				<div style="'.$style.' font-weight: bold; font-size: 14px; border: 1px solid #ccc; text-align: center; padding: 3px; color: #FFF;">
				'.$activate.'</div></a>';
				$num = "Student number";
				echo'<div style="background-color: #DFDFDF; font-weight: bold; font-size: 14px; border: 1px solid #ccc; text-align: center; padding: 3px;">'.$mode.'</div>';

				if($mode == "Distance"){
					$sql = "SELECT `Group` FROM `groups` WHERE `StudentID` LIKE '$uid'";
					$run = $this->core->database->doSelectQuery($sql);

					while ($rd = $run->fetch_assoc()) {
						$group = $rd['Group'];
					}

					echo'<div style="background-color: #b9b9b9; font-weight: bold; font-size: 14px; border: 1px solid #ccc; text-align: center; padding: 3px;">Group '.$group.'</div>';
				}
			}

			echo'<div class="profilepiccontainer"><a href="'.$this->core->conf['conf']['path'].'/picture/make/'.$uid.'">';

			
			if (file_exists("datastore/identities/pictures/$uid.jpg")) {
				$filename = $path.'/datastore/identities/pictures/' . $uid . '.jpg';
			} else if (file_exists("datastore/identities/pictures/$uid.JPG")) {
				$filename = $path.'/datastore/identities/pictures/' . $uid . '.JPG';
			} else if (file_exists("datastore/identities/pictures/$uid.jpeg")) {
				$filename = $path.'/datastore/identities/pictures/' . $uid . '.jpeg';
			} else 	if (file_exists("datastore/identities/pictures/$uid.png")) {
				$filename = $path.'/datastore/identities/pictures/' . $uid . '.png';
			} else {
				$filename = $path.'/templates/default/images/noprofile.png';
			}
			
			echo'<img width="100%" src="'.$filename.'"></a></div>';
 
 
 			$sql = "SELECT `roles`.RoleName, `Username`, `roles`.ID
			 FROM `basic-information`, `access`, `roles`
			WHERE `access`.`ID` = '" . $uid . "' 
			AND (`access`.`Username` = `basic-information`.`ID` OR `access`.`Username` = '" . $uid . "')
			AND `access`.`Username` = `basic-information`.`ID`  
			AND `roles`.`ID` = `access`.RoleID";
			$run = $this->core->database->doSelectQuery($sql);

			while ($row = $run->fetch_row()) {
				$rolename = $row[0];
				$username = $row[1];
				$role = $row[2];
			}

			$sql = "SELECT * 
				FROM `reporting`, `periods`, `basic-information`
				WHERE `reporting`.`StudentID` = '$uid'
				AND `reporting`.PeriodID = `periods`.ID
				AND CURDATE() BETWEEN `CourseRegStartDate` AND  `CourseRegEndDate`
				AND `Delivery` = `StudyType`
				ORDER BY `reporting`.`ID` DESC LIMIT 1";

			$runx = $this->core->database->doSelectQuery($sql);

			$reported = FALSE;
			while ($rowx = $runx->fetch_assoc()) {
				$period = $rowx['Name'];
				
				echo'<div style="background-color: green; font-weight: bold; font-size: 14px; border: 1px solid #ccc; text-align: center; padding: 3px; color: #FFF;">
					REPORTED FOR: '.$period.'
				</div></a>';

				$reported = TRUE;
			}

			if($reported == FALSE){
				//echo '<div style="margin-top: 1px; border: solid 2px red; padding:10px; background-color: red;"><b><a style="color: #000;" href="' . $this->core->conf['conf']['path'] . '/register/returning/?uid=' . $uid . '">REPORT STUDENT</a></b></div>';	
			}

 
			if($sstatus=="Locked" || $sstatus=="Deregistered" || $sstatus == "Graduated"){
				echo'<a href="' . $this->core->conf['conf']['path'] . '/admission/activate/'.$uid.'"><div style="background-color: red; font-weight: bold; font-size: 14px; border: 1px solid #ccc; text-align: center; padding: 3px; color: #FFF;">ACCOUNT NOT ACTIVE</div></a>';
			}

			echo '<div class="studentsubmenucontainer">';
			echo '<div  class="studentsubmenu"><b><a href="' . $this->core->conf['conf']['path'] . '/registry/show/'.$uid.'">Registry Files</a></b></div>';

			if ($this->core->role >= 9 && $this->core->role < 100 ) {
				echo '<div class="studentsubmenu" visible><b><a href="' . $this->core->conf['conf']['path'] . '/information/edit/' . $uid . '">Edit my information</a></b></div>';
				echo '<div  class="studentsubmenu" visible><b><a href="' . $this->core->conf['conf']['path'] . '/grades/personal/' . $uid . '">Grades</a></b></div>';
				echo '<div  class="studentsubmenu visible"><b><a href="' . $this->core->conf['conf']['path'] . '/payments/personal/' . $uid . ''.$other.'">Show payments</a></b></div>';
			}
			
			if ($this->core->role == 107 || $this->core->role == 1000 && $role > 10) {
				echo '<div  class="studentsubmenu"><b><a href="' . $this->core->conf['conf']['path'] . '/records/manage/' . $uid . '">Staff records</a></b></div>';
			}
			
	
			if($role <= 10){
				echo '<div  class="studentsubmenu"><b><a href="' . $this->core->conf['conf']['path'] . '/records/manage/' . $uid . '">Student records</a></b></div>';
				if($schoolid == "14"){
					echo '<div  class="studentsubmenu visible"><b><a href="' . $this->core->conf['conf']['path'] . '/ca/results/' . $uid . '">Mid-Year Exam (NS)</a></b></div>';
				}
			}
			
			if ($this->core->role == 108) {
				echo '<div  class="studentsubmenu"><b><a href="' . $this->core->conf['conf']['path'] . '/information/edit/' . $uid . '">Edit user information</a></b></div>';
				if($role <= 10){
					echo '<div  class="studentsubmenu"><b><a href="' . $this->core->conf['conf']['path'] . '/statement/results/' . $uid . '">Grades</a></b></div>';
					echo '<div  class="studentsubmenu"><b><a href="' . $this->core->conf['conf']['path'] . '/sms/new/'. $mobilephone .'">Send student SMS</a></b></div>';
				}
				echo '<div  class="studentsubmenu"><b><a href="' . $this->core->conf['conf']['path'] . '/payments/dosa/' . $uid . ''.$other.'">Show payments</a></b></div>';

		
			} elseif ($this->core->role >= 100) {
				echo '<div  class="studentsubmenu visible"><b><a href="' . $this->core->conf['conf']['path'] . '/information/edit/' . $uid . '">Edit user information</a></b></div>';
				if($role <= 10){
					echo '<div  class="studentsubmenu visible"> <b><a href="' . $this->core->conf['conf']['path'] . '/statement/results/' . $uid . '">Grades</a></b></div>';
					echo '<div  class="studentsubmenu visible"><b><a href="' . $this->core->conf['conf']['path'] . '/statement/results/' . $uid . '?unpublished=TRUE">Not Published Grades</a></b></div>';
					echo '<div  class="studentsubmenu visible"><b><a href="' . $this->core->conf['conf']['path'] . '/register/course/' . $uid . '">Register Student</a></b></div>';
					echo '<div  class="studentsubmenu"><b><a href="' . $this->core->conf['conf']['path'] . '/override/exam/' . $uid . '?period=74">Add Finance Override</a></b></div>';
					echo '<div  class="studentsubmenu"><b><a href="' . $this->core->conf['conf']['path'] . '/lateregister/course/' . $uid . '">Late Registration</a></b></div>';
				echo '<div  class="studentsubmenu"><b><a href="' . $this->core->conf['conf']['path'] . '/sms/new/'. $mobilephone .'">Send student SMS</a></b></div>';
				}
				echo '<div  class="studentsubmenu visible"><b><a href="' . $this->core->conf['conf']['path'] . '/payments/show/' . $uid . ''.$other.'">Show payments</a></b></div>';
				echo '<div  class="studentsubmenu visible"><b><a href="' . $this->core->conf['conf']['path'] . '/password/reset/'. $uid .'">Reset password</a></b></div>';
				echo '<div  class="studentsubmenu"><b><a href="' . $this->core->conf['conf']['path'] . '/cards/print/' . $uid . '">Print card</a></b></div>';
			}
			if ($this->core->role <= 10 && $personal == TRUE) {
				echo '<div style="margin-top: 1px; border-top: solid 1px #ccc; padding:10px;"><b><a href="' . $this->core->conf['conf']['path'] . '/information/edit/">Edit my information</a></b></div>';
				echo '<div  class="studentsubmenu"><b><a href="' . $this->core->conf['conf']['path'] . '/grades/personal/">Show grades</a></b></div>';
				echo '<div  class="studentsubmenu visible"><b><a href="' . $this->core->conf['conf']['path'] . '/payments/personal/">Show payments</a></b></div>';
				echo '<div  class="studentsubmenu"><b><a href="' . $this->core->conf['conf']['path'] . '/users/withdraw/">Withdraw Online</a></b></div>';
			}
			if ($this->core->role >= 100 && $role <= 10) {
				echo '<div  class="studentsubmenu"><b><a href="' . $this->core->conf['conf']['path'] . '/accommodation/assign?userid='. $uid .'">Assign room</a></b></div>';
				echo '<div  class="studentsubmenu"><b><a href="' . $this->core->conf['conf']['path'] . '/examination/results/'. $uid .'">Print EXAM Docket</a></b></div>';
				echo '<div  class="studentsubmenu"><b><a href="' . $this->core->conf['conf']['path'] . '/tests/results/'. $uid .'">Print TEST Docket</a></b></div>';

			}
			echo'</div>';


			if($sex == ""){
				$sex = "Unknown";
			}

			if($sstatus == "Requesting"){
				$sstatus = "Requesting Admission";
			}
			
			
			echo '</div>
			<div style="float: left; margin-right: 20px;  padding-left: 15px;   border-right: 1px dotted #ccc; ">
			<div class="segment" >Account information</div>
			<table  height="63" border="0" cellpadding="0" cellspacing="0">
			  <tr>
			<td><b>'.$num.'</b></td>
			<td><b>' . $uid . '</b></td>
			  </tr>
			  <tr>
			<td width="200">Gender</td>
			<td><u>' . $sex . '</u></td>
	 		 </tr>
	
	 		 <tr>
			<td>NRC</td>
			<td>' . $nrc . '</td>
	 		 </tr>
			  <tr>
			<td>Nationality</td>
			<td>' . $nationality . '</td>
			  </tr>
			  <tr>
			<td>Account status</td>
			<td><b>' . $sstatus . '</b></td>
	 		 </tr>';
			 
			 
			$sqlx = "SELECT * FROM `sage` WHERE `LocalID` = '$uid'";
			$runx = $this->core->database->doSelectQuery($sqlx);

			while ($rowx = $runx->fetch_assoc()) {
				$sage = $rowx['StudentID'];
			}
			
			if($sage == ''){
				$sage = '<a href="/sage/link/'.$uid.'">NO SAGE ACCOUNT LINKED</a>';
			} else {
				$linkSage = '<a href="/sage/link/'.$uid.'">Edit</a>';
			}

			echo'<tr>
			<td>SAGE ID</td>
			<td><b>' . $sage . '</b> '.$linkSage.'</td>
	 		 </tr>';
			 
			 
			require_once $this->core->conf['conf']['viewPath'] . "payments.view.php";
			$payments = new payments();
			$payments->buildView($this->core);
			$balance = $payments->getBalance($uid);
			if($balance > 0){
				$bcolor = "red";
			} else{
				$bcolor = "#000";
			}
			echo'<tr>
			<td>Account Balance</td>
			<td style="color: '.$bcolor.';"><a href="' . $this->core->conf['conf']['path'] . '/payments/show/' . $uid . '"><b> K'.number_format($balance).'</b></a></td>
	 		 </tr>';
			 

			$sql = "SELECT `roles`.RoleName, `Username`, `roles`.ID
			 FROM `basic-information`, `access`, `roles`
			WHERE `access`.`Username` = '" . $uid . "' 
			AND (`access`.`Username` = `basic-information`.`ID` OR `access`.`Username` = '" . $uid . "')
			AND `access`.`Username` = `basic-information`.`ID`  
			AND `roles`.`ID` = `access`.RoleID";
			$run = $this->core->database->doSelectQuery($sql);

			while ($row = $run->fetch_row()) {
				$rolename = $row[0];
				$username = $row[1];
				$role = $row[2];
				
				echo '<tr>
					<td>Access Level</td>
					<td>' . $rolename . '</td>
				</tr>';
				
				echo '<tr>
					<td>Username</td>
					<td><b>' . $username . '</b></td>
				</tr>';
				$roleset = TRUE;
			}
			
			if($roleset != TRUE){
				echo '<tr>
					<td>Access Level</td>
					<td><span style="font-weight: bold; font-size: 10pt; color: red;">NO ROLE - USER CAN\'T LOG IN</span></td>
				</tr>';
			}
			
			$sql = "SELECT * FROM `student-data-other` WHERE `StudentID` LIKE '$uid' ORDER BY `ID` DESC LIMIT 1";
			$run = $this->core->database->doSelectQuery($sql);

			while ($row = $run->fetch_row()) {
				$studygroup = $row[9];
				$studygrouptwo = $row[10];
				$center = $row[3];
				$resource = $row[7];
				if($center == ""){
					$center = '<span style="font-weight: bold; font-size: 10pt; color: red;">NO CAMPUS SET</span>';
				}

				if($resource == ""){
					$resource = 'Not selected';
				}




			}


			$sql = "SELECT * FROM `overrides` WHERE `StudentID` LIKE '$uid'";
			$run = $this->core->database->doSelectQuery($sql);

			while ($row = $run->fetch_assoc()) {
				echo '<tr>
					<td>Financial Override</td>
					<td><span style="font-weight: bold; font-size: 10pt; color: red;">ENABLED</span></td>
				</tr>';
			}
			
			

			
			
			if ($center == "") { $center = "No campus set";}
			
			echo '<tr>
				<td>Campus</td>
				<td>' . $center . '</td>
				 </tr>';

	

				if(!empty($studygroup)){
					echo '<tr>
					<td>Study Group</td>
					<td>' . $studygroup . ' / ' . $studygrouptwo . '</td>
					</tr>';
				}

			echo '</table>';



			//STAFF SECTION
			
			$sql = "SELECT *, `staff`.`LeaveDays` as days FROM `staff`, `positions`, `departments`
					WHERE `staff`.`ID` = '" . $uid . "'
					AND `staff`.JobTitle = `positions`.ID
					AND `positions`.DepartmentID = `departments`.ID";
					
			$run = $this->core->database->doSelectQuery($sql);

	
			while ($fetch = $run->fetch_assoc()) {

				$jobtitle = $fetch['JobTitle'];
				$department = $fetch['Name'];
				$engaged = $fetch['EmploymentDate'];
				$endofcontract = $fetch['EndDate'];
				$bank = $fetch['Bank'];
				$branch = $fetch['BankBranch'];
				$account = $fetch['BankAccount'];
				$days = $fetch['days'];

				echo '<div class="segment">Employee Information</div>
				<table height="" border="0" cellpadding="0" cellspacing="0">
				  <tr>
					<td width="200"><b>Current Position</b></td>
					<td width=""><b>' . $jobtitle . '</b></td>
				  </tr>
				  <tr>
					<td>Department</td>
					<td>' . $department . '</td>
				  </tr><tr>
				<td>Contact Dates</td>
				<td>' . $engaged . ' to ' . $endofcontract . '</td>
				  </tr>
				  <tr>
					<td>Bank Details</td>
					<td>' . $bank . '</td>
				  </tr>
				  <tr>
					<td>Branch</td>
					<td>' . $branch . '</td>
				  </tr>
				  <tr>
					<td>Account</td>
					<td>' . $account . '</td>
				  </tr>
				   <tr>
					<td><b>Leave Days</b></td>
					<td>' . $days . ' days</td>
				  </tr>
				</table></div>';

			}
			
			
			
			
			
			
			
			if ($streetname == "") { $streetname = "No address provided";}
			echo '<div style="float: left;">
			<div class="segment" >Contact information</div>
			<table height="" border="0" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="200">Physical address</td>
				<td>' . $streetname . '</td>
			  </tr>';

			if ($postalcode == "") { $postalcode = "No PO box provided";}
				echo '<tr>
					<td>PO. Box</td>
					<td>' . $postalcode . '</td>
			 	</tr>';
			

			if ($town == "") {  $town = "No town provided";}
				echo '<tr>
					<td>Town</td>
					<td>' . $town . '</td>
			 	</tr>';
			

			if ($country != "") {
				echo '<tr>
					<td>Country</td>
					<td>' . $country . '</td>
			  	</tr>';
			}

			echo '<tr>
			</tr>';

			if ($homephone != "" && $homephone != "0") {
				echo '<tr>
				<td>Home Phone</td>
				<td><b>' . $homephone . '</b></td>
	 			</tr>';
			}

			if ($mobilephone != "" && $mobilephone != "0") {
				echo '<tr>
				<td>Mobile Phone</td>
				<td><b>' . $mobilephone . '</b></td>
				</tr>';
			}
 
			if ($email == "") { $email = "No email set";}
			
			echo '<tr>
					<td>Private Email</td>
					<td><a href="mailto:' . $email . '">' . $email . '</td>
					</tr>';
			
			echo'</table></div></div>';

			$sql = "SELECT * FROM `emergency-contact` WHERE `StudentID` = '" . $nrc . "' OR  `StudentID` = '" . $uid . "' ";
			$run = $this->core->database->doSelectQuery($sql);

	
			while ($fetch = $run->fetch_row()) {

				$fullname = $fetch[2];
				$relationship = $fetch[3];
				$phonenumber = $fetch[4];
				$street = $fetch[5];
				$town = $fetch[6];
				$postalcode = $fetch[7];

				echo '<div style="float: left;">
				<div class="segment">Emergency information</div>
				<table height="" border="0" cellpadding="0" cellspacing="0">
				  <tr>
					<td width="200">Full Name</td>
					<td width="">' . $fullname . '</td>
				  </tr>
				  <tr>
					<td>Relationship</td>
					<td>' . $relationship . '</td>
				  </tr>';

				if ($phonenumber != "" && $phonenumber != "0") {
					echo '<tr>
					<td>Phonenumber</td>
					<td>' . $phonenumber . '</td>
					</tr>';
				}

				echo '<tr>
				<td>Street</td>
				<td>' . $street . '</td>
			  </tr>
			  <tr>
				<td>Town</td>
				<td>' . $town . '</td>
			  </tr>
			  <tr>
				<td>Postalcode</td>
				<td>' . $postalcode . '</td>
			  </tr>
			</table></div>';

			}
			

			// JERE
			
			
			if($role >= 100){
				echo '<div id="publications" style=" float: left;">';
				echo '<div class="segment">PUBLICATIONS BY STAFF MEMBER</div>';
				$sqlPub = "SELECT `teams`.`ProjectID`, `teams`.`Name`,`teams`.`University`,`teams`.`School`,`teams`.`Position`,`research`.`Name` as 'Description',`research`.`Area`,`research`.`Locale`,`research`.`Budget`,`research`.`Start` ,`research`.`End`  
						   FROM `teams`,`research` 
						   WHERE `teams`.`ProjectID` = `research`.`ID`
						   AND `teams`.`Name` LIKE '%$employeeName%'";

				$runPub = $this->core->database->doSelectQuery($sqlPub);
				while ($row = $runPub->fetch_assoc()) {
					echo '&#10147 Title: <b>'.$row["Description"].'</b><br> &#9658 Position: '.$row["Position"].'<br>';
					echo ' &#9658 Area of research: '.$row["Area"].'<br>';
					echo ' &#9658 Start date: '.$row["Start"].'<br> &#9658 End date: '.$row["End"];
					echo '<hr>';
				}
	
				echo '</div><br>';
			}
			
			
			$sql = "SELECT * FROM `sponsor-contact` WHERE `StudentID` = '" . $uid . "' ";
			$run = $this->core->database->doSelectQuery($sql);

	
			while ($fetch = $run->fetch_row()) {

				$fullname = $fetch[2];
				$relationship = $fetch[3];
				$phonenumber = $fetch[4];
				$street = $fetch[5];
				$town = $fetch[6];
				$postalcode = $fetch[7];

				echo '<div style="float: left;"><div class="segment">Sponsor information</div>
				<table height="" border="0" cellpadding="0" cellspacing="0">
				  <tr>
					<td width="200">Full Name</td>
					<td width="">' . $fullname . '</td>
				  </tr>
				  <tr>
					<td>Relationship</td>
					<td>' . $relationship . '</td>
				  </tr>';

				if ($phonenumber != "" && $phonenumber != "0") {
					echo '<tr>
					<td>Phonenumber</td>
					<td>' . $phonenumber . '</td>
					</tr>';
				}

				echo '<tr>
				<td>Street</td>
				<td>' . $street . '</td>
			  </tr>
			  <tr>
				<td>Town</td>
				<td>' . $town . '</td>
			  </tr>
			  <tr>
				<td>Postalcode</td>
				<td>' . $postalcode . '</td>
			  </tr>
			</table></div>';

			}
			
			echo '</div>';
			
			
			
			
// END FIRST COLUMN
		

			$studyname = '';
			$sql = 'SELECT `study`.Name, `schools`.Name as school, `schools`.ID as SID
				FROM `student-study-link`, `study`, `schools`
				WHERE `student-study-link`.StudentID = "'.$uid.'"
				AND `student-study-link`.StudyID = `study`.ID
				AND `study`.ParentID = `schools`.ID
				LIMIT 1';

			$run = $this->core->database->doSelectQuery($sql);
			$applicant = FALSE;

			while ($row = $run->fetch_row()) {
				$studyname = $row[0];
				$school = $row[1];
				$schoolid = $row[2];
				$applicant = FALSE;

				echo '<div style=" float: left;">
				<div class="segment">Registered Program Information</div>
				<table  height="" border="0" cellpadding="0" cellspacing="0">
				<tr>
				<td width="100">Program: </td>
				<td width=""><b>' . $studyname . '</b></td>
				</tr>
				<tr>
				<td width="100">School: </td>
				<td width="380"><b>' . $school . '</b></td>
				</tr>
				</table>
				</div>';
			}
			

			$sql = 'SELECT `study`.Name FROM `applicants`, `study` 
				WHERE `applicants`.StudentID = "'.$uid.'"
				AND `applicants`.Study = `study`.ID';

			$run = $this->core->database->doSelectQuery($sql);

			while ($row = $run->fetch_row()) {
				$studyname = $row[0];

				$applicant = TRUE;

				echo '<div style="float: left;">
				<div class="segment">Application Details</div>
				<table height="" border="0" cellpadding="0" cellspacing="0">
				<tr>
				<td width="150">Program applied for: </td>
				<td width=""><b>' . $studyname . '</b></td>
				</tr>
				</table></div>';



				$sql = 'SELECT * FROM `subject-grades`, `subjects` 
					WHERE `subject-grades`.StudentID = "'.$nrc.'"
					AND `subjects`.ID = `subject-grades`.SubjectID';
	
				$runi = $this->core->database->doSelectQuery($sql);
				$ix=0;
				while ($fetchi = $runi->fetch_assoc()) {
					
					if($ix == 0){
						echo'<div style=" float: left;">
							<div class="segment" style="">Grade 12 Results</div>
							<div style="padding-left: 40px;">';
							$ix++;
					}
					$course = $fetchi['Shortcode'];
					$grade = $fetchi['Grade'];

					echo '<b>'.$course.'</b> - '.$grade.'<br>';
				}
				if($ix>0){
					echo'</div>';
				}

			}


		

				$sql = "SELECT * FROM `student-program-link` as sp, `programmes` as p
					WHERE sp.`StudentID` = '$uid' 
					AND sp.`Major` = p.`ID` 
					ORDER BY sp.`ID` DESC LIMIT 1";

				$run = $this->core->database->doSelectQuery($sql);
		
				while ($row = $run->fetch_row()) {
	
					$name = $row[7];
	
					echo '<tr>
					<td>Major </td>
					<td width=""><b>' . $name . '</b></td>
					</tr>';
		
					$student = TRUE;
				}
	
					$sql = "SELECT * FROM `student-program-link` as sp, `programmes` as p
						WHERE sp.`StudentID` = '$uid' 
						AND sp.`Minor` = p.`ID`
						ORDER BY sp.`ID` DESC LIMIT 1";

				$run = $this->core->database->doSelectQuery($sql);
		
				while ($row = $run->fetch_row()) {
	
					$name = $row[7];
	
					echo '<tr>
					<td>Minor </td>
					<td width=""><b>' . $name . '</b></td>
					</tr>';

					$student = TRUE;
							
				}


				if($role <= 10){
					echo'<div style=" float: left;">
					<div class="segment" style="">Course Registration</div>
					<div style="width: 100%;">';	

					$sqls = "SELECT DISTINCT `Approved`, `PackageName`, `courses`.Name as course, `courses`.CourseDescription, `courses`.ID, `course-electives`.Year, `course-electives`.Semester,  `course-electives`.CourseID,  `course-electives`.ID as CRID, `periods`.Name, `periods`.ID as PID, `course-electives`.PeriodID, `billing`.PackageName, `billing`.ID
						FROM `course-electives`
						LEFT JOIN `courses` ON `course-electives`.CourseID = `courses`.Name
						LEFT JOIN `periods` ON `course-electives`.PeriodID = `periods`.ID
						LEFT JOIN `billing` ON `billing`.PeriodID = `periods`.ID AND `course-electives`.StudentID = `billing`.StudentID AND `billing`.ID = (SELECT MAX(`ID`) FROM `billing` WHERE `StudentID` = '$uid' AND `PeriodID` = `periods`.ID  AND `billing`.`PackageName` NOT LIKE 'SUP-%')
						WHERE `course-electives`.StudentID  = '$uid' 
						AND `course-electives`.Approved IN (0,1)
						GROUP BY `course-electives`.`PeriodID`, `course-electives`.CourseID, `billing`.PackageName, `billing`.ID, `course-electives`.PeriodID
						ORDER BY `course-electives`.`Year` DESC, `course-electives`.`Semester` DESC, `courses`.Name DESC, `billing`.ID  DESC";


			
					$runo = $this->core->database->doSelectQuery($sqls);
					$ccount=0;
					while ($fetchw = $runo->fetch_assoc()) {
		
						$crid = $fetchw['CRID'];
						$period = $fetchw['PID'];
						$year = $fetchw['Year'];
						$semester = $fetchw['Semester'];
						$courseid = $fetchw['CourseID'];
						$coursecode = $fetchw['Name'];
						$description = $fetchw['CourseDescription'];
						$packagename = $fetchw['PackageName'];
						$approval = $fetchw['Approved'];
						$name = $fetchw['Name'];
						$coursecode = $fetchw['course'];
			
						$dellink = '';
						$status = '';
						$color = '';
						
						if($packagename == ''){
							$packagename = 'No invoice linked';
						}
						
						$dellink = '<div style="float:right;"><a href="' . $this->core->conf['conf']['path'] . '/register/move/?userid='.$uid.'&period='.$period.'"><i class="bi bi-pencil"></i></a>  <a href="' . $this->core->conf['conf']['path'] . '/register/course/delete/?userid='.$uid.'&period='.$period.'"><i class="bi bi-trash"></i></a>   <a href="' . $this->core->conf['conf']['path'] . '/register/direct/'.$uid.'"><i class="bi bi-plus-square"></i></a>  <a href="' . $this->core->conf['conf']['path'] . '/deferred/move/'.$uid.'&period='.$period.'"><i class="bi bi-arrow-down-right-square"></i></a></div>';
					
						if($approval == 0){
							$color = '<span style="color: #ccc">';
							$status = ' <b>(pending approval)</b>';
							}
						
						if($year != $pyear || $psemester != $semester || $ccount==0){
							if($ccount>0){
								echo'</ol>';
							}
							echo '<div style="background-color: #CCC; border: 1px solid #333; font-weight: bold; padding: 5px; padding-left: 20px;">Courses - '.$year.' - Semester '.$semester.'  '.$dellink.'</div><div style="background-color: #b9d2e6; border: 1px solid #333; font-weight: bold; padding: 5px; padding-left: 20px;">'.$packagename.'</div>
							<ol type = "1" style="padding-inline-start: 10px;">';
						}
						
						if($coursecode == '' && $courseid != ''){
							$coursecode = $courseid;
							$description = '<span style="color: gray">COURSE NOT FOUND</span>';
						}
						
						$module = '/loader/module/'.$coursecode;
						$path = '/var/www/html/datastore/modules/'.$coursecode.'.pdf';
						
						if($this->core->role == 1000 || $this->core->role == 105){
							$delete = '- <a href="' . $this->core->conf['conf']['path'] . '/register/course/delete/'.$crid.'?userid='.$uid.'"><img src="/templates/edurole/images/delete.gif"></a>';
						}
						
						if($mode == "Distance"){
							if( file_exists($path)){
								echo'<li>'.$color.'<b>'.$coursecode.'</b>  - <i> <b><a href="'.$module.'">	'.$description.'</a></b></i> '.$delete.''.$status.'</span></li>';
							} else{
								echo'<li>'.$color.'<b>'.$coursecode.'</b>  - <i> '.$description.'</i> '.$delete.''.$status.'</span></li>';
							}
						} else {
							echo'<li>'.$color.'<b>'.$coursecode.'</b>  - <i> '.$description.'</i> '.$delete.''.$status.'</span></li>';
						}
					
					
						$pyear = $year;
						$psemester = $semester;
						$ccount++;
						$setc = TRUE;
		
					}
					
					if($setc==TRUE){
						echo'</ol>';
					}

					if($runo->num_rows == 0){
						echo '<div class="warningpopup">NO COURSES SELECTED FOR THE CURRENT SEMESTER/TERM</div>';
					}	

					echo'</div></p></td></tr>';
					echo'</table></div></div>';

			}




			
	

			$housing = FALSE;

			$sql = "SELECT * 
				FROM `housing`, `rooms`, `hostel`, `basic-information`, `periods`
				WHERE `housing`.RoomID = `rooms`.ID 
				AND `rooms`.HostelID = `hostel`.ID 
				AND `basic-information`.ID = `housing`.StudentID 
				AND `basic-information`.ID = '$uid'
				AND `housing`.PeriodID = `periods`.ID";

			$run = $this->core->database->doSelectQuery($sql);

			$sqlm = "SELECT * FROM `mealcard` WHERE `mealcard`.StudentID = '$uid'";
			//$runm= $this->core->database->doSelectQuery($sqlm);
			//$mealcard = $runm->num_rows;


			while ($fetch = $run->fetch_assoc()) {

				$AccommodationName = $fetch['HostelName'];
				$RoomNumber = $fetch['RoomNumber'];
				$RoomType = $fetch['RoomType'];	
				$RoomID = $fetch['RoomID'];	
				$weeks = $fetch['Weeks'];

				 
				echo '<div style=" float: left;">
				<div class="segment">Housing information</div>
				<table height="" border="0" cellpadding="0" cellspacing="0">
				<tr>
				<td width="200">Accommodation</td>
				<td width="">' . $AccommodationName . '</td>
				<tr>
				<td>Room</td>
				<td width=""><a href="' . $this->core->conf['conf']['path'] . '/accommodation/room/'. $RoomID .'">' . $RoomNumber . ' (' . $RoomType . ')</a></td>
				</tr>';

				/*if($mode != "Fulltime"){
					echo'<tr>
					<td>Weeks</td>
					<td width=""><b> ' . $weeks . ' WEEKS</b></td>
					</tr>';	
				}*/

				if($mealcard > 0){
					echo'<tr>
					<td>Meal card</td>
					<td width=""><b> MEAL CARD PRINTED</b></td>
					</tr>';	
				}

				echo'</table></div>';


				$housing = TRUE;
			}

			if($housing == FALSE){
		
				$sql = "SELECT * FROM `housingapplications`, `rooms`, `hostel`,`basic-information`
				WHERE `housingapplications`.RoomID = `rooms`.ID 
				AND `rooms`.HostelID = `hostel`.ID 
				AND `basic-information`.ID = `housingapplications`.StudentID 
				AND `basic-information`.ID = '$uid'";
				$run = $this->core->database->doSelectQuery($sql);

				while ($fetch = $run->fetch_assoc()) {

					$AccommodationName = $fetch['HostelName'];
					$RoomNumber = $fetch['RoomNumber'];
					$RoomType = $fetch['RoomType'];	
				
					echo '<div style=" float: left;">
					<div class="segment">HOUSING APPLICATION</div>
					<table height="" border="0" cellpadding="0" cellspacing="0" style="color: #ccc">
					<tr>
					<td width="200">Hostel name</td>
					<td width="">' . $AccommodationName . '</td>
					</tr>
					<tr>
					<td>Room</td>
					<td width="">' . $RoomNumber . ' (' . $RoomType . ')</td>
					</tr>
					</table></div>';


				}
			}

			



			
			
			$sql = "SELECT * FROM `staff` WHERE `ID` = '.$uid.'";
			$run = $this->core->database->doSelectQuery($sql);

			while ($fetch = $run->fetch_assoc()) {

				$job = $fetch['JobTitle'];
				$napsa = $fetch['SocialSecurity'];
				$employeeno = $fetch['EmployeeNo'];
				$employmentdate = $fetch['EmploymentDate'];	
				$enddate = $fetch['EndDate'];	
				$grade = $fetch['Grade'];
				$basicpay = $fetch['BasicPay'];
				$gratuity = $fetch['Gratuity'];
				$school = $fetch['SchoolID'];
				 
				 
				echo '<div style=" float: left;">
				<div class="segment">Staff information</div>
				<table width="350" height="" border="0" cellpadding="0" cellspacing="0">
				<tr>
				<td width="200">Job Title</td>
				<td width="">' . $job . '</td>
				<tr>
				<td>Employment Date</td>
				<td width="">'.$employmentdate.'</td>
				</tr>
				<tr>
				<td>Grade</td>
				<td width=""><b> ' . $grade . ' </b></td>
				</tr>
				</table></div><br>';


				$housing = TRUE;
			}

			

			$nrc = preg_replace("/[^0-9]/","",$nrc);
			$sql = "SELECT * FROM `education-background` WHERE `StudentID` = '$uid'";
			$run = $this->core->database->doSelectQuery($sql);
			$n = 0;

			while ($row = $run->fetch_row()) {

				$name = $row[2];
				$type = $row[3];
				$institution = $row[4];
				$filename = $row[5];
				$start = $row[6];
				$end = $row[7];

				if ($n == 0) {
					echo '<div style="float: left;"><div class="segment">Education history</div>';
					$n++;
				} else {
				}

				echo '<table height="" border="0" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="200">Name of institution</td>
				<td width=""><b>' . $institution . '</b></td>
			  </tr>
			  <tr>
				<td>Level of certificate</td>
				<td>' . $type . '</td>
			  </tr>
			  <tr>
				<td>Name of certificate</td>
				<td>' . $name . '</td>
			  </tr>';

				if ($filename != "") {
					echo '<tr>
					<td>Image of certificate</td>
					<td><a href="' . $this->core->conf['conf']['path'] . '/datastore/userhomes/'.$uid.'/education-history/' . $filename . '"><b>View file</b></a></td>
			 		</tr>';
				}

				if ($start != "" && $end != '') {
					echo '<tr>
					<td>Period</td>
					<td>'.$start.' - '.$end.'</td>
			 		</tr>';
				}
				echo '</table><br>';
			}
			echo "</div>";
		}

		if ($results != TRUE) {
			$this->core->throwError('Your search did not return any results');
		}
	}

	private function showInfoList($sql) {

		$run = $this->core->database->doSelectQuery($sql);

	
			
		if(!isset($this->core->cleanGet['offset'])){
			
			$_SESSION["recipients"] = $sql;
			$url = $_SERVER['QUERY_STRING'];
			$url = explode('&', $url);
			$url = $url[2]. '&'. $url[3].'&'. $url[4].'&'. $url[5].'&'. $url[6];

			echo '<div class="toolbar">'.
			'<a href="' . $this->core->conf['conf']['path'] . '/sms/newbulk">Send SMS to all results</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/printer/search?'.$url.'">Print letter to all results</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/export/search?'.$url.'">Export all results</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/sign/search?'.$url.'">Print sign list</a>'.
			'</div>';
			
			if(isset($this->core->cleanGet['period'])){
			
				$period= $this->core->cleanGet['period'];
				
				$sqlPeriod = "SELECT * FROM `periods`	WHERE `periods`.ID = '$period'";
				$runPeriod = $this->core->database->doSelectQuery($sqlPeriod);
				while ($fetch = $runPeriod->fetch_assoc()) {

				$startdate = $fetch['PeriodStartDate'];
				$enddate = $fetch['PeriodEndDate'];
				$name = $fetch['Name'];
				$year = $fetch['Year'];
				$semester = $fetch['Semester'];

					echo '<h2>SELECTED PERIOD '.$year.'  - '.$name.'</h2>';

				}
			}
			
			
			echo'<table id="results" class="table table-bordered table-striped table-hover">
			
			<tbody>';
		}

		$count = $this->offset+1;
		
		while ($row = $run->fetch_assoc()) {
			$results = TRUE;
			
			$id = $row['ID'];
			$NID = $row['GovernmentID'];
			$firstname = $row['FirstName'];
			$middlename = $row['MiddleName'];
			$surname = $row['Surname'];
			$celphone = $row['MobilePhone'];
			$status = $row['Status'];
			$mode = $row['StudyType'];
			$courses = $row['Courses'];
			$examcenter= $row['ExamCentre'];
			$email= $row['PrivateEmail'];
			$currYear= $row['CurrYear'];
			$comment= $row['Comment'];
			
			/***** Extra- code for the study******/
			$sqlx = "SELECT a.Name,a.ShortName,c.Description as school FROM `study` a, `student-study-link` b, schools c
					WHERE a.ID = b.StudyID AND b.StudentID=$id AND a.ParentID=c.ID";
	
				$runx = $this->core->database->doSelectQuery($sqlx);
	
				while ($rowd = $runx->fetch_assoc()) {
					$studyName=$rowd['Name'];
					$studyShortName= $rowd['ShortName'];
					$school= $rowd['school'];
				}
			
			/*************************************/
			

			if($firstname == $middlename){
				$middlename ='';
			}
			
			if($middlename == 'Null'){
				$middlename ='';
			}
			
			if ($school!=$schoolCurrent){
				echo'<tr>
						<td colspan="9" style="font-size: 11pt; font-weight: bold; border: 1px solid #333;">'.$school.'</td>
					</tr>';
			}
			if ($studyName!=$studyNameCurrent){
				echo'<tr>
						<td colspan="9" style="font-size: 9pt; font-weight: bold; border: 1px solid #333; align: center;">'.$studyName.'</td>
					</tr>
					<thead>
						<tr>
							<th bgcolor="#EEEEEE" width="40px">#</th>
							<th bgcolor="#EEEEEE" width="250px" data-sort"string"=""><b>Student Name</b></th>
							<th bgcolor="#EEEEEE"><b>Student Number</b></th>';
							if (!empty($courses)){
								echo '<th bgcolor="#EEEEEE"><b>Course(s)</b></th>';
							}
							echo '<th bgcolor="#EEEEEE"><b>Phone number</b></th>
							<th bgcolor="#EEEEEE"><b>Email</b></th>';
							if (!empty($currYear)){
								echo '<th bgcolor="#EEEEEE"><b>Year</b></th>';
							}
							echo '<th bgcolor="#EEEEEE"><b>Status</b></th>
							<th bgcolor="#EEEEEE"><b>Delivery</b></th>
						</tr>
					</thead>';
			}
			
			echo'<tr>
				<td>'.$count.'</td>
				<td><a href="' . $this->core->conf['conf']['path'] . '/information/show/' . $id . '"><b> '.$firstname.' '.$middlename.' '.$surname.'  </b></a></td>
				<td> '.$id.'</td>';
			if (!empty($courses)){
				echo'<td> '.$courses.'</td>';
			}
			 echo'	<td> '.$celphone.'</td>
				<td> '.$email.'</td>';
			if (!empty($currYear)){
				echo'<td> '.$currYear.'</td>';
			}
			if (!empty($examcenter)){
				echo'<td> '.$examcenter.'</td>';
			}else if (!empty($comment)){
				echo'<td> '.$comment.'</td>';
			}else{
			 echo'<td> '.$status.'</td>';	
			}
			echo'<td> '.$mode.'</td>
				</tr>';

			$count++;
			$results = TRUE;
			
			$schoolCurrent=$school;
			$studyNameCurrent=$studyName;
		}

		if($this->core->pager == FALSE){
			if ($results != TRUE) {
				$this->core->throwError('Your search did not return any results');
			}

			if($this->core->pager == FALSE){

				include $this->core->conf['conf']['libPath'] . "edurole/autoload.js";
			}
		}

		if(!isset($this->core->cleanGet['offset'])){
			echo'</tbody>
			</table>';
		}


	}

	public function editInformation($item) {
		if(empty($item) || $this->core->role <= 10){ $item = $this->core->userID;  }

		$sql = "SELECT  *, bi.ID as SID , bi.Status as Status 
		FROM  `basic-information` as bi
		LEFT JOIN `access` as ac ON ac.`ID` = '" . $item . "' 
		LEFT JOIN `staff` ON  bi.`ID` = `staff`.ID
		WHERE bi.`ID` = '" . $item . "'
		LIMIT 1";
		

		$run = $this->core->database->doSelectQuery($sql);
 
		while ($row = $run->fetch_assoc()) {
			
			
			
			$id = $row['SID'];
			$NID = $row['GovernmentID'];
			$firstname = $row['FirstName'];
			$middlename = $row['MiddleName'];
			$surname = $row['Surname'];
			$gender = $row['Sex'];
			$dob = $row['DateOfBirth'];
			$nationality = $row['Nationality'];
			$street = $row['StreetName'];
			$postal = $row['PostalCode'];
			$town = $row['Town'];
			$country = $row['Country'];
			$homephone = $row['HomePhone']; 
			$celphone = $row['MobilePhone'];
			$disability = $row['Disability'];
			$email = $row['PrivateEmail'];
			$empno = $row['EmployeeNo'];
			$relation = $row['Relation'];
			$role = $row['RoleID'];
			$status = $row['Status'];
			$method = $row['StudyType'];
			$username = $row['Username'];
			$mstatus = $row['MaritalStatus'];

			$study = $row['StudyID'];
			
			//staff fields
			$position = $row['JobTitle'];
			$napsa = $row['SocialSecurity'];
			$tpin = $row['TaxID'];
			$bank = $row['Bank'];
			$account = $row['BankAccount'];
			$branch = $row['BankBranch'];
			$engaged = $row['EmploymentDate'];
			$endcontract = $row['EndDate'];
			$empno = $row['EmployeeNo'];
			$basicpay = $row['BasicPay'];

			if($role == ''){
				$role = 10;
			}


		}

		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";

		$select = new optionBuilder($this->core);
		$roles = $select->showRoles($role);
		$departments = $select->showDepartments($department);
		if($department == ""){ $department = NULL; }
		$positions = $select->showPositions($department, $position);

		include $this->core->conf['conf']['formPath'] . "edituser.form.php";

	}


	public function groupInformation($item) {
		if(empty($item) || $this->core->role <= 10){ $item = $this->core->userID;  }


		$sql = "SELECT `Group` FROM `groups` WHERE `StudentID` LIKE '$uid'";
		$run = $this->core->database->doSelectQuery($sql);

		while ($rd = $run->fetch_assoc()) {
			$group = $rd['Group'];


			include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";

			$select = new optionBuilder($this->core);
			$select = $select->showGroups($group);

		}

		include $this->core->conf['conf']['formPath'] . "editgroup.form.php";

	}
}

?>
