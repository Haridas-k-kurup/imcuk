<?php
include_once(DIR_ROOT."admin/includes/header.php");
include_once(DIR_ROOT."class/manage_category.php");
include_once(DIR_ROOT."class/manage_pages.php");
include_once(DIR_ROOT."class/imc_pages.php");
include_once(DIR_ROOT."class/manage_topic_position.php");
include_once(DIR_ROOT."class/manage_sub_category.php");
include_once(DIR_ROOT."class/manage_sub_pages.php");
include_once(DIR_ROOT."class/manage_sub_menu.php");
include_once(DIR_ROOT."class/manage_sub_sub_menu.php");

$objCat					=	new manage_category();
$objPage				=	new manage_pages();
$objImc					=	new	imc_pages();
$objTopic				=	new	manage_topic_position();
$objSubcat				=	new manage_sub_category();
$objSubPage				=	new manage_sub_pages();
$objSubMenu				=	new manage_sub_menu();
$objSubSub				=	new manage_sub_sub_menu();
$allCat					=	$objCat->getAll();
$allSubCat				=	$objSubcat->getAll("subcat_status=1");
$allImc					=	$objImc->getAll("page_status=1");
$allTopic				=	$objTopic->getAll("pos_status=1");
if($_GET['eid']){
	$editId				=   $objCommon->esc($_GET['eid']);
	$subPageDtail		=   $objSubPage->getRow('topic_id ='.$editId,'topic_id');
}
/*get plab(Mobile) menu*/
  	$subMenuSql			=	"select subCat.subcat_name, subPages.sub_id, subPages.sub_heading, subPages.sub_information from manage_sub_pages as subPages left join manage_sub_category as subCat on subPages.subcat_id = subCat.subcat_id where subPages.sub_status = '1' order by subPages.sub_id desc";
	$subCats			=	$objSubMenu->listQuery($subMenuSql);
?>
<script type="text/javascript" src="<?php echo SITE_ROOT; ?>ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo SITE_ROOT; ?>ckeditor/ckfinder.js"></script>
<link rel="stylesheet" type="text/css" href="css/file_tree.css" media="screen">
<div class="wrapper row-offcanvas row-offcanvas-left"> 
  <!-- Left side column. contains the logo and sidebar -->
  <?php include_once('includes/sidemenubar.php'); ?>
  
  <!-- Right side column. Contains the navbar and content of the page -->
  <aside class="right-side"> 
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> Manage I M C Inner pages <small>International Medical Connection</small> </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Manage Inner Pages</li>
        <li class="active">Add Inner Pages & Menu</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row"> 
        <!-- left column -->
        <div class="col-md-12"> 
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Add Inner Topics <small> ( Inner pages are the sub menus of main pages like Mobile menu. Here you can create Main manu and its sub menu )</small></h3>
              <!-- <img  src="img/submenu_model.png" class="img-responsive" />--> 
            </div>
            <!-- /.box-header --> 
            <!-- form start -->
            <?php 
				echo $notfn->msg();
			?>
          </div>
          <!-- /.box --> 
          <!-- Form Element sizes -->
          <div class="row">
            <div class="col-md-3">
            <div class="box">
            	<div class="box-header">
                    <h3 class="box-title">Mobile Menu Controls</h3>
                 </div>
              <ol class="tree">
              <?php
			   $i					=	1;
			   $j					=	1;
			   $k					=	1;
			   $catFlag				=	1; // flag using for identify which ctatagory type like plab for ajax
			   $SubMenuFlag			=	2; // flag using for identify which Submenu type for ajax
			   $SubSubMenuFlag		=	3; // flag using for identify which sub-submenu type for ajax
			   foreach($subCats as $allCats){ 
			   		$subMenuId		=  $allCats['sub_id'];
			   ?>
                <li>
                  <a href="javascript:;" onclick="return editCategory(<?php echo $subMenuId;?>, <?php echo $catFlag; ?>);"><label for="folder<?php echo $i; ?>"><?php echo $allCats['subcat_name']; ?></label></a>
                  <input type="checkbox" id="folder<?php echo $i; ?>" />
                  <ol>
                  <?php 
				  $allSubMenus	=	$objSubMenu->getAll('sub_id = "'.$subMenuId.'"', 'sub_menu_id desc'); 
				  foreach($allSubMenus as $allsub){ 
				  ?>
                  <?php $allSubSubMenu	=	$objSubSub->getAll('sub_menu_id = '.$allsub['sub_menu_id'],'sub_sub_id desc') ?>
                    <li>
                      <a href="javascript:;" onclick="return editCategory(<?php echo $allsub['sub_menu_id'];?>, <?php echo $SubMenuFlag; ?>);"><label for="subfolder<?php echo $j; ?>"><?php echo $allsub['sub_menu_name']; ?></label></a>
                      <input type="checkbox" id="subfolder<?php echo $j; ?>" />
                      <ol>
                      <?php foreach($allSubSubMenu as $keys=>$subSubMenu){ ?>
                        <li>
                          <a href="javascript:;" onclick="return editCategory(<?php echo $subSubMenu['sub_sub_id'];?>, <?php echo $SubSubMenuFlag; ?>);"><label for="subsubfolder<?php echo $k; ?>"><?php echo $subSubMenu['sub_sub_menu']; ?></label></a>
                          <input type="checkbox" id="subsubfolder<?php echo $k; ?>" />
                        </li>
                        <?php $k++; } ?>
                      </ol>
                    </li>
                    <?php $j++; } ?>
                  </ol>
                </li>
                <?php $i++; } ?>
              <!--  <li>
                  <label for="folder4">Folder 4</label>
                  <input type="checkbox" id="folder4" />
                  <ol>
                    <li>
                      <label for="subfolder4">Subfolder 1</label>
                      <input type="checkbox" id="subfolder4" />
                    </li>
                  </ol>
                </li>
                <li>
                  <label for="folder5">Folder 5</label>
                  <input type="checkbox" id="folder5" />
                  <ol>
                    <li>
                      <label for="subfolder5">Subfolder 1</label>
                      <input type="checkbox" id="subfolder5" />
                    </li>
                  </ol>
                </li>-->
              </ol>
              </div>
            </div>
            <div class="col-md-9">
            <div class="box">
            	<div class="box box-solid">
                	<div class="col-md-6 action-btn">
                    </div>
                    <div class="col-md-6 action-btn">
                    	<div class="row">
                        	<div class="col-md-6">
                            	<button class="btn bg-maroon btn-sm pull-right">Create New</button>
                    	    </div>
                        	<div class="col-md-6" id="action-btn-area" style="display:none;">
                            	 <button class="btn btn-info btn-sm" onclick="return updateSubmenu(1);">Update</button>
                       			 <button class="btn btn-danger btn-sm" onclick="return updateSubmenu(2);">Delete</button>
                       			 <button class="btn btn-success btn-sm" onclick="return updateSubmenu(3);">Active</button>
                        	</div>
                        </div>
                    </div>
                	
                </div>
                	<img src="../images/preloader-01.gif" class="img-preload" />
            	<form action="<?php echo SITE_ROOT?>admin/action.php?act=manage_pages" method="post" role="form" enctype="multipart/form-data" id="sub-menu-edit-field">
                
                                    <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" type="button">Menu / Heading</button>
                                        </div><!-- /btn-group -->
                                        	<input type="text" class="form-control" name="new_head" required value="">
                                    </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <textarea name="newdd_desc" id="new_desc" class="form-control ckeditor" ></textarea>
                                        </div>
                                        
                                         </div>
                                    </div>
                                    </div><!-- /.box-body -->

                                    
                                </form>
                  </div>
            </div>
          </div>
          
          <!-- Input addon --> 
          <!-- /.box --> 
          
        </div>
        <!--/.col (left) --> 
        <!-- right column --> 
        <!--/.col (right) --> 
      </div>
      <!-- /.row --> 
    </section>
    <!-- /.content --> 
  </aside>
  <!-- /.right-side --> 
</div>
<!-- ./wrapper --> 
<!-- jQuery 2.0.2 --> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script> 
<!-- Bootstrap --> 
<script src="js/bootstrap.min.js" type="text/javascript"></script> 
<!-- AdminLTE App --> 
<script src="js/AdminLTE/app.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
/*Menu creation for sub menu start*/

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
function updateSubmenu(actionFlag){
	var id			=	$('#menu_id').val();
	var flag		=	$('#menu_flag').val();
	var	heading		=	$('#new_head').val();
	var editor_data = CKEDITOR.instances.new_desc.getData();
		if(actionFlag == 1){
			var	actDialog	=	"Are you sure you want to update this item ! ";
		}else if(actionFlag == 2){
			var	actDialog	=	"Are you sure you want to delete this item ! ";
		}else{
			var	actDialog	=	"Are you sure you want to change status this item ! ";
		}
	if(id && flag){	
			var dataString 	= 	'id='+id+'&flag='+flag+'&actionFlag='+actionFlag+'&heading='+heading+'&desc='+editor_data; 
		  //alert(dataString);
		  if(confirm(actDialog)){ 
			$.ajax({
			type: "POST",
			url: "ajax_action.php",
			data: dataString,
			cache: false,
			async:false,
			success: function(data){ 
			$('.img-preload').fadeIn(1000);
			setTimeout(function(){
				$('.img-preload').fadeIn(500);
			    editCategory(id,flag);
				
				},1000);
					//alert(data)
					//$('#sub-menu-edit-field').html(data);
				}
			});
		  }
	}
}

/*Menu creation for sub menu end*/
</script>
</body></html>
