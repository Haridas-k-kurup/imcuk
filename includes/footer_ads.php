<?php 
$allRightAds		=	$objAds->getAll('page_id = "'.$currentPage.'" and pos_id = 8 and ads_staff_manage = 0 and ad_status = 1','ad_position');
foreach($allRightAds as $advs){
?>
<td width="16.66%"><div class="imc-block clearfix">
          <div class="imc-blockcontent">
            <div align="center"><img src="<?php echo SITE_ROOT; ?>advertisement/<?php echo $advs['ad_image']; ?>" width="100%" ></div>
          </div></div></td>
<?php } ?>