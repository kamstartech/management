<?php
class picture {

	public $core;
	public $service;
	public $item = NULL;

	public function configService() {
		$this->service->output = TRUE;
		return $this->service;
	}

	/*
	 * Government ID taken check in forms
	 */
	public function runService($core) {
		$this->core = $core;

		if($this->core->cleanGet["data"]){
			$item = $this->core->cleanGet["data"]; 
		}
			
		if ($item != '') {

			if (file_exists("datastore/identities/pictures/$item.png_final.png")) {
				$filename = '/datastore/identities/pictures/' . $item . '.png_final.png';
			} else 	if (file_exists("datastore/identities/pictures/$item.png")) {
				$filename = '/datastore/identities/pictures/' . $item . '.png';
			} else {
				$filename = '/templates/default/images/noprofile.png';
			}
			
			echo '<center><img src="'.$filename.'" alt="User" height="100%"></center>';
		}
	}
}

?>