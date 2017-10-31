<?php
include_once('../includes/site_root.php');
include_once(DIR_ROOT."class/manage_sub_sub_menu.php");
$objSubSubMenu	 =	new manage_sub_sub_menu();
$sub_menu_id	 =	$_POST['sub_menu_id'];
$allSubMenu		 =	$objSubSubMenu->getAll('sub_menu_id="'.$sub_menu_id.'"','sub_menu_id');
if(count($allSubMenu)){
	echo 1;
}else{
	echo 0;
}
?>
 