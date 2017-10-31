<?php 
session_start();
include_once('../includes/site_root.php');
include_once(DIR_ROOT."includes/session_check.php");
include_once(DIR_ROOT."includes/action_functions.php");
include_once(DIR_ROOT."class/registration_details.php");
include_once(DIR_ROOT."class/group_info.php");
include_once(DIR_ROOT.'class/group_members.php');
$objCommon		=	new common_functions();
$objReg			=	new registration_details();
$objGroup		=	new group_info();
$objMember		=	new group_members();
if(isset($_POST['srch']) && $_POST['srch']){
	$item		=	$objCommon->esc(trim($_POST['srch']));
	$loginSql	=	"select reg.reg_id, reg.reg_createdon,user.ud_id, user.ud_name_title,user.ud_first_name, user.ud_country, user.ud_pofile_pic,user.ud_state, prof.up_profession_name from registration_details as reg left join user_details as user on reg.reg_id=user.reg_id left join user_professionals_details as prof on reg.reg_id =  prof.reg_id where user.ud_name_title like '%".$item."%' or user.ud_first_name like '%".$item."%' or user.ud_country like '%".$item."%' or user.ud_state like '%".$item."%' or user.ud_city like '%".$item."%' or user.ud_town like '%".$item."%' or prof.up_student_course  like '%".$item."%' or prof.up_profession_type  like '%".$item."%' or prof.up_profession_name  like '%".$item."%' or prof.up_profession_speciality 	 like '%".$item."%' or prof.up_profession_sup_speciality like '%".$item."%' or prof.up_profession_grade like '%".$item."%' and reg.reg_id != 1 and reg.reg_status = 1 order by reg.reg_createdon desc";
	$users		=	$objReg->listQuery($loginSql);
}else{
	$loginSql	=	"select reg.reg_id, reg.reg_createdon,user.ud_id, user.ud_name_title,user.ud_first_name, user.ud_country, user.ud_pofile_pic from registration_details as reg left join user_details as user on reg.reg_id=user.reg_id where reg.reg_id != 1 and reg.reg_status = 1 order by reg.reg_createdon desc";
	$users		=	$objReg->listQuery($loginSql);
}
 ?>

                                    <?php 
									if(count($users) > 0){
									$i	=	1;
									 foreach($users as $member){ ?>
                                    	<div class="col-lg-4 col-sm-12 col-md-6">
    <div class="mem-baldge-wrap">
    <div class="row">
    <div class="col-lg-4">
   <center> 
   <?php if($member['ud_pofile_pic']){
							 
							$profPic	=  "profiles/".stripslashes($member['ud_pofile_pic']);
							
							if(file_exists($profPic)){
						?>
                            <img  class="img-responsive img-thumbnail" src="<?php echo SITE_ROOT.$profPic; ?>" width="100%" height="100" >
                            <?php } else{ ?>
                            <img class="img-responsive img-thumbnail" src="<?php echo SITE_ROOT; ?>images/profile.jpg" width="100%" height="100" >
                            <?php }  }else{ ?>
                            <img class="img-responsive img-thumbnail" src="<?php echo SITE_ROOT; ?>images/profile.jpg" width="100%" height="100" >
                            <?php } ?>
   
  </center>
    </div>
    <div class="col-lg-8">
    <?php 
	if($member['ud_name_title']){
		$mainName	=	substr($member['ud_name_title'].":&nbsp;".$member['ud_first_name'],0,20);
	}else{
		$mainName	=	$member['ud_first_name'];
	}
	?>
    <p><span class="mem-name"><?php echo $mainName; ?></span><br/>
    <?php echo $member['ud_country']?><?php if ($member['ud_state']) {
													echo ", ".$member['ud_state'];
												}?><br/>
    <span style="font-weight:bold;"><?php echo $member['up_profession_name'] ?></span></p>
    <?php  if($activeMem){ 
		$userGroup	=	$objGroup->getAll('reg_id ="'.$activeMem.' and group_status= 1 "','group_name');
	 ?>
   <center> <div class="drop2down" align="center"><span class="mem_addgroup_btn">Add to Group</span>
        <div class="drop2down-content">
         <?php  foreach($userGroup as $groups){ 
				$groupId	=	$groups['group_id'];
				$memberId	=	$member['reg_id'];
				$membership	=	$objMember->getAll('group_id = "'.$groupId.'" and reg_id = "'.$memberId.'"');
				if(count($membership) > 0){
		   ?>
    <a href="javascript:;" style="cursor:default;" ><span style="float:left;"><i class="fa fa-users"></i></span> <?php echo $groups['group_name']; ?> <span style="float:right;"> <i class="fa fa-check-circle"></i></span></a>
    
    <?php }else{ ?>
    
    <a href="javascript:;" onclick="return togp(<?php echo $groupId; ?>, <?php echo $memberId; ?>)" ><span style="float:left;"><i class="fa fa-users"></i></span> <?php echo $groups['group_name']; ?> <span style="float:right;"> <i class="fa fa-thumb-tack"></i></span></a>
     <?php } } ?>
  </div>
        </div></center> <?php } ?>
    
    </div>
    </div>
    </div>
    </div>
                                        <?php
										
										
										  }
										 	
										 
										 
										  }else{ ?>
                                         	<table><tr><td>No results found for : <?php echo $item; ?> </td></tr></table>
                                         <?php } ?>
                                        <script type="text/javascript" language="javascript">
											function togp(gd, id){
												if(gd && id){
													var act			=	"addto";
													var dataString	=	"g="+gd+"&id="+id+"&act="+act;	
													$.ajax({
														type:"POST",
														url:"ajax_action.php",
														data:dataString,
														cache:false,
														success:function(data){
															var arg	=	$('#search-mem').val();
																getMembers(arg)
																location.reload();
															}
															
															
													});
												}
											}
										</script>
                                    