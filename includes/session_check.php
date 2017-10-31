<?php
	//include_once("includes/site_root.php");
	$sessionval	=	true;
	
	if(!isset($_SESSION['loginId'])){
		$sessionval	=	false;
	}else{
		$activeMem	=	$_SESSION['loginId'];
	}
?>