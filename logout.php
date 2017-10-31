<?php
session_start();
include_once("includes/site_root.php");
include_once(DIR_ROOT.'class/registration_details.php');
$objReg		=	new registration_details();
$userId		=	$_SESSION['loginId'];
$objReg->updateField(array("reg_login_status" => 0),"reg_id=".$userId);
session_destroy();
header("location:".$_SERVER['HTTP_REFERER']);
?>