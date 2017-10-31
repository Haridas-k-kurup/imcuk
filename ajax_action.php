<?php 
session_start();
include_once('includes/site_root.php');
include_once(DIR_ROOT."includes/session_check.php");
include_once(DIR_ROOT."includes/action_functions.php");
include_once(DIR_ROOT."class/forum_topics.php");
include_once(DIR_ROOT."class/forum_discussion.php");
include_once(DIR_ROOT."class/user_details.php");
//include_once(DIR_ROOT."class/group_info.php");
include_once(DIR_ROOT.'class/group_members.php');
$notfn			=	new notification_types();
$objCommon		=	new common_functions();
$objThread		=	new forum_topics();
$objUser		=	new user_details();
$objDiscuss		=	new forum_discussion();
//$objGroup		=	new group_info();
$objMember		=	new group_members();
	if(isset($_POST['type']) && $_POST['type'] == "ft" && $_POST['tId']&& $_POST['tHead']){ // EDIT TOPIC
		 $id				=	$objCommon->esc(trim($_POST['tId']));
		$chkPermission		=	$objThread->getRow('topic_id = "'.$id.'"');
			if($chkPermission['reg_id'] == $activeMem){
				$topic		=	$objCommon->esc(trim($_POST['tHead']));
				$desc		=	stripslashes($_POST['tBody']);
				$objThread->updateField(array('topic' =>$topic,'topic_desc' =>$desc),'topic_id ="'.$id.'"');
				echo 1;
			}else{
				echo 0;
			}
	}else if(isset($_POST['type']) && $_POST['type'] == "dt" && $_POST['did']){// DELETE(UPDATE STATUS) TOPIC
		
		$id					=	$objCommon->esc(trim($_POST['did']));
		$chkPermission		=	$objThread->getRow('topic_id = "'.$id.'"');
		if($chkPermission['reg_id'] == $activeMem){
				$status		=	0;
				$objThread->updateField(array('topic_status' =>$status),'topic_id ="'.$id.'"');
				echo 1;
		}else{
			echo 0;
		}
		
	}else if(isset($_POST['type']) && $_POST['type'] == "dt" && $_POST['dId']&& $_POST['dBody']){// EDIT TOPIC
		 $id				=	$objCommon->esc(trim($_POST['dId']));
		$chkPermission		=	$objDiscuss->getRow('dis_id = "'.$id.'"');
			if($chkPermission['reg_id'] == $activeMem){ 
				$desc		=	stripslashes($_POST['dBody']);
				$objDiscuss->updateField(array('discussion' =>$desc),'dis_id ="'.$id.'"');
				echo 1;
			}else{
				echo 0;
			}
	}else if(isset($_POST['type']) && $_POST['type'] == "dd" && $_POST['ddid']){// DELETE(UPDATE STATUS) TOPIC
		$id					=	$objCommon->esc(trim($_POST['ddid']));
		$chkPermission		=	$objDiscuss->getRow('dis_id = "'.$id.'"');
		if($chkPermission['reg_id'] == $activeMem){
				$status		=	0;
				$objDiscuss->updateField(array('dis_status' =>$status),'dis_id ="'.$id.'"');
				echo 1;
		}else{
			echo 0;
		}
	}
	else if(isset($_POST['type']) && $_POST['type'] == "changedp" && $_POST['image']){ // UPDATE PROFILE PIC
		$img				=	$objCommon->esc(trim($_POST['image']));
		$getImg				=	$objUser->getRow('reg_id="'.$activeMem.'"');
		$excImg				=	$getImg['ud_pofile_pic'];
		$path				=	"profiles/".$excImg;
		if(file_exists($path)){
			unlink($path);
		}
		$objUser->updateField(array("ud_pofile_pic" => $img),"reg_id='".$activeMem."'");
		echo 1;
	}
	else if(isset($_POST['type']) && $_POST['type'] == "unlinkdp" && $_POST['unimage']){ // UNLINK IMAGE WHILE PIC
		$img				=	$objCommon->esc(trim($_POST['unimage']));
		$getAll				=	$objUser->getAll('ud_pofile_pic="'.$img.'"','ud_pofile_pic');
		if(count($getAll)>0){
			echo 0;
		}else{
		$path				=	"profiles/".$img;
			if(file_exists($path)){
				unlink($path);
				echo 1;
			}
		}
		
	}else if(isset($_POST['act']) && $_POST['act'] == "addto" && $_POST['g'] && $_POST['id']){
		
		$groupId			=	$objCommon->esc(trim($_POST['g']));
		$regId				=	$objCommon->esc(trim($_POST['id']));
		$memberStatus		=	$objMember->getAll('group_id="'.$groupId.'" and reg_id = "'.$regId.'"', 'group_m_id');
			if(count($memberStatus) >0){
				$notfn->add_msg("Sorry you are alrady a member this group !",2);
			}else{
		$_POST['group_id']			=	$groupId; 	
		$_POST['reg_id']			=	$regId;
		$_POST['group_m_status']	=	1;
			$objMember->insert($_POST);
			$notfn->add_msg("Member added successfully !",3);
			}
			
		
	}
	

?>