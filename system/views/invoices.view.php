<?php
require_once '/data/web/corelink.co.zm/management/vendor/autoload.php';

use Dompdf\Dompdf;

define('DOMPDF_ENABLE_PHP', true);

class invoices {

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
		<a href="' . $this->core->conf['conf']['path'] . '/quotation/manage/">Manage Quotations</a>
		<a href="' . $this->core->conf['conf']['path'] . '/clients/manage/">Clients</a>
		</div>';

		echo '<div class="toolbar">
		<a href="' . $this->core->conf['conf']['path'] . '/quotation/new/" class="green">New Quotation</a>
		<a href="' . $this->core->conf['conf']['path'] . '/quotation/requisitions/rejected" >Rejected Quotations</a>
		<a href="' . $this->core->conf['conf']['path'] . '/quotation/requisitions/expired" >Expired Quotations</a>
		</div>';
	}

	public function manageInvoices($item) {
		$uid = $this->core->userID;

	
		
		$this->viewMenu();
		$i = 1;
		
		
		echo '<div class="toolbar"> <div class="toolbaritem"> <b>Filter by : </b></div>
			<a href="' . $this->core->conf['conf']['path'] . '/quotation/manage/" class="green">ALL</a>
			<a href="' . $this->core->conf['conf']['path'] . '/quotation/manage/QUOTED" class="green">QUOTED</a>
			<a href="' . $this->core->conf['conf']['path'] . '/quotation/manage/INVOICED" class="green">INVOICED</a>
			<a href="' . $this->core->conf['conf']['path'] . '/quotation/manage/PAID" class="green">PAID</a>
		</div>';
		
		$filter = " WHERE `quotations`.Status IN ('INVOICED', 'PAID')";
		
		
		echo '<table id="active" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th bgcolor="#EEEEEE" width="30px" data-sort"string"><b> #</b></th>
							<th bgcolor="#EEEEEE"><b>Quotation</b></th>
							<th bgcolor="#EEEEEE"><b>Client</b></th>
							<th bgcolor="#EEEEEE"><b>Items</b></th>
							<th bgcolor="#EEEEEE"><b>Total Price</b></th>
							<th bgcolor="#EEEEEE"><b>STAGE</b></th>
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
		
		$sql = "SELECT `quotations`.*, `Firstname`, `Surname`, SUM(`quotation-lines`.ExpectedCost*`quotation-lines`.ItemQuantity) cost, COUNT(`quotation-lines`.ID) as items, `clients`.Name
		FROM `quotations`
		LEFT JOIN `quotation-lines` ON `quotations`.ID = `quotation-lines`.QuotationID
		LEFT JOIN `clients` ON `quotations`.Client = `clients`.ID
		LEFT JOIN `basic-information` ON `quotations`.`CreatedBy` = `basic-information`.ID
		$filter
		GROUP BY `quotations`.ID
		ORDER BY `DateCreated` ASC";
		$run = $this->core->database->doSelectQuery($sql);

		
		while ($fetch = $run->fetch_assoc()) {
			$prid = $fetch['ID'];
			$description = $fetch['Description'];
			$items = $fetch['items'];
			$amount = $fetch['cost'];
			$department = $fetch['department'];
			$stats = $fetch['Status'];
			$client = $fetch['Name'];
			$date = $fetch['DateCreated'];
			$currency = $fetch['Currency'];
			$currency = $fetch['Currency'];
			$requester = $fetch['FirstName'] .' ' . $fetch['Surname'];
			
			$currentyear = substr($date,0,4);
			if($lastyear == ''){
				$lastyear = $currentyear;
			}
			
			if($lastyear != $currentyear){
				echo '<tr style="background-color: #ccc;">
				<td></td>
				<td colspan="2"><b>TOTAL '.$item.'</b></td>
				<td><b>' . $currentyear . ' </b></td>
				<td><b>' . number_format($totalyear) . ' '.$currency.'</b></td>
				<td></td>
				<td></td>
				</tr>';
				$totalyear = 0;
			}
			

			if($currency == ''){
				$currency = "ZMW";
			}
			
			
			if($quotations[$prid] == ''){
				$quotations[$prid] = 0;
			}
			
			
			$managerApproval = $fetch['ManagerApproval'];

			
			
			if($stats == "QUOTED"){
				$status = '<b>QUOTED</b> - <a href="' . $this->core->conf['conf']['path'] . '/quotation/finalize/' . $prid . '/invoice/"><i>FINALIZE SALE</i></a>';
			}		
			
			if($stats == "INVOICED"){
				$status = '<b>INVOICED</b> - <a href="' . $this->core->conf['conf']['path'] . '/quotation/print/' . $prid . '/delivery/"><i>GENERATE DELIVERY NOTE</i></a>';
			}
				
			if($stats == "PAID"){
				$status = '<b>PAID</b> - <a href="' . $this->core->conf['conf']['path'] . '/quotation/print/' . $prid . '/receipt/"><i>GENERATE RECEIPT</i></a>';
			}
				
			echo '<tr '.$style.'>
				<td><b>Q'.$prid.'</b></td>
				<td><a href="' . $this->core->conf['conf']['path'] . '/quotation/show/' . $prid . '"><b>' . ucfirst($description) . '</b></a>  </td>
				<td>'  . $client . '</td>
				<td><b>' . $items . ' </b></td>
				<td><b>' .  number_format($amount) . ' '.$currency.'</b></td>
				<td><b>' . $status . '</b></td>
				<td><i>' . $date . '</i></td>
				</tr>';

			$totalyear = $amount+$totalyear;

			$i++;
			


			
			$lastyear = $currentyear;

		}
		
			echo '<tr style="background-color: #ccc;">
			<td></td>
			<td colspan="2"><b>TOTAL '.$item.'</b></td>
			<td><b>' . $currentyear . ' </b></td>
			<td><b>' . number_format($totalyear) . ' '.$currency.'</b></td>
			<td></td>
			<td></td>
			</tr>';
			$totalyear = 0;
		

		echo '</tbody>
		</table>';

	}
	
}

?>



