<?php 
	include_once('includes/header.php');
	include_once(DIR_ROOT."class/forum_discussion.php");
	include_once(DIR_ROOT."class/group_info.php");
	include_once(DIR_ROOT.'class/group_members.php');
	include_once(DIR_ROOT.'class/personal_messages.php');
	include_once(DIR_ROOT.'class/group_messages.php');
	include_once(DIR_ROOT.'class/group_message_disply_status.php');
	$objDiscuss		=	new forum_discussion();
	$objGroup		=	new group_info();
	$objMember		=	new group_members();
	$objMesg		=	new personal_messages();
	$objGrupEmail	=	new group_messages();
	$objGmsgDisply	=	new group_message_disply_status();
	
	if ($sessionval	==	false) {
		header('location:index.php');
	}else{
		$userQuery	=	"select reg.*, user.*, prof.*, org.*, pat.* from registration_details as reg left join user_details as user on reg.reg_id = user.reg_id left join user_professionals_details as prof on reg.reg_id = prof.reg_id left join user_organizations_details as org on reg.reg_id = org.reg_id left join user_patient_details as pat on reg.reg_id = pat.reg_id where reg.reg_id='".$activeMem."' and reg.reg_status = 1";
		$userData	=	$objReg->getRowSql($userQuery);
		
		//$groupAll	=	$objGroup->getAll('reg_id = "'.$activeMem.'"','group_id desc');
		//GET GROUP COUNT
		$groupCount	=	$objMember->count('reg_id = "'.$activeMem.'"');
	}
	if($_REQUEST['dmail']){
		$msgId		=	$_REQUEST['dmail'];
		foreach($msgId as $dId){
		$getCount	=	$objMesg->count('msg_id = "'.$dId.'" and msg_to = "'.$activeMem.'"');
			if($getCount > 0){
				$delStatus		=	0;
				$objMesg->updateField(array('to_status' => $delStatus), 'msg_id = "'.$dId.'" ');
			}
		}
		header('location:mail_list.php');
	}else if($_REQUEST['dgmail']){
		$gMsgId		=	$_REQUEST['dgmail'];
		foreach($gMsgId as $gid){
			$status	=	$objGmsgDisply->count('gmsg_id ="'.$gid.'" and group_m_id="'.$activeMem.'"');
			if($status == 0){
				$_POST['group_m_id']	=	$activeMem;
				$_POST['gmsg_id']		=	$gid;
				$objGmsgDisply->insert($_POST);
			}
		}
		header('location:mail_list.php');
	}
?>
  <!--MAIN BODY START-->
<div class="container-fluid">
  
 <!--TOP SLIDER START-->
  <div class="row" style="padding:10px 0px;">
  	<div class="col-sm-12" style="padding:10px 0px;">
<?php include_once('includes/profile_left.php'); ?>
    <div class="col-lg-9">
     <div class=" border_style1">
     
     
     <div id="parentHorizontalTab">
            <ul class="resp-tabs-list hor_1">
                <li>Personal Message</li>
                <li>Group Message</li>
            </ul>
            <div class="resp-tabs-container hor_1">
             <?php   $msgQuery		=	"select * from(select msg.*, user.ud_name_title,user.ud_first_name from personal_messages as msg left join user_details as user on msg.msg_from = user.reg_id where msg.msg_to = '".$activeMem."' and msg.to_status = 1 and msg.msg_status = 1 union 
	 select snt.*, usr.ud_name_title,usr.ud_first_name from personal_reply as rply left join personal_messages as snt on rply.msg_id = snt.msg_id left join  user_details as usr on snt.msg_to = usr.reg_id where snt.msg_from = '".$activeMem."' and snt.from_status = 1 and snt.msg_status = 1) a order by msg_id desc"; 
	 
	 
	 		$allMesg		=	 $objMesg->listQuery($msgQuery); 
			if(count($allMesg)>0){
	 ?>
             
                <div>
                <form method="get" id="mail-control">
                <div style="margin:20px 0 10px 30px;"><a title="SELECT ALL" class="mail-control-menu" href="javascript:;"><input type="checkbox" id="select-all-msg" name="">&nbsp;<i class="fa fa-angle-down"></i></a>
                <a title="DELETE" class="mail-control-menu"  href="javascript:;" id="delete-email-wrap"><i class="fa fa-trash-o"></i></a> 
                <a title="REFRESH" class="mail-control-menu" href="javascript:;" id="refresh-btn"><i class="fa fa-refresh"></i></a>
                </div>
                <div class="table-responsive" style="padding:2%;">
                    <table class="table table-hover mailBox" style=" border:2px solid #C0C0C0; border-bottom:3px solid #C0C0C0;">
   
   
    <tbody>
    <?php 
				$i				=	1;
				foreach($allMesg as $mesgs){
				 if($mesgs['msg_from'] == $activeMem){
						$from	=	"Me";
					}else if($mesgs['msg_from'] == 1){
						$from	=	"IMC Team";
					}else if($mesgs['ud_name_title']){
						$from	=	$mesgs['ud_name_title'].": ".$mesgs['ud_first_name'];
					}
					else{
						$from	=	$mesgs['ud_first_name'];
					}
		 ?>
      <tr>
        <td width="5%"><input type="checkbox" name="dmail[]"  value="<?php echo $mesgs['msg_id']; ?>" class="select-message" ></td>
        <td width="20%"><a href="<?php echo SITE_ROOT ?>mail_details.php?message=<?php echo $mesgs['msg_id']; ?>" class="topic-mail"><?php echo $from; ?></a></td>
        <td width="55%"><a href="<?php echo SITE_ROOT ?>mail_details.php?message=<?php echo $mesgs['msg_id']; ?>" class="topic-mail"><?php echo strip_tags(substr($mesgs['msg_subject'],0,60)); ?></a></td>
        <td width="5%"><?php if($mesgs['msg_attachment']){ ?>
                <a href="<?php echo SITE_ROOT ?>mail_details.php?message=<?php echo $mesgs['msg_id']; ?>" class="topic-mail" style="text-align:center;" title="<?php echo $mesgs['msg_attachment']; ?>"><i class="fa fa-paperclip"></i></a>
				<?php } ?></td>
        <td width="15%"><a href="<?php echo SITE_ROOT ?>mail_details.php?message=<?php echo $mesgs['msg_id']; ?>" class="topic-mail"><?php echo date("y-M-d", strtotime($mesgs['msg_created_on'])); ?></a></td>
      </tr>
      <?php $i++; } ?>
    </tbody>
  </table>
  </div> </form>
                </div>
               
                 <?php }else{ ?>
                 <div>
                   <table class="table table-hover mailBox" style=" border:2px solid #C0C0C0; border-bottom:3px solid #C0C0C0;">
                        <tbody>
                            <tr>
                            	<td colspan="5">Your Inbox is empty.</td>
                            </tr>
                        </tbody>
                    </table>
                 </div>
                 <?php } ?>
                 
                 <?php   $gMsgQuery		=	"select gmsg.*, grp.group_name from group_messages as gmsg left join group_info as grp on gmsg.group_id = grp.group_id left join group_members as mem on gmsg.group_id = mem.group_id where mem.reg_id = '".$activeMem ."' and gmsg.gmsg_status = 1 order by gmsg.gmsg_id desc"; 
	 		$allMesg			=	 $objGrupEmail->listQuery($gMsgQuery); 
			if(count($allMesg)>0){
?>
                <div>
                 <form method="get" id="gmail-control">
                <div style="padding-left:2%; margin-top:30px;"><a title="SELECT ALL" class="mail-control-menu" href="javascript:;"><input type="checkbox" id="select-all-gmail" name="">&nbsp;<i class="fa fa-angle-down"></i></a>
                <a title="DELETE" class="mail-control-menu" href="javascript:;" id="delete-gmail"><i class="fa fa-trash"></i></a> 
                <a title="REFRESH" class="mail-control-menu" href="javascript:;"><i class="fa fa-refresh"></i></a>
                </div>
                <div class="table-responsive" style="padding:2%;">
                    <table class="table table-hover mailBox" style=" border:2px solid #C0C0C0; border-bottom:3px solid #C0C0C0;">
   
   
    <tbody>
    <?php 
				$i				=	1;
				foreach($allMesg as $mesgs){
				 if($mesgs['group_name']){
						$from	=	$mesgs['group_name'];
					}
					$gMsgId		=	$mesgs['gmsg_id'];
					$status		=	$objGmsgDisply->count('gmsg_id ="'.$gMsgId.'" and group_m_id="'.$activeMem.'"');
					if($status == 0){
		 ?>
      <tr>
        <td width="5%"><input type="checkbox" name="dgmail[]" value="<?php echo $mesgs['gmsg_id']; ?>" class="select-gmails" ></td>
        <td width="20%"><a href="<?php echo SITE_ROOT ?>group_message_details.php?message=<?php echo $mesgs['gmsg_id']; ?>" class="topic-mail"><?php echo $from; ?></a></td>
        <td width="55%"><a href="<?php echo SITE_ROOT ?>group_message_details.php?message=<?php echo $mesgs['gmsg_id']; ?>" class="topic-mail"><?php echo strip_tags(substr($mesgs['gmsg_subject'],0,60)); ?></a></td>
        <td width="5%"> <?php if($mesgs['gmsg_attachment']){ ?>
                <a href="<?php echo SITE_ROOT ?>group_message_details.php?message=<?php echo $mesgs['gmsg_id']; ?>" class="topic-mail" style="text-align:center;" title="<?php echo $mesgs['gmsg_attachment']; ?>"><i class="fa fa-paperclip"></i>
</a>
<?php } ?></td>
        <td width="15%"><a href="<?php echo SITE_ROOT ?>group_message_details.php?message=<?php echo $mesgs['gmsg_id']; ?>" class="topic-mail"><?php echo date("y-M-d", strtotime($mesgs['gmsg_created_on'])); ?></a></td>
      </tr>
         <?php $i++; } } ?>
    </tbody>
  </table>
  </div>
   </form>
                </div>
    <?php } else {  ?>
            <div>
               <table class="table table-hover mailBox" style=" border:2px solid #C0C0C0; border-bottom:3px solid #C0C0C0;">
                    <tbody>
                        <tr>
                            <td colspan="5">Your Inbox is empty.</td>
                        </tr>
                    </tbody>
                </table>
             </div>
    <?php  } ?>
                
            </div>
        </div>
    </div>
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
<script language="JavaScript" type="text/javascript">
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
 $(document).on("click",".select-message",function(){ // select message
	var checked_status = this.checked;
		if(checked_status == true)
		{
			$(this).parent().parent().css({"background": "#ffffcc"});
			$('#delete-email-wrap').show();
		}else{
			$(this).parent().parent().css({"background": "#efefff"});
		}
	
});
$(document).on("click",".select-gmails",function(){ // select message
	var checked_status = this.checked;
		if(checked_status == true)
		{
			$(this).parent().parent().css({"background": "#ffffcc"});
			$('#delete-gmail-wrap').show();
		}else{
			$(this).parent().parent().css({"background": "#efefff"});
		}
	
});
 </script>
  <script type="text/javascript" language="javascript">
 $(document).on("click","#select-all-msg",function(){  // select message
	var checked_status = this.checked;
		$('.select-message').each(function(){
			this.checked	=	checked_status;
			if(checked_status == true)
		{
			$(this).parent().parent().css({"background": "#ffffcc"});
			$('#delete-email-wrap').show();
		}else{
			$(this).parent().parent().css({"background": "#efefff"});
		}
			});
			
	
});
$(document).on("click","#select-all-gmail", function(){
	var ckeckedstatus		=	this.checked;
		$('.select-gmails').each(function(){
			this.checked	=	ckeckedstatus;
			if(ckeckedstatus == true)
			{
				$(this).parent().parent().css({"background": "#ffffcc"});
			$('#delete-gmail-wrap').show();
			}else{
				$(this).parent().parent().css({"background": "#efefff"});
			}
		});
	
	});
 </script>
 <script type="text/javascript" language="javascript">
 $('#delete-email-wrap').click(function(){
	$('#mail-control').submit();
 });
 $('#delete-gmail').click(function(){
	 	$('#gmail-control').submit();
	 });
 $('#refresh-btn').click(function(){
			location.reload();
		});
 </script>
</html>