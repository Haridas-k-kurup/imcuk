<?php
	include_once('includes/header.php');
	include_once(DIR_ROOT."class/manage_sub_sub_menu.php");
	include_once(DIR_ROOT."class/about_us.php");
	$objSubSub		=	new manage_sub_sub_menu();
	$objAbout		=	new about_us();
	$getAbout		=	$objAbout->getRow();
	//$home 		= 	$objMgPage->getFields("mp_heading,mp_desc","page_id='".$currentPage."' and cat_id=6 and mp_staff_manage = 0 and mp_status=1","mp_createdon desc");
	//$topSlide		=	$objMgPage->getAll("page_id=1 and pos_id=4 and cat_id=3 and mp_status=1","mp_createdon desc");
	//$allTopics	=	$objMgPage->getAll("page_id = '".$currentPage."' and mp_staff_manage = 0 and mp_status=1","mp_createdon desc");
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
        
        <!-- MAIN SLIDER START -->
       
        <!-- MAIN SLIDER END -->
        
      </div>
      <?php 
	  if ($getAbout['about_head']) {
	   ?>
         
      <div class="row background2" style="margin-top:10px;">
        <div class="col-lg-12 padding-0">
          <div class="imc-pagemenu" >
            <center>
             <?php echo stripslashes($getAbout['about_head']); ?>
            </center>
          </div>
          <div class="imc_heading1">
            <center>
              Information
            </center>
          </div>
         <?php echo stripslashes($getAbout['about_us']); ?>
        </div>
      </div>
      <?php } ?> 
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