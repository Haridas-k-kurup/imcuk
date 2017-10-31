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
if ($_POST['searchfid']) { 
$menuName				=	$_POST['searchfid'];
}
//foreach($allImc as $pages){ 
/*get all menu*/
	if ($menuName) {
		$subMenuSql		=	"select distinct subsub.sub_sub_id, subsub.sub_sub_menu from manage_sub_sub_pluse as subpluse left join manage_sub_sub_menu as subsub on subpluse.sub_sub_id = subsub.sub_sub_id left join manage_sub_menu as submenu on subsub.sub_menu_id = submenu.sub_menu_id left join manage_sub_pages as subpages on submenu.sub_id = subpages.sub_id where subsub.sub_sub_menu like '%".$menuName."%' order by subsub.position asc"; 
		} else {
			
	if ($cat_id) { 
   	$subMenuSql			=	"select distinct subsub.sub_sub_id, subsub.sub_sub_menu from manage_sub_sub_pluse as subpluse left join manage_sub_sub_menu as subsub on subpluse.sub_sub_id = subsub.sub_sub_id left join manage_sub_menu as submenu on subsub.sub_menu_id = submenu.sub_menu_id left join manage_sub_pages as subpages on submenu.sub_id = subpages.sub_id where subpages.cat_id  = '".$cat_id."' order by subsub.position asc";
	
	} else {
		$subMenuSql		=	"select distinct subsub.sub_sub_id, subsub.sub_sub_menu from manage_sub_sub_pluse as subpluse left join manage_sub_sub_menu as subsub on subpluse.sub_sub_id = subsub.sub_sub_id left join manage_sub_menu as submenu on subsub.sub_menu_id = submenu.sub_menu_id left join manage_sub_pages as subpages on submenu.sub_id = subpages.sub_id where subpages.cat_id  = '8' order by subsub.position asc";
	}
}
	$subCats			=	$objSubPluse->listQuery($subMenuSql);
	if(count($subCats) > 0){
 ?>
<div class="box">
            	<div class="box-header">
                    <h3 class="box-title"><?php //echo $pages['page_name']; ?> Manage Menus</h3>
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
                  <a href="javascript:;" onclick="return editCategory(<?php echo $subMenuId;?>, <?php echo $catFlag; ?>);"><label for="folder<?php echo $subMenuId; ?>"><?php echo $allCats['sub_sub_menu']; ?></label></a>
                  <input type="checkbox" id="folder<?php echo $subMenuId; ?>" />
                  <ol>
                  <?php 
				  $allSubMenus	=	$objSubPluse->getAll('sub_sub_id  = "'.$subMenuId.'"', 'position asc'); 
				  foreach($allSubMenus as $allsub){ 
				  ?>
                  <?php $allSubSubMenu	=	$objSubInner->getAll('sub_pluse_id = '.$allsub['sub_pluse_id'],'position asc'); ?>
                    <li>
                      <a href="javascript:;" onclick="return editCategory(<?php echo $allsub['sub_pluse_id'];?>, <?php echo $SubMenuFlag; ?>);"><label for="subfolder<?php echo $allsub['sub_pluse_id']; ?>"><?php echo $allsub['sub_pluse_menu']; ?></label></a>
                      <input type="checkbox" id="subfolder<?php echo $allsub['sub_pluse_id']; ?>" />
                      <ol>
                      <?php foreach($allSubSubMenu as $keys=>$subSubMenu){ ?>
                        <li>
                          <a href="javascript:;" onclick="return editCategory(<?php echo $subSubMenu['sub_inner_id'];?>, <?php echo $SubSubMenuFlag; ?>);"><label for="subsubfolder<?php echo $subSubMenu['sub_inner_id']; ?>"><?php echo $subSubMenu['sub_inner_menu']; ?></label></a>
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
			  function editCategory(id,flag){ // function for pass value and flag for fetch menu & details
	
				var dataString 	= 	'id='+id+'&flag='+flag;
			//alert("dataString=="+dataString);
				$.ajax({
				type: "POST",
				url: "ajax_get_submenu_details.php",
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