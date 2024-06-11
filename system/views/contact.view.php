<?php
class contact {
	

	public $core;
	public $view;

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

	public function addContact() {

		include $this->core->conf['conf']['formPath'] . "addcontact.form.php";

	}

	public function saveContact() {
		$item = $this->core->userID;
		$fullname = $this->core->cleanPost["name"];
		$relationship = $this->core->cleanPost["relation"];
		$phonenumber = $this->core->cleanPost["celphone"];
		$street = $this->core->cleanPost["streetname"];
		$town = $this->core->cleanPost["town"];
		$postalcode = $this->core->cleanPost["postalcode"];
		$relationship = $this->core->cleanPost["relation"];
		$email = $this->core->cleanPost["email"];

		$sql = "REPLACE INTO `sponsor-contact` (`ID` ,`StudentID` ,`FullName`, `Relationship` ,`PhoneNumber` ,`Street` ,`Town` ,`Postalcode` ,`Email`)
				VALUES (NULL , '$item', '$fullname', '$relationship', '$phonenumber', '$street', '$town', '$postalcode', '$email')";
					
		if($this->core->database->doInsertQuery($sql)){
			echo'<div class="successpopup">Your sponsor information was added</div>';
			
			include $this->core->conf['conf']['viewPath'] . "information.view.php";

			$information = new information();
			$information->buildView($this->core);
			$information->showInformation($item);
		} else{
			echo'<div class="errorpopup">Your sponsor information failed to be added</div>';
		}		
	}


}
