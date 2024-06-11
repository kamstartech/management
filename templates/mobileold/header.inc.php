<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">




  <style type="text/css">
	@-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}
</style>

<meta name="apple-mobile-web-app-capable" content="yes" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->core->getTitle(); ?></title>

<link rel="icon" type="image/png" href="<?php echo $this->core->conf['conf']['path']; ?>/templates/edurole/images/apple-touch-icon-144x144-precomposed.png">
<link rel="apple-touch-startup-image" href="<?php echo $this->core->conf['conf']['path']; ?>/templates/edurole/images/splash-screen-320x460.png" media="screen and (max-device-width: 320px)" />
<link rel="apple-touch-startup-image" media="(max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2)" href="<?php echo $this->core->conf['conf']['path']; ?>/templates/edurole/images/splash-screen-640x920.png" />
<link rel="apple-touch-icon" href="<?php echo $this->core->conf['conf']['path']; ?>/templates/edurole/images/apple-touch-icon-57x57-precomposed.png" />
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $this->core->conf['conf']['path']; ?>/templates/edurole/images/apple-touch-icon-72x72-precomposed.png" />
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $this->core->conf['conf']['path']; ?>/templates/edurole/images/apple-touch-icon-114x114-precomposed.png" />
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $this->core->conf['conf']['path']; ?>/templates/edurole/images/apple-touch-icon-144x144-precomposed.png" />

<?php 
echo $this->cssFiles;
echo $this->jsFiles; 

if(isset($this->jsConflict)){
	echo'<script type="text/javascript">
		jQuery.noConflict();
	</script>';
}
?>
<script>
$(document).ready(function(){
	$("#search-box").keyup(function(){
		$.ajax({ 
		type: "GET",
		url: "/api/search",
		data:'data='+$(this).val(),
		beforeSend: function(){
			$("#search-box").css("background","#FFF url(<?php echo $this->core->fullTemplatePath; ?>/images/loader.gif) no-repeat 325px");
		},
		success: function(data){
			
			$('.menuburger').text('OPEN MENU');
			$('#menucontainer').addClass('d-none');
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			$("#search-box").css("background","#FFF");
		}
		});
	});
});
</script>

<script>

document.addEventListener("click", function (e) {
  $("#suggesstion-box").hide();
});




function showMenu() {
	var element = document.getElementById("sidebar-sticky");
  $('.menuburger').text('CLOSE MENU');
  $("#navbar-brand").attr("onclick","hideMenu()");
  $('#menucontainer').toggleClass('d-none');
}
function hideMenu() {
	var element = document.getElementById("sidebar-sticky");
  $('.menuburger').text('OPEN MENU');
  $("#navbar-brand").attr("onclick","showMenu()");
  $('#menucontainer').toggleClass('d-none');
}




</script>

<link href="<?php echo $this->core->fullTemplatePath; ?>/css/dashboard.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">

      <a class="navbar-brand col-sm-3 col-md-2 mr-0" id="navbar-brand" href="https://portal.unilus.ac.zm" onclick="showMenu()">
	  <img src="<?php echo $this->core->fullTemplatePath; ?>/images/header.png" style="width: 30px;"> &nbsp; &nbsp; UNILUS	  
	  <?php
	  
	  	if($this->core->role > 0){
			if($this->core->role < 100){
				echo'<div class="menuburger">OPEN MENU</div></a>';
			}else {
				
				echo'<div class="menuburger">OPEN MENU</div></a>';
				echo'<input class="form-control form-control-dark w-100" id="search-box" type="text" placeholder="Search" aria-label="Search">';
			}
		} else {
			echo'</a>';
		}
	  
	  ?>
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">

        </li>
      </ul>
	  
	  
</nav>
	<div id="suggesstion-box" class="suggesstion-box">
	</div>
	
	<div class="container-fluid">
      <div class="row">
	  

		
