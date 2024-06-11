<?php
class getuser {

	public $core;
	public $service;
	public $item = NULL;

	public function configService() {
		$this->service->output = TRUE;
		return $this->service;
	}


	public function runService($core) {
		$this->core = $core;
		
		$key = $this->core->cleanGet['key'];
		$sid = $this->core->cleanGet['sid'];

		if($key != '598e7e7302ded699cfe588e8dbe22124'){
			die();
		}

		if($sid == ''){
			echo'NO ID';
			die();
		}
	
		
		$sql = "SELECT *, `basic-information`.Status as STAT, `basic-information`.StudyType as ST FROM `basic-information`
			 LEFT JOIN `student-data-other` ON `basic-information`.ID = `student-data-other`.StudentID
			 LEFT JOIN `student-study-link` ON `student-study-link`.StudentID = `basic-information`.ID
			 LEFT JOIN `study` ON `student-study-link`.StudyID = `study`.ID
			 WHERE `basic-information`.`ID` = '$sid'";

		$run = $this->core->database->doSelectQuery($sql);
		while ($row = $run->fetch_assoc()) {
			$output["id"] = $row['StudentID'];
			$output["name"] = $row['FirstName'] . ' ' . $row['MiddleName'] . ' ' . $row['Surname'];
			$output["delivery"] = $row['StudyType'];
			$output["study"] = $row['Name'];
		}


		echo json_encode($output);
		
	}
}
?>