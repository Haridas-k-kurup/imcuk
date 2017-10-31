<?php 
session_start();
include_once('../includes/site_root.php');
include_once(DIR_ROOT."includes/session_check.php"); 
include_once(DIR_ROOT."includes/action_functions.php");
include_once(DIR_ROOT."class/group_info.php");
include_once(DIR_ROOT.'class/group_members.php');
$objCommon		=	new common_functions();
$objGroup		=	new group_info();
$objMember		=	new group_members();
if($_POST['act'] >0 && $_POST['act']){
	$act		=	$objCommon->esc($_POST['act']);
	$group_m_id	=	$objCommon->esc($_POST['m']);
	$actionQ	=	"select grp.reg_id, mem.group_m_status from group_members as mem left join group_info as grp on mem.group_id = grp.group_id where mem.group_m_id = '".$group_m_id."'";	
	$actionStus	=	$objMember->getRowSql($actionQ);
	 if($actionStus['reg_id'] == $activeMem){
		 $memberStatus		=	$actionStus['group_m_status'];
		 $checkowner		=	$objMember->getRow('group_m_id="'.$group_m_id.'"');
		 if($checkowner['reg_id'] != $actionStus['reg_id']){
			if($act	==	1){ 
				if($memberStatus == 0){
				$objMember->updateField(array("group_m_status" => 1), 'group_m_id = "'.$group_m_id.'"');
				}else{
				$objMember->updateField(array("group_m_status" => 0), 'group_m_id = "'.$group_m_id.'"');
				}
			}else if($act	==	2){
				$objMember->delete('group_m_id = "'.$group_m_id.'"');
			}
		 }
	 
	 }
	}
 ?>