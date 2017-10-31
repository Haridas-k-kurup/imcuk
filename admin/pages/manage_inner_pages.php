<?php
include_once(DIR_ROOT."admin/includes/header.php");
include_once(DIR_ROOT."class/manage_category.php");
include_once(DIR_ROOT."class/manage_pages.php");
include_once(DIR_ROOT."class/imc_pages.php");
include_once(DIR_ROOT."class/manage_topic_position.php");
//include_once(DIR_ROOT."class/manage_sub_category.php");
include_once(DIR_ROOT."class/manage_sub_pages.php");
$objCat					=	new manage_category();
$objPage				=	new manage_pages();
$objImc					=	new	imc_pages();
$objTopic				=	new	manage_topic_position();
//$objSubcat				=	new manage_sub_category();
$objSubPage				=	new manage_sub_pages();
$allCat					=	$objCat->getAll("cat_status=1 and is_menu_category = 1","cat_category");
//$allSubCat				=	$objSubcat->getAll("subcat_status=1","subcat_name");
$allImc					=	$objImc->getAll("page_status=1","page_name");
$allTopic				=	$objTopic->getAll("pos_status=1");
	
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
                        Manage I M C Inner pages
                        <small>International Medical Connection</small>
                    </h1>
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
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                 <?php 
									echo $notfn->msg();
								?> 
                                <form action="<?php echo SITE_ROOT?>admin/action.php?act=manage_sub_pages" method="post" role="form" enctype="multipart/form-data">
                                	<input type="hidden" name="forum_topic_id" value="<?php echo $subPageDtail['topic_id']; ?>">
                                    <div class="box-body">
                                    <div class="row">
                                    	<div class="col-md-6">
                                        	<div class="form-group">
                                            <label>Target Page</label>
                                            <select name="page_id[]" class="form-control" multiple="multiple" required>
                                                 <?php foreach($allImc as $eachImc){ ?>
                    	<option value="<?php echo  $eachImc['page_id']; ?>" <?php echo ($getPage[0]['page_id'] == $eachImc['page_id'])?'selected=selected':'' ?> ><?php echo  $eachImc['page_name']; ?></option>
                        <?php } ?>
                                            </select>
                                      		</div>
                                        </div>
                                        <div class="col-md-6" style="border:1px solid #999;">
                                        	<div class="form-group" style="margin-bottom: 0;">
                                            	<label>Menu Demo</label>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="demo-images">
                                                    <img src="img/submenu_model.png" class="img-responsive" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                            <div class="demo-images">
                                                    <img src="img/top-sub.png" class="img-responsive" />
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                     	<div class="col-md-6">
                                        	<div class="form-group">
                                            <label>Page Category</label>
                                            <select class="form-control" name="cat_id" id="cat_id" required>
                                            <option value=""></option>
                                                <?php foreach($allCat as $cat){ ?>
                    	<option value="<?php echo $cat['cat_id']; ?>" <?php echo ($cat['cat_id']==$getPage[0]['cat_id'])? "selected=selected":'' ?>> <?php echo $cat['cat_category']; ?> </option>
                        <?php } ?>
                                            </select>
                                        	</div>
                                        </div>
                                        <div class="col-md-6">
                                        	<div class="form-group">
                                            <label>Menu &nbsp;&nbsp;<a href="javascript:;"  onclick="window.open('<?php echo SITE_ROOT ?>admin/index.php?page=add_sub_category','IMC','width=600,height=700')" title="Create new sub category and refersh this page"> <span class="label label-success"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add new</span></a>
                                            
                                           <a href="javascript:;" id="menu-reload"> <small title="Reload" class="label label-primary"><i class="fa fa-refresh"></i>&nbsp;&nbsp; Reload</small></a>
                                            </label>
                                            <select class="form-control" name="subcat_id" id="subcat_id" required>
                                            <option value=""></option>
                                                
                                            </select>
                                            
                                        	</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" type="button">Heading</button>
                                        </div><!-- /btn-group -->
                                        	<input type="text" class="form-control" name="sub_heading"  required value="<?php echo $subPageDtail['topic']; ?>" placeholder="Enter main heading for this page...">
                                    </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <textarea name="sub_information" class="form-control ckeditor" ><?php echo $subPageDtail['topic_desc']; ?></textarea>
                                        </div>  
                                    </div><!-- /.box-body -->
                                    <hr />
                                    <div class="box box-info">
                                    <div class="box-body">
                                    	<h4>Sub Menu Details <small> ( Add Sub-menu for above menu. Click on "Add New Sub-menu" button for add new Sub menu )</small></h4>
                                    </div>
                                    <!--add sub menu details start-->
                                    <div class="multi-field-wrapper">
										<div class="multi-fields">
                                        <div class="multi-field box box-warning">
                                         <button type="button" class="btn btn-danger remove-field pull-right">Remove Menu</button>
                                    <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-warning" type="button">Sub Menu</button>
                                        </div><!-- /btn-group -->
                                        	<input type="text" class="form-control" name="sub_menu_head[]" maxlength="15" required value="<?php echo $subPageDtail['topic']; ?>" placeholder="Enter Sub menu name or heading with in 10 character limit...">
                                    </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <textarea name="sub_menu_info[]" class="form-control" id="23" placeholder="Enter small description about this menu and edit it from Manage All Menu for add style" ><?php echo $subPageDtail['topic_desc']; ?></textarea> 
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-warning" type="button">Position</button>
                                        </div><!-- /btn-group -->
                                        	<input type="number" class="form-control" name="sub_menu_position[]" value="<?php echo $subPageDtail['position']; ?>" placeholder="Enter menu position...">
                                    </div>
                                        </div>
                                        </div>  
                                        </div>
                                        <button type="button" class="btn btn-success add-field"><i class="fa fa-plus-square"></i>
 &nbsp;Add New Sub-Menu</button>
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
    </body>
</html>
<script type="text/javascript" language="javascript">
$('#menu-reload').click(function(){ // reload this page for getting newly added menu
	window.location.reload();
	});
/*Menu creation for sub menu start*/
$('.multi-field-wrapper').each(function() {
	$('.remove-field',$(this)).hide();
    var $wrapper = $('.multi-fields', this);
    $(".add-field", $(this)).click(function(e) {
		//$($wrapper, $(this)).find('textarea').first().attr('id');
        $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
		$('.remove-field:first-child').show();
    });
    $('.multi-field .remove-field', $wrapper).click(function() {
        if ($('.multi-field', $wrapper).length > 1)
            $(this).parent('.multi-field').remove();
    });
});
/*Menu creation for sub menu end*/
/*get all sub catagories ajax start*/

$('#cat_id').change(function(){ 
	var catId		=	$(this).val();
	var dataString 	= 	'catId='+catId;
//alert(dataString);

	$.ajax({
	type: "POST",
	url: "ajax_get_sub_cat.php",
	data: dataString,
	cache: false,
	success: function(data) 
	{ //alert(data);
		$('#subcat_id').html(data);
	}
	}); 
});
/*get all sub catagories ajax end*/

</script>