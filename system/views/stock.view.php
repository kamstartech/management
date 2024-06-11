<?php
class stock {

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
		<a href="' . $this->core->conf['conf']['path'] . '/orders/manage" class="green">Receive Goods</a>
		<a href="' . $this->core->conf['conf']['path'] . '/stock/voucher" >Give out goods</a>
		</div>';
	}

	
	public function saveStock($item){
		
		$idx = $item;
	
		$userid = $this->core->userID;
		$name = $this->core->cleanPost['name'];
		$category = $this->core->cleanPost['category'];
		$address = $this->core->cleanPost['address'];
		$email = $this->core->cleanPost['email'];
		$phone = $this->core->cleanPost['phone'];
		$tpin = $this->core->cleanPost['tpin'];
		$pacra = $this->core->cleanPost['pacra'];
		
				
		$quantity = $this->core->cleanPost['quantity']; 
		$unit = $this->core->cleanPost['unit'];
		$budgeted = $this->core->cleanPost['budgeted'];

		$i=0;
		$set = FALSE;
		foreach($name as $names){
			$curName = $names;
			$curSpecs = $specs[$i];
			$curQuantity = $quantity[$i];
			$curCost = $unit[$i];
			$received = $received[$i];
			
			$sql = "INSERT INTO `stock` (`ID`, `Name`, `Quantity`, `Unit`, `Location`, `Status`, `Category`, `Date`, `OrderID`) 
					VALUES (NULL, '$curName', '$curQuantity', '$curCost', 'Main Stores', '1', '$category', NOW(), '$idx');";

			if($this->core->database->doInsertQuery($sql)){
				echo '<div class="successpopup">Stock item has been added</div>';
			} else {
				echo '<div class="errorpopup">Stock item could not be added</div>';
			}
		}
			
		$this->manageStock('');
		 
	}
		 
	public function manageStock($item) {
		$departmentsManager = $this->getManager();

		$this->viewMenu($item, NULL);
		$role = $this->core->role;
	
	
		if($item !=''){
			echo '<div class="studentname">'.$item.'</div>';
			$filter = " AND `stock`.Category LIKE '$item'";
		}

		$sql = "SELECT * FROM `stock`
				WHERE `Status` = '1' 
				$filter
				ORDER BY `Name` ASC";

		$run = $this->core->database->doSelectQuery($sql);

		$i=0;
		while ($fetch = $run->fetch_assoc()) {
			$name = $fetch['Name'];
			$category = $fetch['Category'];
			$address = $fetch['Address'];
			$supid = $fetch['ID'];
			$quantity = $fetch['Quantity'];
			$added = substr($fetch['Date'],0,10);
			
			if($i ==0){
						
			
				echo'<table id="messages" class="table table-bordered  table-hover">
				<thead>
					<tr>
						<th bgcolor="#EEEEEE" width="30px"><b>#</b></th>
						<th bgcolor="#EEEEEE" width="30px"><b>Stock No.</b></th>
						<th bgcolor="#EEEEEE" width=""><b>Item Name</b></th>
						<th bgcolor="#EEEEEE" width=""><b>Category</b></th>
						<th bgcolor="#EEEEEE" width="120px"><b>Quantity</b></th>
						<th bgcolor="#EEEEEE" width="120px"><b>Date Added</b></th>
						<th bgcolor="#EEEEEE" width="150px">Manage</th>
					</tr>
				</thead>
				<tbody>';
			}

			$options = '<a href="' . $this->core->conf['conf']['path'] . '/stock/edit/' . $supid . '">Update</a>';

			$i++;
			
			echo'<tr>
				<td>'.$i.'</td>
				<td>'.$supid.'</td>
				<td><b><a href="' . $this->core->conf['conf']['path'] . '/stock/show/' . $supid . '">'.$name.'</a></b></td>
				<td><b>'.$category.'</b></td>
				<td><b>'.$quantity.'</b></td>
				<td>'.$added.'</td>
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

	
	public function receiveStock($item) {
		
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
		$optionBuilder = new optionBuilder($this->core);
		$departments = $optionBuilder->showDepartments();
		$suppliers = $optionBuilder->showSuppliers();
		
		
		$sql = "SELECT `orders`.*, `departments`.Name as department, `Firstname`, `Surname`, SUM(`order-lines`.ActualCost*`order-lines`.ItemQuantity) cost, COUNT(`order-lines`.ID) as items, ItemDescription  
				FROM `orders`
				LEFT JOIN `order-lines` ON `orders`.ID = `order-lines`.OrderID
				LEFT JOIN `staff` ON `staff`.ID = `RequestedBy`
				LEFT JOIN `basic-information` ON `staff`.ID = `basic-information`.ID
				LEFT JOIN `positions` ON `staff`.JobTitle = `positions`.ID
				LEFT JOIN `departments` ON `positions`.DepartmentID = `departments`.ID
				WHERE `orders`.ID = '$item'
				GROUP BY `orders`.ID";
				
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
			
			include $this->core->conf['conf']['formPath'] . "newstock.form.php";
			
		 }
	}
	
	public function voucherStock($item) {
		
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
		$optionBuilder = new optionBuilder($this->core);
		$departments = $optionBuilder->showDepartments();
		$suppliers = $optionBuilder->showSuppliers();
		
		$sql = "SELECT * FROM `stock`
				WHERE `stock`.ID = '$item'";
				
		$run = $this->core->database->doSelectQuery($sql);

		while ($fetch = $run->fetch_assoc()) {
			$prid = $fetch['ID'];
			$description = $fetch['Description'];
			$name = $fetch['Name'];
			$items = $fetch['items'];
			$cost = $fetch['cost'];
			$department = $fetch['department'];
			$quotations = $fetch['quotations']; 
			$status = $fetch['status'];
			$date = $fetch['DateCreated'];
			$category = $fetch['Category'];
			
			include $this->core->conf['conf']['formPath'] . "newstock.form.php";
			
		 }
	}


	public function labelStock($item) {
		echo "create asset label";
		
		// print asset label to place on new stock item.
	}
	
	public function grvStock($item) {
		echo "print GRV";
		
		// print the goods received voucher for the supplier and for finance
	}
	
	public function releaseStock($item) {
		echo "release stock item";
		
		// record what department receives the stock item
	}
}
?>