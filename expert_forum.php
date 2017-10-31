<?php 
	include_once('includes/header.php');
	include_once(DIR_ROOT."includes/session_check.php");
	include_once(DIR_ROOT."includes/pagination.php");
	include_once(DIR_ROOT."class/ask_question.php");
	include_once(DIR_ROOT."class/forum_discussion.php");
	include_once(DIR_ROOT."class/manage_sub_sub_menu.php");
	include_once(DIR_ROOT."includes/action_functions.php");
	include_once(DIR_ROOT.'class/forum_discussion_like.php');
	include_once(DIR_ROOT.'class/ask_q_like.php');
	$objSubSub	=	new manage_sub_sub_menu();
	$objTopic	=	new ask_question();
	$objDis		=	new forum_discussion();
	$notfn		=	new notification_types();
	$objCommon	=	new common_functions();
	$objDLike	=	new	forum_discussion_like();
	$objTLike	=	new ask_q_like();
	$ip			=	$objCommon->get_ip();
	if($_GET['id']){
	$topic		=	$_GET['id'];
	}
	$selfPage	=	SITE_ROOT."forum_post.php?id=".$topic;
	$sql		=	"select forum.*, user.*, sum(ulike.q_like) as totlike, sum(ulike.q_dislike) as disliks from ask_question as forum left join user_details as user on forum.reg_id=user.reg_id left join ask_q_like as ulike on forum.ask_q_id = ulike.ask_q_id where forum.ask_q_id =	'".$topic."' and forum.ask_q_staff_manage = 0 order by forum.ask_q_created desc";					
	$getToic	=	$objTopic->getRowSql($sql);
	$getLStatus	=	$objTLike->getRow('ask_q_id = "'.$topic.'" and q_like_ip = "'.$ip.'"');
	$timeNow	=	date("Y-m-d H:i:s");
	$postDate	=	$getToic['ask_q_created'];
	$diff 		= 	abs(strtotime($postDate) - strtotime($timeNow));
	$years 		= 	floor($diff / (365*60*60*24));
	$months 	= 	floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days 		= 	floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	if($topic){
		$noview		=	$getToic['ask_q_views'];
		$newView	=	$noview+1;
		$objTopic->updateField(array("ask_q_views"=>$newView),"ask_q_id=".$topic);
	}
		//$home 		= 	$objMgPage->getFields("mp_heading,mp_desc","page_id='".$currentPage."' and cat_id=6 and mp_status=1","mp_createdon desc");
		$homeQuery		=	"select pages.* from manage_pages as pages left join manage_page_connection as con on pages.mp_id = con.mp_id where page_id = '".$currentPage."' and pages.mp_staff_manage = 0 and pages.mp_status=1 and con.cat_id = 6 and con.mcp_status = 1 order by pages.mp_createdon desc";
	$home 			= 	$objMgPage->listQuery($homeQuery);
	//$topSlide	=	$objMgPage->getAll("page_id=1 and pos_id=4 and cat_id=3 and mp_status=1","mp_createdon desc");
		//$allTopics	=	$objMgPage->getAll("page_id = '".$currentPage."' and mp_status=1","mp_createdon desc");	
		$pageQuery		=	"select con.page_id, con.cat_id, con.mcp_status, pages.* from manage_pages as pages left join manage_page_connection as con on pages.mp_id = con.mp_id where con.page_id = '".$currentPage."' and pages.mp_staff_manage = 0 and pages.mp_status=1 and con.mcp_status = 1 order by pages.mp_createdon desc";
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
        <!-- <p align="center"><img id="down_arrow_img1" src="img/up_arraow1.png" style=" z-index:1000; position:absolute; cursor:pointer; "><p>--> 
        <!--Left vertical slider start-->
        <?php include_once(DIR_ROOT."includes/left_slider.php"); ?>
        <!--Left vertical slider end--> 
      </div>
      <div class="imc-blockcontent">
        <div align="center">
          <div class="sug-consult"> <a style="text-decoration:none;" href="#myModel">
            <div class="write_topic_container ovr">
              <label class="write_topic_head">write a new topic</label>
            </div>
            </a> </div>
        </div>
      </div>
      <div class="imc-blockcontent">
        <div align="center">
          <div class="sug-consult"> <a style="text-decoration:none;" href="#login_form">
            <div class="write_topic_container ovr">
              <label class="write_topic_head">Give your Suggestions</label>
            </div>
            </a> </div>
        </div>
      </div>
      <div class="imc-blockcontent">
        <div align="center">
          <div class="doc-consult"> <a style="text-decoration:none;" href="<?php echo SITE_ROOT; ?>ask_an_expert.php?dept=<?php echo $currentPage; ?>">
            <div class="write_topic_container ovr">
              <label class="write_topic_head">Ask an Expert</label>
            </div>
            </a>
            <p> <a href="#"> <img class="doc_img" src="images/doctor11.png"> </a></p>
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
      <!-- left ads start -->
       <?php include_once(DIR_ROOT.'includes/left_ads.php'); ?>
      <!-- left ads end -->
    </div>
    <div class="col-lg-8" >
      <div class="row">
        <div class="col-lg-2">
          <!-- Menu left to the slider start -->
          	<?php include_once(DIR_ROOT.'includes/top_menu.php'); ?>
          <!-- Menu left to the slider end -->
        </div>
        <!-- MAIN SLIDER START -->
         <?php include_once(DIR_ROOT.'includes/home_slider.php'); ?>
        <!-- MAIN SLIDER END -->
        <div class="col-lg-5 ">
          <div class="coursebg_con">
            <div class="row">
              <div class="col-lg-6 ">
                <div style="border:5px solid #FFF; padding:5px;">
                  <div style="border:5px solid #000; padding:5px; color:#FFF; background-color:#400080; font-size:28px; font-weight:bold; text-align:center;">PLAB</div>
                </div>
              </div>
              <div class="col-lg-6 ">
                <div style="border:5px solid #FFF; padding:5px;">
                  <div style="border:5px solid #000; padding:5px; color:#FFF; background-color:#6C006C; font-size:28px; font-weight:bold; text-align:center;">USMLE</div>
                </div>
              </div>
              <div class="col-lg-12">
                <div style="border:5px solid #FFF; padding:5px; margin-top:2%;">
                  <div style="border:5px solid #000; padding:5px; color:#FFF; background-color:#5C00B9; font-size:28px; font-weight:bold; text-align:center;">Global Medical Course<br/>
                    for the Plab Exam<br/>
                    by Dr. <span style="color:#FF0; font-size:32px; text-shadow: 2px 2px 2px #FF5B5B;">Swamy</span></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php 
	  include_once('includes/middle_menu.php');
	  ?>
      <div class="row background2" style="margin-top:10px;" id="scroll_to_this">
        <div class="col-lg-12">
          <div class="imc-pagemenu" >
            <center>
              PLAB FORUM
            </center>
          </div>
          <div class="forum_ask_contant">
            <h3 style="color:#606; padding:10px 30px;">IMPORTANT NOTICE: DO NOT IGNORE</h3>
            <p style="color:#930; padding:10px 30px;">Please do not share actual questions from the exams wherein you are bound by a Non Disclosure Agreement (NDA). This is applicable even after the completion of exam. This common sense rule is for your own legal protection and to ensure fairness for all exam takers.<br/>
              We have a zero tolerance policy for any violation of this rule and anyone reported to be posting such material is permanently blocked from accessing IMC website. We encourage other users to report such posts to us by using report links found below every post. Our support team is working round the clock for the duration of the exam to ensure prompt action on your reports. </p>
          </div>
        </div>
        <div class="col-lg-12 hidden-xs" style="padding:10px 0px;">
          <div class="col-lg-3">
            <div class="ask_message">Author </div>
          </div>
          <div class="col-lg-9">
            <div class="ask_message">Message </div>
          </div>
        </div>
        
        <!--FORUM TOPIC START-->
        <div class="col-lg-12" style="padding:10px 0px;" id="discussrow<?php echo $topic."101";?>">
          <div style="background-color:#e3eef4;" class="col-lg-3  forum_user_question ovr" id="discussuser<?php echo $topic."101";?>">
            <div class="user_img_dtil_room">
              <p style="font-weight:bold; font-size:18px;"><?php echo stripslashes($getToic['ud_name_title']).": "; echo stripslashes($getToic['ud_first_name']); ?></p>
            </div>
            <center>
            <?php if($getToic['ud_pofile_pic']){
							 
							$profPic	=  "profiles/".stripslashes($getToic['ud_pofile_pic']);
							if(file_exists($profPic)){
						?>
               <img style="max-width:200px;" class="img-responsive img-thumbnail" src="<?php echo SITE_ROOT.$profPic; ?>">
               <?php } else{ ?>
               <img style="max-width:200px;" class="img-responsive img-thumbnail" src="<?php echo SITE_ROOT; ?>images/profile.jpg">
               <?php }  }else{ ?>
                <img style="max-width:200px;" class="img-responsive img-thumbnail" src="<?php echo SITE_ROOT; ?>images/profile.jpg">
              <?php } ?>
            </center>
            <div class="user_img_dtil_room">
              <p><span class="icon_set_pad">Posts: </span> <span class="icon_set_pad"> Credits: <?php echo $getToic['totlike']; ?></span></p>
            </div>
          </div>
          <div class="col-lg-9"><?php $dis_id = 0; ?>
            <div style="background-color:#e3eef4;" class="col-lg-12 forum_user_question ovr">
              <div class="ask_question_head ovr">
                <div class=" col-lg-6 "> <a href="#" class="forum_name">Annotated IMC</a> </div>
                <div class="col-lg-6 forum_time">
                  <p class="forum_date"><?php echo date("Y-M-d",strtotime($postDate)); ?>
                                    <?php if($years > 0){ echo "( ".$years." year ago )"; } elseif($months >0 && $days >0){echo "( ".$months." months and ".$days."  day ago )"; }elseif($days>0){ echo "( ".$days." day ago )"; }  ?></p>
                </div>
              </div>
              <div id="ask_question_body<?php echo $topic."101";?>" style="color:#333" class="ask_question_body">
                <?php echo stripslashes($getToic['ask_q_message']); ?> 
              </div>
              <div class="col-lg-12 ask_question_replay">
                <div class=" col-lg-6 "> <a href="javascript:;" onclick="return reportAbuse(<?php echo $topic; ?>,0);" class="forum_report">Report this post to a moderator</a> </div>
                <div class=" col-lg-6 ">
                  <div  style="float:right; padding-right:10px;"> 
                  <?php
					$cLen	=	960;
						if(strlen($getToic['ask_q_message'])> $cLen){
					 ?>
                      <span class="icon_set_pad" id="showfulltext<?php echo $topic."101";?>">
                      <a href="javascript:;" onClick="return fullShow(<?php echo $topic."101" ?>);" title="View More"><img src="img/viewmore.png" /></a>
                      </span>
                      <?php } ?>
					<span class="icon_set_pad" id="showlesstext<?php echo $topic."101";?>" style="display:none;">
                      <a href="javascript:;" id="showlesstext<?php echo $topic."101";?>" onClick="return lessShow(<?php echo $topic."101";?>);" title="View Less"><img src="img/viewless.png" /></a>
                      </span>
                      
                  <span class="icon_set_pad">
                  <a href="javascript:;" onClick="return quoteForum(<?php echo $topic; ?>,<?php echo $dis_id; ?>  );" title="Reply with quote"  style="color:#6C00D9;"><i class="fa fa-quote-right"></i></a>
                  </span> 
                  <?php if($getLStatus['topic_like_ip'] == $ip){  ?>
                  <span class="icon_set_pad">
                  <a href="javascript:;" style="color:#666;"><i class="fa fa-thumbs-o-up"></i></a> <span class="icon_set_nub"><?php echo ($getToic['totlike']) ? "&nbsp;&nbsp;$getToic[totlike]" : "" ?></span>
                  </span> 
                  <span class="icon_set_pad">
                  <a href="javascript:;" style="color:#666;"><i class="fa fa-thumbs-o-down"></i></a> <span class="icon_set_nub"><?php echo ($getToic['disliks']) ? "&nbsp;&nbsp;$getToic[disliks]" : "" ?></span>
                  </span> 
                  <?php } else{ ?>
                  <span class="icon_set_pad">
                  <a href="javascript:;" onclick="return topicLike(<?php echo $topic; ?>);" title="Rate this post" style="color:#00BF60;"><i class="fa fa-thumbs-o-up"></i></a> <span class="icon_set_nub"><?php echo ($getToic['totlike']) ? "&nbsp;&nbsp;($getToic[totlike])" : "" ?></span>
                  </span> 
                  <span class="icon_set_pad">
                  <a href="javascript:;" onclick="return topicDislike(<?php echo $topic; ?>);" title="Rate this post" style="color:#AE0000;"><i class="fa fa-thumbs-o-down"></i></a> <span class="icon_set_nub"><?php echo ($getToic['disliks']) ? "&nbsp;&nbsp;($getToic[disliks])" : "" ?></span>
                  </span>
                  <?php } ?>
                  <span class="icon_set_pad">
                  <a href="javascript:;" onClick="return forum(<?php echo $topic; ?>,<?php echo $dis_id; ?>);" style="color:#1C1CFF;"><i class="fa fa-reply"></i></a>
                  </span> 
                   <?php if($activeMem){ ?>
                  <span class="icon_set_pad">
                  <a href="<?php echo SITE_ROOT; ?>my_profile.php" style="color:#9F0000;"><i class="fa fa-envelope-o"></i></a>
                  
                  </span> 
                  <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
         <!--FORUM TOPIC END-->
         <!--FORUM DISCUSSION START-->
           <?php
							
							/*-----------discussion start----------------*/
					$num_results_per_page 	 		= 	7;	//($_GET['new_view'])?$_GET['new_view']:7;
				//	$num_page_links_per_page 		= 	5;
				//	$pg_param 						= 	"";
					
						 $sql_pagination 			= 	"select * from forum_discussion as dis left join user_details as user on dis.reg_id=user.reg_id where dis.topic_id='".$topic."' and dis.dis_staff_manage = 0 order by dis.dis_created_on asc";
					
					pagination($sql_pagination,$num_results_per_page);
					$page_list						=	$objDis->listQuery($pageQuery);
					//$countpageList				=	mysql_num_rows(mysql_query($sql_pagination));
					if(count($page_list) >0){
						$count=	1;
						foreach($page_list as $all){
/*-----------discussion End----------------*/
								$getLikes		=	$objDLike->getFields('dis_like_ip, sum(dis_like) as discuslike, sum(dis_dislike) as discusdislike', 'dis_id = "'.$all['dis_id'].'" and dis_like_ip = "'.$ip.'" ', 'dis_like_id');
								 foreach($getLikes as $dLikes){
								  $idcussLike	=	 $dLikes['discuslike'];
								  $noLike		=	 $dLikes['discusdislike'];
								  $userIp		=	 $dLikes['dis_like_ip'];
								 }
                             	$postDate		=	$all['dis_created_on'];
								$diff 			= 	abs(strtotime($postDate) - strtotime($timeNow));
								$years 			= 	floor($diff / (365*60*60*24));
								$months 		= 	floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
								$days 			= 	floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
								$hourdiff 		= 	round((strtotime($timeNow) - strtotime($postDate))/3600, 1);
								?>
        <div class="col-lg-12" style="padding:10px 0px;" id="discussrow<?php echo $all['dis_id'];?>">
          <div class="col-lg-3  forum_user_question1 ovr" id="discussuser<?php echo $all['dis_id'];?>">
            <div class="user_img_dtil_room">
              <p style="font-weight:bold; font-size:18px;"><?php echo stripslashes($all['ud_name_title']).": "; echo stripslashes($all['ud_first_name']); ?></p>
            </div>
            <center>
             <?php if ($all['ud_pofile_pic']) { 
							 
							$profPic	=  "profiles/".stripslashes($all['ud_pofile_pic']);
							if(file_exists($profPic)){
						?>
              <img style="max-width:200px;" class="img-responsive img-thumbnail" src="<?php echo SITE_ROOT.$profPic; ?>">
               <?php } else{ ?>
              <img style="max-width:200px;" class="img-responsive img-thumbnail" src="<?php echo SITE_ROOT; ?>images/profile.jpg">
                <?php }  }else{ ?>
               <img style="max-width:200px;" class="img-responsive img-thumbnail" src="<?php echo SITE_ROOT; ?>images/profile.jpg">
              <?php } ?>
            </center>
            <div class="user_img_dtil_room">
              <p><span class="icon_set_pad">Posts: </span> <span class="icon_set_pad"> Credits: <?php echo $all['dis_like']; ?></span></p>
            </div>
          </div>
          <div class="col-lg-9" id="discusstopic<?php echo $all['dis_id'];?>">
            <div class="col-lg-12 forum_user_question1 ovr">
              <div class="ask_question_head ovr">
                <div class=" col-lg-6 ">  <?php if($all['dis_quote']){ ?><a href="#" class="forum_name"><span class="quote_for"><img src="img/icon_quotes.png" height="23" width="23" title="Quoted for"/> </span>&nbsp;&nbsp;<span class="name-plate"><?php echo ($all['dis_quote']!=":")? $all['dis_quote'] : stripslashes($getToic['ud_name_title']).": ".stripslashes($getToic['ud_first_name']); ?></span></a><?php } ?> </div>
                <div class="col-lg-6 forum_time">
                  <p class="forum_date"><?php echo date("Y-M-d",strtotime($postDate)); ?>
                                    <?php if($years > 0){ echo "( ".$years." year ago )"; } elseif($months >0 && $days >0){echo "( ".$months." months and ".$days."  day ago )"; } elseif ($days>0) { echo "( ".$days." day ago )"; }elseif($hourdiff>0){echo "( ".round($hourdiff)." hours ago )";}  ?></p>
                </div>
              </div>
              <div id="ask_question_body<?php echo $all['dis_id']; ?>" style="color:#333" class="ask_question_body">
                <?php echo stripslashes($all['discussion']); ?> 
              </div>
              <div class="col-lg-12 ask_question_replay">
                <div class=" col-lg-6 "> <a onclick="return reportAbuse(<?php echo $topic; ?>,<?php echo $all['dis_id']; ?>);" href="javascript:;" class="forum_report">Report this post to a moderator</a> </div>
                <div class=" col-lg-6 ">
                  <div  style="float:right; padding-right:10px;"> 
                  
                   <?php
			
						if(strlen($all['discussion']) > $cLen || strlen($qRepaly[0]['discussion']) > 95) {
					 ?>
                      <span class="icon_set_pad" id="showfulltext<?php echo $all['dis_id'];?>">
                      <a href="javascript:;" onClick="return fullShow(<?php echo $all['dis_id'];?>);" title="View More"><img src="img/viewmore.png" /></a>
                      </span>
                      <?php } ?>
					<span class="icon_set_pad" id="showlesstext<?php echo $all['dis_id'];?>" style="display:none;">
                      <a href="javascript:;" onClick="return lessShow(<?php echo $all['dis_id']?>);" title="View More"><img src="img/viewless.png" /></a>
                      </span>
                  
                  <span class="icon_set_pad"><a href="javascript:;" onClick="return quoteForum(<?php echo $all['topic_id']; ?>,<?php echo $all['dis_id'];  ?>);"  style="color:#6C00D9;" title="Reply with quote"><i class="fa fa-quote-right"></i></a></span>
                   <?php if($userIp == $ip){  ?>
                   <span class="icon_set_pad"><a  style="color:#666;" title="Rate this post"><i class="fa fa-thumbs-o-up"></i></a> <span class="icon_set_nub"><?php echo ($idcussLike) ? "&nbsp;&nbsp;$idcussLike" : "" ?></span></span>
                    <span class="icon_set_pad"><a style="color:#666;" title="Rate this post"><i class="fa fa-thumbs-o-down"></i></a> <span class="icon_set_nub"><?php echo ($noLike) ? "&nbsp;&nbsp;$noLike" : "" ?></span></span>
                    <?php }else{ ?>
                    <span class="icon_set_pad"><a href="javascript:;" onclick="return discussLike(<?php echo $all['dis_id'];?>);" style="color:#00BF60;" title="Rate this post"><i class="fa fa-thumbs-o-up"></i></a> <span class="icon_set_nub"><?php echo ($idcussLike) ? "&nbsp;&nbsp;'".$idcussLike."'" : "" ?></span></span>
                    <span class="icon_set_pad"><a href="javascript:;" onclick="return discussDisLike(<?php echo $all['dis_id'];?>);" style="color:#AE0000;" title="Rate this post"> <i class="fa fa-thumbs-o-down"></i></a> <span class="icon_set_nub"><?php echo ($noLike) ? "&nbsp;&nbsp;'".$noLike."'" : "" ?></span></span>
                      <?php } ?>
                    
                     <span class="icon_set_pad"><a href="javascript:;" onClick="return forum(<?php echo $all['topic_id']; ?>,<?php echo $all['dis_id'];  ?>);"  title="Reply"  style="color:#1C1CFF;"><i class="fa fa-reply"></i></a></span> 
                     <span class="icon_set_pad"><a href="my_profile.html" style="color:#9F0000;"><i class="fa fa-envelope-o"></i></a></span>
                  
                   </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php 
		 }?>
		 <?php  include_once(DIR_ROOT."includes/pagination_div.php");
		} 
		 ?>
         <!--FORUM DISCUSSION END-->
      </div>
      <div class="row">
      	<div class="col-lg-12">
        	<div class="abuse-area text-center">
                <form action="<?php echo SITE_ROOT; ?>abuse-action.php?act=forum&ab=<?php echo $topic; ?>" method="post">
                    <input type="hidden" name="topic" id="topic" />
                    <input type="hidden" name="discuss" id="discuss" />
                    <textarea id="report-abuse" name="abusedtil" placeholder="Write abuse..." style="width:100%" ></textarea>
                    <div class="abuse-submit-btn">
                        <button type="submit" class="btn btn-default" >SUBMIT</button>
                    </div>
                </form>
              </div>
        </div>
      </div>
      <div class="modal fade" id="forum-popup" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div style="border:8px double #000066; border-radius:10px;">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Medical Discussion</h4>
              </div>
              <form action="action.php?act=discussions" method="post" enctype="multipart/form-data">
              <div class="modal-body">
               	<div id="popp"></div>
                <div style="padding:1%">
                <textarea name="discussion"  class="clear ckeditor admin_add_content_textarea" placeholder="Write here..." style="height: 350px;margin: 0 20px;width: 700px; resize:vertical; border:2px double #0F609A;" ></textarea>
                </div>
              </div>
              <div class="modal-footer" align="center">
                <button type="submit" class="forum_post_replay_btn">Submit</button>
                <button type="button" class="forum_post_replay_btn" data-dismiss="modal">Close</button>
              </div>
              </form>
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
              </a> 
              </li>
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
<link rel="stylesheet" href="assets/js/slide/flexslider.css" type="text/css" media="screen" />
<script src="assets/js/slide/jquery.flexslider-min.js"></script>
<script type="text/javascript">
		$(window).load(function() {
			$('.flexslider').flexslider();
		});
	</script>
    <script type="text/javascript" charset="utf-8">
jQuery(document).ready(function($) {

$('#main-slider').flexslider({
    animation: "slide",
    slideToStart: 0,
    start: function(slider) {
        $('a.slide_thumb').click(function() {
            $('.flexslider').show();
            var slideTo = $(this).attr("rel")//Grab rel value from link;
            var slideToInt = parseInt(slideTo)//Make sure that this value is an integer;
            if (slider.currentSlide != slideToInt) {
                slider.flexAnimate(slideToInt)//move the slider to the correct slide (Unless the slider is also already showing the slide we want);
            }
        });
    }

});

$('#secondary-slider').flexslider({
    animation: "slide",
    slideToStart: 0,
    start: function(slider) {
        $('a.slide_thumb').click(function() {
            $('.flexslider').show();
            var slideTo = $(this).attr("rel")//Grab rel value from link;
            var slideToInt = parseInt(slideTo)//Make sure that this value is an integer;
            if (slider.currentSlide != slideToInt) {
                slider.flexAnimate(slideToInt)//move the slider to the correct slide (Unless the slider is also already showing the slide we want);
            }
        });
    }

});

});
</script>
<script type="text/javascript">
/*code for login toggle start*/
		$("#msg_slide").jCarouselLite({
		vertical:true,
		auto:5000,
		speed:1500,
		visible:6,
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
        visibleItems: 6,
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
//<![CDATA[
$("#sp_vertical_menu li:has(ul)").doubleTapVerticalMenuToGo();

function isMobileMenu() {
    if( navigator.userAgent.match(/Android/i) ||
            navigator.userAgent.match(/webOS/i) ||
            navigator.userAgent.match(/iPad/i) ||
            navigator.userAgent.match(/iPhone/i) ||
            navigator.userAgent.match(/iPod/i)
    ){
        return true;
    }
}

jQuery(document).ready(function($){
	;(function(element){
		var el = $(element), vf_menu = $('.vf-menu',el), 
		level1 = $('.vf-menu >.spvm-havechild', el), _li = $('.spvm-havechild', el), vf_button = $('.vf-button',el), nb_hiden = 999;
		
		if(level1.length && level1.length > nb_hiden ) {
			for(var i =0 ; i < level1.length ; i++ ){
				if(i > (nb_hiden - 1)) {
					level1.eq(i).addClass('cat-visible');
					level1.eq(i).hide();
				}
			}
			vf_menu.append('<li class="more-wrap"><span class="more-view"><i class="fa fa-plus-square-o"></i>More Categories</span></li>');
			$('.more-view',vf_menu).on('click touchstart', function(){
				if(level1.hasClass('cat-visible')) 
				{
					vf_menu.find('.cat-visible').removeClass('cat-visible').addClass('cat-hidden').stop().slideDown(400);
					$(this).html('<i class="fa fa-minus-square-o"></i>Close Menu');
				}else if(level1.hasClass('cat-hidden')){
					vf_menu.find('.cat-hidden').removeClass('cat-hidden').addClass('cat-visible').stop().slideUp(200);
					$(this).html('<i class="fa fa-plus-square-o"></i>More Categories');
				}
			});
			
		}
		function _vfResponsiveVerticalMenu() {
			if($(window).width() <= 767) {
				vf_menu.hide();
				$('.cat-title', el).on('click', function(){
					$(this).toggleClass('active').parent().find('ul.vf-menu').stop().slideToggle('medium');
					return false;
				});
				_li.addClass('vf-close');
				_li.children('ul').css('display','none');
				if (vf_button.length) {
					vf_button.on('click', function(){
						 var _this = $(this), li = _this.parent(), ul = li.children('ul');
						 if(li.hasClass('vf-close')) {
							li.removeClass('vf-close').addClass('vf-open');
							ul.stop(false, true).slideDown(500);
							_this.removeClass('icon-close').addClass('icon-open');
						 }else{
							li.removeClass('vf-open').addClass('vf-close');
							ul.stop(false, true).slideUp(200);
							_this.removeClass('icon-open').addClass('icon-close');
						 }
						 return;
					});
				}
			}else{
				$('.cat-title', el).unbind('click');
				vf_button.unbind('click');
				$('.cat-title',el).removeClass('active');
				vf_menu.removeAttr('style');
				_li.addClass('vf-close');
				_li.children('ul').removeAttr('style');
				vf_button.removeClass('icon-open').addClass('icon-close');
			}
		}
		_vfResponsiveVerticalMenu();


        if(isMobileMenu())
        {
        }else{
            $(window).on('resize', function(){
                _vfResponsiveVerticalMenu();
            });
        }
	})('#sp_vertical_menu');
});
//]]>
</script>
<script>
$(document).ready(function(){
    $(".nav-tabs1 a").click(function(){
        $(this).tab('show');
    });
	
});
</script>
<script type="text/javascript" language="javascript">
// functions for control forum
	function forum(topic,dis_of){ // reply 
	var dataString	=	'topic_id='+topic+'&dis_reply_of='+dis_of;
	$.ajax({
		url:'includes/forum_popup.php',
		async:true,
		type:"POST",
		data:dataString,
		dataType:"html",
		success: function(data){ 
			$('#forum-popup').modal('show');
			$('#popp').html(data);
			//$('.click_div').show();
			//$('.media_wrapper').slideDown('500');
		 }
		});
}
function quoteForum(qtopic,qdis_of){ // quoted reply
	var quote		=	2;	
	var dataString	=	'topic_id='+qtopic+'&dis_reply_of='+qdis_of+'&quote='+quote;
	$.ajax({
		url:'includes/forum_popup.php',
		async:true,
		type:"POST",
		data:dataString,
		dataType:"html",
		success: function(data){
			$('#forum-popup').modal('show');
			$('#popp').html(data);
			//$('.click_div').show();
			//$('.media_wrapper').slideDown('500');
		 }
		});
}
function changeViewCount(newCount){
	window.location.href='<?php echo SITE_ROOT?>forum_post.php?tid=<?php echo $topic; ?>&new_view='+newCount;
}
//code for make disscussion area big and small
function fullShow(id){ 
	var showfulltext			=	"showfulltext"+id;
	var showlesstext			=	"showlesstext"+id;
	var discussrow				= 	"discussrow"+id; 
	var discussuser				= 	"discussuser"+id;
	var discusstopic			=	"discusstopic"+id;
	var ask_question_body		=	"ask_question_body"+id;
	var quote_post_area			=	"quote_post_area"+id
	//$('#'+discussrow).animate({height:"635px"});
	$('#'+discussuser).animate({height:"635px"});
	$('#'+discusstopic).animate({height:"635px"});
	var className	=	$('#'+ask_question_body).attr('class');
	if(className == "ask_question_body"){
		$('#'+ask_question_body).animate({height:"515px"});
		
	}
	else{
		$('#'+ask_question_body).animate({height:"435px"});
		$('#'+quote_post_area).animate({height:"100px"});;
	}
	$('#'+showfulltext).hide();
	$('#'+showlesstext).show();
}
function lessShow(id){
	var showfulltext			=	"showfulltext"+id;
	var showlesstext			=	"showlesstext"+id;
	var discussrow				= 	"discussrow"+id; 
	var discussuser				= 	"discussuser"+id;
	var discusstopic			=	"discusstopic"+id;
	var ask_question_body		=	"ask_question_body"+id;
	var quote_post_area			=	"quote_post_area"+id
	//$('#'+discussrow).animate({height:"0"});
	$('#'+discussuser).animate({height:"295px"});
	$('#'+discusstopic).animate({height:"295px"});
	var className	=	$('#'+ask_question_body).attr('class');
	if(className == "ask_question_body"){
	$('#'+ask_question_body).animate({height:"200px"});
	}
	else{
	$('#'+ask_question_body).animate({height:"167px"});
	$('#'+quote_post_area).animate({height:"25px"});
	}
	$('#'+showlesstext).hide();
	$('#'+showfulltext).show();
}
</script>
<script type="text/javascript" language="javascript">
function topicLike(topic){
	if(topic){
		var act			=	"addlike";
		var dataString	=	"like_topic="+topic+"&act="+act;
		
	$.ajax({
				type:"POST",
				url:"action.php",
				data:dataString,
				cache:false,
				success:function(data){ 
					location.reload();
				}
				
			});
	}
	
}
function topicDislike(topic){
	if(topic){
		var act			=	"addDislike";
		var dataString	=	"like_topic="+topic+"&act="+act;
	$.ajax({
				type:"POST",
				url:"action.php",
				data:dataString,
				cache:false,
				success:function(data){ 
					location.reload();
				}
				
			});
	}
}
function discussLike(topic){
	if(topic){
		var act			=	"discussLike";
		var dataString	=	"dislike_topic="+topic+"&act="+act;
		$.ajax({
				type:"POST",
				url:"action.php",
				data:dataString,
				cache:false,
				success:function(data){ 
					location.reload();
				}
			});
	}
}
function discussDisLike(topic){
	if(topic){
		var act			=	"discussDisLike";
		var dataString	=	"dislike_topic="+topic+"&act="+act;
		$.ajax({
				type:"POST",
				url:"action.php",
				data:dataString,
				cache:false,
				success:function(data){
					location.reload();
				}
				
			});
	}
}
</script>
<script type="text/javascript" language="javascript">
	function reportAbuse(t,d){ 
		$('#topic').val(t);
		$('#discuss').val(d);
		$('.abuse-area').toggle();
		$('#report-abuse').focus();
		$("html, body").animate({scrollTop: $('.abuse-area').offset().top }, 1000);
	}
</script>
<?php include_once('includes/footer.php'); ?>
</body>
</html>