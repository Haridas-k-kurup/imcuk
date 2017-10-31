<div class="col-lg-5 sliderbg">
  <div class="row">
    <div class="col-lg-12" style="padding:3px 10px;">
      <div id="main-slider" class="flexslider">
        <ul class="slides">
         <?php foreach($allTopics as $slide){ 
				if($slide['cat_id'] == 3){
                $imgCont		=	stripslashes($slide['mp_desc']);
				preg_match('/<img.+src=[\'"](?P<src>.+)[\'"].*>/i',$imgCont,$image);
								?>
          <li> <img src="<?php echo stripslashes($image['src']); ?>" class="img-responsive" style="max-height:100px !important; width:100%; " /> </li>
         <?php 
							  }
							   } ?>
        </ul>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12" style="padding:3px 10px;">
      <div id="secondary-slider" class="flexslider">
        <ul class="slides">
        <?php foreach($allTopics as $slide){ 
				if($slide['cat_id'] == 3){
					?>
          <li>
            <a href="<?php echo SITE_ROOT; ?>story_more.php?story=<?php echo $slide['mp_id']; ?>"><p><?php echo stripslashes(substr(strip_tags($slide['mp_desc']),0,100)); ?></p></a>
          </li>
          <?php 
			 }
		} ?>
        </ul>
      </div>
    </div>
  </div>
</div>
