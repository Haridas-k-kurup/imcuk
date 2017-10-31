<?php 
	include_once('includes/header.php');
	if($sessionval	==	true){ header('location:index.php'); }
	include_once('class/country_details.php');
	include_once('class/state_details.php');
	include_once('class/city_details.php');
	$objState		=	new state_details();
	$contry			=	$objState->getAll("country_id=5","state_name");
	//$home 		= 	$objMgPage->getFields("mp_heading,mp_desc","page_id='".$currentPage."' and cat_id=6 and mp_status=1","mp_createdon desc");
	//$topSlide		=	$objMgPage->getAll("page_id=1 and pos_id=4 and cat_id=3 and mp_status=1","mp_createdon desc");
	//$allTopics		=	$objMgPage->getAll("page_id = '".$currentPage."' and mp_status=1","mp_createdon desc");
	$pageQuery		=	"select con.page_id, con.cat_id, con.mcp_status, pages.* from manage_pages as pages left join manage_page_connection as con on pages.mp_id = con.mp_id where page_id = '".$currentPage."' and pages.mp_staff_manage = 0 and pages.mp_status=1 and con.mcp_status = 1 order by pages.mp_createdon desc";
	$allTopics		=	$objMgPage->listQuery($pageQuery);
?>
<!--MAIN BODY START-->

<div class="container-fluid"> 
  <!--TOP SLIDER START-->
  <?php include_once(DIR_ROOT.'includes/top_slider.php'); ?>
  <div class="row">
    <div class="col-lg-2" style="padding-right:3px; padding-left:1px;">
      <div align="center" class="background1">
        <div style="color:#fff; margin-bottom:10px;" class="txtstyle1">Message Board</div>
        <!-- <p align="center"><img id="down_arrow_img1" src="assets/img/up_arraow1.png" style=" z-index:1000; position:absolute; cursor:pointer; "><p>--> 
        <!--Left vertical slider start-->
        <?php include_once(DIR_ROOT."includes/left_slider.php"); ?>
        <!--Left vertical slider end--> 
      </div>
      <div class="imc-blockcontent">
        <div align="center">
          <div class="sug-consult"> <a style="text-decoration:none;"  data-toggle="modal" data-target="#myModal">
            <div class="write_topic_container ovr">
              <label class="write_topic_head">write a new topic</label>
            </div>
            </a> </div>
        </div>
      </div>
      <div class="imc-blockcontent">
        <div align="center">
          <div class="sug-consult"> <a href="<?php echo SITE_ROOT; ?>contactus.php" style="text-decoration:none;" >
            <div class="write_topic_container ovr">
              <label class="write_topic_head">Give your Suggestions</label>
            </div>
            </a> </div>
        </div>
      </div>
      <div class="imc-blockcontent">
        <div align="center">
          <div class="doc-consult"> <a href="<?php echo SITE_ROOT; ?>ask_an_expert.php?dept=<?php echo $currentPage; ?>" style="text-decoration:none;" >
            <div class="write_topic_container ovr">
              <label class="write_topic_head">Ask an Expert</label>
            </div>
            </a>
            <p> <a href="#"> <img class="doc_img" src="<?php echo SITE_ROOT; ?>assets/images/doctor11.png"> </a></p>
          </div>
        </div>
        <div align="center">
          <div class="sug-consult"> <a style="text-decoration:none;" href="<?php echo SITE_ROOT; ?>ask_an_expert.php?dept=<?php echo $currentPage; ?>">
            <div class="write_topic_container ovr">
              <label class="write_topic_head">View Previous Q&A</label>
            </div>
            </a> </div>
        </div>
      </div>
      <div class="imc-block clearfix">
        <div class="recent_members ovr">
          <div class="recent_heading ovr">
            <label style="margin-top: 11px;">Recently joined members</label>
          </div>
          <div style="margin: 0px; height: 200px; visibility: visible; overflow: hidden; position: absolute; z-index: 2;" id="loger_slide" class="login_persons">
            <ul style="margin: 0px; padding: 0px; position: relative; list-style-type: none; z-index: 1; height: 600px; top: -200px;">
              <?php 
							foreach($recentJoin as $joined){ 
								$pName		=	($joined['ud_name_title']) ? $objCommon->html2text($joined['ud_name_title']).": ". $objCommon->html2text($joined['ud_first_name']) :  $objCommon->html2text($joined['ud_first_name']);
							?>
              <li style="list-style: outside none none; overflow: hidden; float: none; width: 100%; height: 60px; margin-bottom:3px">
                <div class="member_details ovr"> <a href="<?php echo SITE_ROOT; ?>user_profile.php?p=<?php echo stripslashes($joined['reg_private_id']); ?>&u=<?php echo stripslashes($joined['reg_id']); ?>">
                  <p class="loger_name"><?php echo stripslashes($pName); ?></p>
                  <p style="margin-top:0;" class="loger_name"><?php echo $joined['reg_createdon']; ?></p>
                  </a> </div>
              </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
      <?php include_once(DIR_ROOT.'includes/left_ads.php'); ?>
    </div>
    <div class="col-lg-8">
      <div class="row" style="margin-top:10px;">
        <div class="col-lg-12">
          <div class="ask_second_wrappper">
            <div class="ask_contant_wrapper">
              <center>
                <div class="ask_header">Registration Form</div>
              </center>
              <br/>
              <div class="date_time_head">Date and Time</div>
              <div class="time_displays">
                <div class="col-lg-6">
                  <center>
                   <?php echo $todays = date("d F o"); ?>
                  </center>
                </div>
                <div class="col-lg-6">
                  <center>
                   <?php echo $time = date("h:i"); ?> hours
                  </center>
                </div>
              </div>
              <div class="date_time_head" style="margin-top:20px;">Who Can Register</div>
              <div class="time_displays">
                <div class="col-lg-12">
                  <p>This website is for the medical professionals and patients and for any medical related organisations</p>
                </div>
              </div>
              <form action="action.php?act=register" id="signupform" method="post" enctype="multipart/form-data" >
              <div class="date_time_head" style="margin-top:20px;">Registering details</div>
              <div class="time_displays" style="padding:10px 0px;">
                <div class="col-lg-4">User/Screen Name:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;">
                    <input type="text" required style="width:100%;border:2px solid #424447;" class="ask_table_inputs" placeholder="User Name" name="reg_user_name" id="username"  kl_virtual_keyboard_secure_input="on">
                    <br /><img src="img/493.png" id="user-preload" style="display:none;" />
                                <label id="user-waring" class="pass_car_lng" style="display: none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sorry! please make changes in your username for more security.</label>
                  </div>
                </div>
                <div class="col-lg-4">Password:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;">
                    <input type="password" required style="width:100%;border:2px solid #424447;" class="ask_table_inputs" placeholder="Enter password" name="reg_pass_word" kl_virtual_keyboard_secure_input="on" title="Password should have at least six characters for more secure" pattern=".{6,}" onchange=" this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); if(this.checkValidity()) form.reg_con_pass_word.pattern = this.value;">
                  </div>
                </div>
                <div class="col-lg-4">Confirm Password:</div>
                <div class="col-lg-8">
                  <input type="password" required style="width:100%;border:2px solid #424447;" class="ask_table_inputs" placeholder="Confirm Password" name="reg_con_pass_word" pattern=".{6,}" onchange=" this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); " kl_virtual_keyboard_secure_input="on">
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="date_time_head" style="margin-top:20px;">Personal details</div>
              <div class="time_displays" style="padding:10px 0px;">
                <div class="col-lg-4">Title:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <select style="border:2px solid #424447; width:100%" class="ask_table_inputs name_title" id="reg_name_title" name="ud_name_title">
                      <option value="">-- SELECT --</option>
                      <option value="Mr">Mr</option>
                      <option value="Mrs">Mrs</option>
                      <option value="Ms">Ms</option>
                      <option value="Miss">Miss</option>
                      <option value="Dr">Dr</option>
                      <option value="Prof">Prof</option>
                      <option value="Others">Others</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-4">First Name:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;">
                    <input type="text" required style="width:100%; border:2px solid #424447;" class="ask_table_inputs" placeholder="Enter First Name" name="ud_first_name" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-4">Other Name:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input type="text"  style="width:100%;border:2px solid #424447;" class="ask_table_inputs" placeholder="Enter Other Name" name="ud_other_name"  kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-4">Gender:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <select style="border:2px solid #424447; width:100%" class="ask_table_inputs name_title" name="ud_gender">
                      <option value="">-- SELECT GENDER --</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-12"><span style="color:#00007D; font-weight:bold;">Address(country of orgin)</span></div>
                <div class="col-lg-4" style="padding-left:5%;">Country:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <select style="border:2px solid #424447; width:100%" class="ask_table_inputs name_title" name="ud_country" id="ud_country">
                      <option value="India">India</option>
                      <option value="Other">Other</option>
                    </select>
                    <input type="text" style="width:100%;border:2px solid #424447;display:none;" class="ask_table_inputs"  name="ud_other_country" id="ud_other_country" >
                  </div>
                </div>
                <div class="col-lg-4" style="padding-left:5%;">State:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <select style="border:2px solid #424447; width:100%" class="ask_table_inputs name_title" name="ud_state" id="ud_state">
                      <option value="">-- SELECT --</option>
                      <?php foreach($contry as $contries) {?>
                         <option value="<?php echo $contries['state_name']; ?>"><?php echo $contries['state_name']; ?></option>
                      <?php } ?>
                      <input type="text" style="width:100%;border:2px solid #424447;display:none;" name="ud_other_state" id="ud_other_state" class="ask_table_inputs" >
                    </select>
                  </div>
                </div>
                <div class="col-lg-4" style="padding-left:5%;">Districk(City):</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input type="text" style="width:100%; border:2px solid #424447;" class="ask_table_inputs" id="ud_city" name="ud_city" placeholder="Enter city" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-4" style="padding-left:5%;">Taluk(Town):</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input type="text" style="width:100%; border:2px solid #424447;" class="ask_table_inputs" id="ud_town" placeholder="Enter town" name="ud_town" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-4" style="padding-left:5%;">Place:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input type="text" style="width:100%; border:2px solid #424447;" class="ask_table_inputs" id="ud_place" placeholder="Enter place" name="ud_place" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-4" style="padding-left:5%;">Street Name/No:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input type="text" style="width:100%; border:2px solid #424447;" class="ask_table_inputs" id="ud_street_name" placeholder="Enter Street name" name="ud_street_name" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-4" style="padding-left:5%;">House Name/No:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input type="text" style="width:100%; border:2px solid #424447;" class="ask_table_inputs" id="ud_house_name" placeholder="Enter house name" name="ud_house_name" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-4" style="padding-left:5%;">Postal Code:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input type="text" style="width:100%; border:2px solid #424447;" class="ask_table_inputs" id="ud_post_code" name="ud_post_code" placeholder="Enter postal code" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-4">Current Address:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <label style="font-weight:normal;" class="ask_table_label">
                      <input type="checkbox" style="width:0;" value="1" name="current-address" id="current-address">
                      &nbsp;If not same as above</label>
                  </div>
                </div>
                <!--CURRENT ADDRESS START-->
                <div class="current-address" style="display:none;" id="current-addr-dtil">
                	<div class="col-lg-4" style="padding-left:5%;">Country:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <select style="border:2px solid #424447; width:100%" class="ask_table_inputs name_title" name="cur_country" id="cur_country">
                      <option value="India">India</option>
                      <option value="Other">Other</option>
                    </select>
                    <input type="text" style="width:100%;border:2px solid #424447;display:none;" class="ask_table_inputs"  name="cur_other_country" id="cur_other_country" >
                  </div>
                </div>
                <div class="col-lg-4" style="padding-left:5%;">State:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <select style="border:2px solid #424447; width:100%" class="ask_table_inputs name_title" name="cur_state" id="cur_state">
                      <option value="">-- SELECT --</option>
                      <?php foreach($contry as $contries) {?>
                         <option value="<?php echo $contries['state_name']; ?>"><?php echo $contries['state_name']; ?></option>
                      <?php } ?>
                      <input type="text" style="width:100%;border:2px solid #424447;display:none;" name="cur_other_state" id="cur_other_state" class="ask_table_inputs" >
                    </select>
                  </div>
                </div>
                <div class="col-lg-4" style="padding-left:5%;">Districk(City):</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input type="text" style="width:100%; border:2px solid #424447;" class="ask_table_inputs" name="cur_city" id="cur_city" placeholder="Enter city" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-4" style="padding-left:5%;">Taluk(Town):</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input type="text" style="width:100%; border:2px solid #424447;" class="ask_table_inputs" id="cur_town" placeholder="Enter town" name="cur_town" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-4" style="padding-left:5%;">Place:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input type="text" style="width:100%; border:2px solid #424447;" class="ask_table_inputs" id="cur_place" placeholder="Enter place" name="cur_place" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-4" style="padding-left:5%;">Street Name/No:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input type="text" style="width:100%; border:2px solid #424447;" class="ask_table_inputs" id="cur_street_name" placeholder="Enter Street name" name="cur_street_name" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-4" style="padding-left:5%;">House Name/No:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input type="text" style="width:100%; border:2px solid #424447;" class="ask_table_inputs" id="cur_house_name" placeholder="Enter house name" name="cur_house_name" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-4" style="padding-left:5%;">Postal Code:</div>
                
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input type="text" style="width:100%; border:2px solid #424447;" class="ask_table_inputs" name="cur_post_code" id="cur_post_code"  placeholder="Enter postal code" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                </div>
                <!--CURRENT ADDRESS END-->
                <div class="col-lg-4">Date of Birth:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input style="width:100%; border:2px solid #424447;" type="text" title="We ask for your date of birth only for statistical purposes" style="width:60%;margin-right:43px" class="ask_table_inputs personal_input hasDatepicker" id="ud_dob" placeholder="Select date of birth" name="ud_dob" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-4">Age Range:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <select style="width:100%; border:2px solid #424447;" name="age_range" class="ask_table_inputs name_title" style="width:60%;margin-right:43px">
                    <option value="">------------ SELECT RANGE ------------</option>
                    <option value="10-20">10-20</option>
                    <option value="20-30">20-30</option>
                    <option value="30-40">30-40</option>
                    <option value="40-50">40-50</option>
                    <option value="50-60">50-60</option>
                    <option value="60-70">60-70</option>
                    <option value="70-80">70-80</option>
                    <option value="80-90">80-90</option>
                    <option value="90-100">90-100</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-4">Email:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input style="width:100%; border:2px solid #424447;" type="email" required style="width:60%;margin-right:43px" class="ask_table_inputs personal_input" id="ud_email" placeholder="Enter email" name="ud_email"><br />
                    <label id="email-waring" class="pass_car_lng" style="display: none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sorry! This email already registered with IMC.</label>
                  </div>
                </div>
                <div class="col-lg-4">Facebook ID:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input type="text"  style="width:100%; border:2px solid #424447;" class="ask_table_inputs personal_input" id="ud_facebook" placeholder="Enter facebook ID" name="ud_facebook" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-4">Other Social Media ID:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input style="width:100%; border:2px solid #424447;" type="text" style="width:60%;margin-right:43px" class="ask_table_inputs personal_input" id="ud_facebook" placeholder="Enter other social media ID" name="ud_other_social" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-12"><span style="color:#00007D; font-weight:bold;">Tel Number</span></div>
                <div class="col-lg-4" style="padding-left:5%;">Home:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input style="width:100%; border:2px solid #424447;" type="text" class="ask_table_inputs" id="ud_tel_home" name="ud_tel_home" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-4" style="padding-left:5%;">Work:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input style="width:100%; border:2px solid #424447;" type="text" s="" class="ask_table_inputs" id="ud_tel_work" name="ud_tel_work" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-4" style="padding-left:5%;">Mobile:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left">
                    <input style="width:100%; border:2px solid #424447;" type="text" class="ask_table_inputs" id="ud_tel_mob" name="ud_tel_mob" kl_virtual_keyboard_secure_input="on">
                  </div>
                </div>
                <div class="col-lg-4">Profile pictures:</div>
                <div class="col-lg-8">
                  <div style="padding-bottom:10px;" align="left" id="preview">
                    <input style="width:100%; border:2px solid #424447;padding:0;" type="file" name="attachement" id="attachmentFile"  class="ask_table_inputs personal_input form-control" >
                    <div id='imageloadstatus' class="profile_preview" style='display:none;border:none;'><img src="img/725.gif" style="margin-top:10px;" alt="Uploading...."/></div>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="time_displays" style="padding:10px 0px;">
                <div class="col-lg-12"><span style="color:#00007D; font-weight:bold;">Select registration category</span></div>
                <div class="col-lg-4">
                  <label style="font-weight:normal; font-size:18px;" for="reg_med_prof" style="cursor:pointer;">
                  <input type="radio" required value="1" id="reg_med_prof" name="reg_type">
                  Medical related professionals
                  </label>
                </div>
                <div class="col-lg-4">
                  <label style="font-weight:normal; font-size:18px;" for="reg_med_org" style="cursor:pointer;">
                  <input type="radio" required name="reg_type" id="reg_med_org" value="2">
                  Medical Organizations
                  </label>
                </div>
                <div class="col-lg-4">
                  <label style="font-weight:normal; font-size:18px;" for="reg_med_pat" style="cursor:pointer;">
                  <input type="radio" required name="reg_type" id="reg_med_pat" value="3">
                  Patient(non medical persons)
                  </label>
                </div>
                <div class="clearfix"></div>
              </div>
              <!--STUDENT FORM START-->
              <div class="imc-drop-box" id="reg_category_student">
              		<div class="imc-drop-inner">
                    <div class="form-group">
                              <div class="col-lg-12"><span style="color:#00007D; font-weight:bold; font-size:20px;">If you are a medical related student</span></div>              
                                        <label class="">
                                            <div class="iradio_minimal checked" style="position: relative;" aria-disabled="false"><input type="radio"  class="minimal student-radio" name="up_student_course" id="up_student_course1" value="Medical" ></div>
                                        </label>
                                        <label for="up_student_course1">
                                           Medical
                                        </label>
                                        
                                        
                                        <label class="">
                                            <div class="iradio_minimal checked" style="position: relative;" ><input type="radio"  class="minimal student-radio" name="up_student_course" id="up_student_course2" value="Dental" ></div>
                                        </label>
                                        <label for="up_student_course2">
                                            Dental
                                        </label>
                                        
                                         <label class="">
                                            <div class="iradio_minimal checked" style="position: relative;" ><input type="radio"  class="minimal student-radio" name="up_student_course" id="up_student_course3" value="Nursing" ></div>
                                        </label>
                                        <label for="up_student_course3">
                                            Nursing
                                        </label>
                                        
                                        <label class="">
                                            <div class="iradio_minimal checked" style="position: relative;" ><input type="radio"  class="minimal student-radio" name="up_student_course" id="up_student_course4" value="Pharmacy" ></div>
                                        </label>
                                        <label for="up_student_course4">
                                            Pharmacy
                                        </label>
                                        
                                        <label class="">
                                            <div class="iradio_minimal checked" style="position: relative;" ><input type="radio"  class="minimal student-radio" name="up_student_course" id="up_student_course5" value="Physiotherapy" ></div>
                                        </label>
                                        <label for="up_student_course5">
                                            Physiotherapy
                                        </label>
                                        
                                         <label class="">
                                            <div class="iradio_minimal checked" style="position:relative;" ><input type="radio"  class="minimal student-radio" name="up_student_course" id="up_student_course6" value="Management" ></div>
                                        </label>
                                        <label for="up_student_course6">
                                            Management
                                        </label>
                                        
                                        <label class="">
                                            <div class="iradio_minimal checked" style="position:relative;" ><input type="radio"  class="minimal student-radio" name="up_student_course" id="up_student_course7" value="Nutrition" ></div>
                                        </label>
                                        <label for="up_student_course7">
                                            Nutrition
                                        </label>
                                        
                                         <label class="">
                                            <div class="iradio_minimal checked" style="position:relative;" ><input type="radio"  class="minimal student-radio" name="up_student_course" id="up_student_course8" value="Homeopathy" ></div>
                                        </label>
                                        <label for="up_student_course8">
                                            Homeopathy
                                        </label>
                                        
                                         <label class="">
                                            <div class="iradio_minimal checked" style="position:relative;" ><input type="radio"  class="minimal student-radio" name="up_student_course" id="up_student_course9" value="Ayurvedic" ></div>
                                        </label>
                                        <label for="up_student_course9">
                                            Ayurvedic
                                        </label>
                                        
                                         <label class="">
                                            <div class="iradio_minimal checked" style="position:relative;" ><input type="radio"  class="minimal student-radio" name="up_student_course" id="up_student_course10" value="Chinese medicine" ></div>
                                        </label>
                                        <label for="up_student_course10">
                                            Chinese medicine
                                        </label>
                                        <div class="row">
                                        	<div class="col-lg-4 reg-text"><label class="ask_table_label" style="font-weight:normal;">
                      <input type="checkbox" name="ask_specialty_name" id="r_other" style="width:0;">
                      &nbsp;Other</div>
                                            <div class="col-lg-8">
                                              <input type="text" style="width:100%;border:2px solid #424447; border-radius:0; display:none;" class="ask_table_inputs form-control" name="up_student_other_course" id="r_other_text" kl_virtual_keyboard_secure_input="on" placeholder="Specify your course...">
                                            </div>
                                        </div>
                                    </div>
                    </div>
              </div>
              <!--STUDENT FORM END-->
              <!--STUDENT FORM START-->
              <div class="imc-drop-box" id="reg_category_professional">
              		<div class="imc-drop-inner">
                    <div class="form-group">
                              <div class="col-lg-12"><span style="color:#00007D; font-weight:bold; font-size:20px;">If you are medical related professional( not student )</span></div>              
                                        <label class="">
                                            <div class="iradio_minimal checked" style="position: relative;" aria-disabled="false"><input type="radio"  class="minimal prof-radio" name="up_profession_type" id="up_profession_type1" value="Medical" ></div>
                                        </label>
                                        <label for="up_profession_type1">
                                           Medical
                                        </label>
                                        
                                        
                                        <label class="">
                                            <div class="iradio_minimal checked" style="position: relative;" ><input type="radio"  class="minimal prof-radio" name="up_profession_type" id="up_profession_type2" value="Dental" ></div>
                                        </label>
                                        <label for="up_profession_type2">
                                            Dental
                                        </label>
                                        
                                        
                                         <label class="">
                                            <div class="iradio_minimal checked" style="position: relative;" ><input type="radio"  class="minimal prof-radio" name="up_profession_type" id="up_profession_type3" value="Nursing" ></div>
                                        </label>
                                        <label for="up_profession_type3">
                                            Nursing
                                        </label>
                                        
                                        <label class="">
                                            <div class="iradio_minimal checked" style="position: relative;" ><input type="radio"  class="minimal prof-radio" name="up_profession_type" id="up_profession_type4" value="Pharmacy" ></div>
                                        </label>
                                        <label for="up_profession_type4">
                                            Pharmacy
                                        </label>
                                        
                                        
                                        <label class="">
                                            <div class="iradio_minimal checked" style="position: relative;" ><input type="radio"  class="minimal prof-radio" name="up_profession_type" id="up_profession_type5" value="Physiotherapy" ></div>
                                        </label>
                                        <label for="up_profession_type5">
                                            Physiotherapy
                                        </label>
                                        
                                        
                                         <label class="">
                                            <div class="iradio_minimal checked" style="position:relative;" ><input type="radio"  class="minimal prof-radio" name="up_profession_type" id="up_profession_type6" value="Management" ></div>
                                        </label>
                                        <label for="up_profession_type6">
                                            Management
                                        </label>
                                        
                                        
                                        <label class="">
                                            <div class="iradio_minimal checked" style="position:relative;" ><input type="radio" class="minimal prof-radio" name="up_profession_type" id="up_profession_type7" value="Nutrition" ></div>
                                        </label>
                                        <label for="up_profession_type7">
                                            Nutrition
                                        </label>
                                        
                                         <label class="">
                                            <div class="iradio_minimal checked" style="position:relative;" ><input type="radio"  class="minimal prof-radio" name="up_profession_type" id="up_profession_type8" value="Homeopathy" ></div>
                                        </label>
                                        <label for="up_profession_type8">
                                            Homeopathy
                                        </label>
                                        
                                         <label class="">
                                            <div class="iradio_minimal checked" style="position:relative;" ><input type="radio"  class="minimal prof-radio" name="up_profession_type" id="up_profession_type9" value="Ayurvedic" ></div>
                                        </label>
                                        <label for="up_profession_type9">
                                            Ayurvedic
                                        </label>
                                        
                                        
                                         <label class="">
                                            <div class="iradio_minimal checked" style="position:relative;" ><input type="radio"  class="minimal prof-radio" name="up_profession_type" id="up_profession_type10" value="Chinese medicine" ></div>
                                        </label>
                                        <label for="up_profession_type10">
                                            Chinese medicine
                                        </label>
                                        <div class="row">
                                        	<div class="col-lg-4 reg-text"><label class="ask_table_label" style="font-weight:normal;">
                      <input type="checkbox" name="ask_specialty_name" id="r_job_other" value="1" style="width:0;">
                      &nbsp;Other</div>
                                            <div class="col-lg-8">
                                              <input type="text" style="width:100%;border:2px solid #424447; border-radius:0; display:none;" class="ask_table_inputs form-control" name="up_profession_other_type" id="r_job_other_text" kl_virtual_keyboard_secure_input="on" placeholder="Specify your job...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="reg-add-info">
                                    	<div class="row">
                                        	<div class="col-lg-4 reg-text">Profession:</div>
                                            <div class="col-lg-8">
                                              <input type="text" style="width:100%;border:2px solid #424447; border-radius:0;" class="ask_table_inputs form-control" name="up_profession_name" id="up_profession_name" kl_virtual_keyboard_secure_input="on">
                                            </div>
                                        </div><br />
                                        <div class="row">
                                        	<div class="col-lg-4 reg-text">Speciality:</div>
                                            <div class="col-lg-8">
                                              <input type="text" style="width:100%;border:2px solid #424447; border-radius:0;" class="ask_table_inputs form-control" name="up_profession_speciality" id="up_profession_speciality" kl_virtual_keyboard_secure_input="on">
                                            </div>
                                        </div><br />
                                        <div class="row">
                                        	<div class="col-lg-4 reg-text">Super speciality:</div>
                                            <div class="col-lg-8">
                                              <input type="text" style="width:100%;border:2px solid #424447; border-radius:0;" class="ask_table_inputs form-control" name="up_profession_sup_speciality" id="up_profession_sup_speciality" kl_virtual_keyboard_secure_input="on">
                                            </div>
                                        </div><br />
                                        <div class="row">
                                        	<div class="col-lg-4 reg-text">Grade:</div>
                                            <div class="col-lg-8">
                                              <input type="text" style="width:100%; border:2px solid #424447;border-radius:0;" class="ask_table_inputs form-control" name="up_profession_grade" id="up_profession_grade" kl_virtual_keyboard_secure_input="on">
                                            </div>
                                        </div><br />
                                        <div class="row">
                                        	<div class="col-lg-4 reg-text">Hospital address:</div>
                                            <div class="col-lg-8">
                                              <textarea name="up_profession_hosp_addr" id="up_profession_hosp_addr" class="ask_table_inputs" style="width:100%;resize:vertical;border:2px solid #424447;" ></textarea>
                                            </div>
                                        </div><br />
                                        <div class="row">
                                        	<div class="col-lg-4 reg-text">Medical college address:</div>
                                            <div class="col-lg-8">
                                              <textarea name="up_profession_med_addr" id="up_profession_med_addr" class="ask_table_inputs" style="width:100%; resize:vertical;border:2px solid #424447;"></textarea>
                                            </div>
                                        </div><br />
                                        <div class="row">
                                        	<div class="col-lg-4 reg-text">Company working for:</div>
                                            <div class="col-lg-8">
                                              <input type="text" style="width:100%;border:2px solid #424447; border-radius:0;" class="ask_table_inputs form-control" name="up_profession_company_name" id="up_profession_company_name" kl_virtual_keyboard_secure_input="on">
                                            </div>
                                        </div>
                                        
                                    </div>
                    </div>
              </div>
              <!--STUDENT FORM END-->
              <!--ORGANIZATION START-->
              <div class="imc-drop-box" id="reg_category_organization">
              		<div class="imc-drop-inner">
                    <div class="form-group">
                              <div class="col-lg-12"><span style="color:#00007D; font-weight:bold; font-size:20px;">If you are a medical related organization</span></div>              
                                      <div class="row">
                                        	<div class="col-lg-4 reg-text">College name address:</div>
                                            <div class="col-lg-8">
                                              <textarea style="width:100%;border:2px solid #424447;border-radius:0; resize:vertical;" class="ask_table_inputs form-control" name="uo_collage_addr" id="uo_collage_addr" kl_virtual_keyboard_secure_input="on"></textarea>
                                            </div>
                                        </div><br />
                                        <div class="row">
                                        	<div class="col-lg-4 reg-text">Hospital name address:</div>
                                            <div class="col-lg-8">
                                             <textarea style="width:100%;border:2px solid #424447; border-radius:0; resize:vertical;" class="ask_table_inputs form-control" name="uo_hospital_addr" id="uo_hospital_addr" kl_virtual_keyboard_secure_input="on"></textarea>
                                            </div>
                                        </div><br />
                                        <div class="row">
                                        	<div class="col-lg-4 reg-text">Company name address:</div>
                                            <div class="col-lg-8">
                                             <textarea style="width:100%;border:2px solid #424447; border-radius:0; resize:vertical;" class="ask_table_inputs form-control" name="uo_company_addr" id="uo_company_addr" kl_virtual_keyboard_secure_input="on"></textarea>
                                            </div>
                                        </div><br />
                                        <div class="row">
                                        	<div class="col-lg-4 reg-text">Any other name and address:</div>
                                            <div class="col-lg-8">
                                             <textarea style="width:100%;border:2px solid #424447; border-radius:0; resize:vertical;" class="ask_table_inputs form-control" name="uo_other_addr" id="uo_other_addr" kl_virtual_keyboard_secure_input="on"></textarea>
                                            </div>
                                        </div>
                                    </div>
                    </div>
              </div>
              <!--ORGANIZATION END-->
              <!--PATIENT START-->
              	<div class="imc-drop-box"  id="reg_category_patient">
              		<div class="imc-drop-inner">
                    <div class="form-group">
                              <div class="col-lg-12"><span style="color:#00007D; font-weight:bold; font-size:20px;">If you are a patient</span></div>              
                                      <div class="row">
                                        	<div class="col-lg-4 reg-text">Student:</div>
                                            <div class="col-lg-8">
                                              <input type="text" style="width:100%;border:2px solid #424447; border-radius:0;" class="ask_table_inputs form-control" name="upt_details" id="upt_details" kl_virtual_keyboard_secure_input="on">
                                            </div>
                                        </div><br />
                                        <div class="row">
                                        	<div class="col-lg-4 reg-text">Occupation:</div>
                                            <div class="col-lg-8">
                                              <input type="text" style="width:100%;border:2px solid #424447; border-radius:0;" class="ask_table_inputs form-control" name="upt_occupation" id="upt_occupation" kl_virtual_keyboard_secure_input="on">
                                            </div>
                                        </div>
                                    </div>
                    </div>
              </div>
              <!--PATIENT END-->
              <!--ABOUT YOURSELF START-->
              <div class="imc-drop-box" id="reg_category_information">
              		<div class="imc-drop-inner">
                    <div class="form-group">
                              <div class="col-lg-12"><span style="color:#00007D; font-weight:bold; font-size:20px;">Information about yourself</span></div>              
                                       
                                            <textarea name="reg_other_info" id="reg_other_info" class="ask_table_inputs ckeditor" style="width:100%; resize:vertical;"></textarea>
                                            <div class="col-lg-12"><span style="color:#00007D; font-weight:bold; font-size:20px;">Acheivements</span></div>
                        <textarea name="up_profession_acheive" id="up_profession_acheive" class="ask_table_inputs ckeditor" style="width:100%; resize:vertical;"></textarea>               
                                        
                                        
                    	</div>
                    </div>
              </div>
              <!--ABOUT YOURSELF END-->
              <div style="padding:20px 0px;">
                <div class="col-lg-6">
                  <center>
                    <input type="reset" class="ask_buttons" value="Cancel" id="ask_preview" name="ask_preview" kl_virtual_keyboard_secure_input="on">
                  </center>
                </div>
                <div class="col-lg-6">
                  <center>
                    <input type="submit" class="ask_buttons" value="Submit" id="ask_preview" name="ask_preview" kl_virtual_keyboard_secure_input="on">
                  </center>
                </div>
                </form>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-2"  style="padding-right:3px; padding-left:1px;">
      <div align="center" class="background1">
        <div style="color:#fff; margin-bottom:10px;" class="txtstyle1">Message Board</div>
        <div class="table-article" id="left_verical_art" style="margin:0 2px;">
          <ul style="height:450px;">
            <?php foreach ($allTopics as $rightSlide) { 
				  if ($rightSlide['cat_id'] == 5) {
					$imgCont	= stripslashes($rightSlide['mp_desc']);
					preg_match('/<img.+src=[\'"](?P<src>.+)[\'"].*>/i',$imgCont,$image);
			?>
            <li><a href="<?php echo SITE_ROOT; ?>story_more.php?story=<?php echo $rightSlide['mp_id']; ?>">
              <div class="news_post ovr">
                <div class="news_post_img"><img class="img-responsive img-thumbnail margin-top-5" src="<?php echo $image['src']; ?>" /></div>
                <div style="color:#000;" class="news_msg_contant ovr"><?php echo substr($rightSlide['mp_heading'],0,75); ?></div>
              </div>
              </a> </li>
            <?php
				  }
			  }
			 ?>
          </ul>
        </div>
      </div>
      <div align="center" class="background1" style="margin-top:10px;">
        <?php include_once(DIR_ROOT.'includes/right_ads.php'); ?>
      </div>
    </div>
  </div>
</div>
<!--TOP SLIDER END-->

</div>
<!--MAIN BODY END--> 

<!--Slider Plugin Start-->
<link rel="stylesheet" href="assets/js/slide/flexslider.css" type="text/css" media="screen" />
<script src="assets/js/slide/jquery.flexslider-min.js"></script> 
<script type="text/javascript">
		$(window).load(function() {
			$('.flexslider').flexslider();
		});
	</script> 
 
<!--Slider Plugin End--> 
<script type="text/javascript">
/*code for login toggle start*/
		$("#msg_slide").jCarouselLite({
		vertical:true,
		auto:5000,
		speed:1500,
		visible:4,
		btnNext:"#up_arrow_img1",
		btnPrev:"#down_arrow_img1",
		hoverPause:true,
		mouseWheel:true
		});
$("#left_verical_art").jCarouselLite({
		vertical:true,
		auto:5000,
		speed:1500,
		visible:4,
		btnNext:"#up_arrow_img",
		btnPrev:"#down_arrow_img",
		hoverPause:true,
		mouseWheel:true
		
		}); 
		$("#loger_slide").jCarouselLite({
		vertical:true,
		auto:100,
		speed:2000,
		visible:4,
		hoverPause:true,
		mouseWheel:true
		
		}); 

		
		// to hide popup notification


		 

			</script> 
<script type="text/javascript">

  $("#flexiselDemo3").flexisel({
        visibleItems:4,
        animationSpeed: 1000,
        autoPlay: true,
        autoPlaySpeed: 3000,            
        pauseOnHover: true,
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: { 
            portrait: { 
                changePoint:480,
                visibleItems: 1
            }, 
            landscape: { 
                changePoint:640,
                visibleItems: 2
            },
            tablet: { 
                changePoint:768,
                visibleItems: 3
            }
        }
    });

/*code for login toggle end*/				

			</script> 
<script type="text/javascript">
$(function(){
//$( document ).tooltip();
/*$("#ud_dob" ).datepicker({
dateFormat : 'yy-mm-dd',
changeMonth: true,
changeYear: true,
maxDate: new Date,
yearRange: '1915:2015',
onSelect: function(dateText, datePicker) {
$(this).attr('value', dateText); }
});*/

$('#ud_email').blur(function(){ 
	$('#email-waring').hide();
	var email		=	$(this).val();
	if(email){
	$('#email-preload').show();
	var dataString	=	'email='+email;
		$.ajax({
				type:"POST",
				data:dataString,
				url:"ajax/reg_mail_validation.php",
				cache:false,
				success:function(data){
					$('#email-preload').hide();
					if(data	==	1){
						$('#email-waring').show();
						$('#ud_email').val("");
						$('#ud_email').focus();	
					}else{
						$('#email-waring').hide();
					}
				}
			});
	}
	});
	$('#username').blur(function(){ 
	$('#user-waring').hide();
	var user		=	$(this).val();
	if(user){
	$('#user-preload').show();
	var dataString	=	'user='+user;
	
		$.ajax({
				type:"POST",
				data:dataString,
				url:"ajax/username_validation.php",
				cache:false,
				success:function(data){ 
					$('#user-preload').hide();
					if(data	==	1){
						$('#user-waring').show();
						$('#username').val("");
						$('#username').focus();	
					}else{
						$('#user-waring').hide();
					}
				}
				
			});
	}
	});
/*$('#news_table').mouseover(function(){
		$('#up_arrow_img,#down_arrow_img').fadeIn(1500);
	});
	$('#news_table').mouseleave(function(){
		$('#up_arrow_img,#down_arrow_img').fadeOut(1000);
	});*/
/*$('#msg_board').mouseover(function(){
		$('#up_arrow_img1,#down_arrow_img1').fadeIn(1500);
	});
	$('#msg_board').mouseleave(function(){
		$('#up_arrow_img1,#down_arrow_img1').fadeOut(1000);
	});*/

	$('#r_other').on('change',function(){
		if($(this).is(':checked')){
			$('#r_other_text').fadeIn(1000);
		}
		else{
			$('#r_other_text').fadeOut(1000);
		}
	});
	$('#r_job_other').on('change',function(){
		if($(this).is(':checked')){
			$('#r_job_other_text').fadeIn(1000);
		}
		else{
			$('#r_job_other_text').fadeOut(1000);
		}
	});
	
	$('#reg_name_title').on('change',function(){
		var title	=	$(this).val()
		if(title== "Others"){
				$('#name_title_other').fadeIn(1000);
			}
			else{
				$('#name_title_other').fadeOut(1000);
			}
		});
	$('#ud_country').on('change',function(){ 
		
		var contry	=	$('#ud_country').val();
		if(contry	==	"Other"){
			$('#ud_state').hide();
			$('#ud_country').hide();
			$('#ud_other_state').show();	
			$('#ud_other_country').show();
		}
		else{
			$('#ud_other_state').hide();
			$('#ud_other_country').hide();	
			$('#ud_state').show();
			$('#ud_country').show();
		}
		});
		$('#cur_country').on('change',function(){
		
		var contry	=	$('#cur_country').val();
		if(contry	==	"Other"){
			$('#cur_state').hide();
			$('#cur_country').hide();
			$('#cur_other_state').show();	
			$('#cur_other_country').show();
		}
		else{
			$('#cur_other_state').hide();
			$('#cur_other_country').hide();	
			$('#cur_state').show();
			$('#cur_country').show();
		}
		});
	$('#reg_med_prof').click(function(){
			$('#reg_category_student').slideDown(2000);
			$('#reg_category_professional').slideDown(3000);
			$('#reg_category_information').slideDown(4000);
			$('#reg_category_patient').hide();
			$('#reg_category_organization').hide();
		});
		
	$('#reg_med_org').click(function(){
			$('#reg_category_student').hide();
			$('#reg_category_professional').hide();
			$('#reg_category_patient').hide();
			$('#reg_category_organization').slideDown(1000);
			$('#reg_category_information').slideDown(2000);
		});
	$('#reg_med_pat').click(function(){
			$('#reg_category_student').hide();
			$('#reg_category_professional').hide();
			$('#reg_category_organization').hide();
			$('#reg_category_patient').slideDown(1000);
			$('#reg_category_information').slideDown(2000);
		});	
});		
</script>
<script type="text/javascript" language="javascript">
$('.not-student').click(function(){
		$('.as-student').prop('checked', false);
	});
	$('.as-student').click(function(){
		$('.not-student').prop('checked', false);
	});

	$(document).on("click","#current-address",function(){
			var checked_status = this.checked;
				if(checked_status){
					$('#current-addr-dtil').show();
				}else{
					$('#current-addr-dtil').hide();
				}
			});
</script>
<script language="JavaScript" type="text/javascript">
$("#attachmentFile").on('change',function(){
	if($("#attachmentFile").val()!=""){
		$('#imageloadstatus').fadeIn(1000);
		/*setTimeout(function(){
			$("#attachmentFile").upload('upload.php', function(res) { 
				$('#imageloadstatus').hide();
				if(res!=""){ 
					$("#attachmentFile").hide();
					$("#preview").html(res);
					//$("#fileName").val('');
				}
				else{
					alert("Sorry your image is not uploaded Properly. Please fill mandatory fields and try again !");
				}
			});
		},3000);*/
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

// uncheck all the prof catagory
$('.student-radio').click(function() {  $('.prof-radio').prop('checked', false); });

// uncheck all the student catagory
$('.prof-radio').click(function() {  $('.student-radio').prop('checked', false); });

</script>
<?php include_once('includes/footer.php'); ?>
</body></html>