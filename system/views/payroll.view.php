<?php
class payroll{

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
	

	public function processPayroll($item){
		
		$sql = "INSERT INTO `payroll` (`ID`, `StaffID`, `Date`, `RegistrarApproval`, `FinanceApproval`, `PostedDate`, `TotalPayable`, `LeaveDays`) 
		VALUES (NULL, '$staffid', NOW(), '1', '1', '2021-08-01 12:23:02.000000', '24115', '2');";
		if($this->core->database->doInsertQuery($sql)){
			$payrollid = $this->core->database->id();
		}
		
		$sql = "INSERT INTO `payroll-lines` (`ID`, `PayrollID`, `LineItem`, `AccountCode`, `GrossAmount`, `TaxCode`, `TaxAmount`, `NetAmount`) 
		VALUES (NULL, '$payrollid', '$linename, '$account', '$grossamount', '$taxcode', '$taxamount', '$netamount');";

		if($this->core->database->doInsertQuery($sql)){
			echo '<div class="successpopup">Request has been rejected</div>';
			$this->approvalPayroll('');
		} else {
			echo '<div class="errorpopup">Request could not be rejected</div>';
			$this->approvalPayroll('');
		}
		 
	}
	 
	 
	public function managePayroll($item) {
		echo '<h1>Payroll Overview</h1>';
		
		$sql = "SELECT *, `departments`.ID as DEPID , `positions`.JobTitle, `payroll`.ID as PAYID, YEAR(`payroll`.YearMonth) as year, MONTH(`payroll`.YearMonth) as month
		FROM `payroll` 
		LEFT JOIN `staff` ON `payroll`.`StaffID` = `staff`.`ID`
		LEFT JOIN `basic-information` ON `basic-information`.`ID` = `staff`.`EmployeeNo`
		LEFT JOIN `departments` ON `staff`.`SchoolID` = `departments`.`ID`
		LEFT JOIN `positions` ON `staff`.`JobTitle` = `positions`.`ID`
		WHERE `Status` = 'Employed'
		HAVING `basic-information`.ID = '$item'
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
			$payid = $fetch['PAYID'];
			
			$netpay = $fetch['TotalPayable'];
			$year = $fetch['year'];
			$month = $fetch['month'];
			
			$dateObj   = DateTime::createFromFormat('!m', $month);
			$monthName = $dateObj->format('F'); 
			
			if($i ==0){

				echo'<table id="messages" class="table table-bordered  table-hover">
				<thead>
					<tr>
						<th bgcolor="#EEEEEE" width="30px"><b>#</b></th>
						<th bgcolor="#EEEEEE" width="80px"><b>Emp. No.</b></th>
						<th bgcolor="#EEEEEE" width=""><b>Name</b></th>
						<th bgcolor="#EEEEEE" width=""><b>Period</b></th>
						<th bgcolor="#EEEEEE" width=""><b>Job Title</b></th>
						<th bgcolor="#EEEEEE" width=""><b>Department</b></th>
						<th bgcolor="#EEEEEE" width="80px">Grade</th>
						<th bgcolor="#EEEEEE" width="50px">Leave Days</th>
						<th bgcolor="#EEEEEE" width="150px">Net Salary</th>
						<th bgcolor="#EEEEEE" width="150px">View</th>
					</tr>
				</thead>
				<tbody>';
			}

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
				<td><b>'.$year.' - '.$monthName.'</b></td>
				<td><b>'.$position.'</b></td>
				<td><b><a href="' . $this->core->conf['conf']['path'] . '/staff/show/' . $departmentID . '">'.$department.'</a></b></td>
				<td>'.$grade.'</td>
				<td>'.$leave.'</td> 
				<td>K'.number_format($netpay,2).'</td> 
				<td><a href="' . $this->core->conf['conf']['path'] . '/payroll/payslip/' . $payid . '">View Payslip</a></td>
			</tr>';
			
			
			
			$set= TRUE;
		}

		echo'</table>';
		
		if($set != TRUE){
			echo '<br><br><div style="clear:both;" class="warningpopup">No results at the moment</div>';
		}

	}
	
	
	
	public function payslipPayroll($item) {

		$sql = "SELECT `staff`.`Grade`, SocialSecurity, TaxID, YEAR(`YearMonth`) as year, MONTH(`YearMonth`) as month , `basic-information`.FirstName,`basic-information`.Surname, `staff`.EmployeeNo, `staff`.`EmploymentDate`, `departments`.Name as Department, `positions`.JobTitle, `staff`.BankBranch, `staff`.Bank, `staff`.BankAccount, `staff`.Leavedays
			FROM `payroll`, `basic-information`, `staff`, `departments`, `positions` 
			WHERE `basic-information`.ID = `payroll`.StaffID
			AND `basic-information`.ID = `staff`.ID
			AND `departments`.ID = `staff`.SchoolID
			AND `staff`.JobTitle = `positions`.ID
			AND `payroll`.ID = '$item';";
			
		$run = $this->core->database->doSelectQuery($sql);
		
		while ($fetch = $run->fetch_assoc()) {
			$name = $fetch['FirstName'] . ' ' . $fetch['Surname'];
			$staffid = $fetch['EmployeeNo'];
			$start = $fetch['StartDate'];
			$bankaccount = $fetch['BankAccount'];
			$branch = $fetch['BankBranch'];
			$bank = $fetch['Bank'];
			$department = $fetch['Department'];
			$leave = $fetch['Leavedays'];
			$position = $fetch['JobTitle'];
			$year = $fetch['year'];
			$month = $fetch['month'];
			$napsa = $fetch['SocialSecurity'];
			$tpin = $fetch['TaxID'];
			$grade = $fetch['Grade'];

			$dateObj   = DateTime::createFromFormat('!m', $month);
			$monthName = $dateObj->format('F'); 
		}

		echo'<style>
			.table td  {
				padding: 4px !important;
			}
			.logoleft{ 
			    float: left;
				top: -13px;
				width: 122px;
				position: relative;
			}
			.rightnotice{ 
			    float: right;
			    width: 300px;
				font-size: 9px;
				top: -40px;
				position: relative;
			}
		</style>';

		echo '<div style="width: 100%;">
				<div  style="width: 800px; margin-left: auto; margin-right: auto; padding: 20px; border: 1px dashed #000;">
				<div style="padding-top: 10px;"><div class="logoleft"><img width="95" src="https://corelink.co.zm/management/templates/mobile/images/header.png"></div>
				<h1>EDEN UNIVERSITY</h1>
				<h2>Payslip for '.$monthName.' '.$year.'</h2></div>
				<div class="rightnotice">NOTE: Please contact the accounts payable department for any issues with your remumeration. This payslip may contain errors and Eden University is under no way or form legaly bound by the details specified herein.</div>
				
				<table id="messages" class="table table-sm  table-hover" style="padding: 4px !important;" >
				<tr>
					<td width="130px"><b>Employee No.:</b></td>
					<td width="130px">'.$staffid.'</td>
					<td width=""><b>Leave Days Accrued: </b></td>
					<td width="130px">'.$leave.'</td>
				</tr>
				<tr>
					<td width=""><b>Employee Name:</b></td>
					<td width="130px">'.$name.'</td>
					<td width="100px"><b>Bank Account</b></td>
					<td width="130px">'.$bankaccount.'</td>
				</tr>
				<tr>
					<td width=""><b>Position:</b></td>
					<td width="130px">'.$position.' ('.$grade.')</td>
					<td width="100px"><b>Bank</b></td>
					<td width="130px">'.$bank.'</td>
				</tr>
				<tr>
					<td width=""><b>Department: </b></td>
					<td width="130px">'.$department.'</td>
					<td width="150px"><b>Bank Branch</b></td>
					<td width="130px">'.$branch.'</td>
				</tr>
				<tr>
					<td width=""><b>NAPSA: </b></td>
					<td width="130px">'.$napsa.'</td>
					<td width="150px"><b>TPIN</b></td>
					<td width="130px">'.$tpin.'</td>
				</tr>
			</table>';
	

	// EARNINGS
		$sql = "SELECT * FROM `payroll-lines` WHERE `payroll-lines`.PayrollID = '$item' AND `AccountCode` = 1";

		$run = $this->core->database->doSelectQuery($sql);
		
		echo '<div style="padding: 5px; border: 1px solid #ccc; width: 50%; float: left; height: 200px;"> 
		<table class="table">
			<tr>
				<td><b>Earnings</b></td>
				<td align="right"><b>Amount</b></td>
			</tr>';
			
		$i=1;
		while ($fetch = $run->fetch_assoc()) {

			$category = $fetch['LineItem'];
			$amount = $fetch['GrossAmount'];
		
			echo'<tr>
				<td>'.$category.'</td>
				<td align="right">'.number_format($amount,2).'</td>
			</tr>';
			
			$totalamount = $amount+$totalamount;
			$i++;
		}
		
				
		echo'<tr>
			<td><b>TOTAL EARNINGS</b></td>
			<td align="right"><b>'.number_format($totalamount,2).'</b></td>
		</tr>';

		echo'</table></div>';
		
		
	// DEDUCTIONS
		$sql = "SELECT * FROM `payroll-lines` WHERE `payroll-lines`.PayrollID = '$item' AND `AccountCode` = 2";

		$run = $this->core->database->doSelectQuery($sql);
		
		echo '<div style="padding: 5px; border: 1px solid #ccc; width: 50%; float: left; height: 200px;"> 
		<table class="table">
			<tr>
				<td><b>Deductions</b></td>
				<td align="right"><b>Amount</b></td>
			</tr>';
			
		$i=1;
		$totaldeductions=0;
		while ($fetch = $run->fetch_assoc()) {

			$category = $fetch['LineItem'];
			$amount = $fetch['GrossAmount'];
		
			echo'<tr>
				<td>'.$category.'</td>
				<td align="right">'.number_format($amount,2).'</td>
			</tr>';
			
			$totaldeductions = $amount+$totaldeductions;
			$i++;
		}
		
				
		echo'<tr>
			<td><b>TOTAL DEDUCTIONS</b></td>
			<td align="right"><b>'.number_format($totaldeductions,2).'</b></td>
		</tr>';

		echo'</table></div>';
		
		
		$netpay = $totalamount-$totaldeductions;
		
		
		echo'<table class="table table-striped" style="margin-bottom: 0px !important; border: 1px solid #ccc;">
				<tr>
					<td width="25%"></td>
					<td width="25%"></td>
					<td ><b>TOTAL NET PAY</b></td>
					<td align="right"> <b>'.number_format($netpay,2).'<b></td>
				</tr>
		</table>';
		
		echo'</div>';
		echo'</div>';

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