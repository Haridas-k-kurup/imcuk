<?php
include_once(DIR_ROOT."admin/includes/header.php");
include_once(DIR_ROOT."class/imc_pages.php");
include_once(DIR_ROOT."class/manage_category.php");
include_once(DIR_ROOT."class/manage_sub_category.php");
include_once(DIR_ROOT."class/manage_sub_pages.php");
$objImc					=	new	imc_pages();
$objSubcat				=	new manage_sub_category();
$objSubPage				=	new manage_sub_pages();
$objCat					=	new manage_category();
$allImc					=	$objImc->getAll("page_status=1","page_name");
$allSubCat				=	$objSubcat->getAll("subcat_status=1");
$allCat					=	$objCat->getAll("cat_status=1 and is_menu_category = 1","cat_category");
if($_GET['eid']){
	$editId				=   $objCommon->esc($_GET['eid']);
	$subPageDtail		=   $objSubPage->getRow('topic_id ='.$editId,'topic_id');
}
?>
<script type="text/javascript" src="<?php echo SITE_ROOT; ?>ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo SITE_ROOT; ?>ckeditor/ckfinder.js"></script>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <?php include_once('includes/sidemenubar.php'); ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Add I M C Sub Menu
                        <small>International Medical Connection</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li>Inner Menu Pages</li>
                        <li class="active">Add Sub Menu</li>
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
                                    <h3 class="box-title">Add Sub Menu <small>( Here you can create Sub for sub-sub menu.  i.e : You should select MAIN MENU and its SUB-MENU and its SUB-SUB MENU, then go for add SUB MENU. )</small></h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                 <?php 
									echo $notfn->msg();
								?> 
                                <form action="<?php echo SITE_ROOT?>admin/action.php?act=inner_sub_pluse" method="post" role="form" enctype="multipart/form-data">
                                	<input type="hidden" name="forum_topic_id" value="<?php echo $subPageDtail['topic_id']; ?>">
                                    <div class="box-body">
                                    <div class="row">
                                      <div class="col-md-6">
                                      <div class="form-group">
                                            <label>Target Pages</label>
                                            <select name="page_id" id="page_id" class="form-control" required>
                                            <option value="">--------------------------------------- SELECT YOUR PAGE ---------------------------------------</option>
                                                 <?php foreach($allImc as $eachImc){ ?>
                    	<option value="<?php echo  $eachImc['page_id']; ?>" <?php echo ($getPage[0]['page_id'] == $eachImc['page_id'])?'selected=selected':'' ?> ><?php echo  $eachImc['page_name']; ?></option>
                        <?php } ?>
                                            </select>
                                      		</div>
                                      </div>
                                      <div class="col-md-6">
                                      	<div class="form-group">
                                            <label>Page Category</label>
                                            <select class="form-control"  id="cat_id">
                                            <option value="">--------------------------------------- SELECT YOUR CATEGORY ---------------------------------------</option>
                                                <?php foreach($allCat as $cat){ ?>
                    	<option value="<?php echo $cat['cat_id']; ?>" <?php echo ($cat['cat_id']==$getPage[0]['cat_id'])? "selected=selected":'' ?>> <?php echo $cat['cat_category']; ?> </option>
                        <?php } ?>
                                            </select>
                                        	</div>
                                      </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-6">
                                        	<div class="form-group">
                                            <label>Select Menu</label>
                                            <select class="form-control" name="subcat_id" id="subcat_id" required>
                                            <option value="">--------------------------------------- SELECT YOUR SUB MENU ---------------------------------------</option>
                                                <?php foreach($allSubCat as $subCat){ ?>
                    	<option value="<?php echo $subCat['subcat_id']; ?>" <?php echo ($subCat['subcat_id']==$getPage[0]['subcat_id'])? "selected=selected":'' ?>><?php echo $subCat['subcat_name']; ?></option>
                        <?php } ?>
                                            </select>
                                        	</div>
                                        </div>
                                     	<div class="col-md-6">
                                        	<div class="form-group">
                                            <label>Select Sub-Menu</label>
                                            <select class="form-control" name="sub_menu" id="sub_menu" required>
                                            <option value=""></option>
                                            </select>
                                        	</div>
                                        </div>
                                        
                                    </div> 
                                     <div class="row">
                                    <div class="col-md-6">
                                        	<div class="form-group">
                                            <label>Select Sub-Sub Menu</label>
                                            <select class="form-control" name="sub_sub_menu" id="sub_sub_menu" required>
                                            <option value=""></option>
                                            </select>
                                        	</div>
                                        </div>
                                     	<div class="col-md-6">
                                        	<div class="form-group">
                                            <label>Select Inner Menu</label>
                                            <select class="form-control" name="sub_pluse_menu" id="sub_pluse_menu" required>
                                            	<option value=""></option>
                                            </select>
                                        	</div>
                                        </div>
                                    </div>
                                    </div><!-- /.box-body -->
                                    <hr />
                                    <div class="box box-info">
                                    <div class="box-body">
                                    	<h4>Sub Menu Details<small> ( Add Sub-menu for above menu. Click on "Add New Sub-menu" button for add new Sub Menu )</small></h4>
                                    </div>
                                    <!--add sub menu details start-->
                                    <div class="multi-field-wrapper">
										<div class="multi-fields">
                                        <div class="multi-field">
                                         <button type="button" class="btn btn-danger remove-field pull-right">Remove Menu</button>
                                    <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-warning bg-maroon" type="button">Sub Menu</button>
                                        </div><!-- /btn-group -->
                                        	<input type="text" class="form-control" name="inner_pluse_menu[]" maxlength="15" required value="<?php echo $subPageDtail['topic']; ?>" placeholder="Enter Sub menu name or heading with in 10 character limit...">
                                    </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <textarea name="menu_info[]" class="form-control" placeholder="Enter small description about this menu and edit it from Manage All Menu for add style" ><?php echo $subPageDtail['topic_desc']; ?></textarea> 
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-warning bg-maroon" type="button">Position</button>
                                        </div><!-- /btn-group -->
                                        	<input type="number" class="form-control" name="inner_position[]" value="<?php echo $subPageDtail['position']; ?>" placeholder="Enter menu position...">
                                    </div>
                                        </div>
                                        </div>  
                                        </div>
                                        <button type="button" class="btn btn-success add-field">Add New Sub-Menu</button>
                                      </div>
                                      </div>
                                         <!--add sub menu details end-->
                                      <hr />  
                                        
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Save Page</button>
                                    </div>
                                </form>
                            </div><!-- /.box -->

                            <!-- Form Element sizes -->
                           

                            <!-- Input addon -->
                            <!-- /.box -->

                        </div><!--/.col (left) -->
                        <!-- right column -->
                        <!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
  <script type="text/javascript" language="javascript">
/*Menu creation for sub menu start*/
$('.multi-field-wrapper').each(function() {
	$('.remove-field',$(this)).hide();
    var $wrapper = $('.multi-fields', this);
    $(".add-field", $(this)).click(function(e) {
        $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
		$('.remove-field:first-child').show();
    });
    $('.multi-field .remove-field', $wrapper).click(function() {
        if ($('.multi-field', $wrapper).length > 1)
            $(this).parent('.multi-field').remove();
    });
});
/*get all sub catagories ajax start*/

$('#cat_id').change(function(){
	var catId		=	$(this).val();
	var pageId		=	$('#page_id').val();
	var dataString 	= 	'catId='+catId+'&pageId='+pageId;
//alert("dataString=="+dataString);
	$.ajax({
	type: "POST",
	url: "ajax_get_sub_cat.php",
	data: dataString,
	cache: false,
	success: function(data) 
	{  //alert(data);
		$('#subcat_id').html(data);
	}
	}); 
});
/*get all sub catagories ajax end*/
/*Menu creation for sub menu end*/
</script>
<script type="text/javascript" language="javascript">
$('#subcat_id').change(function(){
	var subId		=	$(this).val();
	var dataString 	= 	'sub_cat_id='+subId;
//alert("dataString=="+dataString);
	$.ajax({
	type: "POST",
	url: "ajax_sub_menu.php",
	data: dataString,
	cache: false,
	success: function(data)
	{
		$('#sub_menu').html(data);
	}
	}); 
	});
</script>
<script type="text/javascript" language="javascript">
$('#sub_menu').change(function(){
	var subId		=	$(this).val(); 
	var dataString 	= 	'subId='+subId;
	//alert("dataString=="+dataString);
	$.ajax({
	type: "POST",
	url: "ajax_get_sub_sub_menu.php",
	data: dataString,
	cache: false,
	success: function(data){
		//alert(data);
		$('#sub_sub_menu').html(data);
	}
	}); 
	});
</script>
<script type="text/javascript" language="javascript">
$('#sub_sub_menu').change(function(){ // chk where the select sub menu has alrady assigned sub sub menu or not
	var subSubId	 	=	$(this).val();
	var dataString 		= 	'subSubId='+subSubId;
	//alert("dataString=="+dataString);
	$.ajax({
	type: "POST",
	url: "ajax_get_sub_menu_pluse.php",
	data: dataString,
	cache: false,
	success: function(data)
	{	
		$('#sub_pluse_menu').html(data);
	}
	}); 
	});
</script>
    </body>
</html>

