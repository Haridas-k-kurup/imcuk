<div id="sp_vertical_menu" class="sp-vertical-menu clearfix">
  <h2 class="cat-title">Categories</h2>
  <ul class="vf-menu clearfix menu-content">
  <?php 
	  if(count($topMenu)>0){
	   foreach($topMenu as $tMenu){
		 $subMenuId				=  $tMenu['sub_id'];	
		 $allTopSubMenus		=  $objSubMenu->getAll('sub_id = "'.$subMenuId.'"', 'position asc'); 	
		 ?>
  
    <li  class=" <?php echo (count($allTopSubMenus) > 0) ? 'spvm-havechild' : '' ?> blue-gradient"><i class="fa fa-street-view"></i><a href="<?php SITE_ROOT; ?>multimedia.php?dept=<?php echo $currentPage; ?>&cat=<?php echo $tMenu['sub_id'];  ?>" class="color-white text-dec-none"><?php echo ucfirst(strtolower($tMenu['subcat_name'])); ?></a> <span class="vf-button icon-close"></span>
    
    <?php 
		  if(count($allTopSubMenus)>0){ ?>
      <ul class="box-border">
       <?php
		     foreach($allTopSubMenus as $allTopsub){ 
                 $allTopSubSub		=	$objSubSub->getAll('sub_menu_id = '.$allTopsub['sub_menu_id'],'position asc') ?>
        <li  class="<?php echo (count($allTopSubSub) > 0) ? 'spvm-havechild' : '' ?> "><a href="<?php echo SITE_ROOT ?>multimedia.php?dept=<?php echo $currentPage; ?>&cat=<?php echo $tMenu['sub_id'];  ?>&aniId=<?php echo $allTopsub['sub_menu_id']; ?>"><?php echo ucfirst(strtolower($allTopsub['sub_menu_name'])); ?></a> <span class="vf-button icon-close"></span>
        
        <?php
				 if(count($allTopSubSub)>0){ ?>
          <ul class="box-border">
          
          <?php foreach($allTopSubSub as $allTopsb){ ?>
            <li  class=" "><a href="<?php echo SITE_ROOT ?>multimedia.php?dept=<?php echo $currentPage; ?>&cat=<?php echo $tMenu['sub_id'];  ?>&aniId=<?php echo $allTopsub['sub_menu_id']; ?>&saniId=<?php echo $allTopsb['sub_sub_id']; ?>"><?php echo ucfirst(strtolower($allTopsb['sub_sub_menu'])); ?></a> <span class="vf-button icon-close"></span>
            
            
              <!--<ul class="box-border">
                <li  class=""><a href="#">Sub Sub Sub Menu 1</a></li>
              </ul>-->
              
            </li>
            <?php } ?>
            
          </ul>
           <?php } ?>
          
        </li>
        <?php } ?>
      </ul>
      <?php  } ?>
      
      
      
    </li>
    
     <?php } } ?>
  </ul>
  
  
  
  
  
  
  
</div>
