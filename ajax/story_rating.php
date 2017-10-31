<?php
session_start();
include_once("../includes/site_root.php");
include_once(DIR_ROOT."includes/action_functions.php");
include_once(DIR_ROOT.'class/story_rating.php');
$objRate		=	new story_rating();
$objCommon		=	new common_functions();
$ip				=	$objCommon->get_ip();
$storyId		=	$objCommon->esc(trim($_POST['dataId']));
if($storyId && $_POST['st'] == "load"){
	$getDtil	=	$objRate->getFields('SUM(rate_like) as totallike, SUM(rate_dislike) as totaldislike', 'mp_id='.$storyId, '');
	$total		=	$getDtil[0]['totallike']+$getDtil[0]['totaldislike'];
	if($total){
	$likePer	=	$getDtil[0]['totallike']*100/$total;
	$disPer		=	$getDtil[0]['totaldislike']*100/$total;
	}
	//print_r($objRate->getAll());
?>
<div class="story-rate ovr">
  <div class="story-rate-btn ovr">
    <label><b>Rate this article :</b></label>
    <div class="rate-btn-wrap ovr"> 
    <?php $checkRate				=	$objRate->getRow('mp_id = '.$storyId." and rate_ip = '".$ip."' ",'rating_id'); ?>
    
    <!--<a class="rate-btns rate-like  <?php echo (empty($checkRate))? '' : 'disabled' ?> <?php echo ($checkRate['rate_like'] == 1)? 'like-active' : '' ?>  fl" href="javascript:;" onclick="return rateStory(1);"><i class="fa fa-thumbs-up"></i> &nbsp;Like</a> 
    
    <a class="rate-btns rate-dislike <?php echo (empty($checkRate))? '' : 'disabled' ?> <?php echo ($checkRate['rate_dislike'] == 1)? 'dis-like-active' : '' ?> fl" href="javascript:;" onclick="return rateStory(2);"><i class="fa fa-thumbs-down"></i> &nbsp;Dislike</a>-->
    
    
    <div class="btn-group btn-group-justified">
    <a href="javascript:;" onclick="return rateStory(1);" class="btn btn-primary <?php echo (empty($checkRate))? '' : 'disabled' ?> <?php echo ($checkRate['rate_like'] == 1)? 'like-active' : '' ?>"><i class="fa fa-thumbs-up"></i>&nbsp;Like</a>
    <a href="javascript:;" onclick="return rateStory(2);" class="btn btn-danger <?php echo (empty($checkRate))? '' : 'disabled' ?> <?php echo ($checkRate['rate_dislike'] == 1)? 'dis-like-active' : '' ?>"><i class="fa fa-thumbs-down"></i>&nbsp;Dislike</a>
  </div>
    
      <div class="clear"></div>
    </div>
    <div class="rate-graph-wrapper">
      <?php if($getDtil[0]['totallike']){ ?>
       <label><b>Like</b></label>
      <div class="progress">
    <div class="progress-bar progress-bar-striped  active" role="progressbar" aria-valuenow="<?php echo $likePer; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $likePer."%" ?>">
      <?php echo ($getDtil[0]['totallike']) ? $getDtil[0]['totallike'] : '' ?>
    </div>
  </div>
      <?php } if($getDtil[0]['totaldislike']){ ?>
       <label><b>Dislike</b></label>
      <div class="progress">
    <div class="progress-bar progress-bar-striped progress-bar-danger active" role="progressbar" aria-valuenow="<?php echo $disPer; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $disPer."%" ?>">
      <?php echo ($getDtil[0]['totaldislike']) ? $getDtil[0]['totaldislike'] : '' ?>
    </div>
  </div>
      <?php } ?>
    </div>
    
  </div>
</div>
<script type="text/javascript" language="javascript">
	function rateStory(e){
		var dataString		=	"dataId="+<?php echo $storyId; ?>+"&rate="+e+"&st=rate";	
				$.ajax({
				type:"POST",
				url:"ajax/story_rating.php",
				data:dataString,
				cache:false,
				success:function(data){  
						getRate();
					}	
			});
	}
</script>
<?php }else if($storyId && $_POST['rate'] && $_POST['st'] == "rate"){
	$rateStatus				=	$_POST['rate'];
	$checkRate				=	$objRate->getRow('mp_id = '.$storyId." and rate_ip = '".$ip."' ",'rating_id');
	$_POST['mp_id']			=	$storyId;
	$_POST['rate_ip']		=	$ip;
	$_POST['rate_status']	=	1;
	if(empty($checkRate)){
		if($rateStatus == 1){
		$_POST['rate_like']		=	1;
		$objRate->insert($_POST);
		}else if($rateStatus == 2){
		$_POST['rate_dislike']	=	1;
		$objRate->insert($_POST);
		}
	}
	
}?>
