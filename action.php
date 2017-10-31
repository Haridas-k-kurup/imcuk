<?php
	session_start();
	include_once("includes/site_root.php");
	include_once(DIR_ROOT."includes/session_check.php");
	include_once(DIR_ROOT."includes/action_functions.php");
	include_once(DIR_ROOT.'class/registration_details.php');
	include_once(DIR_ROOT.'class/user_details.php');
	include_once(DIR_ROOT.'class/user_professionals_details.php');
	include_once(DIR_ROOT.'class/user_organizations_details.php');
	include_once(DIR_ROOT.'class/user_patient_details.php');
	include_once(DIR_ROOT.'class/forum_topics.php');
	include_once(DIR_ROOT.'class/forum_discussion.php');
	include_once(DIR_ROOT.'class/group_info.php');
	include_once(DIR_ROOT.'class/group_members.php');
	include_once(DIR_ROOT.'class/forum_topic_like.php');
	include_once(DIR_ROOT.'class/forum_discussion_like.php');
	include_once(DIR_ROOT."class/contact_us_form.php");
	include_once(DIR_ROOT."class/ask_question.php");
	include_once(DIR_ROOT."class/ask_q_like.php");
	
	$notfn						=	new notification_types();
	$objCommon					=	new common_functions();
	$objReg						=	new registration_details();
	$objUser					=	new user_details();
	$objProf					=	new user_professionals_details();
	$objOrg						=	new user_organizations_details();
	$objpat						=	new user_patient_details();
	$objThread					=	new forum_topics();
	$objDiscus					=	new forum_discussion();
	$objGroup					=	new group_info();
	$objMember					=	new group_members();
	$objTLike					=	new forum_topic_like();
	$objDLike					=	new	forum_discussion_like();
	$objConFrom					=	new contact_us_form();
	$objAsk						=	new ask_question();
	$objAskLike					=	new ask_q_like();
	$loginId					=	$_SESSION['loginId'];
	$currentTime				=	date("Y-m-d H:i:s");
	
	if(isset($_GET['act']) && $_GET['act']=="login" && $_POST['user']!='' && $_POST['pass']!=''){
		$username				=		$objCommon->esc(trim($_POST['user']));
		$password				=		$objCommon->esc(trim($_POST['pass']));
		$getRegSql				=		"select reg_id, reg_user_name,reg_pass_word from registration_details where reg_user_name ='".$username."' and  reg_pass_word ='".md5($password)."' and reg_staff_manage = 0 and reg_status=1";
		$getRegCount							=		$objReg->countRows($getRegSql);
		if($getRegCount >0){
			$getRegDetails						=		$objReg->getRowSql($getRegSql);
			$_SESSION['loginId']				=		$getRegDetails['reg_id'];
			$ip									=		$objCommon->get_ip();
			$last_visit_time					=		date('Y-m-d H:i:s');
			$objReg->updateField(array("reg_last_visit"=>$last_visit_time,"last_visit_ip"=>$ip,"reg_login_status" => 1),"reg_id=".$getRegDetails['reg_id']); 
			 
			header("location:".$_SERVER['HTTP_REFERER']);
			$notfn->add_msg("Congratulations you have successfully logged in !",3);
		}else{
			$notfn->add_msg("Invalid username or password. Please try again or &nbsp;&nbsp; <a href=\"pssword-reset.php\" style=\"text-decoration:underline\"><strong>request a new one.</strong></a>",4);
			header("location:".$_SERVER['HTTP_REFERER']);
		}
	}
	/*-------- Registration Details ---------*/
	else if(isset($_GET['act']) && $_GET['act']=="register" && $_POST['reg_user_name']!=''){ 
        $ipaddress = $objCommon->get_ip();
		mysql_query("SET AUTOCOMMIT	= 0");
		mysql_query("START TRANSACTION");
		$orginalPass								=	$objCommon->esc(trim($_POST['reg_pass_word']));
		$newUser									=	$objCommon->esc(trim($_POST['reg_user_name']));
		$newEmail									=	$objCommon->esc(trim($_POST['ud_email']));
		$chekQuery									=	"select reg.reg_user_name, user.ud_email from registration_details as reg left join user_details as user on reg.reg_id = user.reg_id where reg.reg_user_name like '".$newUser."' or user.ud_email like '".$newEmail."'";
		$chekStatus									=	$objReg->getRowSql($chekQuery);
		if($chekStatus['reg_user_name'] == $newUser || $chekStatus['ud_email'] == $newEmail){
			$notfn->add_msg("Sorry ! please check your username or email",4);
			header("location:".$_SERVER['HTTP_REFERER']);
			}else{
		$_POST['reg_user_name']						=	$objCommon->esc(trim($_POST['reg_user_name']));
		$_POST['reg_pass_word']						=	md5($_POST['reg_pass_word']);
		$_POST['reg_type']							=	$regtype =	$objCommon->esc(trim($_POST['reg_type']));
		$_POST['reg_createdon']						=	$currentTime;
		$_POST['reg_editedon']						=	$currentTime;
		$_POST['reg_last_visit']					=	$currentTime;
		$_POST['last_visit_ip']						=	$ipaddress;
		$_POST['reg_status']						=	1;
		
		/*--------------------- private Id ---------------------*/
		$expArray									=	explode(' ',trim($_POST['ud_first_name']));
		$pattern 									= 	'/"((?:.|\n)*?)"\s*[:,}]\s*/';
		$pSting										=	
		$prvIdName									= 	strtoupper($expArray[0]);
		$prvIdDate									= 	date("YmdHis");
		$prvIdGender								= 	substr($_POST['ud_gender'],0,1);
		$privateId									=	$prvIdName.$prvIdDate.$prvIdGender;
		$_POST['reg_private_id']					=	$privateId;
		
		/*--------------------- private Id ---------------------*/
		/*$editId									=	$objCommon->esc(trim($_POST['editId'])); 	
		if($editId){
			$objCountry->update($_POST,"country_id=".$editId);
			$notfn->add_msg("Country Details has successfully been Updated...!",3);
		}else{*/
			$objReg->insert($_POST);
			//$notfn->add_msg("Your successfully registered...!",3);
			$regid		=	$objReg->insertId();
			if($regid){
				$_POST['reg_id']							=	$regid;
				$nameTitle									=	$objCommon->esc(trim($_POST['ud_name_title']));
				$country									=	$objCommon->esc(trim($_POST['ud_country']));
				$curCountry									=	$objCommon->esc(trim($_POST['cur_country']));
				if($nameTitle	==	"Others"){
					$_POST['ud_name_title']					=	$objCommon->esc(trim($_POST['ud_other_name_title']));
					}
				else{
					$_POST['ud_name_title']					=	$objCommon->esc(trim($_POST['ud_name_title']));
				}
				$_POST['ud_first_name']						=	$objCommon->esc(trim($_POST['ud_first_name']));
				$_POST['ud_second_name']					=	$objCommon->esc(trim($_POST['ud_other_name']));
				$_POST['ud_second_name']					=	$objCommon->esc(trim($_POST['ud_second_name']));
				$_POST['ud_gender']							=	$objCommon->esc(trim($_POST['ud_gender']));
				if($country	==	"Other"){
					$_POST['ud_country']					=	$objCommon->esc(trim($_POST['ud_other_country']));
					$_POST['ud_state']						=	$objCommon->esc(trim($_POST['ud_other_state']));
				}
				else{
					$_POST['ud_country']					=	$objCommon->esc(trim($_POST['ud_country']));
					$_POST['ud_state']						=	$objCommon->esc(trim($_POST['ud_state']));
				}
				$_POST['ud_city']							=	$objCommon->esc(trim($_POST['ud_city']));
				$_POST['ud_town']							=	$objCommon->esc(trim($_POST['ud_town']));
				$_POST['ud_place']							=	$objCommon->esc(trim($_POST['ud_place']));
				$_POST['ud_street_name']					=	$objCommon->esc(trim($_POST['ud_street_name']));
				$_POST['ud_house_name']						=	$objCommon->esc(trim($_POST['ud_house_name']));
				$_POST['ud_post_code']						=	$objCommon->esc(trim($_POST['ud_post_code']));
				if($_POST['current-address'] == 1){
					if($curCountry	==	"Other"){
					$_POST['cur_country']					=	$objCommon->esc(trim($_POST['cur_other_country']));
					$_POST['cur_state']						=	$objCommon->esc(trim($_POST['cur_other_state']));
				}
				else{
					$_POST['cur_country']					=	$objCommon->esc(trim($_POST['cur_country']));
					$_POST['cur_state']						=	$objCommon->esc(trim($_POST['cur_state']));
				}
				$_POST['cur_city']							=	$objCommon->esc(trim($_POST['cur_city']));
				$_POST['cur_town']							=	$objCommon->esc(trim($_POST['cur_town']));
				$_POST['cur_place']							=	$objCommon->esc(trim($_POST['cur_place']));
				$_POST['cur_street_name']					=	$objCommon->esc(trim($_POST['cur_street_name']));
				$_POST['cur_house_name']					=	$objCommon->esc(trim($_POST['cur_house_name']));
				$_POST['cur_post_code']						=	$objCommon->esc(trim($_POST['cur_post_code']));
				
				}else{
					
					if($country	==	"Other"){
					$_POST['cur_country']					=	$objCommon->esc(trim($_POST['ud_other_country']));
					$_POST['cur_state']						=	$objCommon->esc(trim($_POST['ud_other_state']));
				}
				else{
					$_POST['cur_country']					=	$objCommon->esc(trim($_POST['ud_country']));
					$_POST['cur_state']						=	$objCommon->esc(trim($_POST['ud_state']));
				}
				$_POST['cur_city']							=	$objCommon->esc(trim($_POST['ud_city']));
				$_POST['cur_town']							=	$objCommon->esc(trim($_POST['ud_town']));
				$_POST['cur_place']							=	$objCommon->esc(trim($_POST['ud_place']));
				$_POST['cur_street_name']					=	$objCommon->esc(trim($_POST['ud_street_name']));
				$_POST['cur_house_name']					=	$objCommon->esc(trim($_POST['ud_house_name']));
				$_POST['cur_post_code']						=	$objCommon->esc(trim($_POST['ud_post_code']));
					
				}
				$_POST['ud_dob']							=	$_POST['ud_dob'];
				$_POST['ud_age']							=	$objCommon->esc(trim($_POST['age_range']));
				$_POST['ud_email']							=	$objCommon->esc(trim($_POST['ud_email']));
				$_POST['ud_facebook']						=	$objCommon->esc(trim($_POST['ud_facebook']));
				$_POST['ud_other_id']						=	$objCommon->esc(trim($_POST['ud_other_social']));
				$_POST['ud_tel_home']						=	$objCommon->esc(trim($_POST['ud_tel_home']));
				$_POST['ud_pofile_pic']						=	$objCommon->esc(trim($_POST['ud_pofile_pic']));
				$_POST['reg_other_info']					=	$objCommon->esc(trim($_POST['reg_other_info']));
				$objUser->insert($_POST);
			}
			if($regtype	==	1){
				$course										=	$objCommon->esc(trim($_POST['up_student_course']));
				$profType									=	$objCommon->esc(trim($_POST['up_profession_type']));
				$_POST['reg_id']							=	$regid;
				if($course	==	""){
						$_POST['up_student_course']			=	$objCommon->esc(trim($_POST['up_student_other_course']));
				}
				else{
						$_POST['up_student_course']			=	$course;
				}
				if($profType	==	""){
					$_POST['up_profession_type']			=	$objCommon->esc(trim($_POST['up_profession_other_type']));
				}
				else{
					$_POST['up_profession_type']			=	$profType;
				}
				$_POST['up_profession_name']				=	$objCommon->esc(trim($_POST['up_profession_name']));
				$_POST['up_profession_speciality']			=	$objCommon->esc(trim($_POST['up_profession_speciality']));
				$_POST['up_profession_sup_speciality']		=	$objCommon->esc(trim($_POST['up_profession_sup_speciality']));
				$_POST['up_profession_grade']				=	$objCommon->esc(trim($_POST['up_profession_grade']));
				$_POST['up_profession_hosp_addr']			=	$objCommon->esc(trim($_POST['up_profession_hosp_addr']));
				$_POST['up_profession_med_addr']			=	$objCommon->esc(trim($_POST['up_profession_med_addr']));
				$_POST['up_profession_company_name']		=	$objCommon->esc(trim($_POST['up_profession_company_name']));
				$_POST['up_profession_acheive']				=	$objCommon->esc(trim($_POST['up_profession_acheive']));
				$objProf->insert($_POST);
			}
			if($regtype	==	2){
				$_POST['reg_id']							=	$regid;
				$_POST['uo_collage_addr']					=	$objCommon->esc(trim($_POST['uo_collage_addr']));
				$_POST['uo_hospital_addr']					=	$objCommon->esc(trim($_POST['uo_hospital_addr']));
				$_POST['uo_company_addr']					=	$objCommon->esc(trim($_POST['uo_company_addr']));
				$_POST['uo_other_addr']						=	$objCommon->esc(trim($_POST['uo_other_addr']));
				$objOrg->insert($_POST);
			}
			if($regtype	==	3){
				$_POST['reg_id']							=	$regid;
				$_POST['upt_details']						=	$objCommon->esc(trim($_POST['upt_details']));
				$_POST['upt_occupation']					=	$objCommon->esc(trim($_POST['upt_occupation']));
				$_POST['utp_disease']						=	$objCommon->esc(trim($_POST['utp_disease']));
				$objpat->insert($_POST);
			}
		//}
					$to  						= 	$_POST['ud_email']; // note the comma
			
					// subject
					$subject 					= 	'Your IMC account has been successfully created';
					// message
					$message					= 	"<table border=\"1\"><tr> <td colspan=\"2\">Your account details are given below</td></tr>";
					$message					.=	"<tr><td>Username</td><td>".$newUser."</td></tr>";
					$message					.=	"<tr><td>Password</td><td>".$orginalPass."</td></tr>";
					$message					.=	"<tr><td>Your private ID</td><td>".$privateId."</td></tr>";
					$message					.=	"</table>";
					// To send HTML mail, the Content-type header must be set
					$headers  					= 	'MIME-Version: 1.0' . "\r\n";
					$headers 					.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					
					// Additional headers
					//$headers 					.= 	'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
					$headers 					.= 	'From: international medical connection <admin@websoftcreators.com>' . "\r\n";
					//$headers 					.= 	'Cc: birthdayarchive@example.com' . "\r\n";
					//$headers 					.= 	'Bcc: birthdaycheck@example.com' . "\r\n";
					// Mail it
					mail($to, $subject, $message, $headers);
					
				
		mysql_query("COMMIT");
		$notfn->add_msg("Your account has been created",3);
		header("location:".$_SERVER['HTTP_REFERER']);
		}
	}
else if(isset($_GET['act']) && $_GET['act']=="add_country_del" && $_GET['did']	!=''){
		$did						  =	$objCommon->esc(trim($_GET['did']));
		$objAdminPage->delete("country_id=".$did);
		$notfn->add_msg("Selected  item has been  removed successfully...!",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	/*-------- forum new topic ---------*/
	else if(isset($_GET['act']) && $_GET['act']=="create_new_thread" && $_POST['page_id'] !=''){
		$_POST['page_id']						=	$objCommon->esc(trim($_POST['page_id']));
		$submenuId								=	$objCommon->esc(trim($_POST['subMenuId']));
		if($submenuId){
			$_POST['sub_menu_id']				=	$submenuId;
		}else{
			$_POST['sub_menu_id']				=	1; // This is a dummy Id for null catagory in manage_sub_menu table 
		}
		$_POST['reg_id']						=	$loginId;
		$_POST['topic']							=	$objCommon->esc(trim($_POST['topic']));
		$_POST['topic_desc']					=	$_POST['topic_desc'];
		$_POST['topic_created_on']				=	$currentTime;
		$_POST['topic_status']					=	1;
		/*$editId								=	$objCommon->esc(trim($_POST['editId'])); */	

		if($loginId){
			$objThread->insert($_POST);
			$notfn->add_msg("New topic details has successfully been added...!",3);
		}else{
			$notfn->add_msg("Sorry ! Please login for add topic...!",4);
		}
		
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	/*-------- forum discussions ---------*/
else if(isset($_GET['act']) && $_GET['act']=="discussions" && $_POST['topic_id'] !=''){
		$_POST['topic_id']						=	$objCommon->esc(trim($_POST['topic_id']));
		$_POST['reg_id']						=	$loginId;
		$_POST['dis_reply_of']					=	$objCommon->esc(trim($_POST['dis_reply_of']));
		$_POST['dis_quote']						=	$objCommon->esc(trim($_POST['dis_quote']));
		$_POST['dis_like']						=	$objCommon->esc(trim($_POST['dis_like']));
		$_POST['dis_dislike']					=	$objCommon->esc(trim($_POST['dis_dislike']));
		$_POST['discussion']					=	$_POST['discussion'];
		$_POST['dis_created_on']				=	$currentTime;
		$_POST['dis_status']					=	1;
		/*$editId									=	$objCommon->esc(trim($_POST['editId']));  */	
		if($loginId){
			$objDiscus->insert($_POST);
			$notfn->add_msg("Your message has successfully been added...!",3);
		}else{
			$notfn->add_msg("Sorry ! Please login for continue...!",4);	
		}
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	/*--------------Registration form edit start -----------------*/
	else if(isset($_GET['upact']) && $_GET['upact']== "pd" && $_POST['first_name']){
		$_POST['ud_name_title']					=	$objCommon->esc(trim($_POST['name_title']));
		$_POST['ud_first_name']					=	$objCommon->esc(trim($_POST['first_name']));
		$_POST['ud_dob']						=	$objCommon->esc(trim($_POST['dob']));
		$_POST['ud_age']						=	$objCommon->esc(trim($_POST['age_range']));
		$_POST['ud_email']						=	$objCommon->esc(trim($_POST['email']));
		$objUser->update($_POST,"reg_id='".$activeMem."'");
		$notfn->add_msg("Your Personal Details Updated...!",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}else if(isset($_GET['upact']) && $_GET['upact']== "ad"){
		$_POST['ud_country']					=	$objCommon->esc(trim($_POST['country']));
		$_POST['ud_state']						=	$objCommon->esc(trim($_POST['state']));
		$_POST['ud_city']						=	$objCommon->esc(trim($_POST['city']));
		$_POST['ud_town']						=	$objCommon->esc(trim($_POST['town']));
		$_POST['ud_street_name']				=	$objCommon->esc(trim($_POST['street_name']));
		$_POST['ud_house_name']					=	$objCommon->esc(trim($_POST['house_name']));
		$_POST['ud_post_code']					=	$objCommon->esc(trim($_POST['post_code']));
		$_POST['cur_country']					=	$objCommon->esc(trim($_POST['cur_country']));
		$_POST['cur_state']						=	$objCommon->esc(trim($_POST['cur_state']));
		$_POST['cur_city']						=	$objCommon->esc(trim($_POST['cur_city']));
		$_POST['cur_town']						=	$objCommon->esc(trim($_POST['cur_town']));
		$_POST['cur_street_name']				=	$objCommon->esc(trim($_POST['cur_street_name']));
		$_POST['cur_house_name']				=	$objCommon->esc(trim($_POST['cur_house_name']));
		$_POST['cur_post_code']					=	$objCommon->esc(trim($_POST['cur_post_code']));
		$objUser->update($_POST,"reg_id='".$activeMem."'");
		$notfn->add_msg("Address Details Updated...!",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	else if(isset($_GET['upact']) && $_GET['upact']== "cpd"){
		$_POST['ud_tel_home']					=	$objCommon->esc(trim($_POST['tel_home']));
		$_POST['ud_tel_work']					=	$objCommon->esc(trim($_POST['tel_work']));
		$_POST['ud_tel_mob']					=	$objCommon->esc(trim($_POST['tel_mob']));
		$objUser->update($_POST,"reg_id='".$activeMem."'");
		$notfn->add_msg("Contact / Phone Details Updated...!",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}else if(isset($_GET['upact']) && $_GET['upact']== "cpd"){
		$_POST['ud_tel_home']					=	$objCommon->esc(trim($_POST['tel_home']));
		$_POST['ud_tel_work']					=	$objCommon->esc(trim($_POST['tel_work']));
		$_POST['ud_tel_mob']					=	$objCommon->esc(trim($_POST['tel_mob']));
		$objUser->update($_POST,"reg_id='".$activeMem."'");
		$notfn->add_msg("Contact / Phone Details Updated...!",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}else if(isset($_GET['upact']) && $_GET['upact']== "course"){
		$currentPro								=	$objProf->getAll('reg_id ="'.$activeMem.'"');
		if($_POST['up_student_course']){
			$_POST['up_student_course']			=	$objCommon->esc(trim($_POST['up_student_course']));
			if(count($currentPro)){
			$objProf->update($_POST,"reg_id='".$activeMem."'");
			
			}else{
				$_POST['reg_id']				=	$activeMem;
				$objProf->insert($_POST);
			}
			$notfn->add_msg("course Details Updated...!",3);
		}else if($_POST['up_profession_type']){
			$_POST['up_profession_type']		=	$objCommon->esc(trim($_POST['up_profession_type']));
			if(count($currentPro) >0){
			$objProf->update($_POST,"reg_id='".$activeMem."'");
			}else{
				$_POST['reg_id']				=	$activeMem;
				$objProf->insert($_POST);
			}
			$notfn->add_msg("Profession Updated...!",3);
		}
		
		header("location:".$_SERVER['HTTP_REFERER']);
	}else if(isset($_GET['upact']) && $_GET['upact']== "profDtil"){
		$currentPro								=	$objProf->getAll('reg_id ="'.$activeMem.'"');
		$_POST['up_profession_name']			=	$objCommon->esc(trim($_POST['profession_name']));
		$_POST['up_profession_speciality']		=	$objCommon->esc(trim($_POST['profession_speciality']));
		$_POST['up_profession_sup_speciality']	=	$objCommon->esc(trim($_POST['profession_sup_speciality']));
		$_POST['up_profession_grade']			=	$objCommon->esc(trim($_POST['profession_grade']));
		$_POST['up_profession_hosp_addr']		=	$objCommon->esc(trim($_POST['profession_hosp_addr']));
		$_POST['up_profession_med_addr']		=	$objCommon->esc(trim($_POST['profession_med_addr']));
		$_POST['up_profession_company_name']	=	$objCommon->esc(trim($_POST['profession_company_name']));
		if(count($currentPro)>0){
		$objProf->update($_POST,"reg_id='".$activeMem."'");
		}else{
			$_POST['reg_id']					=	$activeMem;
			$objProf->insert($_POST);
		}
		$notfn->add_msg("Professional Details Updated...!",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}else if(isset($_GET['upact']) && $_GET['upact']== "orgdtil"){
		$currOrg				 				=	$objOrg->getAll('reg_id ="'.$activeMem.'"');
		$_POST['uo_collage_addr']				=	$objCommon->esc(trim($_POST['collage_addr']));
		$_POST['uo_hospital_addr']				=	$objCommon->esc(trim($_POST['hospital_addr']));
		$_POST['uo_company_addr']				=	$objCommon->esc(trim($_POST['company_addr']));
		$_POST['uo_other_addr']					=	$objCommon->esc(trim($_POST['other_addr']));
		if(count($currOrg) >0){
			$objOrg->update($_POST,"reg_id='".$activeMem."'");
		}else{
			$_POST['reg_id']					=	$activeMem;
			$objOrg->insert($_POST);
			$notfn->add_msg("Organization Details Updated...!",3);
		}
		header("location:".$_SERVER['HTTP_REFERER']);
	}else if(isset($_GET['upact']) && $_GET['upact']== "acheivement"){
		
		$_POST['up_profession_acheive']			=	$_POST['acheivement_info'];
		$objProf->update($_POST,"reg_id='".$activeMem."'");
		$notfn->add_msg("Your Acheivements Updated...!",3);
		header("location:".$_SERVER['HTTP_REFERER']);
		
	}else if(isset($_GET['upact']) && $_GET['upact']== "status"){
		$_POST['reg_other_info']				=	$_POST['status'];
		$objUser->update($_POST,"reg_id='".$activeMem."'");
		$notfn->add_msg("Your Status Updated...!",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	/*--------------Registration form edit end -----------------*/
	/*--------------Manage group details start -----------------*/
	else if(isset($_GET['act']) && $_GET['act']== "gpadd" && $_POST['ggName']){
		$groupName					=	$objCommon->esc(trim($_POST['ggName']));
		$members					=	$_POST['gn'];
		$groupStatus				=	$objGroup->getRow('group_name = "'.$groupName.'" and reg_id = "'.$loginId.'"');
		if($groupStatus['group_name']){
			$notfn->add_msg("Sorry this group name is alrady exist in your group details",2);
			header("location:".$_SERVER['HTTP_REFERER']);
		}else{
			$_POST['reg_id'] 		=	$objCommon->esc(trim($loginId));
			$_POST['group_name'] 	=	$objCommon->esc($groupName);
			$_POST['group_status']	=	1;
			$objGroup->insert($_POST);
			$groupId				=	$objGroup->insertId();
			if(count($members)>0){
			foreach($members as $mem){
				if($groupId){
					$memStatus		=	$objMember->getRow('group_id = "'.$groupId.'" and reg_id = "'.$mem.'"');
					if($memStatus['reg_id'] != $mem){
						$_POST['group_id']			= $objCommon->esc(trim($groupId));
						$_POST['reg_id']			= $objCommon->esc(trim($mem));
						$_POST['group_m_status']	= 1;
					 		$objMember->insert($_POST);
					}
				}
			}
			}
			$notfn->add_msg("Your Group Added Successfully",3);
			header("location:".$_SERVER['HTTP_REFERER']);
		}	
	}else if(isset($_GET['act']) && $_GET['act'] == "changepass" && $_POST['curpass']){
			$curentPass				=	$objReg->getRow('reg_id = "'.$loginId.'"');
			$enterPass				=	$objCommon->esc(trim(md5($_POST['curpass'])));
		if($curentPass['reg_pass_word'] == $enterPass){
			$newpassWord			=	$objCommon->esc(trim($_POST['npass']));
			$rePassword				=	$objCommon->esc(trim($_POST['repass']));
			if($newpassWord == $rePassword){
				$newpass			=	md5($newpassWord);
				$objReg->updateField(array("reg_pass_word" => $newpass ), "reg_id= '".$loginId."'");
				header("location:logout.php");
			}else{
				$notfn->add_msg("Sorry ! Action not compleated  ",2);
				header("location:".$_SERVER['HTTP_REFERER']);
			}
		}else{
			
			$notfn->add_msg("Sorry ! Action not compleated  ",2);
			header("location:".$_SERVER['HTTP_REFERER']);
		}
	
	}else if(isset($_POST['act']) && ($_POST['act'] == "addlike" || $_POST['act'] == "addDislike") && $_POST['like_topic'] ){
			$ip								=	$objCommon->get_ip();
			$topicId						=	$objCommon->esc(trim($_POST['like_topic']));
			$likeStatus						=	$objTLike->getRow('topic_id = "'.$topicId.'" and topic_like_ip = "'.$ip.'"');
			if(! $likeStatus['topic_like_id']){
				if($_POST['act'] == "addlike"){
				$_POST['topic_id']			=	$topicId;
				$_POST['topic_like_ip']		=	$ip;
				$_POST['topic_like']		=	1;
				$_POST['topic_dislike']		=	0;
				$_POST['topic_like_status']	=	1;
				$objTLike->insert($_POST);
				}else if($_POST['act'] == "addDislike"){
				$_POST['topic_id']			=	$topicId;
				$_POST['topic_like_ip']		=	$ip;
				$_POST['topic_like']		=	0;
				$_POST['topic_dislike']		=	1;
				$_POST['topic_like_status']	=	1;
				$objTLike->insert($_POST);
				}
			}	
	}else if(isset($_POST['act']) && ($_POST['act'] == "discussLike" || $_POST['act'] == "discussDisLike") && $_POST['dislike_topic'] ){
			$ip								=	$objCommon->get_ip();
			$discussId						=	$objCommon->esc(trim($_POST['dislike_topic']));
			$likeStatus						=	$objDLike->getRow('dis_id = "'.$discussId.'" and dis_like_ip = "'.$ip.'"');
			if(! $likeStatus['dis_like_id']){
				if($_POST['act'] == "discussLike"){
				$_POST['dis_id']			=	$discussId;
				$_POST['dis_like_ip']		=	$ip;
				$_POST['dis_like']			=	1;
				$_POST['dis_dislike']		=	0;
				$_POST['dis_like_status']	=	1;
				$objDLike->insert($_POST);
				}else if($_POST['act'] == "discussDisLike"){
				$_POST['dis_id']			=	$discussId;
				$_POST['dis_like_ip']		=	$ip;
				$_POST['dis_like']			=	0;
				$_POST['dis_dislike']		=	1;
				$_POST['dis_like_status']	=	1;
				$objDLike->insert($_POST);
				}
			}	
	}else if(isset($_GET['act']) && $_GET['act'] == "contactus" && $_POST['con_type']){
		
		if($loginId){
			$idRow							=	$objUser->getRow('reg_id = "'.$loginId.'"');
			$_POST['contact_name']			=	$idRow['ud_first_name'];
			$_POST['reg_id']				=	$loginId;
			$_POST['contact_email']			=	$idRow['ud_email'];
		}else{
		$_POST['contact_name']				=	$objCommon->esc(trim($_POST['con_name']));	
		$_POST['reg_id']					=	0;
		$_POST['contact_email']				=	$objCommon->esc(trim($_POST['con_email']));
		}
		$_POST['contact_ip']				=	$objCommon->get_ip();
		$_POST['contact_type_id']			=	$objCommon->esc(trim($_POST['con_type']));
		$_POST['contact_subject']			=	$objCommon->esc(trim($_POST['con_subject']));
		$_POST['contact_message']			=	$objCommon->esc(trim($_POST['con_msg']));
		$_POST['read_status']				=	0;
		$_POST['contact_status']			=	1;
		$objConFrom->insert($_POST);
			
		$notfn->add_msg("Thank you for sharing your feedback with us",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}else if(isset($_GET['act']) && $_GET['act'] == "ask_an_expert" && $_POST['ask_topic'] && $loginId){
		$_POST['reg_id']					=	$loginId;
		$_POST['ask_q_heading']				=	$objCommon->esc(trim($_POST['ask_topic']));
		$_POST['ask_q_message']				=	$_POST['ask_topic_desc'];
		$_POST['ask_q_created']				=	$currentTime;
		$_POST['ask_q_edited']				=	$currentTime;
		$_POST['ask_q_ip']					=	$objCommon->get_ip();
		$_POST['ask_q_status']				=	1;
		$objAsk->insert($_POST);
		$notfn->add_msg("Thank you for sharing your question with us",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}else if(isset($_POST['act']) && ($_POST['act'] == "asklike" || $_POST['act'] == "askDislike") && $_POST['ask_topic'] ){
			$ip								=	$objCommon->get_ip();
			$askId							=	$objCommon->esc(trim($_POST['ask_topic']));
			$likeStatus						=	$objAskLike->getRow('ask_q_id = "'.$askId.'" and q_like_ip = "'.$ip.'"');
			if(!$likeStatus['q_like_id']){
				if($_POST['act'] == "asklike"){
				$_POST['ask_q_id']			=	$askId;
				$_POST['q_like_ip']			=	$ip;
				$_POST['q_like']			=	1;
				$_POST['q_dislike']			=	0;
				$_POST['q_like_status']		=	1;
				$objAskLike->insert($_POST);
				}else if($_POST['act'] == "askDislike"){
				$_POST['ask_q_id']			=	$askId;
				$_POST['q_like_ip']			=	$ip;
				$_POST['q_like']			=	0;
				$_POST['q_dislike']			=	1;
				$_POST['q_like_status']		=	1;
				$objAskLike->insert($_POST);
				}
			}	
	}
	else{
		$notfn->add_msg("Sorry ! Action not compleated  ",4);
			header("location:".$_SERVER['HTTP_REFERER']);
	}
	/*--------------Manage group details end -----------------*/