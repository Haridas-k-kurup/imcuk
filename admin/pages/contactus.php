<?php 
	include_once(DIR_ROOT.'admin/includes/header.php');
	$conType			=	$objCommon->esc($_GET['type']);
	$delAllId			=	$_REQUEST['del_id'];
	if(!$conType || ($conType == 3 && $adminType == 2)){
		header('location:'.SITE_ROOT."admin/index.php?page=dashboard");
	}
	include_once(DIR_ROOT."admin/includes/pagination.php");
	$phpSelf			=	SITE_ROOT.'admin/index.php?page=contactus&type='.$conType;
	//$userDtils		=	$objConForm->getAll('contact_type_id = "'.$conType.'"','contact_id desc');
	if(count($delAllId) >0){
		foreach($delAllId as $delId)
		if($adminType == 1){ 
			$objConForm->delete('contact_id = "'.$delId.'"');
		}else{
			$objConForm->updateField(array('staff_delete' => 1),'contact_id = "'.$delId.'"');
		}
		header('location:'.$phpSelf);
	}
?>
<style>
	.unread {
		font-weight:bold !important;
		color:#090 !important;
	}
</style>
<script type="text/javascript" src="<?php echo SITE_ROOT; ?>ckeditor/ckeditor.js"></script>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
             <?php include_once('includes/sidemenubar.php'); ?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header no-margin">
                    <h1 class="text-center">
                     Contact Us
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
                                        <!-- /.col (LEFT) -->
                                        <div class="col-md-12 col-sm-12">
                                            <div class="row pad">
                                                <div class="col-sm-6">
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" id="check-all"/>
                                                    </label>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                                            Action <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="javascript:;" id="delete-contact">Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 search-form">
                                                    <form action="#" class="text-right">
                                                        <div class="input-group">  
                                                        <input type="hidden" value="contactus" name="page">
                                                        <input type="hidden" value="<?php echo $conType; ?>" name="type">                                                          
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
                                                 <form method="get" id="contact-us">
                                					<input type="hidden" value="contactus" name="page" />
                                                    <input type="hidden" name="type" value="<?php echo $conType; ?>" />
                                                <table class="table table-mailbox">
                                                <?php
													/*-----------Pagination start----------------*/
													$num_results_per_page 	 					=	($_GET['new_view'])?$_GET['new_view']:12;
													$num_page_links_per_page 					= 	5;
													$pg_param 									= 	"";
													if($adminType == 1){
														if($search){
															$sql_pagination 					= 	"select * from contact_us_form where (contact_name like '%".$search."%' or contact_email like '%".$search."%' or contact_ip  like '%".$search."%' or contact_subject  like '%".$search."%') and contact_type_id = '".$conType."' and contact_status = 1 order by contact_id desc";
														}else{
															 $sql_pagination 					= 	 "select * from contact_us_form where contact_type_id = '".$conType."' and contact_status = 1 order by contact_id desc";		 	
														}
													}else{
														if($search){
															$sql_pagination 					= 	"select * from contact_us_form where (contact_name like '%".$search."%' or contact_email like '%".$search."%' or contact_ip  like '%".$search."%' or contact_subject  like '%".$search."%') and contact_type_id = '".$conType."' and staff_delete = 0 and contact_status = 1 order by contact_id desc";
														}else{
															 $sql_pagination 					= 	 "select * from contact_us_form where contact_type_id = '".$conType."' and staff_delete = 0 and contact_status = 1 order by contact_id desc";		 	
														}
													}
													$pagesection								=	'';
													pagination($sql_pagination, $num_results_per_page, $num_page_links_per_page, $pg_param,$pagesection);
													$page_list									=	$objConForm->listQuery($paginationQuery);
													$countpageList								=	mysql_num_rows(mysql_query($sql_pagination));
													if(count($page_list) >0){
														$count									=	1;
														foreach($page_list as $all){
													/*-----------Pagination End----------------*/
													$sentTime									= 	$all['contact_created'];
													$timeObj									=	new DateTime($sentTime);
													$dateSent									=	$timeObj->format('m-d-y');
													$currentDate								=	date("m-d-y");
													if($currentDate > $dateSent){
														$showTime								=	$dateSent;
													}else{
														$showTime								=	$timeObj->format('H:i A');
													}
													?>
													<tr class="<?php   if($all['staff_delete'] == 1){ echo 'alert-warning';}else if($all['reply_status'] == 1){ echo 'alert-success'; } ?> <?=($all['read_status'] == 0)? 'unread' : ''?> sfdsf" >
                                                        <td class="small-col"><input type="checkbox" class="mglr_checkbox read_checkbox"  value="<?php echo $all['contact_id']?>" name="del_id[]"/></td>
                                                        <td class="small-col" title="<?php echo $all['contact_ip'];?>"><i class="fa fa-globe"></i></td>
                                                        <td class="name"><a href="<?php echo SITE_ROOT; ?>admin/index.php?page=contact_read&cid=<?php echo $all['contact_id'] ?>"><?php echo $all['contact_name'];?></a></td>
                                                        <td class="subject"><a href="<?php echo SITE_ROOT; ?>admin/index.php?page=contact_read&cid=<?php echo $all['contact_id'] ?>"  data-toggle="tooltip" data-original-title="IP Address: <?php echo $all['contact_ip'];?>"><?php echo substr(stripslashes($all['contact_subject']),0,200); ?></a></td>
                                                        <td class="time"><?php echo $showTime; ?></td>
                                                    </tr>
													<?php  } }else{ ?>
                                                    <tr class="unread">
                                                        <td colspan="5">Sorry ! No feedback exist</td>
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
        <script type="text/javascript" language="javascript">
			$('#check-all').click(function(){
					var checkStatus		=	this.checked;
					$('.mglr_checkbox').each(function() {
                        this.checked	=	checkStatus;
                    });
				});
		</script>
        <script type="text/javascript" language="javascript">
			$('#delete-contact').click(function(){
					$('#contact-us').submit();
				});
		</script>
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