<?php
class loans{

	public $core;
	public $view;

	public function configView() {
		$this->view->header = FALSE;
		$this->view->footer = FALSE;
		$this->view->menu = FALSE;
		$this->view->javascript = array();
		$this->view->css = array();

		return $this->view;
	}

	public function buildView($core) {
		$this->core = $core;
	}
	
	private function viewMenu($item, $phone){
		if($this->core->role != 107 && $this->core->role != 104 && $this->core->role != 1000 ){
			echo '<div class="toolbar">'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/request">Request Leave</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/approval">Leave Approval</a>'.
			'</div>';
		}else{
			echo'<div class="toolbar">'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/show">Manage Employees</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/departments/manage">Manage Departments</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/positions/manage">Manage Establishment</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/approval">Leave Management</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/show/expiring">Expiring Contracts</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/performance/manage">Performance Appraisals</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/loans/manage">Loan Management</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/claim/manage">Claim Management</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/sms/new/'.$phone.'">Message staff</a>'.
			'</div>';
		}
	}
	
	public function approvalLoans($item) {

		$departmentsManager = $this->getManager();
		
		$this->viewMenu($item, NULL);

		$item = $this->core->userID;
		$role = $this->core->role;

		$sql = "SELECT * FROM `departments` WHERE `Manager` = '$item'";
		$run = $this->core->database->doSelectQuery($sql);
		if($run->num_rows > 0){
			$hod = TRUE;
		}
		
		echo'<div class="toolbar" style="clear: left; ">'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/request/" class="green">New Leave Request</a>'.
		'</div>';

		if($this->core->role != 107 && $this->core->role != 104 || $hod == TRUE){

			if($hod == TRUE){
				// HOD DEPARTMENT
				$sql = "SELECT `basic-information`.FirstName,`basic-information`.Surname,`leave`.EmployeeNo,`leave`.Description, `leave`.StartDate,`leave`.EndDate,`leave`.Status,`leave`.ID AS ID, `leavetypes`.Name
				FROM `leave`, `basic-information`, `departments`, `leavetypes`
				WHERE `basic-information`.ID = `leave`.`EmployeeNo`
				AND `leave`.`Status` != '100'
				AND `leave`.`Type` = `leavetypes`.ID
				AND `basic-information`.ID != '$item'
				AND `departments`.`Manager` = '$item'";
			}else{
				$sql = "SELECT `basic-information`.FirstName,`basic-information`.Surname,`leave`.EmployeeNo,`leave`.Description,
		   		`leave`.StartDate,`leave`.EndDate,`leave`.Status,`leave`.ID AS ID, `leavetypes`.Name
				FROM `leave`, `basic-information`, `leavetypes`
				WHERE `basic-information`.ID = `leave`.EmployeeNo 
				AND `leave`.`Status` != '100'
				AND `leave`.`Type` = `leavetypes`.ID
				AND `basic-information`.ID = '$item'";
			}

		}else{

			$sql = "SELECT `basic-information`.FirstName,`basic-information`.Surname,`leave`.EmployeeNo,`leave`.Description,
		    	`leave`.StartDate,`leave`.EndDate,`leave`.Status,`leave`.ID AS ID, `leavetypes`.Name
				FROM `leave`, `basic-information`, `leavetypes`
				WHERE `basic-information`.ID = `leave`.EmployeeNo 
				AND `leave`.`Type` = `leavetypes`.ID
				AND `basic-information`.ID != '$item'
				AND `leave`.`Status` != '100'";
		}



		$run = $this->core->database->doSelectQuery($sql);

		echo'<table id="messages" class="table table-bordered  table-hover">
			<thead>
				<tr>
					<th bgcolor="#EEEEEE" width="130px"><b>Employee No.</b></th>
					<th bgcolor="#EEEEEE" width=""><b>Employee Requesting Leave</b></th>
					<th bgcolor="#EEEEEE" width=""><b>Leave Type</b></th>
					<th bgcolor="#EEEEEE">Description</th>
					<th bgcolor="#EEEEEE" width="100px"><b>Start leave</b></th>
					<th bgcolor="#EEEEEE" width="100px"><b>End leave</b></th>
					<th bgcolor="#EEEEEE" width="150px">Status</th>
				</tr>
			</thead>
			<tbody>';

		if($run->num_rows == 0){
			echo'<div class="warningpopup">No leave requests currently made, PLEASE CLICK ON REQUEST LEAVE TO START A NEW REQUEST</div>';
		}

		while ($fetch = $run->fetch_assoc()) {
			$name = $fetch['FirstName'] . ' ' . $fetch['Surname'];
			$employeeid = $fetch['EmployeeNo'];
			$description = $fetch['Description'];
			$start = $fetch['StartDate'];
			$end = $fetch['EndDate'];
			$status = $fetch['Status'];
			$type = $fetch['Name'];
			$id = $fetch['ID'];
				
		
        if($status==0){
				$status= '<b><a href="' . $this->core->conf['conf']['path'] . '/staff/process/?ID='.$id.'&Status=approved"> Approve</a></b> |'.
				
                          '<b><a href="' . $this->core->conf['conf']['path'] . '/staff/process/?ID='.$id.'&Status=rejected"> Reject</a></b>';
              
		} elseif($status ==1){
			
			$status= 'Approved';
			}
            elseif($status ==2){
				
				$status= 'Rejected';
			}    
 
			echo'<tr>
				<td>'.$employeeid.'</td>
				<td><b><a href="' . $this->core->conf['conf']['path'] . '/information/show">'.$name.'</a></b></td>
				<td>'.$type.'</td>
				<td>'.$description.'</td>
				<td>'.$start.'</td>
				<td>'.$end.'</td>
				<td>'.$status.'</td>
			</tr>';
		}

		echo'</table>';
		

	}

	public function requestLoans($item) {
		$uid = $this->core->cleanPost['staff'];
		$description = $this->core->cleanPost['description'];
		$duration = $this->core->cleanPost['duration'];

		$sql = "INSERT INTO `loans` (`ID`, `StaffID`, `LoanRequested`, `LoanType`, `LoanAccepted`, `FinanceApproval`, `DirectorApproval`, `LoanPeriod`, `LoanInterest`, `LoanRepaid`) 
		VALUES (NULL, '$uid', '$amount', '1', NULL, NULL, NULL, '.$duration.', NULL, NULL);";

		if($this->core->database->doInsertQuery($sql)){ 
			echo '<div class="successpopup">Loan Request Submitted</div>';
			$this->manageLoans('');
		} else {
			echo '<div class="errorpopup">ERROR: Loan request could not be submitted.</div>';
			$this->manageLoans('');
		}
	}

	public function addLoans($item) {
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
 
		$select = new optionBuilder($this->core);
		$staff = $select->showUsers(100);
		
		include $this->core->conf['conf']['formPath'] . "newloan.form.php";
	}
	
	public function advanceLoans($item) {
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
 
		$select = new optionBuilder($this->core);
		$staff = $select->showUsers(100);
		
		include $this->core->conf['conf']['formPath'] . "newadvance.form.php";
	}

	public function leaverequestLoans($item){
					
		$employeeno = $this->core->userID;
		$start = $this->core->cleanPost['start'];
		$end = $this->core->cleanPost['end'];
		$description = $this->core->cleanPost['description'];
		$type = $this->core->cleanPost['type'];
		
		echo'<div class="toolbar">'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/approval/" class="green">Back to Overview</a>'.
		'</div>';
		
		$uid = $this->core->userID;
		$sql = "SELECT `Leavedays`, `DaysRequired` 
		FROM `staff`, `leavetypes`
		WHERE `leavetypes`.ID = '$type'
		AND `staff`.`ID` = '$uid'";
		$run = $this->core->database->doSelectQuery($sql);
		while ($fetch = $run->fetch_assoc()) {
			$leavedays = $fetch['Leavedays'];
			$required = $fetch['DaysRequired'];
		}
		


		$total = $this->getWorkdays($start, $end);
		
		if($leavedays < $total && $required == 1){
			echo '<div class="errorpopup">You currently do not have sufficient leave days. Your current days are: '.$leavedays.' Days. Your request cannot be saved!</div>';
			return;
		}

		$sql = "INSERT INTO `leave` (`ID`, `EmployeeNo`, `StartDate`, `EndDate`, `Type`, `Description`, `Total`, `Status`, `Comment`, `DateRequested`) 
				VALUES (NULL, '$employeeno', '$start', '$end', '$type', '$description', '$total', '0', '', NOW());";

       if($this->core->database->doInsertQuery($sql)){
			echo '<div class="successpopup">Your leave request was submitted to your HOD for approval</div>';
			$this->approvalLoans('');
	   } else {
		   	echo '<div class="errorpopup">ERROR: Your leave request was  NOT submitted.</div>';
			$this->approvalLoans('');
	   }
	   
       $this->core->redirect("approval", "show", $item);
	}

	
	public function processLoans($item){
		
		if(isset($_GET['Status'] )) {
			$id = $this->core->userID;
			$id = $this->core->cleanGet['ID'];
			$status = $this->core->cleanGet['Status'];

			if ($status == 'approved'){
				$sql = "UPDATE `leave` SET `Status` = 1 WHERE `leave`.`ID` = '$id'";
				if($this->core->database->doInsertQuery($sql)){
					echo '<div class="successpopup">Request has been approved</div>';
					$this->approvalLoans('');
				} else {
					echo '<div class="errorpopup">Request could not be approved</div>';
					$this->approvalLoans('');
				}
			}elseif($status == 'rejected'){
				$sql = "UPDATE `leave` SET `Status` = 2 WHERE leave.ID = '$id'";
				if($this->core->database->doInsertQuery($sql)){
					echo '<div class="successpopup">Request has been rejected</div>';
					$this->approvalLoans('');
				} else {
					echo '<div class="errorpopup">Request could not be rejected</div>';
					$this->approvalLoans('');
				}
			}
		 }
	}
		 
	 
	 
	public function manageLoans($item) {
		$departmentsManager = $this->getManager();

		$this->viewMenu($item, NULL);

		
		$role = $this->core->role;
		
		if($role != '107' && $role != '1000'){ 
			$deps = implode("','", $departmentsManager);
			$filter = "HAVING `departments`.Name IN ('$deps')";
		}

		if($item !=''){
			$filter = "HAVING `departments`.ID = '$item'";
		}

		$sql = "SELECT *, `departments`.ID as DEPID , `positions`.JobTitle
		FROM `staff`
		LEFT JOIN `basic-information` ON `basic-information`.`ID` = `staff`.`EmployeeNo`
		LEFT JOIN `departments` ON `staff`.`SchoolID` = `departments`.`ID`
		LEFT JOIN `positions` ON `staff`.`JobTitle` = `positions`.`ID`
		WHERE `Status` = 'Employed'
		$filter 
		ORDER BY `Surname` ASC";
		


		$run = $this->core->database->doSelectQuery($sql);

		$i=0;
		while ($fetch = $run->fetch_assoc()) {
			$name = $fetch['FirstName'] . ' ' . $fetch['Surname'];
			$employeeid = $fetch['EmployeeNo'];
			$grade = $fetch['Grade'];
			$doe = $fetch['EmploymentDate'];
			$eoe = $fetch['EndDate'];
			$leave = $fetch['Leavedays'];
			$department = $fetch['Name'];
			$departmentID = $fetch['DEPID'];
			$position = $fetch['JobTitle'];
			
			if($i ==0){
				if($item !=''){
					echo '<div class="studentname">'.$department.'</div>';
				}
				
						
				echo'<div class="toolbar" style="clear:both;">'.
					'<a href="' . $this->core->conf['conf']['path'] . '/loans/advance" class="green">New Salary Advance</a>'.
					'<a href="' . $this->core->conf['conf']['path'] . '/loans/add" class="green">New Loan</a>'.
				'</div>';
			
				echo'<table id="messages" class="table table-bordered  table-hover">
				<thead>
					<tr>
						<th bgcolor="#EEEEEE" width="30px"><b>#</b></th>
						<th bgcolor="#EEEEEE" width="30px"><b>Employee No.</b></th>
						<th bgcolor="#EEEEEE" width=""><b>Name</b></th>
						<th bgcolor="#EEEEEE" width=""><b>Job Title</b></th>
						<th bgcolor="#EEEEEE" width=""><b>Department</b></th>
						<th bgcolor="#EEEEEE" width="70px"><b>Date of Employment</b></th>
						<th bgcolor="#EEEEEE" width="100px"><b>End of contract</b></th>
						<th bgcolor="#EEEEEE" width="80px">Grade</th>
						<th bgcolor="#EEEEEE" width="50px">Leave Days</th>
						<th bgcolor="#EEEEEE" width="150px">Manage</th>
					</tr>
				</thead>
				<tbody>';
			}

			$options = '<a href="' . $this->core->conf['conf']['path'] . '/user/edit/' . $employeeid . '">Edit</a> /
			<a href="' . $this->core->conf['conf']['path'] . '/performance/appraise/' . $employeeid . '">Appraise</a>';
			if($doe == ""){
				$doe = "NOT SET";
			}
			if($eoe == ""){
				$eoe = "NOT SET";
			}
			if($grade == ""){
				$grade = "NOT SET";
			}
			$i++;
			

			echo'<tr>
				<td>'.$i.'</td>
				<td>'.$employeeid.'</td>
				<td><b><a href="' . $this->core->conf['conf']['path'] . '/information/show/' . $employeeid . '">'.$name.'</a></b></td>
				<td><b>'.$position.'</b></td>
				<td><b><a href="' . $this->core->conf['conf']['path'] . '/staff/show/' . $departmentID . '">'.$department.'</a></b></td>
				<td>'.$doe.'</td>
				<td>'.$eoe.'</td>
				<td>'.$grade.'</td>
				<td>'.$leave.'</td> 
				<td>'.$options.'</td>
			</tr>';
			
			$set= TRUE;
		}

		echo'</table>';
		
		if($set != TRUE){
			echo '<br><br><div style="clear:both;" class="warningpopup">No results at the moment</div>';
		}

	}

		
	private function getManager(){
		
		// GET MANAGER / DEPARTMENT STATUS
		$uid = $this->core->userID;
		$sql = "SELECT * FROM `departments` WHERE `Manager` = $uid";
		$run = $this->core->database->doSelectQuery($sql);
		
		while ($fetch = $run->fetch_assoc()) {
			$departmentsManager[] = $fetch['Name'];
		}
		
		if(isset($departmentsManager)){
			$deps = implode(', ', $departmentsManager);
			echo '<div class="itemheader"><b>You are manager for: '.$deps.'</b></div>';
		}
		
		return $departmentsManager;
	}
}
?>