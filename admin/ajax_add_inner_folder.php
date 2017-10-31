<?php 
include_once('../includes/site_root.php');
include_once(DIR_ROOT."class/imc_pages.php");
include_once(DIR_ROOT."class/manage_sub_sub_pluse.php");
include_once(DIR_ROOT."class/manage_sub_sub_inner.php");
$objSubPluse			=	new manage_sub_sub_pluse();
$objSubInner			=	new manage_sub_sub_inner();
$objImc					=	new	imc_pages();
$allImc					=	$objImc->getAll();
$cat_id					=	$_POST['catId'];
//foreach($allImc as $pages){
/*get all menu*/
	if($cat_id){ 
	
  	$subMenuSql		=	"select distinct subsub.sub_sub_id, subsub.sub_sub_menu from manage_sub_sub_pluse as subpluse left join manage_sub_sub_menu as subsub on subpluse.sub_sub_id = subsub.sub_sub_id left join manage_sub_menu as submenu on subsub.sub_menu_id = submenu.sub_menu_id left join manage_sub_pages as subpages on submenu.sub_id = subpages.sub_id where  subpages.cat_id  = '".$cat_id."' order by subpluse.sub_pluse_id desc";
	
	}else{
		$subMenuSql	=	"select distinct subsub.sub_sub_id, subsub.sub_sub_menu from manage_sub_sub_pluse as subpluse left join manage_sub_sub_menu as subsub on subpluse.sub_sub_id = subsub.sub_sub_id left join manage_sub_menu as submenu on subsub.sub_menu_id = submenu.sub_menu_id left join manage_sub_pages as subpages on submenu.sub_id = subpages.sub_id where subpages.cat_id  = '8' order by subpluse.sub_pluse_id desc";
	}
	$subCats			=	$objSubPluse->listQuery($subMenuSql);
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
			   		$subMenuId		=  $allCats['sub_sub_id'];
			   ?>
                <li>
                  <a href="javascript:;" onclick="return getSubId(<?php echo $subMenuId;?>);"><label for="folder<?php echo $subMenuId; ?>"><?php echo $allCats['sub_sub_menu']; ?></label></a>
                  <input type="checkbox" id="folder<?php echo $subMenuId; ?>" />
                  <ol>
                  <?php 
				  $allSubMenus	=	$objSubPluse->getAll('sub_sub_id  = "'.$subMenuId.'"', 'sub_pluse_id desc');  
				  foreach($allSubMenus as $allsub){ 
				  ?>
                  <?php $allSubSubMenu	=	$objSubInner->getAll('sub_pluse_id = '.$allsub['sub_pluse_id'],'sub_inner_id desc'); ?>
                    <li>
                      <a href="javascript:;" onclick="return getSubSubId(<?php echo $allsub['sub_pluse_id']; ?>);"><label for="subfolder<?php echo $allsub['sub_pluse_id']; ?>"><?php echo $allsub['sub_pluse_menu']; ?></label></a>
                      <input type="checkbox" id="subfolder<?php echo $allsub['sub_pluse_id']; ?>" />
                      <ol>
                      <?php foreach($allSubSubMenu as $keys=>$subSubMenu){ ?>
                        <li>
                          <label for="subsubfolder<?php echo $subSubMenu['sub_inner_id']; ?>"><?php echo $subSubMenu['sub_inner_menu']; ?></label>
                          <input type="checkbox" id="subsubfolder<?php echo $subSubMenu['sub_inner_id']; ?>" />
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
              <?php } //} ?>
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
			 function getSubSubId(id){  // function for pass value to sub-id for create new subsub-menu
				if(id){
					//$('#cat-id').val(cat);
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