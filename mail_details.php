<?php 
	include_once('includes/header.php');
	include_once(DIR_ROOT."class/forum_discussion.php");
	include_once(DIR_ROOT."class/group_info.php");
	include_once(DIR_ROOT.'class/group_members.php');
	include_once(DIR_ROOT.'class/personal_messages.php');
	include_once(DIR_ROOT."class/personal_reply.php");
	$objDiscuss		=	new forum_discussion();
	$objGroup		=	new group_info();
	$objMember		=	new group_members();
	$objMesg		=	new personal_messages();
	$objReply		=	new personal_reply();
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
  <!--MAIN BODY START-->
<div class="container-fluid">
  
 <!--TOP SLIDER START-->
  <div class="row" style="padding:10px 0px;">
  	<div class="col-sm-12" style="padding:10px 0px;">
<?php include_once('includes/profile_left.php'); ?>
    <div class="col-lg-9">
    <?php   $msgQuery		=	"select msg.*, user.ud_name_title,user.ud_first_name, user.ud_pofile_pic from personal_messages as msg left join user_details as user on msg.msg_from = user.reg_id where msg.msg_id= '".$msgId."' and (msg.msg_to = '".$activeMem."' or msg.msg_from = '".$activeMem."') and  msg.to_status = 1 and msg.msg_status = 1"; 
	 		  $myMesg		=	 $objMesg->getRowSql($msgQuery); 
			
			if($myMesg['msg_id']){
	 ?>
     			<div style="margin:20px 0 10px 30px;">
                <a title="DELETE" class="mail-control-menu"  href="javascript:;" onclick="return delMsg(<?php echo $msgId; ?>);"><i class="fa fa-trash-o"></i></a> 
                <a title="REFRESH" class="mail-control-menu" href="javascript:;" id="refresh-btn"><i class="fa fa-refresh"></i></a>
                </div>
     	<div class="row">
        	<div class="col-lg-1">
            	<div class="mail-image ">
                	  <?php if($myMesg['ud_pofile_pic']){
							 
							$profPic	=  "profiles/".stripslashes($myMesg['ud_pofile_pic']);
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
            <div class="col-lg-11">
            <div class="mail-read-box box-border-bttom">
             <?php 
								if($myMesg['msg_from'] == $activeMem){
									$from	=	"Me";
									}else if($myMesg['ud_name_title']){
									$from	=	$myMesg['ud_name_title'].": ".$myMesg['ud_first_name'];
									}else{
									$from	=	$myMesg['ud_first_name'];
									}
							 ?>
            	<div class="sender-head"><strong><?php echo $from; ?>&nbsp;&nbsp;&nbsp;(<?php echo date("y-M-d", strtotime($myMesg['msg_created_on'])); ?>)</strong></div>
                <div class="pull-right">
                 <a class="btn btn-bitbucket" title="REPLY" onclick="return getReply(<?php echo $myMesg['msg_id']; ?>);"><i class="fa fa-reply" style="color:#fff;"></i></a>
                </div>
                <div class="clearfix"></div>
        	<p><?php echo stripslashes($myMesg['msg_body']); ?></p>
             <?php if($myMesg['msg_attachment']){ ?>
                        <div class="mail-attachment-area ovr">
                       	 	<a href="<?php echo SITE_ROOT; ?>download.php?item=<?php echo $myMesg['msg_attachment']; ?>" title="<?php echo $myMesg['msg_attachment']; ?>"><img src="img/downloadicon.png" /></a>
                        </div>
                        <?php } ?>
        </div>
        <div class="reply-area" id="main-reply">
                    	
        </div>
            </div>
        </div>
        <?php 
			$replySql		=	"select reply.*, user.ud_name_title,user.ud_first_name, user.ud_pofile_pic from personal_reply as reply left join user_details as user on reply.preply_from = user.reg_id where reply.msg_id 	= '".$myMesg['msg_id']."' and  reply.preply_status = 1"; 
			$allReply		=	$objReply->listQuery($replySql);
				foreach($allReply as $reply){
			 ?> 
             <div class="row">
        	<div class="col-lg-1">
            	<div class="mail-image ">
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
            <div class="col-lg-11">
            <div class="mail-read-box box-border-bttom">
             <?php 
								if($reply['msg_from'] == $activeMem){
									$from	=	"Me";
									}else if($reply['ud_name_title']){
									$from	=	$reply['ud_name_title'].": ".$reply['ud_first_name'];
									}else{
									$from	=	$reply['ud_first_name'];
									}
							 ?>
            	<div class="sender-head"><strong><?php echo $from; ?>&nbsp;&nbsp;&nbsp;(<?php echo date("y-M-d", strtotime($reply['preply_created_on'])); ?>)</strong></div>
                <div class="pull-right">
                 <a class="btn  btn-bitbucket" title="REPLY" onclick="return getMoreReply(<?php echo $reply['preply_id']; ?>, <?php echo $myMesg['msg_id']; ?>);"><i class="fa fa-reply" style="color:#fff;"></i></a>
                </div>
                <div class="clearfix"></div>
        	<p><?php echo stripslashes($reply['preply_body']); ?></p>
             <?php if($reply['preply_attachment']){ ?>
                        <div class="mail-attachment-area ovr">
                       	 	<a href="<?php echo SITE_ROOT; ?>download.php?item=<?php echo $reply['preply_attachment']; ?>" title="<?php echo $reply['preply_attachment']; ?>"><img src="img/downloadicon.png" /></a>
                        </div>
                        <?php } ?>
        </div>
        <div class="reply-area" id="main-reply<?php echo $reply['preply_id']; ?>"></div>
            </div>
        </div>
              <?php } ?>
    <?php }else{
			header('location:mail_list.php');
		}?>
    </div>
    </div>
  </div>
  <!--TOP SLIDER END-->
  
</div>
<!--MAIN BODY END-->

</body>
<script type="text/javascript">
    $(document).ready(function() {
        //Horizontal Tab
        $('#parentHorizontalTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            tabidentify: 'hor_1', // The tab groups identifier
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#nested-tabInfo');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });

        // Child Tab
        $('#ChildVerticalTab_1').easyResponsiveTabs({
            type: 'vertical',
            width: 'auto',
            fit: true,
            tabidentify: 'ver_1', // The tab groups identifier
            activetab_bg: '#fff', // background color for active tabs in this group
            inactive_bg: '#F5F5F5', // background color for inactive tabs in this group
            active_border_color: '#c1c1c1', // border color for active tabs heads in this group
            active_content_border_color: '#5AB1D0' // border color for active tabs contect in this group so that it matches the tab head border
        });

        //Vertical Tab
        $('#parentVerticalTab').easyResponsiveTabs({
            type: 'vertical', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            tabidentify: 'hor_1', // The tab groups identifier
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#nested-tabInfo2');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });
    });
</script>
<script>

$(".modal-backdrop").removeClass("modal-backdrop");
</script>

<script type="text/javascript" language="javascript">
function loadFrame(){
		$('.proff-pic-area').slideUp(1000);
		$('.change-image_wrap').slideDown(1000);
	}	
$('#close-window').click(function(){
		$('.proff-pic-area').show();
		$('.change-image_wrap').hide();
		$('#cancel-window').show();
		});			
</script>
<script type="text/javascript" language="javascript">
   function loadFrame(){
			$('.proff-pic-area').slideUp(1000);
			$('.change-image_wrap').slideDown(1000);
		}
</script>
<script type="text/javascript" language="javascript">
 $('#compose').click(function(){
	 	$.ajax({
				type:"POST",
				url:"ajax/mail_compose.php",
				cache:false,
				success:function(data){ 
					$('#myModal').html(data);
					$('#myModal').modal('show');
					//$(".mail_box_wrapper").html(data);
				}
				
			});
	 });
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
			url:"ajax/get_replybox.php",
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
			url:"ajax/get_replybox.php",
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
			var act			=	"pdelete";
			var dataString	=	"ms="+ms+"&act="+act;
			
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

</html>