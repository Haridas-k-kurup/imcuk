<?php
include_once(DIR_ROOT."admin/includes/header.php");
if($adminType != 1){
	header('location:index.php?page=dashboard');
}
include_once(DIR_ROOT."class/about_us.php");
$objAbout					=	new about_us();
$allTopic					=	$objAbout->getRow();
?>
<script type="text/javascript" src="<?php echo SITE_ROOT; ?>ckeditor/ckeditor.js"></script>
<!--<script type="text/javascript" src="<?php echo SITE_ROOT; ?>ckeditor/ckfinder.js"></script>-->
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <?php include_once('includes/sidemenubar.php'); ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                       About I M C 
                        <small>International Medical Connection</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">About Us</li>
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
                                    <h3 class="box-title">Add About us</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                 <?php 
									echo $notfn->msg();
								?> 
                                <form action="<?php echo SITE_ROOT?>admin/action.php?act=about_us" method="post" role="form" enctype="multipart/form-data">
                                	<?php if($allTopic['about_id']){ ?>
                                	<input type="hidden" name="about_editId" value="<?php echo $allTopic['about_id']; ?>">
                                    <?php } ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" type="button">Main Heading</button>
                                        </div><!-- /btn-group -->
                                        	<input type="text" class="form-control" name="about_heading" required value="<?php echo stripslashes($allTopic['about_head']); ?>" placeholder="Enter heading...">
                                    </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <textarea name="about_desc" class="form-control ckeditor" placeholder="Enter description..."><?php echo stripslashes($allTopic['about_us']); ?></textarea>
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary"><?php echo($allTopic['about_id'])?'Update':'Save' ?></button>
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