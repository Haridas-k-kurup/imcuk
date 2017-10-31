<?php 
	include_once('includes/header.php');
	include_once(DIR_ROOT."class/forum_discussion.php");
	include_once(DIR_ROOT."class/group_info.php");
	include_once(DIR_ROOT.'class/group_members.php');
	include_once(DIR_ROOT.'class/group_messages.php');
	include_once(DIR_ROOT."class/group_replys.php");
	include_once(DIR_ROOT.'class/group_message_disply_status.php');
	include_once(DIR_ROOT.'class/user_details.php');
	$objDiscuss		=	new forum_discussion();
	$objGroup		=	new group_info();
	$objMember		=	new group_members();
	$objGmsg		=	new group_messages();
	$objGreply		=	new group_replys();
	$objGmsgDisply	=	new group_message_disply_status();
	$objUser		=	new user_details();
	$msgId			=	$_GET['message'];
	if($sessionval	==	false){
		header('location:index.php');
	}else{
		$userQuery	=	"select reg.*, user.*, prof.*, org.*, pat.* from registration_details as reg left join user_details as user on reg.reg_id = user.reg_id left join user_professionals_details as prof on reg.reg_id = prof.reg_id left join user_organizations_details as org on reg.reg_id = org.reg_id left join user_patient_details as pat on reg.reg_id = pat.reg_id where reg.reg_id='".$activeMem."' and reg.reg_status = 1";
		$userData	=	$objReg->getRowSql($userQuery);
		//GET GROUP COUNT
		$groupCount	=	$objMember->count('reg_id = "'.$activeMem.'"');
	}
?>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<!--tab javascript start-->
<link rel="stylesheet" href="tab-css/style.css"> <!-- Resource style -->
<script src="tab-js/modernizr.js"></script> <!-- Modernizr -->
<div class="imc-sheet">
	<div class="proff-wrapper">
    	<div class="proff-left fl">
        	<?php include_once('includes/profile_left.php'); ?>
        </div>
        <div class="proff-right fl">
        		<div class="proff-right-wrap">
<div class="message-list-cover">

	<div class="mail-list-areas">
     <?php   $msgQuery		=	"select msg.*,user.reg_id, user.ud_name_title,user.ud_first_name, user.ud_pofile_pic from group_messages as msg left join group_members as mem on msg.group_id = mem.group_id left join user_details as user on mem.reg_id = user.reg_id where msg.gmsg_id= '".$msgId."' and user.reg_id = '".$activeMem."' and msg.gmsg_status = 1"; 
	 		  $myMesg		=	 $objGmsg->getRowSql($msgQuery); 
			
			if($myMesg['gmsg_id']){
			$status			=	$objGmsgDisply->count('gmsg_id ="'.$myMesg['gmsg_id'].'" and group_m_id="'.$activeMem.'"');
			if($status == 0){
	 ?>
     
    	<div class="mail-control-area ovr">
        	<table width="100%" class="mail-control-table">
            	<tr>
                    <td width="10%"><a href="javascript:;" class="mail-control-menu" onclick="return delMsg(<?php echo $msgId; ?>);" title="DELETE"><i class="fa fa-trash"></i>
</a></td>  
                    <td width="10%"><a href="javascript:;" class="mail-control-menu" title="REFRESH" id="refresh-btn" ><i class="fa fa-refresh"></i>

</a></td>
                    <td></td>
                </tr>
            </table>
        </div>
    	<table class="mailbox-table">
        	<tr>
            	<td>
                	<div class="show-mail ovr">
                    	<div class="mail-from-details ovr fl">
                        	<div class="mailer-image ovr">
                            	 <?php
								 $userDtil	=	$objUser->getRow('reg_id = "'.$myMesg['gmsg_from'].'"');
								  if($userDtil['ud_pofile_pic']){
							 
							$profPic	=  "profiles/".stripslashes($userDtil['ud_pofile_pic']);
							if(file_exists($profPic)){
						?>
                            <img src="<?php echo SITE_ROOT.$profPic; ?>" width="100%" >
                            <?php } else{ ?>
                            <img src="<?php echo SITE_ROOT; ?>images/profile.jpg" width="100%" >
                            <?php }  }else{ ?>
                            <img src="<?php echo SITE_ROOT; ?>images/profile.jpg" width="100%" >
                            <?php } ?>
                            </div> 
                        </div>
                        <div class="mail-details-area fl">
                        	<div class="mail-header-action">
                            <?php 
								
								if($userDtil['reg_id'] == $activeMem){
									$from	=	"Me";
									}else if($userDtil['ud_name_title']){
									$from	=	$userDtil['ud_name_title'].": ".$userDtil['ud_first_name'];
									}else{
									$from	=	$userDtil['ud_first_name'];
									}
							 ?>
                            	<label class="mail-from-label"><?php echo $from; ?>&nbsp;&nbsp;&nbsp;(<?php echo date("y-M-d", strtotime($myMesg['gmsg_created_on'])); ?>)</label>
                                <a href="javascript:;" class="mail-reply-btn fr" title="REPLY" onclick="return getReply(<?php echo $myMesg['gmsg_id']; ?>);"><i class="fa fa-reply"></i></a>
                            </div>
                            <div class="mail-deteils-more">
                            	<p><?php echo stripslashes($myMesg['gmsg_body']); ?></p>
                            </div>
                             <?php if($myMesg['gmsg_attachment']){ ?>
                        <div class="mail-attachment-area ovr">
                       	 	<a href="<?php echo SITE_ROOT; ?>download.php?item=<?php echo $myMesg['gmsg_attachment']; ?>" title="<?php echo $myMesg['gmsg_attachment']; ?>"><img src="img/downloadicon.png" /></a>
                        </div>
                        <?php } ?>
                        </div>
                         
                    </div>
                    <div class="reply-area" id="main-reply">
                    	
                    </div>
                </td>
            </tr>
            <?php 
			$replySql		=	"select reply.*, user.ud_name_title,user.ud_first_name, user.ud_pofile_pic from group_replys as reply left join user_details as user on reply.greply_from = user.reg_id where reply.gmsg_id 	= '".$myMesg['gmsg_id']."' and  reply.greply_status = 1 order by reply.greply_id asc"; 
			$allReply		=	$objGreply->listQuery($replySql);
				foreach($allReply as $reply){
			 ?> 
            <tr>
            	<td>
                	<div class="show-mail ovr">
                    	<div class="mail-from-details ovr fl">
                        	<div class="mailer-image ovr">
                            	<?php if($reply['ud_pofile_pic']){
							 
							$profPic	=  "profiles/".stripslashes($reply['ud_pofile_pic']);
							if(file_exists($profPic)){
						?>
                            <img src="<?php echo SITE_ROOT.$profPic; ?>" width="100%" >
                            <?php } else{ ?>
                            <img src="<?php echo SITE_ROOT; ?>images/profile.jpg" width="100%" >
                            <?php }  }else{ ?>
                            <img src="<?php echo SITE_ROOT; ?>images/profile.jpg" width="100%" >
                            <?php } ?>
                            </div> 
                        </div>
                        <div class="mail-details-area fl">
                        	<div class="mail-header-action">
                             <?php 
								if($reply['greply_from'] == $activeMem){
									$from	=	"Me";
									}else if($reply['ud_name_title']){
									$from	=	$reply['ud_name_title'].": ".$reply['ud_first_name'];
									}else{
									$from	=	$reply['ud_first_name'];
									}
							 ?>
                            	<label class="mail-from-label"><?php echo $from; ?>&nbsp;&nbsp;&nbsp;(<?php echo date("y-M-d", strtotime($reply['greply_created_on'])); ?>)</label>
                                <a href="javascript:;" class="mail-reply-btn fr" title="REPLY" onclick="return getMoreReply(<?php echo $reply['greply_id']; ?>, <?php echo $myMesg['gmsg_id']; ?>);"><i class="fa fa-reply"></i></a>
                            </div>
                            <div class="mail-deteils-more">
                            	<p><?php echo stripslashes($reply['greply_body']); ?></p>
                            </div>
                             <?php if($reply['greply_attachment']){ ?>
                        <div class="mail-attachment-area ovr">
                       	 	<a href="<?php echo SITE_ROOT; ?>download.php?item=<?php echo $reply['greply_attachment']; ?>" title="<?php echo $reply['greply_attachment']; ?>"><img src="img/downloadicon.png" /></a>
                        </div>
                        <?php } ?>
                        </div> 
                        
                    </div>
                    <div class="reply-area" id="main-reply<?php echo $reply['greply_id']; ?>"></div>
                </td>
            </tr>
            <?php } ?>
        </table>
        <?php }else{
			header('location:mail_list.php');
		}
		
		 }else{
			header('location:mail_list.php');
		}?>
    </div>

</div>    

                </div>
                <!--SEND MAIL BOX HERE START-->
                	<div class="mail_box_wrapper ovr">
                    	
                    </div>
                <!--SEND MAIL BOX HERE END-->
                 <!--CREATE GROUP BOX HERE START-->
                <div class="pro-popup ovr">
                	
                </div>
                <!--CREATE GROUP BOX HERE END-->   
        </div>
        <div class="clear"></div>
    </div>
  </div>  
  <!--end--> 
   <?php include_once('includes/footer.php'); ?>
   </div>
   <script type="text/javascript" language="javascript">
   function loadFrame(){
			$('.proff-pic-area').slideUp(1000);
			$('.change-image_wrap').slideDown(1000);
		}
   </script>
   <script language="javaScript" type="text/javascript">
$("#attachmentFile").on('change',function(){
	if($("#attachmentFile").val()!=""){
		$('.upload').hide();
		$('#imageloadstatus').fadeIn(1000);
		setTimeout(function(){
			$("#attachmentFile").upload('ajax/add_profile_upload.php', function(res) {
				$('#imageloadstatus').hide();
				$('.browse-btn-wrap').slideUp(1000);
				if(res!=""){
					$("#attachmentFile").hide();
					$("#preview").html(res);
					$('#cancel-window').hide();
					//$("#fileName").val('');
				}
				else{
					alert("Sorry your image is not uploaded Properly. Please fill mandatory fields and try again !");
				}
			});
		},3000);
	}
});
function deleteAttachment(filename,curr){
	if(filename!=""){
		$('.imageloadstatus').fadeIn(1000);
		//$.get("access/delete_attachment.php",{fileName:filename,<?php if($id){?>schemeId:<?php echo $id;}?>},function(data){
			//if(data=="success"){
			//	$(curr).parent().parent().parent().parent().parent().remove();
			//}
		//});
	}
}
</script>
<script type="text/javascript" language="javascript">
 $('#compose').click(function(){
	 	$.ajax({
				type:"POST",
				url:"ajax/mail_compose.php",
				cache:false,
				success:function(data){
					$(".mail_box_wrapper").html(data);
				}
				
			});
	 });
	 
 </script>
 <script type="text/javascript" language="javascript">
 $('#create-group').click(function(){// GET CREATE GROUP POPUP
	 	$('.popup_wrapper').show();
		$('.pro-popup').show();
		var preload		=	'<img src="img/small.gif" class="preloadersmall" />';
		$('.pro-popup').html(preload);
		$.ajax({
				type:"POST",
				url:"ajax/create_group_box.php",
				cache:false,
				success:function(data){
					$(".pro-popup").html(data);
				}
			});
	 	
	 });
	 
 </script>
<script type="text/javascript" language="javascript">
 function getReply( to ){
	 if(to){
	var dataString	=	"to="+to;
 	$.ajax({
			type:"POST",
			url:"ajax/get_groupreplybox.php",
			data:dataString,
			cache:false,
			success:function(data){
				
				$("#main-reply").html(data);
			}
			});
	 }
 }
 </script>
 <script type="text/javascript" language="javascript">
 function getMoreReply(dis, to){
	 if(to){
	var dataString	=	"to="+to;
	var mainreply	=	"#main-reply"+dis;
 	$.ajax({
			type:"POST",
			url:"ajax/get_groupreplybox.php",
			data:dataString,
			cache:false,
			success:function(data){
				
				$(mainreply).html(data);
			}
			});
	 }
 }
 </script>
 <script type="text/javascript" language="javascript">
 	function delMsg(ms){
		if(ms){
			var act			=	"gdelete";
			var dataString	=	"gmsg="+ms+"&act="+act;
			
			$.ajax({
			type:"POST",
			url:"mail_action.php",
			data:dataString,
			cache:false,
			success:function(data){	
				location.reload();
			}
			});
		}
	}
	$('#refresh-btn').click(function(){
			location.reload();
		});
 </script>
</body>
</html>





		