<?php 
include_once('../includes/site_root.php');
include_once(DIR_ROOT."admin/includes/pagination.php");
include_once(DIR_ROOT."class/manage_pages.php");
$objPage			= new manage_pages();
$pageId				= $_POST['page_id']; ?>
<form action="<?php echo SITE_ROOT ?>admin/action.php?act=page-menu-connection" method="post" enctype="multipart/form-data">
<input type="hidden" name="page_id" value="<?php echo $pageId ?>" />
<table id="example2" class="table table-bordered table-hover">

  <thead>
    <tr>
      <th width="1%"><input type="checkbox" name="checkbox" class="checkall" id="checkbox"></th>
      <th width="24%">Menu Name</th>
    </tr>
  </thead>
  <?php
/*-----------Pagination start----------------*/
$num_results_per_page 	 		=	($_GET['new_view'])?$_GET['new_view']:10;
$num_page_links_per_page 		= 	100;
$pg_param 						= 	"";
if($search || $_GET['serchcat']){
		$sql_pagination 		= 	"select distinct subCat.subcat_name, subPages.sub_id, subPages.sub_heading, subPages.sub_information from manage_sub_pages as subPages left join manage_sub_category as subCat on subPages.subcat_id = subCat.subcat_id left join submenu_page_connection as subcon on subPages.sub_id = subcon.sub_id where subPages.sub_status = '1' order by subCat.subcat_position asc";
	}else{
	
		$sql_pagination 		= 	"select distinct subCat.subcat_name, subPages.sub_id, subPages.sub_heading, subPages.sub_information from manage_sub_pages as subPages left join manage_sub_category as subCat on subPages.subcat_id = subCat.subcat_id left join submenu_page_connection as subcon on subPages.sub_id = subcon.sub_id where subPages.sub_status = '1' order by subCat.subcat_position asc";
	
}
$pagesection					=	'';
pagination($sql_pagination, $num_results_per_page, $num_page_links_per_page, $pg_param,$pagesection);
$page_list						=	$objPage->listQuery($paginationQuery);
$countpageList					=	mysql_num_rows(mysql_query($sql_pagination));

#get menu which is there in home page 
$pagewiseQuery					= 	"select subCat.subcat_name, subPages.sub_id, subPages.sub_heading, subPages.sub_information from manage_sub_pages as subPages left join manage_sub_category as subCat on subPages.subcat_id = subCat.subcat_id left join submenu_page_connection as subcon on subPages.sub_id = subcon.sub_id where subcon.page_id = '".$pageId."' order by subCat.subcat_position asc";
$menuInfo						= $objPage->listQuery($pagewiseQuery);
$menuArray						= 	array();

if(!empty($menuInfo)) {
	foreach ($menuInfo as $subMenu) {
		$menuArray[]			= $subMenu['sub_id'];
	}
}
if(count($page_list) >0){
	$count=	1;
	foreach($page_list as $key => $all){
		$manuKey				=  array_search($all['sub_id'],$menuArray );
/*-----------Pagination End----------------*/
?>
  <tbody>
    <tr>
      <td><input type="checkbox" name="sub_id[]" value="<?php echo $all['sub_id']?>" <?php echo ($menuArray[$manuKey] == $all['sub_id']) ? "checked" : "" ?>  id="page-menu-<?php echo $key; ?>" class="mglr_checkbox"></td>
      <td><label for="page-menu-<?php echo $key; ?>"><?php echo strip_tags($all['subcat_name']); ?></label></td>
    </tr>
  </tbody>
  <?php } 
									
									 }else{ ?>
  <tr>
    <td colspan="7"><p class="alert-warning">Sorry ! No Details Found</p></td>
  </tr>
  <?php } ?>
</table>
<?php include_once(DIR_ROOT."admin/includes/pagination_div.php"); ?>
<div class="row">
                                     	<div class="col-lg-12 text-center">
                                   			<input type="submit" class="btn btn-success" value="Submit Changes" >
                                        </div>
                                    </div>
                                     </form>