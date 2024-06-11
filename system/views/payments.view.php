 <?php
class payments{

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
	


	public function editPayments($item) {
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
		
			include $this->core->conf['conf']['formPath'] . "newclients.form.php";
		}
	}
	
	public function deletePayments($item) {

		$sql = "UPDATE `clients` 
				SET	`Status` = '5'
				WHERE `ID` = '$item'";

		$run = $this->core->database->doSelectQuery($sql);

		$this->manageClients('');
	}
	

	public function addPayments($item) {
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";

		
		include $this->core->conf['conf']['formPath'] . "addpayment.form.php";
	}



	public function savePayments($item) {
		$uid = $this->core->cleanGet['uid'];
		$amount = $this->core->cleanGet['amount'];
		$description = $this->core->cleanGet['description'];
		$type = $this->core->cleanGet['paymenttype'];
		$date = $this->core->cleanGet['date'];
		$reference = $this->core->cleanGet['reference'];

		$outtype = "CASH PAYMENT";
		

		echo'<div class="heading">'. $this->core->translate("Confirm payment/billing") .'</div>
		<form id="savepayment" name="savepayment" method="get" action="'. $this->core->conf['conf']['path'] .'/payments/transact">
		<p><b>Please confirm the following information is correct:</b><br>
		
		<div class="label">'. $this->core->translate("Student") .':</div><div class="label">'.$uid.'</div><br>
		<div class="label">'. $this->core->translate("Payment Amount") .':</div><div class="label">'.$amount.'</div><br>
		<div class="label">'. $this->core->translate("Description") .' :</div><div class="label">'.$description.'</div><br>
		<div class="label">'. $this->core->translate("Payment Type") .':</div><div class="label">'.$outtype.'</div><br>
		<div class="label">'. $this->core->translate("Payment Reference") .':</div><div class="label">'.$reference.'</div><br>
		<div class="label">'. $this->core->translate("Payment Date") .':</div><div class="label">'.$date.'</div><br>

		<input type="hidden" name="uid" value="'.$uid.'">
		<input type="hidden" name="amount" value="'.$amount.'">
		<input type="hidden" name="description" value="'.$description.'">
		<input type="hidden" name="paymenttype" value="'.$type.'">
		<input type="hidden" name="reference" value="'.$reference.'">
		<input type="hidden" name="date" value="'.$date.'">
	
		</p><p><button onclick="window.history.back();" name="no"  id="no" class="input submit" style="font-size: 18px; font-weight: bold; padding: 5px; padding-left: 20px; padding-right: 20px; padding-bottom: 10px; border: 1px solid #000; background-color: #e81f1f"> <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"> NO</button> 
		<button onclick="this.form.submit();" class="input submit" style="font-size: 18px; font-weight: bold; padding: 5px;  padding-left: 20px; padding-bottom: 10px; padding-right: 20px; border: 1px solid #000; background-color: #39c541"> <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"> YES</button></p>
		</form>';
	}

	public function transactPayments($item) {
		$uid = $this->core->cleanGet['uid'];
		$amount = $this->core->cleanGet['amount'];
		$description = $this->core->cleanGet['description'];
		$type = $this->core->cleanGet['paymenttype'];
		$date = $this->core->cleanGet['date'];
		$reference = $this->core->cleanGet['reference'];
		
		$this->makePayments($item, $uid, $amount, $description, $type, $date, $reference);
		
		$this->core->redirect("payments", "manage");
	}
	
	
	
	public function managePayments() {

		echo '<div class="toolbar">
		<a href="' . $this->core->conf['conf']['path'] . '/payments/manage/">Back to Overview</a>
		<a href="' . $this->core->conf['conf']['path'] . '/payments/add/">Add Payment</a></div>';
				
		$today = date("Y-m-d");


		$sql = "SELECT *, `transactions`.ID as PID 
		FROM `transactions`
		LEFT JOIN `clients` ON `transactions`.CustomerID = `clients`.ID 
		ORDER BY `transactions`.TransactionDate ASC";
		

		$run = $this->core->database->doSelectQuery($sql);



		echo'<div class="mobilescroll">
		<table width="100%" height="" border="0" cellpadding="3" cellspacing="0" class="table table-striped">'.
		'<tr class="tableheader">
		<td width=""><b>Bank</b></td>
		<td width=""><b>Transaction ID</b></td>' .
		'<td width=""><b>Date/Time</b></td>' .
		'<td width=""><b>Amount</b></td>' .
		'<td width=""><b>VAT</b></td>' .
		'<td width=""><b>Client</b></td>' .
		'<td width=""><b>Reference</b></td>' .
		'<td><b>Management</b></td>' .
		'</tr>';

		$i = 0;
		$percent = 0;
		$percenttwo = 0;
		$color = "";
		$name = "";
		$userid = "";
		$output = "";


		while ($fetch = $run->fetch_assoc()) {

			$bank =  $fetch['Bank'];
			$date =  $fetch['TransactionDate'];
			$name = $fetch['FirstName'] . ' ' . $fetch['MiddleName'] . ' ' . $fetch['Surname'];

			if(!empty($name)){
				$matched = TRUE;
			} else {
				$matched = FALSE;
			}



				$edit = "reassign";
			if($fetch['Status'] == "MANUAL"){
				$color = 'style="color: #D61EBE;"';
			}

			$userid = $fetch['UID'];
			$amount =  $fetch['Amount'];
			$amountb =  $fetch['Amount'];
			$ipaddr =  $fetch['Phone']; 
			$Type =  $fetch['Type']; 
			$description =  $fetch['Description']; 
			$total =  $fetch['Amount']+$total;

			if($Type == 1){
				$vat = $amount/1.16;
			} else {
				$vat = 0;
			}
			
			$output .= '<tr ' . $color . '>
			<td><b>' . $bank . '</b></td>
			<td><b><a href="' . $this->core->conf['conf']['path'] . '/payments/view/' . $fetch['PID'] . '"> ' . $fetch['TransactionID'] . '</a></b></td>
			<td>' . $date . '</td>
			<td><b>' . number_format($amount) . ' ZMW</b></td>
			<td><b>' . number_format($vat) . ' ZMW</b></td>
			<td><a href="' . $this->core->conf['conf']['path'] . '/clients/show/'. $userid .'?payid='.$userid.'&date='.$today.'">'.$name.'</a></td>
			<td>'. $description.'</td>';

			if($print != TRUE){
				$output .='<td>
				<a href="' . $this->core->conf['conf']['path'] . '/payments/assign/' . $fetch[0] . '?date='.$today.'"> <img src="' . $this->core->fullTemplatePath . '/images/edi.png"> '.$edit.'</a>
	 			</td>';
			}

			$output .= '</tr>';
		}

		$total = number_format($total);
		$today = date("l - Y-m-d", strtotime($today));
		$year = date("Y");
 
		echo '<div class="successpopup"> Total revenue for  '.$year.' at the time of printing is: '.$total.' '.$this->core->conf['conf']['currency'].' over a total of '.$run->num_rows . " payments</div>";
		echo $output;
		echo '</table></div>';


	}
}
?>