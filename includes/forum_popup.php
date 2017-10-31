<?php 
include('../includes/site_root.php'); 
include_once(DIR_ROOT.'class/forum_discussion.php');
include_once(DIR_ROOT.'class/forum_topics.php');
$objDis	=	new forum_discussion();
$objTop	=	new forum_topics();
?>
<?php
	$topic	=	$_POST['topic_id'];
	$disId	=	$_POST['dis_reply_of'];
	$quote	=	$_POST['quote'];
	if($quote	==	2){
		$quoteSql	=	"select dis.reg_id,user.ud_name_title,user.ud_first_name  from forum_discussion as dis left join user_details as user on dis.reg_id=user.reg_id where dis.dis_id='".$disId."' order by dis.dis_id ";
		$qutedperson	=	$objDis->listQuery($quoteSql);
		$first			=	$qutedperson[0]['ud_name_title'];
		$second			=	$qutedperson[0]['ud_first_name'];
		$quoteName		=	$first.": ".$second;
	}
	$allDic				=	$objDis->getFields("discussion","dis_id='".$disId."'","dis_id");
 ?>
    <?php if($disId){ ?>
    <div class="disscuss_for">
    	<?php echo $allDic[0]['discussion']; ?>
    </div>
    <?php } 
	else{
    $allTop				=	$objTop->getFields("topic_desc","topic_id='".$topic."'","topic_id");
	 ?>
		 <div class="disscuss_for">
    	<?php echo $allTop[0]['topic_desc']; ?>
    </div>
	<?php } ?>
      <input type="hidden" name="topic_id" value="<?php echo $topic; ?>">
      <input type="hidden" name="dis_reply_of" value="<?php echo $disId; ?>">
      <input type="hidden" name="dis_quote" value="<?php echo $quoteName; ?>">
      