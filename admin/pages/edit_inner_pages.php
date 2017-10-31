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
$allCat					=	$objCat->getAll('cat_id = 7 or cat_id = 8 or cat_id = 9 ','cat_category desc');
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
      <h1> Manage I M C Inner pages details <small>International Medical Connection</small> </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Manage Inner Pages</li>
        <li class="active">Edit Inner Pages & Menu</li>
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
              <h3 class="box-title">Edit Inner Pages & Menu <small> ( Click on menu, Sub-menu or Sub-sub menu for edit this  or delete content )</small></h3>
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
          
            <div class="col-md-3" >
            <div class="input-group input-group-sm">
                <input type="text" id="search-txt" class="form-control" placeholder="Search by main menu name ">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-info btn-flat" onclick="return seachMenu();">Go!</button>
                </span>
             </div>
            <div class="form-group">
                <label>Select Category</label>
                <select class="form-control alert-danger" id="menu-cat">
                    <?php foreach($allCat as $menuCat){ ?>
                    <option value="<?php echo $menuCat['cat_id']; ?>"><?php echo $menuCat['cat_category']; ?></option>
                    <?php } ?>
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
                    <div class="row">
                        	<div class="col-md-6">
                            	<button class="btn bg-yellow btn-sm pull-left" onclick="window.open('<?php echo SITE_ROOT; ?>admin/index.php?page=page-and-menu','IMC','width=600,height=700')">Page and Menu</button>
                    	    </div>
                            <div class="col-md-6">
                            	<button class="btn bg-maroon btn-sm pull-left" onclick="return loadAddMenu();">Add New Sub-Menu</button>
                    	    </div>
                         </div>
                    </div>
                    <div class="col-md-6 action-btn">
                    	<div class="row">
                        	<div class="col-md-6">
                            	
                    	    </div>
                        	<div class="col-md-6" id="action-btn-area" style="display:none;">
                            	 <button class="btn btn-info btn-sm" onclick="return submitForm(1);">Update</button>
                       			 <button class="btn btn-danger btn-sm" onclick="return updateSubmenu(2);">Delete</button>
                       			 <button class="btn btn-success btn-sm" onclick="return updateSubmenu(3);">Active</button>
                        	</div>
                        </div>
                    </div>
                	
                </div>
                	<img src="../images/preloader-01.gif" class="img-preload" />
            	<form action="<?php echo SITE_ROOT?>admin/ajax_action.php" method="post" role="form" enctype="multipart/form-data" id="sub-menu-edit-field">
                 <input type="hidden" name="id" id="select-menu" />
                <input type="hidden" name="actionFlag" value="1" />
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
<script src="js/AdminLTE/app-modified.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
$('#menu-cat').on('change', function(){// function for change menu list
				  	var catId		=	$(this).val();
					getFolders(catId);
					
				  });
/*Menu creation for sub menu start*/
function loadAddMenu(){
	window.location = "index.php?page=add_sub_menu";
}
function getFolders(catId){ /*this function will call while page load from app.js*/
		var dataString 	= 	'catId='+catId
		$.ajax({
				type: "POST",
				url: "ajax_get_folder.php",
				data: dataString,
				cache: false,
				async:false,
				dataType:"html",
				success: function(data){
						$('#submenu-folder').html(data);
					}
				});
	}
	function seachMenu(){ // FUNCTION FOR SEACH MAIN MANU 
	var searchfid	=	$('#search-txt').val();
	var dataStrg 	= 	'searchfid='+searchfid;
	if(searchfid){
		$.ajax({
				type: "POST",
				url: "ajax_get_folder.php",
				data: dataStrg,
				cache: false,
				async:false,
				dataType:"html",
				success: function(data){ //alert(data);
						$('#submenu-folder').html(data);
					}
				});
	}			
}


function updateSubmenu(actionFlag){
	var catId		=	$('#menu-cat').val(); // this value is used for stay back on same folder details
	var id			=	$('#menu_id').val();
	var flag		=	$('#menu_flag').val(); alert(flag); return false;
	var	heading		=	$('#new_head').val();
	var editor_data = CKEDITOR.instances.new_desc.getData();
	var position	= 	$('#new_position').val();
		if(actionFlag == 1){
			var	actDialog	=	"Are you sure you want to update this item ! ";
		}else if(actionFlag == 2){
			var	actDialog	=	"Are you sure you want to delete this item ! ";
		}else{
			var	actDialog	=	"Are you sure you want to change status of this item ! ";
		}
	if(id && flag){	
			var dataString 	= 	'id='+id+'&flag='+flag+'&actionFlag='+actionFlag+'&heading='+heading+'&desc='+editor_data+'&pos='+position; 
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
				getFolders(catId);//call folder field
			    editCategory(id,flag); //call edited field
				},1000);
					//alert(data)
					//$('#sub-menu-edit-field').html(data);
				}
			});
		  }
	}
}

/*Menu creation for sub menu end*/

function submitForm() {
	var id			=	$('#menu_id').val();
	if (id) {
	$('#select-menu').val(id);
		if (confirm("Are you sure you want to update this menu !")) {
			$('#sub-menu-edit-field').submit();
		}
	}
}
</script>
</body></html>
