<?php
include_once('../includes/site_root.php');
include_once(DIR_ROOT."class/manage_sub_sub_menu.php");
$objSubSubMenu		=	new manage_sub_sub_menu();
$sub_menu_id	 	=	$_POST['subId'];
$allSubMenu		 	=	$objSubSubMenu->getAll('sub_menu_id ="'.$sub_menu_id.'"','sub_menu_id desc'); ?>
 <option value="">--------------------------------------- SELECT YOUR SUB-SUB MENU ---------------------------------------</option>
	<?php	foreach($allSubMenu as $subMenu){  ?>
 <option value="<?php echo $subMenu['sub_sub_id']; ?>" ><?php echo $subMenu['sub_sub_menu']; ?></option>
 <?php } ?>