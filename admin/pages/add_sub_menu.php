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
/*get plab(Mobile) menu*/
  /*	$subMenuSql			=	"select subCat.subcat_name, subPages.sub_id, subPages.sub_heading, subPages.sub_information from manage_sub_pages as subPages left join manage_sub_category as subCat on subPages.subcat_id = subCat.subcat_id where subPages.sub_status = '1' order by subPages.sub_id desc";
	$subCats			=	$objSubMenu->listQuery($subMenuSql);*/
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
        <li class="active ">List Inner Pages & Menu</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row"> 
        <!-- left column -->
        <div class="col-md-12"> 
          <!-- general form elements -->
          <div class="box box-primary ">
            <div class="box-header alert-success">
              <h3 class="box-title ">Add new sub menu for existing menu <small> ( click on Menu or Sub-Menu and add new menu under selected menu )</small></h3>
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
            <div class="form-group">
                <label>Select Category</label>
                <select class="form-control alert-danger" id="menu-cat">
                    <option value="7">Mobile Menu</option>
                    <option value="8">Top Menu ( Left to slider)</option>
                    <option value="9">Middle Menu (Below Slider)</option>
                </select>
			</div>
            <div id="submenu-folder">
            	<!-- sub menu folder start -->
                <!-- sub menu folder end -->
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
                            	
                    	    </div>
                        	<div class="col-md-6" id="action-btn-area" style="display:none;">
                       			 <button class="btn btn-success btn-sm" onclick="return addSubmenu();">Add Sub-Menu</button>
                        	</div>
                            <div class="col-md-6" id="subsbub-btn-area" style="display:none;">
                       			 <button class="btn btn-success btn-sm" onclick="return addSubSubmenu();">Add Sub-Sub Menu</button>
                        	</div>
                        </div>
                    </div>
                	
                </div>
                	<img src="../images/preloader-01.gif" class="img-preload" />
            	<form action="" method="post" role="form" enctype="multipart/form-data" id="sub-menu-edit-field">
                
                                    <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" type="button">Menu Name</button>
                                        </div><!-- /btn-group -->
                                        	<input type="hidden" id="sub-id" value="">
                                            <input type="hidden" id="subsub-id" value="">
                                            <input type="hidden" id="cat-id" value="">
                                        	<input type="text" class="form-control" id="menu_head" name="menu_head" required value="" disabled="disabled" placeholder="Click on your main manu and fill new sub-menu here...">
                                    </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <textarea name="menu_desc" id="menu_desc" class="form-control ckeditor" ></textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" type="button">Menu Position</button>
                                        </div><!-- /btn-group -->
                                        	<input type="number" class="form-control" id="menu_position" name="menu_position" placeholder="Enter menu position">
                                    </div>
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
<script src="js/AdminLTE/app-modified.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
$('#menu-cat').on('change', function(){// function for change menu list
				  	var catId		=	$(this).val();
					getFolders(catId);
					
				  });
/*Menu creation for sub menu start*/

function getFolders(catId){ /*this function will call while page load from app.js*/
	var dataString 	= 	'catId='+catId
		$.ajax({
				type: "POST",
				url: "ajax_add_folder.php",
				data: dataString,
				cache: false,
				async:false,
				dataType:"html",
				success: function(data){
						$('#submenu-folder').html(data);
					}
				});
	}
function addSubmenu(){ // for add sub menu for main menu
		var catId		=	$('#menu-cat').val(); // this value is used for stay back on same folder details
		var sub_id		=	$('#sub-id').val();
		var menu_name	=	$('#menu_head').val(); 
		var menu_desc	=	CKEDITOR.instances.menu_desc.getData();
		var new_pos		=   $('#menu_position').val();
		var dataString	=	'subId='+sub_id+'&menu_name='+menu_name+'&menu_desc='+menu_desc+'&act=addsub'+'&menu_pos='+new_pos;
		if(sub_id && menu_name){
			$('.img-preload').fadeIn(1000);
		$.ajax({
			type: "POST",
			url: "ajax_action.php",
			data: dataString,
			cache: false,
			async:false,
			success: function(data){ 
			setTimeout(function(){
					$('.img-preload').fadeOut(500);
					getFolders(catId);//call folder field
					$('#sub-id').val("");
					$('#cat-id').val("");
					$('#subsub-id').val("");
					$('#menu_head').val("");
					$('#menu_position').val("");
					CKEDITOR.instances.menu_desc.setData();
				},1000);
					 //alert(data)
					 
				}
			});
		}else{
			alert("Please Fill New Menu Name and Description !");
		}
}
function addSubSubmenu(){ // add sub sub menu for submeu
		var catId			=	$('#menu-cat').val(); // this value is used for stay back on same folder details
		var subcat_id 		=	$('#cat-id').val();
		var sub_menu_id 	=	$('#subsub-id').val();
		var menu_name		=	$('#menu_head').val(); 
		var menu_desc		=	CKEDITOR.instances.menu_desc.getData();
		var new_pos			=   $('#menu_position').val();
		var dataString		=	'subcat_id='+subcat_id+'&sub_menu_id='+sub_menu_id+'&menu_name='+menu_name+'&menu_desc='+menu_desc+'&act=addsubsub'+'&menu_pos='+new_pos;
		if(subcat_id && sub_menu_id && menu_name){
			$('.img-preload').fadeIn(1000);
		$.ajax({
			type: "POST",
			url: "ajax_action.php",
			data: dataString,
			cache: false,
			async:false,
			success: function(data){ // alert(data);
			setTimeout(function(){
					$('.img-preload').fadeOut(500);
					getFolders(catId);//call folder field
					$('#sub-id').val("");
					$('#cat-id').val("");
					$('#subsub-id').val("");
					$('#menu_head').val("");
					$('#menu_position').val("");
					CKEDITOR.instances.menu_desc.setData();
				},1000);
					 //alert(data)
					 
				}
			});
		}else{
			alert("Please Fill New Menu Name and Description !");
		}
}

/*Menu creation for sub menu end*/
</script>
</body></html>
