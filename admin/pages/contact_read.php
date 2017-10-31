<?php 
	include_once(DIR_ROOT.'admin/includes/header.php');
	include_once(DIR_ROOT."admin/includes/pagination.php");
	$del_id					=	$_REQUEST['del_id'];
	if(isset($_GET['cid']) && $_GET['cid']){
		 $cId				=	$objCommon->esc($_GET['cid']);
		 $phpSelf			=	SITE_ROOT.'admin/index.php?page=contact_read&cid='.$cId;
		 $getCont			=	$objConForm->getRow('contact_id = "'.$cId.'"');	
		 $objConForm->update(array('read_status' => 1),"contact_id='".$cId."'");
		}else{
			header('location:'.$_SERVER['HTTP_REFERER']);
		}
?>
<script type="text/javascript" src="<?php echo SITE_ROOT; ?>ckeditor/ckeditor.js"></script>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
             <?php include_once('includes/sidemenubar.php'); ?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Contact us message
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Mailbox</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content invoice">                    
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                         <?php 
							echo $notfn->msg();
						  ?> 
                            <h2 class="page-header">
                                <i class="fa fa-globe"></i> <?php echo $getCont['contact_name']; 
													$sentTime									= 	$getCont['contact_created'];
													$timeObj									=	new DateTime($sentTime);
													$dateSent									=	$timeObj->format('m-d-y');
													$currentDate								=	date("m-d-y");
													$showDate									=	$dateSent;
													$showTime									=	$timeObj->format('H:i A');
								 ?>
                                
                                <small class="pull-right">Date: <?php echo $showDate." ".$showTime ?></small>
                            </h2>                            
                        </div><!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-12 invoice-col">
                            From
                            <address>
                                <strong>Subject:</strong> <?php echo  stripcslashes($getCont['contact_subject']); ?><br>
                                <?php echo $getCont['contact_name']; ?>, <?php echo $showDate." ".$showTime ?><br>
                                IP Address : <?php echo $getCont['contact_ip']; ?>
                            </address>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                                 <?php echo stripcslashes($getCont['contact_message']); ?>                       
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- /.row -->
                    
                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-xs-12">
                            <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>  
                            <button class="btn btn-success pull-right" id="replysub" ><i class="fa fa-share-square-o"></i> Reply</button>
                            <button class="btn btn-danger pull-right" style="margin-right: 5px;" onclick="return delMesg(<?php echo $getCont['contact_id']; ?>)"><i class="fa fa-trash-o"></i> Delete</button> 
                        </div>
                    </div>
                     <!-- COMPOSE MESSAGE MODAL -->
                    <div class="row" >
                    	<div class="col-md-12">
                            <!-- Primary box -->
                            <div class="box box-primary margin" style="display:none;"  id="sub-reply">
                                <div title="Compose New Reply" data-toggle="tooltip" class="box-header" data-original-title="Header tooltip">
                                    <h3 class="box-title">Compose Reply for <?php echo $getCont['contact_name']; ?></h3>
                                    <div class="box-tools pull-right">
                                        <button data-widget="collapse" class="btn btn-primary btn-xs"><i class="fa fa-minus"></i></button>
                                        <button data-widget="remove" class="btn btn-primary btn-xs"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body" style="display: block;">
                                    <form action="mail_action.php?act=contactReply" method="post">
                                    <input type="hidden" name="con_dtil" value="<?php echo $getCont['contact_id']; ?>" />
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <textarea name="con_reply" id="message"  class="form-control ckeditor" placeholder="Message" ></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer clearfix">
                                            <button type="button" class="btn btn-danger" data-widget="remove"><i class="fa fa-times"></i> Discard</button>
                
                                            <button type="submit" class="btn btn-primary pull-left"><i class="fa fa-envelope"></i> Send Reply</button>
                                        </div>
                                    </form>
                                </div><!-- /.box-body -->
                                <!-- /.box-footer-->
                            </div>
                            <!-- /.box -->
                        </div>
                    </div><!-- /.modal -->
                </section><!-- /.content -->
                <!-- reply start -->
                <!-- reply end -->
                <?php 
				
					$conRyQ										  	=		"select rply.*, adm.admin_username from contact_us_reply as rply left join admin as adm on rply.contact_replyed = adm.admin_id where rply.contact_id = '".$getCont['contact_id']."'";
					$allConReply									=		$objConForm->listQuery($conRyQ);
					foreach($allConReply as $replys){
				 ?>
                <section class="content invoice">                    
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12"> 
                            <h2 class="page-header">
                                <i class="fa fa-mail-forward"></i>  Reply from IMC Team <?php echo ($adminType == 1) ? "<small class = \"text-green\">Replied  By : ".$replys['admin_username']."</small>" : ''; 
								$sentTime									= 	$replys['contact_reply_date'];
								$timeObj									=	new DateTime($sentTime);
								$dateSent									=	$timeObj->format('m-d-y');
								$currentDate								=	date("m-d-y");
								$showDate									=	$dateSent;
								$showTime									=	$timeObj->format('H:i A');
								 ?>
                                
                                <small class="pull-right">Date: <?php echo $showDate." ".$showTime ?></small>
                            </h2>                            
                        </div><!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-12 invoice-col">
                            From
                            <address>
                                <strong>Subject:</strong> <?php echo  stripcslashes($getCont['contact_subject']); ?>
                            </address>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                                 <?php echo stripcslashes($replys['contact_reply']); ?>                       
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- /.row -->
                    
                </section>
                <?php } ?>
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!--<script type="text/javascript" language="javascript">
		CKEDITOR.replace("message",
				{
					 height: 250
				});
		</script>-->
        <script type="text/javascript" language="javascript">
			function delMesg(e){
				var	url						=	'<?php echo $phpSelf ?>&del_id='+e;
				if(confirm('You are sure to delete this message.. Continue?')){
					window.location.href	=	url;
				}
			}
		</script>
        <script type="text/javascript" language="javascript">
			$('#replysub').click(function(){
					$('#sub-reply').show();
				});
		</script>
        
        <script type="text/javascript" language="javascript">
		$(function(){
				var notific_count	= $('#contact-notific').text();
				<?php if ($getCont['read_status'] == 0) { ?>
					var new_count	= $('#contact-notific').text(notific_count-1);	
				<?php } ?>
			});
		</script>
        
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

    </body>
</html>