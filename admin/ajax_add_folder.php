<?php 
session_start();
include_once('../includes/site_root.php');
include_once(DIR_ROOT."class/imc_pages.php");
include_once(DIR_ROOT."class/manage_sub_pages.php");
include_once(DIR_ROOT."class/manage_sub_menu.php");
include_once(DIR_ROOT."class/manage_sub_sub_menu.php");
include_once(DIR_ROOT."admin/includes/action_functions.php");
$notfn					=	new notification_types();
$objSubPage				=	new manage_sub_pages();
$objSubMenu				=	new manage_sub_menu();
$objSubSub				=	new manage_sub_sub_menu();
$objImc					=	new	imc_pages();
$allImc					=	$objImc->getAll();
$cat_id					=	$_POST['catId'];
echo $notfn->msg(); // print action msg
foreach($allImc as $pages){
/*get all menu*/
	if($cat_id){ 
	
  	$subMenuSql			=	"select subCat.subcat_name, subPages.sub_id, subPages.subcat_id, subPages.sub_heading, subPages.sub_information from manage_sub_pages as subPages left join manage_sub_category as subCat on subPages.subcat_id = subCat.subcat_id left join submenu_page_connection as subcon on subPages.sub_id = subcon.sub_id  where subcon.page_id = '".$pages['page_id']."' and subPages.cat_id = '".$cat_id."' and  subPages.sub_status = '1'  order by subCat.subcat_position asc";
	
	}else{
		$subMenuSql		=	"select subCat.subcat_name, subPages.sub_id, subPages.subcat_id, subPages.sub_heading, subPages.sub_information from manage_sub_pages as subPages left join manage_sub_category as subCat on subPages.subcat_id = subCat.subcat_id left join submenu_page_connection as subcon on subPages.sub_id = subcon.sub_id where subcon.page_id = '".$pages['page_id']."' and subPages.cat_id = '7' and subPages.sub_status = '1'  order by subCat.subcat_position asc";
	}
	$subCats			=	$objSubMenu->listQuery($subMenuSql);
	if(count($subCats) > 0){
 ?>
<div class="box">
            	<div class="box-header">
                    <h3 class="box-title"><?php echo $pages['page_name']; ?> Menu Controls</h3>
                 </div>
              <ol class="tree">
              <?php
			   $catFlag				=	1; // flag using for identify which ctatagory type like plab for ajax
			   $SubMenuFlag			=	2; // flag using for identify which Submenu type for ajax
			   $SubSubMenuFlag		=	3; // flag using for identify which sub-submenu type for ajax
			   foreach($subCats as $allCats){ 
			   		$subMenuId		=  $allCats['sub_id'];
			   ?>
                <li>
                  <a href="javascript:;" onclick="return getSubId(<?php echo $subMenuId;?>);"><label for="folder<?php echo $subMenuId; ?>"><?php echo $allCats['subcat_name']; ?></label></a>
                  <input type="checkbox" id="folder<?php echo $subMenuId; ?>" />
                  <ol>
                  <?php 
				  $allSubMenus	=	$objSubMenu->getAll('sub_id = "'.$subMenuId.'"', 'sub_menu_id desc'); 
				  foreach($allSubMenus as $allsub){ 
				  ?>
                  <?php $allSubSubMenu	=	$objSubSub->getAll('sub_menu_id = '.$allsub['sub_menu_id'],'sub_sub_id desc'); ?>
                    <li>
                      <a href="javascript:;" onclick="return getSubSubId(<?php echo $allCats['subcat_id'];?>, <?php echo $allsub['sub_menu_id']; ?>);"><label for="subfolder<?php echo $allsub['sub_menu_id']; ?>"><?php echo $allsub['sub_menu_name']; ?></label></a>
                      <input type="checkbox" id="subfolder<?php echo $allsub['sub_menu_id']; ?>" />
                      <ol>
                      <?php foreach($allSubSubMenu as $keys=>$subSubMenu){ ?>
                        <li>
                          <label for="subsubfolder<?php echo $subSubMenu['sub_sub_id']; ?>"><?php echo $subSubMenu['sub_sub_menu']; ?></label>
                          <input type="checkbox" id="subsubfolder<?php echo $subSubMenu['sub_sub_id']; ?>" />
                        </li>
                        <?php } ?>
                      </ol>
                    </li>
                    <?php } ?>
                  </ol>
                </li>
                <?php  } ?>
              </ol>
              </div>
              <?php } } ?>
              <script type="text/javascript" language="javascript">
			  function getSubId(id){ // function for pass value to sub-id for create new sub-menu
				  if(id){
					$('#sub-id').val(id);
					$('#subsub-id').val("");
					$('#subsbub-btn-area').hide();
					$('#action-btn-area').fadeIn(1000);
					$('#menu_head').removeAttr("disabled");
					
				  }else{
					  $('#sub-id').val("");
					  $('#action-btn-area').fadeOut(1000);
				  }
			}
			 function getSubSubId(cat,id){  // function for pass value to sub-id for create new subsub-menu
				if(id){
					$('#cat-id').val(cat);
					$('#subsub-id').val(id);
					$('#sub-id').val("");
					$('#action-btn-area').hide();
					$('#subsbub-btn-area').fadeIn(1000);
					$('#menu_head').removeAttr("disabled");
				  }else{
					  $('#cat-id').val("");
					  $('#sub-id').val("");
					  $('#subsub-id').val("");
					  $('#subsbub-btn-area').fadeOut(1000);
				  }
			 }
			  </script>