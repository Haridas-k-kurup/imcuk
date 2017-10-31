<div  id="msg_slide" style="margin-bottom:10px;">
          <ul style="height:450px;">
            <?php foreach($allTopics as $leftSlide){ 
							  if($leftSlide['cat_id'] == 2){
                            		$imgCont		=	stripslashes($leftSlide['mp_desc']);
									preg_match('/<img.+src=[\'"](?P<src>.+)[\'"].*>/i',$imgCont,$image);
						?>
            <li>
            	<a href="<?php echo SITE_ROOT ?>story_more.php?story=<?php echo $leftSlide['mp_id']; ?>">
              	<div class="news_post ovr">
                <div class="news_post_img"><img class="img-responsive img-thumbnail margin-top-5" src="<?php echo $image['src']; ?>" /></div>
                <div style="color:#000;" class="news_msg_contant ovr"><?php echo substr(stripslashes($leftSlide['mp_heading']),0,50);  ?></div>
              	</div>
              	</a> 
              </li>
              <?php 
					}
				 }
			?>
          </ul>
        </div>