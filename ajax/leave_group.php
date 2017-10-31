<?php 
session_start();
include_once('../includes/site_root.php');
include_once(DIR_ROOT."includes/session_check.php"); 
include_once(DIR_ROOT."includes/action_functions.php");
//include_once(DIR_ROOT."class/group_info.php");
include_once(DIR_ROOT.'class/group_members.php');
$objCommon		=	new common_functions();
//$objGroup		=	new group_info();
$objMember		=	new group_members();
if(isset($_POST['g']) && $_POST['g'] >0){
	$group_m_id	=	$objCommon->esc(trim($_POST['g']));
	$groupIfo	=	$objMember->getRow('group_m_id = "'.$group_m_id.'"');
	if($groupIfo['reg_id'] == $activeMem){
		$objMember->delete('group_m_id = "'.$group_m_id.'"');
	}
}