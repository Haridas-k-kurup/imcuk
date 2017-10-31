<?php
	include_once("../includes/site_root.php");
	$sessionval			=	true;
	if(!isset($_SESSION['adminid'])){
		$sessionval		=	false;	
	}else{
		$adminSession	=	$_SESSION['adminid'];
		$adminType		=	$_SESSION['admintype'];	
	}
?>