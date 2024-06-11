<?php
class search {

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

		if($this->core->cleanGet["data"] && $this->core->role >= 100){
			$item = $this->core->cleanGet["data"]; 
		}
			
		if ($item != '') {
			$sql = "SELECT * FROM `basic-information`, `student-study-link`, `study`
					WHERE `basic-information`.`ID` LIKE '%$item%' AND `student-study-link`.`StudyID` = `study`.ID AND `student-study-link`.`StudentID` = `basic-information`.`ID`
					OR `GovernmentID` LIKE '$item%'  AND `student-study-link`.`StudyID` = `study`.ID AND `student-study-link`.`StudentID` = `basic-information`.`ID`
					OR concat(`FirstName`, ' ', `MiddleName`, ' ', `Surname`) LIKE '%$item%'  AND `student-study-link`.`StudyID` = `study`.ID AND `student-study-link`.`StudentID` = `basic-information`.`ID`
					OR concat(`FirstName`, ' ', `Surname`) LIKE '%$item%' AND `student-study-link`.`StudyID` = `study`.ID AND `student-study-link`.`StudentID` = `basic-information`.`ID`
					LIMIT 0,20";

			$run = $this->core->database->doSelectQuery($sql);
			$out = "";			
			
			if($this->core->template == 'desktop') {
				$out .= '<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right show">';
				while ($fetch = $run->fetch_row()) {
					$firstname = $fetch[0];
					$lastname = $fetch[2];
					$middlename = $fetch[1];
					$nrc = $fetch[5];
					$uid = $fetch[4];
					
				//	if (file_exists("datastore/identities/pictures/$uid.png_final.png")) {
				//		$filename = '/datastore/identities/pictures/' . $uid . '.png_final.png';
				//	} else 	if (file_exists("datastore/identities/pictures/$uid.png")) {
				//		$filename = '/datastore/identities/pictures/' . $uid . '.png';
				//	} else {
						$filename = '/templates/default/images/noprofile.png';
				//	}
					
					$out .= '<a href="/information/show/'.$uid.'" class="dropdown-item">
								<div class="media">
								<img src="'.$filename.'" alt="User" class="img-size-50 mr-3 img-circle">
									<div class="media-body">
										<h3 class="dropdown-item-title">
											'.$firstname.'  '.$middlename.' '.$lastname.'
											<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
										</h3>
										<p class="text-sm">'.$uid.'</p>
										<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 3 Minutes Ago</p>
									</div>
								</div>
							</a>
							<div class="dropdown-divider"></div>';
				}

				echo $out.'<a href="/information/search" class="dropdown-item dropdown-footer">Advanced Search</a></div>';
			} else {
				echo '<ul>';
				while ($fetch = $run->fetch_row()) {
					$firstname = $fetch[0];
					$lastname = $fetch[2];
					$middlename = $fetch[1];
					$nrc = $fetch[5];
					$uid = $fetch[4];
					$program = $fetch[34];
					if($nrc ==''){
						$nrc = 'NO NRC';
					}
					
					//if (file_exists("datastore/identities/pictures/$uid.png_final.png")) {
					//	$filename = '/datastore/identities/pictures/' . $uid . '.png_final.png';
					//} else 	if (file_exists("datastore/identities/pictures/$uid.png")) {
					//	$filename = '/datastore/identities/pictures/' . $uid . '.png';
					//} else {
						$filename = '/templates/default/images/noprofile.png';
					//}
					
					$out .= '<li class="active">
								<div class="d-flex bd-highlight">
									<a href="' . $this->core->conf['conf']['path'] . '/information/show/'.$uid.'">
										<div class="img_cont" >
											<img src="'.$filename.'" class="rounded-circle user_img">
											<span class="online_icon"></span>
										</div>
										<div class="user_info">
											<span>'.$firstname.'  '.$middlename.' '.$lastname.'</span>
											<p>'.$uid.'<span style="font-weight: normal; font-size: 11px;"> - ('.$nrc.') - '.$program.'</span></p>
										</div>
									</a>
								</div>
							</li>';
				}

				echo $out;

				echo '</ul>';
			}
		}
	}
}

?>