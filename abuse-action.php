<?php
	session_start();
	include_once("includes/site_root.php");
	include_once(DIR_ROOT."includes/session_check.php");
	include_once(DIR_ROOT."includes/action_functions.php");
	include_once(DIR_ROOT.'class/abuse_slider.php');
	include_once(DIR_ROOT.'class/abuse_forum.php');
	$notfn						=	new notification_types();
	$objCommon					=	new common_functions();
	$objAbuseSlider				=	new abuse_slider();
	$objAbuseForum				=	new abuse_forum();
	$contentId					=	$objCommon->esc($_GET['ab']);
	$abuseDtil					=	$objCommon->esc($_POST['abusedtil']);
	$ip							=	$objCommon->get_ip();
	$currentTime				=	date("Y-m-d H:i:s");
	if($sessionval){
	if($contentId && $_GET['act'] && $abuseDtil){
		$_POST['reg_id']		=	$activeMem;
		$_POST['abuse']			=	$abuseDtil;
		$_POST['abuse_ip']		=	$ip;
		$_POST['abuse_read_status']	=	0;
		$_POST['abuse_date']	=	$currentTime;
		$_POST['abuse_status']	=	1;
		if($_GET['act'] == "slider"){
			$_POST['mp_id']		=	$contentId;
		$objAbuseSlider->insert($_POST);
		}else if($_GET['act'] == "forum"){
		$_POST['topic_id']		=	$contentId;
		$_POST['dis_id']		=	$_POST['discuss'];
		$objAbuseForum->insert($_POST);
		}
		$notfn->add_msg("Thank you for your request",3);
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	}else{
		$notfn->add_msg("Please login for report abuse",4);
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	?>