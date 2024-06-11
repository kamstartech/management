<?php
class departments{

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
	
	public function addDepartments($item) {
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
 
		$select = new optionBuilder($this->core);
		$staff = $select->showUsers(100);
		$leavetypes = $select->showLeave(); 
		$departments = $select->showDepartments(); 
		
		include $this->core->conf['conf']['formPath'] . "addepartment.form.php";
	}
		
	public function editDepartments($item) {
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
 
		$select = new optionBuilder($this->core);
		$staff = $select->showUsers(100);
		$leavetypes = $select->showLeave(); 
		$departments = $select->showDepartments(); 
		
		
		$sql = "SELECT * FROM `departments` WHERE `ID` = '$item'";
		$run = $this->core->database->doSelectQuery($sql);

		
		while ($fetch = $run->fetch_assoc()) {
			$name = $fetch['Name'];
			$description = $fetch['Description'];
		}
			
		
		include $this->core->conf['conf']['formPath'] . "addepartment.form.php";
	}
	

	public function saveDepartments($item) {
		$uid = $this->core->userID;
		$name = $this->core->cleanPost['name'];
		$manager = $this->core->cleanPost['managed'];
		$parent = $this->core->cleanPost['under'];
		$description = $this->core->cleanPost['description'];
		
		if($item == ''){
			$depid = 'NULL';
		} else {
			$depid = $item;
		}

		$sql = "REPLACE INTO `departments` (`ID`, `Name`, `Description`, `Manager`, `Parent`)
			    VALUES ($depid, '$name', '$description', '$manager', '$parent');";

		if($this->core->database->doInsertQuery($sql)){
			echo '<div class="successpopup">Department Created</div>';
			$this->manageDepartments('');
		} else {
			echo '<div class="errorpopup">ERROR: Department could not be added.</div>';
			$this->manageDepartments('');
		}
	   
	}	
	
	public function deleteDepartments($item) {
		$sql = "DELETE FROM `departments` WHERE `ID` = '$item'";
		if($this->core->database->doInsertQuery($sql)){
			echo '<div class="successpopup">Department Deleted</div>';
		} 
		$this->core->audit(__CLASS__, $item, $this->core->userID, "DELETING DEPARTMENT $position");

		$this->manageDepartments('');
	}
	
	



	public function chartDepartments($item) {

		$departmentsManager = $this->getManager();
		
		$uid = $this->core->userID; 
		$this->viewMenu($item, $phone);
		$i = 1;
		echo'<div class="toolbar" style="clear: both;">'.
				'<a href="' . $this->core->conf['conf']['path'] . '/departments/add" class="green">Add New Department</a>'.
				'<a href="' . $this->core->conf['conf']['path'] . '/departments/chart" class="blue">Organizational Chart</a>'.
			'</div>';

		echo' <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript">
			  google.charts.load(\'current\', {packages:["orgchart"]});
			  google.charts.setOnLoadCallback(drawChart);

			  function drawChart() {
				var data = new google.visualization.DataTable();
				data.addColumn(\'string\', \'Name\');
				data.addColumn(\'string\', \'Manager\');
				data.addColumn(\'string\', \'ToolTip\');

				// For each orgchart box, provide the name, manager, and tooltip to show.
				data.addRows([';
				
				$sql = "SELECT *, `departments`.Name, `departments`.ID as DEPID, SUM(`BasicPay`) as pay, TotalBudget, SUM(`positions`.Establishment) as establishment, `basic-information`.ID as MANID, `DEPS`.Name as ParentDep
						FROM `departments`
						LEFT JOIN `basic-information` ON `departments`.Manager = `basic-information`.ID
						LEFT JOIN `positions` ON `departments`.ID = `positions`.DepartmentID
						LEFT JOIN `budget` ON `departments`.ID = `budget`.DepartmentID
						LEFT JOIN `departments` as DEPS ON `departments`.Parent = `DEPS`.ID
						GROUP BY `departments`.ID";
				$run = $this->core->database->doSelectQuery($sql);

				
				while ($fetch = $run->fetch_assoc()) {
					$depid = $fetch['DEPID'];
					$managerID = $fetch['MANID'];
					$department = $fetch['Name'];
					$parent = $fetch['ParentDep'];
					$description = $fetch['Description'];
					$staffCountRequired = $fetch['establishment'];
					$monthlyPay = $fetch['pay'];
					$totalBudget = $fetch['TotalBudget'];
					$manager = $fetch['FirstName'] .' ' . $fetch['MiddleName'] .' ' . $fetch['Surname'];


					$manager = str_replace("'", '', $manager);
			
			
					if($parent == ''){
						continue;
					} else {
						$output .= "[  {'v':'$department', 'f':'<b><a href=\"" . $this->core->conf['conf']['path'] . "/staff/show/$depid\">$department</a></b><div style=\"color: #333; font-style:italic\">$manager</div>'}  , '$parent', '$manager'], \n";
					}
				}
				
				rtrim($output, ',');
				echo $output;
				
				echo']);
				
				data.setRowProperty(2, \'selectedStyle\', \'background-color:#ccc\');

				// Create the chart.
				var chart = new google.visualization.OrgChart(document.getElementById(\'chart_div\'));
				// Draw the chart, setting the allowHtml option to true for the tooltips.
				chart.draw(data, {\'allowHtml\':true});
			  }
		   </script>
		  
 
		<div id="chart_div"></div>';
	
	}			
				
				
	public function hiearchyDepartments($item) {

		$departmentsManager = $this->getManager();
		
		$uid = $this->core->userID; 
		$this->viewMenu($item, $phone);
		$i = 1;
		echo'<div class="toolbar" style="clear: both;">'.
				'<a href="' . $this->core->conf['conf']['path'] . '/departments/add" class="green">Add New Department</a>'.
				'<a href="' . $this->core->conf['conf']['path'] . '/departments/chart" class="blue">Organizational Chart</a>'.
			'</div>';
		
		echo '<table id="active" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th bgcolor="#EEEEEE" width="30px" data-sort"string"><b>#</b></th>
						<th bgcolor="#EEEEEE"><b>Department</b></th>
						<th bgcolor="#EEEEEE"><b>Manager</b></th>

					</tr>
				</thead>
				<tbody>';
				
				
		$sql = "with recursive cte (ID, Name, Manager) as (
				  select     ID,
							 Name,
							 Manager
				  from       departments
				  where      Manager IS NULL
				  union all
				  select     p.ID,
							 p.Name,
							 p.Manager
				  from       departments p
				  inner join cte
						  on p.Manager = cte.ID
				)
				select *, CONCAT(Manager,'.',ID) as sort from cte;";
				

		$run = $this->core->database->doSelectQuery($sql);

		
		while ($fetch = $run->fetch_assoc()) {
			$depid = $fetch['ID'];
			$department = $fetch['Name'];
			$sort = $fetch['sort'];
			$hiearchy = $fetch['Manager'];
			
			if($hiearchy == ''){
				$sort = 100;
			}
			$departments[$sort] =  $department;
		}

		krsort($departments, SORT_NATURAL );

		foreach($departments as $asd => $department){
			$depid = $asd;
			$name = $department;
			
			$hiearchy = explode('.',$asd);
			
			if($hiearchy[0] != $prevhiearchy){
				$append .=  "--->";
			}
		
			
			echo '<tr>
				<td><b>'.$depid.'</b></td>
				<td><a href="' . $this->core->conf['conf']['path'] . '/staff/show/' . $depid . '">'.$append	.' <b>' . $name . '</b></a>  </td>
				<td>'.$depid.'</td>
				</tr>';

			$prevhiearchy = $hiearchy[0];
			$i++;

		}

		echo '</tbody>
		</table>';

	}			
				


	public function manageDepartments($item) {
		$departmentsManager = $this->getManager(); 
		$uid = $this->core->userID;
		$this->viewMenu($item, $phone);
		$i = 1;
 
		echo'<div class="toolbar" style="clear: both;">'.
				'<a href="' . $this->core->conf['conf']['path'] . '/departments/add" class="green">Add New Department</a>'.
				'<a href="' . $this->core->conf['conf']['path'] . '/departments/chart" class="blue">Organizational Chart</a>'.
			'</div>';
		
		echo '<table id="active" class="table table-bordered table-hover">
				<thead>
					<tr> 
						<th bgcolor="#EEEEEE" width="30px" data-sort"string"><b>#</b></th>
						<th bgcolor="#EEEEEE"><b>Department</b></th>
						<th bgcolor="#EEEEEE"><b>Manager</b></th>
						<th bgcolor="#EEEEEE"><b>Current Establishment</b></th>
						<th bgcolor="#EEEEEE"><b>Required Establishment</b></th>
						<th bgcolor="#EEEEEE"><b>Curent Annual Payroll</b></th>
						<th bgcolor="#EEEEEE"><b>Budgeted Annual Payroll</b></th>
						<th bgcolor="#EEEEEE"><b>Manage</b></th>
					</tr>
				</thead>
				<tbody>';

		$sql = "SELECT `departments`.Name, COUNT(DISTINCT `staff`.ID) as staff
		FROM `staff`, `positions`, `departments`
		WHERE  `staff`.JobTitle = `positions`.ID
		AND  `departments`.ID = `positions`.DepartmentID
		GROUP BY `departments`.Name;";
		$run = $this->core->database->doSelectQuery($sql);
		
		while ($fetch = $run->fetch_assoc()) {
			$department = $fetch['Name'];
			$requisitions[$department] = $fetch['count'];
			$staffCount[$department] = $fetch['staff'];
			$cost[$department] = $fetch['cost'];
		}
		
		$sql = "SELECT *, `departments`.ID as DEPID, SUM(`BasicPay`) as pay, TotalBudget, SUM(`positions`.Establishment) as establishment, `basic-information`.ID as MANID
				FROM `departments`
				LEFT JOIN `basic-information` ON `departments`.Manager = `basic-information`.ID
				LEFT JOIN `positions` ON `departments`.ID = `positions`.DepartmentID
				LEFT JOIN `budget` ON `departments`.ID = `budget`.DepartmentID
				GROUP BY `departments`.ID";
		$run = $this->core->database->doSelectQuery($sql);

		
		while ($fetch = $run->fetch_assoc()) {
			$depid = $fetch['DEPID'];
			$managerID = $fetch['MANID'];
			$department = $fetch['Name'];
			$description = $fetch['Description'];
			$staffCountRequired = $fetch['establishment'];
			$monthlyPay = $fetch['pay'];
			$totalBudget = $fetch['TotalBudget'];
			$manager = $fetch['FirstName'] .' ' . $fetch['MiddleName'] .' ' . $fetch['Surname'];
	
			$manager = str_replace("'", '', $manager);
			
			if($staffCount[$department] == ''){
				$staffCount[$department]=0;
			}
			if($staffCountRequired == ''){
				$staffCountRequired=0;
			}
			
			echo '<tr '.$style.'>
				<td><b>'.$i.'</b></td>
				<td><a href="' . $this->core->conf['conf']['path'] . '/staff/show/' . $depid . '"><b>' . $department . '</b></a>  </td>
				<td><a href="' . $this->core->conf['conf']['path'] . '/information/show/' . $managerID . '">'  . $manager . '</a></td>
				<td><b>' . $staffCount[$department] . ' FTE</b></td>
				<td><b>' . $staffCountRequired . ' FTE</b></td>
				<td><b>' . number_format($monthlyPay*12,2) . '</b></td>
				<td><b>' . number_format($totalBudget,2) . '</b></td>
				<td><b>
					<a href="' . $this->core->conf['conf']['path'] . '/departments/edit/' . $depid . '"><b>Edit</b></a> -
					<a href="' . $this->core->conf['conf']['path'] . '/departments/delete/' . $depid . '"><b>Delete</b></a>
					'.$hire.'
				</b></td>
				</tr>';


			$i++;

		}

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