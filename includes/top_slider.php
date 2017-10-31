<div class="row">
    <div class="col-sm-12">
      <div class="borderslide">
        <ul id="flexiselDemo3">
        <?php foreach($allTopics as $topSlide){ 
							  if($topSlide['cat_id'] == 1){
                            		$imgCont	=	stripslashes($topSlide['mp_desc']);
									preg_match('/<img.+src=[\'"](?P<src>.+)[\'"].*>/i',$imgCont,$image);
					?>
          <li style="width:300px">
          <a href="<?php echo SITE_ROOT ?>story_more.php?story=<?php echo $topSlide['mp_id']; ?>">
            <div class="top_slider ovr">
              <div class="top_slide_img ovr"><img class="img-responsive img-thumbnail"  style="max-height:70px;" src="<?php echo $image['src']; ?>"></div>
              <div class="top_slide_contant ovr"><?php echo stripslashes(substr(strip_tags($topSlide['mp_heading']),0,150)); ?></div>
            </div>
          </li>
          </a>
           <?php 
				}
			}
			 ?>
        </ul>
      </div>
    </div>
  </div>