<?php
include_once('../includes/site_root.php');
include_once(DIR_ROOT."class/manage_sub_menu.php");
$objSubMenu		 =	new manage_sub_menu();
$sub_id			 =	$_POST['sub_cat_id'];
$menuSql		 =	"SELECT submenu.sub_menu_id, submenu.sub_menu_name FROM manage_sub_menu as submenu left join manage_sub_pages as subpage on submenu.sub_id   = subpage.sub_id left join manage_sub_category as subcat on subpage.subcat_id = subcat.subcat_id WHERE subcat.subcat_id = '".$sub_id."'";
$allSubMenu		 =	$objSubMenu->listQuery($menuSql); ?>
 <option value="">--------------------------------------- SELECT YOUR SUB MENU ---------------------------------------</option>
	<?php	foreach($allSubMenu as $subMenu){
 ?>
 <option value="<?php echo $subMenu['sub_menu_id']; ?>" ><?php echo $subMenu['sub_menu_name']; ?></option>
 <?php } ?>
 
 