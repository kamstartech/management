<?php
class staff{

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
		if($this->core->role != 115  && $this->core->role != 107 && $this->core->role != 104 && $this->core->role != 1000 ){
			echo '<div class="toolbar">'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/request">Request Leave</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/approval">Leave Approval</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/leavereport/all">Leave Report</a>'.
			'</div>';
		}else{
			echo'<div class="toolbar">'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/show">Manage Employees</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/departments/manage">Manage Departments</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/positions/manage">Manage Establishment</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/approval">Leave Management</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/show/expiring">Expiring Contracts</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/loans/manage">Loan Management</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/claim/manage">Claim Management</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/sms/new/'.$phone.'">Message staff</a>'.
			'</div>';
		}
	}
	
	public function leavereportStaff($item) {

		$departmentsManager = $this->getManager();
		
		$this->viewMenu($item, NULL);

		$role = $this->core->role;

		$sql = "SELECT * FROM `departments` WHERE `Manager` = '$item'";
		$run = $this->core->database->doSelectQuery($sql);
		if($run->num_rows > 0){
			$hod = TRUE;
		}
		
		
		echo'<div class="toolbar" style="clear: left; ">'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/request/" class="green">New Leave Request</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/leavereport/all">Leave Report</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/approval/approved">All Approved Requests</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/approval/approved">All Rejected Requests</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/approval/pending">All Pending Requests</a>'.
		'</div>';
		
		if($item == 'all'){
			echo '<div class="successpopup">Showing leave report for all staff members who have taken leave</div>';
		}else if($item == 'pending'){
			$status = "		AND `leave`.`Status` LIKE '0'";
		} else {
			$status = "		AND `leave`.`Status` LIKE '2'";
		}

		$sql = "SELECT `departments`.ID as DID, `departments`.Name as DEPARTMENT, SUM(`leave`.`Total`) as USED, `staff`.LeaveDays as REMAINING, `basic-information`.FirstName,`basic-information`.Surname,`leave`.EmployeeNo,`leave`.Description, `leave`.StartDate,`leave`.EndDate,`leave`.Status,`leave`.ID AS ID, `leavetypes`.Name, `leave`.Total
		FROM `leave`, `basic-information`,`staff`, `positions`,`departments`, `leavetypes`
		WHERE `basic-information`.ID = `leave`.`EmployeeNo`
		AND `staff`.ID = `basic-information`.ID
		AND `positions`.ID = `staff`.JobTitle
		$status
		AND `positions`.DepartmentID = `departments`.ID
		AND `leave`.`Type` = `leavetypes`.ID
		GROUP BY `leave`.EmployeeNo";

	

		$run = $this->core->database->doSelectQuery($sql);
		
		
		
		$sql = "SELECT *, `departments`.ID as DID
		FROM `basic-information`,`departments`
		WHERE `basic-information`.ID = `departments`.`Manager`";
	
		$runx = $this->core->database->doSelectQuery($sql);
		
		while ($fetch = $runx->fetch_assoc()) {
			$manager[$fetch['DID']] = $fetch['FirstName'] . ' ' . $fetch['MiddleName']. ' ' . $fetch['Surname'];
		}

		echo'<table id="messages" class="table table-bordered  table-hover">
			<thead>
				<tr>
					<th bgcolor="#EEEEEE" width="130px"><b>Employee No.</b></th>
					<th bgcolor="#EEEEEE" width="330px"><b>Employee Name.</b></th>
					<th bgcolor="#EEEEEE" width="150px"><b>Leave days taken</b></th>
					<th bgcolor="#EEEEEE" width="150px"><b>Leave days remaining</b></th>
					<th bgcolor="#EEEEEE" width=""><b>Department Name</b></th>
				</tr>
			</thead>
			<tbody>';

		if($run->num_rows == 0){
			echo'<div class="warningpopup">No leave requests currently made, PLEASE CLICK ON REQUEST LEAVE TO START A NEW REQUEST</div>';
		}

		while ($fetch = $run->fetch_assoc()) {
			$name = $fetch['FirstName'] . ' ' . $fetch['MiddleName'] . ' ' . $fetch['Surname'];
			$employeeid = $fetch['EmployeeNo'];
			$used = $fetch['USED'];
			$remaining = $fetch['REMAINING'];
			$department = $fetch['DEPARTMENT'];
			$departmentid = $fetch['DID'];
			$id = $fetch['ID'];
				
		
			if($manager[$departmentid] == ''){
				$manager[$departmentid] = 'NO MANAGER SET';
			}
			
			echo'<tr>
				<td>'.$employeeid.'</td>
				<td><b><a href="' . $this->core->conf['conf']['path'] . '/information/show">'.$name.'</a></b></td>
				<td>'.$used.'</td>
				<td>'.$remaining.'</td>
				<td>'.$department.' ('.$manager[$departmentid].')</td>
			</tr>';
		}

		echo'</table>';
		

	}
	
	public function approvalStaff($item) {
		$departmentsManager = $this->getManager();
		
		$this->viewMenu($item, NULL);

		if($item != ''){	
			$list = $item;
		}
		
		$item = $this->core->userID;
		$role = $this->core->role;

		$sql = "SELECT * FROM `departments` WHERE `Manager` = '$item'";
		$run = $this->core->database->doSelectQuery($sql);
		if($run->num_rows > 0){
			$hod = TRUE;
		}
		
		echo'<div class="toolbar" style="clear: left; ">'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/request/" class="green">New Leave Request</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/leavereport/all">Leave Report</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/approval/approved">All Approved Requests</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/staff/approval/pending">All Pending Requests</a>'.
		'</div>';
		
		if($this->core->role == 107 && $list == 'pending' || $this->core->role == 1000 && $list == 'pending'){
			$sql = "SELECT `basic-information`.FirstName,`basic-information`.Surname,`leave`.EmployeeNo,`leave`.Description, `leave`.StartDate,`leave`.EndDate,`leave`.Status,`leave`.ID AS ID, `leavetypes`.Name, `leave`.Total
					FROM `leave`, `basic-information`,`staff`, `positions`,`departments`, `leavetypes`
					WHERE `basic-information`.ID = `leave`.`EmployeeNo`
					AND `leave`.`Status` IN (0)
					AND `staff`.ID = `basic-information`.ID
					AND `positions`.ID = `staff`.JobTitle
					AND `positions`.DepartmentID = `departments`.ID
					AND `leave`.`Type` = `leavetypes`.ID";
					
		} else if($this->core->role == 107 && $list == 'approved' || $this->core->role == 1000 && $list == 'approved'){
			$sql = "SELECT `basic-information`.FirstName,`basic-information`.Surname,`leave`.EmployeeNo,`leave`.Description, `leave`.StartDate,`leave`.EndDate,`leave`.Status,`leave`.ID AS ID, `leavetypes`.Name, `leave`.Total
					FROM `leave`, `basic-information`,`staff`, `positions`,`departments`, `leavetypes`
					WHERE `basic-information`.ID = `leave`.`EmployeeNo`
					AND `leave`.`Status` = '1'
					AND `staff`.ID = `basic-information`.ID
					AND `positions`.ID = `staff`.JobTitle
					AND `positions`.DepartmentID = `departments`.ID
					AND `leave`.`Type` = `leavetypes`.ID";		
		} else if($this->core->role == 107 && $list == 'rejected' || $this->core->role == 1000 && $list == 'rejected'){
			$sql = "SELECT `basic-information`.FirstName,`basic-information`.Surname,`leave`.EmployeeNo,`leave`.Description, `leave`.StartDate,`leave`.EndDate,`leave`.Status,`leave`.ID AS ID, `leavetypes`.Name, `leave`.Total
					FROM `leave`, `basic-information`,`staff`, `positions`,`departments`, `leavetypes`
					WHERE `basic-information`.ID = `leave`.`EmployeeNo`
					AND `leave`.`Status` = '2'
					AND `staff`.ID = `basic-information`.ID
					AND `positions`.ID = `staff`.JobTitle
					AND `positions`.DepartmentID = `departments`.ID
					AND `leave`.`Type` = `leavetypes`.ID";	
		} else {
				
			if($this->core->role != 107 && $this->core->role != 104 || $hod == TRUE){

				if($hod == TRUE){
					// HOD DEPARTMENT
					$sql = "SELECT `basic-information`.FirstName,`basic-information`.Surname,`leave`.EmployeeNo,`leave`.Description, `leave`.StartDate,`leave`.EndDate,`leave`.Status,`leave`.ID AS ID, `leavetypes`.Name, `leave`.Total
					FROM `leave`, `basic-information`,`staff`, `positions`,`departments`, `leavetypes`
					WHERE `basic-information`.ID = `leave`.`EmployeeNo`
					AND `leave`.`Status` != '100'
					AND `staff`.ID = `basic-information`.ID
					AND `positions`.ID = `staff`.JobTitle
					AND `positions`.DepartmentID = `departments`.ID
					AND `leave`.`Type` = `leavetypes`.ID
					AND `departments`.Manager  = '$item'";
				}else{
					$sql = "SELECT `basic-information`.FirstName,`basic-information`.Surname,`leave`.EmployeeNo,`leave`.Description, `leave`.StartDate,`leave`.EndDate,`leave`.Status,`leave`.ID AS ID, `leavetypes`.Name, `leave`.Total
					FROM `leave`, `basic-information`,`staff`, `positions`,`departments`, `leavetypes`
					WHERE `basic-information`.ID = `leave`.`EmployeeNo`
					AND `leave`.`Status` != '100'
					AND `staff`.ID = `basic-information`.ID
					AND `positions`.ID = `staff`.JobTitle
					AND `positions`.DepartmentID = `departments`.ID
					AND `leave`.`Type` = `leavetypes`.ID
					AND `leave`.EmployeeNo = '$item'";
					
				}

			}else{
					$sql = "SELECT `basic-information`.FirstName,`basic-information`.Surname,`leave`.EmployeeNo,`leave`.Description, `leave`.StartDate,`leave`.EndDate,`leave`.Status,`leave`.ID AS ID, `leavetypes`.Name, `leave`.Total
					FROM `leave`, `basic-information`,`staff`, `positions`,`departments`, `leavetypes`
					WHERE `basic-information`.ID = `leave`.`EmployeeNo`
					AND `leave`.`Status` != '100'
					AND `staff`.ID = `basic-information`.ID
					AND `positions`.ID = `staff`.JobTitle
					AND `positions`.DepartmentID = `departments`.ID
					AND `leave`.`Type` = `leavetypes`.ID
					AND `leave`.EmployeeNo = '$item'";
			}
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
					<th bgcolor="#EEEEEE" width="100px"><b>Total Days</b></th>
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
			$total = $fetch['Total'];
			$id = $fetch['ID'];
				
		
        if($status==0){
				$status= '<b><a href="' . $this->core->conf['conf']['path'] . '/staff/process/?ID='.$id.'&Status=approved&employee='.$employeeid.'&days='.$total.'"> Approve</a></b> |'.
				
                          '<b><a href="' . $this->core->conf['conf']['path'] . '/staff/process/?ID='.$id.'&Status=rejected"> Reject</a></b>';
              
		} elseif($status ==1){
			
			$status= 'Approved';
			}
            elseif($status ==2){
				
				$status= 'Rejected';
			}    
			
			if($employeeid == $item){
				$status = 'PENDING APPROVAL';
			}
 
			echo'<tr>
				<td>'.$employeeid.'</td>
				<td><b><a href="' . $this->core->conf['conf']['path'] . '/information/show">'.$name.'</a></b></td>
				<td>'.$type.'</td>
				<td>'.$description.'</td>
				<td>'.$start.'</td>
				<td>'.$end.'</td>
				<td>'.$total.'</td>
				<td>'.$status.'</td>
			</tr>';
		}

		echo'</table>';
		

	}
	
	public function contractStaff($item) {
		$sql = "SELECT `contract-lines`.*
				FROM `contract-lines` 
				WHERE `contract-lines`.StaffID = '$item'
				AND `AccountCode` = 1";

		$run = $this->core->database->doSelectQuery($sql);
		$i=0;
		while ($fetch = $run->fetch_assoc()) {
			$category[$i] = $fetch['LineItem'];
			$AccountCode = $fetch['AccountCode'];
			$amount[$i] = $fetch['GrossAmount'];
			$taxed[$i] = $fetch['TaxCode'];
			$TaxAmount = $fetch['TaxAmount'];
			$NetAmount = $fetch['NetAmount'];
			
			$i++;
		}
		
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
 
		$select = new optionBuilder($this->core);
		
		include $this->core->conf['conf']['formPath'] . "editcontract.form.php";
	}

	public function savecontractStaff($item){
		$category = $this->core->cleanPost['category'];
		$taxed = $this->core->cleanPost['taxed'];
		$amount = $this->core->cleanPost['amount'];
		$monthly = $this->core->cleanPost['monthly'];

		$totalpay = array_sum($amount);
	
		echo "<h1>Calculating taxes</h1>";
		$i=0;
		$set = FALSE;
		$basicTaxed = FALSE;
		$taxamount = 0;
		foreach($category as $curcategory){
			$curcat = $curcategory;
			$grossamount = $amount[$i];
			$taxcode = $taxed[$i];
			$taxcoded = $taxed[$i];
			
			
			if($taxcode != ''){
				$taxcode = explode(',', $taxcode);
			}
			
			foreach($taxcode as $tax){
				$sql = "SELECT * FROM `tax-bands` WHERE `TaxCategory` = '$tax'";
				$run = $this->core->database->doSelectQuery($sql);
				while ($fetch = $run->fetch_assoc()) {
					$taxamount = 0;
					$AmountLow = $fetch['AmountLow'];
					$AmountHigh = $fetch['AmountHigh'];
					$Percentage = $fetch['Percentage'];
					$taxedon = $fetch['Taxed'];
				
					if($taxedon == 1 && $curcat == 'Basic Pay' ){
						//TAX TOTAL GROSS PAY 
									
						if($tax == "NAPSA"){
							if ($totalpay < 22992.01) {
								$taxamount = $totalpay/100*$Percentage;
							} else if($totalpay > 22992) {
								$taxamount = '1149.6';
							}

						} else{
							
							if($totalpay > $AmountLow && $totalpay > $AmountHigh){
								$taxamount = ($AmountHigh-$AmountLow)/100*$Percentage;
							}
							if($totalpay > $AmountLow && $totalpay < $AmountHigh){
								$taxamount = ($totalpay-$AmountLow)/100*$Percentage;
							}
							
						}
						
						$taxation[$tax] = $taxamount + $taxation[$tax];
						echo $tax . ' -  ' . $Percentage . '% -  ' . $taxamount . '<br>';
						$totaltax = $taxamount+$totaltax;

					}else if($taxedon == 0 && $curcat == 'Basic Pay'){
						//TAX BASIC PAY ONLY

						
						if($grossamount > $AmountLow && $grossamount > $AmountHigh){
							$taxamount = ($AmountLow-$AmountHigh)/100*$Percentage;
						}
						if($grossamount > $AmountLow && $grossamount < $AmountHigh){
							$taxamount = ($grossamount-$alreadytaxed)/100*$Percentage;
						}
			
						
						$taxation[$tax] = $taxamount + $taxation[$tax];
						
						echo $tax . ' -  ' . $Percentage . '% -  ' . $taxamount . '<br>';
						$totaltax = $taxamount+$totaltax;
					} 
				}

			}
			
			
			$i++;
			
			if($curcat != ''){
					
				$sql = "REPLACE INTO `contract-lines` (`ID`, `StaffID`, `LineItem`, `AccountCode`, `GrossAmount`, `TaxCode`, `TaxAmount`, `NetAmount`)
						VALUES (NULL, '$item', '$curcat', '1', '$grossamount', '$taxcoded', '$grossamount', '$grossamount');";
				
				
				if($this->core->database->doInsertQuery($sql)){
				} else {
					echo '<div class="errorpopup">ERROR: CONTRACT LINE NOT ENTERED.</div>';
				}
			}
			

		}
	
		foreach($taxation as $taxing => $tamount){
								
			$sql = "REPLACE INTO `contract-lines` (`ID`, `StaffID`, `LineItem`, `AccountCode`, `GrossAmount`, `TaxCode`, `TaxAmount`, `NetAmount`)
					VALUES (NULL, '$item', '$taxing', '2', '$tamount', '', '$tamount', '$tamount');";
			
			
			if($this->core->database->doInsertQuery($sql)){
			} else {
				echo '<div class="errorpopup">ERROR: CONTRACT LINE NOT ENTERED.</div>';
			}
		}
		
		echo "<b>TOTAL TAX: " . $totaltax ."</b>";
		
		echo '<div class="successpopup">CONTRACT LINES SAVED. <a href="/staff/show/">RETURN TO OVERVIEW</a></div>';
	}

	public function requestStaff($item) {
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
 
		$select = new optionBuilder($this->core);
		$staff = $select->showUsers(100);
		$leavetypes = $select->showLeave();
		
		include $this->core->conf['conf']['formPath'] . "requestleave.form.php";
	}

	public function leaverequestStaff($item){
		
		$employeeno = $this->core->cleanPost['staff'];
		if($employeeno == '') { $employeeno = $this->core->userID; }
		$start = $this->core->cleanPost['start'];
		$end = $this->core->cleanPost['end'];
		$description = $this->core->cleanPost['description'];
		$type = $this->core->cleanPost['type'];
		
		$sql = "SELECT `Leavedays`, `DaysRequired` 
		FROM `staff`, `leavetypes`
		WHERE `leavetypes`.ID = '$type'
		AND `staff`.`ID` = '$employeeno'";
		$run = $this->core->database->doSelectQuery($sql);
		while ($fetch = $run->fetch_assoc()) {
			$leavedays = $fetch['Leavedays'];
			$required = $fetch['DaysRequired'];
		}
		
		$total = $this->getWorkdays($start, $end);
		
		if($leavedays < $total && $required == 1){
			echo '<div class="warningpopup">You currently do not have sufficient leave days. Your current days are: '.$leavedays.' Days. Your leave days will become negative and taking future leave will be possible only after your days have been replenished!</div>';
			//	return;
		}

		$sql = "INSERT INTO `leave` (`ID`, `EmployeeNo`, `StartDate`, `EndDate`, `Type`, `Description`, `Total`, `Status`, `Comment`, `DateRequested`) 
				VALUES (NULL, '$employeeno', '$start', '$end', '$type', '$description', '$total', '0', '', NOW());";

		if($this->core->database->doInsertQuery($sql)){
			echo '<div class="successpopup">Your leave request was submitted to your HOD for approval</div>';
			$this->approvalStaff('');
	   } else {
		   	echo '<div class="errorpopup">ERROR: Your leave request was  NOT submitted.</div>';
			$this->approvalStaff('');
	   }
	   
       $this->core->redirect("approval", "show", $item);
	}

	public function processStaff($item){
		
		if(isset($_GET['Status'] )) {

			$employee = $this->core->cleanGet['employee'];
			$id = $this->core->cleanGet['ID'];
			$days = $this->core->cleanGet['days'];
			$status = $this->core->cleanGet['Status'];

			if ($status == 'approved'){
				$sql = "UPDATE `staff` SET `LeaveDays` = `LeaveDays`-$days WHERE `ID` = '$employee'";
				if($this->core->database->doInsertQuery($sql)){
					echo '<div class="successpopup">Leave days updated</div>';
				}
				
				$sql = "UPDATE `leave` SET `Status` = 1 WHERE `leave`.`ID` = '$id'";
				if($this->core->database->doInsertQuery($sql)){
					echo '<div class="successpopup">Request has been approved</div>';
					
					
				include $this->core->conf['conf']['viewPath'] . "sms.view.php";
				$sms = new sms($this->core);
				$sms->buildView($this->core);
				
				$sql = "SELECT * FROM `basic-information` WHERE `ID` = '$employee'";
						
				$run = $this->core->database->doSelectQuery($sql);
				while ($fetch = $run->fetch_assoc()) {
					$name = $fetch['FirstName']. ' ' . $fetch['Surname'];
					$celphone = $fetch['MobilePhone'];
							
					$runx = $this->core->database->doSelectQuery($sql);
					while ($fetchx = $runx->fetch_assoc()) {
						$courses[] = $fetchx['Name'];
					}
					
					$courses = implode(',', $courses);
					
					if ($celphone != '') {
						$sms->directSms($celphone, "Dear $name your leave request has been approved. Number of Days: $days", $this->core->username);
					}
				}
					
					$this->approvalStaff('');
				} else {
					echo '<div class="errorpopup">Request could not be approved</div>';
					$this->approvalStaff('');
				}
			}elseif($status == 'rejected'){
				$sql = "UPDATE `leave` SET `Status` = 2 WHERE leave.ID = '$id'";
				if($this->core->database->doInsertQuery($sql)){
					echo '<div class="successpopup">Request has been rejected</div>';
					$this->approvalStaff('');
				} else {
					echo '<div class="errorpopup">Request could not be rejected</div>';
					$this->approvalStaff('');
				}
			}
		 }
	}
	
	public function addStaff($item){
		
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
 
		$select = new optionBuilder($this->core);
		$staff = $select->showUsers(100);
		$leavetypes = $select->showLeave(); 
		$departments = $select->showDepartments(); 
		
		$users = $select->showUsers(100); 
		$positions = $select->showPositions(); 
		
		include $this->core->conf['conf']['formPath'] . "addstaff.form.php";
	}

	public function saveStaff($item) {
		$uid = $this->core->userID;
		$manager = $this->core->cleanPost['managed'];
		$position = $this->core->cleanPost['position'];
		$user = $this->core->cleanPost['user'];
		$idx = $this->core->cleanPost['idx'];
		
		if($user == ''){
			return;
		}
		
		$sql = "UPDATE `basic-information` SET `Status` = 'Employed' WHERE `ID` = '$user'";
		$this->core->database->doInsertQuery($sql);
		
		$sql = "REPLACE INTO `staff` (`ID`, `EmployeeNo`, `JobTitle`, `Manager`)
			    VALUES ($user, '$idx', '$position', '$manager');";

		if($this->core->database->doInsertQuery($sql)){
			echo '<div class="successpopup">Staff Created</div>';
			$this->showStaff('');
		} else {
			echo '<div class="errorpopup">ERROR: Staff could not be added.</div>';
			$this->showStaff('');
		}
	}
	
	public function showStaff($item) {
		$departmentsManager = $this->getManager();

		$this->viewMenu($item, NULL);
		$role = $this->core->role;
		
		if($role != '115' && $role != '107' && $role != '1000'){ 
			$deps = implode("','", $departmentsManager);
			$filter = "HAVING `departments`.Name IN ('$deps')";
		}

		if($item !=''){
			$filter = "HAVING `departments`.ID = '$item'";
		}

		if($this->core->item == 'retired'){
			$sql = "SELECT *, `departments`.ID as DEPID, `positions`.JobTitle, `staff`.JobTitle as JT, `staff`.ID as UID
			FROM `basic-information`
			LEFT JOIN `staff` ON `basic-information`.`ID` = `staff`.`ID`
			LEFT JOIN `departments` ON `staff`.`SchoolID` = `departments`.`ID`
			LEFT JOIN `positions` ON `staff`.`JobTitle` = `positions`.`ID`
			WHERE `Status` IN ('Retired', 'Fired', 'Deceased', 'Dismissed')
			ORDER BY `departments`.ID, `staff`.`EndDate`  ASC";
		}else if($this->core->item == 'expiring'){
			$sql = "SELECT *, `departments`.ID as DEPID, `positions`.JobTitle, `staff`.JobTitle as JT, `staff`.ID as UID
			FROM `basic-information`
			LEFT JOIN `staff` ON `basic-information`.`ID` = `staff`.`ID`
			LEFT JOIN `departments` ON `staff`.`SchoolID` = `departments`.`ID`
			LEFT JOIN `positions` ON `staff`.`JobTitle` = `positions`.`ID`
			WHERE `Status` = 'Employed'
			AND `EndDate`>= NOW() AND `EndDate` <= NOW() + INTERVAL 6 MONTH
			ORDER BY `departments`.ID, `staff`.`EndDate`  ASC";
		} else {
			$sql = "SELECT *, `departments`.ID as DEPID , `positions`.JobTitle, `staff`.JobTitle as JT, `staff`.ID as UID
			FROM `staff` 
			LEFT JOIN `basic-information` ON `basic-information`.`ID` = `staff`.`ID`
			LEFT JOIN `positions` ON `staff`.`JobTitle` = `positions`.`ID`
			LEFT JOIN `departments` ON `positions`.`DepartmentID` = `departments`.`ID`
			WHERE `Status` = 'Employed'
			$filter
			ORDER BY `departments`.ID, `Surname` ASC";
		}


		$run = $this->core->database->doSelectQuery($sql);

		$total = $run->num_rows;
		
		$i=0;
		while ($fetch = $run->fetch_assoc()) {
			$name = $fetch['FirstName'] . ' ' . $fetch['MiddleName'] . ' ' . $fetch['Surname'];
			$employeeid = $fetch['EmployeeNo'];
			$uid = $fetch['UID'];
			$grade = $fetch['Grade'];
			$doe = $fetch['EmploymentDate'];
			$eoe = $fetch['EndDate'];
			$leave = $fetch['Leavedays'];
			$department = $fetch['Name'];
			$departmentID = $fetch['DEPID'];
			$position = $fetch['JobTitle'];
			$positionNotcreated = $fetch['JT'];
			
			if($position == ''){
				$position = "</b><i>". $positionNotcreated . "</i><b>";
			}
			
			if($i ==0){
				if($item !=''){
					echo '<div class="studentname">'.$department.'</div>';
				}
				
				
						
				echo'<div class="toolbar" style="clear:both;">'.
					'<a href="' . $this->core->conf['conf']['path'] . '/users/add" class="green">Add New Staff Member</a>'.
					'<a href="' . $this->core->conf['conf']['path'] . '/staff/add" class="green">Add Existing User</a>'.
					'<a href="' . $this->core->conf['conf']['path'] . '/staff/show/retired" class="gray">Ex Employees</a>'.
					'<div class="toolbaritem">TOTAL EMPLOYEES: '.$total.'</div>'.
				'</div>';
			
				echo'<table id="messages" class="table table-bordered  table-hover">
				<thead>
					<tr>
						<th bgcolor="#EEEEEE" width="30px"><b>#</b></th>
						<th bgcolor="#EEEEEE" width="30px"><b>Employee No.</b></th>
						<th bgcolor="#EEEEEE" width=""><b>Name</b></th>
						<th bgcolor="#EEEEEE" width=""><b>Job Title</b></th>
						<th bgcolor="#EEEEEE" width="70px"><b>Date of Employment</b></th>
						<th bgcolor="#EEEEEE" width="100px"><b>End of contract</b></th>
						<th bgcolor="#EEEEEE" width="80px">Grade</th>
						<th bgcolor="#EEEEEE" width="50px">Leave Days</th>
						<th bgcolor="#EEEEEE" width="200px">Manage</th>
					</tr>
				</thead>
				<tbody>';
			}
			
			$nrm = '<script>
				function showMenu'.$i.'() {
				  $("#menu'.$i.'").toggleClass("d-none");
				}
			</script>';

			$options =   $nrm .'<div style="display: block" onclick="showMenu'.$i.'()"><b>SHOW OPTIONS</b></div>
			<div id="menu'.$i.'" class="d-none">
				<li><a href="' . $this->core->conf['conf']['path'] . '/information/edit/' . $uid . '">Edit Information</a> </li>
				<li><a href="' . $this->core->conf['conf']['path'] . '/load/manage/' . $uid . '">Course Load</a> </li>
				<li><a href="' . $this->core->conf['conf']['path'] . '/staff/contract/' . $uid . '">Remuneration</a> </li>
				<li><a href="' . $this->core->conf['conf']['path'] . '/payroll/manage/' . $uid . '">Payslips</a> </li>
				<li><a href="' . $this->core->conf['conf']['path'] . '/records/manage/' . $uid . '">Records</a> </li>
				<li><a href="' . $this->core->conf['conf']['path'] . '/registry/manage/' . $uid . '">Documents</a> </li>
				<li><a href="' . $this->core->conf['conf']['path'] . '/performance/appraise/' . $uid . '">Appraise Employee</a></li>
			<div>' ;
			
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
			
			if($department != $prevdepartment){
				echo '<tr style="background-color: #ccc;">
					<td colspan="10"><b><a href="' . $this->core->conf['conf']['path'] . '/staff/show/' . $departmentID . '">DEPARTMENT: '.$department.'</a></b></td>
				</tr>';
			}
			
			echo'<tr>
				<td>'.$i.'</td>
				<td>'.$employeeid.'</td>
				<td><b><a href="' . $this->core->conf['conf']['path'] . '/information/show/' . $uid . '">'.$name.'</a></b></td>
				<td><b>'.$position.'</b></td>
				<td>'.$doe.'</td>
				<td>'.$eoe.'</td>
				<td>'.$grade.'</td>
				<td>'.$leave.'</td> 
				<td>'.$options.'</td>
			</tr>';
			
			$prevdepartment = $department;
			$set= TRUE;
		}

		echo'</table>';
		
		if($set != TRUE){
			echo '<br><br><div style="clear:both;" class="warningpopup">No results at the moment</div>';
		}

	}
	
	private function getWorkdays($date1, $date2, $workSat = FALSE, $patron = NULL) {
	  if (!defined('SATURDAY')) define('SATURDAY', 6);
	  if (!defined('SUNDAY')) define('SUNDAY', 0);


	  // DEFINE HOLIDAYS HERE!!!!
	  $publicHolidays = array('01-01', '01-06', '04-25', '05-01', '06-02', '08-15', '11-01', '12-08', '12-25', '12-26');

	  if ($patron) {
	    $publicHolidays[] = $patron;
	  }
	  $yearStart = date('Y', strtotime($date1));
	  $yearEnd   = date('Y', strtotime($date2));
	  for ($i = $yearStart; $i <= $yearEnd; $i++) {
	    $easter = date('Y-m-d', easter_date($i));
	    list($y, $m, $g) = explode("-", $easter);
	    $monday = mktime(0,0,0, date($m), date($g)+1, date($y));
	    $easterMondays[] = $monday;
	  }
	  $start = strtotime($date1);
	  $end   = strtotime($date2);
	  $workdays = 0;
	  for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
	    $day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
	    $mmgg = date('m-d', $i);
	    if ($day != SUNDAY &&
	      !in_array($mmgg, $publicHolidays) &&
	      !in_array($i, $easterMondays) &&
	      !($day == SATURDAY && $workSat == FALSE)) {
	        $workdays++;
	    }
	  }
	  return intval($workdays);
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