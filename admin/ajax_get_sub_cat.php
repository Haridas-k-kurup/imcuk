<?php
include_once('../includes/site_root.php');
include_once(DIR_ROOT."class/manage_sub_pages.php");
include_once(DIR_ROOT."class/manage_sub_category.php");
$objSubcat		 	=	new manage_sub_category();
$objSubPage			=	new manage_sub_pages();
$catId			 	=	$_POST['catId'];
$pageId				=	$_POST['pageId']; 
if($catId && $pageId){
//$allPageCat		    =	$objSubPage->getFields('subcat_id','page_id = "'.$pageId.'" and cat_id = "'.$catId.'"', 'subcat_id');
$allPageCat		    =	$objSubPage->getFields('subcat_id','cat_id = "'.$catId.'"', 'subcat_id');
//print_r($allPageCat); ?>
<option value="">--------------------------------------- SELECT YOUR MENU ---------------------------------------</option>
<?php foreach($allPageCat as $eachCat){ 
	$subcat_id		 =  $eachCat['subcat_id'];
	$allSubCat		 =	$objSubcat->getRow("subcat_id = '".$subcat_id."' and subcat_status=1","subcat_name"); ?>
	<option value="<?php echo $allSubCat['subcat_id']; ?>" ><?php echo $allSubCat['subcat_name']; ?></option>
<?php } }else{ 

?>
 
 
 
<?php // first code for select all menu not accroding to page


//include_once('../includes/site_root.php');
//include_once(DIR_ROOT."class/manage_sub_category.php");
//$objSubcat		 =	new manage_sub_category();
//$catId			 =	$_POST['catId'];
$allSubCat		 =	$objSubcat->getAll("cat_id = '".$catId."' and subcat_status=1","subcat_name");
?>
 <option value="">--------------------------------------- SELECT YOUR MENU ---------------------------------------</option>
	<?php  foreach($allSubCat as $subCat){ ?>
                    	<option value="<?php echo $subCat['subcat_id']; ?>" <?php echo ($subCat['subcat_id']==$getPage[0]['subcat_id'])? "selected=selected":'' ?>><?php echo $subCat['subcat_name']; ?></option>
                        <?php } }?>
 
 