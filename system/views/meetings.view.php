<?php
class meetings{

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
	
		
	public function newMeetings($item) {
		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
		$optionBuilder = new optionBuilder($this->core);
		$clients = $optionBuilder->showClients();
		
		include $this->core->conf['conf']['formPath'] . "newmeeting.form.php";
	}
	
	

	public function saveMeetings($item) {

		$userid = $this->core->userID;
		$description = $this->core->cleanPost['description'];
		$client = $this->core->cleanPost['client'];
		$venue = $this->core->cleanPost['venue'];
		$startdate = $this->core->cleanPost['start'];
		$enddate = $this->core->cleanPost['end'];
		
		$sql = "INSERT INTO `meetings` (`ID`, `Client`, `Description`, `StartDateTime`, `EndDateTime`, `Venue`, `Status`) 
		VALUES (NULL, '$client', '$description', '$startdate', '$enddate', '$venue', 'Pending');";
		
		
		$link = "Meeting request for $client, $description, $startdate, $enddate, $venue";
		
		include $this->core->conf['conf']['servicePath'] . "mailer.inc.php";
		$mailer = new mailer;
		$mailer->runService($this->core);
		$mailer->newMail("schedule", 'rowan.vos@gmail.com', 'CoreLink Scheduling', $link, NULL);
	
	}
	
	
	public function scheduleMeetings($item) {
		echo '<h2>Schedule a meeting</h2>';
		echo '<iframe src="https://calendar.google.com/calendar/embed?height=800&wkst=2&bgcolor=%23ffffff&ctz=Africa%2FMaputo&showTitle=0&mode=WEEK&showCalendars=0&showTabs=0&showPrint=0&src=cm93YW4udm9zQGdtYWlsLmNvbQ&color=%237986CB" style="border:solid 1px #777" width="1080" height="800" frameborder="0" scrolling="no"></iframe>';	}
}
?>