<?php 
	include_once(DIR_ROOT.'admin/includes/header.php');
	include_once(DIR_ROOT."admin/includes/pagination.php");
	$userId				=	$objCommon->esc($_GET['stf']);
	$userDtils			=	$objAdmin->getRow('admin_id = "'.$userId.'"','admin_id');
	//$del_id				=	$_REQUEST['del_id'];
	$phpSelf			=	SITE_ROOT.'admin/index.php?page=sentbox';
	/*if(count($del_id)>0){
	foreach($del_id as $all_del_id){
		$mailId			=	$objCommon->esc($all_del_id);
		$checkStatus	=	$objMail->getRow("mail_id = ".$mailId);
		if($checkStatus['mail_from'] == $adminSession){	
		$objMail->updateField(array("mail_from_del" => 1),"mail_id =".$mailId);	
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
                                                <i class="fa fa-upload"></i>
                                                <h3 class="box-title">OUTBOX of <?php echo $userDtils['admin_username']; ?></h3>
                                            </div>
                                             <?php 
													echo $notfn->msg();
											 ?> 
                                            <div style="margin-top: 15px;">
                                                <ul class="nav nav-pills nav-stacked">
                                                    <li class="header">Folders</li>
                                                    <li><a href="<?php echo SITE_ROOT ?>admin/index.php?page=staff_mailbox&stf=<?php echo $userId; ?>"><i class="fa fa-inbox"></i> Inbox</a></li>
                                                    <li class="active"><a href="<?php echo SITE_ROOT ?>admin/index.php?page=staff_sentbox&stf=<?php echo $userId; ?>"><i class="fa fa-mail-forward"></i> Sent</a></li>
                                                </ul>
                                            </div>
                                        </div><!-- /.col (LEFT) -->
                                        <div class="col-md-9 col-sm-8">
                                            <div class="row pad">
                                                <div class="col-sm-6">
                                                  <!--  <label style="margin-right: 10px;">
                                                        <input type="checkbox" id="check-all"/>
                                                    </label>
                                                    <!-- Action button -->
                                                 <!--   <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                                            Action <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="javascript:;" id="check-allmark">Select all</a></li>
                                                            <li><a href="javascript:;" id="check-allunmark">Deselect all</a></li>
                                                            <li class="divider"></li>
                                                            <li><a href="javascript:;" id="delete-mail">Delete</a></li>
                                                        </ul>
                                                    </div>-->

                                                </div>
                                                <div class="col-sm-6 search-form">
                                                    <form action="#" class="text-right">
                                                        <div class="input-group">  
                                                        <input type="hidden" value="sentbox" name="page">                                                          
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
                                                 <form method="get" id="sent-box">
                                					<input type="hidden" value="sentbox" name="page" />
                                                <table class="table table-mailbox">
                                                <?php
													/*-----------Pagination start----------------*/
													$num_results_per_page 	 					=	($_GET['new_view'])?$_GET['new_view']:12;
													$num_page_links_per_page 					= 	5;
													$pg_param 									= 	"";
													if($search){
														$sql_pagination 						= 	"SELECT mail.mail_id, mail.mail_subject, mail.mail_body, mail.mail_created, ad.admin_username, ad.admin_type FROM admin_mailbox AS mail LEFT JOIN admin AS ad ON mail.mail_to = ad.admin_id WHERE (mail.mail_subject LIKE '%".$search."%' OR ad.admin_username LIKE '%".$search."%')AND mail.mail_from  = '".$adminSession."' AND mail.mail_from_del = 0 ORDER BY mail.mail_id DESC";
													}else{
														 $sql_pagination 						= 	"SELECT mail.mail_id, mail.mail_subject, mail.mail_body, mail.mail_created, ad.admin_username, ad.admin_type FROM admin_mailbox AS mail LEFT JOIN admin AS ad ON mail.mail_to = ad.admin_id WHERE mail.mail_from  = '".$userId."' AND mail.mail_from_del = 0 ORDER BY mail.mail_id DESC";
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
													?>
													<tr>
                                                        <td class="small-col"><input type="checkbox" class="mglr_checkbox"  value="<?php echo $all['mail_id']?>" name="del_id[]"/></td>
                                                        <td class="small-col"><i class="fa fa-star"></i></td>
                                                        <td class="name"><a href="<?php echo SITE_ROOT; ?>admin/index.php?page=staff_sentread&stf=<?php echo $userId; ?>&mail=<?php echo $all['mail_id']; ?>"><?php echo ($all['admin_type'] == 1) ? 'Administrator' : $all['admin_username'];  ?></a></td>
                                                        <td class="subject"><a href="<?php echo SITE_ROOT; ?>admin/index.php?page=staff_sentread&stf=<?php echo $userId; ?>&mail=<?php echo $all['mail_id']; ?>"><?php echo substr($all['mail_subject'],0,100); ?></a></td>
                                                        <td class="time"><?php echo $showTime; ?></td>
                                                    </tr>
													<?php  } }else{ ?>
                                                    <tr class="unread">
                                                      <td colspan="5">Sorry ! Outbox is empty</td>
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

        <!-- COMPOSE MESSAGE MODAL -->
        <div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-envelope-o"></i> Compose New Message</h4>
                    </div>
                    <form action="mail_action.php?act=sendMail" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">TO:</span>
                                    <select  name="email_to" class="form-control" required>
                                     <optgroup label="ADMINISTRATOR">
                                    	<?php foreach($allAdmins as $admins){ 
											if($admins['admin_id'] == 1 && $admins['admin_type'] == 1){
										?>
                                       
                                            <option value="<?php echo $admins['admin_id']; ?>">Administrator</option>
                                          <?php } } ?>
                                          </optgroup>
                                           <optgroup label="MODERATOR">
                                          <?php 
										  foreach($allAdmins as $admins){
											  if($admins['admin_type'] == 2){
											   ?>
											<option value="<?php echo $admins['admin_id']; ?>"><?php echo $admins['admin_username'] ?></option>	
											<?php } } ?>
                                             </optgroup> 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Subject:</span>
                                    <input name="subject" type="text" class="form-control" placeholder="Sbject" required>
                                </div>
                            </div>
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
        </div><!-- /.modal -->

        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!--<script type="text/javascript" language="javascript">
		CKEDITOR.replace("message",
				{
					 height: 150
				});
		</script>
        <script type="text/javascript" language="javascript">
			$(document).on("click","#check-all",function(){
			var checked_status = this.checked;
			$(".mglr_checkbox").each(function(){
			this.checked = checked_status;
			});
			});
			$(document).on("click","#check-allmark",function(){
			$(".mglr_checkbox").each(function(){
			this.checked = true;
			});
			});
			$(document).on("click","#check-allunmark",function(){
			$(".mglr_checkbox").each(function(){
			this.checked = false;
			});
			});
			$('#delete-mail').click(function(){
				if(confirm('You are sure to delete this Mail.. Continue?')){
				$('#sent-box').submit();
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