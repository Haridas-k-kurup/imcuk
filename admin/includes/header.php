<?php 
include_once(DIR_ROOT."class/imc_pages.php");
include_once(DIR_ROOT."class/admin.php");
include_once(DIR_ROOT."class/admin_mailbox.php");
include_once(DIR_ROOT."class/admin_mailreply.php");
include_once(DIR_ROOT."class/contact_us_type.php");
include_once(DIR_ROOT."class/contact_us_form.php");
include_once(DIR_ROOT."class/abuse_forum.php");
include_once(DIR_ROOT."class/abuse_slider.php");
$objImcPage		=	new imc_pages();
$objAdmin		=	new admin();
$objMail		=	new admin_mailbox();
$objReply		=	new admin_mailreply();
$objConType		=	new contact_us_type();
$objConForm		=	new contact_us_form();
$objAbuseForum	=	new abuse_forum();
$objAbuseSlider	=	new abuse_slider();
$allPages		=	$objImcPage->getAll();
$adminDtils		=	$objAdmin->getRow('admin_id = "'.$adminSession.'"');
$unread			=	$objMail->count('(mail_to = "'.$adminSession.'" and mail_to_read = 1 and mail_to_del = 0) or ( mail_from = "'.$adminSession.'" and mail_from_read = 1 and mail_from_del = 0)');
$allContype		=	$objConType->getAll('contact_type_status = 1','contact_type_id');
if ($adminType == 1) {
	$con_unread	= $objConForm->count('read_status = 0');
} else {
	$con_unread	= $objConForm->count('read_status = 0 and contact_type_id != 3');
}

 ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>I M C | International Medical Connection</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="css/imc_admin.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="pace-done fixed skin-blue">
        <!-- header logo: style can be found in header.less -->
<header class="header">
            <a href="index.html" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                I M C
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                	<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <a href="<?php echo SITE_ROOT; ?>admin/index.php?page=mailbox" class="dropdown-toggle" title="Messages">
                                <i class="fa fa-envelope"></i>
                                 <?php  if($unread > 0){ ?>
                                <span class="label label-success"><?php echo $unread ?></span>
                                <?php } ?>
                            </a>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu" id="abuse-notification">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Notifications">
                                <i class="fa fa-warning"></i>
                                
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">No new notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu"  style="height:auto !important">
                                        <li>
                                            <a href="<?php echo SITE_ROOT; ?>admin/index.php?page=abuse_details&abtype=forum" >
                                                <i class="ion ion-ios7-people info"></i> IMC Forum Abuse &nbsp; <span class="label label-warning"></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo SITE_ROOT; ?>admin/index.php?page=abuse_details&abtype=slider">
                                                <i class="fa fa-warning danger"></i> IMC Page Details Abuse&nbsp; <span class="label label-warning"></span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">IMC notifications list</a></li>
                            </ul>
                        </li>
                        <!-- Tasks: style can be found in dropdown.less -->
                        
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo ($adminType == 2)? ucfirst($adminDtils['admin_username']) : 'Administrator' ?><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                	<?php if($adminType == 2){ 
										if($adminDtils['admin_image'] != ""){
                                    	$filePath		=	DIR_ROOT."admin/profile/".$adminDtils['admin_image'];
														if(file_exists($filePath)){
													 ?>
                                    			<img src="<?php echo SITE_ROOT ?>admin/profile/<?php echo $adminDtils['admin_image']; ?>" class="img-circle" alt="User Image" />
                                    <?php }else{ ?>
										<img src="<?php echo SITE_ROOT ?>admin/img/avatar5.png" class="img-circle" alt="User Image" />
									<?php	}
												}else{ ?> 
										<img src="<?php echo SITE_ROOT ?>admin/img/avatar5.png" class="img-circle" alt="User Image" />
									<?php } 
											}else{ ?>
                                    	<img src="img/swami.png" class="img-circle" alt="User Image" />
                                    <?php } ?>
                                    <p>
                                        International Medical Connection
                                        <small>India</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <?php if($adminType == 1){ ?>
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="<?php echo SITE_ROOT; ?>admin/index.php?page=add_staff">Add-Staff</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="<?php echo SITE_ROOT; ?>admin/index.php?page=list_staff">All-Staff</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="<?php echo SITE_ROOT; ?>admin/index.php?page=list_online_staff">Online-Staff</a>
                                    </div>
                                </li>
                                <?php } ?>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Website</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo SITE_ROOT; ?>admin/index.php?page=logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <script type="text/javascript" language="javascript">
			window.setInterval(function(){ getNotification();}, 5000);
			function getNotification(){
			$.ajax({
					type: "POST",
					url: "ajax/get_abuse_notification.php",
					cache: false,
					async:false,
					dataType:"html",
					success: function(data){
							$('#abuse-notification').html(data);
						}
					});
			}
			</script>
        </header>
      