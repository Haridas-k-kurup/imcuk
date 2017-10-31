<?php
include_once('../includes/site_root.php');
include_once(DIR_ROOT."class/manage_sub_sub_pluse.php");
$objSubMenuPluse	=	new manage_sub_sub_pluse();
$subSubId		 	=	$_POST['subSubId'];
$allSubSub		 	=	$objSubMenuPluse->getAll('sub_sub_id="'.$subSubId.'"','sub_sub_id');
if(count($allSubSub)){
	echo 1;
}else{
	echo 0;
}
?>
 