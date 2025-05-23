<?php
	include('appmvc.php');

	if(isset($_GET['page'])) $page = $_GET['page'];
	else $page = 1;

	$monapp = new AppMVC();
	
	$monapp -> afficherPage($page);
?>