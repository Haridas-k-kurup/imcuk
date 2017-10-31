<?php 
	include_once(DIR_ROOT.'admin/includes/header.php');
	include_once(DIR_ROOT."admin/includes/pagination.php");
	$del_id					=	$_REQUEST['del_id'];
	$phpSelf				=	SITE_ROOT.'admin/index.php?page=abuse-info&abtype='.$_GET['abtype'].'&id='.$_GET['id'];
	if($_GET['abtype'] && $_GET['id']){
		if($_GET['abtype'] == "forum"){
			$abId			=	$_GET['id'];
			$abuseSql		=	"select abuse.*, user.ud_first_name, user.ud_pofile_pic from abuse_forum as abuse left join user_details as user on abuse.reg_id = user.reg_id where abuse_id =".$abId;
			$getAbuse		=	$objAbuseForum->getRowSql($abuseSql);
			if($getAbuse['abuse_read_status'] == 0){
				$objAbuseForum->updateField(array("abuse_read_status"=>1),'abuse_id = '.$abId);
			}
			
		}else if($_GET['abtype'] == "slider"){
			$abId			=	$_GET['id'];
			$abuseSql		=	"select abuse.*, user.ud_first_name, user.ud_pofile_pic from abuse_slider as abuse left join user_details as user on abuse.reg_id = user.reg_id where abuse_id =".$abId;
			$getAbuse		=	$objAbuseSlider->getRowSql($abuseSql);
			if($getAbuse['abuse_read_status'] == 0){
				$objAbuseSlider->updateField(array("abuse_read_status"=>1),'abuse_id = '.$abId);
			}
		}
	}
	/*********** Action Area *************/
	if($_GET['del_id']){ // delete topic
		 $dlId				=	$_GET['del_id'];
		if($_GET['abtype'] == "forum"){
				if($getAbuse['dis_id']){
					include_once(DIR_ROOT.'class/forum_discussion.php');
					$objForumDis		=	new forum_discussion();
					$objForumDis->delete("dis_id=".$dlId);
					header("location:index.php?page=abuse_details&abtype=forum");
					exit;
				}else{
					include_once(DIR_ROOT.'class/forum_topics.php');
					$objForumTopic		=	new forum_topics();
					$objForumTopic->delete("topic_id=".$dlId);
					header("location:index.php?page=abuse_details&abtype=forum");
					exit;
				}
			
		}else if($_GET['abtype'] == "slider"){
					include_once(DIR_ROOT.'class/manage_pages.php');
					$objManagePage		=	new manage_pages();
					$objManagePage->delete("mp_id=".$dlId);
					header("location:index.php?page=abuse_details&abtype=slider");
					exit;
		}
		
	}
	
	if($_GET['sts_id']){ //status changing
		 $stsId				=	$_GET['sts_id'];
		if($_GET['abtype'] == "forum"){
				if($getAbuse['dis_id']){// if this is forum discussion
					include_once(DIR_ROOT.'class/forum_discussion.php');
					$objForumDis		=	new forum_discussion();
					$discusstion		=	$objForumDis->getRow('dis_id ='.$stsId,'dis_id');
						if($discusstion['dis_status']){
							$objForumDis->updateField(array("dis_status"=>0),'dis_id = '.$stsId);
						}else{
							$objForumDis->updateField(array("dis_status"=>1),'dis_id = '.$stsId);
						}
					header("location:".$phpSelf);
					exit;
				
				}else{ //else consider as forum topic
					include_once(DIR_ROOT.'class/forum_topics.php');
					$objForumTopic		=	new forum_topics();
					$fmTopic			=	$objForumTopic->getRow('topic_id ='.$stsId,'topic_id');
					if($fmTopic['topic_status']){
							$objForumTopic->updateField(array("topic_status"=>0),'topic_id = '.$stsId);
						}else{
							$objForumTopic->updateField(array("topic_status"=>1),'topic_id = '.$stsId);
						}
					header("location:".$phpSelf);
					exit;
				}
			
		}else if($_GET['abtype'] == "slider"){
					include_once(DIR_ROOT.'class/manage_pages.php');
					$objManagePage		=	new manage_pages();
					$pageInfo			=	$objManagePage->getRow('mp_id ='.$stsId,'mp_id');
					if($pageInfo['mp_status']){
							$objManagePage->updateField(array("mp_status"=>0),'mp_id = '.$stsId);
						}else{
							$objManagePage->updateField(array("mp_status"=>1),'mp_id = '.$stsId);
						}
					header("location:".$phpSelf);
					exit;
		}
		
	}
	
	/***********************************/
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
                       Abuse Message &nbsp;&nbsp;&nbsp; <i class="fa fa-arrow-circle-o-down"></i>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Abuse</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content invoice bg-red">                    
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                         <?php 
							echo $notfn->msg();
						  ?> 
                            <h2 class="page-header">
                                <i class="fa fa-globe"></i> <?php echo ucfirst($getAbuse['ud_first_name']); 
													$sentTime									= 	$getAbuse['abuse_date'];
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
                    <!-- /.row -->
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                                 <?php echo stripslashes($getAbuse['abuse']); ?>                       
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- /.row -->
                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-xs-12"><br />
                            <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>  <button class="btn btn-default"  data-toggle="modal" data-target="#compose-alert"><i class="fa fa-reply"></i> Reply</button>    
                        </div>
                    </div>
                     <!-- COMPOSE MESSAGE MODAL -->
                    <!-- /.modal -->
                </section><!-- /.content -->
                <?php
		if($_GET['abtype'] == "forum"){
			if($getAbuse['dis_id']){
			 $abuseTopicSql		=	"select disc.*, user.ud_first_name, user.ud_pofile_pic from forum_discussion as disc left join user_details as user on disc.reg_id = user.reg_id where disc.dis_id =".$getAbuse['dis_id'];
			$getContent			=	$objAbuseForum->getRowSql($abuseTopicSql);
			}else{
				 $abuseTopicSql	=	"select topic.*, user.ud_first_name, user.ud_pofile_pic from forum_topics as topic left join user_details as user on topic.reg_id = user.reg_id where topic.topic_id =".$getAbuse['topic_id'];
			$getContent			=	$objAbuseForum->getRowSql($abuseTopicSql);
			}
			if($getContent['topic_id'] || $getContent['dis_id']){
				 ?>
                
                <!--area for get imc content start-->
                <section class="content-header">
                    <h1>
                       Abuse reported forum source &nbsp;&nbsp;&nbsp; <i class="fa fa-arrow-circle-o-down"></i>
                    </h1>
                    <a href="<?php echo SITE_ROOT ?>forum_post.php?tid=<?php echo $getAbuse['topic_id']; ?>" target="_blank" class="btn btn-info pull-right" style="margin-top: -30px;">Go to the discussion</a>
                    
                </section>
                <section class="content invoice" style="border:1px solid #000;">
                                 
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-clipboard"></i> <?php echo ($getAbuse['dis_id']) ? ucfirst($getContent['ud_first_name']) : $getContent['topic'];
								
													$sentTime									= 	($getAbuse['dis_id']) ? $getContent['dis_created_on'] : $getContent['topic_created_on'] ;
													
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
                    <!-- /.row -->
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                                 <?php echo ($getAbuse['dis_id']) ? stripslashes($getContent['discussion']) : stripslashes($getContent['topic_desc']) ; ?>                       
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- /.row -->
                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-xs-12"><br />
                        <?php if($getAbuse['dis_id']){ ?>
                           <a href="<?php echo SITE_ROOT; ?>admin/index.php?page=edit_discussion&eid=<?php echo $getContent['dis_id']; ?>" class="btn btn-info pull-right"><i class="fa fa-pencil-square-o"></i> EDIT</a>
                           <?php }else{ ?>
                           <a href="<?php echo SITE_ROOT; ?>admin/index.php?page=forum_edit&eid=<?php echo $getContent['topic_id']; ?>" class="btn btn-info pull-right"><i class="fa fa-pencil-square-o"></i> EDIT</a>
                           <?php } ?>
                           
                            <button onclick="return delMesg(<?php echo ($getAbuse['dis_id']) ? $getContent['dis_id'] : $getContent['topic_id'] ?>)" style="margin-right: 5px;" class="btn btn-danger pull-right"><i class="fa fa-trash-o"></i> DELETE</button>
                            <div class="input-group-btn" style="padding-right:1%;">
                                            <button data-toggle="dropdown" class="btn <?php echo ($getContent['topic_status'] || $getContent['dis_status']) ? "btn-success" : "btn-warning" ?> dropdown-toggle pull-right" type="button"><?php echo ($getContent['topic_status'] || $getContent['dis_status']) ? "ACTIVE" : "DE-ACTIVE" ?>&nbsp;<span class="fa fa-caret-down"></span></button>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a href="javascript:;" onclick="statusChange(<?php echo ($getAbuse['dis_id']) ? $getContent['dis_id'] : $getContent['topic_id'] ?>);"><?php echo ($getContent['topic_status'] || $getContent['dis_status']) ? "DEACTIVE" : "ACTIVE" ?></a></li>
                                            </ul>
                                        </div>
                        </div>
                    </div>
                     <!-- COMPOSE MESSAGE MODAL -->
                    <!-- /.modal -->
                </section>
                <?php } } else if($_GET['abtype'] == "slider"){  // slider details
                	if($getAbuse['mp_id']){
						$abuseTopicSql		=	"select * from manage_pages where mp_id =".$getAbuse['mp_id'];
						$getContent			=	$objAbuseForum->getRowSql($abuseTopicSql);
					}
					?>
                <!--area for get imc content start-->
                <section class="content-header">
                    <h1>
                       Abuse reported page source &nbsp;&nbsp;&nbsp; <i class="fa fa-arrow-circle-o-down"></i>

                    </h1>
                    <a href="<?php echo SITE_ROOT ?>story_more.php?story=<?php echo $getAbuse['mp_id']; ?>" target="_blank" class="btn btn-info pull-right" style="margin-top: -30px;">Go to the story</a>
                </section>
                <section class="content invoice" style="border:1px solid #000;">                    
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-clipboard"></i> <?php echo $getContent['mp_heading'];
								
													$sentTime									= 	 $getContent['mp_createdon'];
													
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
                    <!-- /.row -->
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                                 <?php echo stripslashes($getContent['mp_desc']); ?>                       
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- /.row -->
                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-xs-12"><br />
                            <a href="<?php echo SITE_ROOT; ?>admin/index.php?page=manage_pages&eid=<?php echo $getContent['mp_id']; ?>" class="btn btn-info pull-right"><i class="fa fa-pencil-square-o"></i>
 EDIT</a>
                            <button onclick="return delMesg(<?php echo $getContent['mp_id']; ?>)" style="margin-right: 5px;" class="btn btn-danger pull-right"><i class="fa fa-trash-o"></i> DELETE</button>
                            <div class="input-group-btn" style="padding-right:1%;">
                                            <button data-toggle="dropdown" class="btn <?php echo ($getContent['mp_status']) ? "btn-success" : "btn-warning" ?> dropdown-toggle pull-right" type="button"><?php echo ($getContent['mp_status']) ? "ACTIVE" : "DEACTIVE" ?>&nbsp;<span class="fa fa-caret-down"></span></button>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a href="javascript:;" onclick="statusChange(<?php echo $getContent['mp_id']; ?>)"><?php echo ($getContent['mp_status']) ? "DEACTIVE" : "ACTIVE" ?></a></li>
                                            </ul>
                                        </div>
                        </div>
                    </div>
                     <!-- COMPOSE MESSAGE MODAL -->
                    <!-- /.modal -->
                </section>
                
                <?php } ?>
                <!-- area for get imc content end -->
               
                
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <!-- COMPOSE NOTICE MODAL -->
<div class="modal fade" id="compose-alert" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:850px !important;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-envelope-o"></i> Compose New Message</h4>
      </div>
      <form action="mail_action.php?act=sendNotice" method="post">
        <div class="modal-body">
          <!--<div class="form-group">
            <div class="row">
              <div class="col-sm-6">
                <div class="input-group bg-gray"> <span class="input-group-addon">Select All:</span>
                  <input type="checkbox" class="form-control" name="notice_all" value="1" />
                </div>
              </div>
              <div class="col-sm-6">
                <div class="input-group"> <span class="input-group-addon">Select Category:</span>
                  <select  name="notice_to" class="form-control">
                    <option value="">--- Select ---</option>
                    <option value="1">Medical Related Professionals</option>
                    <option value="2">Medical Organizations</option>
                    <option value="3">Patient(Non Medical Persons)</option>
                  </select>
                </div>
              </div>
            </div>
          </div>-->
          <div class="form-group">
            <div class="input-group"> <span class="input-group-addon">Subject:</span>
              <input id="notice_subject" name="notice_subject" type="text" class="form-control" placeholder="Sbject" required>
            </div>
          </div>
          <div class="form-group">
            <textarea id="notice_message" name="notice_message" class="form-control ckeditor" placeholder="Message" ></textarea>
          </div>
        </div>
        <div class="modal-footer clearfix">
        <input type="hidden" name="send-ind-user" value="<?php echo $getAbuse['reg_id']; ?>" />
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
          <button type="submit" class="btn btn-primary pull-left"><i class="fa fa-envelope"></i> Send Notice</button>
          <button type="button" id="save-user-draft" class="btn btn-info pull-left"><i class="fa fa-pencil-square-o"></i> Save Draft</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
<!-- /.modal -->
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
				//alert(url);
				if(confirm('You are sure to delete this message.. Continue?')){
					window.location.href	=	url;
				}
			}
		</script>
        <script type="text/javascript" language="javascript">
        	function statusChange(e){
				var	url						=	'<?php echo $phpSelf ?>&sts_id='+e;
				//alert(url);
				if(confirm('You are sure to change status.. Continue?')){
					window.location.href	=	url;
				}
			}
        </script>
        <script type="text/javascript" language="javascript">
			$('#save-user-draft').click(function(){
				var dfsubject		=	$('#notice_subject').val();
				var dfmessage		=	$('#notice_message').val();
				var dfact			=	"userDraft";
				var dataString 		= 	'df_subject='+dfsubject+'&df_message='+dfmessage+'&udf_act='+dfact;
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
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

    </body>
</html>