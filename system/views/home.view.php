<?php
class home {

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

	public function showHome($item) {
		require_once "system/components.inc.php";
		include $this->core->conf['conf']['viewPath'] . "item.view.php";

		$items = new item();
		$items->buildView($this->core);
	
		if($item == "internet"){
			echo'<div class="successpopup">You have logged in succesfuly, you can now browse the internet. <br>Please keep in mind your data limit for today is <u>700MB</u>.</div>';
		}


		$userid =$this->core->userID;
		
	
		$sql = "SELECT * FROM `basic-information`WHERE ID = '$userid'";
		$run = $this->core->database->doSelectQuery($sql);

		while ($fetch = $run->fetch_assoc()) {
			$status = $fetch['Status'];
		}

		if($status == "Locked"){
			echo'<div class="errorpopup">Your account is locked because you have not fully registered. Complete your registration first.</div>';
			return;
		}


		$this->infoSheet();
		$items->overviewItem('news', "News and updates");
		$items->showItem(1, NULL);

		if ($this->core->role >= 100) {
			$this->globalStatistics();
		}

	
	}



	private function globalStatistics() {

		$periodf = $this->core->getPeriod('Fulltime');
		$periodd = $this->core->getPeriod('Distance');
		$periodp = $this->core->getPeriod('Partime');
		
		$year = date('Y');
		$this->core->logEvent("Initializing global user statistics count", "3");

		$sql = "SELECT  
		(SELECT COUNT(DISTINCT `ID`) FROM `clients`) AS clients, 
		(SELECT COUNT(DISTINCT `ID`) FROM `quotations` WHERE `Status` IN ('INVOICED', 'PAID')) AS orders, 
		(SELECT COUNT(DISTINCT `ID`) FROM `quotations` WHERE `Status` IN ('PAID')) AS paid, 
		(SELECT SUM(`Amount`) FROM `transactions`) AS revenue,
		(SELECT SUM(`Amount`) FROM `transactions` WHERE YEAR(`TransactionDate`) = '$year') AS revenueyear,
		(SELECT SUM(`Amount`)-SUM(`Amount`/1.16) FROM `transactions` WHERE `Type` = 1) AS vat";

		$run = $this->core->database->doSelectQuery($sql);

		while ($row = $run->fetch_row()) {
			$clients = $row[0];
			$orders= $row[1];
			$paid = $row[2];
			$revenue = $row[3];
			$revenueyear = $row[4];
			$vat = $row[5];
		}



		
		echo'<div class="itemheader"><h2>General statistics</h2></div>';

		echo '<div style="width: 100%">
        	<div class="statistics" style="height: 115px">'.$this->core->translate("Total Clients").': <a href="'. $this->core->conf['conf']['path'] .'/clients/manage"><div class="statistic"> ' . number_format($clients) . '</div></a></div>
        	<div class="statistics" style="height: 115px">'.$this->core->translate("Total Orders").': <a href="'. $this->core->conf['conf']['path'] .'/invoices/manage"><div class="statistic">' . number_format($orders) . '</div></a></div>
         	<div class="statistics" style="height: 115px">'.$this->core->translate("Total Paid").': <a href="'. $this->core->conf['conf']['path'] .'/quotation/manage/PAID"><div class="statistic">' . number_format($paid) . '</div></a></div> 
         	<div class="statistics" style="height: 115px">'.$this->core->translate("Total Revenue").': <a href="'. $this->core->conf['conf']['path'] .'/payments/manage"><div class="statistic">' . number_format($revenue) . '</div></a></div> 
        	<div class="statistics" style="height: 115px">'.$this->core->translate("Yearly Revenue").': <a href="'. $this->core->conf['conf']['path'] .'/payments/manage"><div class="statistic"  style="color: #2C89D4;">' . number_format($revenueyear) . '</div></a></div>
			<div class="statistics" style="height: 115px">'.$this->core->translate("Total VAT").':  <a href="'. $this->core->conf['conf']['path'] .'/vat/manage"><div class="statistic">' . number_format($vat) . '</div></a></div>
			</div>';
	}

	private function infoSheet() {

		$this->core->logEvent("Initializing info-sheet", "3");

		$sql = "SELECT * FROM `basic-information` as bi, `access` as ac WHERE ac.`Username` = '" . $this->core->userID . "' AND ac.`Username` = bi.`ID` OR ac.`ID` = '" . $this->core->userID . "' AND ac.`ID` = bi.`ID`  ";
		$run = $this->core->database->doSelectQuery($sql);
		$user=  $this->core->userID;

		if ($run->num_rows == 0) {
			$this->core->throwSuccess($this->core->translate("Please take the time to enter your profile information first, you can do this <a href='". $this->core->conf['conf']['path'] ."/information/edit/personal'>here</a>."));
		}

		while ($row = $run->fetch_row()) {

			$id = $this->core->userID;
			$firstname = $row[0];
			$middlename = $row[1];
			$surname = $row[2];
			$sex = $row[3];
			$idnumber = $row[4];
			$nrc = $row[5];
			$studytype = $row[22];
			$username = $row[22];

			if(empty($firstname) && empty($lastname)){
				$this->core->throwSuccess($this->core->translate("Please take the time to enter your profile information first, you can do this <a href='". $this->core->conf['conf']['path'] ."/information/edit/personal'>here</a>."));
			}

			$sql = "SELECT * FROM `content` WHERE `ContentCat` = 'news' ORDER BY `ContentID` DESC LIMIT 1";
			$runx = $this->core->database->doSelectQuery($sql);


echo"<script>
document.addEventListener('DOMContentLoaded', function () {
  if (Notification.permission !== 'granted')
    Notification.requestPermission();
});


  if (Notification.permission !== 'granted')
    Notification.requestPermission();
  else {";


    


			while ($row = $runx->fetch_assoc()) {
				$name =  $row['Name'];
				$content =  strip_tags($row['Content']);
				$url =  $row['URL'];

				if(empty($url)){
					$url =  $row['Files'];
				}

				echo"    var notification = new Notification('$name', {
      icon: 'https://sis.zcas.ac.zm/templates/edurole/images/apple-touch-icon-144x144-precomposed.png',
      body: '$content',
    });

    notification.onclick = function () {
      window.open('$url');      
    };";
			}

  echo'}
</script>';

			echo '<div class="col-lg-12 greeter">'.$this->core->translate("Welcome").' ' . $firstname . ' ' . $surname . '</div>
			<div class="col-lg-12 panel panel-default">

               	 	<table width="600" border="0" cellpadding="2"><tr>';

			if ($this->core->role < 100) {
				echo'<td  width="117">';
				echo $this->core->translate("Student number");
				echo'</td>';
			} else {
				echo '<td  width="200">';
				echo $this->core->translate("Employee number");
				echo '</td>';
			}

			echo '<td><b>' . $idnumber . '</a></td></tr>';
			echo '<tr><td>';
			echo $this->core->translate("Your privileges");
			echo'</td> <td>' . $this->core->roleName . '</td></tr>';
			echo '<tr><td>';

			$sql = "SELECT * FROM `access` as ac, `study` as st
				LEFT JOIN  `student-study-link` as ss ON ss.`StudentID` = ''
				LEFT JOIN  `student-program-link` as pl ON pl.`StudentID` = '$id'
				WHERE ac.`ID` = ''
				AND ss.`StudyID` = st.`ID`";

			$run = $this->core->database->doSelectQuery($sql);

			while ($row = $run->fetch_row()) {

				$status = $row[7];
				$study = $row[14];

				echo '<tr><td>';
				echo $this->core->translate("Selected Study");
                        	echo'</td><td><b><a href="' . $this->core->conf['conf']['path'] . '/studies/show/' . $row[8] . '">' . $study . '</a></b></td>
                        	</tr>';

				$sql = "SELECT * FROM `programmes` as pr WHERE pr.`ID` = '$row[23]' OR pr.`ID` = '$row[24]'";
				$run = $this->core->database->doSelectQuery($sql);

				$i = 0;

				while ($row = $run->fetch_row()) {

					$programme = $row[2];

					if ($i == 0) {
						$majmin = "major";
						$i++;
					} else {
						$majmin = "minor";
						$n = 1;
					}

				echo '<tr><td>';
				echo $this->core->translate("Selected");
                                echo ' ' . $majmin . '</td>
                                <td>' . $programme . '</td>
                                </tr>';
				}

				if ($majmin == "major") {
					echo '<tr><td>';
					echo $this->core->translate("Selected Minor");
					echo'</td><td>' . $programme . '</td></tr>';
				}
			}

			echo '</table></div>';

		}

	}

	private function easyMenu() {
		if ($this->core->role > 10) {
			echo '<div style="float:left; margin-bottom: 5px; width: 100%">
                 	<div class="easymen"><a href="https://astrialibrary.com/"><img src="' . $this->core->fullTemplatePath . '/images/books.png"> <br>  Astria Library</a></div>
                 	<div class="easymen"><a href="' . $this->core->conf['conf']['path'] . '/grades"><img src="' . $this->core->fullTemplatePath . '/images/chart.png"> <br> Grades</a></div>
                 	<div class="easymen"><a href="' . $this->core->conf['conf']['path'] . '/calendar"><img src="' . $this->core->fullTemplatePath . '/images/calendar.png"> <br> Calendar</a></div>
		 	<div class="easymen"><a href="' . $this->core->conf['conf']['path'] . '/files/personal"><img src="' . $this->core->fullTemplatePath . '/images/box.png"> <br>  Files</a></div>
                 	<div class="easymen"><a href="' . $this->core->conf['conf']['path'] . '/assignments"><img src="' . $this->core->fullTemplatePath . '/images/clipboard.png">  <br> Assignments</a></div>
                 	<div class="easymen"><a href="' . $this->core->conf['conf']['path'] . '/payments/show"><img src="' . $this->core->fullTemplatePath . '/images/money.png"> <br> Payments</a></div>
                 	<div class="easymen"><a href="' . $this->core->conf['conf']['path'] . '/helpdesk/message"><img src="' . $this->core->fullTemplatePath . '/images/info.png">  <br> Help</a></div>
                	</div>';
		} else {
			echo '<div style="float:left; margin-bottom: 5px; width: 100%">
                 	<div class="easymen"><a href="https://astrialibrary.com/"><img src="' . $this->core->fullTemplatePath . '/images/books.png"> <br>  Astria Library</a></div>
                 	<div class="easymen"><a href="' . $this->core->conf['conf']['path'] . '/grades/personal"><img src="' . $this->core->fullTemplatePath . '/images/chart.png"> <br> Grades</a></div>
                 	<div class="easymen"><a href="' . $this->core->conf['conf']['path'] . '/calendar/personal"><img src="' . $this->core->fullTemplatePath . '/images/calendar.png"> <br> Calendar</a></div>
		 	<div class="easymen"><a href="' . $this->core->conf['conf']['path'] . '/files/personal"><img src="' . $this->core->fullTemplatePath . '/images/box.png"> <br>  Files</a></div>
                 	<div class="easymen"><a href="' . $this->core->conf['conf']['path'] . '/assignments/show"><img src="' . $this->core->fullTemplatePath . '/images/clipboard.png">  <br> Assignments</a></div>
                 	<div class="easymen"><a href="' . $this->core->conf['conf']['path'] . '/payments/personal"><img src="' . $this->core->fullTemplatePath . '/images/money.png"> <br> Payments</a></div>
                 	<div class="easymen"><a href="' . $this->core->conf['conf']['path'] . '/helpdesk/message"><img src="' . $this->core->fullTemplatePath . '/images/info.png">  <br> Help</a></div>
                	</div>';
		}

	}
}

?>
