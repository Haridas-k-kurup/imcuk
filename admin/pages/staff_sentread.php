<?php 
	include_once(DIR_ROOT.'admin/includes/header.php');
	if($adminType != 1){
			header('location:'.SITE_ROOT."admin/index.php?page=dashboard");
		}
	include_once(DIR_ROOT."admin/includes/pagination.php");
	//$del_id			=	$_REQUEST['del_id'];
	if(isset($_GET['mail']) && $_GET['stf']){
		$mailId		=	$objCommon->esc($_GET['mail']);
		$userId		=	$objCommon->esc($_GET['stf']);
		$phpSelf	=	SITE_ROOT.'admin/index.php?page=sentread&mail='.$mailId;
		
		$megSql		=	"SELECT mail.mail_id, mail.mail_subject, mail.mail_body, mail.mail_created, ad.admin_username, ad.admin_type FROM admin_mailbox AS mail LEFT JOIN admin AS ad ON mail.mail_to = ad.admin_id WHERE mail.mail_id = '".$mailId."' AND mail.mail_from = '".$userId."' AND mail.mail_from_del = 0 ORDER BY mail.mail_id DESC";
		
		$msg		=	$objMail->getRowSql($megSql);
		
		if(empty($msg)){
			header('location:index.php?page=sentbox');
		}
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
                    
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script type="text/javascript" language="javascript">
			function delMesg(e){
				url							=	'<?php echo $phpSelf ?>&del_id='+e;
				
				if(confirm('You are sure to delete this message.. Continue?')){
					window.location.href	=	url;
				}
			}
		</script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

    </body>
</html>