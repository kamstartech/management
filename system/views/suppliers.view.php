<?php
class suppliers{

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
		<a href="' . $this->core->conf['conf']['path'] . '/suppliers/add/" class="green">New Supplier</a>
		<a href="' . $this->core->conf['conf']['path'] . '/suppliers/manage/deleted" >Deleted Suppliers</a>
		</div>';
	}

	public function editSuppliers($item) {
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
 
		$select = new optionBuilder($this->core);
		$staff = $select->showUsers(100);
		
		$sql = "SELECT * FROM `suppliers`
				WHERE `ID` = '$item'";

		$run = $this->core->database->doSelectQuery($sql);

		$i=0;
		while ($fetch = $run->fetch_assoc()) {
			$name = $fetch['Name'];
			$category = $fetch['Category'];
			$address = $fetch['Address'];
			$sid = $fetch['ID'];
			$phone = $fetch['Phone'];
			$email = $fetch['Email'];
			$tpin = $fetch['TaxCertificate'];
			$pacra = $fetch['RegistrationCertificate'];
		
			include $this->core->conf['conf']['formPath'] . "newsupplier.form.php";
		}
	}
	
	public function deleteSuppliers($item) {

		$sql = "UPDATE `suppliers` 
				SET	`Status` = '5'
				WHERE `ID` = '$item'";

		$run = $this->core->database->doSelectQuery($sql);

		$this->manageSuppliers('');
	}
	

	public function addSuppliers($item) {
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
 
		$select = new optionBuilder($this->core);
		$staff = $select->showUsers(100);
		
		include $this->core->conf['conf']['formPath'] . "newsupplier.form.php";
	}
	
	
	public function saveSuppliers($item){
		
		if($item != ''){
			$idx = $item;
		} else {
			$idx = 'NULL';
		}
		
		$userid = $this->core->userID;
		$name = $this->core->cleanPost['name'];
		$category = $this->core->cleanPost['category'];
		$address = $this->core->cleanPost['address'];
		$email = $this->core->cleanPost['email'];
		$phone = $this->core->cleanPost['phone'];
		$tpin = $this->core->cleanPost['tpin'];
		$pacra = $this->core->cleanPost['pacra'];
		
		$sql = "REPLACE INTO `suppliers` (`ID`, `Name`, `Category`, `Address`, `Created`, `Email`, `Phone`, `TaxCertificate`, `RegistrationCertificate`, `Status`) 
		VALUES ($idx, '$name', '$category', '$address', NOW(), '$email', '$phone', '$tpin', '$pacra', '1');";

		if($this->core->database->doInsertQuery($sql)){
			echo '<div class="successpopup">Supplier has been added</div>';
			$this->manageSuppliers('');
		} else {
			echo '<div class="errorpopup">Supplier could not be added</div>';
			$this->manageSuppliers('');
		}
		 
	}
		 
	public function manageSuppliers($item) {
		$departmentsManager = $this->getManager();

		$this->viewMenu($item, NULL);
		$role = $this->core->role;
	
	
		if($item !=''){
			echo '<div class="studentname">'.$item.'</div>';
			$filter = " AND `suppliers`.Category LIKE '$item'";
		}

		$sql = "SELECT * FROM `suppliers`
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
			$added = substr($fetch['Created'],0,10);
			
			if($i ==0){
						
			
				echo'<table id="messages" class="table table-bordered  table-hover">
				<thead>
					<tr>
						<th bgcolor="#EEEEEE" width="30px"><b>#</b></th>
						<th bgcolor="#EEEEEE" width="30px"><b>Supplier No.</b></th>
						<th bgcolor="#EEEEEE" width=""><b>Supplier Name</b></th>
						<th bgcolor="#EEEEEE" width=""><b>Category</b></th>
						<th bgcolor="#EEEEEE" width="120px"><b>Date Added</b></th>
						<th bgcolor="#EEEEEE" width="150px">Manage</th>
					</tr>
				</thead>
				<tbody>';
			}

			$options = '<a href="' . $this->core->conf['conf']['path'] . '/suppliers/edit/' . $supid . '">Edit</a> - ';
			$options .= '<a href="' . $this->core->conf['conf']['path'] . '/suppliers/delete/' . $supid . '">Delete</a> ';

			$i++;
			
			echo'<tr>
				<td>'.$i.'</td>
				<td>'.$supid.'</td>
				<td><b><a href="' . $this->core->conf['conf']['path'] . '/information/show/' . $supid . '">'.$name.'</a></b></td>
				<td><b><a href="' . $this->core->conf['conf']['path'] . '/suppliers/manage/' . $category . '">'.$category.'</a></b></td>
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
}
?>