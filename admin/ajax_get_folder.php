<?php 
include_once('../includes/site_root.php');
include_once(DIR_ROOT."class/imc_pages.php");
include_once(DIR_ROOT."class/manage_sub_pages.php");
include_once(DIR_ROOT."class/manage_sub_menu.php");
include_once(DIR_ROOT."class/manage_sub_sub_menu.php");
$objSubPage				=	new manage_sub_pages();
$objSubMenu				=	new manage_sub_menu();
$objSubSub				=	new manage_sub_sub_menu();
$objImc					=	new	imc_pages();
$allImc					=	$objImc->getAll();
$cat_id					=	$_POST['catId'];
if($_POST['searchfid']){
$menuName				=	$_POST['searchfid'];
}
foreach($allImc as $pages){
/*get all menu*/
if($menuName){
		$subMenuSql		=	"select subCat.subcat_name, subPages.sub_id, subPages.sub_heading, subPages.sub_information from manage_sub_pages as subPages left join manage_sub_category as subCat on subPages.subcat_id = subCat.subcat_id left join submenu_page_connection as subcon on subPages.sub_id = subcon.sub_id  where subcon.page_id = '".$pages['page_id']."' and subCat.subcat_name like '%".$menuName."%' and  subPages.sub_status = '1' order by subCat.subcat_position asc";
	}
	else{
		if($cat_id){ 
	
  	$subMenuSql			=	"select subCat.subcat_name, subPages.sub_id, subPages.sub_heading, subPages.sub_information from manage_sub_pages as subPages left join manage_sub_category as subCat on subPages.subcat_id = subCat.subcat_id left join submenu_page_connection as subcon on subPages.sub_id = subcon.sub_id where subcon.page_id = '".$pages['page_id']."' and subPages.cat_id = '".$cat_id."' and  subPages.sub_status = '1'  order by  subCat.subcat_position asc";
	
	}else{
		$subMenuSql		=	"select subCat.subcat_name, subPages.sub_id, subPages.sub_heading, subPages.sub_information from manage_sub_pages as subPages left join manage_sub_category as subCat on subPages.subcat_id = subCat.subcat_id left join submenu_page_connection as subcon on subPages.sub_id = subcon.sub_id where subcon.page_id = '".$pages['page_id']."' and subPages.cat_id = '7' and subPages.sub_status = '1'  order by  subCat.subcat_position asc";
	}
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
			   foreach ($subCats as $allCats) { 
			   		$subMenuId		=  $allCats['sub_id'];
			   ?>
                <li>
                  <a href="javascript:;" onclick="return editCategory(<?php echo $subMenuId;?>, <?php echo $catFlag; ?>);"><label for="folder<?php echo $subMenuId; ?>"><?php echo $allCats['subcat_name']; ?></label></a>
                  <input type="checkbox" id="folder<?php echo $subMenuId; ?>" />
                  <ol>
                  <?php 
				  $allSubMenus	=	$objSubMenu->getAll('sub_id = "'.$subMenuId.'"', 'position asc'); 
				  foreach($allSubMenus as $allsub){ 
				  ?>
                  <?php $allSubSubMenu	=	$objSubSub->getAll('sub_menu_id = '.$allsub['sub_menu_id'],'position asc') ?>
                    <li>
                      <a href="javascript:;" onclick="return editCategory(<?php echo $allsub['sub_menu_id'];?>, <?php echo $SubMenuFlag; ?>);"><label for="subfolder<?php echo $allsub['sub_menu_id']; ?>"><?php echo $allsub['sub_menu_name']; ?></label></a>
                      <input type="checkbox" id="subfolder<?php echo $allsub['sub_menu_id']; ?>" />
                      <ol>
                      <?php foreach($allSubSubMenu as $keys=>$subSubMenu){ ?>
                        <li>
                          <a href="javascript:;" onclick="return editCategory(<?php echo $subSubMenu['sub_sub_id'];?>, <?php echo $SubSubMenuFlag; ?>);"><label for="subsubfolder<?php echo $subSubMenu['sub_sub_id']; ?>"><?php echo $subSubMenu['sub_sub_menu']; ?></label></a>
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
			  function editCategory(id,flag){ // function for pass value and flag for fetch menu & details
	
				var dataString 	= 	'id='+id+'&flag='+flag;
			//alert("dataString=="+dataString);
				$.ajax({
				type: "POST",
				url: "ajax_sub_menu_details_edit.php",
				data: dataString,
				cache: false,
				async:false,
				dataType:"html",
				success: function(data){
					$('.img-preload').fadeIn(1000);
					setTimeout(function(){
					//alert(data)
					$('.img-preload').fadeOut(500);
					if(typeof(CKEDITOR.instances.new_desc)=="object")
						{
						CKEDITOR.instances.new_desc.destroy();
						}
					$('#sub-menu-edit-field').html(data);
					$('#action-btn-area').fadeIn(1000);
					var editor = CKEDITOR.replace( 'new_desc' );
					},1000);
				}
				});
			}
			  </script>