<?php
require_once '/data/web/corelink.co.zm/management/vendor/autoload.php';

use Dompdf\Dompdf;

define('DOMPDF_ENABLE_PHP', true);

class quotation {

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

	public function newQuotation($item) {
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
		$optionBuilder = new optionBuilder($this->core);
		$clients = $optionBuilder->showClients();
		
		include $this->core->conf['conf']['formPath'] . "newquotation.form.php";
	}
		
	public function finalizeQuotation($item) {
		$sql = "UPDATE `quotations` SET `Status` = 'INVOICED' WHERE `ID` = '$item'";
		$this->core->database->doInsertQuery($sql);
		
		$this->showQuotation($item);
	}

	public function saveQuotation($item) {
		echo '<div class="toolbar">
		<a href="' . $this->core->conf['conf']['path'] . '/quotation/manage/">Back to Overview</a>
		</div>';
		
		$userid = $this->core->userID;
		$description = $this->core->cleanPost['description'];
		$client = $this->core->cleanPost['client'];
		
		$currency = $this->core->cleanPost['currency'];
		$terms = $this->core->cleanPost['terms'];
		
		$sql = "INSERT INTO `quotations` (`ID`, `Description`, `Client`, `DateCreated`, `CreatedBy`, `Status`,  `Currency`, `Terms`) 
				VALUES (NULL, '$description', '$client', NOW(), '$userid', 'QUOTED', '$currency', '$terms');";
		
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
		$stock = $this->core->cleanPost['stock'];

		$i=0;
		$set = FALSE;
		foreach($name as $names){
			$curName = $names;
			$curSpecs = $specs[$i];
			$curQuantity = $quantity[$i];
			$curCost = $cost[$i];
			$curStock = $stock[$i];
			
			if($curStock == 'on'){
				$curStock = 1;
			} else{
				$curStock = 0;
			}
			
			if($curName != ''){
				$sql = "INSERT INTO `quotation-lines` (`ID`, `QuotationID`, `ItemName`, `ItemDescription`, `ItemQuantity`, `ExpectedCost`, `SuggestedSuppliers`, `DateRequire`, `BudgetAllocation`, `BudgetVariation`, `Image`) 
						VALUES (NULL, '$prn', '$curName', '$curSpecs', '$curQuantity', '$curCost', '$curSuppliers', NOW(), '$curCost', '$curStock', '');";

				$this->core->database->doInsertQuery($sql);
		
			}
			
			$set = TRUE;
			$i++;
		}

		if($set == TRUE){
			echo '<div class="successpopup">Quotation #'.$prn.' created</div>';
		}else{
			echo '<div class="errorpopup">No lines were added.</div>';
		}
	}

	public function showQuotation($item, $print=FALSE) { 

		$sql = "SELECT COUNT(`registry`.StudentID) count
		FROM `registry`
		WHERE `registry`.Category = 'Quote'
		AND `registry`.StudentID = '$item'
		GROUP BY `registry`.StudentID ";
	
		$run = $this->core->database->doSelectQuery($sql);
		
		$documents = $run->num_rows;
		
		
		$sql = "SELECT `quotations`.*, `Firstname`, `Surname`, SUM(`quotation-lines`.ExpectedCost*`quotation-lines`.ItemQuantity) cost, `clients`.BRN, `clients`.TPIN, COUNT(`quotation-lines`.ID) as items,`clients`.ID as CID, `clients`.Address,`clients`.Name, `clients`.Phone, `clients`.Email, `quotations`.Status
		FROM `quotations`
		LEFT JOIN `quotation-lines` ON `quotations`.ID = `quotation-lines`.QuotationID
		LEFT JOIN `clients` ON `quotations`.Client = `clients`.ID
		LEFT JOIN `basic-information` ON `quotations`.`CreatedBy` = `basic-information`.ID
		WHERE `quotations`.ID = '$item'
		GROUP BY `quotations`.ID";

		$run = $this->core->database->doSelectQuery($sql);
		
		while ($fetch = $run->fetch_assoc()) {
			$prid = $fetch['ID'];
			$description = $fetch['Description'];
			$items = $fetch['items'];
			$cost = $fetch['cost'];
			$department = $fetch['department'];
			$quotations = $fetch['quotations'];
			$status = $fetch['Status'];
			$client = $fetch['Name'];
			$address = $fetch['Address'];
			$tpin = $fetch['TPIN'];
			$brn = $fetch['BRN'];
			$phone = $fetch['Phone'];
			$email = $fetch['Email'];
			$date = $fetch['DateCreated'];
			$category = $fetch['Category'];
			$vat = $fetch['VAT'];
			$clientID = $fetch['CID'];
			$requester = $fetch['FirstName'] .' ' . $fetch['Surname'];

			$terms = $fetch['Terms'];
			
			$currency = $fetch['Currency'];
			
			if($currency == ''){
				$currency = "ZMW";
			}
			
			// SHOW MENU
			if($print != TRUE){
				$output .= '<div class="toolbar">
				<a href="' . $this->core->conf['conf']['path'] . '/quotation/manage/">Back to Overview</a>
				<a href="' . $this->core->conf['conf']['path'] . '/quotation/print/'.$item.'">Print Quotation</a>
				<a href="' . $this->core->conf['conf']['path'] . '/quotation/print/'.$item.'/invoice">Print Invoice</a>
				<a href="' . $this->core->conf['conf']['path'] . '/quotation/print/'.$item.'/delivery">Print Delivery Note</a>
				<a href="' . $this->core->conf['conf']['path'] . '/quotation/print/'.$item.'/receipt">Receipt</a>';
				$output .= '</div>';
			}
			
			
			$cost =  number_format($cost) . " " . $currency;
			
			if($quotations[$prid] == ''){
				$quotations[$prid] = 0;
			}
			
			
			
			$sub = $this->core->subitem;
			if($sub == 'invoice') { $type = "INVOICE";   } else { $type ="QUOTATION";}
			if($sub == 'invoice') { $typen = "INVOICED"; } else { $typen ="QUOTED";}
			if($sub == 'delivery'){	$type = "DELIVERY NOTE";  	$typen = "DELIVERED";  } 
			if($sub == 'receipt'){	$type = "RECEIPT";  		$typen = "RECEIPT";   $date = date('Y-m-d'); } 
			
			if($print == TRUE){
				$path = '/data/web/corelink.co.zm/management/templates/mobile/images/logo.png';
			} else {
				$path = '/management/templates/mobile/images/logo.png';
			}
				
			if($print == TRUE){
				if($clientID == 50){
							
					$path = '/data/web/corelink.co.zm/management/templates/mobile/images/vos2.png';
			
					$output .= '<html><body style="font-family: Arial, Helvetica, sans-serif; font-size: 13px;">
						<table style=" background-color: #FFF;">
							<tr style=" border: 1px solid #ccc; ">
							
								<td style="width: 400px;"><a href="https://www.corelink.co.zm"><img height="100px" src="'.$path.'" /></a><br><br>
								</td>
								<td style="padding-left: 30px; font-size: 11pt; color: #333; ">
									<br>Ngwerema Road 5<br>Olympia Park<br>Lusaka, Zambia 
									<br> <a href="mailto:info@corelink.co.zm">rowan@edurole.com</a>
									<br> CEL: +260 972 615 221
							</td>
							</tr>
							</table>';
				}else {
					$output .= '<html><body style="font-family: Arial, Helvetica, sans-serif; font-size: 13px;">
						<table style=" background-color: #FFF;">
							<tr style=" border: 1px solid #ccc; ">
								<td style="width: 400px;"><a href="https://www.corelink.co.zm"><img height="90px" src="'.$path.'" /></a><br><br>
								<div style="font-size: 11pt;"><b>CoreLink Consulting Ltd.</b></div>
								</td>
								<td style="padding-left: 30px; font-size: 11pt; color: #333; ">
									<b>Visit our company offices:</b> 
									<br>Ngwerema Road 5<br>Olympia Park<br>Lusaka, Zambia 
									<br> <a href="mailto:info@corelink.co.zm">info@corelink.co.zm</a>
									<br> TPIN: 2564304921
									<br> CEL: +260 972 615 221
							</td>
							</tr>
							</table>';
				}
			}
				
			$output .= '<h1>'.$type.'</h1>
				<div style="border-bottom: 1px solid #333; width: 100%; margin-bottom: 20px;">&nbsp;</div>';
			
			if($print == TRUE){
				$output .= '<div style="position: absolute; right: 10px; width: 250px;">
							<b>Client details:</b> <br>'.nl2br($address).'<br>Phone: '.$phone.'<br>BRN: '.$brn.'<br>TPIN: '.$tpin.'
							</div>';
			}
			
			$output .=  '<table class="">
				<tr>
					<td style="width: 200px;">'.$type.' Number: </td>
					<td><b>CL20220'.$prid.'</b></td> 
				</tr>
				<tr>
					<td>Description of '.$type.': </td>
					<td><b>' . $description . '</b></td>
				</tr>
				<tr>
					<td>Client: </td>
					<td><b>'  . $client . '</b></td>
				</tr>';
				
				if($print != TRUE){
						$output .= '<tr>
							<td>Number of Item Lines: </td>
							<td><b>' . $items . ' </b></td>
						</td>
						<tr>
							<td>Total price '.$typen.': </td>
							<td><b>' . $cost . '</b></td>
						</tr>
						<tr>
						<td>Documents attached: </td>
						<td><b>' . $documents  . '</b></td>
					</tr>
					<tr>
						<td>Customer approval status: </td>
						<td><b>' . $status . '</b></td>
					</tr>';
				}
				
				
				if($sub == 'delivery'){
					$date = "2022-07-29";
				}
					
				$output .= '<tr>
					<td>Date Generated: </td>
					<td><i>' . $date . '</i></td>
				</tr>
				</table> <div style="border-bottom: 1px solid #333; width: 100%;">&nbsp;</div><br>';
				
						
				$sql = "SELECT * FROM `quotation-lines` 
						WHERE `quotation-lines`.QuotationID = $item";
				$rund = $this->core->database->doSelectQuery($sql);

				$output .=  '<h2>'.$typen.' ITEMS</h2>';
				
				if($sub == 'receipt'){
					$output .=  '<table style="font-weight: bold; border: 1px solid #333; width: 100%;">
							<tr style="font-weight: bold; border: 1px solid #333; width: 100%;">
								<th style="font-weight: bold; border: 1px solid #333; width: 100%;">#</th>
								<th style="font-weight: bold; border: 1px solid #333; width: 100%;">Payment Received For</th>
								<th style="font-weight: bold; border: 1px solid #333; width: 100%;">Item Specifications</th>
								<th style="font-weight: bold; border: 1px solid #333; width: 100%;">Total Amount</th>
							</tr>';
				}else if($sub == 'delivery'){
					$output .=  '<table style="font-weight: bold; border: 1px solid #333; width: 100%;">
							<tr style="font-weight: bold; border: 1px solid #333; width: 100%;">
								<th style="font-weight: bold; border: 1px solid #333; width: 100%;">#</th>
								<th style="font-weight: bold; border: 1px solid #333; width: 100%;">Item Name</th>
								<th style="font-weight: bold; border: 1px solid #333; width: 100%;">Item Specifications</th>
								<th style="font-weight: bold; border: 1px solid #333; width: 100%;">Quantity<br> Ordered</th>
								<th style="font-weight: bold; border: 1px solid #333; width: 100%;">Quantity<br> Delivered</th>
							</tr>';
				} else {
					$output .=  '<table style="font-weight: bold; border: 1px solid #333; width: 100%;">
							<tr style="font-weight: bold; border: 1px solid #333; width: 100%;">
								<th style="font-weight: bold; border: 1px solid #333; ">#</th>
								<th style="font-weight: bold; border: 1px solid #333; ">Item Name</th>
								<th style="font-weight: bold; border: 1px solid #333; ">Item Specifications</th>
								<th style="font-weight: bold; border: 1px solid #333; ">Quantity</th>
								<th style="font-weight: bold; border: 1px solid #333; ">Unit Cost</th>
								<th style="font-weight: bold; border: 1px solid #333; ">Total Cost</th>
							</tr>';
				}
					$x=1;
				while ($fetchd = $rund->fetch_assoc()) {
					$plid = $fetchd['ID'];
					$name = nl2br($fetchd['ItemName']);
					$specs = nl2br($fetchd['ItemDescription']);
					$quantity = $fetchd['ItemQuantity'];
					$unit = $fetchd['ExpectedCost'];
					$cost = $unit*$quantity;
					$stock = $fetchd['BudgetVariation'];
					
					if($terms == ''){
						$terms = 'Payment on installation.';
					}
				
					if($stock == 1){
						$stock = "CHECK DELIVERY TIME";
					} else{
						$stock = "IN STOCK";
					}
					
					
					if($sub == 'receipt'){
						$output .= '<tr>
								<td style="width:20px; height: 32px;">'.$x.'</td>
								<td style="width:180px;"><b>'.$name.'</b></td>
								<td style="width:220px;">'.$specs.'</td>
								<td style="width:100px;">'. number_format($cost,2) .' '.$currency.'</td>
							</tr>';
					} else if($sub == 'delivery'){
						$output .= '<tr>
								<td style="width:20px; height: 32px;">'.$x.'</td>
								<td style="width:180px;"><b>'.$name.'</b></td>
								<td style="width:220px;">'.$specs.'</td>
								<td style="width:80px;"> <center>'.$quantity.'</center></td>
								<td style="width:100px;"><center>'.$quantity.'</center></td>
							</tr>';
					} else if($print != TRUE){
						$output .= '<tr>
								<td style="height: 32px; width: 40px;">'.$x.'</td>
								<td style=""><b>'.$name.'</b></td>
								<td style="">'.$specs.'</td>
								<td style="">'.$quantity.'</td>
								<td style="">'.number_format($unit,2).'  '.$currency.'</td>
								<td style=""><b>'.number_format($cost,2).'  '.$currency.'</b></td>
							</tr>';
					} else{
						$output .= '<tr>
								<td style="width:20px; height: 32px;">'.$x.'</td>
								<td style=""><b>'.$name.'</b></td>
								<td style="">'.$specs.'</td>
								<td style="width:80px;">'.$quantity.'</td>
								<td style="width:100px;">'.number_format($unit,2).'  '.$currency.'</td>
								<td style="width:100px;"><b>'.number_format($cost,2).'  '.$currency.'</b></td>
							</tr>';
					}
					$x++;
					
					$totcost = $totcost+$cost;
					$totquantity = $totquantity+$quantity;
					
				}
				
				$vatamount = $totcost*($vat/100);
				$totalincl = $totcost+$vatamount;
				
				
				if($sub == 'receipt'){

											
					$output .= '<tr class="table-dark" style="border-top: 1px solid #333 !important;">
							<td ></td>
							<td ><b> VAT EXCL.</b></td>
							<td ></td>
							<td style="font-weight: bold; border-top: 1px solid #333;"><b>'.number_format($totcost,2).'  '.$currency.'</b></td>
						</tr>';
						
					$output .= '<tr class="table-dark" style="border-top: 1px solid #333 !important;">
							<td ></td>
							<td ><b>VAT AMOUNT</b></td>
						
							<td >'.number_format($vat).'%</td>
							<td style="font-weight: bold; border-top: 1px solid #333;"><b>'.number_format($vatamount,2).'  '.$currency.'</b></td>
						</tr>';
											
					$output .= '<tr class="table-dark" style="border-top: 1px solid #333 !important;">
							<td ></td>
							<td ><b>TOTAL PAYMENTS RECEIVED</b></td>
							<td ></td>
							<td style="font-weight: bold; border-top: 1px solid #333;"><b>'.number_format($totalincl,2).'  '.$currency.'</b></td>
						</tr>';
						
						
				} else if($sub != 'delivery'){
					$output .= '<tr class="table-dark" style="border-top: 1px solid #333 !important;">
							<td style=" font-weight: bold; border-top: 1px solid #333;"></td>
							<td  style="font-weight: bold; border-top: 1px solid #333;"></td>
							<td style="font-weight: bold; border-top: 1px solid #333;"><b>NET TOTAL</b></td>
							<td style="font-weight: bold; border-top: 1px solid #333;"></td>
							<td style="font-weight: bold; border-top: 1px solid #333;"></td>
							<td style="font-weight: bold; border-top: 1px solid #333;"><b>'.number_format($totcost,2).'  '.$currency.'</b></td>
						</tr>';
					
					$output .= '<tr class="table-dark" style="border-top: 1px solid #333 !important;">
							<td ></td>
							<td ></td>
							<td ><b>VAT AMOUNT</b></td>
							<td ></td>
							<td >'.number_format($vat).'%</td>
							<td style="font-weight: bold; border-top: 1px solid #333;"><b>'.number_format($vatamount,2).'  '.$currency.'</b></td>
						</tr>';
											
					$output .= '<tr class="table-dark" style="border-top: 1px solid #333 !important;">
							<td ></td>
							<td  ></td>
							<td ><b>GROSS TOTAL</b></td>
							<td ></td>
							<td ></td>
							<td style="font-weight: bold; border-top: 1px solid #333;"><b>'.number_format($totalincl,2).'  '.$currency.'</b></td>
						</tr>';
				}
							
				$output .= '</table>';
				
				
				
			$i++;
		}
		
		if($sub != 'delivery' && $sub != 'receipt'){
			
				$output .=  '<br><div style="border-bottom: 1px solid #333; width: 100%;">&nbsp;</div><br>
						<table><tr>
						<td><table class="">';
						
				if($sub != 'invoice'){
					$output .=  '<tr>
							<td>Notes: </td>
							<td><b> None</b></td>
						</tr>
						<tr>  
							<td>Validity: </td>
							<td><b>30 days after closing date</b></td>
						</tr>
						<tr>
							<td>Delivery Period: </td>
							<td><b>7 days</b></td> 
						</tr>';
				}
				
				$output .=  '<tr>
							<td>Payment Terms: </td>
							<td><i>'.$terms.'</i></td>
						</tr>

						</table>
						</td>
						<td>
								</td>
						</table>
						<div style="border-bottom: 1px solid #333; width: 100%;">&nbsp;</div><br>';
			} else {
				$output .= '<div style="border-bottom: 1px solid #333; width: 100%;">&nbsp;</div><br>';
			}
					
			if($sub != 'delivery' && $sub != 'receipt' && $sub != 'quotation' && $sub != '' ){
				if($print == TRUE){
					
					if($clientID == 50){
						$output .= '<div style=" width: 800px;">
									<b>BANK DETAILS:</b><br>
										Bank Account Holder: <b>Rowan J. Vos</b><br>
										Bank Name:   <b>ING</b><br>
										Bank BIC/SWIFT Code: <b>INGBNL2A</b><br>
										Account Number/IBAN: <b>NL30 INGB 0008 8858 44</b><br>
										Bank address: <b>NG Bank N.V., Foreign Operations, PO Box 1800, 1000 BV Amsterdam, Netherlands</b><br>
									</div>';
					} else {
						$output .= '<div style=" width: 350px;">
									<b>BANK DETAILS:</b><br>
										Bank:   <b>Atlas Mara</b><br>
										Branch: <b>Industrial Branch</b><br>
										Account: <b>0336005861022</b><br>
										SWIFT: <b>FMBZZMLXXXX</b><br>
									</div>';
					}
									
				$output .= '<hr><table>
								<tr><td width="250px"><b>Invoice Provided by</b><br>
							<b>Name:</b> Rowan J. Vos<br><br>
							<b>Signature:</b> <div style=" padding-left: 10px;"> <img  height="75px" src="/data/web/corelink.co.zm/management/templates/mobile/images/signature.png" /></div></td>';
							
				$output .= '<td><b>Client confirmation:</b><br>
						<i>The client representative receiving the invoice:</i><br><br>
						<b>Name:</b>  ........................................................................ <br>
						<b>ID Number:</b>  ...................................................................  <br>
						<b>Role:</b>  ........................................................................ <br><br> 
						<b>Signature:</b> .................................................................... </td>
						</tr></table>';
						
							
					//		<i>Note: The consultant is adequatly insured as may be required under the Defense Base Act (DBA), all insurance information is available on request.  </i>';
				} 
			}else if($sub == 'receipt' ){
				if($print == TRUE){
					$output .= '<b>RECEIPTED BY:</b><br>
					<b>Name:</b> R. J. Vos<br><br>
					<b>Signature:</b> <div style="float: left; padding-left: 10px;"> <img  height="75px" src="/data/web/corelink.co.zm/management/templates/mobile/images/signature.png" /></div>';
					
					$output .= '<br><br><b>RECEIPT RECEIVED BY:</b><br>
					<b>Name:</b>  ......................... <br><br>
					<b>Signature:</b> ......................... ';
				} 
			}  else if ($sub == 'delivery'){
				$output .= '<b>DELIVERED BY:</b><br>
				<b>Name:</b> R. J. Vos<br><br>
				<b>Signature:</b> <div style="float: left; padding-left: 10px;"> <img  height="75px" src="/data/web/corelink.co.zm/management/templates/mobile/images/signature.png" /></div>';
				
				$output .= '<br><br><b>RECEIVED BY:</b><br>
				<b>Name:</b>  ......................... <br><br>
				<b>Signature:</b> ......................... ';
			}  else if ($sub == 'quotation' || $sub == ''){

				$output .= '<br>
							<table>
							<tr><td width="250px"><b>Quotation Provided by</b><br>
							<b>Name:</b> Rowan J. Vos<br><br>
							<b>Signature:</b> <img  height="75px" src="/data/web/corelink.co.zm/management/templates/mobile/images/signature.png" />
							</td></table>';
							
							
			} 
			
		if($print == TRUE){
			return $output;
		} else {
			echo $output;
			return;
		}
	} 
	
	public function printQuotation($item){
		
		$sub = $this->core->subitem;
		if($sub == 'invoice') { $type = "INVOICE";   } else {  $type = "QUOTE";  }
		if($sub == 'delivery') { $type = "DELIVERY";   } 
		
		$output = $this->showQuotation($item, TRUE);
		$path = "datastore/output/quotations/";
		$filename =  $path . $type . '-'.$item.'.pdf';

		if(file_exists($filename)){
			unlink($filename);
		}



		$dompdf= new Dompdf();
		

		$dompdf->getOptions()->setChroot("/data/web/corelink.co.zm/");
		$dompdf->load_html($output);  
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream();
                 

		$pdf = $dompdf->output();
		file_put_contents($filename, $pdf);
		
  
		$mime = mime_content_type($filename);
		header('Content-type: '.$mime);
		header('Content-Disposition: attachment; filename='.$type . $item.'.pdf');
		header('Content-Length: ' . filesize($filename));
		$content = readfile($filename);
		
		echo $content;

	}

	public function manageQuotation($item) {
		$uid = $this->core->userID;

		if($item == ""){
			$item = "%";
		}
		
		$this->viewMenu();
		$i = 1;
		
		
		echo '<div class="toolbar"> <div class="toolbaritem"> <b>Filter by : </b></div>
			<a href="' . $this->core->conf['conf']['path'] . '/quotation/manage/" class="green">ALL</a>
			<a href="' . $this->core->conf['conf']['path'] . '/quotation/manage/QUOTED" class="green">QUOTED</a>
			<a href="' . $this->core->conf['conf']['path'] . '/quotation/manage/INVOICED" class="green">INVOICED</a>
			<a href="' . $this->core->conf['conf']['path'] . '/quotation/manage/PAID" class="green">PAID</a>
		</div>';
		
		if($item != ''){
			$filter = " WHERE `quotations`.Status LIKE '$item' ";
		}
		
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



