<?php
class claim {

	public $core;
	public $view;

	public function configView() {
		$this->view->open = TRUE;
		$this->view->header = TRUE;
		$this->view->footer = TRUE;
		$this->view->menu = FALSE;
		$this->view->internalMenu = TRUE;
		$this->view->javascript = array('register', 'jquery.form-repeater');
		$this->view->css = array();

		return $this->view;
	}

	public function buildView($core) {
		$this->core = $core;
		
		echo'<style>
			.bodywrapper {
				width: 1015px !important;
			}
			.contentwrapper {
				padding: 20px;
			}
		</style>';
	}

	private function viewMenu(){
		echo '<div class="toolbar">'.
		'<a href="' . $this->core->conf['conf']['path'] . '/claim/manage">Manage Claims</a>'.
		'<a href="' . $this->core->conf['conf']['path'] . '/claim/new">Add</a>';
		if($this->core->role == 1000){
			echo '<a href="' . $this->core->conf['conf']['path'] . '/claim/report">Report</a>';
		}
		echo '</div>';
	}


	public function showClaim($item) {

		$this->viewMenu();
		$userid = $this->core->userID;
		$editable = $this->core->cleanGet['edit'];
		
		
		if($this->core->role == 1000 && $item != 'hidden'){
			$sql = "SELECT a.ID,b.ID AS ItemID,a.Status,a.CreatedDate,d.Name as Course,CONCAT(c.Name,'-(K ',c.Rate,')') as Category,CONCAT(e.FirstName,' ',e.Surname) as Lname, (b.NumberOfStudents * c.Rate)
					Claim,a.ApproverOne,a.ApproverTwo,a.ApproverThree,b.NumberOfStudents
					FROM claims a, `claim-items` b,`claim-category` c,courses d,`basic-information` e
					WHERE a.`Status`  IN ('Pending', 'Entry')
					AND a.ID=b.ClaimID
					AND a.ID = '$item'
					AND b.CategoryID=c.ID
					AND b.CourseID=d.ID
					AND a.UserID=e.ID
					ORDER BY CreatedDate";

		}

		$run = $this->core->database->doSelectQuery($sql);

		if(!isset($this->core->cleanGet['offset'])){
			echo'<table id="results" class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th bgcolor="#EEEEEE" width="30px"></th>
					<th bgcolor="#EEEEEE" width=""><b>Item</b></th>
					<th bgcolor="#EEEEEE" width="70px"><b>Course</b></th>
					<th bgcolor="#EEEEEE" width="70px"><b>Students</b></th>
					<th bgcolor="#EEEEEE" width="120px"><b>Date/Time</b></th>
					<th bgcolor="#EEEEEE" width="70px"><b>Claim</b></th>
					<th bgcolor="#EEEEEE" width="180px"><b>Status</b></th>
				</tr>
			</thead>
			<tbody>';
		}


		while ($row = $run->fetch_assoc()) {
			$results == TRUE;

			$id = $row['ID'];
			$itemID = $row['ItemID'];
			$date = $row['CreatedDate'];
			$numberOfStudents = $row['NumberOfStudents'];
			$course = $row['Course'];
			$claimcategory = $row['Category'];
			$author = $row['Lname'];
			$claim = $row['Claim'];
			$status = $row['Status'];
			$hod = $row['ApproverOne'];
			$dean = $row['ApproverTwo'];
			$dvc = $row['ApproverThree'];
			$person="";
			
			if($editable == TRUE){
				$status = '<b><a href="'. $this->core->conf['conf']['path'] .'/claim/edit/'.$itemID.'">Edit</a></b> <br>
				<a href="'. $this->core->conf['conf']['path'] .'/claim/delete/'.$itemID.'">Cancel</a> <br>';
			}
								
			echo'<tr>
				<td><img src="'. $this->core->conf['conf']['path'] .'/templates/edurole/images/user.png"></td>
				<td> '.$claimcategory.'</td>
				<td> '.$course.'</td>
				<td> '.$numberOfStudents.'</td>
				<td> '.$date.'</td>
				<td> K'.$claim.'</td>
				<td> '.$status.'</td>
				</tr>';
			$totalClaim+=$claim;
			$results = TRUE;


		}
		
		echo'<tr>
					<td colspan=7>
					Author :'.$author.'
					<b>Total Claim: K'.$totalClaim.'</b>
					</td>
				</tr>';

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

	
	public function manageClaim($item) {

		$this->viewMenu();
		$userid = $this->core->userID;
		
		
		if($this->core->role == 1000 && $item != 'hidden'){
			$sql = "SELECT a.ID,a.Status,a.CreatedDate,CONCAT(d.Name,'-',c.Name)as Course,CONCAT(e.FirstName,' ',e.Surname) as Lname, SUM(b.NumberOfStudents * c.Rate) as Claim, a.UserID, a.ApproverOne,a.ApproverTwo,a.ApproverThree
					FROM claims a, `claim-items` b,`claim-category` c,courses d,`basic-information` e
					WHERE a.`Status`  IN ('Pending', 'Entry')
					AND a.ID=b.ClaimID
					AND b.CategoryID=c.ID
					AND b.CourseID=d.ID
					AND a.UserID=e.ID
					GROUP BY b.ClaimID
					ORDER BY CreatedDate";
		} else if ($this->core->role == 104 && $item != 'hidden'){
			$sql = "SELECT a.ID,a.Status,a.CreatedDate,CONCAT(d.Name,'-',c.Name)as Course,CONCAT(e.FirstName,' ',e.Surname) as Lname, SUM(b.NumberOfStudents * c.Rate) as Claim, a.UserID, a.ApproverOne,a.ApproverTwo,a.ApproverThree
					FROM claims a, `claim-items` b,`claim-category` c,courses d,`basic-information` e
					WHERE a.SchoolID IN(SELECT DISTINCT(SchoolID) FROM staff WHERE EmployeeNo='$userid')
					AND a.ID=b.ClaimID
					AND b.CategoryID=c.ID
					AND b.CourseID=d.ID
					AND a.UserID=e.ID
					GROUP BY b.ClaimID
					ORDER BY CreatedDate";
		}else if ($this->core->role == 100 && $item != 'hidden'){
			$sql = "SELECT a.ID,a.Status,a.CreatedDate,CONCAT(d.Name,'-',c.Name)as Course,CONCAT(e.FirstName,' ',e.Surname) as Lname, SUM(b.NumberOfStudents * c.Rate) as Claim, a.UserID, a.ApproverOne,a.ApproverTwo,a.ApproverThree
					FROM claims a, `claim-items` b,`claim-category` c,courses d,`basic-information` e
					WHERE a.UserID ='$userid'
					AND a.ID=b.ClaimID
					AND b.CategoryID=c.ID
					AND b.CourseID=d.ID
					AND a.UserID=e.ID
					GROUP BY b.ClaimID
					ORDER BY CreatedDate";
		}else{
			$sql = "SELECT a.ID,a.Status,a.CreatedDate,CONCAT(d.Name,'-',c.Name)as Course,CONCAT(e.FirstName,' ',e.Surname) as Lname, SUM(b.NumberOfStudents * c.Rate) as Claim, a.UserID, a.ApproverOne,a.ApproverTwo,a.ApproverThree
					FROM claims a, `claim-items` b,`claim-category` c,courses d,`basic-information` e
					WHERE a.UserID ='$userid'
					AND a.ID=b.ClaimID
					AND b.CategoryID=c.ID
					AND b.CourseID=d.ID
					AND a.UserID=e.ID
					GROUP BY b.ClaimID
					ORDER BY CreatedDate";
		}

		$run = $this->core->database->doSelectQuery($sql);

		if(!isset($this->core->cleanGet['offset'])){
			echo'<table id="results" class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th bgcolor="#EEEEEE" width="30px"></th>
					<th bgcolor="#EEEEEE" width=""><b>Lecturer</b></th>
					<th bgcolor="#EEEEEE" width="70px"><b>Course</b></th>
					<th bgcolor="#EEEEEE" width="120px"><b>Date/Time</b></th>
					<th bgcolor="#EEEEEE" width="70px"><b>Claim</b></th>
					<th bgcolor="#EEEEEE" width="180px"><b>Status</b></th>
				</tr>
			</thead>
			<tbody>';
		}

		while ($row = $run->fetch_assoc()) {
			$results == TRUE;

			$id = $row['ID'];
			$date = $row['CreatedDate'];
			$course = $row['Course'];
			$author = $row['Lname'];
			$claim = $row['Claim'];
			$status = $row['Status'];
			$hod = $row['ApproverOne'];
			$dean = $row['ApproverTwo'];
			$dvc = $row['ApproverThree'];
			$lecturer = $row['UserID'];

			if($userid == $lecturer){
				$edit= '<a href="'. $this->core->conf['conf']['path'] .'/claim/show/'.$id.'?edit=TRUE">Edit claim</a>';
			} else {
				$edit= '<a href="'. $this->core->conf['conf']['path'] .'/claim/show/'.$id.'">View claim details</a>';
			}

			$person="";
			if($status == "Pending"){
				if(empty($hod)){
					$person='HOD';
				}else if(empty($dean)){
					$person='Dean';
				}else if(empty($dvc)){
					$person='DVC';
				}

				if($item != "hidden"){
					$status = '<b><a href="'. $this->core->conf['conf']['path'] .'/claim/approve/'.$id.'?person='.$person.'">Awaiting '.$person.' approval</a></b> <br>
					<a href="'. $this->core->conf['conf']['path'] .'/claim/delete/'.$id.'">Cancel</a> <br>
					Author: ' . $author;
				}
					
			} else {
				$status =  '<b>' . $status . '</b><br> Author: ' .$author;
			}
								
			echo'<tr>
				<td><img src="'. $this->core->conf['conf']['path'] .'/templates/edurole/images/user.png"></td>
				<td> '.$author.' <br> '.$edit.'</td>
				<td> '.$course.'</td>
				<td> '.$date.'</td>
				<td> K'.$claim.'</td>
				<td> '.$status.'</td>
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
	public function newClaim($item) {

		if($item != ''){
			$this->manageClaim("hidden");
		} else {
			$this->viewMenu();
		}


		$userid = $this->core->userID;
		
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";

		$select = new optionBuilder($this->core);
		$courses = $select->showCourses(NULL);


		$schools = $select->showSchools(null);
		$periods = $select->showPeriods(null);
		$claims = $select->showClaimcategory(null);

		if($item == ''){
			$button = 'Create Claim';
		} else {
			$button = 'Update Claim';
			$submit = '</p><button onclick="' . $this->core->conf['conf']['path'] .'/claims/submit/'.$item.'" class="submit">FINALIZE SUBMISSION</button>';
		}

		include $this->core->conf['conf']['formPath'] . "newclaim.form.php";
	
	}
	public function newlectureingClaim($item) {

		//if($item != ''){
		//	$this->manageClaim("hidden");
		//} else {
			$this->viewMenu();
		//}


		$userid = $this->core->userID;
		
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";

		$select = new optionBuilder($this->core);
		$courses = $select->showCourses(NULL);


		$schools = $select->showSchools(null);
		$periods = $select->showPeriods(null);
		$claims = $select->showClaimcategory(null);

		if($item == ''){
			$button = 'Create Claim';
		} else {
			$button = 'Update Claim';
			$submit = '</p><button onclick="' . $this->core->conf['conf']['path'] .'/claims/submit/'.$item.'" class="submit">FINALIZE SUBMISSION</button>';
		}

		include $this->core->conf['conf']['formPath'] . "newlectureingclaim.form.php";
	
	}
	public function editClaim($item) {

		$userid = $this->core->userID;
		$sql = "SELECT * FROM `claim-items` WHERE ID = '$item' AND `Status` = 'Entry'";
		$run = $this->core->database->doSelectQuery($sql);
		while ($row = $run->fetch_assoc()) {
			$id = $row['ID'];
		}
			
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";

		$select = new optionBuilder($this->core);
		$courses = $select->showCourses(NULL);
		$schools = $select->showSchools(null);
		$periods = $select->showPeriods(null);
		$claims = $select->showClaimcategory(null);

		if($item == ''){
			$button = 'Create Claim';
		} else {
			$button = 'Update Claim';
			//$submit = '</p><button onclick="' . $this->core->conf['conf']['path'] .'/claims/submit" class="submit">FINALIZE SUBMISSION</button>';
		}

		include $this->core->conf['conf']['formPath'] . "editclaim.form.php";
	
	}

	public function submitClaim($item) {

		$sql = "UPDATE `claims` SET `Status`='Pending' WHERE `ID` = '$item';";
		$this->core->database->doInsertQuery($sql);

		return;
	
	}

	public function saveClaimItem($item) {

		$userid   = $this->core->userID;

		$course     = $this->core->cleanPost['course'];
		$students   = $this->core->cleanPost['students'];
		$mode       = $this->core->cleanPost['delivery'];
		$category   = $this->core->cleanPost['category']; 

		$sql = "INSERT INTO `claim-items` SELECT NULL, '$item', '$category', '$course', '$mode', '$students', `Rate` FROM `claim-category` WHERE `ID` = '$category'";
		$this->core->database->doInsertQuery($sql);

		return;
	}

	public function saveClaim($item) {

		$userid = $this->core->userID;
		$school = $this->core->cleanPost['school'];
		$period = $this->core->cleanPost['period'];
		$name   = $this->core->cleanPost['name'];


		if($item == ""){
			$sql = "INSERT INTO `claims` (`ID`, `UserID`, `Status`, `CreatedDate`, `ConfirmDate`, `SchoolID`, `ApproverOne`, `ApproverTwo`, `ApproverThree`, `ApproverOneDate`, `ApproverTwoDate`, `ApproverThreeDate`, `Username`, `PeriodID`) 
			VALUES (NULL, '$userid', 'Entry', NOW(), NULL, '$school', NULL, NULL, NULL, NULL, NULL, NULL, '$name', '$period');";
			$this->core->database->doInsertQuery($sql);
	
			echo '<span class="successpopup">You claim has been added</span>';
	
			$sql = "SELECT `ID` FROM `claims` WHERE `UserID` = '$userid' AND `Status` = 'Entry'";
			$run = $this->core->database->doSelectQuery($sql);
			while ($row = $run->fetch_assoc()) {
				$cid = $row['ID'];
			}

			$this->saveClaimItem($cid);
		} else {
			$this->saveClaimItem($item);
		}

		
		$this->newClaim($cid);
	}


	public function approveClaim($item) {

		$this->viewMenu();
		$userid = $this->core->userID;
	
	}	
	
	public function approveviewClaim($item) {

		$this->viewMenu();
		$userid = $this->core->userID;
		$status = '<b><a href="'. $this->core->conf['conf']['path'] .'/claim/approve/'.$id.'?person='.$person.'">Awaiting '.$person.' approval</a></b> <br>
					<a href="'. $this->core->conf['conf']['path'] .'/claim/delete/'.$id.'">Cancel</a> <br>
					Author: ' . $author;
		
	
	}
	public function deleteClaim($item) {

		$this->viewMenu();
		$userid = $this->core->userID;
	
	}
	public function reportClaim($item) {

		$this->viewMenu();
		$userid = $this->core->userID;
	
	}



	public function getPeriod(){
		$d1=new DateTime("NOW");
		$data_now= (int)$d1->format("Y");
		$date_year = (int)$d1->format("Y");
		$date_month = (int)$d1->format("m");
	
		$p_year=$date_year+1;
		$m_year=$date_year-1;
		$_academicyear1=""; 
		$_semester1=""; 
		if($date_month >=7){
			$year =$date_year."/".$p_year; 
			$semester ="Semester I";
		}else if($date_month <=6){
			$year = $m_year."/".$date_year; 
			$semester = "Semester II";
		}

		$sql = "SELECT * FROM `periods` WHERE `Year` = '$year' AND `Name` = '$semester'";
		$run = $this->core->database->doSelectQuery($sql);

		while ($fetch = $run->fetch_assoc()) {
			$item = $fetch['ID'];
		}
		return $item;
	}

	private function getDates(){
		$d1=new DateTime("NOW");
		$data_now= (int)$d1->format("Y");
		$date_year = (int)$d1->format("Y");
		$date_month = (int)$d1->format("m");
	
		$p_year=$date_year+1;
		$m_year=$date_year-1;
		$_academicyear1=""; 
		$_semester1=""; 
		if($date_month >=7){
			$dates['academicyear'] = $date_year."/".$p_year; 
			$dates['semester'] = "Semester I";
		}else if($date_month <=6){
			$dates['academicyear'] = $m_year."/".$date_year; 
			$dates['semester'] = "Semester II";
		}

		return $dates;
	}
	
}

?>
