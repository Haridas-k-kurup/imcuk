<?php 
	include_once('includes/header.php');
	include_once(DIR_ROOT."class/forum_discussion.php");
	include_once(DIR_ROOT."class/group_info.php");
	include_once(DIR_ROOT.'class/group_members.php');
	include_once(DIR_ROOT.'class/personal_messages.php');
	include_once(DIR_ROOT.'class/group_messages.php');
	include_once(DIR_ROOT.'class/personal_msg_draft.php');
	$objDiscuss		=	new forum_discussion();
	$objGroup		=	new group_info();
	$objMember		=	new group_members();
	$objMesg		=	new personal_messages();
	$objGrupEmail	=	new group_messages();
	$objDraft		=	new personal_msg_draft();
	
	if($sessionval	==	false){
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
		$getCount	=	$objDraft->count('personal_draft_id = "'.$dId.'" and personal_draft_from = "'.$activeMem.'"');
			if($getCount > 0){
				$delStatus		=	0;
				$objDraft->updateField(array('personal_draft_status' => $delStatus), 'personal_draft_id = "'.$dId.'" ');
			}
		}
		header('location:message_draft.php');
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
            
            <div class="resp-tabs-container hor_1">
              <?php   $msgQuery		=	"select msg.*, user.ud_name_title,user.ud_first_name from personal_msg_draft as msg left join user_details as user on msg.personal_draft_from = user.reg_id where msg.personal_draft_from = '".$activeMem."' and msg.personal_draft_status = 1 order by msg.personal_draft_id desc"; 
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
				 if($mesgs['personal_draft_from'] == $activeMem){
						$from	=	"Me";
					}
		 ?>
      <tr>
        <td width="5%"><input type="checkbox" name="dmail[]"  value="<?php echo $mesgs['personal_draft_id']; ?>" class="select-message" ></td>
        <td width="20%"><a href="javascript:;" onClick="return getDraftCompose(<?php echo $mesgs['personal_draft_id'] ?>);" class="topic-mail"><?php echo $from; ?></a></td>
        <td width="55%"><a href="javascript:;" onClick="return getDraftCompose(<?php echo $mesgs['personal_draft_id'] ?>);" class="topic-mail"><?php echo strip_tags(substr($mesgs['personal_draft_subject'],0,60)); ?></a></td>
        <td width="5%"><?php if($mesgs['personal_draft_attachment']){ ?>
                <a href="javascript:;" onClick="return getDraftCompose(<?php echo $mesgs['personal_draft_id'] ?>);" class="topic-mail" style="text-align:center;" title="<?php echo $mesgs['personal_draft_attachment']; ?>"><i class="fa fa-paperclip"></i></a>
				<?php } ?></td>
        <td width="15%"><a href="javascript:;" onClick="return getDraftCompose(<?php echo $mesgs['personal_draft_id'] ?>);" class="topic-mail"><?php echo date("y-M-d", strtotime($mesgs['personal_draft_date'])); ?></a></td>
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
                            	<td colspan="5">Your draft is empty.</td>
                            </tr>
                        </tbody>
                    </table>
                 </div>
                 <?php } ?>
                 
                 
           
                
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
 <script type="text/javascript" language="javascript">
 function getDraftCompose(mid){
	 var datastring	=	"mid="+mid;
	 if(mid){
 		$.ajax({
				type:"POST",
				url:"ajax/draft_compose.php",
				data:datastring,
				cache:false,
				success:function(data){ 
					//$(".mail_box_wrapper").html(data);
					$('#myModal').html(data);
					$('#myModal').modal('show');
				}
				
			});
	 }
 }
 </script>
</html>