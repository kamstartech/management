<?php
class searchpic {

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

			$item = $this->core->cleanGet["data"];
		
			
		if ($item != '') {
			$sql = "SELECT `basic-information`.*, `study`.Name 
					FROM `basic-information`
					LEFT JOIN `student-study-link` ON `basic-information`.ID = `student-study-link`.StudentID
					LEFT JOIN `study` ON `student-study-link`.StudyID = `study`.ID
					WHERE (`basic-information`.`ID` LIKE '%$item%' OR concat(`FirstName`, ' ', `Surname`) LIKE '%$item%' )
					LIMIT 0,50";

			$run = $this->core->database->doSelectQuery($sql);
			$out = "";			
			
			echo '<ul>';
			while ($fetch = $run->fetch_assoc()) {
				$firstname = $fetch['FirstName'];
				$middlename = $fetch['MiddleName'];
				$surname = $fetch['Surname'];
				$nrc = $fetch['GovernmentID'];
				$uid = $fetch['ID'];
				$program = $fetch['Name'];
				
				$out .= '
							<div class="d-flex bd-highlight" >
								<div class="user_info" onclick="changeText('.$uid.')">
									<a href="/information/show/'.$uid.'" target="_blank"><span>'.$firstname.' '.$middlename.' '.$surname.'</span></a> <br><b>'.$program.'</b>
									<p>'.$uid.'</br>
									'.$nrc.'</p>
								</div>
							</div>
						';
			}

			echo $out;

			echo '</ul>';
			
		}
	}
}

?>