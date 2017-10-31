<?php 
session_start();
include_once('../includes/site_root.php');
include_once(DIR_ROOT."admin/includes/action_functions.php");
include_once(DIR_ROOT."class/manage_sub_sub_menu.php");
include_once(DIR_ROOT."class/manage_sub_sub_pluse.php");
include_once(DIR_ROOT."class/manage_sub_sub_inner.php");
$objSubSub		=	new manage_sub_sub_menu();
$objSubPluse	=	new manage_sub_sub_pluse();
$objSubInner	=	new manage_sub_sub_inner();
$objCommon		=	new common_functions();
$notfn			=	new notification_types();
$id				=	$objCommon->esc($_POST['id']);
if (!$id) {
	$id			=	$objCommon->esc($_POST['menu_id']);
}

$flag			=	$objCommon->esc($_POST['flag']);
if (!$flag) {
	$flag		=	$objCommon->esc($_POST['menu_flag']);
}

$actionFlag		=	$objCommon->esc($_POST['actionFlag']);// 1 for update 2 for delete 3 for status change
if (!$actionFlag) {
	$actionFlag	=	$objCommon->esc($_POST['menu_act_flag']);;
	}
	
$heading		=	$objCommon->esc($_POST['heading']);
if (!$heading) {
	$heading	=	$objCommon->esc($_POST['new_head']);
}

$desc			=	$_POST['desc'];
if (!$desc) {
	$desc		=	$_POST['new_desc'];
}

$position		=   $objCommon->esc($_POST['pos']);
if (!$position) {
	$position	=   $objCommon->esc($_POST['new_position']);
	}
if($flag == 1){
		if($actionFlag == 1){
			 $objSubSub->updateField(array("sub_sub_menu"=>$heading,"sub_sub_menu_details"=>$desc, "position" => $position),"sub_sub_id=".$id);
			 $notfn->add_msg("Details has been edited successfully",3);
			  header('location:'.$_SERVER['HTTP_REFERER']);
				}else if($actionFlag == 2){
					$notfn->add_msg("Details has been removed successfully",3);
			 		$objSubSub->delete("sub_sub_id=".$id);
					
		}

	} else if($flag == 2){
		if($actionFlag == 1){
			 $objSubPluse->updateField(array("sub_pluse_menu"=>$heading,"sub_pluse_details"=>$desc, "position" => $position),"sub_pluse_id=".$id);
			 $notfn->add_msg("Details has been edited successfully",3);
			  header('location:'.$_SERVER['HTTP_REFERER']);
		}else if($actionFlag == 2){
				$notfn->add_msg("Details has been removed successfully",3);
			 $objSubPluse->delete("sub_pluse_id=".$id);
		}
	
	}else if($flag == 3){
			if($actionFlag == 1){
			 $objSubInner->updateField(array("sub_inner_menu"=>$heading,"sub_inner_details"=>$desc, "position" => $position),"sub_inner_id =".$id);
			 $notfn->add_msg("Details has been edited successfully",3);
			  header('location:'.$_SERVER['HTTP_REFERER']);
				}else if($actionFlag == 2){
					$notfn->add_msg("Details has been removed successfully",3);
			 		$objSubInner->delete("sub_inner_id =".$id);
		}
        
         }
		 // for add new sub menu for menu
		 else if($_POST['act'] && $_POST['act'] == "addsub"){
			 $_POST['sub_sub_id']				=	$objCommon->esc($_POST['subId']);
			 $_POST['sub_pluse_menu']			=	$objCommon->esc($_POST['menu_name']);
			 $_POST['sub_pluse_details']		=	$_POST['menu_desc'];
			 $_POST['position']					=	$objCommon->esc($_POST['position']);
			 $_POST['sub_pluse_status']			=	1;
			 $objSubPluse->insert($_POST);
			 $notfn->add_msg("Menu Added Successfully",3);
		 }
		  // for add new subsub menu  for sub menu
		 else if($_POST['act'] && $_POST['act'] == "addsubsub" && $_POST['sub_menu_id']){
			 $_POST['sub_pluse_id']				=	$objCommon->esc($_POST['sub_menu_id']);
			 $_POST['sub_inner_menu']			=	$objCommon->esc($_POST['menu_name']);
			 $_POST['sub_inner_details']		=	$_POST['menu_desc'];
			 $_POST['position']					=	$objCommon->esc($_POST['position']);
			 $_POST['sub_inner_status']			=	1;
			 $objSubInner->insert($_POST);
			 $notfn->add_msg("Menu Added Successfully",3);
		 }
		 
 ?>