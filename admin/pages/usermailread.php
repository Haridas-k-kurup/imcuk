<?php 
	include_once(DIR_ROOT.'admin/includes/header.php');
	include_once(DIR_ROOT."admin/includes/pagination.php");
	include_once(DIR_ROOT."class/personal_messages.php");
	include_once(DIR_ROOT."class/personal_reply.php");
	$objPMsg				=	new personal_messages();
	$objPrply				=	new personal_reply();
	$del_id					=	$_REQUEST['del_id'];
	if(isset($_GET['mail'])){
		$mailId				=	$objCommon->esc($_GET['mail']);
		$phpSelf			=	SITE_ROOT.'admin/index.php?page=usermailread&mail='.$mailId;
		
		if(isset($del_id) && $del_id >0){
			$chkStatus		=	$objPMsg->getRow('msg_id = "'.$del_id.'"');
			
			if($chkStatus['msg_to'] == 1){ 
				$objPMsg->updateField(array("to_status" =>0),"msg_id =".$del_id);
			}else if($chkStatus['msg_from'] == 1){
				$objPMsg->updateField(array("from_status" =>0),"msg_id =".$del_id);
		}
			header('location:index.php?page=mailbox');
		}
		
		$megSql				=	"SELECT mail.msg_id, mail.msg_from, mail.msg_to, mail.msg_subject, mail.msg_body, mail.msg_created_on, ad.ud_name_title, ad.ud_first_name FROM personal_messages AS mail LEFT JOIN user_details AS ad ON mail.msg_from = ad.reg_id WHERE mail.msg_id = '".$mailId."' AND (mail.msg_to = 1 OR mail.msg_from = 1) AND mail.to_status = 1 ORDER BY msg_id DESC";
		
		$msg				=	$objMail->getRowSql($megSql);
		
		if($msg['mail_from'] != 1){ // for save to draft msg_to dtil
			$replyTo		=	$msg['msg_from'];	
		}else{
			$replyTo		=	$msg['msg_from'];
		}
		
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
                                <i class="fa fa-globe"></i> <?php
								 echo ($msg['ud_name_title'])? $msg['ud_name_title']." :".$msg['ud_first_name']: $msg['ud_first_name'] ;
								 if(!$msg['ud_name_title']){
									 echo "Administrator ";
								 }
													$sentTime									= 	$msg['msg_created_on'];
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
                                <strong>Subject:</strong> <?php echo $msg['msg_subject']; ?><br>
                                <?php echo $msg['ud_first_name']; ?>, <?php echo $showDate." ".$showTime ?>
                            </address>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                                 <?php echo $msg['msg_body']; ?>                       
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- /.row -->
                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-xs-12">
                            <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>  
                            <button class="btn btn-success pull-right" id="replysub" ><i class="fa fa-share-square-o"></i> Reply</button>
                            <button class="btn btn-danger pull-right" style="margin-right: 5px;" onclick="return delMesg(<?php echo $msg['msg_id']; ?>)"><i class="fa fa-trash-o"></i> Delete</button>
                            
                        </div>
                    </div>
                     <!-- COMPOSE MESSAGE MODAL -->
                    <div class="row" >
                    	<div class="col-md-12">
                            <!-- Primary box -->
                            <div class="box box-primary margin" style="display:none;"  id="sub-reply">
                                <div title="Compose New Reply" data-toggle="tooltip" class="box-header" data-original-title="Header tooltip">
                                    <h3 class="box-title">Compose New Reply</h3>
                                    <div class="box-tools pull-right">
                                        <button data-widget="collapse" class="btn btn-primary btn-xs"><i class="fa fa-minus"></i></button>
                                        <button data-widget="remove" class="btn btn-primary btn-xs"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body" style="display: block;">
                                    <form action="mail_action.php?act=sendReply" method="post">
                                    <input type="hidden" name="mail_dtl" value="<?php echo $msg['msg_id']; ?>" />
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <textarea name="message" id="message"  class="form-control ckeditor" placeholder="Message" ></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer clearfix">
                                            <button type="button" class="btn btn-danger" data-widget="remove"><i class="fa fa-times"></i> Discard</button>
                
                                            <button type="submit" class="btn btn-primary pull-left"><i class="fa fa-envelope"></i> Send Message</button>
                                            <button type="button" id="save-draft" class="btn btn-info pull-left"><i class="fa fa-pencil-square-o"></i> Save Draft</button>
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
                <?php 
					$replySql			=	"SELECT reply.preply_id, reply.preply_body, reply.preply_created_on, reply.preply_status, ad.ud_name_title, ad.ud_first_name FROM personal_reply AS reply LEFT JOIN user_details AS ad ON reply.preply_from = ad.reg_id WHERE reply.msg_id = '".$msg['msg_id']."' AND reply.preply_status = 1 ORDER BY reply.preply_id";
					$allReply			=	$objPrply->listQuery($replySql);
					if(count($allReply) >0){
						foreach($allReply as $reply){
				 ?>
                <section class="content invoice">                    
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-globe"></i> <?php echo ($reply['ud_name_title'])? $reply['ud_name_title']." :".$reply['ud_first_name']: $reply['ud_first_name'] ;
								if(!$reply['ud_name_title']){
									 echo "Administrator ";
								 }
													$sentTime					= 	$reply['preply_created_on'];
													$timeObj					=	new DateTime($sentTime);
													$dateSent					=	$timeObj->format('m-d-y');
													$currentDate				=	date("m-d-y");
														$showDate				=	$dateSent;
														$showTime				=	$timeObj->format('H:i A');				
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
                                <strong>Subject: </strong> <?php echo $msg['msg_subject']; ?><br>
                                <?php echo $reply['ud_first_name']; ?>, <?php echo $showDate." ".$showTime; ?>
                            </address>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                                 <?php echo $reply['preply_body']; ?>                       
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- /.row -->
                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-xs-12"> 
                            <button class="btn btn-success pull-right" onclick="return showReply(<?php echo $reply['preply_id']; ?>);"><i class="fa fa-share-square-o"></i> Reply</button>
                            <button class="btn btn-danger pull-right" style="margin-right: 5px;" onclick="return delReply(<?php echo $reply['preply_id']; ?>)"><i class="fa fa-trash-o"></i> Delete</button>
                        </div>
                    </div>
                    <!-- COMPOSE MESSAGE MODAL -->
                    <div class="row" >
                    	<div class="col-md-12">
                            <!-- Primary box -->
                            <div class="box box-primary margin" style="display:none;"  id="reply-reply<?php echo $reply['preply_id']; ?>">
                                <div title="Compose New Reply" data-toggle="tooltip" class="box-header" data-original-title="Header tooltip">
                                    <h3 class="box-title">Compose New Reply</h3>
                                    <div class="box-tools pull-right">
                                        <button data-widget="collapse" class="btn btn-primary btn-xs"><i class="fa fa-minus"></i></button>
                                        <button data-widget="remove" class="btn btn-primary btn-xs"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body" style="display: block;">
                                    <form action="mail_action.php?act=sendReply" method="post">
                                    <input type="hidden" name="mail_dtl" value="<?php echo $msg['preply_id']; ?>" />
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <textarea name="message" id="message<?php echo $reply['preply_id']; ?>" class="form-control ckeditor" placeholder="Message" ></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer clearfix">
                                            <button type="button" class="btn btn-danger" data-widget="remove"><i class="fa fa-times"></i> Discard</button>
                                            <button type="submit" class="btn btn-primary pull-left"><i class="fa fa-envelope"></i> Send Message</button>
                                            <button type="button" onclick="return replyDraft(<?php echo $reply['preply_id']; ?>);" class="btn btn-info pull-left"><i class="fa fa-pencil-square-o"></i> Save Draft</button>
                                        </div>
                                    </form>
                                </div><!-- /.box-body -->
                                <!-- /.box-footer-->
                            </div><!-- /.box -->
                        </div>
                    </div><!-- /.modal -->
                </section>
                <?php 
				}
				 } ?>
                <!-- reply end -->
                
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
			function delReply(e){
			var	url							=	'<?php echo $phpSelf ?>&rply='+e;
				if(confirm('You are sure to delete this message... Continue?')){
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
			function showReply(e){
				var r		=	"#reply-reply"+e;
				$(r).show();
			}
		</script>
        <script type="text/javascript" language="javascript">
			$('#save-draft').click(function(){
				var toDtil			=	<?php echo $replyTo; ?>;
				var dfsubject		=	"<?php echo $msg['mail_subject']; ?>";
				var dfmessage		=	CKEDITOR.instances.message.getData();
				var dfact			=	"draft";
				var dataString 		= 	'toDtil='+toDtil+'&df_subject='+dfsubject+'&df_message='+dfmessage+'&df_act='+dfact;
				$.ajax({
						type: "POST",
						url: "mail_action.php",
						data: dataString,
						cache: false,
						async:false,
						success: function(data){
								window.location.reload();
							}
						});
			});
		</script>
        <script type="text/javascript" language="javascript">
		function replyDraft(e){
			var	r				=	"message"+e;
			var toDtil			=	<?php echo $replyTo; ?>;
			var dfsubject		=	"<?php echo $msg['mail_subject']; ?>";
			var dfmessage		=	CKEDITOR.instances.r.getData();
			var dfact			=	"draft";
			var dataString 		= 	'toDtil='+toDtil+'&df_subject='+dfsubject+'&df_message='+dfmessage+'&df_act='+dfact;
			$.ajax({
					type: "POST",
					url: "mail_action.php",
					data: dataString,
					cache: false,
					async:false,
					success: function(data){
							window.location.reload();
						}
					});
		}
		</script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
    </body>
</html>