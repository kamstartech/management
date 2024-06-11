<?php
class clients{

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
		<a href="' . $this->core->conf['conf']['path'] . '/quotation/manage/">Quotations</a>
		<a href="' . $this->core->conf['conf']['path'] . '/clients/manage/">Clients</a>
		</div>';

		echo '<div class="toolbar">
		<a href="' . $this->core->conf['conf']['path'] . '/clients/add/" class="green">New Client</a>
		<a href="' . $this->core->conf['conf']['path'] . '/clients/manage/deleted" >Deleted clients</a>
		</div>';
	}

	public function editClients($item) {
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
 
		$select = new optionBuilder($this->core);
		$staff = $select->showUsers(100);
		
		$sql = "SELECT * FROM `clients`
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
			$brn = $fetch['BRN'];
			$tpin = $fetch['TPIN'];
		
		include $this->core->conf['conf']['formPath'] . "newclient.form.php";
		}
	}
	
	public function deleteClients($item) {

		$sql = "UPDATE `clients` 
				SET	`Status` = '5'
				WHERE `ID` = '$item'";

		$run = $this->core->database->doSelectQuery($sql);

		$this->manageClients('');
	}
	

	public function addClients($item) {
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
 
		$select = new optionBuilder($this->core);
		$staff = $select->showUsers(100);
		
		include $this->core->conf['conf']['formPath'] . "newclient.form.php";
	}
	
	
	public function saveClients($item){
		
		if($item != ''){
			$idx = $item;
		} else {
			$idx = 'NULL';
		}
		
		$userid = $this->core->userID;
		$name = $this->core->cleanPost['name'];
		$contact = $this->core->cleanPost['ContactName'] ?? NULL;
		$address = $this->core->cleanPost['address'];
		$email = $this->core->cleanPost['email'];
		$phone = $this->core->cleanPost['phone'];
		$contact = $this->core->cleanPost['contact'] ?? NULL;
		$terms = $this->core->cleanPost['terms'] ?? NULL;
		$pacra = $this->core->cleanPost['pacra'];
		$tpin = $this->core->cleanPost['tpin'];
		
		if($tpin == ''){
			$tpin = 'NULL';		
		}
		if($pacra == ''){
			$pacra = 'NULL';	
		}
		$sql = "REPLACE INTO `clients` (`ID`, `Name`, `Email`, `Phone`, `Address`, `PaymentTerms`, `ContactName`, `DateCreated`, `CreatedBy`, `Status`, `TPIN`, `BRN`) 
							VALUES 	   ($idx, '$name', '$email', '$phone', '$address', '$terms', '$contact', NOW(), '$userid', '1', $tpin, $pacra);";

		if($this->core->database->doInsertQuery($sql)){
			echo '<div class="successpopup">Client has been added</div>';
			$this->manageClients('');
		} else {
			echo '<div class="errorpopup">Client could not be added</div>';
			$this->manageClients('');
		}
		 
	}
		 
	public function manageClients($item) {
		$departmentsManager = $this->getManager();

		$this->viewMenu($item, NULL);
		$role = $this->core->role;
	
	
		if($item !=''){
			echo '<div class="studentname">'.$item.'</div>';
			$filter = " AND `clients`.Category LIKE '$item'";
		}

		$sql = "SELECT * FROM `clients`
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
						<th bgcolor="#EEEEEE" width="30px"><b>Client No.</b></th>
						<th bgcolor="#EEEEEE" width=""><b>Client Name</b></th>
						<th bgcolor="#EEEEEE" width=""><b>Category</b></th>
						<th bgcolor="#EEEEEE" width="120px"><b>Date Added</b></th>
						<th bgcolor="#EEEEEE" width="150px">Manage</th>
					</tr>
				</thead>
				<tbody>';
			}

			$options = '<a href="' . $this->core->conf['conf']['path'] . '/clients/edit/' . $supid . '">Edit</a> - ';
			$options .= '<a href="' . $this->core->conf['conf']['path'] . '/clients/delete/' . $supid . '">Delete</a> ';

			$i++;
			
			echo'<tr>
				<td>'.$i.'</td>
				<td>'.$supid.'</td>
				<td><b><a href="' . $this->core->conf['conf']['path'] . '/information/show/' . $supid . '">'.$name.'</a></b></td>
				<td><b><a href="' . $this->core->conf['conf']['path'] . '/clients/manage/' . $category . '">'.$category.'</a></b></td>
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