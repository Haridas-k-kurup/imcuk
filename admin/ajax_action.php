<?php 
	session_start();
	include_once('../includes/site_root.php');
	include_once(DIR_ROOT."admin/includes/action_functions.php");
	include_once(DIR_ROOT."class/manage_sub_category.php");
	include_once(DIR_ROOT."class/manage_sub_pages.php");
	include_once(DIR_ROOT."class/manage_sub_menu.php");
	include_once(DIR_ROOT."class/manage_sub_sub_menu.php");
	$objSubCat		=	new manage_sub_category();
	$objSubPage		=	new manage_sub_pages();
	$objCommon		=	new common_functions();
	$notfn			=	new notification_types();
	$objSubMenu		=	new manage_sub_menu();
	$objSubSub		=	new manage_sub_sub_menu();
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
	
	$position		=   $_POST['pos'];
	if (!$position) {
		$position	=   $objCommon->esc($_POST['new_position']);
	}
	
	if ($flag == 1) {
		if($actionFlag == 1){
			 $objSubPage->updateField(array("sub_heading"=>$heading,"sub_information"=>$desc),"sub_id=".$id);
			 if ($position) { 
				 $pageCatDetls	=	$objSubPage->getRow('sub_id ='.$id,'sub_id');
				 $objSubCat->updateField(array("subcat_position"=>$position), 'subcat_id = '.$pageCatDetls['subcat_id']);
			 }
			 $notfn->add_msg("Details has been edited successfully",3);
			 header('location:'.$_SERVER['HTTP_REFERER']);
		}else if($actionFlag == 2){
			 $notfn->add_msg("Details has been removed successfully",3);
			 $objSubPage->delete("sub_id=".$id);
		}

	} else if($flag == 2){
		if($actionFlag == 1){
			 $objSubMenu->updateField(array("sub_menu_name"=>$heading,"sub_menu_details"=>$desc, 'position' => $position),"sub_menu_id=".$id);
			 $notfn->add_msg("Details has been edited successfully",3);
			 header('location:'.$_SERVER['HTTP_REFERER']);
		}else if($actionFlag == 2){
				$notfn->add_msg("Details has been removed successfully",3);
			 $objSubMenu->delete("sub_menu_id=".$id);
		}
	
	}else if($flag == 3){
			if($actionFlag == 1){
			 $objSubSub->updateField(array("sub_sub_menu"=>$heading,"sub_sub_menu_details"=>$desc, 'position' => $position),"sub_sub_id=".$id);
			 $notfn->add_msg("Details has been edited successfully",3);
			 header('location:'.$_SERVER['HTTP_REFERER']);
				}else if($actionFlag == 2){
					$notfn->add_msg("Details has been removed successfully",3);
			 		$objSubSub->delete("sub_sub_id=".$id);
		}
        
         }
		 
		 // for add new sub menu for menu
		 else if($_POST['act'] && $_POST['act'] == "addsub"){
			 $_POST['sub_id']			=	$objCommon->esc($_POST['subId']);
			 $_POST['sub_menu_name']	=	$objCommon->esc($_POST['menu_name']);
			 $_POST['sub_menu_details']	=	$objCommon->esc($_POST['menu_desc']);
			 $_POST['position']			=	$objCommon->esc($_POST['menu_pos']);
			 $objSubMenu->insert($_POST);
			 $notfn->add_msg("Menu Added Successfully",3);
		 }
		  // for add new subsub menu  for sub menu
		 else if($_POST['act'] && $_POST['act'] == "addsubsub" && $_POST['subcat_id']){
			 $_POST['subcat_id']				=	$objCommon->esc($_POST['subcat_id']);
			 $_POST['sub_menu_id']				=	$objCommon->esc($_POST['sub_menu_id']);
			 $_POST['sub_sub_menu']				=	$objCommon->esc($_POST['menu_name']);
			 $_POST['sub_sub_menu_details']		=	$objCommon->esc($_POST['menu_desc']);
			 $_POST['position']					=	$objCommon->esc($_POST['menu_pos']);
			 $objSubSub->insert($_POST);
			 $notfn->add_msg("Menu Added Successfully",3);
		 }
		  ?>
 