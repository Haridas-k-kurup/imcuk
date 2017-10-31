<?php
include_once(DIR_ROOT."admin/includes/header.php");
include_once(DIR_ROOT."admin/includes/pagination.php");
include_once(DIR_ROOT."class/manage_category.php");
include_once(DIR_ROOT."class/manage_pages.php");
include_once(DIR_ROOT."class/manage_page_connection.php");
include_once(DIR_ROOT."class/imc_pages.php");
$objCat				= new manage_category();
$objPage			= new manage_pages();
$objPageCon			= new manage_page_connection();
$allCat				= $objCat->getAll('(cat_id = 1 or cat_id = 2 or cat_id = 3 or cat_id = 5 or cat_id = 6) and cat_status=1','cat_category asc');
if(isset($_GET['dept'])){
	$pageId			= $objCommon->esc($_GET['dept']);
	$pageDtils		= $objImcPage->getRow('page_id = "'.$pageId.'"');
}
$phpSelf			= SITE_ROOT.'admin/index.php?page=list_page_details&dept='.$pageId;
$search				= $objCommon->esc($_REQUEST['search_field']);
$sid				= $objCommon->esc($_GET['sid']);
$del_id				= $_REQUEST['del_id'];

if(count($del_id)>0){
	if($adminType == 1){
	foreach($del_id as $all_del_id){
		$objPage->delete("mp_id=".$all_del_id);	
	}
	}else{
		foreach($del_id as $all_del_id){
		$objPage->updateField(array("mp_staff_manage"=>1),"mp_id =".$all_del_id);
	}
		}
	$notfn->add_msg("Selected item has been removed successfully...!",3);
	header("location:".$phpSelf);
}
if($sid && $_GET['scat']){
	$sCat			=  $objCommon->esc($_GET['scat']);
	$editData		=  $objPageCon->getRow("mp_id =".$sid." and page_id=".$pageId." and cat_id = ".$sCat, "mpc_id");
	if($editData['mcp_status'] == 0){
		$objPageCon->updateField(array("mcp_status"=>1),"mp_id	=".$sid." and page_id=".$pageId." and cat_id = ".$sCat);
	}else{
		$objPageCon->updateField(array("mcp_status"=>0),"mp_id =".$sid." and page_id=".$pageId." and cat_id = ".$sCat);
	}
	header("location:".$phpSelf);
}
/*-----------Recover content from staff start----------------------------*/
if(isset($_GET['dsid']) && $_GET['dsid'] > 0 && $adminType == 1){
	$mpID				=	$objCommon->esc($_GET['dsid']);
	$objPage->updateField(array("mp_staff_manage"=>0),"mp_id =".$mpID);
	$notfn->add_msg("Page detail has been Recovered...!",3);
	//header("location:".$phpSelf);
}
/*-----------Recover content from staff end----------------------------*/
?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <?php include_once('includes/sidemenubar.php'); ?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                       List all I M C pages and menus
                        <small>International Medical Connection</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo SITE_ROOT ?>admin"><i class="fa fa-dashboard"></i>Home</a></li>
                        <li><a href="#">Manage Main Menus</a></li>
                        <li><a href="<?php echo SITE_ROOT ?>admin/index.php?page=edit_inner_pages">Manage Main Menus</a></li>
                        <li class="active">Page and Menu</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                      <?php 
						echo $notfn->msg();
						?> 
                        <div class="col-xs-12">
                            <div class="box">
                                <!-- /.box-header -->
                                <div class="row">
                                
                    			
                                	<div class="col-lg-6">
                                        <div class="row">
                                        <div class="col-lg-4">
                                           <div class="form-group margin">
                                            <select class="form-control" name="page_id" id="search-cat">
                                                <?php foreach($allPages as $pageInfo){ ?>
                                                <option value="<?php echo $pageInfo['page_id']; ?>"><?php echo $pageInfo['page_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div> 
                                        </div>
                                        <div class="col-lg-8">
                                            
                                        </div>
                                        </div>
                                    </div>
                                  
                                    <div class="col-lg-3">
                                        
                                    </div>
                                    <div class="col-lg-3">
                                        
                                    </div>
                                </div>
                                
                                <div class="box-body table-responsive" id="menu-table">
                                <form action="<?php echo SITE_ROOT ?>admin/action.php?act=page-menu-connection" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="page_id" value="1" />
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
$pagewiseQuery					= 	"select subCat.subcat_name, subPages.sub_id, subPages.sub_heading, subPages.sub_information from manage_sub_pages as subPages left join manage_sub_category as subCat on subPages.subcat_id = subCat.subcat_id left join submenu_page_connection as subcon on subPages.sub_id = subcon.sub_id where subcon.page_id = 1 order by subCat.subcat_position asc";
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
                                     	<td colspan="7">
                                        	<p class="alert-warning">Sorry ! No Details Found</p>
                                        </td>
                                     </tr>
                                     <?php } ?> 
                                    </table>
                                    
                                    <?php include_once(DIR_ROOT."admin/includes/pagination_div.php"); ?>
                                    <div class="row">
                                     	<div class="col-lg-12 text-center">
                                   			<input type="submit" class="btn btn-success" value="Submit Changes" >
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                       </form>
                            </div><!-- /.box -->
                            
                                </div>
                               
                            <!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
		<script type="text/javascript" language="javascript">
			$(document).on("click","#checkbox",function(){
			var checked_status = this.checked;
			$(".mglr_checkbox").each(function(){
				this.checked = checked_status;
			});
			});
			$('#delete-all').click(function(){
				if(confirm('You are sure to delete this Item... Continue?')){
				$('#manage-details').submit();
				}
				});
		</script>
        <script type="text/javascript" language="javascript">
        	$('#search-cat').on('change', function(){
					var pageId		= $(this).val();
					var dataString 	= 'page_id='+pageId;
					$.ajax({
						type: "POST",
						url: "ajax_page_and_menu.php",
						data: dataString,
						cache: false,
						async:false,
						success: function(data){ 
								$('#menu-table').html(data);
							}
						});
				});
        </script>
    </body>
</html>