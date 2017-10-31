<?php 
	include_once('includes/header.php');
	include_once(DIR_ROOT."class/forum_discussion.php");
	include_once(DIR_ROOT.'class/country_details.php');
	include_once(DIR_ROOT.'class/group_members.php');
	$objDiscuss		=	new forum_discussion();
	$objMember		=	new group_members();
	if($sessionval	==	false){
		header('location:index.php');
	}else{
		$userQuery	=	"select reg.*, user.*, prof.*, org.*, pat.* from registration_details as reg left join user_details as user on reg.reg_id = user.reg_id left join user_professionals_details as prof on reg.reg_id = prof.reg_id left join user_organizations_details as org on reg.reg_id = org.reg_id left join user_patient_details as pat on reg.reg_id = pat.reg_id where reg.reg_id='".$activeMem."' and reg.reg_status = 1";
		$userData	=	$objReg->getRowSql($userQuery);
		//GET GROUP COUNT
		$groupCount	=	$objMember->count('reg_id = "'.$activeMem.'"');
	}
?>
 <link rel="stylesheet" type="text/css" href="plugin/responsive-tab/easy-responsive-tabs.css" />
  <script src="plugin/responsive-tab/easyResponsiveTabs.js"></script>
  <!--MAIN BODY START-->
<div class="container-fluid">
  
 <!--TOP SLIDER START-->
  <div class="row" style="padding:10px 0px;">
  	<div class="col-sm-12" style="padding:10px 0px;"> 
    <?php include_once('includes/profile_left.php'); ?>
    <div class="col-lg-9">
     <div class=" border_style1">
     
     
     <div id="parentVerticalTab">
            <ul class="resp-tabs-list hor_1">
                <li>Basic Information</li>
                <li>Address</li>
                <li>Phone</li>
                <li>Study Related</li>
                <li>Pro-Category</li>
                <li>Pro-Information</li>
                <li>Organization</li>
                <li>About Yourself</li>
                <li>Achivements</li>
            </ul>
            <div class="resp-tabs-container hor_1">
           
                <div>
                 <form action="action.php?upact=pd" method="post" enctype="multipart/form-data">
                    <h3 style="color:#0000B3;">Personal Details</h3>
                   <div class="col-lg-3"><label class="lablepafd">Title:</label></div>
                   <div class="col-lg-9"><select class="inputstylea1" name="name_title" id="reg_name_title">
                                          <option value="">--SELECT--</option>
                                         <option <?php echo ($userData['ud_name_title'] == "Mr")? 'selected' : "" ?> value="Mr">Mr</option>
                                          <option <?php echo ($userData['ud_name_title'] == "Mrs")? 'selected' : "" ?> value="Mrs">Mrs</option>
                                          <option <?php echo ($userData['ud_name_title'] == "Ms")? 'selected' : "" ?> value="Ms">Ms</option>
                                          <option <?php echo ($userData['ud_name_title'] == "Miss")? 'selected' : "" ?> value="Miss">Miss</option>
                                          <option <?php echo ($userData['ud_name_title'] == "Dr")? 'selected' : "" ?> value="Dr">Dr</option>
                                          <option <?php echo ($userData['ud_name_title'] == "Prof")? 'selected' : "" ?> value="Prof">Prof</option>
                                          <option value="Others">Others</option>
                                  </select></div>
                                 <div class="col-lg-3"><label class="lablepafd">Name:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="first_name" value="<?php echo stripcslashes($userData['ud_first_name']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                  <div class="col-lg-3"><label class="lablepafd">Date of Birth:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" value="<?php echo stripcslashes($userData['ud_dob']); ?>" name="dob" id="dob" kl_virtual_keyboard_secure_input="on"></div>
                                  <div class="col-lg-3"><label class="lablepafd">Age Range:</label></div>
                                   <div class="col-lg-9">
                                    <select  class="inputstylea1" name="age_range" id="reg_name_title">
                                        <option value="">------------ SELECT RANGE ------------</option>
                                        <option <?php echo ($userData['ud_age'] == "10-20") ? 'selected' : '' ?> value="10-20">10-20</option>
                                        <option <?php echo ($userData['ud_age'] == "20-30") ? 'selected' : '' ?> value="20-30">20-30</option>
                                        <option <?php echo ($userData['ud_age'] == "30-40") ? 'selected' : '' ?> value="30-40">30-40</option>
                                        <option <?php echo ($userData['ud_age'] == "40-50") ? 'selected' : '' ?> value="40-50">40-50</option>
                                        <option <?php echo ($userData['ud_age'] == "50-60") ? 'selected' : '' ?> value="50-60">50-60</option>
                                        <option <?php echo ($userData['ud_age'] == "60-70") ? 'selected' : '' ?> value="60-70">60-70</option>
                                        <option <?php echo ($userData['ud_age'] == "70-80") ? 'selected' : '' ?> value="70-80">70-80</option>
                                        <option <?php echo ($userData['ud_age'] == "80-90") ? 'selected' : '' ?> value="80-90">80-90</option>
                                        <option <?php echo ($userData['ud_age'] == "90-100")? 'selected' : '' ?> value="90-100">90-100</option>
                                    </select>
                                    </div>
                                  
                                  <div class="col-lg-3"><label class="lablepafd">Email Address:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="email" value="<?php echo stripcslashes($userData['ud_email']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                  
                   <button type="submit" name="submit" class="popup-button">Save Changes</button>  
                   <button type="submit" name="submit" data-dismiss="modal" class="popup-button" id="create-group-close">Cancel</button>             
                	  </form>
                </div>
                
                
                <div>
                  <form action="action.php?upact=ad" method="post" enctype="multipart/form-data">
                    <h3 style="color:#0000B3;">Address Details</h3>
                  <p style="color:#800000; font-weight:bold;">Address(country of orgin)</p>
                                 <div class="col-lg-3"><label class="lablepafd">Country:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="country" value="<?php echo stripcslashes($userData['ud_country']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                  <div class="col-lg-3"><label class="lablepafd">State:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="state" value="<?php echo stripcslashes($userData['ud_state']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                                                    
                                  <div class="col-lg-3"><label class="lablepafd">City:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="city" value="<?php echo stripcslashes($userData['ud_city']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                  
                                  <div class="col-lg-3"><label class="lablepafd">Town:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="town" value="<?php echo stripcslashes($userData['ud_town']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                  <div class="col-lg-3"><label class="lablepafd">Street Name/No:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="street_name" value="<?php echo stripcslashes($userData['ud_street_name']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                                                    
                                  <div class="col-lg-3"><label class="lablepafd">House Name/No:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="house_name" value="<?php echo stripcslashes($userData['ud_house_name']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                  <div class="col-lg-3"><label class = "lablepafd">Postal Code:</label></div>
                                  <div class="col-lg-9"><input class = "inputstyle1" type="text" name="post_code" value="<?php echo stripcslashes($userData['ud_post_code']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                  
                                  <p style="color:#800000; font-weight:bold;">Current Address</p>
                                 <div class="col-lg-3"><label class="lablepafd">Country:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="cur_country" value="<?php echo stripcslashes($userData['cur_country']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                  <div class="col-lg-3"><label class="lablepafd">State:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="cur_state" value="<?php echo stripcslashes($userData['cur_state']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                                                    
                                  <div class="col-lg-3"><label class="lablepafd">City:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="cur_city" value="<?php echo stripcslashes($userData['cur_city']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                  
                                  <div class="col-lg-3"><label class="lablepafd">Town:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="cur_town" value="<?php echo stripcslashes($userData['cur_town']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                  <div class="col-lg-3"><label class="lablepafd">Street Name/No:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="cur_street_name" value="<?php echo stripcslashes($userData['cur_street_name']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                                                    
                                  <div class="col-lg-3"><label class="lablepafd">House Name/No:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="cur_house_name" value="<?php echo stripcslashes($userData['cur_house_name']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                  <div class="col-lg-3"><label class="lablepafd">Postal Code:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="cur_post_code" value="<?php echo stripcslashes($userData['cur_post_code']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                  
                   <button type="submit" name="submit" class="popup-button">Save Changes</button>  
                   <button type="submit" name="submit" data-dismiss="modal" class="popup-button" id="create-group-close">Cancel</button>  
                   </form>           
                </div>
                
                
                
                <div>
                 <form action="action.php?upact=cpd" method="post" enctype="multipart/form-data">
                 <h3 style="color:#0000B3;">Contact/Phone Details</h3>
                    <div class="col-lg-3"><label class="lablepafd">Home:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="tel_home" value="<?php echo stripcslashes($userData['ud_tel_home']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                  <div class="col-lg-3"><label class="lablepafd">Work:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="tel_work" value="<?php echo stripcslashes($userData['ud_tel_work']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                                                    
                                  <div class="col-lg-3"><label class="lablepafd">Mobile:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="tel_mob" value="<?php echo stripcslashes($userData['ud_tel_mob']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                  
                   <button type="submit" name="submit" class="popup-button">Save Changes</button>  
                   <button type="submit" name="submit" data-dismiss="modal" class="popup-button" id="create-group-close">Cancel</button>
                  </form>
                </div>
                <div>
                  <form action="action.php?upact=course" method="post" enctype="multipart/form-data">
                <h3 style="color:#0000B3;">If You are a Medical Related Student</h3>
                    <div class="col-lg-6"><div class="radio">
                     <label><input type="radio" name="up_student_course" <?php echo ($userData['up_student_course'] == "Medical") ? 'checked' : '' ?> value="Medical">Medical</label></div>
<div class="radio"><label><input type="radio" name="up_student_course" <?php echo ($userData['up_student_course'] == "Dental") ? 'checked' : '' ?> value="Dental">Dental</label></div>
<div class="radio"><label><input type="radio" name="up_student_course" <?php echo ($userData['up_student_course'] == "Nursing") ? 'checked' : '' ?> value="Nursing">Nursing</label> </div>
 <div class="radio"><label><input type="radio" name="up_student_course" <?php echo ($userData['up_student_course'] == "Pharmacy") ? 'checked' : '' ?> value="Pharmacy">Pharmacy</label></div>
<div class="radio"><label><input type="radio" name="up_student_course" <?php echo ($userData['up_student_course'] == "Physiotherapy") ? 'checked' : '' ?> value="Physiotherapy">Physiotherapy</label></div></div>
<div class="col-lg-6">
<div class="radio"><label><input type="radio" name="up_student_course" <?php echo ($userData['up_student_course'] == "Management") ? 'checked' : '' ?> value="Management">Management</label></div> 
<div class="radio"><label><input type="radio" name="up_student_course" <?php echo ($userData['up_student_course'] == "Nutrition") ? 'checked' : '' ?> value="Nutrition">Nutrition</label></div>
<div class="radio"><label><input type="radio" name="up_student_course" <?php echo ($userData['up_student_course'] == "Homeopathy") ? 'checked' : '' ?> value="Homeopathy">Homeopathy</label></div>
<div class="radio"><label><input type="radio" name="up_student_course" <?php echo ($userData['up_student_course'] == "Ayurvedic") ? 'checked' : '' ?> value="Ayurvedic">Ayurvedic</label></div> 
<div class="radio"><label><input type="radio" name="up_student_course" <?php echo ($userData['up_student_course'] == "Chinese medicine") ? 'checked' : '' ?> value="Chinese medicine">Chinese medicine</label> </div></div>
<button type="submit" name="submit" class="popup-button">Save Changes</button>  
                   <button type="submit" name="submit" data-dismiss="modal" class="popup-button" id="create-group-close">Cancel</button>
                   </form>
                </div>
                <div>
                 <form action="action.php?upact=course" method="post" enctype="multipart/form-data">
                <h3 style="color:#0000B3;">If You are Professional(Medical Related)</h3>
                    <div class="col-lg-6"><div class="radio"> <label><input type="radio" name="up_profession_type" <?php echo ($userData['up_profession_type'] == "Medical") ? 'checked' : '' ?> class="ask_table_inputs" value="Medical">Medical</label></div>
<div class="radio"><label><input type="radio" name="up_profession_type" <?php echo ($userData['up_profession_type'] == "Dental") ? 'checked' : '' ?>  value="Dental">Dental</label></div>
<div class="radio"><label><input type="radio" <?php echo ($userData['up_profession_type'] == "Nursing") ? 'checked' : '' ?>  value="Nursing">Nursing</label> </div>
 <div class="radio"><label><input type="radio" <?php echo ($userData['up_profession_type'] == "Pharmacy") ? 'checked' : '' ?>  value="Pharmacy">Pharmacy</label></div>
<div class="radio"><label><input type="radio" <?php echo ($userData['up_profession_type'] == "Physiotherapy") ? 'checked' : '' ?>  value="Physiotherapy">Physiotherapy</label></div></div>
<div class="col-lg-6">
<div class="radio"><label><input type="radio" <?php echo ($userData['up_profession_type'] == "Management") ? 'checked' : '' ?>  value="Management">Management</label></div> 
<div class="radio"><label><input type="radio" <?php echo ($userData['up_profession_type'] == "Nutrition") ? 'checked' : '' ?>  value="Nutrition">Nutrition</label></div>
<div class="radio"><label><input type="radio" <?php echo ($userData['up_profession_type'] == "Homeopathy") ? 'checked' : '' ?>  value="Homeopathy">Homeopathy</label></div>
<div class="radio"><label><input type="radio" <?php echo ($userData['up_profession_type'] == "Ayurvedic") ? 'checked' : '' ?>  value="Ayurvedic">Ayurvedic</label></div> 
<div class="radio"><label><input type="radio" <?php echo ($userData['up_profession_type'] == "Chinese medicine") ? 'checked' : '' ?>  value="Chinese medicine">Chinese medicine</label> </div></div>
				   <button type="submit" name="submit" class="popup-button">Save Changes</button>  
                   <button type="submit" name="submit" data-dismiss="modal" class="popup-button" id="create-group-close">Cancel</button>
                   </form>
                </div>
                <div>
                <form action="action.php?upact=profDtil" method="post" enctype="multipart/form-data">
                 <h3 style="color:#0000B3;">If You are Professional(Medical Related)</h3>
                    <div class="col-lg-3"><label class="lablepafd">Profession:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="profession_name" value="<?php echo stripcslashes($userData['up_profession_name']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                  <div class="col-lg-3"><label class="lablepafd">Speciality:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="profession_speciality" value="<?php echo stripcslashes($userData['up_profession_speciality']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                                                    
                                  <div class="col-lg-3"><label class="lablepafd">Super Speciality:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" value="ENT" name="first_name" kl_virtual_keyboard_secure_input="on"></div>
                                  <div class="col-lg-3"><label class="lablepafd">Grade:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="profession_grade" value="<?php echo stripcslashes($userData['up_profession_grade']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                   <div class="col-lg-3"><label class="lablepafd">Hospital Address:</label></div>
                                  <div class="col-lg-9"><textarea  class="inputstyle1" style=" height:100px; " name="profession_hosp_addr" type="text"><?php echo stripcslashes($userData['up_profession_hosp_addr']); ?></textarea></div>
                                  <div class="col-lg-3"><label class="lablepafd">Medical College Address:</label></div>
                                  <div class="col-lg-9"><textarea class="inputstyle1" style="height:100px;" name="profession_med_addr" ><?php echo stripcslashes($userData['up_profession_med_addr']); ?></textarea></div>
                                  <div class="col-lg-3"><label class="lablepafd">Company Working for:</label></div>
                                  <div class="col-lg-9"><input class="inputstyle1" type="text" name="profession_company_name" value="<?php echo stripcslashes($userData['up_profession_company_name']); ?>" kl_virtual_keyboard_secure_input="on"></div>
                                  
                   <button type="submit" name="submit" class="popup-button">Save Changes</button>  
                   <button type="submit" name="submit" data-dismiss="modal" class="popup-button" id="create-group-close">Cancel</button> 
                   </form>
                </div>
                <div>
                 <h3 style="color:#0000B3;">Organization Details</h3>
                    
                     <form action="action.php?upact=orgdtil" method="post" enctype="multipart/form-data">
                                 
                                   <div class="col-lg-3"><label class="lablepafd">College Name Address:</label></div>
                                  <div class="col-lg-9"><textarea  class="inputstyle1" style=" height:100px;" name="collage_addr" type="text"><?php echo stripcslashes($userData['uo_collage_addr']); ?></textarea></div>
                                  <div class="col-lg-3"><label class="lablepafd">Hospital Name Address:</label></div>
                                  <div class="col-lg-9"><textarea  class="inputstyle1" style=" height:100px;" name="hospital_addr" type="text"><?php echo stripcslashes($userData['uo_hospital_addr']); ?></textarea></div>
                                  <div class="col-lg-3"><label class="lablepafd">Company Name Address:</label></div>
                                  <div class="col-lg-9"><textarea name="company_addr"  class="inputstyle1" style=" height:100px;" name="profession_hosp_addr" type="text"><?php echo stripcslashes($userData['uo_company_addr']); ?></textarea></div>
                                  <div class="col-lg-3"><label class="lablepafd">Many Other Name And Address:</label></div>
                                  <div class="col-lg-9"><textarea  name="other_addr"  class="inputstyle1" style=" height:100px;" name="profession_hosp_addr" type="text"><?php echo stripcslashes($userData['uo_other_addr']); ?></textarea></div>
                                  
                                  
                   <button type="submit" name="submit" class="popup-button">Save Changes</button>  
                   <button type="submit" name="submit" data-dismiss="modal" class="popup-button" id="create-group-close">Cancel</button> 
                   </form>
                </div>
                <div>
                
                </div>
                
                <div>
                
                </div>
                
                
            </div>
        </div>
        <div class="clearfix"></div>
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
                         <span class="proff-msg-btn1 topic-area">No discussion found</span>
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
<script type="text/javascript">
    $(document).ready(function() {
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
</body>

</html>