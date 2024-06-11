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
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			$("#search-box").css("background","#FFF");
		}
		});
	});
});

$(document).ready(function () {
var i = 1;

    $('#sidebarCollapse').on('click', function () {
		
		if($('#sidebar').css("display") == 'none'){
			$('#sidebar').css("display","block");
			i = 0; 
		}else{
			$('#sidebar').css("display","none");
			i = 1;
		}


    });

});



document.addEventListener("click", function (e) {
  $("#suggesstion-box").hide();
});




function showMenu() {
var element = document.getElementById("sidebar-sticky");

  $('#menucontainer').toggleClass('d-none');
}


</script>

<script>

document.addEventListener("click", function (e) {
  $("#suggesstion-box").hide();
});




function showMenu() {
var element = document.getElementById("sidebar-sticky");

  $('#menucontainer').toggleClass('d-none');
}

</script>

<link href="<?php echo $this->core->fullTemplatePath; ?>/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->core->fullTemplatePath; ?>/css/bootstrap-theme.css" rel="stylesheet">

<link href="<?php echo $this->core->fullTemplatePath; ?>/css/dashboard.css" rel="stylesheet">
</head>
<body>

	<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">

		<a class="navbar-brand col-sm-3 col-md-2 mr-0" id="navbar-brand" href="<?php echo $this->core->conf['conf']['path']; ?>" >
		 <img src="<?php echo $this->core->fullTemplatePath; ?>/images/header.png" style="width: 130px;">  </a>

		<button id="sidebarCollapse" class="navbar-toggler" type="button" d data-target="#sidebar" aria-controls="sidebar" aria-expanded="true" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<?php
			if($this->core->role > 1){
				echo'<input class="form-control form-control-dark w-100" id="search-box" type="text" placeholder="Search" aria-label="Search">';
			}
		?>
		<div class=" navbar-collapse" id="topNavBar">
			<ul class="navbar-nav mr-auto"> 
				<li class="nav-item active">
					<a class="nav-link" href="<?php echo $this->core->conf['conf']['path']; ?>">Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="https://www.corelink.co.zm"> Website </a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="https://edurole.com/rc/"> Staff Mail </a>
				</li>

			</ul>
		</div>
	</nav>
	
	<div id="suggesstion-box" class="suggesstion-box"></div>
	
	<div id="mainpage">