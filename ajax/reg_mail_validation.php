<?php 
	session_start();
	include_once('../includes/site_root.php'); 
	include_once(DIR_ROOT."includes/session_check.php");
	include_once(DIR_ROOT.'class/user_details.php');
	$objUser			=	new user_details();
	$email				=	mysql_real_escape_string(trim($_POST['email']));
	if($email){
		$checkStatus	=	$objUser->getRow('ud_email = "'.$email.'"');
		$existMail		=	stripslashes($checkStatus['ud_email']);
		if($existMail == $email){
			echo 1;
		}else{
			echo 0;
		}
	}
 ?>