<?php
include_once(DIR_ROOT."admin/includes/header.php");
include_once(DIR_ROOT."class/manage_category.php");
include_once(DIR_ROOT."class/manage_pages.php");
include_once(DIR_ROOT."class/manage_page_connection.php");
include_once(DIR_ROOT."class/imc_pages.php");
include_once(DIR_ROOT."class/manage_topic_position.php");
$objCat					= new manage_category();
$objImcPage				= new manage_pages();
$objPageCon				= new manage_page_connection();
$objImc					= new imc_pages();
$objTopic				= new manage_topic_position();
$allCat					= $objCat->getAll("(cat_id = 1 or cat_id = 2 or cat_id = 3 or cat_id = 5 or cat_id = 6 or cat_id = 10) and cat_status=1","cat_category");
$allImc					= $objImc->getAll("page_status=1","page_name");
$allTopic				= $objTopic->getAll("pos_status=1","pos_name");
if ($_GET['eid']) {
	$editId				= $objCommon->esc($_GET['eid']);
	$pageDtail			= $objImcPage->getRow('mp_id ='.$editId);
	$conDtil			= $objPageCon->getAll('mp_id ='.$editId);
	$arrayPage			= array();
	$arrayCat			= array();
	foreach($conDtil as $conPage){
		$arrayPage[]	= $conPage['page_id'];
	}
	foreach($conDtil as $conCat){
		$arrayCat[]		= $conCat['cat_id'];
	}
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
                        Manage I M C Slider & pages
                        <small>International Medical Connection</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Add Topics</li>
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
                                    <h3 class="box-title">Add Topics<small>(Add topic and description on sliders, and main page information fields ...etc)</small></h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                 <?php 
									echo $notfn->msg();
								?> 
                                <form action="<?php echo SITE_ROOT?>admin/action.php?act=manage_pages" method="post" role="form" enctype="multipart/form-data">
                                	<?php if($pageDtail['mp_id']){ ?>
                                	<input type="hidden" name="page_editId" value="<?php echo $pageDtail['mp_id']; ?>">
                                    <?php } ?>
                                    <div class="box-body">
                                    <div class="row">
                                     <div class="col-md-12">
                                     	<div class="row">
                                        	<div class="col-md-6">
                                            	<div class="form-group">
                                            <label>Target Pages</label>
                                            <?php if($editId){ ?>
                                            <select name="page_id[]" class="form-control" multiple="" required>
                                               <?php foreach($allImc as $eachImc){ ?>
                    							<option value="<?php echo $eachImc['page_id']; ?>" <?php echo (in_array($eachImc['page_id'],$arrayPage))?'selected':'' ?> ><?php echo  $eachImc['page_name']; ?></option>
                        						<?php } ?>
                                            </select>
                                            <?php }else{ ?>
                                             <select name="page_id[]" class="form-control" multiple="" required>
                                               <?php foreach($allImc as $eachImc){ ?>
                    							<option value="<?php echo $eachImc['page_id']; ?>" ><?php echo  $eachImc['page_name']; ?></option>
                        						<?php } ?>
                                            </select>
                                            <?php } ?>
                                      			</div>
                                            </div>
                                            <div class="col-md-6">
                                            	<div class="form-group">
                                            <label>Page Category</label>
                                             <?php if($editId){ ?>
                                            <select class="form-control" name="cat_id[]"  multiple="" required>
                                                <?php foreach($allCat as $cat){ ?>
                    							<option value="<?php echo $cat['cat_id']; ?>" <?php echo (in_array($cat['cat_id'],$arrayCat))? 'selected':'' ?>><?php echo $cat['cat_category']; ?></option>
                        						<?php } ?>
                                            </select>
                                            <?php }else{ ?>
                                            <select class="form-control" name="cat_id[]"  multiple="" required>
                                                <?php foreach($allCat as $cat){ ?>
                    							<option value="<?php echo $cat['cat_id']; ?>"><?php echo $cat['cat_category']; ?></option>
                        						<?php } ?>
                                            </select>
                                             <?php } ?>
                                        		</div>
                                            </div>
                                        </div>
                                     </div>
                                    </div>
                                    <!--<div class="row">
                                    	<div class="col-md-6">
                                        <div class="form-group">
                                            <label>Topic Position (Optional)</label>
                                            <select class="form-control" name="pos_id">
                                            <option value=""></option>
 						 <?php foreach ($allTopic as $value) { ?>
                    							<option value="<?php echo $value['pos_id']; ?>" <?php echo ($pageDtail['pos_id'] == $value['pos_id'])?'selected':'' ?>><?php echo $value['pos_name']; ?></option>
                        <?php } ?>
                                            </select>
                                        	</div>
                                        </div>
                                        <div class="col-md-6">
                                        	
                                        </div>
                                    </div>-->
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" type="button">Main Heading</button>
                                        </div><!-- /btn-group -->
                                        	<input type="text" class="form-control" name="mp_heading" required value="<?php echo stripslashes($pageDtail['mp_heading']); ?>" placeholder="Enter heading...">
                                    </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <textarea name="mp_desc" class="form-control ckeditor" placeholder="Enter description..."><?php echo stripslashes($pageDtail['mp_desc']); ?></textarea>
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary"><?php echo($pageDtail['mp_id'])?'Update Page':'Save Page' ?></button>
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