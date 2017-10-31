<div id="left_verical_art" class="table-article" style="height:425px; overflow:hidden;">
                        
                        
                          <ul class="bgcolorskyblue">
                          <?php foreach($allTopics as $rightSlide){ 
							  if($rightSlide['cat_id'] == 5){
                            	$imgCont	=	stripslashes($rightSlide['mp_desc']);
								preg_match('/<img.+src=[\'"](?P<src>.+)[\'"].*>/i',$imgCont,$image);
						?>
                            <li>
                            <a href="<?php echo SITE_ROOT; ?>story_more.php?story=<?php echo $rightSlide['mp_id']; ?>">
                              <div class="news_post ovr">
                                <div class="news_post_img ovr"><img src="<?php echo $image['src']; ?> "  width="100%" /></div>
                                <div class="news_post_contant ovr"><?php echo substr($rightSlide['mp_heading'],0,75); ?></div>
                              </div></a>
                            </li>
                            <?php
							  }
						  }
							 ?>
                          </ul>
                          
                          
                        </div>
                     