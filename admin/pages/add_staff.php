<?php 
include_once(DIR_ROOT."admin/includes/header.php");
include_once(DIR_ROOT."class/admin.php");
$objAdmin				=	new admin();
if($adminType != 1){
	header('location:'.SITE_ROOT."admin/index.php?page=dashboard");
}
if($_GET['staff']){
	$eid				=	$objCommon->esc($_GET['staff']);
	$changeStaff		=	$objAdmin->getRow('admin_id = "'.$eid.'"');
	}
 ?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <?php include_once('includes/sidemenubar.php'); ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Manage I M C Staff
                        <small>International Medical Connection</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Manage Staff</li>
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
                                    <h3 class="box-title"> <?php echo ($eid)? 'Change Staff Permission' : 'Add Staff' ?></small></h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                 <?php 
									echo $notfn->msg();
								?> 
                                <form action="<?php echo SITE_ROOT?>admin/action.php?act=addStaff" method="post" role="form" enctype="multipart/form-data">
                                <?php if($eid){ ?>
                                	<input type="hidden" name="admin_edit" value="<?php echo $eid; ?>">
                                    <?php } ?>
                                    <div class="box-body">
                                    <div class="row">
                                    <div class="col-md-3"></div>
                                     <div class="col-md-6">
                                     	<div class="row">
                                        	<div class="col-md-12">
                                            	<div class="form-group has-success">
                                            	<label>Staff's User Name</label>
                                            	<input required title="Enter User Name" name="admin_user" type="text" placeholder="Enter User Name..." value="<?php echo $changeStaff['admin_username'];?>"  class="form-control">
                                      			</div>
                                                <div class="form-group has-success">
                                            	<div class="btn btn-success btn-file">
                                                        <i class="fa fa-paperclip"></i> Profile Image
                                                        <input type="file" name="staff_attachement" id="attachment">
                                                    </div>
                                      			</div>
                                                <div class="form-group has-warning"  style="text-align:center">
                                                	<img src="<?php echo SITE_ROOT ?>admin/img/ajax-loader.gif" alt="loading" id="ad-loader" />
                                                   
                                                	<div id="preview">
                                                    <?php// if($changeAds['ad_image']){ ?>
                                                        <!-- <input type="hidden" value="<?php echo $changeAds['ad_image']; ?>" name="edit_ad_image">
                                                       <div style="width:20%;margin:0 auto; text-align:center;" class="profile_preview ovr">
                                                        	<h4>Advertisement</h4><br>
                                                            <div class="alert-danger alert-dismissable">
                                                            <h5>Browse New Advertisement For Change This Ad Image </h5></div>
                                                            <img width="100%" height="112px" title="1430804701.jpg" src="<?php echo SITE_ROOT; ?>advertisement/<?php echo $changeAds['ad_image']; ?>">
                                                        </div>-->
                                                        <?php// } ?>
                                                    </div>
                                                </div>
                                                <div class="form-group has-success">
                                            	<label><?php echo ($eid)? 'New Password' : 'Password' ?></label>
                                            	<input type="password" name="admin_pass" placeholder="Enter Password ..."  class="form-control" title="Password must contain at least 6 characters" required pattern=".{6,}" onchange=" this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); if(this.checkValidity()) form.pwd2.pattern = this.value;">
                                      			</div>
                                                <div class="form-group has-success">
                                            	<label>Re-enter Password</label>
                                            	<input type="password" id="pwd2" required pattern=".{6,}" name="pwd2" onchange=" this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); " placeholder="Re-Enter Password..."  class="form-control">
                                      			</div>
                                                <div class="box-footer">
                                        		<button type="submit" class="btn btn-primary"><?php echo ($eid)? 'Save Changes' : 'Done !' ?></button>
                                    			</div>
                                            </div>
                                            
                                        </div>
                                     </div>
                                      <div class="col-md-3"></div>
                                    </div> 
                                    </div><!-- /.box-body -->

                                    
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
        <script type="text/javascript" src="<?php echo SITE_ROOT; ?>js/jquery.upload-1.0.2.js"></script>
        <script language="JavaScript" type="text/javascript">
			$("#attachment").on('change',function(){
				if($("#attachment").val()!=""){
					$('#ad-loader').fadeIn(1000);
					setTimeout(function(){  
						$("#attachment").upload('profile_upload.php', function(res) {  
							if(res!=""){
								$('#ad-loader').hide();
								$("#preview").html(res);
							}
							else{
								alert("Sorry your Advertisement is not uploaded Properly !");
							}
						});
					},3000);
				}
			});

		</script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
    </body>
</html>