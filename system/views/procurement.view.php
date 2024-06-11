<?php
class procurement {
	
	// requisitionProcurement   -   user in department makes a request
	// approveProcurement		-   user approves PR to next stage
	// rejectProcurement		- 	user rejects PR (cancelled)
	// finalizeProcurement		-	print purchase requisition
	// departmentProcurement	-	overview of items bought
	// manageProcurement		-	overview of requisitions viewable for the user

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

	private function viewMenu(){
		$today = date("Y-m-d");

		if(isset($_GET['date'])){
			$today = $_GET['date'];
		}

		echo '<div class="toolbar">
		<a href="' . $this->core->conf['conf']['path'] . '/procurement/requisitions/">Purchase Requisitions</a>
		<a href="' . $this->core->conf['conf']['path'] . '/orders/manage/">Purchase Orders</a>
			<a href="' . $this->core->conf['conf']['path'] . '/stock/manage/">Stock Management</a>
		<a href="' . $this->core->conf['conf']['path'] . '/procurement/departments/">Departments</a>
		<a href="' . $this->core->conf['conf']['path'] . '/suppliers/manage/">Suppliers</a>
		</div>';

		echo '<div class="toolbar">
		<a href="' . $this->core->conf['conf']['path'] . '/procurement/new/" class="green">New Purchase Requisition</a>
		<a href="' . $this->core->conf['conf']['path'] . '/procurement/requisitions/complete">Approved Requisitions</a>
		<a href="' . $this->core->conf['conf']['path'] . '/procurement/requisitions/pending">Pending Requisitions</a>
		<a href="' . $this->core->conf['conf']['path'] . '/procurement/requisitions/rejected">Rejected Requisitions</a>
		</div>';
	}
	
	public function newProcurement($item) {
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
		$optionBuilder = new optionBuilder($this->core);
		$departments = $optionBuilder->showDepartments();
		
		include $this->core->conf['conf']['formPath'] . "newrequisition.form.php";
	}

	public function editProcurement($item) {
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
		$optionBuilder = new optionBuilder($this->core);
		$departments = $optionBuilder->showDepartments();
		

		$sql = "SELECT * FROM `requisition-lines` 
				WHERE `requisition-lines`.ID = '$item'";
		$rund = $this->core->database->doSelectQuery($sql);
		
		$x=1;
		while ($fetchd = $rund->fetch_assoc()) {
			$name = $fetchd['ItemName'];
			$specs = $fetchd['ItemDescription'];
			$qty = $fetchd['ItemQuantity'];
			$cost = $fetchd['ExpectedCost'];
			$budgeted = $fetchd['BudgetVariation'];
		}
		
		include $this->core->conf['conf']['formPath'] . "editrequisition.form.php";
	}
	
	public function saveeditProcurement($item) {
		$curName = $this->core->cleanPost['name'];
		$curSpecs = $this->core->cleanPost['specs'];
		$curQuantity = $this->core->cleanPost['quantity']; 
		$curCost = $this->core->cleanPost['cost'];
		
		$sql = "UPDATE `requisition-lines` SET 
					`ItemName` = '$curName', 
					`ItemDescription` = '$curSpecs', 
					`ItemQuantity` = '$curQuantity', 
					`ExpectedCost` = '$curCost' 
				WHERE `ID` = '$item'";

		$this->core->database->doInsertQuery($sql);
		
		$this->core->audit(__CLASS__, $item, $item, "Edited requisition line $item - $curName");
	}
	
	
	public function saveProcurement($item) {

		echo '<div class="toolbar">
		<a href="' . $this->core->conf['conf']['path'] . '/procurement/requisitions/">Back to Overview</a>
		</div>';
		
		$userid = $this->core->userID;
		$description = $this->core->cleanPost['description'];
		$category = $this->core->cleanPost['category'];
		
		$sql = "INSERT INTO `requisitions` (`ID`, `Description`, `Category`, `DateCreated`, `RequestedBy`, `Status`) 
		VALUES (NULL, '$description', '$category', NOW(), '$userid', '');";
		
		if($this->core->database->doInsertQuery($sql)){
			$prn = $this->core->database->id();
		} else {
			echo '<div class="errorpopup">Error please contact ICT</div>';
			return;
		}
		
		$name = $this->core->cleanPost['name'];
		$specs = $this->core->cleanPost['specs'];
		$quantity = $this->core->cleanPost['quantity']; 
		$cost = $this->core->cleanPost['cost'];
		$budgeted = $this->core->cleanPost['budgeted'];

		$i=0;
		$set = FALSE;
		foreach($name as $names){
			$curName = $names;
			$curSpecs = $specs[$i];
			$curQuantity = $quantity[$i];
			$curCost = $cost[$i];
			$curBudgeted = $budgeted[$i];
			
			if($curBudgeted == 'on'){
				$curBudgeted = 1;
			} else{
				$curBudgeted = 0;
			}
			
			if($curName != ''){
				$sql = "INSERT INTO `requisition-lines` (`ID`, `RequisitionID`, `ItemName`, `ItemDescription`, `ItemQuantity`, `ExpectedCost`, `SuggestedSuppliers`, `DateRequire`, `BudgetAllocation`, `BudgetVariation`, `Image`) 
				VALUES (NULL, '$prn', '$curName', '$curSpecs', '$curQuantity', '$curCost', '$curSuppliers', NOW(), '$curCost', '$curBudgeted', '');";

				$this->core->database->doInsertQuery($sql);
			}
			
			$i++;
			$set = TRUE;
		}
		
		if($set == TRUE){
			echo '<div class="successpopup">Purchase Requisition #'.$prn.' created</div>';
		}else{
			echo '<div class="errorpopup">No lines were added.</div>';
		}
	}

	public function approveProcurement($item) {
		$uid = $this->core->userID;
		$departmentsManager = $this->getManager();
		
		$sql = "SELECT * FROM `requisitions` 
		LEFT JOIN `staff` ON `staff`.ID = `RequestedBy`
		LEFT JOIN `positions` ON `positions`.ID = `staff`.JobTitle
		LEFT JOIN `departments` ON `positions`.DepartmentID = `departments`.ID
		WHERE `requisitions`.ID = '$item'";
		$run = $this->core->database->doSelectQuery($sql);

		while ($fetch = $run->fetch_assoc()) {
			$prid = $fetch['ID'];
			$department = $fetch['Name']; 
			
			$managerApproval 	 = $fetch['ManagerApproval'];
			$procurementApproval = $fetch['ProcurementApproval'];
			$financeApproval 	 = $fetch['FinanceApproval'];
			$auditorApproval 	 = $fetch['AuditApproval'];
			$managementApproval  = $fetch['ManagementApproval'];
			$directorApproval 	 = $fetch['DirectorApproval'];
						
			if($managerApproval == ''){
				$approvalLevel = "ManagerApproval";
			} else if($procurementApproval == ''){
				$department = "Procurement";
				$approvalLevel = 'ProcurementApproval';
			} else if($financeApproval == ''){
				$department = "Finance";
				$approvalLevel = 'FinanceApproval';
			} else if($managementApproval == ''){
				$department = "Registrar";
				$approvalLevel = 'ManagementApproval';
			} else if($directorApproval == ''){
				$department = "Director";
				$approvalLevel = 'DirectorApproval';
			} else if($auditorApproval == ''){
				$department = "Audit";
				$approvalLevel = 'AuditApproval';
			}
			
			$approvalLevelDate = $approvalLevel.'Date';
			$approvalLevelComment = $approvalLevel.'Comment';
				
			if(in_array($department, $departmentsManager)){

				$reason = $this->core->cleanPost['reason']; 
				if($reason==''){
					echo '<form method="POST" action="'. $this->core->conf['conf']['path'] .'/procurement/approve/'.$item.'">
					If you have any notes please provide them here: <br>
					<textarea type="text" name="reason" style="width: 500px; height: 200px;"required> </textarea><br>
					<input type="submit" name="submit" value="ACCEPT Purchase Requisition" id="submit" class="submit" style="width: 260px"/>
					</form>';
				} else {
					$sql = 'UPDATE `requisitions` SET   '.$approvalLevel.' = "'.$uid.'", 
														'.$approvalLevelComment.' = "'.$reason.'", 
														'.$approvalLevelDate.' = NOW() 
														WHERE `requisitions`.ID = "'.$item.'"';
					
					if($this->core->database->doInsertQuery($sql)){
						echo'<div class="successpopup">Purchase Requisition PRN'.$item.' Approved</div>';
						$this->requisitionsProcurement(NULL);
					}
				}
			}
		}
	}
	
	public function rejectProcurement($item) {
		$uid = $this->core->userID;
		$departmentsManager = $this->getManager();
		
		$sql = "SELECT `departments`.Name FROM `requisitions` 
		LEFT JOIN `staff` ON `staff`.ID = `RequestedBy`
		LEFT JOIN `departments` ON `staff`.SchoolID = `departments`.ID
		WHERE `requisitions`.ID = '$item'";
		$run = $this->core->database->doSelectQuery($sql);

		while ($fetch = $run->fetch_assoc()) {
			$prid = $fetch['ID'];
			$department = $fetch['Name']; 
			
			$managerApproval = $fetch['ManagerApproval'];
			$procurementApproval = $fetch['ProcurementApproval'];
			$financeApproval = $fetch['FinanceApproval'];
			$managementApproval = $fetch['ManagementApproval'];
			$directorApproval = $fetch['DirectorApproval'];
			$auditorApproval = $fetch['AuditorApproval'];
						
			if($managerApproval == ''){
				$approvalLevel = 'ManagerApproval';
			} else if($procurementApproval == ''){
				$department = "Procurement Department";
				$approvalLevel = 'ProcurementApproval';
			} else if($financeApproval == ''){
				$department = "Finance";
				$approvalLevel = 'FinanceApproval';
			} else if($auditorApproval == ''){
				$department = "Audit";
				$approvalLevel = 'AuditApproval';
			} else if($managementApproval == ''){
				$department = "Registrar";
				$approvalLevel = 'ManagementApproval';
			} else if($directorApproval == ''){
				$department = "Director";
				$approvalLevel = 'DirectorApproval';
			}
			
			$approvalLevelDate = $approvalLevel.'Date';
				
			if(in_array($department, $departmentsManager)){

				$reason = $this->core->cleanPost['reason']; 
				if($reason==''){
					echo '<form method="GET" action="'. $this->core->conf['conf']['path'] .'/procurement/reject/'.$item.'">
					If you have any notes please provide them here: <br>
					<input type="text" name="reason" required>
					<input type="submit" name="submit" value="REJECT Purchase Requisition" id="submit" class="submit" style="width: 260px"/>
					</form>';
				} else {
					$sql = 'UPDATE `requisitions` SET '.$approvalLevel.' = '.$uid.', `Status` = "REJECTED BY '.$department.'", '.$approvalLevelDate.' = NOW() WHERE `requisitions`.ID = "'.$item.'"';
					$this->core->database->doInsertQuery($sql);
					
				}
			}
		}
	}

	public function printProcurement($item) {
		
		$output = $this->prProcurement($item, TRUE);
		
		$path = "datastore/output/requisitions/";
		$filename =  $path . 'PR-'.$item.'.pdf';


		$owner = $this->core->userID;
		
		if(file_exists($filename)){
			$rand = rand(1111,9999);
			$filename =  $path . 'PR-'.$owner.'-'.$item.'-'.$rand.'.pdf';
		}

		require_once $this->core->conf['conf']['libPath'] . 'dompdf/dompdf_config.inc.php';

		$dompdf= new Dompdf();
		$dompdf->set_paper("A4", "portrait");
		$dompdf->load_html($output);
		$dompdf->render();

		$pdf = $dompdf->output();
		file_put_contents($filename, $pdf);

		
		$mime = mime_content_type($filename);
		header('Content-type: '.$mime);
		header('Content-Disposition: attachment; filename=PR-'.$item.'.pdf');
		header('Content-Length: ' . filesize($filename));
		$content = readfile($filename);
			
	}
		
		
	public function prProcurement($item, $print=FALSE) {
		
		$sql = "SELECT COUNT(`registry`.StudentID) count
		FROM `registry`
		WHERE `registry`.Category = 'Quote'
		AND `registry`.StudentID = '$item'
		GROUP BY `registry`.StudentID ";
	
		$run = $this->core->database->doSelectQuery($sql);
		
		$quotes = $run->num_rows;
		
		$sql = "SELECT `requisitions`.*, `departments`.Name as department, `Firstname`, `Surname`, SUM(`requisition-lines`.ExpectedCost*`requisition-lines`.ItemQuantity) cost, COUNT(`requisition-lines`.ID) as items  
		FROM `requisitions`
		LEFT JOIN `requisition-lines` ON `requisitions`.ID = `requisition-lines`.RequisitionID
		LEFT JOIN `staff` ON `staff`.ID = `RequestedBy`
		LEFT JOIN `basic-information` ON `staff`.ID = `basic-information`.ID
		LEFT JOIN `positions` ON `staff`.JobTitle = `positions`.ID
		LEFT JOIN `departments` ON `positions`.DepartmentID = `departments`.ID
		WHERE `requisitions`.ID = '$item'
		GROUP BY `requisitions`.ID";
		$run = $this->core->database->doSelectQuery($sql);

		
		while ($fetch = $run->fetch_assoc()) {
			$prid = $fetch['ID'];
			$description = $fetch['Description'];
			$items = $fetch['items'];
			$cost = $fetch['cost'];
			$department = $fetch['department'];
			$quotations = $fetch['quotations'];
			$status = $fetch['status'];
			$date = $fetch['DateCreated'];
			$category = $fetch['Category'];
			$requester = $fetch['FirstName'] .' ' . $fetch['Surname'];

			$cost =  number_format($cost) . " ZMW";
			
			if($quotations[$prid] == ''){
				$quotations[$prid] = 0;
			}
				
			
			$managerApproval = $fetch['ManagerApproval'];
			$procurementApproval = $fetch['ProcurementApproval'];
			$financeApproval = $fetch['FinanceApproval'];
			$managementApproval = $fetch['ManagementApproval'];
			$directorApproval = $fetch['DirectorApproval'];
			$auditorApproval = $fetch['AuditApproval'];
			
			
			if($directorApproval == ''){
				$status = "<b>PENDING WITH: </b>";
			}else {
				$status = "<b>FULLY APPROVED</b>";
			}
			
			if($managerApproval == ''){
				$statusNext .= $department;
			} else if($procurementApproval == ''){
				$statusNext .= 'Procurement';
			} else if($financeApproval == ''){
				$statusNext .= 'Finance';
			} else if($managementApproval == ''){
				$statusNext = 'Registrar';
			} else if($directorApproval == ''){
				$statusNext .= 'Director';
			} else if($auditorApproval == ''){
				$statusNext .= 'Audit';
			}
			
			$status .= $statusNext;
			
			if($print == FALSE){
				$departmentsManager = $this->getManager();
				
				// SHOW MENU
				$output .= '<div class="toolbar">
				<a href="' . $this->core->conf['conf']['path'] . '/procurement/requisitions/">Back to Overview</a>
				<a href="' . $this->core->conf['conf']['path'] . '/registry/quotes/'.$item.'">Manage Quotations</a>
				<a href="' . $this->core->conf['conf']['path'] . '/procurement/print/'.$item.'">Print Requisition</a>';
			
				
				
				if(in_array($statusNext, $departmentsManager)){
						$output .=  '<a class="green" href="' . $this->core->conf['conf']['path'] . '/procurement/approve/'.$item.'">Approve Requisition</a>';
						$output .=  '<a class="red" href="' . $this->core->conf['conf']['path'] . '/procurement/reject/'.$item.'">Reject Requisition</a>';
				}
			
				$output .= '</div>';
				$output .=  '<h1>PURCHASE REQUISITION</h1>';
			} else {
				
				
				$output .= '<html><body style="font-family: Arial, Helvetica, sans-serif; font-size: 13px;">
				<style>
				table, th {
					border-collapse: collapse;
					align: left;
					text-align; left;
				}
				</style>

					<table>
					<tr style=" border: 1px solid #ccc; ">
						<td style="width: 400px;">
						<center>	
							<a href="' . $this->core->conf['conf']['path'] . '"><img height="90px" src="/var/www/html/templates/mobile/images/header.png" /></a>
							<div style="font-size: 13pt;"><b>EDEN UNIVERSITY</b></div>
						</center>
						
						</td>
						<td style="padding-left: 30px; font-size: 11pt; color: #333; ">
							<br>Barlastone, Lusaka, Zambia
							<br> <a href="mailto:info@edenuniversity.edu.zm">info@edenuniversity.edu.zm</a>
							<br> CEL: +260 211 12345
					</td>
					</tr>
					</table> 
					<h1>PURCHASE REQUISITION</h1>
					<div style="border-bottom: 1px solid #333; width: 100%; margin-bottom: 20px;">&nbsp;</div>';
			}
			
			
			
	
			$output .=  '<table class="">
				<tr>
					<td style="width: 250px;">Purchase Requisition Number: </td>
					<td><b>PRN'.$prid.'</b></td>
				</tr>
				<tr>
					<td>Description of PR: </td>
					<td><b>' . $description . '</b></td>
				</tr>
				<tr>
					<td>Department requested under: </td>
					<td><b>'  . $department . '</b></td>
				</tr>
				<tr>
					<td>Request category: </td>
					<td><b>'  . $category . '</b></td>
				</tr>
				<tr>
					<td>Number of Item Lines: </td>
					<td><b>' . $items . ' </b></td>
				</td>
				<tr>
					<td>Total estimated cost: </td>
					<td><b>' . $cost . '</b></td>
				</tr>
				<tr>
					<td>Quotations collected: </td>
					<td><b>' . $quotes  . '</b></td>
				</tr>
				<tr>
					<td>Approval status: </td>
					<td><b>' . $status . '</b></td>
				</tr>
				<tr>
					<td>Date Requested: </td>
					<td><i>' . $date . '</i></td>
				</tr>
				</table><br>';
				
						
				$sql = "SELECT * FROM `requisition-lines` 
						WHERE `requisition-lines`.RequisitionID = $item";
				$rund = $this->core->database->doSelectQuery($sql);

				$output .=  '<h2>PURCHASE REQUISITION LINE ITEMS</h2>';
				$output .=  '<table class="table table-responsive-sm" border="1" width="100%">
							<tr style="font-weight: bold; text-align: left;  background-color: #333; color: #fff;" align="left" >
								<th>#</th>
								<th>Item Name</th>
								<th>Item Specifications</th>
								<th>Quantity</th>
								<th>Unit Cost <br> (Expected)</th>
								<th>Total <br> (Expected)</th>
							</tr>';
					$x=1;
				while ($fetchd = $rund->fetch_assoc()) {
					$plid = $fetchd['ID'];
					$name = $fetchd['ItemName'];
					$specs = $fetchd['ItemDescription'];
					$quantity = $fetchd['ItemQuantity'];
					$unit = $fetchd['ExpectedCost'];
					$cost = $unit*$quantity;
					$budgeted = $fetchd['BudgetVariation'];
					if($budgeted == 1){
						$budgeted = "NOT BUDGETED";
					} else{
						$budgeted = "BUDGETED";
					}
					
					
					
					$output .= '<tr>
							<td style="width:20px; text-align: left;">'.$x.'</td>
							<td style=" text-align: left;"><b>'.$name.'</b></td>
							<td style="text-align: left;">'.$specs.'</td>
							<td style="width:80px; text-align: left;">'.$quantity.'</td>
							<td style="width:100px; text-align: left;">K'.number_format($unit,2).'</td>
							<td style="width:100px; text-align: left;"><b>K'.number_format($cost,2).'</b></td>';
							
							if(in_array($statusNext, $departmentsManager)){
								$output .= '<td style="width:50px; text-align: left;"><a href="' . $this->core->conf['conf']['path'] . '/procurement/edit/'.$plid.'"><img src="' . $this->core->conf['conf']['path'] . '/templates/mobile/images/edi.png"></a></td>';
							}
					$output .= '</tr>';
					$x++;
					
					$totcost = $totcost+$cost;
					$totquantity = $totquantity+$quantity;
					
				}


				$output .= '<tr class="" style="border-top: 1px solid #333 !important; background-color: #333; color: #fff;">
						<td style="width:20px;"></td>
						<td style="width:200px;"><b>TOTAL EXPECTED</b></td>
						<td></td>
						<td>'.$totquantity.'</td>
						<td></td>
						<td><b>K'.number_format($totcost,2).'</b></td>
					</tr>';
						
				$output .= '</table>';
				
				
				
										
				$sql = "SELECT `FirstName`, `MiddleName`, `Surname`, `DateCreated`, 'Original Request', 'Original Request' FROM `requisitions` LEFT JOIN `staff` ON `requisitions`.`RequestedBy` = `staff`.ID LEFT JOIN `basic-information` ON `requisitions`.`RequestedBy` = `basic-information`.ID  WHERE `requisitions`.`ID` =  '$item'
				  UNION SELECT `FirstName`, `MiddleName`, `Surname`, `ManagerApprovalDate`, `ManagerApprovalComment`, 'Department Manager' FROM `requisitions` LEFT JOIN `staff` ON `requisitions`.`ManagerApproval` = `staff`.ID LEFT JOIN `basic-information` ON `requisitions`.`ManagerApproval` = `basic-information`.ID  WHERE `requisitions`.`ID` =  '$item'
				  UNION SELECT `FirstName`, `MiddleName`, `Surname`, `ProcurementApprovalDate`, `ProcurementApprovalComment`, 'Procurement Level'   FROM `requisitions` LEFT JOIN `staff` ON `requisitions`.`ProcurementApproval` = `staff`.ID LEFT JOIN `basic-information` ON `requisitions`.`ProcurementApproval` = `basic-information`.ID  WHERE `requisitions`.`ID` =  '$item'
				  UNION SELECT `FirstName`, `MiddleName`, `Surname`, `FinanceApprovalDate`, `FinanceApprovalComment`, 'Finance Level'   FROM `requisitions` LEFT JOIN `staff` ON `requisitions`.`FinanceApproval` = `staff`.ID LEFT JOIN `basic-information` ON `requisitions`.`FinanceApproval` = `basic-information`.ID  WHERE `requisitions`.`ID` =  '$item'
				  UNION SELECT `FirstName`, `MiddleName`, `Surname`, `ManagementApprovalDate`, `ManagementApprovalComment`, 'Management Level'   FROM `requisitions` LEFT JOIN `staff` ON `requisitions`.`ManagementApproval` = `staff`.ID LEFT JOIN `basic-information` ON `requisitions`.`ManagementApproval` = `basic-information`.ID  WHERE `requisitions`.`ID` =  '$item'
				  UNION SELECT `FirstName`, `MiddleName`, `Surname`, `DirectorApprovalDate`, `DirectorApprovalComment`, 'Director Level'   FROM `requisitions` LEFT JOIN `staff` ON `requisitions`.`DirectorApproval` = `staff`.ID LEFT JOIN `basic-information` ON `requisitions`.`DirectorApproval` = `basic-information`.`ID`  WHERE `requisitions`.`ID` =  '$item'
				  UNION SELECT `FirstName`, `MiddleName`, `Surname`, `AuditApprovalDate`, `AuditApprovalComment`, 'Audit Level'   FROM `requisitions` LEFT JOIN `staff` ON `requisitions`.`AuditApproval` = `staff`.ID LEFT JOIN `basic-information` ON `requisitions`.`AuditApproval` = `basic-information`.ID  WHERE `requisitions`.`ID` =  '$item'";
				
				$rund = $this->core->database->doSelectQuery($sql);

				$output .=  '<br><br>
				<h2>CURRENT APPROVAL FLOW</h2>';
				$output .=  '<table class="table table-responsive-sm" style="width: 500px;" border="1">
							<tr style="font-weight: bold; text-align: left;" class="table-info"  align="left" >
								<th>#</th>
								<th>Approver Level</th>
								<th>Approver Name</th>
								<th>Date Approved</th>
								<th>Comment</th>
							</tr>';
					$x=1;
				while ($fetchd = $rund->fetch_row()) {
					$name = $fetchd[0] .' '. $fetchd[1] .' '. $fetchd[2];
					$date = $fetchd[3];
					$comment = $fetchd[4];
					$level = $fetchd[5];
					
					if($date == ''){
						continue;
					}
					
					$output .= '<tr style="font-weight: bold; text-align: left;" align="left" >
								<th>'.$x.'</th>
								<th>'.$level.'</th>
								<th>'.$name.'</th>
								<th>'.$date.'</th>
								<th>'.$comment.'</th>
							</tr>';
					$x++;
							
				}
				$output .= '</table>';
				
			$i++;
		}
		
		if($print == TRUE){
			return $output;
		} else {
			echo $output;
		}
	}

	public function requisitionsProcurement($item) {
		$departmentsManager = $this->getManager();
		
		$uid = $this->core->userID;


		
		$this->viewMenu();
		$i = 1;
		
		
		
		if($item == ""){
			$filters = " `DirectorApproval` IS NULL ";
			echo "<h1>Pending Purchase Requisitions generated in Department</h1>";
		}else if($item == "complete"){
			$filters = " `DirectorApproval` IS NOT NULL ";
			echo "<h1>Purchase Requisitions Fully Approved</h1>";
		} else if($item == "pending"){
			$filters = " `DirectorApproval` IS NULL ";
			echo "<h1>Purchase Requisitions Pending</h1>";
		} else if($item == "rejected"){
			$filters = " `requisitions`.`Status` LIKE '%REJECTED%' ";
			echo "<h1>Purchase Requisitions Pending</h1>";
		}
		
		echo '<table id="active" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th bgcolor="#EEEEEE" width="30px" data-sort"string"><b> PRN#</b></th>
							<th bgcolor="#EEEEEE"><b>Requisition</b></th>
							<th bgcolor="#EEEEEE"><b>Department</b></th>
							<th bgcolor="#EEEEEE"><b>Items</b></th>
							<th bgcolor="#EEEEEE" width="150px;"><b>Expected Cost</b></th>
							<th bgcolor="#EEEEEE"><b>Quotations</b></th>
							<th bgcolor="#EEEEEE"><b>Approval Status</b></th>
							<th bgcolor="#EEEEEE"><b>Date Created</b></th>
						</tr>
					</thead>
					<tbody>';
			
		

		$sql = "SELECT `registry`.StudentID, COUNT(`registry`.StudentID) count
		FROM `registry`
		WHERE `Category` = 'Quote'
		GROUP BY `registry`.StudentID ";
		$run = $this->core->database->doSelectQuery($sql);
		
		while ($fetch = $run->fetch_assoc()) {
			$id = $fetch['StudentID'];
			$quotations[$id] = $fetch['count'];
		}
		
		$deps = implode("',", $departmentsManager);

		if($this->core->role != 1000 && $this->core->role != 1035 && $this->core->role != 1039 && $this->core->role != 102){
			// Only show all requisitions to admin/finance/compliance 
			$filter = " WHERE (`departments`.Name IN ('$deps') 
						 OR `requisitions`.RequestedBy = '$uid')
						 AND " . $filters;
		} else {
			$filter =  "WHERE " . $filters;
		}
		
		$sql = "SELECT `requisitions`.*, `departments`.Name as department, `Firstname`, `Surname`, SUM(`requisition-lines`.ExpectedCost*`requisition-lines`.ItemQuantity) cost, COUNT(`requisition-lines`.ID) as items, departments.Name as DepartmentName, MONTHNAME(`DateCreated`) as month, YEAR(`DateCreated`) as yeard
		FROM `requisitions`
		LEFT JOIN `requisition-lines` ON `requisitions`.ID = `requisition-lines`.RequisitionID
		LEFT JOIN `staff` ON `staff`.ID = `RequestedBy`
		LEFT JOIN `basic-information` ON `staff`.ID = `basic-information`.ID
		LEFT JOIN `positions` ON `staff`.JobTitle = `positions`.ID
		LEFT JOIN `departments` ON `positions`.DepartmentID = `departments`.ID
		".$filter."
		GROUP BY `requisitions`.ID
		ORDER BY DateCreated ASC";
		$run = $this->core->database->doSelectQuery($sql);
	
		
		while ($fetch = $run->fetch_assoc()) {
			$prid = $fetch['ID'];
			$description = $fetch['Description'];
			$items = $fetch['items'];
			$cost = $fetch['cost'];
			$department = $fetch['department'];
			$department = $fetch['DepartmentName'];
			$prstatus = $fetch['Status'];
			$date = $fetch['DateCreated'];
			$month = $fetch['month'];
			$year = $fetch['yeard'];
			$requester = $fetch['FirstName'] .' ' . $fetch['Surname'];

			$totalcost = $cost+$totalcost;
			$cost =  number_format($cost) . " ZMW";
			
			if($quotations[$prid] == ''){
				$quotations[$prid] = 0;
			}
			
			
			if($month != $lastmonth){
				echo '<tr '.$style.'>
				<td colspan="8" style="background-color: #ccc;"><b>'.$month.' - '.$year.' REQUISITIONS</b></td>
				</tr>';
			}
			$lastmonth = $month;
			
			$managerApproval = $fetch['ManagerApproval'];
			$procurementApproval = $fetch['ProcurementApproval'];
			$financeApproval = $fetch['FinanceApproval'];
			$managementApproval = $fetch['ManagementApproval'];
			$directorApproval = $fetch['DirectorApproval'];
			$auditorApproval = $fetch['AuditApproval'];
			
			if(substr($prstatus,0,8) != 'REJECTED'){
				if(in_array($department, $departmentsManager)){
					$status = '<b><a href="' . $this->core->conf['conf']['path'] . '/procurement/pr/' . $prid . '">ACTION REQUIRED</a></b>';
				}
				
				if($directorApproval == ''){
					$status = "<b>PENDING WITH: </b>";
				}else {
					$status = "<b>FULLY APPROVED</b>";
				}
				if($managerApproval != '' && $procurementApproval == '' && $financeApproval == '' && $managementApproval == '' && $directorApproval == '' && $auditorApproval == ''){
					$complete = TRUE;
				}
				
				
				if($managerApproval == ''){
					$status .= ' Head of Department';
				} else if($procurementApproval == ''){
					$status .= 'Procurement';
				} else if($financeApproval == ''){
					$status .= 'Finance';
				} else if($managementApproval == ''){
					$status .= 'Management';
				} else if($directorApproval == ''){
					$status .= 'Director';
				} else if($auditorApproval == ''){
				//	$status .= 'Audit'; 
				}
				

			
			}else {
				$status = '<span style="color: #e20303;">'.$prstatus.'</span>';
			}
			
			if($item == "complete"){
				$status .= '<br><a href="' . $this->core->conf['conf']['path'] . '/orders/generate/' . $prid . '"><b>GENERATE PURCHASE ORDER</b></a>';
				$status .= '<br><a href="' . $this->core->conf['conf']['path'] . '/vouchers/generate/' . $prid . '"><b>GENERATE PAYMENT VOUCHER </b></a>';
			}
			
			if($department == ''){
				continue;
			}
				
			echo '<tr '.$style.'>
				<td><b>PRN'.$prid.'</b></td>
				<td><a href="' . $this->core->conf['conf']['path'] . '/procurement/pr/' . $prid . '"><b>' . ucfirst( $this->lchar($description,70) ) . '</b></a>  </td>
				<td>'  . $department . '</td>
				<td><b>' . $items . ' </b></td>
				<td><b>' . $cost . '</b></td>
				<td><b>' . $quotations[$prid] . '</b></td>
				<td><b>' . $status . '</b></td>
				<td><i>' . $date . '</i></td>
				</tr>';


			$i++;



		}
		
		
		echo '<tr style="background-color: #333; color: #FFF;">
				<td><b></b></td>
				<td><b>TOTAL REQUISITIONS</b></a>  </td>
				<td></td>
				<td><b>' . $i . ' </b></td>
				<td><b>' . number_format($totalcost) . ' ZMW</b></td>
				<td><b></b></td>
				<td><b></b></td>
				<td><i></i></td>
				</tr>';

		echo '</tbody>
		</table>';

	}
	
	
	private function lchar($str,$val){return strlen($str)<=$val?$str:substr($str,0,$val).'...';}
	
	public function departmentsProcurement($item) {
		$uid = $this->core->userID;

		if($item == ""){
			$item = "%";
		}
		
		$this->viewMenu();
		$i = 1;

		$departmentsManager = $this->getManager();
		
		echo '<table id="active" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th bgcolor="#EEEEEE" width="30px" data-sort"string"><b>#</b></th>
							<th bgcolor="#EEEEEE"><b>Department</b></th>
							<th bgcolor="#EEEEEE"><b>Manager</b></th>
							<th bgcolor="#EEEEEE"><b>Requisitions</b></th>
							<th bgcolor="#EEEEEE"><b>Budget</b></th>
							<th bgcolor="#EEEEEE"><b>Total Cost</b></th>
							<th bgcolor="#EEEEEE"><b>Remaining Budget</b></th>
						</tr>
					</thead>
					<tbody>';
			


		$sql = "SELECT `departments`.Name, COUNT(DISTINCT `requisitions`.ID) count, SUM(`requisition-lines`.ExpectedCost*`requisition-lines`.ItemQuantity) cost
		FROM `requisitions`, `requisition-lines`, `staff`, `departments`
		WHERE `requisition-lines`.RequisitionID = `requisitions`.ID
		AND `departments`.ID = `staff`.SchoolID
		AND `requisitions`.`RequestedBy` = `staff`.ID
		GROUP BY `departments`.Name";
		$run = $this->core->database->doSelectQuery($sql);
		
		while ($fetch = $run->fetch_assoc()) {
			$department = $fetch['Name'];
			$requisitions[$department] = $fetch['count'];
			$cost[$department] = $fetch['cost'];
		}
		

		$sql = "SELECT *, `departments`.ID as DEPID, TotalBudget, `FirstName`, `Surname`
				FROM `departments`
				LEFT JOIN `basic-information` ON `departments`.Manager = `basic-information`.ID
				LEFT JOIN `budget` ON `departments`.ID = `budget`.DepartmentID";
		$run = $this->core->database->doSelectQuery($sql);

		
		while ($fetch = $run->fetch_assoc()) {
			$depid = $fetch['DEPID'];
			$department = $fetch['Name'];
			$description = $fetch['Description'];
			$totalBudget = $fetch['TotalBudget'];
			$manager = $fetch['FirstName'] .' ' . $fetch['Surname'];
	
			
			echo '<tr '.$style.'>
				<td><b>'.$i.'</b></td>
				<td><a href="' . $this->core->conf['conf']['path'] . '/procurement/requisitions/' . $depid . '"><b>' . $department . '</b></a>  </td>
				<td>'  . $manager . '</td>
				<td><b>' . $requisitions[$department] . ' </b></td>
				<td><b>' . number_format($totalBudget,2) . '</b></td>
				<td><b>' . number_format($cost[$department],2) . '</b></td>
				<td><b>' . number_format($totalBudget-$cost[$department],2) . '</b></td>
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



