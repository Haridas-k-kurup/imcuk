<?php 
	session_start();
	include_once('../includes/site_root.php'); 
	include_once(DIR_ROOT."includes/session_check.php");
	include_once(DIR_ROOT.'class/registration_details.php');
	$objReg				=	new registration_details();
	$user				=	mysql_real_escape_string(trim($_POST['user']));
	if($user){
		$checkStatus	=	$objReg->getRow('reg_user_name = "'.$user.'"');
		$existUser		=	stripslashes($checkStatus['reg_user_name']);
		if($existUser == $user){
			echo 1;
		}else{
			echo 0;
		}
	}
 ?>