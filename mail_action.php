<?php 
	ob_start();
	session_start();
	include_once("includes/site_root.php");
	include_once(DIR_ROOT."includes/session_check.php");
	include_once(DIR_ROOT."includes/action_functions.php");
	include_once(DIR_ROOT."class/personal_messages.php");
	include_once(DIR_ROOT."class/group_messages.php");
	include_once(DIR_ROOT."class/personal_reply.php");
	include_once(DIR_ROOT."class/group_replys.php");
	include_once(DIR_ROOT.'class/group_message_disply_status.php');
	include_once(DIR_ROOT.'class/personal_msg_draft.php');
	$notfn									=	new notification_types();
	$objCommon								=	new common_functions();
	$objEmail								=	new personal_messages();
	$objGrupEmail							=	new group_messages();
	$objReply								=	new personal_reply();
	$objGreply								=	new group_replys();
	$objGmsgDisply							=	new group_message_disply_status();
	$objDraft								=	new personal_msg_draft();
	if($activeMem){
	if(isset($_GET['act']) && $_GET['act'] == "firstMail" && (isset($_POST['details']) || isset($_POST['groups']))){
		
		if($_POST['details']){ //FOR SEND PERSONAL MESSAGES
			$msgTo							=	$_POST['details'];
			foreach($msgTo as $to){
				$_POST['msg_from']			=	$activeMem;
				$_POST['msg_to']			=	$objCommon->esc($to);
				$_POST['msg_subject']		=	$objCommon->esc(trim($_POST['subject']));
				$_POST['msg_body']			=	$objCommon->esc(trim($_POST['body']));
				$_POST['msg_attachment']	=	$objCommon->esc(trim($_POST['mailattached']));
				$_POST['from_status']		=	1;
				$_POST['to_status']			=	1;
				$_POST['msg_status']		=	1;
				$objEmail->insert($_POST);
			}
		$notfn->add_msg("Your Message has been Sent !",3);
		header('location:'.$_SERVER['HTTP_REFERER']);	
		}else if($_POST['groups']){
			$msgTo							=	$_POST['groups'];
			foreach($msgTo as $to){
				$_POST['gmsg_from']			=	$activeMem;
				$_POST['group_id']			=	$objCommon->esc($to);
				$_POST['gmsg_subject']		=	$objCommon->esc(trim($_POST['subject']));
				$_POST['gmsg_body']			=	$objCommon->esc(trim($_POST['body']));
				$_POST['gmsg_attachment']	=	$objCommon->esc(trim($_POST['mailattached']));
				$_POST['gmsg_status']		=	1;
				$objGrupEmail->insert($_POST);
			}
		$notfn->add_msg("Your Message has been Sent !",3);
		header('location:'.$_SERVER['HTTP_REFERER']);
		}
		
	}else if(isset($_GET['act']) && $_GET['act'] == "reply" && $_POST['forhim']){
			$msgId							=	$objCommon->esc(trim($_POST['forhim']));
			$msgCount						=	$objEmail->count("msg_id ='".$msgId."' and (msg_to = '".$activeMem."' or msg_from = '".$activeMem."') ");
			if($msgCount >0){
				$_POST['msg_id']			=	$msgId;
				$_POST['preply_from']		=	$activeMem;
				$_POST['preply_body']		=	$objCommon->esc(trim($_POST['replay'])); 	
				$_POST['preply_attachment']	=	$objCommon->esc(trim($_POST['mailattached']));
				$_POST['preply_status']		=	1;
				$objReply->insert($_POST);
				$notfn->add_msg("Your messge has been sent successfully !",3);
				header('location:'.$_SERVER['HTTP_REFERER']);	
			}
		}else if(isset($_POST['act']) && $_POST['act'] == "pdelete" && $_POST['ms']){
				$msgId						=	$_POST['ms'];
				$delAct						=	0;
				$objEmail->updateField(array('to_status' => $delAct),'msg_id="'.$msgId.'" and msg_to = "'.$activeMem.'"');
				$notfn->add_msg("Message has been deleted !",3);
		}
		else if(isset($_GET['act']) && $_GET['act'] == "gReply" && $_POST['mesg']){
			$msgId							=	$objCommon->esc(trim($_POST['mesg']));
			$msgQuery						=	"select count(msg.gmsg_id) as msgstatus from group_messages as msg left join group_members as mem on msg.group_id = mem.group_id left join user_details as user on mem.reg_id = user.reg_id where msg.gmsg_id= '".$msgId."' and user.reg_id = '".$activeMem."' and msg.gmsg_status = 1"; 
			$msgCount						=	$objGreply->getRowSql($msgQuery);
			 
			if($msgCount['msgstatus'] >0){
				$_POST['gmsg_id']			=	$msgId;
				$_POST['greply_from']		=	$activeMem;
				$_POST['greply_body']		=	$objCommon->esc(trim($_POST['greplay'])); 	
				$_POST['greply_attachment']	=	$objCommon->esc(trim($_POST['mailattached']));
				$_POST['greply_status']		=	1;
				$objGreply->insert($_POST);
				$notfn->add_msg("Your messge has been sent successfully !",3);
				header('location:'.$_SERVER['HTTP_REFERER']);	
			}
		}else if(isset($_POST['act']) && $_POST['act'] == "gdelete" && $_POST['gmsg']){
				$msgId						=	$_POST['gmsg'];
				$delAct						=	0;
				$msgQuery					=	"select count(msg.gmsg_id) as msgstatus from group_messages as msg left join group_members as mem on msg.group_id = mem.group_id left join user_details as user on mem.reg_id = user.reg_id where msg.gmsg_id= '".$msgId."' and user.reg_id = '".$activeMem."' and msg.gmsg_status = 1"; 
				$msgCount					=	$objGreply->getRowSql($msgQuery);
			if($msgCount['msgstatus'] >0){
				$_POST['group_m_id']		=	$activeMem;
				$_POST['gmsg_id']			=	$msgId;
				$objGmsgDisply->insert($_POST);
			}
			 
				$notfn->add_msg("Message has been deleted !",3);
		}else if(isset($_POST['act']) && $_POST['act'] == "draft"){
			$_POST['personal_draft_from']		=	$activeMem;
			$_POST['personal_draft_subject']	=	$objCommon->esc($_POST['subject']);
			$_POST['personal_draft_body']		=	$objCommon->esc($_POST['dtils']);
			$_POST['personal_draft_attachment']	=	$objCommon->esc($_POST['attach']);
			$_POST['personal_draft_status']		=	1;
			$objDraft->insert($_POST);
			echo 1;
				
		}else if(isset($_GET['act']) && $_GET['act'] == "sendDraft" && (isset($_POST['details']) || isset($_POST['groups']))){
			 $draftId						=	$objCommon->esc($_POST['draftId']);
			if($_POST['details']){ //FOR SEND PERSONAL MESSAGES 
			$msgTo							=	$_POST['details'];
			foreach($msgTo as $to){
				$_POST['msg_from']			=	$activeMem;
				$_POST['msg_to']			=	$objCommon->esc($to);
				$_POST['msg_subject']		=	$objCommon->esc(trim($_POST['dft_subject']));
				$_POST['msg_body']			=	$objCommon->esc(trim($_POST['dft_body']));
				$_POST['msg_attachment']	=	$objCommon->esc(trim($_POST['mailattached']));
				$_POST['from_status']		=	1;
				$_POST['to_status']			=	1;
				$_POST['msg_status']		=	1;
				$objEmail->insert($_POST);
			}
		}else if($_POST['groups']){
			$msgTo							=	$_POST['groups'];
			foreach($msgTo as $to){
				$_POST['gmsg_from']			=	$activeMem;
				$_POST['group_id']			=	$objCommon->esc($to);
				$_POST['gmsg_subject']		=	$objCommon->esc(trim($_POST['dft_subject']));
				$_POST['gmsg_body']			=	$objCommon->esc(trim($_POST['dft_body']));
				$_POST['gmsg_attachment']	=	$objCommon->esc(trim($_POST['mailattached']));
				$_POST['gmsg_status']		=	1;
				$objGrupEmail->insert($_POST);
			}
		
		}
		$objDraft->delete("personal_draft_id = '".$draftId."' and personal_draft_from = '".$activeMem."'");
		$notfn->add_msg("Your Message has been Sent !",3);
		header('location:'.$_SERVER['HTTP_REFERER']);	
			}else{
				$notfn->add_msg("Sorry ! An error occurred while taking action",2);
				header('location:'.$_SERVER['HTTP_REFERER']);
		}
	}else{
		$notfn->add_msg("Sorry an error occur in your action !",2);
		header('location:'.$_SERVER['HTTP_REFERER']);	
	}
	
	
 ?>