<?php 
$allRightAds		=	$objAds->getAll('page_id = "'.$currentPage.'" and pos_id = 6 and ads_staff_manage = 0 and ad_status = 1','ad_position'); 
if(!empty($allRightAds)){
?>
<div align="center" class="background1" style="margin-top:10px;"> 
<?php 
foreach($allRightAds as $advs){
?>
<img class="img-responsive img-thumbnail" src="<?php echo SITE_ROOT; ?>advertisement/<?php echo $advs['ad_image']; ?>">  
<?php } ?>
</div>
<?php } ?>