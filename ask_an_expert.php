<?php
	include_once('includes/header.php');
	include_once(DIR_ROOT."class/manage_sub_sub_menu.php");
	$objSubSub		=	new manage_sub_sub_menu();
	/*if($_GET['dept'] > 7){
			echo "<img src=\"images/under_construction_animated.gif\" style=\"margin: 0px 15%;\">"; exit;
		}*/
	//$home 			= 	$objMgPage->getFields("mp_heading,mp_desc","page_id='".$currentPage."' and cat_id=6 and mp_staff_manage = 0 and mp_status=1","mp_createdon desc");
		$homeQuery		=	"select pages.* from manage_pages as pages left join manage_page_connection as con on pages.mp_id = con.mp_id where page_id = '".$currentPage."' and pages.mp_staff_manage = 0 and pages.mp_status=1 and con.cat_id = 6 and con.mcp_status = 1 order by pages.mp_createdon desc";
	$home 			= 	$objMgPage->listQuery($homeQuery);
	
	//$topSlide		=	$objMgPage->getAll("page_id=1 and pos_id=4 and cat_id=3 and mp_status=1","mp_createdon desc");
	//$allTopics		=	$objMgPage->getAll("page_id = '".$currentPage."' and mp_staff_manage = 0 and mp_status=1","mp_createdon desc");
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
        <!-- <p align="center"><img id="down_arrow_img1" src="assets/img/up_arraow1.png" style=" z-index:1000; position:absolute; cursor:pointer; "><p>-->
        <!--Left vertical slider start-->
        <?php include_once(DIR_ROOT."includes/left_slider.php"); ?>
        <!--Left vertical slider end-->
      </div>
      <div class="imc-blockcontent">
        <div align="center">
          <div class="sug-consult">
          	<a style="text-decoration:none;" data-toggle="modal" data-target="#myModal">
                <div class="write_topic_container ovr">
                  <label class="write_topic_head">write a new topic</label>
                </div>
            </a>
         </div>
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
              <label class="write_topic_head">View Previous Q&A </label>
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
      <div class="row background2" style="margin-top:10px;">
        <div class="col-lg-12 padding-0">
          <div class="imc-pagemenu" >
            <center>
                Ask An Expert
            </center>
          </div>
          <div class="imc_heading1">
            <center>
              Information
            </center>
          </div>
          
         <?php echo stripslashes($home[0]['mp_desc']); ?>
          
          <p style="float:right"><a class="classname">Click here to give Suggestions on this Topic</a></p>
        </div>
      </div>
        <?php 
							/*-----------Topic start----------------*/
					$num_results_per_page 	 		=	10;	//($_GET['new_view'])?$_GET['new_view']:;
				//	$num_page_links_per_page 		= 	7;
					
					$sql_pagination 				= 	"select user.ud_name_title, user.ud_first_name, user.ud_pofile_pic, ask.ask_q_id, ask.ask_q_heading, ask.ask_q_message, ask.ask_q_views, anw.ask_a_created,ask.ask_q_created,count(anw.ask_a_id) as countrely from ask_question as ask left join user_details as user on ask.reg_id = user.reg_id left join ask_answer as anw on ask.ask_q_id=anw.ask_q_id";
					
					
						$sql_pagination 			.=	" where ask.ask_q_staff_manage = 0 and ask.ask_q_status = 1";
					
					
					
						$sql_pagination				.=	" group by ask.ask_q_id order by ask.ask_q_id desc";
					
					$pagesection					=	'';
					pagination($sql_pagination,$num_results_per_page);
					$page_list						=	$objThread->listQuery($pageQuery);
		?>
      <div class="row"  style="margin-top:10px;">
        <div class="col-lg-12 imc-pagemenu1">
          <div align="center">Latest posts in all <?php echo ($currentPage != 1) ? ucfirst($pageName['page_name']) : '' ?> forums </div>
          <?php  include_once(DIR_ROOT."includes/pagination_div.php"); ?>
        </div></div>
        <div class="row" >
        <div class="col-lg-12">
        <div class="col-xs-12 col-sm-5 col-lg-5"  style="padding:2px 15px 2px 2px;">
        
        
        <div class="row" >
          <div class="col-lg-12"  style="border:2px solid #999; margin-top:5px;">
            <div class="row"  style="border:1px solid #999">
              <div class="col-lg-4"  style="border-right:1px solid #999">
               <?php //if ($currentPage != 1) { ?>
                <button type="button" class="add_to_user btn-lg" data-toggle="modal" data-target="#myModal">ADD TOPIC</button>
                <?php //} ?>
              </div>
              <div class="col-lg-8"><span class="topichead">Arranged Topic-wise</span></div>
            </div>
          </div>
          </div>
          <?php 
			$dummyImg		= "uploades/forum-icon.png";
			foreach($page_list as $all) { 
			$imgDiscu		= stripslashes($all['topic_desc']);
			preg_match('/<img [^>]*src=["|\']([^"|\']+)/i',$imgDiscu,$dImage);
			$newImg			= str_replace("http://localhost/imc/",SITE_ROOT,$dImage[1]);
			 ?>
        <div class="row" >
          <div class="col-lg-12"  style="border:2px solid #999; margin-top:5px;">
            <div class="row"  style="border:1px solid #999">
              <div class="col-lg-4"  style="border-right:1px solid #999"><span class="topicname"><?php echo $all['ud_name_title'].": "; echo stripslashes($all['ud_first_name']); ?></span></div>
              <div class="col-lg-8">
                <div class="row">
                  <div class="col-lg-6"  style="border-right:1px solid #999">
                    <label class="replys" title="TOTAL REPLIES"> <i class="fa fa-comments"></i> </label>
                    <?php echo  $all['countrely']; ?> <span class="replys" style="font-weight:bold;">|</span>
                    <label class="replys" title="TOTAL VIEWS"> <i class="fa fa-eye"></i> </label>
                    <?php echo  $all['topic_view']; ?></div>
                  <div class="col-lg-6"><span class="topicname"><?php echo stripslashes($all['ask_q_created']); ?></span></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3" style="border-right:1px solid #999"><img  width="<?php echo ($newImg)? "100%" : '' ?>" src="<?php echo ($newImg)? $newImg : $dummyImg ?>"></div>
              <div class="col-lg-9">
                <p><?php echo substr(strip_tags($all['ask_q_message']),0,80)."..."; ?><a style="font-weight:bold; color:#910000" href="<?php echo SITE_ROOT; ?>expert_forum.php?id=<?php echo $all['ask_q_id']; ?>&dept=<?php echo $currentPage; ?>">&nbsp;&nbsp; Read more</a></p>
              </div>
            </div>
          </div>
          </div>
        
        <?php } ?>
        </div>
        <?php include_once(DIR_ROOT.'includes/middle_ads.php'); ?>
        
        
        <div class="col-xs-12 col-sm-5 col-lg-5"  style="padding:2px 2px 2px 15px; ">
        
        <div class="row" >
          <div class="col-lg-12"  style="border:2px solid #999; margin-top:5px;">
            <div class="row"  style="border:1px solid #999">
              <div class="col-lg-12"><span class="topichead">
                <center>
                  Arranged Comment-wise
                </center>
                </span></div>
            </div>
          </div>
          </div>
          <?php 
			$dummyImg		= "uploades/dummyForum.jpg";
			$commentWise 	= "select user.ud_name_title, user.ud_first_name, user.ud_pofile_pic, ask.ask_q_id, ask.ask_q_heading, ask.ask_q_message, ask.ask_q_views, anw.ask_a_created,ask.ask_q_created,count(anw.ask_a_id) as countrely from ask_question as ask left join user_details as user on ask.reg_id = user.reg_id left join ask_answer as anw on ask.ask_q_id = anw.ask_q_id";
			
			$commentWise 	.= " where ask.ask_q_staff_manage = 0 and ask.ask_q_status = 1";
			
			$commentWise 	.= " group by ask.ask_q_id order by max(anw.ask_a_created) desc";
			$pagesection	 = '';
			pagination($commentWise,$num_results_per_page);
			$page_list		 = $objThread->listQuery($pageQuery);
			
			foreach($page_list as $all){
				$imgDiscu	 = stripslashes($all['topic_desc']);
				preg_match('/<img [^>]*src=["|\']([^"|\']+)/i',$imgDiscu,$dImage);
				$newImg		 = str_replace("http://localhost:81/imc/",SITE_ROOT,$dImage[1]);
			 ?>
        <div class="row">
          <div class="col-lg-12" style="border:2px solid #999; margin-top:5px;">
            <div class="row"  style="border:1px solid #999">
              <div class="col-lg-4"  style="border-right:1px solid #999"><span class="topicname"><?php echo $all['ud_name_title'].": "; echo stripslashes($all['ud_first_name']); ?></span></div>
              <div class="col-lg-8">
                <div class="row">
                  <div class="col-lg-6"  style="border-right:1px solid #999">
                    <label class="replys" title="TOTAL REPLIES"> <i class="fa fa-comments"></i> </label>
                    <?php echo  $all['countrely']; ?> <span class="replys" style="font-weight:bold;">|</span>
                    <label class="replys" title="TOTAL VIEWS"> <i class="fa fa-eye"></i> </label>
                     <?php echo  $all['topic_view']; ?></div>
                  <div class="col-lg-6"><span class="topicname"><?php echo stripslashes($all['ask_q_created']); ?></span></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3"   style="border-right:1px solid #999"><img width="<?php echo ($newImg)? "100%" : '' ?>" src="<?php echo ($newImg)? $newImg : $dummyImg ?>"></div>
              <div class="col-lg-9">
                <p><?php echo substr(strip_tags($all['ask_q_message']),0,80)."..."; ?> <a style="font-weight:bold; color:#910000" href="<?php echo SITE_ROOT; ?>expert_forum.php?id=<?php echo $all['ask_q_id']; ?>&dept=<?php echo $currentPage; ?>">&nbsp;&nbsp; Read more</a></p>
              </div>
            </div>
          </div>
          </div>
          <?php } ?>
        </div>
        
      </div>
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div style="border:8px double #000066; border-radius:10px;">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">IMC Forum Discussion</h4>
              </div>
              <form action="action.php?act=create_new_thread" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                <div class="form-group">
                    <label>Forum Topic</label>
                    <input type="text" placeholder="Enter topic ..." class="form-control" title="Forum Topic" required="required">
                    <input type="hidden" name="page_id" value="<?php echo $currentPage; ?>">
                  </div>
                  <div class="form-group">
                    <label>Forum Description</label>
                     <textarea id="editor1" name="topic_desc"  class=" clear ckeditor admin_add_content_textarea" placeholder="Write here..." ></textarea>
                  </div>
              </div>
              <div class="modal-footer" align="center">
                <button type="submit" class="forum_post_replay_btn" >Submit</button>
                <button type="button" class="forum_post_replay_btn" data-dismiss="modal">Close</button>
              </div>
              </form>
            </div>
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

<!--Slider Plugin Start-->
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
                slider.flexAnimate(slideToInt) //move the slider to the correct slide (Unless the slider is also already showing the slide we want);
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
<?php include_once('includes/footer.php'); ?>
 </body>
</html>