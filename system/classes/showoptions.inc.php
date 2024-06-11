<?php
class optionBuilder {

	public $core;

	public function __construct($core) {

		$this->core = $core;
	}

	public function buildSelect($run, $selected = NULL) {
		$begin = "";
		$out = "";

		if (!empty($run)) {

			foreach ($run as $row) {

				$name = $row[1];
				$uid = $row[0];

				if ($uid == $selected) {
					$sel = 'selected="selected"'; 
				} else {
					$sel = "";
				}

				if ($uid == $selected) {
					$begin = '<option value="' . $uid . '" ' . $sel . '>' . $name . '</option>';
				}else{
					$out = $out . '<option value="' . $uid . '" ' . $sel . '>' . $name . '</option>';
				}
			}

		} else {

			$out = $out . '<option value="">No information available</option>';

		}

		$out = $begin . $out;
		return $out;
	}
	
		function showAccreditors($selected = null) {

		$sql = "SELECT `ID`, `Shortname` FROM `accreditors` ORDER BY `Shortname` ASC";

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}
 
	function showSuppliers($selected = null) {

		$sql = "SELECT `ID`, `Name` FROM `suppliers` ORDER BY `Name` ASC";

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}
	
	 
	function showClients($selected = null) {

		$sql = "SELECT `ID`, `Name` FROM `clients` ORDER BY `Name` ASC";

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}
	
	

	function showClaimcategory($selected = null) {

		$sql = "SELECT `ID`, CONCAT(`Name`,'-(K ',`Rate`,')') AS Name FROM `claim-category`";

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}	
	

	function showDepartments($selected = null) {

		$sql = "SELECT `ID`, `Name` FROM `departments`  ORDER BY `Name` ASC";

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}
	
	function showPositions($department = null, $selected = null) {
		
		$sql = "SELECT `positions`.ID, `positions`.JobTitle FROM `positions` ORDER BY `JobTitle` ASC";
		if ($department != null && $department != '') {
			$sql = "SELECT `positions`.ID, `positions`.JobTitle FROM `positions` WHERE DepartmentID = '.$department.'";
		}

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);	
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}

	function showCentres($centre = null, $selected = null) {

		if ($centre != null) {
			$sql = "SELECT  DISTINCT `student-data-other`.ExamCentre, `student-data-other`.ExamCentre FROM `student-data-other`";
		} else {
			$sql = "SELECT  DISTINCT `student-data-other`.ExamCentre, `student-data-other`.ExamCentre FROM `student-data-other`";
		}

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}

	function showCurrentPeriods($period = null, $selected = null) {

		if ($study != null) {
			$sql = "SELECT `periods`.ID, `periods`.Name  FROM `periods` WHERE NOW() BETWEEN `PeriodStartDate`AND `PeriodEndDate` ORDER BY `PeriodEndDate` DESC";
		} else {
			$sql = "SELECT `periods`.ID, `periods`.Name  FROM `periods` WHERE NOW() BETWEEN `PeriodStartDate`AND `PeriodEndDate` ORDER BY `PeriodEndDate` DESC";
		} 

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}

	public function showPeriods($period = null, $selected = null) {

		if ($period != null) {
			$sql = "SELECT  DISTINCT `periods`.ID, `periods`.Name FROM `periods` ORDER BY `ID` DESC";
		} else {
			$sql = "SELECT  DISTINCT `periods`.ID, `periods`.Name FROM `periods` ORDER BY `ID` DESC";
		}

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}

	public function showRegisteredPeriods($uid) {
	
		$sql = "SELECT  DISTINCT `periods`.ID, `periods`.Name 
		FROM `periods`, `course-electives` WHERE `periods`.ID = `course-electives`.PeriodID 
		AND `course-electives`.StudentID = '$uid' ORDER BY `periods`.`ID` DESC";
		
		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}
	
	function showPrograms($study = null, $selected = null) {

		if ($study != null) {
			$sql = "SELECT `programmes`.ID, `programmes`.ProgramName FROM `programmes`, `study-program-link` WHERE `study-program-link`.StudyID = '$study' AND `study-program-link`.ProgramID = `programmes`.ID ORDER BY `programmes`.`ProgramName`";
		} else {
			$sql = "SELECT `ID`, `ProgramName` FROM `programmes` ORDER BY `ProgramName`";
		}

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}	
	
	function showProgramsd($study = null, $selected = null) {

		if ($study != null) {
			$sql = "SELECT `programmes`.ProgramName, `programmes`.ProgramName FROM `programmes`, `study-program-link` WHERE `study-program-link`.StudyID = '$study' AND `study-program-link`.ProgramID = `programmes`.ID ORDER BY `programmes`.`ProgramName`";
		} else {
			$sql = "SELECT  `ProgramName`, `ProgramName` FROM `programmes` ORDER BY `ProgramName`";
		}

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}

	function showProgramNames($study = null, $selected = null) {

		if ($study != null) {
			$sql = "SELECT `programmes`.ID, `programmes`.ProgramName FROM `programmes`, `study-program-link` WHERE `study-program-link`.StudyID = '$study' AND `study-program-link`.ProgramID = `programmes`.ID ORDER BY `programmes`.`ProgramName`";
		} else {
			$sql = "SELECT `ProgramName`, `ProgramName` FROM `programmes` ORDER BY `ProgramName`";
		}

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}

	function showFeepackages($study = null, $selected = null) {

		if ($study != null) {
			$sql = "SELECT * FROM `fee-package`,`fee-package-study-link` WHERE `fee-package-study-link`.StudyID = '$study' AND `fee-package-study-link`.FeePackageID = `fee-package`.ID";
		} else {
			$sql = "SELECT * FROM `fee-package` ORDER BY `fee-package`.Name";
		}

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}


	function showCenters($center = null, $selected = null) {
		$sql = "SELECT `id`, `name` FROM `exam_centers` ORDER BY `exam_centers`.`name`";
		
		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}

	
	function showSCourses($study = null, $selected = null) {

		if ($study != null) {
			$sql = "SELECT `courses`.`ID`, CONCAT(`courses`.`Name`, ' - ',`courses`.CourseDescription)  FROM `courses`, `programmes`, `program-course-link`, `study-program-link`
			WHERE `program-course-link`.CourseID = `courses`.ID 
			AND `program-course-link`.ProgramID = `programmes`.ID 
			AND `program-course-link`.ProgramID = `study-program-link`.ProgramID 
			AND `study-program-link`.StudyID = $study
			GROUP BY `courses`.Name
			ORDER BY `courses`.`Name`";
		} else {
			$sql = "SELECT `ID`, CONCAT(`courses`.`Name`, ' - ',`courses`.CourseDescription) FROM `courses` ORDER BY `courses`.`Name`";
		}

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}

	function showCourses($program = null, $selected = null) {

		if ($program != null) {
			$sql = "SELECT * FROM `courses`, `programmes`, `program-course-link` 
			WHERE `program-course-link`.CourseID = `courses`.ID 
			AND `program-course-link`.ProgramID = `programmes`.ID 
			AND `program-course-link`.ProgramID = $program 
			ORDER BY `courses`.`Name`";
		} else {
			$sql = "SELECT `ID`, `Name` FROM `courses` ORDER BY `courses`.`Name`";
		}

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}

	function showPCourses($program = null, $selected = null) {

		if ($program != null) {
			$sql = "SELECT * FROM `courses`, `course-prerequisites` WHERE `course-prerequisites`.Prerequisites= `courses`.ID AND `course-prerequisites`.CourseID = $program ORDER BY `courses`.`Name`";
		} else {
			$sql = "SELECT `ID`, `Name` FROM `courses` ORDER BY `courses`.`Name`";
		}

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}

	function showCoursesV($program = null, $selected = null) {

		if ($program != null) {
			$sql = "SELECT * FROM `study`, `programmes`, `program-course-link`, `study-program-link`, `courses`
				    WHERE `program-course-link`.CourseID = `courses`.ID 
					AND `program-course-link`.ProgramID = `programmes`.ID 
					AND `program-course-link`.ProgramID = `study-program-link`.`ProgramID`
					AND `study-program-link`.StudyID = `study`.ID 
					AND `study`.ID =  '$program'
					ORDER BY `courses`.`Name`";
					echo $sql;
		} else {
			$sql = "SELECT `ID`, `Name` FROM `courses` ORDER BY `courses`.`Name`";
		}

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}

	function showLeave() { 

		$sql = "SELECT `ID`, `Name`
		FROM `leavetypes`";

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}

	function showUsers($role = null, $selected = null) {

		$sql = "SELECT `basic-information`.`ID`, CONCAT(`Surname`, ' ', `MiddleName`, ' ',  `FirstName`) 
		FROM `basic-information`, `access`, `roles` 
		WHERE `access`.`ID` = `basic-information`.`ID` 
		AND `access`.`RoleID` = `roles`.`ID` 
		AND `access`.`RoleID` >= '$role'
		ORDER BY CONCAT(`Surname`, ' ', `MiddleName`, ' ',  `FirstName`) ASC";

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}

	function showPaymentTypes($selected = null) {

		$sql = "SELECT `ID`, `Value`, `Name` FROM `settings` WHERE `Name` LIKE 'PaymentType%' ORDER BY `Name`";

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}

	function showSchools($selected = null) {

		$sql = "SELECT `ID`, `Name` FROM `schools`  ORDER BY `Name` ASC";

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}

	function showStudies($selected = null) {

		$sql = "SELECT `ID`, `Name` FROM `study` ORDER BY `Name` ASC";

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}

	function showRoles($selected = null) {

		$sql = "SELECT `ID`, `RoleName` FROM `roles`  ORDER BY `RoleName` ASC";

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}


	function showPermissions($selected = null) {

		$sql = "SELECT `ID`, `PermissionDescription` FROM `permissions`";

		$run = $this->core->database->doSelectQuery($sql);
		$out = $this->core->database->fetch_all($run);

		return ($out);
	}

	function showAccommodation($selected = null) {

		$sql = "SELECT `ID`, `Name` FROM `accommodation`";

		$run = $this->core->database->doSelectQuery($sql);
		$fetch = $this->core->database->fetch_all($run);
		$out = $this->buildSelect($fetch, $selected);

		return ($out);
	}


}

?>
