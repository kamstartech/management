<?php
class positions{

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
			'<a href="' . $this->core->conf['conf']['path'] . '/loans/manage">Loan Management</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/claim/manage">Claim Management</a>'.
			'<a href="' . $this->core->conf['conf']['path'] . '/sms/new/'.$phone.'">Message staff</a>'.
			'</div>';
		}
	}
	
	public function addPositions($item) {
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
 
		$select = new optionBuilder($this->core);
		$staff = $select->showUsers(100);
		$leavetypes = $select->showLeave(); 
		$departments = $select->showDepartments(); 
		
		include $this->core->conf['conf']['formPath'] . "addposition.form.php";
	}	
	
	public function editPositions($item) {
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
		
		$sql = "SELECT `positions`.*,`departments`.Name, reporting.JobTitle as manager , `departments`.ID as DID 
			   FROM `positions`
			   LEFT JOIN `departments` ON `positions`.DepartmentID = `departments`.ID
			   LEFT JOIN `positions` as reporting ON `positions`.ReportsTo = reporting.ID
			   WHERE `positions`.ID = '$item'";
		$run = $this->core->database->doSelectQuery($sql);
		
		while ($fetch = $run->fetch_assoc()) {
			$pid = $fetch['ID'];
			$jobtitle = $fetch['JobTitle'];
			$description = $fetch['JobDescription'];
			$establishment = $fetch['Establishment'];
			$pay = $fetch['BasicPay'];
			$staffCount = $fetch['count'];
			$grade = $fetch['Grade'];
			$department = $fetch['DID'];
			$manager = $fetch['manager'];
			$leave = $fetch['LeaveDays'];
		}
		
		 
		$select = new optionBuilder($this->core);
		$staff = $select->showUsers(100);
		$leavetypes = $select->showLeave(); 
		$departments = $select->showDepartments($department); 
		
		
		include $this->core->conf['conf']['formPath'] . "addposition.form.php";
	}	
	
	public function savePositions($item) {
		$uid = $this->core->userID;
		$name = $this->core->cleanPost['name'];
		$manager = $this->core->cleanPost['managed'];
		$establishment = $this->core->cleanPost['establishment'];
		$grade = $this->core->cleanPost['grade'];
		$pay = $this->core->cleanPost['pay'];
		$department = $this->core->cleanPost['department'];
		$entitlement = $this->core->cleanPost['entitlements'];
		$type = $this->core->cleanPost['type'];
		$description = $this->core->cleanPost['description'];
		$leave = $this->core->cleanPost['leave'];
		
		if($item == ''){ $item = "NULL"; }

		$sql = "REPLACE INTO `positions` (`ID`, `JobTitle`, `JobDescription`, `Establishment`, `DateAdded`, `Grade`, `BasicPay`, `ContractType`, `DepartmentID`, `ReportsTo`, `Entitlements`,`LeaveDays`)
				VALUES ($item, '$name', '$description', '$establishment', NOW(), '$grade', '$pay', '$type', '$department', '$manager', '$entitlement', '$leave');";

		if($this->core->database->doInsertQuery($sql)){
			echo '<div class="successpopup">Position Created</div>';
			$this->managePositions('');
		} else {
			echo '<div class="errorpopup">ERROR: Position could not be added.</div>';
			$this->managePositions('');
		}
	   
	}	
	
	public function deletePositions($item) {
		$sql = "DELETE FROM `positions` WHERE `ID` = '$item'";
		if($this->core->database->doInsertQuery($sql)){
			echo '<div class="successpopup">Position Deleted</div>';
		} 
		$this->core->audit(__CLASS__, $item, $this->core->userID, "DELETING POSITION $position");

		$this->managePositions('');
	}
	
	public function managePositions($item) {
		
		$departmentsManager = $this->getManager();
		
		$uid = $this->core->userID;
		$this->viewMenu($item, $phone);
		$i = 1;

		
		echo'<div class="toolbar" style="clear: left;">'.
				'<a class="green" href="' . $this->core->conf['conf']['path'] . '/positions/add">Create Position</a>'.
				'<a class="blue" href="' . $this->core->conf['conf']['path'] . '/positions/grades/">Manage Grades</a>'.
			'</div>';
		
		echo '<table id="active" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th bgcolor="#EEEEEE" width="30px" data-sort"string"><b>#</b></th>
						<th bgcolor="#EEEEEE"><b>Job Title</b></th>
						<th bgcolor="#EEEEEE"><b>Leave</b></th>
						<th bgcolor="#EEEEEE"><b>Grade</b></th>
						<th bgcolor="#EEEEEE"><b>Current Establishment</b></th>
						<th bgcolor="#EEEEEE"><b>Required Establishment</b></th>
						<th bgcolor="#EEEEEE"><b>Monthtly Payroll</b></th>
						<th bgcolor="#EEEEEE"><b>Anual Payroll</b></th>
						<th bgcolor="#EEEEEE"><b>Reports To</b></th>
						<th bgcolor="#EEEEEE"><b>Manage</b></th>
					</tr>
				</thead>
				<tbody>';
				
				
		$sql = "SELECT `positions`.ID, COUNT(`staff`.`JobTitle`) count FROM `positions`, `staff`
				WHERE `staff`.JobTitle = `positions`.ID
				GROUP BY `staff`.`JobTitle`
				ORDER BY `positions`.DepartmentID ASC";
		$run = $this->core->database->doSelectQuery($sql);
		
		while ($fetch = $run->fetch_assoc()) {
			$pid = $fetch['ID'];
			$hired[$pid] = $fetch['count'];
		}

		$sql = "SELECT `positions`.*,`departments`.Name, CONCAT(reporting.Firstname, ' ', reporting.MiddleName, ' ', reporting.Surname)  as manager  
			   FROM `positions`
			   LEFT JOIN `departments` ON `positions`.DepartmentID = `departments`.ID
			   LEFT JOIN `basic-information` as reporting ON `positions`.ReportsTo = `reporting`.ID
			   ORDER BY `positions`.DepartmentID ASC";
		$run = $this->core->database->doSelectQuery($sql);
		
		while ($fetch = $run->fetch_assoc()) {
			$pid = $fetch['ID'];
			$position = $fetch['JobTitle'];
			$description = $fetch['JobDescription'];
			$establishment = $fetch['Establishment'];
			$salaryMonth = $fetch['BasicPay'];
			$staffCount = $fetch['count'];
			$grade = $fetch['Grade'];
			$department = $fetch['Name'];
			$manager = $fetch['manager'];
			$leave = $fetch['LeaveDays'];

			if($hired[$pid] == ''){
				$hired[$pid] = 0;
			}
			
			if($hired[$pid]<$establishment){
				$hire = '  - <a href="' . $this->core->conf['conf']['path'] . '/positions/hire/' . $pid . '"><b>Hire</b></a> ';
			}
			
			if($department != $prevdepartment){
				echo '<tr style="background-color: #ccc;">
					<td colspan="10"><b>DEPARTMENT: '.$department.'</b></td>
				</tr>';
			}
			echo '<tr '.$style.'>
				<td><b>'.$i.'</b></td>
				<td><a href="' . $this->core->conf['conf']['path'] . '/staff/show/?position=' . $pid . '"><b>' . $position . '</b></a>  </td>
				<td>'  . $leave . ' days/month</td>
				<td>'  . $grade . '</td>
				<td><b>' . $hired[$pid] . ' FTE</b></td>
				<td><b>' . $establishment . ' FTE</b></td>
				<td><b>' . number_format($salaryMonth,2) . '</b></td>
				<td><b>' . number_format($salaryMonth*12,2) . '</b></td>
				<td><b>' . $manager . '</b></td>
				<td><b>
					<a href="' . $this->core->conf['conf']['path'] . '/performance/manage/' . $pid . '"><b>KPI</b></a> -
					<a href="' . $this->core->conf['conf']['path'] . '/positions/edit/' . $pid . '"><b>Edit</b></a> -
					<a href="' . $this->core->conf['conf']['path'] . '/positions/delete/' . $pid . '"><b>Delete</b></a>
					'.$hire.'
				</b></td>
				</tr>';
			$prevdepartment = $department;
			$totalMonth = $totalMonth+$salaryMonth;
			$totalEstablishment = $totalEstablishment+$hired[$pid];
			$totalRequiredEstablishment = $totalRequiredEstablishment+$establishment;
			
			$i++;
		}
	
		echo '<tr class="table-light">
			<td></td>
			<td><b>TOTALS</b> </td>
			<td></td>
			<td><b> </b></td>
			<td><b>' . $totalEstablishment . ' FTE</b></td>
			<td><b>' . $totalRequiredEstablishment . ' FTE</b></td>
			<td><b>' . number_format($totalMonth,2) . '</b></td>
			<td><b>' . number_format($totalMonth*12,2) . '</b></td>
			<td></td>
			</tr>';
		echo '</tbody>
		</table>';

	}
	
	public function gradesPositions($item) {
		
		$departmentsManager = $this->getManager();
		
		$uid = $this->core->userID;
		$this->viewMenu($item, $phone);
		$i = 1;

		
		echo'<div class="toolbar" style="clear: left;">'.
				'<a class="green" href="' . $this->core->conf['conf']['path'] . '/positions/addgrade">Create Grade</a>'.
				'<a class="blue" href="' . $this->core->conf['conf']['path'] . '/positions/manage/">Manage Positions</a>'.
			'</div>';
		
		echo '<table id="active" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th bgcolor="#EEEEEE" width="30px" data-sort"string"><b>#</b></th>
						<th bgcolor="#EEEEEE"><b>Job Title</b></th>
						<th bgcolor="#EEEEEE"><b>Department</b></th>
						<th bgcolor="#EEEEEE"><b>Grade</b></th>
						<th bgcolor="#EEEEEE"><b>Current Establishment</b></th>
						<th bgcolor="#EEEEEE"><b>Required Establishment</b></th>
						<th bgcolor="#EEEEEE"><b>Monthtly Payroll</b></th>
						<th bgcolor="#EEEEEE"><b>Anual Payroll</b></th>
						<th bgcolor="#EEEEEE"><b>Reports To</b></th>
						<th bgcolor="#EEEEEE"><b>Manage</b></th>
					</tr>
				</thead>
				<tbody>';
				
				
		$sql = "SELECT `positions`.ID, COUNT(`staff`.`JobTitle`) count FROM `positions`, `staff`
				WHERE `staff`.JobTitle = `positions`.ID
				GROUP BY `staff`.`JobTitle`";
		$run = $this->core->database->doSelectQuery($sql);
		
		while ($fetch = $run->fetch_assoc()) {
			$pid = $fetch['ID'];
			$hired[$pid] = $fetch['count'];
		}

		$sql = "SELECT `positions`.*,`departments`.Name, reporting.JobTitle as manager  
			   FROM `positions`
			   LEFT JOIN `departments` ON `positions`.DepartmentID = `departments`.ID
			   LEFT JOIN `positions` as reporting ON `positions`.ReportsTo = reporting.ID";
		$run = $this->core->database->doSelectQuery($sql);
		
		while ($fetch = $run->fetch_assoc()) {
			$pid = $fetch['ID'];
			$position = $fetch['JobTitle'];
			$description = $fetch['JobDescription'];
			$establishment = $fetch['Establishment'];
			$salaryMonth = $fetch['BasicPay'];
			$staffCount = $fetch['count'];
			$grade = $fetch['Grade'];
			$department = $fetch['Name'];
			$manager = $fetch['manager'];

			if($hired[$pid] == ''){
				$hired[$pid] = 0;
			}
			
			if($hired[$pid]<$establishment){
				$hire = '  - <a href="' . $this->core->conf['conf']['path'] . '/positions/hire/' . $pid . '"><b>Hire</b></a> ';
			}
			
			echo '<tr '.$style.'>
				<td><b>'.$i.'</b></td>
				<td><a href="' . $this->core->conf['conf']['path'] . '/staff/show/?position=' . $pid . '"><b>' . $position . '</b></a>  </td>
				<td>'  . $department . '</td>
				<td>'  . $grade . '</td>
				<td><b>' . $hired[$pid] . ' FTE</b></td>
				<td><b>' . $establishment . ' FTE</b></td>
				<td><b>' . number_format($salaryMonth,2) . '</b></td>
				<td><b>' . number_format($salaryMonth*12,2) . '</b></td>
				<td><b>' . $manager . '</b></td>
				<td><b>
					<a href="' . $this->core->conf['conf']['path'] . '/positions/edit/' . $pid . '"><b>Edit</b></a> -
					<a href="' . $this->core->conf['conf']['path'] . '/positions/delete/' . $pid . '"><b>Delete</b></a>
					'.$hire.'
				</b></td>
				</tr>';
				
			$totalMonth = $totalMonth+$salaryMonth;
			$totalEstablishment = $totalEstablishment+$hired[$pid];
			$totalRequiredEstablishment = $totalRequiredEstablishment+$establishment;
			
			$i++;
		}
	
		echo '<tr class="table-light">
			<td></td>
			<td><b>TOTALS</b> </td>
			<td></td>
			<td><b> </b></td>
			<td><b>' . $totalEstablishment . ' FTE</b></td>
			<td><b>' . $totalRequiredEstablishment . ' FTE</b></td>
			<td><b>' . number_format($totalMonth,2) . '</b></td>
			<td><b>' . number_format($totalMonth*12,2) . '</b></td>
			<td></td>
			</tr>';
		echo '</tbody>
		</table>';

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