<?php 
	  if (count($middleMenu)>0) {	
		 ?>
<div class="row background2">
        <div class="col-lg-6">
          <div class="row">
          
          <?php $midClr				=	1;
				foreach ($middleMenu as $midMenu) {
		 			$subMenuId		=   $midMenu['sub_id'];	
			 ?>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 padding_col3">
              <div class="imageborder">
                <div class="coursehead"><a href="<?php SITE_ROOT; ?>multimedia.php?dept=<?php echo $currentPage; ?>&cat=<?php echo $midMenu['sub_id'];  ?>"><?php echo $objCommon->html2text($midMenu['subcat_name']); ?></a></div>
                <div class="navigation1">
                  <div style="background-color:#FFF; width:100%;">
                    <ul class="top-level">
                      <li>
                        <div class="center-menu text-center">
                        	<center>
                            <?php 
							$imgSrc		=  stripslashes($midMenu['sub_information']);
							preg_match('/<img.+src=[\'"](?P<src>.+)[\'"].*>/i',$imgSrc,$midImage);
				 			?>
                          		<img class="img-responsive" style="height:100px;" src="<?php echo stripslashes($midImage['src']); ?>" alt="">
                          </center>
                        </div>
                        <?php $allMidSubMenus	=	$objSubMenu->getAll('sub_id = "'.$subMenuId.'"', 'position asc');
		 					if (count($allMidSubMenus)>0) {
		  					?>
                        <ul class="sub-level">
                          <?php foreach ($allMidSubMenus as $midsub) { ?>
                          <li class="sub_sub3"><a href="<?php echo SITE_ROOT ?>multimedia.php?dept=<?php echo $currentPage; ?>&cat=<?php echo $midMenu['sub_id'];  ?>&aniId=<?php echo $midsub['sub_menu_id']; ?>"><?php echo strip_tags(ucfirst(strtolower($midsub['sub_menu_name']))); ?></a>
                          <?php $midSubSubMenu	=	$objSubSub->getAll('sub_menu_id = '.$midsub['sub_menu_id'],'position asc');
						if (count($midSubSubMenu)>0) {
					 ?>
                          <span>&gt;&gt;</span>
                            <ul class="sub-level sub_sub1" style="margin-left:90px;">
                             <?php foreach ($midSubSubMenu as $keys=>$subSubMenu) { ?>
                              <li class="sub_sub2"><a href="<?php echo SITE_ROOT ?>multimedia.php?dept=<?php echo $currentPage; ?>&cat=<?php echo $midMenu['sub_id'];  ?>&aniId=<?php echo $midsub['sub_menu_id']; ?>&saniId=<?php echo $subSubMenu['sub_sub_id']; ?>"><?php echo $subSubMenu['sub_sub_menu']; ?></a></li>
                              <?php } ?> 
                            </ul>
                            
                            <?php } ?>
                          </li>
                          
                          <?php } ?>
                        </ul>
                        <?php } ?>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            
            <?php
			if ($midClr%4 == 0) { ?>
            </div>
        </div>
        <div class="col-lg-6">
          <div class="row">
		<?php 	}
			
			 $midClr++; } ?>
          </div>
        </div>
        
        </div>
        <?php } ?>