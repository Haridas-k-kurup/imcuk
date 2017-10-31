<?php
	session_start();
	include_once("../includes/site_root.php");
	include_once(DIR_ROOT."admin/includes/action_functions.php");
	include_once(DIR_ROOT."admin/includes/session_check.php");
	include_once(DIR_ROOT."class/admin_mailbox.php");
	include_once(DIR_ROOT."class/admin_mailreply.php");
	include_once(DIR_ROOT."class/admin_draft.php");
	include_once(DIR_ROOT."class/registration_details.php");
	include_once(DIR_ROOT."class/personal_messages.php");
	include_once(DIR_ROOT."class/personal_msg_draft.php");
	include_once(DIR_ROOT."class/contact_us_form.php");
	include_once(DIR_ROOT."class/contact_us_reply.php");
	
	$notfn							=	new notification_types();
	$objCommon						=	new common_functions();
	$objMail						=	new admin_mailbox();
	$objReply						=	new admin_mailreply();
	$objDraft						=	new admin_draft();
	$objReg							=	new registration_details();
	$objPMsg						=  	new personal_messages();
	$objPDraft						=	new personal_msg_draft();
	$objConForm						=	new contact_us_form();
	$objConReply					=	new contact_us_reply();
	$currentTime					=	date("Y-m-d H:i:s");
	if(isset($_GET['act']) && $_GET['act'] == "sendMail" && $_POST['email_to'] && $_POST['email_to']){
		$_POST['mail_from']			=	$adminSession;
		$_POST['mail_to']			=	$objCommon->esc(trim($_POST['email_to']));
		$_POST['mail_subject']		=	$objCommon->esc(trim($_POST['subject']));
		$_POST['mail_body']			=	$_POST['message'];
		$_POST['mail_created']		=	$currentTime;
		$_POST['mail_from_read']	=	0;
		$_POST['mail_to_read']		=	1;
		$_POST['mail_status']		=	1;
		$objMail->insert($_POST);
		if($_POST['draftid']){
			$draftId				=	$objCommon->esc(trim($_POST['draftid']));
			$chkDraft				=	$objDraft->getRow('draft_id ="'.$draftId.'"');
			if($chkDraft['draft_from'] == $adminSession){
					$objDraft->delete('draft_id = "'.$draftId.'"');
			}
		}
		$notfn->add_msg("Mail has been sent",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}else if(isset($_GET['act']) && $_GET['act'] == "sendReply" && $_POST['mail_dtl']){
		$mailId								=	$objCommon->esc(trim($_POST['mail_dtl']));
		$checkStatus						=	$objMail->getRow('mail_id ="'.$mailId.'"');
			if($checkStatus['mail_to'] == $adminSession || $checkStatus['mail_from'] == $adminSession){
				$_POST['mail_id']			=	$mailId;
				$_POST['reply_from']		=	$adminSession;
				$_POST['reply_body']		=	$_POST['message'];
				$_POST['reply_read_staus']	=	0;
				$_POST['reply_from_del']	=	0;
				$_POST['reply_to_del']		=	0;
				$_POST['reply_status']		=	1;
				$objReply->insert($_POST);
				$redFlag					=	1;
				if($checkStatus['mail_to'] == $adminSession){
					$objMail->updateField(array("mail_from_read" =>$redFlag),"mail_id =".$mailId);
				}else{
					$objMail->updateField(array("mail_to_read" =>$redFlag),"mail_id =".$mailId);
				}
				$notfn->add_msg("Reply has been sent",3);
				header("location:".$_SERVER['HTTP_REFERER']);
			}
		
		}else if(isset($_POST['df_act']) && $_POST['df_act'] == "draft"){
			$_POST['draft_from']			=	$adminSession;
			$_POST['draft_to']				=	$objCommon->esc(trim($_POST['toDtil']));
			$_POST['draft_subject']			=	$objCommon->esc(trim($_POST['df_subject']));
			$_POST['draft_body']			=	$_POST['df_message'];
			$_POST['draft_status']			=	1;
			$objDraft->insert($_POST);
		}else if(isset($_GET['act']) && $_GET['act']=="sendNotice"){
			$sendAll						=	$objCommon->esc(trim($_POST['notice_all']));
			$sendOption						=	$objCommon->esc(trim($_POST['notice_to']));
				
			if($sendAll || $sendOption){
			if($sendAll == 1){
				$getAllUser					=	$objReg->getAll('reg_status = 1');
				foreach($getAllUser as $siteUser){
					$_POST['msg_from']		=	1;
					$_POST['msg_to']		=	$siteUser['reg_id'];
					$_POST['msg_subject']	=	$objCommon->esc($_POST['notice_subject']);
					$_POST['msg_body']		=	$_POST['notice_message'];
					$_POST['from_status']	=	1;
					$_POST['to_status']		=	1;
					$_POST['msg_status']	=	1;
					
					$objPMsg->insert($_POST);
				}
			}else{
				
				if($sendOption){
					$getAllUser				=	$objReg->getAll('reg_type = "'.$sendOption.'" and reg_status = 1');
				foreach($getAllUser as $siteUser){
					$_POST['msg_from']		=	1;
					$_POST['msg_to']		=	$siteUser['reg_id'];
					$_POST['msg_subject']	=	$objCommon->esc($_POST['notice_subject']);
					$_POST['msg_body']		=	$_POST['notice_message'];
					$_POST['from_status']	=	1;
					$_POST['to_status']		=	1;
					$_POST['msg_status']	=	1;
					$objPMsg->insert($_POST);
				}
				}
			}
			if($_POST['user_draftid']){
				$udid						=	$objCommon->esc($_POST['user_draftid']);
				$objPDraft->delete($udid);
			}
			$notfn->add_msg("Notice has been sent",3);
			header("location:".$_SERVER['HTTP_REFERER']);
		} else if (!empty($_POST['multi_user'])) {
			$getAllUser						= $_POST['multi_user'];
			foreach($getAllUser as $siteUser){
					$_POST['msg_from']		=	1;
					$_POST['msg_to']		=	$siteUser;
					$_POST['msg_subject']	=	$objCommon->esc($_POST['notice_subject']);
					$_POST['msg_body']		=	$_POST['notice_message'];
					$_POST['from_status']	=	1;
					$_POST['to_status']		=	1;
					$_POST['msg_status']	=	1;
					
					$objPMsg->insert($_POST);
				}
				$notfn->add_msg("Notice has been sent",3);
				header("location:".$_SERVER['HTTP_REFERER']);
			
		} else if($_POST['send-ind-user']){
					$_POST['msg_from']		=	1;
					$_POST['msg_to']		=	$objCommon->esc($_POST['send-ind-user']);
					$_POST['msg_subject']	=	$objCommon->esc($_POST['notice_subject']);
					$_POST['msg_body']		=	$_POST['notice_message'];
					$_POST['from_status']	=	1;
					$_POST['to_status']		=	1;
					$_POST['msg_status']	=	1;
					
					$objPMsg->insert($_POST);
					$notfn->add_msg("Notice has been sent",3);
					header("location:".$_SERVER['HTTP_REFERER']);
			
			}else{
			$notfn->add_msg("Sorry ! Select any one option for receiver",4);
			header("location:".$_SERVER['HTTP_REFERER']);
		}
			
			}else if(isset($_POST['udf_act']) && $_POST['udf_act'] == "userDraft"){
			$_POST['personal_draft_from']		=	1;
			$_POST['personal_draft_subject']	=	$objCommon->esc(trim($_POST['df_subject']));
			$_POST['personal_draft_body']		=	$_POST['df_message'];
			$_POST['personal_draft_status']		=	1;
			$objPDraft->insert($_POST);
		}else if(isset($_GET['act']) && $_GET['act'] == "contactReply" && $_POST['con_dtil']){
			$contactId							=	$objCommon->esc(trim($_POST['con_dtil']));
			$getContact							=	$objConForm->getRow('contact_id = "'.$contactId.'"');
			$contactLog							=	mysql_real_escape_string($getContact['reg_id']);
			$_POST['contact_id']				=	$contactId;
			$_POST['contact_reply']				=	$_POST['con_reply'];
			$_POST['contact_replyed']			=	$adminSession;
			$_POST['contact_reply_satus']		=	1;
			$objConReply->insert($_POST);
			$objConForm->updateField(array('reply_status' => 1),'contact_id ="'.$contactId.'"');
				if($contactLog){
					$_POST['msg_from']			=	1;
					$_POST['msg_to']			=	$contactLog;
					$_POST['msg_subject']		=	mysql_real_escape_string($getContact['contact_subject']);
					$_POST['msg_body']			=	$_POST['con_reply'];
					$_POST['from_status']		=	1;
					$_POST['to_status']			=	1;
					$_POST['msg_status']		=	1;
					$objPMsg->insert($_POST);
					$to  						= 	mysql_real_escape_string($getContact['contact_email']); // note the comma
			
					// subject
					$subject 					= 	'Reply for your IMC Feedback';
					// message
					$message					= 	"IMC Message exists in your inbox";
					
					// To send HTML mail, the Content-type header must be set
					$headers  					= 	'MIME-Version: 1.0' . "\r\n";
					$headers 					.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					
					// Additional headers
					//$headers 					.= 	'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
					$headers 					.= 	'From: international medical connection <admin@websoftcreators.com>' . "\r\n";
					//$headers 					.= 	'Cc: birthdayarchive@example.com' . "\r\n";
					//$headers 					.= 	'Bcc: birthdaycheck@example.com' . "\r\n";
					// Mail it
					mail($to, $subject, $message, $headers);
					
				}else{
					$to  						= 	mysql_real_escape_string($getContact['contact_email']); // note the comma
			
					// subject
					$subject 					= 	'Reply for your IMC Feedback';
					// message
					$message					= 	$_POST['con_reply'];
					
					// To send HTML mail, the Content-type header must be set
					$headers  					= 	'MIME-Version: 1.0' . "\r\n";
					$headers 					.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					
					// Additional headers
					//$headers 					.= 	'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
					$headers 					.= 	'From: international medical connection <admin@websoftcreators.com>' . "\r\n";
					//$headers 					.= 	'Cc: birthdayarchive@example.com' . "\r\n";
					//$headers 					.= 	'Bcc: birthdaycheck@example.com' . "\r\n";
					// Mail it
					mail($to, $subject, $message, $headers);
			
				}
				$notfn->add_msg("Feed back reply has been sent",3);
				header("location:".$_SERVER['HTTP_REFERER']);
			
			}else{
		$notfn->add_msg("Sorry ! No action take place",4);
		header("location:".$_SERVER['HTTP_REFERER']);
	}
?>