<?php
ob_start();
session_start();
include_once('../includes/site_root.php');
include_once(DIR_ROOT."admin/includes/session_check.php");
include_once(DIR_ROOT."admin/includes/action_functions.php");
$notfn			=	new notification_types();
$objCommon		=	new common_functions();
if($sessionval == true){
	$page		=	"dashboard";
	if(isset($_GET['page'])){
		$page	=	$_GET['page'];
	}
	$pagefile	=	"pages/$page.php";
	if(file_exists($pagefile)){
		require_once($pagefile);
	}
}
else{
	$page		=	"login";
	$pagefile	=	"pages/$page.php";
	if(file_exists($pagefile)){
			require_once($pagefile);
		}
}

?>