<?php 
include_once(DIR_ROOT."admin/includes/header.php");
include_once(DIR_ROOT."class/ad_management.php");
include_once(DIR_ROOT."class/imc_pages.php");
include_once(DIR_ROOT."class/manage_topic_position.php");
$objAds					=	new ad_management();
$objImcPgs				=	new imc_pages();
$objPos					=	new manage_topic_position();
if($_GET['eid']){
	$eid				=	$objCommon->esc($_GET['eid']);
	$changeAds			=	$objAds->getRow('ad_id = "'.$eid.'"');
}
 ?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
 
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <?php include_once('includes/sidemenubar.php'); ?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Manage I M C Advertisement
                        <small>International Medical Connection</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Advertisement</a></li>
                        <li class="active">Add Advertisement</li>
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
                                    <h3 class="box-title"> <?php echo ($eid)? 'Change Advertisement' : 'Add Advertisement' ?></small></h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                 <?php 
									echo $notfn->msg();
								 ?> 
                                <form action="<?php echo SITE_ROOT?>admin/action.php?act=advertisement" method="post" role="form" enctype="multipart/form-data">
                                <?php if($eid){ ?>
                                	<input type="hidden" name="ads_edit" value="<?php echo $eid; ?>">
                                    <input type="hidden" name="adPos" value="<?php echo $changeAds['ad_position']; ?>">
                                    <?php } ?>
                                    <div class="box-body">
                                    <div class="row">
                                    <div class="col-md-3"></div>
                                     <div class="col-md-6">
                                     	<div class="row">
                                        	<div class="col-md-12">
                                            	<div class="form-group has-warning">
                                            	<label>Advertisement Name</label>
                                            	<input required title="Enter Advertisement Name" name="ads_name" type="text" placeholder="Enter Advertisement Name..." value="<?php echo $changeAds['ad_name'];?>"  class="form-control">
                                      			</div>
                                                <div class="form-group has-warning">
                                            	<label>Advertiser Name</label>
                                            	<input required title="Enter Advertiser Name" name="adrs_name" type="text" placeholder="Enter Advertiser Name..." value="<?php echo $changeAds['ad_adver_name'];?>"  class="form-control">
                                      			</div>
                                                <div class="form-group has-warning">
                                            	<label>Advertisement Pages ( Press 'ctrl' to select multiple Pages )</label>
                                                <select class="form-control" name="page_id[]" multiple>
                                                <?php 
													$allPages		=	$objImcPgs->getAll('page_status = 1','page_name');
													foreach($allPages as $imcPgs){
												 ?>
                                                <option value="<?php echo $imcPgs['page_id']; ?>" <?php echo ($imcPgs['page_id'] == $changeAds['page_id'])? 'selected' : '' ?>><?php echo $imcPgs['page_name']; ?></option>
                                               <?php } ?>
                                            </select>
                                      			</div>
                                                <div class="form-group has-warning">
                                            	<label>Advertisement Position</label>
                                                <select class="form-control" name="pos_id">
                                                <option value="">---------- Select Position ----------</option>
                                                <?php $allPos	=	$objPos->getAll('pos_status = 1', 'pos_name'); 
														foreach($allPos as $postion){
												?>
                                                <option value="<?php echo $postion['pos_id']; ?>" <?php echo ($postion['pos_id'] == $changeAds['pos_id'])? 'selected' : '' ?>><?php echo $postion['pos_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                      			</div>
                                                <div class="form-group has-warning">
                                            	<label>Advertisement Publish From</label>
                                            	<input required title="Advertisement Publish From" name="ad_publish_from" type="text" id="ad-from" placeholder="Enter starting date..." value="<?php echo $changeAds['ad_publish_from'];?>"  class="form-control" >
                                      			</div>
                                                
                                                <div class="form-group has-warning">
                                            	<label>Advertisement Publish To</label>
                                            	<input required title="Advertisement Publish To" name="ad_publish_to" type="text" id="ad-to" placeholder="Enter End Date..." value="<?php echo $changeAds['ad_publish_to'];?>"  class="form-control">
                                      			</div>     	
                                                <div class="form-group has-warning">
                                            	<label>Advertisement Hyper Link</label>
                                            	<input required title="Enter Advertisement Hyper Link" name="ad_hyper_link" type="text" placeholder="Enter Advertisement Hyper Link..." value="<?php echo $changeAds['ad_hyper_link'];?>"  class="form-control">
                                      			</div>
                                                <div class="form-group has-warning">                                
                                                    <div class="btn btn-warning btn-file">
                                                        <i class="fa fa-paperclip"></i> Advertisement
                                                        <input type="file" name="attachement" id="attachment">
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-group has-warning"  style="text-align:center">
                                                	<img src="<?php echo SITE_ROOT ?>admin/img/ajax-loader.gif" alt="loading" id="ad-loader" />
                                                   
                                                	<div id="preview">
                                                    <?php if($changeAds['ad_image']){ ?>
                                                        <input type="hidden" value="<?php echo $changeAds['ad_image']; ?>" name="edit_ad_image">
                                                        <div style="width:20%;margin:0 auto; text-align:center;" class="profile_preview ovr">
                                                        	<h4>Advertisement</h4><br>
                                                            <div class="alert-danger alert-dismissable">
                                                            <h5>Browse New Advertisement For Change This Ad Image </h5></div>
                                                            <img width="100%" height="112px" title="1430804701.jpg" src="<?php echo SITE_ROOT; ?>advertisement/<?php echo $changeAds['ad_image']; ?>">
                                                        </div>
                                                        <?php } ?>
                                                    </div>
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
        <!-- AdminLTE App -->
         <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
         <script type="text/javascript" src="<?php echo SITE_ROOT; ?>js/jquery.upload-1.0.2.js"></script>
          <script>
			$(function() {
			$( "#ad-from" ).datepicker({
        		  dateFormat: 'yy-mm-dd',
        		  onSelect: function(dateText, datePicker) {
       $(this).attr('value', dateText);
    	}
				});
			$( "#ad-to" ).datepicker({
				dateFormat: 'yy-mm-dd',
				onSelect: function(dateText, datePicker) {
       $(this).attr('value', dateText); }
				});
				
		  });
		  </script>
          
          <script language="JavaScript" type="text/javascript">
			$("#attachment").on('change',function(){
				if($("#attachment").val()!=""){
					$('#ad-loader').fadeIn(1000);
					setTimeout(function(){  
						$("#attachment").upload('upload.php', function(res) {  
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
  <script src="js/AdminLTE/app.js" type="text/javascript"></script>
    </body>
</html>