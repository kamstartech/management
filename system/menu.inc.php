<?php
class menuConstruct {

	public $core;

	function __construct($core) {
		$this->core = $core;
	}

	public function buildMainMenu($menudata = FALSE) {

		if($menudata == FALSE){
			$menu = NULL;
		} else if(isset($this->core->role)){
			$menu = $this->fillMainMenu();
		}

		$menu = $this->menuContainer($menu);
	
		return $menu;
	}

	public function menuContainer($menu) {
 

			$container = '<nav class="sidebar-colapse colapse " id="sidebar" aria-expanded="true" >
							<div class="  bg-light" >
								<ul class="nav flex-column">
														
									<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
										<span>Current user: <strong>' . $this->core->username . '</strong></span>
											<a class="d-flex align-items-center text-muted" href="#">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
											</a>
									</h6>
					
									'.$menu.'
								</ul>
							</div>
						</nav>';
			$container .= '<main role="main"  id="content">';
			

	
		
		return $container;
	}

	private function fillMainMenu() {

		$menu = NULL;

		if($this->core->role != 1000){
			$sql = "SELECT *
			FROM `functions-permissions`, `functions`, `roles`
			WHERE `functions`.`FunctionMenuVisible` > 0
			AND `functions-permissions`.RoleID = " . $this->core->role ."
			AND `functions-permissions`.FunctionID = `functions`.ID
			AND `roles`.ID = " . $this->core->role ."
			ORDER BY `functions`.`FunctionMenuVisible` ASC";
		}else{
			$sql = "SELECT *, `PermissionDescription` as RoleName  
			FROM `permissions`, `functions`
			WHERE `functions`.`FunctionRequiredPermissions` = `permissions`.`ID`
			AND `permissions`.`RequiredRoleMin` LIKE '%'
			AND `permissions`.`RequiredRoleMax` NOT IN (2,3,4,5,7,8,9)
			AND `functions`.`FunctionMenuVisible` > 0
			ORDER BY `permissions`.`RequiredRoleMin`, `functions`.`FunctionRequiredPermissions`,  `functions`.`FunctionMenuVisible`";
		}

		$run = $this->core->database->doSelectQuery($sql);

		if ($run->num_rows == 0) {
			return $menu;
		}


		$currentSegment = NULL;
		$i=0;

		while ($fetch = $run->fetch_assoc()) {

			$segmentName = $fetch['RoleName'];
			$pageRoute = $fetch['Class'] . '/' . $fetch['Function'];
			$pageName = $fetch['FunctionTitle'];
			$icon = $fetch['Icon'];

			if (!isset($currentSegment)) {

				$menu .= $this->segmentHeader($segmentName, $i);

			} else if ($segmentName != $currentSegment) {

				$i++;
				
				if (strpos($segmentName, 'Student') !== false && $this->core->role = 1000) {
					
					continue;
				}
				
				$menu .= '</ul>';

				
				$menu .= $this->segmentHeader($segmentName, $i);
 
			}

			if($icon == ''){
				$icon = 'files.svg';
			}

			$menu .= $this->pageItem($pageRoute, $pageName, $icon);

			$currentSegment = $segmentName;

		}



		return $menu;

	}

	public function segmentHeader($segmentName, $count) {
		if(strlen($segmentName) > 25){
			$segmentName = substr($segmentName, 0, 25) . "...";
		}
		$id =  rand(1000, 9999);

		if($count == 0 || $count == 1){
			$expand = 'open';
		} 

		if($this->core->role < 1000){

		}
		
	
			$menu = '<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
						<span>' . $segmentName . '</span>
						  <a class="d-flex align-items-center text-muted" href="#">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
						  </a>
					</h6>
					
					<ul class="nav flex-column mb-2">';

		return $menu;
	}

	public function pageItem($pageRoute, $pageName, $icon) {
		$menu ='';
		
		

			
			if($pageName == 'Logout'){ 
				if($this->core->role == 1000){

				} 
			}
			
			
			if ($pageName == "Helpdesk Messages") {
				$uid = $this->core->userID;
				$sql = "SELECT `helpdesk`.ID as MID FROM `helpdesk`
				WHERE `RecipientID` LIKE '$uid' AND `Read` = 0
				OR `RecipientID` LIKE 'ALL'
				ORDER BY `MID` DESC";
				$runx = $this->core->database->doSelectQuery($sql);
				
				$sql = "SELECT `helpdesk`.ID as MID FROM `helpdesk`
				WHERE `RecipientID` LIKE '$uid' AND `Completed` IS NULL
				OR `RecipientID` LIKE 'ALL'
				ORDER BY `MID` DESC";
				$rund = $this->core->database->doSelectQuery($sql);
				
				$countm = $runx->num_rows;
				$countp = $rund->num_rows;

				$menu .= '<li class="nav-item"> 
						<a class="nav-link" href="' . $this->core->conf['conf']['path'] . '/' . $pageRoute . '">
						<img src="' . $this->core->conf['conf']['path'] . '/templates/mobile/bootstrap-icons/'.$icon.'" alt="" title="'.$icon.'">
							' . $pageName . ' <span class="mailcount"><b>'.$countm.'</b></span><span class="pendingcount"><b>'.$countp.'</b></span>
						</a>
					</li>';
					
				return $menu;
			}
						
			if ($pageName == "Message Inbox") {
				$uid = $this->core->userID;
				$sql = "SELECT `helpdesk`.ID as MID FROM `helpdesk`
				WHERE `RecipientID` LIKE '$uid' AND `Read` = 0
				OR `RecipientID` LIKE 'ALL'
				ORDER BY `MID` DESC";

				$runx = $this->core->database->doSelectQuery($sql);
				$countm = $runx->num_rows;

				$menu .= '<li class="nav-item">
						<a class="nav-link" href="' . $this->core->conf['conf']['path'] . '/' . $pageRoute . '">
						<img src="' . $this->core->conf['conf']['path'] . '/templates/mobile/bootstrap-icons/'.$icon.'" alt="" title="'.$icon.'"> &nbsp; 
						' . $pageName . ' <span class="mailcount"><b>'.$countm.'</b></span>
						</a>
					</li>';
					
				
			}
			
	
			$menu .= '<li class="nav-item">
						<a class="nav-link" href="' . $this->core->conf['conf']['path'] . '/' . $pageRoute . '">
						<img src="' . $this->core->conf['conf']['path'] . '/templates/mobile/bootstrap-icons/'.$icon.'" alt="" title="'.$icon.'"> &nbsp; 
						' . $pageName . '
						</a>
					</li>';

		return $menu;
	}
	
	


}
?>