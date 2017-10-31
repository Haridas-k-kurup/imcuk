<?php
	session_start();
	include_once("../includes/site_root.php");
	include_once(DIR_ROOT."admin/includes/action_functions.php");
	include_once(DIR_ROOT."admin/includes/session_check.php");
	include_once(DIR_ROOT."admin/includes/array_insert_fun.php");
	include_once(DIR_ROOT."class/admin.php");
	include_once(DIR_ROOT."class/admin_security.php");
	include_once(DIR_ROOT."class/country_details.php");
	include_once(DIR_ROOT."class/state_details.php");
	include_once(DIR_ROOT."class/manage_category.php");
	include_once(DIR_ROOT."class/manage_pages.php");
	include_once(DIR_ROOT."class/manage_page_connection.php");
	include_once(DIR_ROOT."class/forum_topics.php");
	include_once(DIR_ROOT."class/imc_pages.php");
	include_once(DIR_ROOT."class/manage_sub_category.php");
	include_once(DIR_ROOT."class/manage_topic_position.php");
	include_once(DIR_ROOT."class/manage_sub_pages.php");
	include_once(DIR_ROOT."class/manage_sub_menu.php");
	include_once(DIR_ROOT."class/manage_sub_sub_menu.php");
	include_once(DIR_ROOT."class/manage_sub_sub_pluse.php");
	include_once(DIR_ROOT."class/manage_sub_sub_inner.php");
	include_once(DIR_ROOT."class/city_details.php");
	include_once(DIR_ROOT."class/forum_discussion.php");
	include_once(DIR_ROOT."class/forum_discussion.php");
	include_once(DIR_ROOT."class/ad_management.php");
	include_once(DIR_ROOT."class/about_us.php");
	include_once(DIR_ROOT."class/promotional_ads.php");
	include_once(DIR_ROOT."class/submenu_page_connection.php");
	include_once(DIR_ROOT."class/imc_message.php");
	$notfn						= new notification_types();
	$objCommon					= new common_functions();
	$objAdmin					= new admin();
	$objCountry					= new country_details();
	$objState					= new state_details();
	$objCat						= new manage_category();
	$objPages					= new manage_pages();
	$objPageCon					= new manage_page_connection();
	$objForum					= new forum_topics();
	$pagesObj					= new imc_pages();
	$objSubcat					= new manage_sub_category();
	$objPos						= new manage_topic_position();
	$objSubPage					= new manage_sub_pages();
	$objSubMenu					= new manage_sub_menu();
	$objSubSubMenu				= new manage_sub_sub_menu();
	$objSubPluse				= new manage_sub_sub_pluse();
	$objSubInner				= new manage_sub_sub_inner();
	$objCity					= new city_details();
	$objDiscus					= new forum_discussion();
	$objAds						= new ad_management();
	$objSecurity				= new admin_security();
	$objAbout					= new about_us();
	$objpromotion				= new promotional_ads();
	$objSubMenuCon				= new submenu_page_connection();
	$objMessage					= new imc_message();
	$currentTime				= date("Y-m-d H:i:s");
	if(isset($_GET['act']) && $_GET['act']=="login" && $_POST['admin_username']	!='' && $_POST['admin_password']!=''){
		$admin_username			= $objCommon->esc(trim($_POST['admin_username']));
		$admin_password			= $objCommon->esc(trim($_POST['admin_password']));
		$getAdminSql			= "select admin_id,admin_type from admin where admin_username ='".$admin_username."' and  admin_password='".md5($admin_password)."' and admin_status=1";
		$getAdminCount							= $objAdmin->countRows($getAdminSql);
		if($getAdminCount >0){
			$getAdminDetails					= $objAdmin->getRowSql($getAdminSql);
			$_SESSION['adminid']				= $getAdminDetails['admin_id'];
			$_SESSION['admintype']				= $getAdminDetails['admin_type'];
			$ip									= $objCommon->get_ip();
			$adminLogStatus						= 1;
			$objAdmin->updateField(array("admin_last_visit_ip"=>$ip,"admin_last_visit"=>$currentTime,"admin_login_status"=>$adminLogStatus),"admin_id=".$getAdminDetails['admin_id']);  
			header("location:".SITE_ROOT."admin/index.php?page=dashboard");
		}else{
			$notfn->add_msg("Invalid username or password",4);
			header("location:".$_SERVER['HTTP_REFERER']);
		}
	}else if(isset($_GET['act']) && $_GET['act']=="addStaff" && $_POST['admin_pass']!='' && $_POST['admin_user']!=''){
			$_POST['admin_type']				= 2;
			$_POST['admin_username']			= $objCommon->esc(trim($_POST['admin_user']));
			$adminPassword						= $objCommon->esc(trim($_POST['admin_pass']));
			$_POST['admin_password']			= md5($adminPassword);
			$_POST['admin_image']				= $objCommon->esc(trim($_POST['staff_image']));
			$_POST['admin_last_visit_ip']		= $objCommon->get_ip();
			$_POST['admin_status']				= 1;
			$editAdmin							= $objCommon->esc(trim($_POST['admin_edit']));
			if($editAdmin){
				$objAdmin->update($_POST,"admin_id=".$editAdmin);
				$_POST['secur_dtil']			= $adminPassword;
				$objSecurity->update($_POST,"admin_id=".$editAdmin);
				$notfn->add_msg("Staff Permission has been Changed",3);
				header('location:index.php?page=list_staff');
				}else{
					$_POST['admin_createdon']	= $currentTime;
			$objAdmin->insert($_POST);	
			$lastAdminId						= $objAdmin->insertId();
			if ($lastAdminId) {
				$_POST['admin_id']				= $lastAdminId;
				$_POST['secur_dtil']			= $adminPassword;
				$objSecurity->insert($_POST);
			}
			$notfn->add_msg("Staff has been added",3);
			header("location:".$_SERVER['HTTP_REFERER']);
			}
			
	}
	/*-------- Country Details ---------*/
	else if(isset($_GET['act']) && $_GET['act']=="country" && $_POST['country_name']	!=''){
		$_POST['country_name']					= $objCommon->esc(trim($_POST['country_name']));
		$_POST['country_capital']				= $objCommon->esc(trim($_POST['country_capital']));
		$_POST['country_status']				= 1;
		$editId									= $objCommon->esc(trim($_POST['editId'])); 	
		if($editId){
			$objCountry->update($_POST,"country_id=".$editId);
			$notfn->add_msg("Country Details has successfully been Updated...!",3);
		}else{
			$objCountry->insert($_POST);
			$notfn->add_msg("Country details has successfully been added...!",3);
		}
		header("location:".$_SERVER['HTTP_REFERER']);
	}
else if(isset($_POST['act']) && $_POST['act']=="add_country_del" && $_POST['cdid']	!=''){
		$did						  =	$objCommon->esc(trim($_POST['cdid']));
		$objCountry->delete("country_id=".$did);
		$notfn->add_msg("Selected item has been removed successfully...!",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	/*-------- State Details ---------*/
	else if(isset($_GET['act']) && $_GET['act']=="states" && $_POST['country_id']!=''){
		$_POST['country_id']					= $objCommon->esc(trim($_POST['country_id']));
		$_POST['state_name']					= $objCommon->esc(trim($_POST['state_name']));
		$_POST['state_capital']					= $objCommon->esc(trim($_POST['state_capital']));
		$_POST['state_status']					= 1;
		$editId									= $objCommon->esc(trim($_POST['editId'])); 	
		if ($editId) {
			$objState->update($_POST,"state_id=".$editId);
			$notfn->add_msg("State Details has successfully been Updated...!",3);
		}else{
			$objState->insert($_POST);
			$notfn->add_msg("State Details has successfully been added...!",3);
		}
		header("location:".$_SERVER['HTTP_REFERER']);
	} else if (isset($_POST['act']) && $_POST['act']=="add_state_del" && $_POST['sdid']	!='') {
		$did						  			= $objCommon->esc(trim($_POST['sdid']));
		$objState->delete("state_id=".$did);
		$notfn->add_msg("Selected item has been removed successfully...!",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	/*-------- City Details ---------*/
	else if (isset($_GET['act']) && $_GET['act']=="addcities" && $_POST['country_id']) {
		$_POST['country_id']					= $objCommon->esc(trim($_POST['country_id']));
		$_POST['state_id']						= $objCommon->esc(trim($_POST['state']));
		$_POST['city_name']						= $objCommon->esc(trim($_POST['city_name']));
		$_POST['city_status']					= 1;
		$editId									= $objCommon->esc(trim($_POST['editId'])); 	
		if ($editId) {
			$objCity->update($_POST,"city_id=".$editId);
			$notfn->add_msg("City Details has successfully been Updated...!",3);
		} else {
			$objCity->insert($_POST);
			$notfn->add_msg("City Details has successfully been added...!",3);
		}
		header("location:".$_SERVER['HTTP_REFERER']);
	} else if (isset($_POST['act']) && $_POST['act']=="det_city" && $_POST['citydid']	!='') {
		$did						  			= $objCommon->esc(trim($_POST['citydid']));
		$objCity->delete("city_id=".$did);
		$notfn->add_msg("City has been removed successfully...!",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	/*-------- Manage Category ---------*/
	else if (isset($_GET['act']) && $_GET['act'] == "mng_category" && $_POST['cat_category'] !='') {
		$_POST['par_id']						= $objCommon->esc(trim($_POST['par_id']));
		$_POST['cat_category']					= $objCommon->esc(trim($_POST['cat_category']));
		$_POST['cat_status']					= 1;
		$editId									= $objCommon->esc(trim($_POST['editId'])); 	
		if($editId){
			$objCat->update($_POST,"cat_id=".$editId);
			$notfn->add_msg("Category Details has successfully been Updated...!",3);
		}else{
			$objCat->insert($_POST);
			$notfn->add_msg("Category Details has successfully been added...!",3);
		}
		header("location:index.php?page=add_category");
	} else if (isset($_POST['act']) && $_POST['act']=="add_category_del" && $_POST['cdid']	!='') {
		$did						  =	$objCommon->esc(trim($_POST['cdid']));
		$objCat->delete("cat_id=".$did);
		$notfn->add_msg("Selected  item has been  removed successfully...!",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	/*-------- Manage Sub-Category ---------*/
	else if (isset($_GET['act']) && $_GET['act']=="mng_sub_category" && $_POST['category'] !='') {
		//$_POST['cat_id']					= $objCommon->esc(trim($_POST['category']));
		//$_POST['page_id']					= $objCommon->esc(trim($_POST['page']));
		$categorisList						= $_POST['category'];
		$pagesList							= $_POST['page'];
		$_POST['subcat_name']				= $objCommon->esc(trim($_POST['sub_name']));
		$_POST['subcat_position']			= $objCommon->esc(trim($_POST['sub_position']));
		$_POST['subcat_status']				= 1;
		$editId								= $objCommon->esc(trim($_POST['editId'])); 
		foreach ($categorisList as $cats) {
			$_POST['cat_id']				= $cats;
			//foreach($pagesList as $pages){
				//$_POST['page_id']			=	$pages;
				if ($editId) {
					$objSubcat->update($_POST,"subcat_id =".$editId);
					$notfn->add_msg("Sub-Category Details has successfully been Updated...!",3);
				} else {
					$objSubcat->insert($_POST);
					$notfn->add_msg("Sub-Category Details has successfully been added...!",3);
				}
			//}
		}
		header("location:index.php?page=add_sub_category");
	}
 else if(isset($_POST['act']) && $_POST['act']=="add_sub_category_del" && $_POST['subdid']	!='') {
		$did						  			= $objCommon->esc(trim($_POST['subdid']));
		$objSubcat->delete("subcat_id=".$did);
		$notfn->add_msg("Selected  item has been removed successfully...!",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	
	/*-------- Manage pages/ Menus ---------*/
	
	else if(isset($_GET['act']) && $_GET['act']=="mng_pages" && $_POST['page_name'] !='') {
		$_POST['par_id']						= $objCommon->esc(trim($_POST['par_id']));
		$_POST['page_name']						= $objCommon->esc(trim($_POST['page_name']));
		$_POST['page_position']					= $objCommon->esc(trim($_POST['page_pos']));
		$_POST['page_status']					= 1;
		$editId									= $objCommon->esc(trim($_POST['editId'])); 
		if($editId){
			$pagesObj->update($_POST,"page_id=".$editId);
			$notfn->add_msg("Page/Menu has successfully been Updated...!",3);
		}else{
			$pagesObj->insert($_POST);
			$notfn->add_msg("Page/Menu has successfully been added...!",3);
		}
		header("location:index.php?page=imc_pages");
	}
 else if (isset($_POST['act']) && $_POST['act']=="add_page_del" && $_POST['mdid'] != '') {
		$did			=	$objCommon->esc(trim($_POST['mdid']));
		$pagesObj->delete("page_id=".$did);
		$notfn->add_msg("Selected  item has been  removed successfully...!",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	/*-------- Manage Content Position details ---------*/	
else if (isset($_GET['act']) && $_GET['act']=="mng_cont_pos" && $_POST['pos_name'] !='') {
		
		$_POST['pos_name']						= $objCommon->esc(trim($_POST['pos_name']));
		$_POST['pos_status']					= 1;
		$editId									= $objCommon->esc(trim($_POST['editId'])); 	
				if($editId){
					$objPos->update($_POST,"pos_id=".$editId);
					$notfn->add_msg("Content Position has successfully been Updated...!",3);
				}else{
					$objPos->insert($_POST);
					$notfn->add_msg("Content Position has successfully been added...!",3);
				}
		
		header("location:index.php?page=add_content_position");
	}
 else if(isset($_POST['act']) && $_POST['act']=="add_cont_pos_del" && $_POST['posdid']	!=''){
		$did						  			= $objCommon->esc(trim($_POST['posdid']));
		$objPos->delete("pos_id=".$did);
		$notfn->add_msg("Selected  item has been  removed successfully...!",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	/*-------- Manage main pages ---------*/
 else if(isset($_GET['act']) && $_GET['act']=="manage_pages" && $_POST['page_id'] !=''){
		$allPageId								= $_POST['page_id'];
		$allPosId								= $_POST['pos_id'];
		$allCatId								= $_POST['cat_id'];
		$_POST['mp_heading']					= $objCommon->esc(trim($_POST['mp_heading']));
		$_POST['mp_alias']						= $objCommon->esc(trim($_POST['mp_heading']));
		$_POST['mp_desc']						= $_POST['mp_desc'];
		$_POST['mp_ip']							= $objCommon->get_ip();
		$_POST['mp_status']						= 1;
		$editId									= $objCommon->esc(trim($_POST['page_editId'])); 
		if(!$allPosId){
			$_POST['pos_id']					= 4;
		}else{
			$_POST['pos_id']					= $objCommon->esc(trim($allPosId));
		}
		if($editId){
				$objPages->update($_POST,"mp_id=".$editId);
				$notfn->add_msg("Page details has successfully been Updated...!",3);
				foreach($allPageId as $pageId){
					$_POST['mp_id']				= $editId;
					$_POST['page_id']			= $objCommon->esc(trim($pageId));
						//foreach($allPosId as $posId){
							foreach($allCatId as $catId){
								$_POST['cat_id']= $objCommon->esc(trim($catId));
								$conChk			= $objPageCon->getRow('mp_id ='.$editId.' and page_id ='.$_POST['page_id'].' and cat_id ='.$_POST['cat_id']);		
								if (empty($conChk)) {
									$_POST['mcp_status']	= 1;
									$objPageCon->insert($_POST);
									$notfn->add_msg("Page details has successfully been added...!",3);
								}
								
							}// third for loop end
						
						//}//second for loop end
				
				}//first for loop end
			/*-------delete all the messages which is not in new list start--------*/
			$conAll								= $objPageCon->getAll('mp_id ='.$editId, 'mpc_id');
			
			foreach($conAll as $cnCk){
				if(!in_array($cnCk['page_id'],$allPageId)){ 
					$objPageCon->delete("mp_id=".$editId." and page_id = ".$cnCk['page_id']);	
				}
			}
			foreach($conAll as $cnCk){
				if(!in_array($cnCk['cat_id'],$allCatId)){ 
					$objPageCon->delete("mp_id=".$editId." and cat_id = ".$cnCk['cat_id']);	
				}
			}
			/*-------delete all the messages which is not in new list end--------*/
			
		}//edit if end
		else{
			$objPages->insert($_POST);
			$_POST['mp_id']								= $objPages->insertId();
			$notfn->add_msg("Page details has successfully been added...!",3);
				foreach($allPageId as $pageId){
					$_POST['page_id']					= $objCommon->esc(trim($pageId));
						//foreach($allPosId as $posId){
							foreach($allCatId as $catId){
								$_POST['cat_id']		= $objCommon->esc(trim($catId));
								$_POST['mcp_status']	= 1;		
								$objPageCon->insert($_POST);
							}// third for loop end
						
						//}//second for loop end
				
				}//first for loop end
		}
		
		header("location:".$_SERVER['HTTP_REFERER']);	
		
	}
 else if(isset($_GET['act']) && $_GET['act']=="forumEdit" && $_POST['forum_topic_id']	!=''){
		$topic_id				= $objCommon->esc(trim($_POST['forum_topic_id']));
		$topic					= $objCommon->esc(trim($_POST['forum_head']));
		$topic_desc				= $_POST['forum_dec'];
		$forum_notice			= $_POST['forum_notice'];
		$objForum->updateField(array("topic"=>$topic,"topic_desc"=>$topic_desc, 'topic_notice' => $forum_notice),"topic_id	=".$topic_id);
		$notfn->add_msg("Topic has been edited successfully...!",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}else if(isset($_GET['act']) && $_GET['act']=="forumDiscuss" && $_POST['dis_topic_id']	!=''){
		$dis_id					= $objCommon->esc(trim($_POST['dis_topic_id']));
		$dis_desc				= trim($_POST['dicussion_dec']);
		$objDiscus->updateField(array("discussion"=>$dis_desc),"dis_id =".$dis_id);
		$notfn->add_msg("Discussion has been edited successfully...!",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	/*Manage sub pages details*/
 else if (isset($_GET['act']) && $_GET['act']=="manage_sub_pages" && $_POST['page_id'] !='' && $_POST['cat_id'] != '' && $_POST['subcat_id'] != '') { 
	 		$pageIdArry						= $_POST['page_id'];
		//print_r($pageIdArry); exit;
			$_POST['cat_id']				= $objCommon->esc(trim($_POST['cat_id']));
			$_POST['subcat_id']				= $objCommon->esc(trim($_POST['subcat_id']));
			$_POST['sub_heading']			= $objCommon->esc(trim($_POST['sub_heading']));
			$_POST['sub_information']		= $_POST['sub_information'];
			$_POST['sub_status']			= 1;
			$objSubPage->insert($_POST);	
			$notfn->add_msg("Sub-page details has been added successfully...!",3);
			$lastInsertSubPage				= $objSubPage->insertId();
			if ($lastInsertSubPage) {
			$allSubMenu						= $_POST['sub_menu_head'];
			$allSubDetails					= $_POST['sub_menu_info'];
			$allSubmenuPositions			= $_POST['sub_menu_position'];
				$i							= 0;
				foreach ($pageIdArry as $page) {
					$_POST['sub_id']		= $lastInsertSubPage;
					$_POST['page_id']		= $page;
					$_POST['subcon_status']	= 1;
					$objSubMenuCon->insert($_POST);
				}
			foreach ($allSubMenu as $menus) { 
				$_POST['sub_menu_name']		= $objCommon->esc(trim($menus));
				$_POST['sub_menu_details']	= $allSubDetails[$i];
				$_POST['position']			= $allSubmenuPositions[$i];
				$_POST['sub_menu_status']	= 1;
				$objSubMenu->insert($_POST);
				$i++;
			}
		}
		header("location:index.php?page=manage_inner_pages");
	 } else if(isset($_GET['act']) && $_GET['act']=="manage_sub_sub_pages" && $_POST['subcat_id'] >0) {
	 		$subSubMenu						= $_POST['sub_sub_menu'];
			$subSubDetails					= $_POST['menu_info'];
			$subSubPosition					= $_POST['sub_sub_position'];
			$i								= 0;
				foreach ($subSubMenu as $submenus) {
					$_POST['subcat_id']				  	= $objCommon->esc(trim($_POST['subcat_id']));
					$_POST['sub_menu_id']				= $objCommon->esc(trim($_POST['sub_menu']));
					$_POST['sub_sub_menu']				= $objCommon->esc(trim($submenus));
					$_POST['sub_sub_menu_details']		= $subSubDetails[$i];
					$_POST['position']					= $subSubPosition[$i];
					$_POST['sub_sub_status']			= 1;
					$objSubSubMenu->insert($_POST);
					$i++;
				}
				$notfn->add_msg("Sub-Sub menu added successfully...!",3);
				header("location:index.php?page=manage_sub_menu");
	 } else if (isset($_GET['act']) && $_GET['act']=="manage_sub_sub_pluse" && $_POST['sub_sub_menu'] >0) {
	 		$subPluesMenu			=	$_POST['sub_pluse_menu'];
			$details				=	$_POST['menu_info'];
			$position				= 	$_POST['sub_position'];
				$i					=	0;
				foreach ($subPluesMenu as $submenus) {
					$_POST['sub_sub_id']			= $objCommon->esc(trim($_POST['sub_sub_menu']));
					$_POST['sub_pluse_menu']		= $objCommon->esc(trim($submenus));
					$_POST['sub_pluse_details']		= $details[$i];
					$_POST['position']				= $position[$i];
					$_POST['sub_pluse_status']		= 1;
					$objSubPluse->insert($_POST);
					$i++;
				}
				$notfn->add_msg("Sub menu added successfully...!",3);
				header("location:index.php?page=manage_sub_menu_pluse");
	 } else if(isset($_GET['act']) && $_GET['act']=="inner_sub_pluse" && $_POST['sub_pluse_menu'] >0) {
	 		$subPluesInner			=	$_POST['inner_pluse_menu'];
			$details				=	$_POST['menu_info'];
			$position				= 	$_POST['inner_position'];
				$i					=	0;
				foreach ($subPluesInner	as $submenus) {
					$_POST['sub_pluse_id']			= $objCommon->esc(trim($_POST['sub_pluse_menu']));
					$_POST['sub_inner_menu']		= $objCommon->esc(trim($submenus));
					$_POST['sub_inner_details']		= $details[$i];
					$_POST['position']				= $position[$i];
					$_POST['sub_inner_status']		= 1;
					$objSubInner->insert($_POST);
					$i++;
				}
				$notfn->add_msg("Sub menu added successfully...!",3);
				header("location:index.php?page=manage_subsub_menu_pluse");
	 }else if(isset($_GET['act']) && $_GET['act']=="advertisement" && ($_POST['ad_image'] || $_POST['edit_ad_image'])){
					$allAdPage						= $_POST['page_id'];
					if(count($allAdPage > 0)){
						$_POST['ad_name']			= $objCommon->esc(trim($_POST['ads_name']));
						$_POST['ad_adver_name']		= $objCommon->esc(trim($_POST['adrs_name']));
						$_POST['ad_adver_name']		= $objCommon->esc(trim($_POST['adrs_name']));
						$_POST['pos_id']			= $objCommon->esc(trim($_POST['pos_id']));
						$_POST['ad_publish_from']	= $objCommon->esc(trim($_POST['ad_publish_from']));
						$_POST['ad_publish_to']		= $objCommon->esc(trim($_POST['ad_publish_to']));
						$_POST['ad_hyper_link']		= $objCommon->esc(trim($_POST['ad_hyper_link']));
						$_POST['ad_image']			= $objCommon->esc(trim($_POST['ad_image']));
						$_POST['ad_status']			= 1;
						$adEdit						= $objCommon->esc(trim($_POST['ads_edit']));
						foreach($allAdPage as $adPages){
							$_POST['page_id']		= $objCommon->esc(trim($adPages));
							$maxPosSql				= "select MAX(ad_position) as max_pos from ad_management where page_id = '".$_POST['page_id']."' and pos_id = '".$_POST['pos_id']."'";
							$maxPosition			= $objAds->getRowSql($maxPosSql);
							$posNo					= $maxPosition['max_pos'];
							$newposNo				= $posNo+1;
							$_POST['ad_position']	= $newposNo;
							if($adEdit && $adEdit > 0){
								if($_POST['edit_ad_image']){
								$_POST['ad_image']	= $objCommon->esc(trim($_POST['edit_ad_image']));
								}
							$_POST['ad_position']   = $objCommon->esc(trim($_POST['adPos']));
								$objAds->update($_POST,"ad_id=".$adEdit);
								$notfn->add_msg("Advertisement Edited Successfully...!",3);
							}else{
								$objAds->insert($_POST);
								$notfn->add_msg("Advertisement Added Successfully...!",3);
							}
						}
					}
					
					header("location:".$_SERVER['HTTP_REFERER']);
	 }
	 //ajax ads position change
	else if ($_POST['crt_pos'] && $_POST['new_pos'] && $_POST['ad_position'] && $_POST['pageId']) { 
		 	$crtPos			= $objCommon->esc($_POST['crt_pos']);
			$newPos			= $objCommon->esc($_POST['new_pos']);
			$ad_position	= $objCommon->esc($_POST['ad_position']);
			$pageId			= $objCommon->esc($_POST['pageId']);
			/*select all ads for change order*/
			$allAds			= $objAds->getAll('page_id = "'.$pageId.'" and pos_id = "'.$ad_position.'"', 'ad_position');
			
			$idArray		= array(); // array for order change
			foreach($allAds	as	$eachAds){
				$idArray[]	= $eachAds['ad_id'];		
			}
			$getCrtId		= $objAds->getRow('page_id = "'.$pageId.'" and pos_id = "'.$ad_position.'" and ad_position = "'.$crtPos.'"');
			$crtId			= $getCrtId['ad_id']; // id of ads for change pos
			$newPos			= $newPos-1; // new array pos i.e 0,1,2,...
				if(($key	= array_search($crtId,$idArray)) !== false){
					unset($idArray[$key]);
				}
			array_insert($idArray,$crtId,$newPos);
					$position	= 1;
					
				foreach($idArray as $id){
					$updateNew	= $objAds->updateField(array("ad_position"=>$position),"ad_id=".$id); 
					$position++;
				}
				echo 1;
	} else if (isset($_GET['act']) && $_GET['act'] == "about_us") {
		$_POST['about_head']	= $objCommon->esc($_POST['about_heading']);
		$_POST['about_us']		= $_POST['about_desc'];
		$_POST['about_date']	= $currentTime;
		$_POST['about_status']	= 1;
		$aboutEdit				= $objCommon->esc($_POST['about_editId']);
		if($aboutEdit){
			$objAbout->update($_POST,'about_id = "'.$aboutEdit.'"');
			$notfn->add_msg("About Us has been updated successfully...!",3);
		}else{
			$objAbout->insert($_POST);
			$notfn->add_msg("About Us has been added successfully...!",3);
		}
		header("location:".$_SERVER['HTTP_REFERER']);
	} else if (isset($_GET['act']) && $_GET['act'] == "mng_promotionads" && $_POST['p_cat_id']) {  
		$_POST['p_cat_id']		= $objCommon->esc($_POST['p_cat_id']);
		$_POST['p_ads_link']	= $objCommon->esc($_POST['p_ads_link']);
		$_POST['p_ads_status']	= 1;
		$promoEdit				= $objCommon->esc($_POST['editId']); 
			if ($promoEdit) {
				$objpromotion->update($_POST,'p_ads_id = "'.$promoEdit.'"');
				$notfn->add_msg("Promotional ads has been edited successfully...!",3);
			} else {
				$objpromotion->insert($_POST);
				$notfn->add_msg("Promotional ads has been added successfully...!",3);
			}
			header("location:".$_SERVER['HTTP_REFERER']);
	} else if ($_POST['act'] == "promoadvs_del" && $_POST['adid']) { 
		$pAdvs					= $objCommon->esc($_POST['adid']);
		if ($objpromotion->delete("p_ads_id=".$pAdvs)) {
			echo "Record has been deleted";
		} else {
			echo "Oops ! something went wrong";
		}
		//$notfn->add_msg("Link has been removed successfully...!",3);
		//header("location:".$_SERVER['HTTP_REFERER']);		
	} else if (isset($_GET['act']) && $_GET['act'] == "page-menu-connection" && $_POST['page_id']) {  
		 $pageId				= $objCommon->esc($_POST['page_id']);
		 $menuIds				= $_POST['sub_id'];
		 $objSubMenuCon->delete('page_id = '.$pageId);
		if (!empty($menuIds)) {
		 foreach($menuIds as $sub_id) {
			 $_POST['page_id']			= $pageId;
			 $_POST['sub_id']			= $sub_id;
			 $_POST['subcon_status']	= 1;
			 $objSubMenuCon->insert($_POST);
		 }
		}
		 $notfn->add_msg("Menus has been updated successfully!",3);
		 header("location:".$_SERVER['HTTP_REFERER']);
	} else if(isset($_GET['act']) && $_GET['act'] == "manage-message-alert") { #to handle message and alert which is need for user notice
			$_POST['message_code']				= $objCommon->esc($_POST['message_type']);
			$_POST['mesage']					= $objCommon->esc($_POST['message']);
			$editId 							= $_POST['edit_id'];
			if ($editId){
				$objMessage->update($_POST, 'message_id ='.$editId);
				$notfn->add_msg("Message has been updated successfully",3);
			} else {
			if ($objMessage->insert($_POST)) {
				$notfn->add_msg("Message has been added successfully",3);
			} else {
				$notfn->add_msg("Oops ! something went wrong!",4);
			}
			}
			header("location:".$_SERVER['HTTP_REFERER']);
	}
	else{
		$notfn->add_msg("Oops ! something went wrong!",4);
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	