<?php
class helpdesk{

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

	private function viewMenu($item, $uid, $message){
		if(isset($uid)){
			$uid = "/".$uid;
		}

		echo '<div class="toolbar">'.
		'<a href="' . $this->core->conf['conf']['path'] . '/helpdesk/inbox"><span class="glyphicon glyphicon-inbox"></span> Inbox</a>'.
		'<a href="' . $this->core->conf['conf']['path'] . '/helpdesk/delete/'.$item.'"><span class="glyphicon glyphicon-remove"></span> Delete</a>'.
		'<a href="' . $this->core->conf['conf']['path'] . '/helpdesk/reply/'.$item . $uid.'"><span class="glyphicon glyphicon-share"></span> Reply </a>'.
		'<a href="' . $this->core->conf['conf']['path'] . '/helpdesk/forward/'.$item . $uid.'"><span class="glyphicon glyphicon-forward"></span> Forward </a>'.
		'</div>';
	}
	
	public function messageHelpdesk($item) {
		include $this->core->conf['conf']['formPath'] . "createticket.form.php";
	}

	public function forwardHelpdesk($item) {
		$recipient = $this->core->userID;

		echo '<div class="toolbar">'.
		'<a href="' . $this->core->conf['conf']['path'] . '/helpdesk/inbox"><span class="glyphicon glyphicon-inbox"></span> Inbox</a>'.
		'</div>';

		$sql = "SELECT * FROM `helpdesk`	
			LEFT JOIN `basic-information` ON `basic-information`.ID = `helpdesk`.SenderID 
			WHERE `helpdesk`.`ID` = '$item' AND `RecipientID` = '$recipient' 
			OR  `helpdesk`.`ID` = '$item' AND `RecipientID` = 'ALL'";

		$run = $this->core->database->doSelectQuery($sql);

		while ($fetch = $run->fetch_assoc()) {
			$item = $fetch['ID'];
			$sender = $fetch['SenderID'];
			$item = "FWD: " . $fetch['Subject'];
			$date = $fetch['Date'];
			$message = "$sender WROTE ON $date: \n ------------------------------------------------------------------------------------------------------------\n" . $fetch['Message'];
			$name = $fetch['FirstName'] . ' ' . $fetch['Surname'];
		}

		include $this->core->conf['conf']['formPath'] . "sendmessage.form.php";
	}
	
	public function replyHelpdesk($item) {
		$recipient = $this->core->userID;

		echo '<div class="toolbar">'.
		'<a href="' . $this->core->conf['conf']['path'] . '/helpdesk/inbox"><span class="glyphicon glyphicon-inbox"></span> Inbox</a>'.
		'</div>';

		$sql = "SELECT * FROM `helpdesk`	
			LEFT JOIN `basic-information` ON `basic-information`.ID = `helpdesk`.SenderID 
			WHERE `helpdesk`.`ID` = '$item' AND `RecipientID` = '$recipient' 
			OR  `helpdesk`.`ID` = '$item' AND `RecipientID` = 'ALL'";

		$run = $this->core->database->doSelectQuery($sql);

		while ($fetch = $run->fetch_assoc()) {
			$item = $fetch['ID'];
			$uid = $fetch['SenderID'];
			$item = "RE: " . $fetch['Subject'];
			$name = $fetch['FirstName'] . ' ' . $fetch['Surname'];
		}

		include $this->core->conf['conf']['formPath'] . "sendmessage.form.php";
	}

	public function inboxHelpdesk($item) { 
		$inbox = $this->core->userID;
		$userid = $this->core->userID;
		
		$sql = "SELECT *, `helpdesk`.ID as MID, rep.FirstName as rFirstName, `rep`.Surname as rSurname 
			FROM `helpdesk`
			LEFT JOIN `basic-information` as rep ON `rep`.ID = `helpdesk`.RecipientID 
			LEFT JOIN `basic-information` ON `basic-information`.ID = `helpdesk`.SenderID 
			WHERE `RecipientID` LIKE '$inbox'
			AND (`Completed` IS NULL OR `Completed` = 2)
			ORDER BY `MID` DESC";
		$run = $this->core->database->doSelectQuery($sql);
		$pp = $run->num_rows;
		
		$sql = "SELECT *, `helpdesk`.ID as MID, rep.FirstName as rFirstName, `rep`.Surname as rSurname 
			FROM `helpdesk`
			LEFT JOIN `staff` ON `staff`.Manager = '$userid' 
			LEFT JOIN `basic-information` as rep ON `rep`.ID = `helpdesk`.RecipientID 
			LEFT JOIN `basic-information` ON `basic-information`.ID = `helpdesk`.SenderID 
			WHERE `RecipientID` LIKE `staff`.EmployeeNo
			AND (`Completed` IS NULL OR `Completed` = 2)
			ORDER BY `MID` DESC";
		$run = $this->core->database->doSelectQuery($sql);
		$tp = $run->num_rows;
			
		
		echo'<div class="toolbar">
			<a href="' . $this->core->conf['conf']['path'] . '/helpdesk/reply/"><span class="glyphicon glyphicon-send"></span> Send message </a>
			<a href="' . $this->core->conf['conf']['path'] . '/helpdesk/inbox/pending"><span class="glyphicon glyphicon-send"></span> Pending Tickets <span class="pendingcount"><b>'.$pp.'</b></span></a>
			<a href="' . $this->core->conf['conf']['path'] . '/helpdesk/inbox/completed"><span class="glyphicon glyphicon-send"></span> Completed Tickets </a>';
		
		if($this->core->role > 10){
				echo'<a href="' . $this->core->conf['conf']['path'] . '/helpdesk/inbox/pending/department"><span class="glyphicon glyphicon-send"></span> My Department <span class="pendingcount"><b>'.$tp.'</b></span></a>';
		}

		if($this->core->role == 102 || $this->core->role == 1003 || $this->core->role == 1000){
				echo'<a href="' . $this->core->conf['conf']['path'] . '/payments/proof"><span class="glyphicon glyphicon-send">Proof of Payments</span></a>';
		}
		
		if($this->core->role == 1000){
				echo'<a href="' . $this->core->conf['conf']['path'] . '/helpdesk/inbox/pending/all"><span class="glyphicon glyphicon-send"></span> Monitor All Pending Tickets </a>';
				echo'<a href="' . $this->core->conf['conf']['path'] . '/helpdesk/inbox/complete/all"><span class="glyphicon glyphicon-send"></span> Monitor All Complete Tickets </a>';
		}
		
		echo'</div>';
		
		if($this->core->subitem == 'all'){
			$inbox = '%';
		}
		
				


		if($item == 'pending'){
			$sql = "SELECT *, `helpdesk`.ID as MID, rep.FirstName as rFirstName, `rep`.Surname as rSurname 
			FROM `helpdesk`
			LEFT JOIN `basic-information` as rep ON `rep`.ID = `helpdesk`.RecipientID 
			LEFT JOIN `basic-information` ON `basic-information`.ID = `helpdesk`.SenderID 
			WHERE `RecipientID` LIKE '$inbox'
			AND (`Completed` IS NULL OR `Completed` = 2)
			ORDER BY `MID` DESC";
		}else if($item == 'complete'){
			$sql = "SELECT *, `helpdesk`.ID as MID, rep.FirstName as rFirstName, `rep`.Surname as rSurname 
			FROM `helpdesk`
			LEFT JOIN `basic-information` as rep ON `rep`.ID = `helpdesk`.RecipientID 
			LEFT JOIN `basic-information` ON `basic-information`.ID = `helpdesk`.SenderID 
			WHERE `RecipientID` LIKE '$inbox'
				AND `Completed` =1
			OR `RecipientID` LIKE 'ALL'
				AND `Completed` =1 
			ORDER BY `MID` DESC";
		} else {
			$sql = "SELECT *, `helpdesk`.ID as MID FROM `helpdesk`
			LEFT JOIN `basic-information` ON `basic-information`.ID = `helpdesk`.SenderID 
			WHERE `RecipientID` LIKE '$inbox'
			OR `RecipientID` LIKE 'ALL'
			ORDER BY `MID` DESC";
		}

		if($this->core->subitem == 'department'){
			$sql = "SELECT *, `helpdesk`.ID as MID, rep.FirstName as rFirstName, `rep`.Surname as rSurname 
			FROM `helpdesk`
			LEFT JOIN `staff` ON `staff`.Manager = '$userid' 
			LEFT JOIN `basic-information` as rep ON `rep`.ID = `helpdesk`.RecipientID 
			LEFT JOIN `basic-information` ON `basic-information`.ID = `helpdesk`.SenderID 
			WHERE `RecipientID` LIKE `staff`.EmployeeNo
			AND (`Completed` IS NULL OR `Completed` = 2)
			ORDER BY `MID` DESC";
		}
		
		$run = $this->core->database->doSelectQuery($sql);

		echo'<table id="helpdesk" class="table table-bordered  table-hover">
			<thead>
				<tr>
					<th bgcolor="#EEEEEE" width="30px"></th>
					<th bgcolor="#EEEEEE" width="50px">Ticket</th>
					<th bgcolor="#EEEEEE" width="180px"><b>Date/Time</b></th>
					<th bgcolor="#EEEEEE" width=""><b>Subject</b></th>';
					if($this->core->subitem == 'all' || $this->core->subitem == 'department'){
						echo'<th bgcolor="#EEEEEE" ><b>Recipient</b></th>';
					}

					echo'<th bgcolor="#EEEEEE"<b>Sender</b></th>
					<th bgcolor="#EEEEEE">Status</th>
				</tr>
			</thead>
			<tbody>';

		while ($fetch = $run->fetch_assoc()) {
			$i++;
			
			$item = $fetch['MID'];
			$sender = $fetch['SenderID'];
			$recipient = $fetch['RecipientID'];
			$subject = $fetch['Subject'];
			$date = $fetch['Date'];
			$dated = $fetch['Date'];
			$read = $fetch['Read'];
			$message = $fetch['Message'];
			$completed = $fetch['Completed'];
			
			$sname = strtoupper($fetch['FirstName'] . ' ' . $fetch['Surname']);
			$rname = strtoupper($fetch['rFirstName'] . ' ' . $fetch['rSurname']);

			
			if(empty($subject)){
				$subject = "No subject";
			}
			


			if($read == "1"){
				$color = "#FFFFFF";
			} else { 
				$color = "#B1CADE";
			}
			

		
		
			$exp = $this->weekDays(2, strtotime($date));
			$current = date('Y-m-d H:i:s');
			$cur = strtotime($current);
			
				//echo $cur . ' ' . $exp; die();  
			$diff = $exp - $cur;
			$hours = round($diff / ( 60 * 60 ));
			if($hours<0){
				$sql = "SELECT * FROM `staff`, `basic-information` 
						WHERE `ID` = '".$recipient."' 
						AND `basic-information`.ID = `staff`.Manager";
				$date = $date;
			} else {
				$date = 'Escalates in: '.$hours.' Hours';
			}
			
			if($completed == "1"){
				$status = 'Completed';
				$date = $dated;
			}else if($completed == "2"){
				$status = '<a href="' . $this->core->conf['conf']['path'] . '/helpdesk/delete/'.$item.'" style="text-align: center;" align="center"><b>COMPLETE</b> </a>';
				$date = $dated;
				$color = "#c7d8e6";
			} else {
				$status = '<a href="' . $this->core->conf['conf']['path'] . '/helpdesk/delete/'.$item.'" style="text-align: center;" align="center"><b>COMPLETE</b> </a> | ';
				$status .= '<a href="' . $this->core->conf['conf']['path'] . '/helpdesk/delete/'.$item.'?status=2" style="text-align: center;" align="center"><b>IN PROGRESS</b> </a>';
				$color = "#e8beb4";
			}
			
			echo'<tr style="background-color: '.$color.';">
				<td><img src="' . $this->core->conf['conf']['path'] . '/templates/edurole/images/user.png"> </td>
				<td> '.$item.'</td>
				<td> '.$date.'</td>
				<td> <b><a href="' . $this->core->conf['conf']['path'] . '/helpdesk/read/'.$item.'">'.$subject.'</a></b></td>';
				
				if($this->core->subitem == 'all' || $this->core->subitem == 'department'){
					echo'<td> <a href="' . $this->core->conf['conf']['path'] . '/information/show/'.$recipient.'">'.$rname.'</a></td>';
				}
				echo'<td> <a href="' . $this->core->conf['conf']['path'] . '/information/show/'.$sender.'">'.$sname.'</a></td>';

				echo'<td> '.$status.'</td>
				</tr>';
		}

			echo'</tbody>
			</table>';
	}
	
	
	function weekDays($days, $date){
		
		if(date('D',$date) == 'Sat')  {
			$date = $date + 86400;
		}
		if(date('D',$date) == 'Sun')  {
			$date = $date + 86400;
		}
		
		$tstamp = $date + 172800;
		if(date('D',$tstamp) == 'Sat')  {
			$tstamp = $tstamp + 86400;
		}
		if(date('D',$tstamp) == 'Sun')  {
			$tstamp = $tstamp + 86400;
		}

		return $tstamp;
	}


	public function readHelpdesk($item) { 
		$recipient = $this->core->userID;
		
		if($this->core->role == 1000){
			$sql = "SELECT *, `helpdesk`.ID as HID
			FROM `helpdesk` 
			LEFT JOIN `basic-information` ON `basic-information`.ID = `helpdesk`.SenderID 
			WHERE `helpdesk`.`ID` = '$item'";
		}else{
			$sql = "SELECT *, `helpdesk`.ID as HID
			FROM `helpdesk` 
			LEFT JOIN `basic-information` ON `basic-information`.ID = `helpdesk`.SenderID 
			WHERE `helpdesk`.`ID` = '$item' 
			AND `RecipientID` = '$recipient' 
			OR  `helpdesk`.`ID` = '$item' 
			AND `RecipientID` = 'ALL'";
		}

		$run = $this->core->database->doSelectQuery($sql);

		while ($fetch = $run->fetch_assoc()) {
			$item = $fetch['HID'];
			$sender = $fetch['SenderID'];
			$recipient = $fetch['RecipientID'];
			$subject = $fetch['Subject'];
			$date = $fetch['Date'];
			$read = $fetch['Read'];
			$message = $fetch['Message'];
			$name = strtoupper($fetch['FirstName'] . ' ' . $fetch['Surname']);
		}

		$this->viewMenu($item, $sender);

		echo'<table id="helpdesk" class="table table-bordered  table-hover">
			<thead>
				<tr>
					<th bgcolor="#EEEEEE" width="30px"></th>
					<th bgcolor="#EEEEEE" width="50px">Ticket</th>
					<th bgcolor="#EEEEEE" width="180px"><b>Date/Time</b></th>
					<th bgcolor="#EEEEEE" width=""><b>Subject</b></th>
					<th bgcolor="#EEEEEE" width=""><b>Sender ID</b></th>
					<th bgcolor="#EEEEEE" width=""><b>Sender Name</b></th>
				</tr>
			</thead>
			<tbody>';



			if($read != "1"){
				$color = "#EEEEEE";
			}
 
			echo'<tr style="background-color: '.$color.';">
				<td><img src="' . $this->core->conf['conf']['path'] . '/templates/edurole/images/user.png"> </td>
				<td> '.$item.'</td>
				<td> '.$date.'</td>
				<td> <a href="' . $this->core->conf['conf']['path'] . '/helpdesk/read/'.$item.'"><b>'.$subject.'</b></a></td>
				<td> <a href="' . $this->core->conf['conf']['path'] . '/information/show/'.$sender.'">'.$sender.'</a></td>
				<td> <a href="' . $this->core->conf['conf']['path'] . '/information/show/'.$sender.'"><b>'.$name.'</b></a></td>
				</tr>';
				
			if($recipient == $this->core->userID){
				$sql = "UPDATE `helpdesk` SET `Read` = '1' WHERE `ID` = '$item' AND `RecipientID` != 'ALL'";
				$run = $this->core->database->doInsertQuery($sql);	
			}
		
		
			echo'<tr style="background-color: #b1c9ff; padding: 20px;">
				<td colspan="6" style="padding: 20px !important;"><b>'.nl2br($message).'</b></td>
				</tr>
				</tbody>
			</table>';
			
			echo '<b>REMEMBER TO MARK THIS TICKET AS: </b><a href="' . $this->core->conf['conf']['path'] . '/helpdesk/delete/'.$item.'" style="text-align: center;" align="center"><b> COMPLETED </b> </a> OR  ';
			echo '<a href="' . $this->core->conf['conf']['path'] . '/helpdesk/delete/'.$item.'?status=2" style="text-align: center;" align="center"><b>IN PROGRESS</b> </a>';

	}

	
	public function deleteHelpdesk($item) {
		
		$inbox = $this->core->userID;
		$status = $this->core->cleanGet['status'];
		
		if($status == '2'){
			$set = 2;
		} else{
			$set = 1;
		}

		$sql = "UPDATE `helpdesk` SET `Completed` = '$set' WHERE `ID` = '$item' AND `RecipientID` = '$inbox'";
		$run = $this->core->database->doInsertQuery($sql);		

		$this->core->redirect("helpdesk", "inbox", NULL);
	}


	public function sendHelpdesk($item) {
		$title = $this->core->cleanPost['title'];
		$message = $this->core->cleanPost['message'];
		$recipient = $this->core->cleanPost['recipient'];
		$mainproblem = $this->core->cleanPost['mainproblem'];
		$schoolproblem = $this->core->cleanPost['schoolproblem'];
		
		$ip = $_SERVER['REMOTE_ADDR'];
		$uid = $this->core->userID;
		
		if($recipient == ''){
			echo '<div class="errorpopup">'. $this->core->translate("SELECT ALL FIELDS ON THE PREVIOUS PAGE") .'</div>';
			die();
		}

		echo '<div class="toolbar">'.
		'<a href="' . $this->core->conf['conf']['path'] . '/helpdesk/inbox"><span class="glyphicon glyphicon-inbox"></span> Inbox</a>'.
		'</div>';
		
		

		$sql = "INSERT INTO `helpdesk` (`ID`, `SenderID`, `RecipientID`, `Date`, `Message`, `IP`, `Subject`) 
			VALUES (NULL, '$uid', '$recipient', NOW(), '$message', '$ip', '$title');";
			

		$run = $this->core->database->doInsertQuery($sql);		
		$ticket = $this->core->database->id();

		echo '<div class="successpopup">'. $this->core->translate("Your message has been sent.") .'</div>';
		
		echo '<div class="successpopup">'. $this->core->translate("Your ticket number is") .' : <h1>'. $ticket .'</h2></div>';

	}
}
?>