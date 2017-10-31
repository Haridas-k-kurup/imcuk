<?php
include_once('../includes/site_root.php');
include_once(DIR_ROOT."class/manage_sub_sub_pluse.php");
$objSubMenuPluse	=	new manage_sub_sub_pluse();
$subSubId		 	=	$_POST['subSubId'];
$allSubMenu		 	=	$objSubMenuPluse->getAll('sub_sub_id ="'.$subSubId.'"','sub_pluse_id desc'); ?>
<option value="">--------------------------------------- SELECT YOUR INNER MENU ---------------------------------------</option>
<?php foreach($allSubMenu as $subMenu){  ?>
 <option value="<?php echo $subMenu['sub_pluse_id']; ?>" ><?php echo $subMenu['sub_pluse_menu']; ?></option>
<?php } ?>