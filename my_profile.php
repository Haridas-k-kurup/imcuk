<?php 
	include_once('includes/header.php');
	include_once(DIR_ROOT."class/forum_discussion.php");
	include_once(DIR_ROOT.'class/group_members.php');
	$objDiscuss		=	new forum_discussion();
	$objMember		=	new group_members();
	if($sessionval	==	false){
		header('location:index.php');
	}else{
		$userQuery	=	"select reg.*, user.*, prof.*, org.*, pat.* from registration_details as reg left join user_details as user on reg.reg_id = user.reg_id left join user_professionals_details as prof on reg.reg_id = prof.reg_id left join user_organizations_details as org on reg.reg_id = org.reg_id left join user_patient_details as pat on reg.reg_id = pat.reg_id where reg.reg_id='".$activeMem."' and reg.reg_status = 1";
		$userData	=	$objReg->getRowSql($userQuery);
	}
	//GET GROUP COUNT
	$groupCount	=	$objMember->count('reg_id = "'.$activeMem.'"');
?>
  <!--MAIN BODY START-->
<div class="container-fluid">
  
 <!--TOP SLIDER START-->
  <div class="row" style="padding:10px 0px;">
  	<div class="col-sm-12" style="padding:10px 0px;"> 
    <?php include_once('includes/profile_left.php'); ?>
    <div class="col-lg-9">
     <div class="row">
     <div class="col-lg-12">
     <div class="col-lg-9">
     <?php 
									if ($userData['ud_name_title']) {
										$mainName	=	stripslashes($userData['ud_name_title']).":&nbsp;".stripslashes($userData['ud_first_name'])."&nbsp;".stripslashes($userData['ud_second_name']);		} else {
										$mainName	=	stripslashes($userData['ud_first_name']);
									}
								 ?>
     <span style="font-size:24px; color:#333;"><?php echo $mainName; ?></span> <a class="update-btn fr" href="<?php echo SITE_ROOT; ?>update_information.php">Update Info</a>
        <hr style="padding:0px; margin:0px 0px 10px 0px ; color:#000; border:1px solid #666;"/>
        <?php echo stripslashes($userData['reg_other_info']); ?>
         <?php if ($userData['up_profession_acheive']) { ?>
        <span style="font-size:18px; color:#0076EC;">Achievements</span>
        <hr style="padding:0px; margin:0px 0px 10px 0px ; color:#000; border:1px solid #666;"/>
        <?php echo stripslashes($userData['up_profession_acheive']); ?>
     <?php } ?>
     </div>
     
     
     <div class="col-lg-3">
     <div class="proff-icon-wrapp office-title">
    <a  href="javascript:;" class="proff-msg-btn"><i class="fa fa-tag"></i>&nbsp;&nbsp;  Private ID </a>
    </div>
    <div class="more-details"><div class="more-details-border"><center><?php echo stripslashes($userData['reg_private_id']); ?></center></div></div>
    
    <div class="proff-icon-wrapp ">
    <a href="javascript:;" class="proff-msg-btn" href="javascript:;" id="change-password"><i class="fa fa-key"></i>&nbsp;&nbsp;  Change Password</a>
    </div>
    
    <div class="proff-icon-wrapp  office-title">
    <a href="javascript:;" class="proff-msg-btn"><i class="fa fa-user"></i>&nbsp;&nbsp;  Personal Details</a>
    </div>
    <div class="more-details">
    <div align="right"><i class="fa fa-pencil"></i></div>
    <div class="more-details-border">
    
    <span class="textstylea1">
	<?php 
		if ($userData['ud_name_title']) {
		$mainName	=	$userData['ud_name_title'].":&nbsp;".$userData['ud_first_name'];
		
		} else {
		$mainName	=	$userData['ud_first_name'];
		}
		echo $mainName;
		?>
     </span>
    <hr class="hrstyle3"/>
    <span class="textstylea1">Date of Birth:</span><span class="textstylea2"><?php 
											echo $birthDay	= date("M-d-Y",strtotime($userData['ud_dob']));
										 ?></span>
    
    <hr class="hrstyle3"/>
    <span class="textstylea1">Email:</span><span class="textstylea2"><?php 
											if ($userData['ud_email']) {
											echo $userData['ud_email'];
											} else {
												echo "------------------";
											}?></span>
    <hr class="hrstyle3"/>
    <span class="textstylea1">Home No:</span><span class="textstylea2"><?php 
											if ($userData['ud_tel_home']) {
											echo $userData['ud_tel_home'];
											} else {
												echo "------------------";
											}?></span><br/>
    <span class="textstylea1">Mob No:</span><span class="textstylea2"><?php 
											if ($userData['ud_tel_mob']) {
											echo $userData['ud_tel_mob'];
											} else {
												echo "------------------";
											}?></span><br/>
    <span class="textstylea1">Work No:</span><span class="textstylea2"><?php 
											if ($userData['ud_tel_work']) {
											echo $userData['ud_tel_work'];
											} else{
												echo "------------------";
											}?></span>
    <hr class="hrstyle3"/>
    <span class="textstylea1">Address (country of orgin):</span><br/><span class="textstylea2"><?php echo stripslashes($userData['ud_house_name']); ?> <br> <?php echo stripslashes($userData['ud_street_name']); ?> <br> <?php echo stripslashes($userData['ud_town']); ?> 	<br> <?php echo stripslashes($userData['ud_city']); ?>  <br> <?php echo stripslashes($userData['ud_state']); ?> <br> <?php echo stripslashes($userData['ud_country']); ?><br><?php echo stripslashes($userData['ud_post_code']); ?>
    </span>
    <hr class="hrstyle3"/>
    <span class="textstylea1">Current (country of orgin):</span><br/><span class="textstylea2"><?php echo stripslashes($userData['cur_house_name']); ?> <br> <?php echo stripslashes($userData['cur_street_name']); ?> <br> <?php echo stripslashes($userData['cur_town']); ?> <br> <?php echo stripslashes($userData['cur_city']); ?>  <br> <?php echo stripslashes($userData['cur_state']); ?> <br> <?php echo stripslashes($userData['cur_country']); ?><br><?php echo stripslashes($userData['cur_post_code']); ?>
    </span>
    </div></div>
    
    <div class="proff-icon-wrapp  office-title">
    <a href="javascript:;" class="proff-msg-btn"><i class="fa fa-bars"></i>&nbsp;&nbsp;  Registration Category</a>
    </div>
    
    <div class="more-details"><div class="more-details-border"><center><?php if($userData['reg_type'] == 1){ $regType	=	"Medical related professionals"; }else if($userData['reg_type'] == 2){ $regType	=	"Medical Organizations"; }else{$regType	=	"Non medical persons";} echo $regType; ?></center></div></div>
    
    <div class="proff-icon-wrapp  office-title">
    <a href="javascript:;" class="proff-msg-btn"><i class="fa fa-user-plus"></i>&nbsp;&nbsp;  Professional Details</a>
    </div>
    <div class="more-details">
    <div align="right"><i class="fa fa-pencil"></i></div><div class="more-details-border">
     <?php if ($userData['up_student_course']) { ?>
    <span class="textstylea1">Course:</span><span class="textstylea2"><?php echo stripslashes($userData['up_student_course']); ?></span>
     <hr class="hrstyle3"/>
      <?php } ?>
    <span class="textstylea1">Professional Type:</span><span class="textstylea2"><?php echo stripslashes($userData['up_profession_type']); ?></span>
    <hr class="hrstyle3"/>
    <span class="textstylea1">Professional Name:</span><span class="textstylea2"><?php echo $userData['up_profession_name']; ?></span>
    <hr class="hrstyle3"/>
    <span class="textstylea1">Speciality:</span><span class="textstylea2"><?php echo $userData['up_profession_speciality']; ?></span>
    <hr class="hrstyle3"/>
    <span class="textstylea1">Super Speciality:</span><span class="textstylea2"><?php echo $userData['up_profession_sup_speciality']; ?></span>
    <hr class="hrstyle3"/>
    <span class="textstylea1">Grade:</span><span class="textstylea2"><?php echo $userData['up_profession_grade']; ?></span>
    
    <hr class="hrstyle3"/>
    <span class="textstylea1">Hospital Address:</span><br/><span class="textstylea2">
	<?php 
			if ($userData['up_profession_hosp_addr']) {
			echo stripslashes($userData['up_profession_hosp_addr']);
			} else {
				echo "------------------";
			}?>
    </span>
    </div></div>
    
    
    <div class="proff-icon-wrapp  office-title">
    <a  href="javascript:;" class="proff-msg-btn"><i class="fa fa-users"></i>&nbsp;&nbsp;  Organization Details</a>
    </div>
    <div class="more-details">
    <div align="right"><i class="fa fa-pencil"></i></div><div class="more-details-border">
    <span class="textstylea1">College Address:</span><br/><span class="textstylea2"><?php 
											if ($userData['uo_collage_addr']) {
											echo stripslashes($userData['uo_collage_addr']);
											} else {
												echo "------------------";
											}?>
    </span>
    <hr class="hrstyle3"/>
    <span class="textstylea1">Hospital Address:</span><br/><span class="textstylea2"><?php 
											if ($userData['uo_hospital_addr']){
											echo stripslashes($userData['uo_hospital_addr']);
											} else {
												echo "------------------";
											}?>
    </span>
    
    <hr class="hrstyle3"/>
    <span class="textstylea1">Company Address:</span><br/><span class="textstylea2"><?php 
											if ($userData['uo_company_addr']) {
											echo stripslashes($userData['uo_company_addr']);
											} else {
												echo "------------------";
											}?>
    </span>
    </div></div>
    
    <!--<div class="proff-icon-wrapp">
    <a href="#" class="proff-msg-btn"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;  Other Details</a>
    </div>-->
     </div>
     
    </div>
    <div class="prof-more-dtils ovr">
                    </div>
        <div class="row">
        
        <div class="col-lg-9">
        <div style="font-size:24px; color:#333;">Topics you shared</div>
        <hr style="padding:0px; margin:0px 0px 10px 0px ; color:#000; border:1px solid #666;"/>
         <?php 
							/*-----------Topic start----------------*/
					$num_results_per_page 	 		=	5;
				//	$num_page_links_per_page 		= 	7;
					
					$sql_pagination 				= 	"select * from forum_topics";
					
					$sql_pagination					.=	" where reg_id ='".$activeMem."' and topic_staff_manage = 0 and topic_status = 1 order by topic_id desc";
					
					$pagesection					=	'';
					pagination($sql_pagination,$num_results_per_page);
					$page_list						=	$objThread->listQuery($pageQuery);
					if($page_list){
						foreach($page_list as $topic){
							$shrDate				=	date("M-d-Y",strtotime($topic['topic_created_on']));
					 ?>
                            	<span class="proff-msg-btn1  topic-area"><a title="EDIT TOPIC" onclick="return updateTopic(<?php echo $topic['topic_id']; ?>);" href="javascript:;"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a title="DELETE TOPIC" onclick="return deleteTopic(<?php echo $topic['topic_id']; ?>)" href="javascript:;"><i class="fa fa-trash-o"></i></a>
<a class="topic-head">&nbsp;&nbsp;<?php echo substr($topic['topic'],0,95); ?></a><br><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shared on&nbsp;&nbsp;<?php echo $shrDate; ?></span></span><br/>
<div  id="share-wrap-<?php echo $topic['topic_id']; ?>">
                            	
                            </div>
 <?php } ?>
                        <?php 
							include_once(DIR_ROOT."includes/pagination_div.php");
						  }else{?>
                          <span class="proff-msg-btn1  topic-area">No topic found</span>
                          <?php } ?>


<div style="font-size:24px; color:#333;">Discussion</div>
        <hr style="padding:0px; margin:0px 0px 10px 0px ; color:#000; border:1px solid #666;"/>
        <?php 
							/*-----------Topic start----------------*/
					$num_results_per_page 	 		=	5;
				//	$num_page_links_per_page 		= 	7;
					
					$sql_pagination 				= 	"select * from forum_discussion";
					
					$sql_pagination					.=	" where reg_id ='".$activeMem."' and dis_staff_manage = 0 and dis_status = 1 order by dis_id desc";
					
					$pagesection					=	'';
					pagination($sql_pagination,$num_results_per_page);
					$page_list						=	$objThread->listQuery($pageQuery);
					if($page_list){
						foreach($page_list as $dicuss){
							$disDate				=	date("M-d-Y",strtotime($dicuss['dis_created_on']));
					 ?>
                            	<span class="proff-msg-btn1  topic-area"><a title="EDIT TOPIC" onclick="return updateDiscuss(<?php echo $dicuss['dis_id']; ?>);" href="javascript:;"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a title="DELETE TOPIC" onclick="return deleteDiscuss(<?php echo $dicuss['dis_id']; ?>)" href="javascript:;"><i class="fa fa-trash-o"></i></a>
<a class="topic-head">&nbsp;&nbsp;<?php echo substr(strip_tags($dicuss['discussion']),0,95); ?></a><br><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shared on&nbsp;&nbsp;<?php echo $disDate; ?></span></span><br/>
<div  id="share-wrap-discuss-<?php echo $dicuss['dis_id']; ?>">
</div>
<?php }
							include_once(DIR_ROOT."includes/pagination_div.php");
						 } else{ ?>
                         <span class="proff-msg-btn1  topic-area">No discussion found</span>
                         <?php } ?>
                            </div>
                            
       <div class="col-lg-3">
       <div class="proff-icon-wrapp">
    <a href="#" class="proff-msg-btn"><i class="fa fa-briefcase"></i>&nbsp;&nbsp; Projects</a>
    </div>
    <div class="proff-icon-wrapp">
    <a href="#" class="proff-msg-btn"><i class="fa fa-briefcase"></i>&nbsp;&nbsp; Projects</a>
    </div>
    <div class="proff-icon-wrapp">
    <a href="#" class="proff-msg-btn"><i class="fa fa-envelope"></i>&nbsp;&nbsp; Message</a>
    </div>
    <div class="proff-icon-wrapp">
    <a href="#" class="proff-msg-btn"><i class="fa fa-envelope"></i>&nbsp;&nbsp; Message</a>
    </div>
    <div class="proff-icon-wrapp">
    <a href="#" class="proff-msg-btn"><i class="fa fa-envelope"></i>&nbsp;&nbsp; Message</a>
    </div>
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
<script>
$(".modal-backdrop").removeClass("modal-backdrop");
$(document).ready(function () {
 $('.office-title').next('div').slideToggle();
 $('.office-title').click(function(){   
 $('.office-title').next('div').slideUp();
     $(this).next('div').slideToggle(); 
     return false;
});
     });
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
   function updateTopic(id){ //get update 
   		var dataString	=	'id='+id;
		var sharewrap	=	"#share-wrap-"+id;
		$('.share_edit').remove();
		$.ajax({
				type:"POST",
				url:"ajax/get_profile_share_topic.php",
				data:dataString,
				cache:false,
				success:function(data){
					
					$(sharewrap).html(data);
					if(typeof(CKEDITOR.instances.tds)=="object")
						{
						CKEDITOR.instances.tds.destroy();
						}
						var editor = CKEDITOR.replace('tds');
					}
			});
   }
   </script>
   <script type="text/javascript" language="javascript">
   	function deleteTopic(data){ // tpoic delete
			var type		=	"dt";
			var dataString	=	'type='+type+'&did='+data;
			$.ajax({
				type:"POST",
				url:"ajax_action.php",
				data:dataString,
				cache:false,
				success:function(data){
					if(data==1){
						location.reload();
					}else{
						alert("Sorry! Try again.");
						location.reload();
					}
				}
				});
	}
   </script>
   <script type="text/javascript" language="javascript">
   function updateDiscuss(id){ //get update discuss 
   		var dataString	=	'id='+id;
		var sharewrap	=	"#share-wrap-discuss-"+id;
		$('.share_edit').remove();
		$.ajax({
				type:"POST",
				url:"ajax/get_profile_share_discuss.php",
				data:dataString,
				cache:false,
				success:function(data){ //alert(data);
					
					$(sharewrap).html(data);
					if(typeof(CKEDITOR.instances.dds)=="object")
						{
						CKEDITOR.instances.dds.destroy();
						}
						var editor = CKEDITOR.replace('dds');
					}
			});
   }
   </script>
   <script type="text/javascript" language="javascript"> 
   	function deleteDiscuss(data){ // tpoic delete
			var type		=	"dd";
			var dataString	=	'type='+type+'&ddid='+data;
			$.ajax({
				type:"POST",
				url:"ajax_action.php",
				data:dataString,
				cache:false,
				success:function(data){
					if(data==1){
						location.reload();
					}else{
						alert("Sorry! Try again.");
						location.reload();
					}
				}
				});
	}
   </script>
   
 
 <script type="text/javascript" language="javascript">
 $('#change-password').click(function(){// GET CHANGE PASSWORD POPUP
	 	$('.popup_wrapper').show();
		$('.pro-popup').show();
		var preload		=	'<img src="img/small.gif" class="preloadersmall" />';
		$('.pro-popup').html(preload);
		$.ajax({
				type:"POST",
				url:"ajax/change_password.php",
				cache:false,
				success:function(data){ 
					//$(".pro-popup").html(data);
					$('#change-pass').html(data);
					$('#change-pass').modal('show');
				}
				
			});
	 	
	 });
	 
 </script>

</html>