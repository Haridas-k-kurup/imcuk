<?php
	ob_start();
	session_start();
	include_once("includes/site_root.php");
	include_once(DIR_ROOT."includes/action_functions.php");
	include_once(DIR_ROOT."class/reset_password.php");
	include_once(DIR_ROOT."class/user_details.php");
	include_once(DIR_ROOT."class/registration_details.php");
	$notfn				=	new notification_types();
	$objCommon			=	new common_functions();
	$objReset			=	new reset_password();
	$objUser			=	new user_details();
	$objRegister		=	new registration_details();
	$currentTime		=	date("Y-m-d H:i:s");
	if(isset($_POST['account'])){
			$email								=	$objCommon->esc($_POST['account']);
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) // Validate email address
			{
				$message 						=  "Invalid email address please type a valid email!!";
				$notfn->add_msg($message,4);
				header('location:'.$_SERVER['HTTP_REFERER']);
			}else{
				$getUser						=	$objUser->getRow('ud_email = "'.$email.'"');
					if($getUser['reg_id']){
						$getUserName			=	$objRegister->getRow('reg_id='.$getUser['reg_id']);
						$sqTime 				= 	strtotime($currentTime);
						$sendCode				=	md5($sqTime*7+$getUser['reg_id']);
						if($getUser['ud_name_title']){
							$name 				=	stripslashes($getUser['ud_name_title']).": ".stripslashes($getUser['ud_first_name']);
						}else{
							$name 				=	stripslashes($getUser['ud_first_name']);
						}
						$_POST['reg_id']		=	$getUser['reg_id'];
						$_POST['reset_code']	=	$sendCode;
						$_POST['reset_date']	=	$currentTime;
						$_POST['reset_status']	=	1;
						$objReset->insert($_POST);
						$resetId				=	$objReset->insertId();
						$message 				= 	"IMC Security";
						$to						=	$email;
						$subject				=	"IMC Security";
						$from 					= 	'security-noreply@imc.com';
						$body					=	'Hi, '.$name.' <br/> <br/> <br>You have mentioned that you have forgotten username or password. <br><br> Your user name is : '.$getUserName['reg_user_name'].'<br><br> If you want to change your password, please paste following link to your browser or click on the link: '.SITE_ROOT.'change_password.php?at=reset&ps='.$resetId.'&imcp='.$sendCode.' <br/> <br/>--<br>internationalmedicalconnection.com<br>The link will expire in 24 hours, so be sure to use it right away. <br><br>Thanks for using IMC!<br>
The IMC Team';
						$headers 				= 	"From: security-noreply@imc.com\r\n";
						$headers 				.= 	"Reply-To: security-noreply@imc.com\r\n";
						$headers 				.= 	"MIME-Version: 1.0\r\n";
						$headers 				.= 	"Content-Type: text/html; charset=ISO-8859-1\r\n";
 
           				if(mail($to,$subject,$body,$headers)){
							$_SESSION['sent-info']	=	"sent";
							header('location:sentmail.php');
						}else{
							$message			=	"We couldn't sent email to '".$email."'. Try again.";
						$notfn->add_msg($message,4);
						header('location:'.$_SERVER['HTTP_REFERER']);
						}
					}else{
						$message				=	"We couldn't find an IMC account associated with '".$email."'.";
						$notfn->add_msg($message,4);
						header('location:'.$_SERVER['HTTP_REFERER']);
					}
			}
			
		
	}else if(isset($_GET['act']) && $_GET['act'] == "change-password" && $_POST['new_password']){
		if($_SESSION['reset']){
						$regId					=	$_SESSION['reset'];
						$password				=	$objCommon->esc($_POST['new_password']);
						$conPass				=	$objCommon->esc($_POST['con_pass_word']);
							if($password == $conPass){
								$newPass		=	md5($password);
								$objRegister->updateField(array("reg_pass_word" => $newPass, "reg_editedon" => $currentTime), 'reg_id = "'.$regId.'"');
								$objReset->delete('reg_id = "'.$regId.'"');
								unset($_SESSION['reset']);
								$_SESSION['reset-okay']	=	"success";
								header('location:reset-password-submit.php');
							}
		}
		
	}else{
		header('location:'.SITE_ROOT);
	}
?>