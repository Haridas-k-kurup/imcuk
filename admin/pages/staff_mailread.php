<?php 
	include_once(DIR_ROOT.'admin/includes/header.php');
	include_once(DIR_ROOT."admin/includes/pagination.php");
	$del_id					=	$_REQUEST['del_id'];
	if(isset($_GET['mail']) && $_GET['stf']){
		if($adminType != 1){
			header('location:'.SITE_ROOT."admin/index.php?page=dashboard");
		}
		$mailId				=	$objCommon->esc($_GET['mail']);
		$userId				=	$objCommon->esc($_GET['stf']);
		$phpSelf			=	SITE_ROOT.'admin/index.php?page=stsff_mailread&mail='.$mailId."&stf=".$userId;
		
		/*if(isset($del_id) && $del_id >0){
			$chkStatus		=	$objMail->getRow('mail_id = "'.$del_id.'"');
			if($chkStatus['mail_to'] == $adminSession){
				$delFlag	=	1;
				$objMail->updateField(array("mail_to_del" =>$delFlag),"mail_id =".$del_id);
			}else if($checkStatus['mail_from'] == $adminSession){
				$delFlag	=	1;
				$objMail->updateField(array("mail_from_del" =>$delFlag),"mail_id =".$del_id);
		}
			header('location:index.php?page=mailbox');
		}*/
		
		$megSql				=	"SELECT mail.mail_id, mail.mail_from, mail.mail_to, mail.mail_subject, mail.mail_body, mail.mail_created, mail.mail_from_read, mail.mail_to_read, ad.admin_username, ad.admin_type FROM admin_mailbox AS mail LEFT JOIN admin AS ad ON mail.mail_from = ad.admin_id WHERE mail.mail_id = '".$mailId."' AND (mail.mail_to = '".$userId."' OR mail.mail_from = '".$userId."') AND mail.mail_to_del = 0 ORDER BY mail_id DESC";
		
		$msg				=	$objMail->getRowSql($megSql);
		
		if(!empty($msg)){ // for change read status
			$readFlag		=	0;
			if($msg['mail_to'] == $adminSession && $msg['mail_to_read'] == 1){
				$objMail->updateField(array("mail_to_read" =>$readFlag),"mail_id =".$mailId);
			}else if($msg['mail_from'] == $adminSession && $msg['mail_from_read'] == 1){
				$objMail->updateField(array("mail_from_read" =>$readFlag),"mail_id =".$mailId);
			}
		}else{
			header('location:'.$_SERVER['HTTP_REFERER']);
			$chkStatus		=	$objReply->getRow('mail_id = "'.$del_id.'"');
		}
		
	}else{
		header('location:'.SITE_ROOT."admin/index.php?page=dashboard");
	}
	/*if(isset($_GET['rply'])){
			$replyId		=	$objCommon->esc($_GET['rply']);
			$chkQuery		=	"SELECT rply.*, mail.mail_from FROM admin_mailreply AS rply LEFT JOIN admin_mailbox AS mail ON rply.mail_id = mail.mail_id WHERE rply.reply_id = '".$replyId."'";
			$chkrply		=	$objReply->getRowSql($chkQuery);
			if($chkrply['reply_from'] == $adminSession){
				$objReply->updateField(array("reply_from_del" =>1),"reply_id = ".$replyId);
			}else if($chkrply['mail_from'] == $adminSession){
				$objReply->updateField(array("reply_to_del" =>1),"reply_id = ".$replyId);
			}
			header('location:'.$phpSelf);
	}*/
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
                        Message
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
                                <i class="fa fa-globe"></i> <?php echo $msg['admin_username']; 
													$sentTime									= 	$msg['mail_created'];
													$timeObj									=	new DateTime($sentTime);
													$dateSent									=	$timeObj->format('m-d-y');
													$currentDate								=	date("m-d-y");
													
														$showDate								=	$dateSent;
														$showTime								=	$timeObj->format('H:i A');
														
													
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
                                <strong>Subject:</strong> <?php echo $msg['mail_subject']; ?><br>
                                <?php echo $msg['admin_username']; ?>, <?php echo $showDate." ".$showTime ?>
                            </address>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                                 <?php echo $msg['mail_body']; ?>                       
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- /.row -->
                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <!--<div class="col-xs-12">
                            <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>  
                            <button class="btn btn-success pull-right" data-toggle="modal" data-target="#compose-modal"><i class="fa fa-share-square-o"></i> Reply</button>
                            <button class="btn btn-danger pull-right" style="margin-right: 5px;" onclick="return delMesg(<?php echo $msg['mail_id']; ?>)"><i class="fa fa-trash-o"></i> Delete</button>
                        </div>-->
                    </div>
                </section><!-- /.content -->
                <!-- reply start -->
                <?php 
					$replySql		=	"SELECT reply.reply_id, reply.reply_body, reply.reply_date, reply.reply_status, ad.admin_username, ad.admin_type FROM admin_mailreply AS reply LEFT JOIN admin AS ad ON reply.reply_from = ad.admin_id WHERE reply.mail_id = '".$msg['mail_id']."' AND reply.reply_status = 1 ORDER BY reply.reply_id";
					$allReply			=	$objReply->listQuery($replySql);
					if(count($allReply) >0){
						foreach($allReply as $reply){
				 ?>
                <section class="content invoice">                    
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-globe"></i> <?php echo $reply['admin_username']; 
													$sentTime									= 	$reply['reply_date'];
													$timeObj									=	new DateTime($sentTime);
													$dateSent									=	$timeObj->format('m-d-y');
													$currentDate								=	date("m-d-y");
														$showDate								=	$dateSent;
														$showTime								=	$timeObj->format('H:i A');
														
													
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
                                <strong>Subject:</strong> <?php echo $msg['mail_subject']; ?><br>
                                <?php echo $reply['admin_username']; ?>, <?php echo $showDate." ".$showTime; ?>
                            </address>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                                 <?php echo $reply['reply_body']; ?>                       
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- /.row -->
                    <!-- this row will not appear when printing -->
                    <!--<div class="row no-print">
                        <div class="col-xs-12"> 
                            <button class="btn btn-success pull-right" data-toggle="modal" data-target="#compose-modal"><i class="fa fa-share-square-o"></i> Reply</button>
                            <button class="btn btn-danger pull-right" style="margin-right: 5px;" onclick="return delReply(<?php echo $reply['reply_id']; ?>)"><i class="fa fa-trash-o"></i> Delete</button>
                        </div>
                    </div>-->
                </section>
                <?php 
						}
				 } ?>
                <!-- reply end -->
                
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

  <!-- COMPOSE MESSAGE MODAL -->
        <!--<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-envelope-o"></i> Compose New Reply</h4>
                    </div>
                    <form action="mail_action.php?act=sendReply" method="post">
                    <input type="hidden" name="mail_dtl" value="<?php echo $msg['mail_id']; ?>" />
                        <div class="modal-body">
                            <div class="form-group">
                                <textarea name="message" id="email_message" class="form-control ckeditor" placeholder="Message" ></textarea>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>

                            <button type="submit" class="btn btn-primary pull-left"><i class="fa fa-envelope"></i> Send Message</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>--><!-- /.modal -->
        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!--<script type="text/javascript" language="javascript">
		CKEDITOR.replace("message",
				{
					 height: 250
				});
		</script>
        <script type="text/javascript" language="javascript">
			function delMesg(e){
				url							=	'<?php echo $phpSelf ?>&del_id='+e;
				
				if(confirm('You are sure to delete this message.. Continue?')){
					window.location.href	=	url;
				}
			}
		</script>
        <script type="text/javascript" language="javascript">
			function delReply(e){
				url							=	'<?php echo $phpSelf ?>&rply='+e;
				
				if(confirm('You are sure to delete this message.. Continue?')){
					window.location.href	=	url;
				}
			}
		</script>-->
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

    </body>
</html>