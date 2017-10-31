<?php 
	include_once(DIR_ROOT.'admin/includes/header.php');
	$userId			=	$objCommon->esc($_GET['stf']);
	if($adminType != 1 ||  !$userId){
		header('location:'.SITE_ROOT."admin/index.php?page=dashboard");
	}
	include_once(DIR_ROOT."admin/includes/pagination.php");
	$userDtils		=	$objAdmin->getRow('admin_id = "'.$userId.'"','admin_id');
	//$del_id			=	$_REQUEST['del_id'];
	$actionFlag		=	$objCommon->esc($_GET['mail_action']);
	$phpSelf		=	SITE_ROOT.'admin/index.php?page=staff_mailbox&stf='.$userId	;
	/*if(count($del_id)>0){
	foreach($del_id as $all_del_id){
		$mailId			=	$objCommon->esc($all_del_id);
		$checkStatus	=	$objMail->getRow("mail_id = ".$mailId);
		if($checkStatus['mail_to'] == $adminSession){
			if($actionFlag && $actionFlag == 1){
				//flag 1 for delete status changing
				$objMail->updateField(array("mail_to_del" => 1),"mail_id =".$mailId);	
			}else if($actionFlag && $actionFlag == 2){
				//flag 2 for delete status unread to read
				$objMail->updateField(array("mail_to_read" => 0),"mail_id =".$mailId);	
			}else if($actionFlag && $actionFlag == 3){
				//flag 3 for delete status read to unread
				$objMail->updateField(array("mail_to_read" =>1),"mail_id =".$mailId);	
			}
		}else if($checkStatus['mail_from'] == $adminSession){
			if($actionFlag && $actionFlag == 1){
				//flag 1 for delete status changing
				$objMail->updateField(array("mail_from_del" => 1),"mail_id =".$mailId);	
			}else if($actionFlag && $actionFlag == 2){
				//flag 2 for delete status unread to read
				$objMail->updateField(array("mail_from_read" => 0),"mail_id =".$mailId);	
			}else if($actionFlag && $actionFlag == 3){
				//flag 3 for delete status read to unread
				$objMail->updateField(array("mail_from_read" =>1),"mail_id =".$mailId);	
			}
		}
	}
	$notfn->add_msg("Message has been deleted successfully...!",3);
	header("location:".$phpSelf);
}*/
?>
<script type="text/javascript" src="<?php echo SITE_ROOT; ?>ckeditor/ckeditor.js"></script>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
             <?php include_once('includes/sidemenubar.php'); ?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header no-margin">
                    <h1 class="text-center">
                        Mailbox
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- MAILBOX BEGIN -->
                    <div class="mailbox row">
                        <div class="col-xs-12">
                            <div class="box box-solid">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-4">
                                            <!-- BOXES are complex enough to move the .box-header around.
                                                 This is an example of having the box header within the box body -->
                                            <div class="box-header">
                                                <i class="fa fa-inbox"></i>
                                                <h3 class="box-title">INBOX of <?php echo $userDtils['admin_username']; ?></h3>
                                            </div>
                                             <?php 
													echo $notfn->msg();
											 ?> 
                                            <div style="margin-top: 15px;">
                                                <ul class="nav nav-pills nav-stacked">
                                                    <li class="header">Folders</li>
                                                    <li class="active"><a href="<?php echo SITE_ROOT ?>admin/index.php?page=staff_mailbox&stf=<?php echo $userId; ?>"><i class="fa fa-inbox"></i> Inbox</a></li>
                                                    <li><a href="<?php echo SITE_ROOT ?>admin/index.php?page=staff_sentbox&stf=<?php echo $userId; ?>"><i class="fa fa-mail-forward"></i> Sent</a></li>
                                                </ul>
                                            </div>
                                        </div><!-- /.col (LEFT) -->
                                        <div class="col-md-9 col-sm-8">
                                            <div class="row pad">
                                                <div class="col-sm-6">
                                                    <!--<label style="margin-right: 10px;">
                                                        <input type="checkbox" id="check-all"/>
                                                    </label>-->
                                                    <!-- Action button -->
                                                    <!--<div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                                            Action <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="javascript:;" id="check-allread">Read</a></li>
                                                            <li><a href="javascript:;" id="check-allunread">Unread</a></li>
                                                            <li class="divider"></li>
                                                            <li><a href="javascript:;" id="delete-mail">Delete</a></li>
                                                            <li><a href="javascript:;" id="mark-as-read">Mark as read</a></li>
                                                            <li><a href="javascript:;" id="mark-as-unread">Mark as unread</a></li>
                                                        </ul>
                                                    </div>-->

                                                </div>
                                                <div class="col-sm-6 search-form">
                                                    <form action="#" class="text-right">
                                                        <div class="input-group">  
                                                        <input type="hidden" value="staff_mailbox" name="page">
                                                        <input type="hidden" value="<?php echo $userId; ?>" name="stf">                                                          
                                                            <input type="text" class="form-control input-sm" name="search_field" placeholder="Search">
                                                            <div class="input-group-btn">
                                                                <button type="submit" name="q" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                                            </div>
                                                        </div>                                                     
                                                    </form>
                                                </div>
                                            </div><!-- /.row -->

                                            <div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                 <form method="get" id="mail-box">
                                					<input type="hidden" value="mailbox" name="page" />
                                                    <input type="hidden" name="mail_action" id="mail_action" value="" />
                                                <table class="table table-mailbox">
                                                <?php
													/*-----------Pagination start----------------*/
													$num_results_per_page 	 					=	($_GET['new_view'])?$_GET['new_view']:12;
													$num_page_links_per_page 					= 	5;
													$pg_param 									= 	"";
													if($search){
														$sql_pagination 						= 	"SELECT * FROM( SELECT mail.mail_id, mail.mail_from, mail.mail_to,  mail.mail_subject, mail.mail_body, mail.mail_created, mail.mail_from_read, mail.mail_to_read, ad.admin_username, ad.admin_type FROM admin_mailbox AS mail LEFT JOIN admin AS ad ON mail.mail_from = ad.admin_id WHERE mail.mail_to = '".$userId."' AND (mail.mail_subject LIKE '%".$search."%' OR ad.admin_username LIKE '%".$search."%') AND mail.mail_to_del = 0  UNION
SELECT snt.mail_id, snt.mail_from, snt.mail_to, snt.mail_subject, snt.mail_body, snt.mail_created, snt.mail_from_read, snt.mail_to_read, adm.admin_username, adm.admin_type FROM admin_mailreply AS rply LEFT JOIN admin_mailbox AS snt ON rply.mail_id = snt.mail_id LEFT JOIN admin AS adm ON snt.mail_to = adm.admin_id WHERE snt.mail_from = '".$userId."' AND     (snt.mail_subject LIKE '%".$search."%' OR adm.admin_username LIKE '%".$search."%') AND snt.mail_from_del = 0 GROUP BY snt.mail_id ) a ORDER BY mail_id DESC";	
														
														
														
														
														
														"SELECT mail.mail_id, mail.mail_subject, mail.mail_body, mail.mail_created, mail.mail_read_status, ad.admin_username, ad.admin_type FROM admin_mailbox AS mail LEFT JOIN admin AS ad ON mail.mail_from = ad.admin_id WHERE (mail.mail_subject LIKE '%".$search."%' OR ad.admin_username LIKE '%".$search."%') AND mail.mail_to = '".$adminSession."' AND mail.mail_to_del = 0 ORDER BY mail.mail_id DESC";
													}else{
														 $sql_pagination 						= 	 "SELECT * FROM( SELECT mail.mail_id, mail.mail_from, mail.mail_to,  mail.mail_subject, mail.mail_body, mail.mail_created, mail.mail_from_read, mail.mail_to_read, ad.admin_username, ad.admin_type FROM admin_mailbox AS mail LEFT JOIN admin AS ad ON mail.mail_from = ad.admin_id WHERE mail.mail_to = '".$userId."' AND mail.mail_to_del = 0  UNION
SELECT snt.mail_id, snt.mail_from, snt.mail_to, snt.mail_subject, snt.mail_body, snt.mail_created, snt.mail_from_read, snt.mail_to_read, adm.admin_username, adm.admin_type FROM admin_mailreply AS rply LEFT JOIN admin_mailbox AS snt ON rply.mail_id = snt.mail_id LEFT JOIN admin AS adm ON snt.mail_to = adm.admin_id WHERE snt.mail_from = '".$userId."' AND snt.mail_from_del = 0 GROUP BY snt.mail_id ) a ORDER BY mail_id DESC";	
														 
														  
														
													}
													$pagesection								=	'';
													pagination($sql_pagination, $num_results_per_page, $num_page_links_per_page, $pg_param,$pagesection);
													$page_list									=	$objMail->listQuery($paginationQuery);
													$countpageList								=	mysql_num_rows(mysql_query($sql_pagination));
													if(count($page_list) >0){
														$count									=	1;
														foreach($page_list as $all){
													/*-----------Pagination End----------------*/
													$sentTime									= 	$all['mail_created'];
													$timeObj									=	new DateTime($sentTime);
													$dateSent									=	$timeObj->format('m-d-y');
													$currentDate								=	date("m-d-y");
													if($currentDate > $dateSent){
														$showTime								=	$dateSent;
														
													}else{
														$showTime								=	$timeObj->format('H:i A');
														
													}
													if(($all['mail_to'] == $adminSession && $all['mail_to_read'] == 1) || ($all['mail_from'] == $adminSession && $all['mail_from_read'] == 1)){
													?>                                     
                                                    <tr class="unread">
                                                        <td class="small-col"><input type="checkbox" class="mglr_checkbox unread_checkbox" value="<?php echo $all['mail_id']?>" name="del_id[]" /></td>
                                                        <td class="small-col"><i class="fa <?php echo($all['admin_type'] == 1)? "fa-star" : "fa-star-o" ?>"></i></td>
                                                        <td class="name"><a href="<?php echo SITE_ROOT; ?>admin/index.php?page=staff_mailread&mail=<?php echo $all['mail_id']; ?>&stf=<?php echo $userId; ?>"><?php echo ($all['admin_type'] == 1) ? 'Administrator' : $all['admin_username'];  ?></a></td>
                                                        <td class="subject"><a href="<?php echo SITE_ROOT; ?>admin/index.php?page=staff_mailread&mail=<?php echo $all['mail_id']; ?>&stf=<?php echo $userId; ?>"><?php echo substr($all['mail_subject'],0,100); ?></a></td>
                                                        <td class="time"><?php echo $showTime; ?></td>
                                                    </tr>
                                                    <?php }else{ ?>
													<tr>
                                                        <td class="small-col"><input type="checkbox" class="mglr_checkbox read_checkbox"  value="<?php echo $all['mail_id']?>" name="del_id[]"/></td>
                                                        <td class="small-col"><i class="fa fa-star"></i></td>
                                                        <td class="name"><a href="<?php echo SITE_ROOT; ?>admin/index.php?page=staff_mailread&mail=<?php echo $all['mail_id']; ?>&stf=<?php echo $userId; ?>"><?php echo ($all['admin_type'] == 1) ? 'Administrator' : $all['admin_username'];  ?></a></td>
                                                        <td class="subject"><a href="<?php echo SITE_ROOT; ?>admin/index.php?page=staff_mailread&mail=<?php echo $all['mail_id']; ?>&stf=<?php echo $userId; ?>"><?php echo substr($all['mail_subject'],0,100); ?></a></td>
                                                        <td class="time"><?php echo $showTime; ?></td>
                                                    </tr>
													<?php } } }else{ ?>
                                                    <tr class="unread">
                                                        <td colspan="5">Sorry ! Inbox is empty</td>
                                                        
                                                    </tr>
                                                    <?php } ?>
                                                </table>
                                                </form>
                                            </div><!-- /.table-responsive -->
                                        </div><!-- /.col (RIGHT) -->
                                    </div><!-- /.row -->
                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                   
                                         <?php include_once(DIR_ROOT."admin/includes/pagination_div.php"); ?>
                                   
                                </div><!-- box-footer -->
                            </div><!-- /.box -->
                        </div><!-- /.col (MAIN) -->
                    </div>
                    <!-- MAILBOX END -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!--<script type="text/javascript" language="javascript">
			$(document).on("click","#check-all",function(){
			var checked_status = this.checked;
			$(".mglr_checkbox").each(function(){
			this.checked = checked_status;
			});
			$('#mark-as-read').show();
			$('#mark-as-unread').show();
			});
			$(document).on("click","#check-allread",function(){
			$(".read_checkbox").each(function(){
			this.checked = true;
			
			});
			$(".unread_checkbox").each(function(){
			this.checked = false;
			});
			$('#mark-as-read').hide();
			$('#mark-as-unread').show();
			});
			$(document).on("click","#check-allunread",function(){
			$(".unread_checkbox").each(function(){
			this.checked = true;
			});
			$(".read_checkbox").each(function(){
			this.checked = false;
			});
			$('#mark-as-read').show();
			$('#mark-as-unread').hide();
			});
			$('#delete-mail').click(function(){
				if(confirm('You are sure to delete this Mail.. Continue?')){
					$('#mail_action').val(1);
					$('#mail-box').submit();
				}
				});
			$('#mark-as-read').click(function(){
				if(confirm('You are sure to mark as read.. Continue?')){
					$('#mail_action').val(2);
					$('#mail-box').submit();
				}
				});
			$('#mark-as-unread').click(function(){
				if(confirm('You are sure to mark as unread.. Continue?')){
					$('#mail_action').val(3);
					$('#mail-box').submit();
				}
				});
		</script>-->
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="jsplugins//bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="jsplugins//iCheck/icheck.min.js" type="text/javascript"></script>
        <!-- Page script -->
        

    </body>
</html>