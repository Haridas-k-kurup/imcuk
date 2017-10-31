<?php
include_once(DIR_ROOT."admin/includes/header.php");
include_once(DIR_ROOT."class/forum_topics.php");
$objForum			=	new forum_topics();
if($_GET['eid']){
	$editId			=  $objCommon->esc($_GET['eid']);
	$forumDtail		=  $objForum->getRow('topic_id ='.$editId,'topic_id');
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
                        Edit User Forum
                        <small>International Medical Connection</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">List All I M C Forums</a></li>
                        <li class="active">Edit Forum</li>
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
                                    <h3 class="box-title">Edit Forum</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                 <?php 
						echo $notfn->msg();
						?> 
                                <form action="action.php?act=forumEdit" method="post" role="form">
                                	<input type="hidden" name="forum_topic_id" value="<?php echo $forumDtail['topic_id']; ?>">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" type="button">Heading</button>
                                        </div><!-- /btn-group -->
                                        <input type="text" class="form-control" name="forum_head" value="<?php echo $forumDtail['topic']; ?>">
                                    </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <textarea name="forum_dec" class="form-control ckeditor" ><?php echo $forumDtail['topic_desc']; ?></textarea>
                                        </div>
                                        
                                        
                                        <div class="form-group">
                                            <label for="">Add a notice for this forum</label>
                                            <textarea name="forum_notice" class="form-control ckeditor" ><?php echo $forumDtail['topic_notice']; ?></textarea>
                                        </div>
                                        
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Update Forum</button>
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