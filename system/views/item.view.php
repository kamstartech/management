<?php
class item {

	public $core;
	public $view;

	public function configView() {
		$this->view->header = TRUE;
		$this->view->footer = TRUE;
		$this->view->menu = TRUE;
		$this->view->javascript = array('require', 'aloha');
		$this->view->css = array('aloha');

		return $this->view;
	}

	public function buildView($core) {
		$this->core = $core;
	}

	public function overviewItem($id, $title) {
		$role = $this->core->role;

		$sql = "SELECT * FROM `content` WHERE `ContentCat` = '$id' AND `Privileges` LIKE '%+$role+%' 
			OR `ContentCat` = '$id' AND `Privileges` LIKE ''
			ORDER BY PublishingDate DESC";
		$run = $this->core->database->doSelectQuery($sql);

		echo '<div class="col-lg-12 padding20 panel panel-default loginpadding" style="padding-bottom: 15px;">';

		if ($this->core->role > 104) {
			echo '<div style="float: right;"><a href="' . $this->core->conf['conf']['path'] . '/item/add/'.$id.'">add</a></div>';
		}
        
		echo '<div class="itemheader"><h2>';
		echo $this->core->translate($title);
		echo '</h2></div> <p>';
		while ($row = $run->fetch_row()) {

			if($row[0] == 1){ continue; }

			echo '<div style="border-bottom: 1px dotted #ccc; height: 20px;">
				<div style="width: 85%; float:left; padding-left: 20px;"> <b><a href="' . $this->core->conf['conf']['path'] . '/item/show/' . $row[0] . '">' . $row[1] . '</a></b></div>
				<div class="hidden" style="width: 15%; float:left;">'. $row[6] .'</div>
			</div>';
		}
        
		echo '</p></div>';
	}

	public function deleteItem($item) {
		$sql = 'DELETE FROM `content` WHERE `ContentID` = "' . $item . '"';
		$run = $this->core->database->doInsertQuery($sql);

		$this->core->redirect("home", "show", NULL);
	}

	public function saveItem($item) {
		$id = $this->core->cleanPost['itemid'];
		$name = $this->core->cleanPost['name'];
		$roles = $this->core->cleanPost['roles'];
		$content = $_POST['content'];

		foreach($roles as $role){
			$privileges .= "+$role+";
		}

		if ($_FILES["file"]["name"] != '') {

			$file = $_FILES["file"];
		
			$home = getcwd();
			$path = $this->core->conf['conf']["dataStorePath"] . 'uploads';

	
		
			if (!is_dir($path)) {
				mkdir($path, 0755, true);
			}
		
			if ($_FILES["file"]["error"] > 0) {
				echo "Error: " . $file["error"]["file"] . "<br>";
			} else {
		
				$fname = $_FILES["file"]["name"];
				$destination = $path."/".$fname;
		
				if (file_exists($destination)) {
					$fname = rand(1,999) . '-' .$fname;
					$destination = $path."/".$fname;
				}

				move_uploaded_file($_FILES["file"]["tmp_name"], $destination);
				
				if(file_exists($destination)){
					echo'<div class="successpopup">File uploaded as '.$fname.'</div>';
				}
			}
		}

		foreach($links as $link){
			$linked = $link . ',';
		}
		
		$base = $this->core->conf['conf']['path'] . '/datastore/uploads/' . $fname;

		
		if(!empty($id)){
	            $sql = "UPDATE `content` SET `Content` = '".$content."', `Name` = '".$name."' WHERE `ContentID` = '".$id."';";
		}else{
	            $sql = "INSERT INTO `content` (`ContentID`, `URL`, `Name`, `Content`, `ContentCat`, `Files`, `PublishingDate`, `Privileges`) 
				VALUES (NULL, '', '".$name."', '".$content."', '".$this->core->item."', '$base', NOW(),  '$privileges');";
		}
		
        $run = $this->core->database->doInsertQuery($sql);

		$this->core->redirect("home", "show", NULL);
	}

	function showItem($id, $width) {
		if(!isset($width)){
			$width = "12";
		}

		$sql = "SELECT * FROM `content` WHERE `ContentID` = $id";
		$run = $this->core->database->doSelectQuery($sql);

		echo '<div class="col-lg-'.$width.' panel panel-default">';

		if ($this->core->role == 1000) {
			echo '<div style="float: right;"><a href="' . $this->core->conf['conf']['path'] . '/item/edit/' . $id . '">edit</a> | <a href="' . $this->core->conf['conf']['path'] . '/item/delete/' . $id . '">delete</a></div>';
		}

		while ($row = $run->fetch_assoc()) {
			echo '<div class="itemheader"><h2>' . $row['Name'] . '</h2></div>';
			echo ' <p>' . nl2br($row['Content']) . '</p>';

			$files = $row['Files'];
			$base = '//portal.edenuniversity.edu.zm/datastore/uploads/';
			if($files != '' && $files != $base){
				
				echo'<hr><a href="'.$files.'" class="btn btn-info">DOWNLOAD ATTACHMENT</a>';
			}
		}

		echo '</div>';

	}


	function addItem($item) {

		if ($this->core->role == 1000) {
			echo "<script type=\"text/javascript\">
				Aloha.ready( function() {
					var $ = Aloha.jQuery;
					$('.editable').aloha();
				});
			</script>";
		}



		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
		$select = new optionBuilder($this->core);
		$manager = $select->showUsers("100", null);
		$roles = $select->showRoles(null);
				
		include $this->core->conf['conf']['formPath'] . "additem.form.php";

		echo '</div>';

	}

	function editItem($id) {
		$sql = "SELECT * FROM `content` WHERE `ContentID` = $id";

		$run = $this->core->database->doSelectQuery($sql);

		if ($this->core->role == 1000) {
			echo "<script type=\"text/javascript\">
				Aloha.ready( function() {
					var $ = Aloha.jQuery;
					$('.editable').aloha();
				});
			</script>";
		}

		include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";
		$select = new optionBuilder($this->core);
		$manager = $select->showUsers("100", null);
		
		while ($row = $run->fetch_row()) {
			$name =  $row[1];
			$content = $row[2];

			include $this->core->conf['conf']['formPath'] . "edititem.form.php";
		}

		echo '</div>';

	}
}

?>

