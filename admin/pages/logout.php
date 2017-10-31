<?php
session_start();
include_once("../includes/site_root.php");
include_once(DIR_ROOT."class/admin.php");
$objAdmin		=	new admin();
$adminId		=	$_SESSION['adminid'];
$adminLogStatus	=	0;
$objAdmin->updateField(array("admin_login_status"=>$adminLogStatus),"admin_id=".$adminId); 

session_destroy();
header("location:".SITE_ROOT."admin")
?>