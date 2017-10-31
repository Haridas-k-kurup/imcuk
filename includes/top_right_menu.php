<?php /* if(count($topRightMenu)){
		foreach($topRightMenu as $topRMenu){
	 ?>
     <a href="<?php SITE_ROOT; ?>multimedia.php?dept=<?php echo $currentPage; ?>&cat=<?php echo $topRMenu['sub_id'];  ?>">
    <div class="home-main-ads-wrapper">
        <div class="home-main-ads-head">
            <span><?php echo $topRMenu['subcat_name'];  ?></span>
        </div>
        <div class="home-main-ads-img">
        		<?php 
					$imgSrc		=  stripslashes($topRMenu['sub_information']);
					preg_match('/<img.+src=[\'"](?P<src>.+)[\'"].*>/i',$imgSrc,$rightImg);
				 ?>
            <img src="<?php echo $rightImg['src']; ?>" width="100%" />
        </div>
    </div>
    </a>
 <?php } }*/ ?>

<?php/* if(count($topRightMenu)){
		foreach($topRightMenu as $topRMenu){*/
	 ?>
     <a href="<?php SITE_ROOT; ?>multimedia.php?dept=2&cat=41&aniId=177&saniId=41">
    <div>
        
        <img src="images/plab_training.png" width="100%" height="255" />
    </div>
    </a>
 <?php //} }?>