<?php
	include_once('includes/header.php');
	include_once(DIR_ROOT."includes/pagination.php");
	include_once(DIR_ROOT."class/manage_sub_sub_menu.php");
	$objSubSub		=	new manage_sub_sub_menu();
	//$home 		= 	$objMgPage->getFields("mp_heading,mp_desc","page_id='".$currentPage."' and cat_id=6 and mp_status=1","mp_createdon desc");
	//$topSlide		=	$objMgPage->getAll("page_id=1 and pos_id=4 and cat_id=3 and mp_status=1","mp_createdon desc");
	//$allTopics	=	$objMgPage->getAll("page_id = '".$currentPage."' and mp_status=1","mp_createdon desc");
	$pageQuery		=	"select con.page_id, con.cat_id, con.mcp_status, pages.* from manage_pages as pages left join manage_page_connection as con on pages.mp_id = con.mp_id where page_id = '".$currentPage."' and pages.mp_staff_manage = 0 and pages.mp_status=1 and con.mcp_status = 1 order by pages.mp_createdon desc";
	$allTopics		=	$objMgPage->listQuery($pageQuery);
	$story			=	$_GET['story'];
	$URL			=	"http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
 ?> 
  <!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54ab78ba40c0d176" async="async"></script>
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
               <a href="<?php echo $plabLink; ?>">
                <div style="border:5px solid #FFF; padding:5px;">
                  <div style="border:5px solid #000; padding:5px; color:#FFF; background-color:#400080; font-size:28px; font-weight:bold; text-align:center;">PLAB</div>
                </div>
                </a>
              </div>
              <div class="col-lg-6 ">
              <a href="<?php echo $umleLink; ?>">
                <div style="border:5px solid #FFF; padding:5px;">
                  <div style="border:5px solid #000; padding:5px; color:#FFF; background-color:#6C006C; font-size:28px; font-weight:bold; text-align:center;">USMLE</div>
                </div>
                </a>
              </div>
              <div class="col-lg-12">
                <a href="http://drswamyplabcourses.co.uk/" target="_blank">   <div style="border:5px solid #FFF; padding:5px; margin-top:2%;">
                  <div style="border:5px solid #000; padding:5px; color:#FFF; background-color:#5C00B9; font-size:24px; font-weight:bold; text-align:center;">Dr Swamy PLAB Courses<br /> <span style="color:#FF0; font-size:24px; text-shadow: 2px 2px 2px #FF5B5B;">Email :- swamyplab@gmail.com <br />

Tel :-  0044 744  8070 710</span></div>
                </div></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php 
	  include_once('includes/middle_menu.php');
	  $storyDetails		=		$objMgPage->getRow('mp_id="'.$story.'"');
	   ?>
       <div class="story-share">
            <!-- Go to www.addthis.com/dashboard to customize your tools -->
            <div class="addthis_native_toolbox"></div>
          </div>
      <div class="row background2" style="margin-top:10px;" id="scroll_to_this">
        <div class="col-lg-12 padding-0">
          <div class="imc-pagemenu" >
            <center>
             <?php echo $storyDetails['mp_heading']; ?>
            </center>
          </div>
          
          <?php echo stripcslashes($storyDetails['mp_desc']); ?>
          <div class="row">
          	<div class="col-md-3"></div>
          	<div class="col-md-6"><div class="overall-rate"></div></div>
            <div class="col-md-3"></div>
          </div>
        </div>
      </div>
      <div class="fb-like-share">
                           <!--facebook like box start-->
							<script>(function(d, s, id) {
                              var js, fjs = d.getElementsByTagName(s)[0];
                              if (d.getElementById(id)) return;
                              js = d.createElement(s); js.id = id;
                              js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=708286809285991";
                              fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                            
                            <div class="fb-like" data-href="<?php echo $URL; ?>" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
                            
                            <!--facebook like box end-->
                            <div class="abuse-btn-wrap pull-right"><a href="javascript:;" onclick="return reportAbuse();" class="btn btn-default btn-small report-abuse"><i class="fa fa-exclamation-circle"></i>&nbsp;
Report Abuse</a></div>
                            </div>
                            <div class="abuse-area text-center">
                                <form action="<?php echo SITE_ROOT; ?>abuse-action.php?act=slider&ab=<?php echo $story; ?>" method="post">
                                    <textarea id="report-abuse" name="abusedtil" placeholder="Write abuse..."  style="width:100%" required></textarea>
                                    <div class="abuse-submit-btn">
                                        <button class="btn btn-small btn-primary"type="submit" >SUBMIT</button>
                                    </div>
                                </form>
                            </div>
       <div class="row">
       	<div class="col-lg-12 padding-0">
        	<div class="comment-wrapper">
            	<div class="comment_start"><h1>Readers Comments</h1></div>
                <div class="comment-disclimer">
                 <div class="rules-of-comment">
<p><span>Disclaimer:</span> Please fill in the credentials appropriately and truthfully. Kindly do not post any offensive comments that could be personal, abusive, infringing, indecent, defamatory, discriminatory, unlawful or alike. <strong>International Medical Connection </strong> will not be responsible for any defamatory message posted under this article. Consequently, sending offensive comments using International Medical Connection will be purely at your own risk, and in no way will International Medical Connection be held responsible. </p>
<p>Under 66A of the IT Act,sending offensive or menacing messages through electronic communication service and sending false messages to cheat mislead or deceive people or to cause annoyance to them is punishable. It is obligatory on <strong>International Medical Connection</strong> to provide the IP address and other details of senders of such comments, to the authority concerned upon request. </p>
<p><strong>International Medical Connection</strong> reserves the right to edit / block / delete the comments without any notification. </p>
                </div>
            </div>
            <div class="comments" style="width:100% !important;">
           <div id="fb-root"></div>
 <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '708286809285991',
      xfbml      : true,
      version    : 'v2.3'
    });
  };
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
 </script>
                                        <div class="fb-comments" data-href="<?php echo $URL; ?>" data-width="100%" data-numposts="10" data-colorscheme="light" data-order-by="reverse_time"></div>
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
<script type="text/javascript" language="javascript">
	function getRate(){
		var dataString		=	"dataId="+<?php echo $_GET['story']; ?>+"&st=load";	
				$.ajax({
				type:"POST",
				url:"ajax/story_rating.php",
				data:dataString,
				cache:false,
				success:function(data){  
						$('.overall-rate').html(data);
					}	
			});
	}
</script>
<script type="text/javascript" language="javascript">
	function reportAbuse(){
					$('.abuse-area').toggle();
					$('#report-abuse').focus();
	}
</script>
<?php include_once('includes/footer.php'); ?>
 </body>
</html>