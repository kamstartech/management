<?php
class login {

	public $core;
	public $view;

	public function configView() {
		$this->view->open = TRUE;
		$this->view->header = TRUE;
		$this->view->footer = TRUE;
		$this->view->menu = FALSE;
		$this->view->javascript = array();
		$this->view->css = array('login');
		
		return $this->view;
	}

	public function buildView($core) {
		$this->core = $core;
	}

	private function showError(){
		$error = $this->core->getViewError();
		if(isset($error)){
			$this->core->throwError($error->description);
		} else {
			return false;
		}
	}

	public function showLogin($item) {
		if($item == "timeout"){
			$this->core->setViewError('Expired session', 'Your session timed-out please login again.');
		}
		
		echo'<div class="loginheader">';
		$this->showError();

		include $this->core->conf['conf']['formPath'] . "login.form.php";

		include $this->core->conf['conf']['viewPath'] . "item.view.php";
		$items = new item();
		$items->buildView($this->core);

		//$items->overviewItem('news', NULL);

		echo '</div></div>';
	}
	
	public function logoutLogin() {
		
	}
}
?>
