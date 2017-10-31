<?php
include_once(DIR_ROOT."admin/includes/header.php");
include_once(DIR_ROOT."admin/includes/pagination.php");
include_once(DIR_ROOT."class/manage_category.php");
include_once(DIR_ROOT."class/forum_topics.php");
include_once(DIR_ROOT."class/forum_discussion.php");
include_once(DIR_ROOT."class/user_delete_content_info.php");
$objCat				=	new manage_category();
$objForum			=	new forum_topics();
$objDiscus			=	new forum_discussion();
$obj_del_con		=   new user_delete_content_info();
if(isset($_GET['dept'])){
	$pageId			=	$objCommon->esc($_GET['dept']);
	$pageDtils		=	$objImcPage->getRow('page_id = "'.$pageId.'"');
}
$search				=	$objCommon->esc($_REQUEST['search_field']);
$sid				=	$objCommon->esc($_GET['sid']);
$del_id				=	$_REQUEST['del_id'];
$phpSelf			=	SITE_ROOT.'admin/index.php?page=list_medical_forum&dept='.$pageId;
if(count($del_id)>0){
	if($adminType	==	1){
	foreach($del_id as $all_del_id){
		$objForum->delete("topic_id=".$all_del_id);	
	}
	}else{
	foreach($del_id as $all_del_id){
		$forum_info				= $objForum->getRow('topic_id = "'.$all_del_id.'"');
		$objForum->updateField(array("topic_staff_manage" =>1),"topic_id = ".$all_del_id);	
		$_POST['user_id']		= $_SESSION['adminid'];
		$_POST['heading']		= $forum_info['topic'];
		$_POST['link']			= SITE_ROOT.'admin/index.php?page=forum_edit&eid='.$all_del_id;
		$_POST['status']		= 1;
		$obj_del_con->insert($_POST);
	}	
	}
	$notfn->add_msg("Forum Topic has been removed successfully...!",3);
	header("location:".$phpSelf);
}
if($sid){ 
	$editData		=  $objForum->getRow("topic_id =".$sid, "topic_id");	
	if($editData['topic_status'] == 0){
		$objForum->updateField(array("topic_status"=>1),"topic_id	=".$sid);
	}else{
		$objForum->updateField(array("topic_status"=>0),"topic_id 	=".$sid);
	}
	header("location:".$phpSelf);
}
/*-----------Recover content from staff start----------------------------*/
if(isset($_GET['dsid']) && $_GET['dsid'] > 0 && $adminType == 1){
	$topicID				=	$objCommon->esc($_GET['dsid']);
	$objForum->updateField(array("topic_staff_manage"=>0),"topic_id =".$topicID);
	$notfn->add_msg("Forum Topic has been Recovered...!",3);
	header("location:".$phpSelf);
}
/*-----------Recover content from staff end----------------------------*/

/*-----------control form Discussion Start----------------------------*/
if(isset($_GET['forsid'])){ 
	$disId			=  $_GET['forsid'];
	$dissData		=  $objDiscus->getRow("dis_id =".$disId, "dis_id");	
	if($dissData['dis_status'] == 0){
		$objDiscus->updateField(array("dis_status"=>1),"dis_id	=".$disId);
	}else{
		$objDiscus->updateField(array("dis_status"=>0),"dis_id 	=".$disId);
	}
	header("location:".$phpSelf);
}
if(isset($_GET['discus_id']) &&  count($_GET['discus_id']) > 0){ 
	$discusIds		=	$_GET['discus_id'];
	if($adminType	==	1){
	foreach($discusIds as $all_del_id){
		$objDiscus->delete("dis_id=".$all_del_id);	
	}
	}else{
	foreach($discusIds as $all_del_id){
		$objDiscus->updateField(array("dis_staff_manage" =>1),"dis_id = ".$all_del_id);	
	}	
	}
	$notfn->add_msg("Forum Discussion has been removed successfully...!",3);
	header("location:".$phpSelf);
}
/*-----------Recover content from staff start----------------------------*/
if(isset($_GET['frm_dsid']) && $_GET['frm_dsid'] > 0 && $adminType == 1){
	$recoverID				=	$objCommon->esc($_GET['frm_dsid']);
	$objDiscus->updateField(array("dis_staff_manage"=>0),"dis_id =".$recoverID);
	$notfn->add_msg("Discussion has been Recovered...!",3);
	header("location:".$phpSelf);
}
/*-----------Recover content from staff end----------------------------*/
/*-----------control form Discussion End----------------------------*/
?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <?php include_once('includes/sidemenubar.php'); ?>
  
      
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                       List All I M C <?php echo $objCommon->esc($pageDtils['page_name']); ?> Forums
                        <small>International Medical Connection</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">I M C <?php echo $objCommon->esc($pageDtils['page_name']); ?> Page</a></li>
                        <li class="active">List All I M C <?php echo $objCommon->esc($pageDtils['page_name']); ?> Forums</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                      <?php 
						echo $notfn->msg();
						?> 
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">List Medical Forums</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="row">
                                	<div class="col-lg-6">
                                    <!--<div class="input-group margin">
                                        <input type="text" class="form-control">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-flat">Go!</button>
                                        </span>
                                    </div>-->
                                    </div>
                                    <div class="col-lg-6">
                                    	<div class="input-group margin pull-right">
                                    		<button class="btn btn-danger btn-sm" id="delete-all">Delete All</button>
                                    	</div>
                                    </div>
                                </div>
                                <div class="box-body table-responsive">
                                <form method="get" id="forum-details">
                                 <input type="hidden" value="list_medical_forum" name="page" />
                                  <input type="hidden" value="<?php echo $pageId; ?>" name="dept" />
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="1%"><input type="checkbox" name="checkbox" class="checkall" id="checkbox"></th>
                                                <th width="10%">Posted By</th>
                                                <th width="24%">Heading</th>
                                                <th width="25%">Description</th>
                                                <th width="14%">Uploaded Date</th>
                                                <th width="7%">Uploaded IP</th>
                                                <th width="19%">Action</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                     <?php
/*-----------Pagination start----------------*/
$num_results_per_page 	 		=	($_GET['new_view'])?$_GET['new_view']:10;
$num_page_links_per_page 		= 	5;
$pg_param 						= 	"";
if($search){
	if($adminType == 1){
	$sql_pagination 			= 	"SELECT forum.*, user.ud_name_title, user.ud_first_name FROM forum_topics AS forum LEFT JOIN user_details AS user ON forum.reg_id = user.reg_id WHERE forum.page_id = '".$pageId."' AND (forum.topic LIKE '".$search."%' OR user.ud_first_name LIKE '%".$search."%') ORDER BY forum.topic_id DESC";
	}else{
	$sql_pagination 			= 	"SELECT forum.*, user.ud_name_title, user.ud_first_name FROM forum_topics AS forum LEFT JOIN user_details AS user ON forum.reg_id = user.reg_id WHERE forum.page_id = '".$pageId."' AND forum.topic_staff_manage = 0 AND (forum.topic LIKE '".$search."%' OR user.ud_first_name LIKE '%".$search."%') ORDER BY forum.topic_id DESC";
	}
}else{
	if($adminType == 1){
	 $sql_pagination 			= 	"SELECT forum.*, user.ud_name_title, user.ud_first_name FROM forum_topics AS forum LEFT JOIN user_details AS user ON forum.reg_id = user.reg_id WHERE forum.page_id = '".$pageId."' ORDER BY forum.topic_id DESC";
	}else{
		 $sql_pagination 		= 	"SELECT forum.*, user.ud_name_title, user.ud_first_name FROM forum_topics AS forum LEFT JOIN user_details AS user ON forum.reg_id = user.reg_id WHERE forum.page_id = '".$pageId."' AND forum.topic_staff_manage = 0 ORDER BY forum.topic_id DESC";
	}
}
$pagesection					=	'';
pagination($sql_pagination, $num_results_per_page, $num_page_links_per_page, $pg_param,$pagesection);
$page_list						=	$objForum->listQuery($paginationQuery);
$countpageList					=	mysql_num_rows(mysql_query($sql_pagination));
if(count($page_list) >0){
	$count=	1;
	foreach($page_list as $all){
/*-----------Pagination End----------------*/
?>
                                       
                                            <tr>
                                                <td><input type="checkbox" name="del_id[]" value="<?php echo $all['topic_id']?>" class="mglr_checkbox"></td>
                                                <td><?php
												  if($all['ud_name_title']){
												  echo	$names		=	$all['ud_name_title']." : ".$all['ud_first_name'];
												  }else{
												  echo $names		=	$all['ud_name_title']." : ".$all['ud_first_name'];
												  }
												 
												  ?></td>
                                                <td><?php echo strip_tags(substr($all['topic'],0,75)); ?></td>
                                                <td><?php echo substr(strip_tags($all['topic_desc']),0,75); ?> </td>
                                                <td><?php echo $all['topic_created_on'];?></td>
                                                <td><?php echo $all['topic_ip'];?></td>
                                                <td>
                                                <?php if($adminType == 1 && $all['topic_staff_manage'] == 1){ ?> 
                          <a class="tiptip outer_admin_action" href="<?php echo $phpSelf?>&dsid=<?php echo $all['topic_id']?>" >
                          <img  src="<?php echo SITE_ROOT; ?>admin/img/question.png" title="Deleted from Sub-Admin">
                          </a>
                          <?php }else{ ?>  
												<a class="tiptip outer_admin_action" href="<?php echo $phpSelf?>&sid=<?php echo $all['topic_id']?>">
                        	<?php if($all['topic_status'] == 1){ ?>
							<img  src="img/icon_green_dot.png" title="Clik to deactivate">
                            <?php }else{ ?>
                            <img src="img/red_dot.png" title="Clik to activate">
                            <?php } ?>
						</a>
                        <?php } ?>
                        <a class="tiptip outer_admin_action" href="<?php echo SITE_ROOT?>admin/index.php?page=forum_edit&dept=<?php echo $pageId; ?>&eid=<?php echo $all['topic_id']?>" title="Edit">
                        <img src="<?php echo SITE_ROOT ?>admin/images/edit.png" title="Edit this topic" >
						</a>
						<a class="tiptip outer_admin_action" href="javascript:;" title="Delete" onclick="return del(<?php echo $all['topic_id'];?>);">
							<span class="inner_admin_action admin_action_delete"><i class="fa fa-trash-o"></i></span>
						</a> 
                        <a class="tiptip outer_admin_action" href="javascript:;" title="View Topic Discussion" onclick="return showForumDis(<?php echo $all['topic_id'];?>);">
							<span class="inner_admin_action admin_action_delete"><img id="forum-view-icon<?php echo $all['topic_id'];?>" src="<?php echo SITE_ROOT ?>admin/img/arrow_down.png" title="View Topic Discussion" ></span>
						</a>
                                                </td>
                                            </tr>
                                            <!-- Forum discussion start-->
                                       		<tr class="forum-diss-wrapp" id="forum-wrap-<?php echo $all['topic_id'] ?>">
                                            	<td colspan="7">
                                                	<table id="example2" class="table table-bordered alert-warning table-striped dataTable">
                                                        <thead>
                                                            <tr class="alert-info">
                                                                <th width="10%">Replied By</th>
                                                                <th width="50%">Reply Details</th>
                                                                <th width="14%">Uploaded Date</th>
                                                                <th width="14%">Uploaded IP</th>
                                                                <th width="10%">Action</th>
                                                            </tr>
                                                        </thead>
                                                       <tbody>
                                                       <?php 
													    $topicId					=	$all['topic_id'];
													   if($adminType == 1){
															 $sql_discussion		= 	"SELECT disc.*, user.ud_name_title, user.ud_first_name FROM forum_discussion AS disc LEFT JOIN forum_topics AS forum ON disc.topic_id = forum.topic_id LEFT JOIN user_details AS user ON disc.reg_id = user.reg_id WHERE forum.page_id = '".$pageId."' AND disc.topic_id = '".$topicId."' ORDER BY disc.dis_id DESC";
															 
															}else{
																 $sql_discussion	= 	"SELECT disc.*, user.ud_name_title, user.ud_first_name FROM forum_discussion AS disc LEFT JOIN forum_topics AS forum ON disc.topic_id = forum.topic_id LEFT JOIN user_details AS user ON disc.reg_id = user.reg_id WHERE forum.page_id = '".$pageId."' AND disc.topic_id = '".$topicId."' AND disc.dis_staff_manage = 0 ORDER BY disc.dis_id DESC";
															}
													   		$allDissusion			=	$objDiscus->listQuery($sql_discussion);
															if(count($allDissusion) >0){
															foreach($allDissusion as $discussion){
													    ?>
                                                       	<tr>
                                                                <td>
																<?php
												  if($discussion['ud_name_title']){
												  	echo $names		=	$discussion['ud_name_title']." : ".$discussion['ud_first_name'];
												  }else{
												  	echo $names		=	$discussion['ud_name_title']." : ".$discussion['ud_first_name'];
												  }
												  ?>
                                                  </td>
                                                                <td><?php echo strip_tags(substr($discussion['discussion'],0,75)); ?></td>
                                                                <td><?php echo $discussion['dis_created_on']; ?></td>
                                                                <td><?php echo $discussion['dis_ip']; ?></td>
                                                                <td>
                                                <?php if($adminType == 1 && $discussion['dis_staff_manage'] == 1){ ?> 
                                                  <a class="tiptip outer_admin_action" href="<?php echo $phpSelf; ?>&frm_dsid=<?php echo $discussion['dis_id']; ?>" >
                                                  <img  src="<?php echo SITE_ROOT; ?>admin/img/question.png" title="Deleted from Sub-Admin">
                                                  </a>
                                                  <?php }else{ ?>  
                                                        <a class="tiptip outer_admin_action" href="<?php echo $phpSelf?>&forsid=<?php echo $discussion['dis_id']; ?>">
                                                    <?php if($discussion['dis_status'] == 1){ ?>
                                                    <img  src="img/icon_green_dot.png" title="Clik to Deactivate">
                                                    <?php }else{ ?>
                                                    <img src="img/red_dot.png" title="Clik to Activate">
                                                    <?php } ?>
                                                </a>
                                                <?php } ?>
                                                <a class="tiptip outer_admin_action" href="<?php echo SITE_ROOT?>admin/index.php?page=edit_discussion&dept=<?php echo $pageId; ?>&eid=<?php echo $discussion['dis_id']; ?>" title="Edit">
                                                <img  src="<?php echo SITE_ROOT ?>admin/images/edit.png" title="Edit this topic" >
                                                </a>
                                                <a class="tiptip outer_admin_action" href="javascript:;" title="Delete" onclick="return disussionDel(<?php echo $discussion['dis_id']; ?>);">
                                                    <span class="inner_admin_action admin_action_delete"><i class="fa fa-trash-o"></i></span>
                                                </a> 
                        
                                                </td>
                                                        </tr>
                                                        <?php } }else{ ?>
                                                        <tr>
                                                            <td colspan="7">
                                                                <p class="alert-warning">Sorry ! No Discussion Found</p>
                                                            </td>
                                                         </tr>
                                                        <?php } ?>
                                                       </tbody>
                                                   </table>
                                                </td>
                                            </tr>
                                            <!-- Forum discussion start-->
                                     <?php } 
									
									 }else{ ?>  
                                     <tr>
                                     	<td colspan="7">
                                        	<p class="alert-warning">Sorry ! No Topic Found</p>
                                        </td>
                                     </tr>
                                     <?php } ?>
                                      </tbody> 
                                    </table>
                                    </form>
                                    <?php include_once(DIR_ROOT."admin/includes/pagination_div.php"); ?> 
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                            <!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
       
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- page script -->
        <script type="text/javascript">
		/*Check all*/	
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
				
            });
        </script>
       
        <script type="text/javascript" language="javascript">
		function changeViewCount(newCount){
			window.location.href='<?php echo $phpSelf ?>&new_view='+newCount;
		}
		// delete forum
		function del(id){ 
				if(confirm("Are you sure to delete this  Topic !")){
				var urls	=	"<?php echo $phpSelf ?>&del_id[]="+id;
				window.location.href=urls;
			}
		}
		// delete disuccsion
		function disussionDel(id){ 
				if(confirm("Are you sure to delete this  selected item !")){
				var urls	=	"<?php echo $phpSelf ?>&discus_id[]="+id;
				window.location.href=urls;
			}
		}
		</script>
        <script type="text/javascript" language="javascript">
			$(document).on("click","#checkbox",function(){
			var checked_status = this.checked;
			$(".mglr_checkbox").each(function(){
			this.checked = checked_status;
			});
			});
			$('#delete-all').click(function(){
				if(confirm('You are sure to delete this Topic.. Continue?')){
				$('#forum-details').submit();
				}
				});
		</script>
		<script type="text/javascript" language="javascript">
			function showForumDis(fid){
				if(fid){
					var wrapId		=	"#forum-wrap-"+fid; 
					var iconId		=	"#forum-view-icon"+fid;
					if( $(wrapId).is(':visible') === true){
						$(wrapId).slideUp();
						$(iconId).attr("src","<?php echo SITE_ROOT; ?>admin/img/arrow_down.png");
					}else{
						$(wrapId).slideDown();
						$(iconId).attr("src","<?php echo SITE_ROOT; ?>admin/img/arrowup.png");
					}
				}
			}
		</script>
    </body>
</html>