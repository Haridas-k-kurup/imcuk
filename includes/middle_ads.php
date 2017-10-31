
<div class="col-xs-12 col-sm-2 col-lg-2 hidden-xs" style="padding:2px;">
  <div class="col-lg-12"  style="border:2px solid #999; margin-top:5px;"> 
  <?php 
$allRightAds		=	$objAds->getAll('page_id = "'.$currentPage.'" and pos_id = 9 and ads_staff_manage = 0 and ad_status = 1','ad_position');
foreach($allRightAds as $advs){
?>
  <img class="img-responsive" src="<?php echo SITE_ROOT; ?>advertisement/<?php echo $advs['ad_image']; ?>">
    <hr/>
    <?php  } ?>
     </div>
</div>
