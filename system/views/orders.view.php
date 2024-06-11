<?php
class orders {

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
			<a href="' . $this->core->conf['conf']['path'] . '/procurement/requisitions/complete" class="green">New Purchase Order</a>
		</div>';
	}
	
	public function printOrders($item) {
		
		$output = $this->showOrders($item, TRUE);
		
		$path = "datastore/output/orders/";
		$filename =  $path . 'PO-'.$item.'.pdf';


		$owner = $this->core->userID;
		
		if(file_exists($filename)){
			$rand = rand(1111,9999);
			$filename =  $path . 'PO-'.$owner.'-'.$item.'-'.$rand.'.pdf';
		}

		require_once $this->core->conf['conf']['libPath'] . 'dompdf/dompdf_config.inc.php';

		$dompdf= new Dompdf();
		$dompdf->load_html($output);
		$dompdf->render();

		$pdf = $dompdf->output();
		file_put_contents($filename, $pdf);

		
		$mime = mime_content_type($filename);
		header('Content-type: '.$mime);
		header('Content-Disposition: attachment; filename=PO-'.$item.'.pdf');
		header('Content-Length: ' . filesize($filename));
		$content = readfile($filename);
			
	}
	

	public function manageOrders($item) {

		$departmentsManager = $this->getManager();
		$uid = $this->core->userID;

		if($item == ""){
			$item = "%";
		}
		
		$this->viewMenu();
		$i = 1;
		
		echo '<table id="active" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th bgcolor="#EEEEEE" width="30px" data-sort"string"><b> PO#</b></th>
						<th bgcolor="#EEEEEE"><b>Order</b></th>
						<th bgcolor="#EEEEEE"><b>Department</b></th>
						<th bgcolor="#EEEEEE"><b>Items</b></th>
						<th bgcolor="#EEEEEE"><b>Total Cost</b></th>
						<th bgcolor="#EEEEEE"><b>Supplier</b></th>
						<th bgcolor="#EEEEEE"><b>Status</b></th>
						<th bgcolor="#EEEEEE"><b>Date Created</b></th>
					</tr>
				</thead>
				<tbody>';

		$sql = "SELECT `orders`.*, `departments`.Name as department, `Firstname`, `Surname`, SUM(`order-lines`.ActualCost*`order-lines`.ItemQuantity) cost, COUNT(`order-lines`.ID) as items  
		FROM `orders`
		LEFT JOIN `order-lines` ON `orders`.ID = `order-lines`.OrderID
		LEFT JOIN `staff` ON `staff`.ID = `RequestedBy`
		LEFT JOIN `basic-information` ON `staff`.ID = `basic-information`.ID
		LEFT JOIN `departments` ON `staff`.SchoolID = `departments`.ID
			GROUP BY `orders`.ID";
		$run = $this->core->database->doSelectQuery($sql);

		while ($fetch = $run->fetch_assoc()) {
			$prid = $fetch['ID'];
			$description = $fetch['Description'];
			$items = $fetch['items'];
			$cost = $fetch['cost'];
			$department = $fetch['department'];
			$quotations = $fetch['quotations'];
			$prstatus = $fetch['Status'];
			$supplier = $fetch['Supplier'];
			$date = $fetch['DateCreated'];
			$requester = $fetch['FirstName'] .' ' . $fetch['Surname'];

			
			$cost =  number_format($cost) . " ZMW";
			
			if($quotations[$prid] == ''){
				$quotations[$prid] = 0;
			}
			
			
			$managerApproval = $fetch['SupplierApproval'];		// Delivery
			$procurementApproval = $fetch['StoresApproval'];	// Awaiting GRV
			$financeApproval = $fetch['FinanceApproval'];		// Awaiting payment

			
			if(substr($prstatus,0,8) != 'REJECTED'){
				if(in_array($department, $departmentsManager)){
					$status = '<b><a href="' . $this->core->conf['conf']['path'] . '/procurement/pr/' . $prid . '">ACTION REQUIRED</a></b>';
				}
				
				if($directorApproval == ''){
					$status = "<b>AWAITING: </b>";
				}else {
					$status = "<b>FULLY APPROVED</b>";
				}
				if($managerApproval != '' && $procurementApproval == '' && $financeApproval == '' && $managementApproval == '' && $directorApproval == '' && $auditorApproval == ''){
					$complete = TRUE;
				}
				
				
				if($managerApproval == ''){
					$status .= '<a href="' . $this->core->conf['conf']['path'] . '/stock/receive/' . $prid . '"><b>Supplier Delivery</b></a>';
				} else if($procurementApproval == ''){
					$status .= 'Goods Received';
				} else if($financeApproval == ''){
					$status .= 'Payment';
				}
				

			
			}else {
				$status = '<span style="color: #e20303;">'.$prstatus.'</span>';
			}
				
			echo '<tr '.$style.'>
				<td><b>PO'.$prid.'</b></td>
				<td><a href="' . $this->core->conf['conf']['path'] . '/orders/show/' . $prid . '"><b>' . $description . '</b></a>  </td>
				<td>'  . $department . '</td>
				<td><b>' . $items . ' </b></td>
				<td><b>' . $cost . '</b></td>
				<td><b>' . $supplier . '</b></td>
				<td><b>' . $status . '</b></td>
				<td><i>' . $date . '</i></td>
				</tr>';


			$i++;
		}

		echo '</tbody>
		</table>';

	}
	
	
	public function generateOrders($item) {
		
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
		$optionBuilder = new optionBuilder($this->core);
		$departments = $optionBuilder->showDepartments();
		$suppliers = $optionBuilder->showSuppliers();
		
		
		$sql = "SELECT `requisitions`.*, `departments`.Name as department, `Firstname`, `Surname`, SUM(`requisition-lines`.ExpectedCost*`requisition-lines`.ItemQuantity) cost, COUNT(`requisition-lines`.ID) as items, ItemDescription  
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
			$specifications = $fetch['ItemDescription'];
			$items = $fetch['items'];
			$cost = $fetch['cost'];
			$department = $fetch['department'];
			$quotations = $fetch['quotations']; 
			$status = $fetch['status'];
			$date = $fetch['DateCreated'];
			$category = $fetch['Category'];
			$requester = $fetch['FirstName'] .' ' . $fetch['Surname'];
			
			$directorApproval = $fetch['DirectorApproval'];	
		
			if($directorApproval != ''){
				include $this->core->conf['conf']['formPath'] . "neworder.form.php";
			}
		 }
	}

	public function approveOrders() {
		echo "approve an order";
	}
	
	public function rejectOrders() {
		echo "reject an order";
	}
	
	public function finalizeOrders() {
		echo "finalize an order";
	}
	
	
	
	public function saveOrders($item) {

		echo '<div class="toolbar">
		<a href="' . $this->core->conf['conf']['path'] . '/orders/manage/">Back to Overview</a>
		</div>';
		
		$userid = $this->core->userID;
		$description = $this->core->cleanPost['description'];
		$category = $this->core->cleanPost['category'];
		$supplier = $this->core->cleanPost['supplier'];
		
		$sql = "INSERT INTO `orders` (`ID`, `Description`, `Category`, `DateCreated`, `RequestedBy`, `Status`, `Supplier`) 
				VALUES (NULL, '$description', '$category', NOW(), '$userid', 'Order generated', '$supplier');";

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
			$ordered = $budgeted[$i];
			
			if($ordered == 'on'){
				$ordered = 1;
			} else{
				$ordered = 0;
				continue;
			}
			
			if($curName != ''){
			$sql = "INSERT INTO `order-lines` (`ID`, `OrderID`, `ItemName`, `ItemDescription`, `ItemQuantity`, `ActualCost`, `SuggestedSuppliers`, `DateRequire`, `BudgetAllocation`, `BudgetVariation`, `Image`) 
			VALUES (NULL, '$prn', '$curName', '$curSpecs', '$curQuantity', '$curCost', '$curSuppliers', NOW(), '$curCost', '$ordered', '');";

			$this->core->database->doInsertQuery($sql);
			
			}
			
			$set = TRUE;
		}
		
		if($set == TRUE){
			echo '<div class="successpopup">Purchase Order #'.$prn.' created</div>';
		}else{
			echo '<div class="errorpopup">No lines were added.</div>';
		}
	}
	
	
	public function showOrders($item, $print=FALSE) {
		
		$sql = "SELECT `orders`.*, `departments`.Name as department, `Firstname`, `Surname`, SUM(`order-lines`.ActualCost*`order-lines`.ItemQuantity) cost, COUNT(`order-lines`.ID) as items , `suppliers`.Category as OrderCat, `suppliers`.Name as SupName 
				FROM `orders`
				LEFT JOIN `order-lines` ON `orders`.ID = `order-lines`.OrderID
				LEFT JOIN `staff` ON `staff`.ID = `RequestedBy`
				LEFT JOIN `basic-information` ON `staff`.ID = `basic-information`.ID
				LEFT JOIN `positions`  ON `staff`.JobTitle = `positions`.ID
				LEFT JOIN `departments` ON `positions`.DepartmentID = `departments`.ID
				LEFT JOIN `suppliers` ON `orders`.Supplier = `suppliers`.ID
				WHERE `orders`.ID = '$item'
				GROUP BY `orders`.ID";
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
			$category = $fetch['OrderCat'];
			$supplier = $fetch['SupName'];
			$requester = $fetch['FirstName'] .' ' . $fetch['Surname'];


			if($print == FALSE){
				$departmentsManager = $this->getManager();
				
				// SHOW MENU
				$output .= '<div class="toolbar">
						<a href="' . $this->core->conf['conf']['path'] . '/orders/manage/">Back to Overview</a>
						<a href="' . $this->core->conf['conf']['path'] . '/orders/print/'.$item.'">Print Order</a>';
				
				if(in_array($department, $departmentsManager)){
						$output .= '<a class="green" href="' . $this->core->conf['conf']['path'] . '/stock/receive/'.$item.'">Receive Goods</a>';
						$output .= '<a class="red" href="' . $this->core->conf['conf']['path'] . '/orders/cancel/'.$item.'">Cancel Order</a>';
				}
				$output .='</div>
				<h1>PURCHASE ORDER</h1>';
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
						<td style="width: 400px;"><center><a href="https://www.edenuniversity.edu.zm"><img height="90px" src="/var/www/html/templates/mobile/images/header.png" /></a></center><br><br>
						<div style="font-size: 13pt;"><b>EDEN UNIVERSITY</b></div>
						</td>
						<td style="padding-left: 30px; font-size: 11pt; color: #333; ">
							<br>Barlastone, Lusaka, Zambia
							<br> <a href="mailto:info@edenuniversity.edu.zm">info@edenuniversity.edu.zm</a>
							<br> CEL: +260 211 12345
					</td>
					</tr>
					</table> 
					<h1>PURCHASE ORDER</h1>
					<div style="border-bottom: 1px solid #333; width: 100%; margin-bottom: 20px;">&nbsp;</div>';
			}
			
			$cost =  number_format($cost) . " ZMW";
			
			if($quotations[$prid] == ''){
				$quotations[$prid] = 0;
			}
			
			

			$managerApproval = $fetch['SupplierApproval'];		// Delivery
			$procurementApproval = $fetch['StoresApproval'];	// Awaiting GRV
			$financeApproval = $fetch['FinanceApproval'];		// Awaiting payment

			
			if(substr($prstatus,0,8) != 'REJECTED'){
				if(in_array($department, $departmentsManager)){
					$status = '<b><a href="' . $this->core->conf['conf']['path'] . '/procurement/pr/' . $prid . '">ACTION REQUIRED</a></b>';
				}
				
				if($directorApproval == ''){
					$status = "<b>AWAITING: </b>";
				}else {
					$status = "<b>FULLY APPROVED</b>";
				}
				if($managerApproval != '' && $procurementApproval == '' && $financeApproval == '' && $managementApproval == '' && $directorApproval == '' && $auditorApproval == ''){
					$complete = TRUE;
				}
				
				
				if($managerApproval == ''){
					$status .= 'Supplier delivery';
				} else if($procurementApproval == ''){
					$status .= 'Goods Received';
				} else if($financeApproval == ''){
					$status .= 'Payment';
				}
				
			}
			
			
			$output .= '<table class="">
				<tr>
					<td style="width: 250px;">Purchase Order Number: </td>
					<td><b>PO'.$prid.'</b></td>
				</tr>
				<tr>
					<td>Description of PO: </td>
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
					<td>Total cost: </td>
					<td><b>' . $cost . '</b></td>
				</tr>
				<tr>
					<td>Required Delivery Period: </td>
					<td><b>30 days</b></td>
				</tr>
				<tr>
					<td>Payment Terms: </td>
					<td><b>Payment on delivery</b></td>
				</tr>
				<tr>
					<td>Supplier: </td>
					<td><b>' . $supplier . '</b></td>
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
				
						
				$sql = "SELECT * FROM `order-lines` 
						WHERE `order-lines`.OrderID = $item";
				$rund = $this->core->database->doSelectQuery($sql);

				$output .= '<h2>PURCHASE ORDER ITEMS</h2><br>
				<table class="table table-responsive-sm" border="1" width="100%">
							<tr style="font-weight: bold; text-align: left;" align="left" class="thead-dark">
								<th>#</th>
								<th>Item Name</th>
								<th>Item Specifications</th>
								<th>Quantity</th>
								<th>Unit Cost</th>
								<th>Total Cost</th>
							</tr>';
				$x=1;
				
				while ($fetchd = $rund->fetch_assoc()) {
					$plid = $fetchd['ID'];
					$name = $fetchd['ItemName'];
					$specs = $fetchd['ItemDescription'];
					$quantity = $fetchd['ItemQuantity'];
					$unit = $fetchd['ActualCost'];
					$cost = $unit*$quantity;
					$budgeted = $fetchd['BudgetVariation'];
					if($budgeted == 1){
						$budgeted = "NOT BUDGETED";
					} else{
						$budgeted = "BUDGETED";
					}
					
					
					
					$output .= '<tr>
							<td style="width:20px;">'.$x.'</td>
							<td><b>'.$name.'</b></td>
							<td>'.$specs.'</td>
							<td style="width:80px;">'.$quantity.'</td>
							<td style="width:100px;">'.number_format($unit,2).'</td>
							<td style="width:100px;"><b>'.number_format($cost,2).'</b></td>
						</tr>';
					$x++;
					
					$totcost = $totcost+$cost;
					$totquantity = $totquantity+$quantity;
					
				}


				$output .= '<tr class="table-dark" style="border-top: 1px solid #333 !important;">
							<td style="width:20px;"></td>
							<td style="width:260px;"><b>TOTAL</b></td>
							<td></td>
							<td></td>
							<td></td>
							<td><b>'.number_format($totcost,2).'</b></td>
						</tr>
				</table>';

									
				$sql = "SELECT `FirstName`, `MiddleName`, `Surname`, `DateCreated`, 'Original Request', 'Original Request' FROM `requisitions` LEFT JOIN `staff` ON `requisitions`.`RequestedBy` = `staff`.ID LEFT JOIN `basic-information` ON `requisitions`.`RequestedBy` = `basic-information`.ID  WHERE `requisitions`.`ID` =  '$item'
				  UNION SELECT `FirstName`, `MiddleName`, `Surname`, `ManagerApprovalDate`, `ManagerApprovalComment`, 'Department Manager' FROM `requisitions` LEFT JOIN `staff` ON `requisitions`.`ManagerApproval` = `staff`.ID LEFT JOIN `basic-information` ON `requisitions`.`ManagerApproval` = `basic-information`.ID  WHERE `requisitions`.`ID` =  '$item'
				  UNION SELECT `FirstName`, `MiddleName`, `Surname`, `ProcurementApprovalDate`, `ProcurementApprovalComment`, 'Procurement Level'   FROM `requisitions` LEFT JOIN `staff` ON `requisitions`.`ProcurementApproval` = `staff`.ID LEFT JOIN `basic-information` ON `requisitions`.`ProcurementApproval` = `basic-information`.ID  WHERE `requisitions`.`ID` =  '$item'
				  UNION SELECT `FirstName`, `MiddleName`, `Surname`, `FinanceApprovalDate`, `FinanceApprovalComment`, 'Finance Level'   FROM `requisitions` LEFT JOIN `staff` ON `requisitions`.`FinanceApproval` = `staff`.ID LEFT JOIN `basic-information` ON `requisitions`.`FinanceApproval` = `basic-information`.ID  WHERE `requisitions`.`ID` =  '$item'
				  UNION SELECT `FirstName`, `MiddleName`, `Surname`, `ManagementApprovalDate`, `ManagementApprovalComment`, 'Management Level'   FROM `requisitions` LEFT JOIN `staff` ON `requisitions`.`ManagementApproval` = `staff`.ID LEFT JOIN `basic-information` ON `requisitions`.`ManagementApproval` = `basic-information`.ID  WHERE `requisitions`.`ID` =  '$item'
				  UNION SELECT `FirstName`, `MiddleName`, `Surname`, `DirectorApprovalDate`, `DirectorApprovalComment`, 'Director Level'   FROM `requisitions` LEFT JOIN `staff` ON `requisitions`.`DirectorApproval` = `staff`.ID LEFT JOIN `basic-information` ON `requisitions`.`DirectorApproval` = `basic-information`.`ID`  WHERE `requisitions`.`ID` =  '$item'
				  UNION SELECT `FirstName`, `MiddleName`, `Surname`, `AuditApprovalDate`, `AuditApprovalComment`, 'Audit Level'   FROM `requisitions` LEFT JOIN `staff` ON `requisitions`.`AuditApproval` = `staff`.ID LEFT JOIN `basic-information` ON `requisitions`.`AuditApproval` = `basic-information`.ID  WHERE `requisitions`.`ID` =  '$item'";
				
				$rund = $this->core->database->doSelectQuery($sql);

				$output .=  '<br><br>
				<h2>APPROVAL FLOW</h2>';
				$output .=  '<table class="table table-responsive-sm" style="width: 650px;" border="1">
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