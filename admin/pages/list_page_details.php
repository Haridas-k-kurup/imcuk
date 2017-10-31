<?php
include_once(DIR_ROOT."admin/includes/header.php");
include_once(DIR_ROOT."admin/includes/pagination.php");
include_once(DIR_ROOT."class/manage_category.php");
include_once(DIR_ROOT."class/manage_pages.php");
include_once(DIR_ROOT."class/manage_page_connection.php");
include_once(DIR_ROOT."class/user_delete_content_info.php");
$objCat				=	new manage_category();
$objPage			=	new manage_pages();
$objPageCon			=	new manage_page_connection();
$obj_del_con		=   new user_delete_content_info();
$allCat				=	$objCat->getAll('(cat_id = 1 or cat_id = 2 or cat_id = 3 or cat_id = 5 or cat_id = 6) and cat_status=1','cat_category asc');
if(isset($_GET['dept'])){
	$pageId			=	$objCommon->esc($_GET['dept']);
	$pageDtils		=	$objImcPage->getRow('page_id = "'.$pageId.'"');
}
$phpSelf			=	SITE_ROOT.'admin/index.php?page=list_page_details&dept='.$pageId;
$search				=	$objCommon->esc($_REQUEST['search_field']);
$sid				=	$objCommon->esc($_GET['sid']);
$del_id				=	$_REQUEST['del_id'];

if(count($del_id)>0){
	if($adminType == 1){
	foreach($del_id as $all_del_id){
		$objPage->delete("mp_id=".$all_del_id);	
	}
	}else{
		
		foreach($del_id as $all_del_id){
			$page_info				= $objPage->getRow('mp_id = "'.$all_del_id.'"');
			$objPage->updateField(array("mp_staff_manage"=>1),"mp_id =".$all_del_id);
			$_POST['user_id']		= $_SESSION['adminid'];
			$_POST['heading']		= $page_info['mp_heading'].'<strong style="color:red">( Page content Delete )</strong>';
			$_POST['link']			= SITE_ROOT.'admin/index.php?page=manage_pages&eid='.$all_del_id;
			$_POST['status']		= 1;
			$obj_del_con->insert($_POST);
		
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
                       List All I M C <?php echo $pageDtils['page_name'] ?> Details
                        <small>International Medical Connection</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
                        <li><a href="#">I M C <?php echo $pageDtils['page_name'] ?> Page</a></li>
                        <li class="active">List Page Details</li>
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
                                <div class="box-header">
                                    <h3 class="box-title">List Page Details</h3>                                   
                                </div><!-- /.box-header -->
                                <div class="row">
                                <form action="#" method="get">
                    			<input type="hidden" name="page" value="<?php echo $page; ?>" />
                                <?php if(isset($_GET['dept'])){ ?>
                    				<input type="hidden" name="dept" value="<?php echo $_GET['dept']; ?>" />
                    			<?php } ?>
                                	<div class="col-lg-6">
                                        <div class="row">
                                        <div class="col-lg-4">
                                           <div class="form-group margin">
                                            <select class="form-control" name="serchcat">
                                                <option value="">--- CATEGORY ---</option>
                                                <?php foreach($allCat as $category){ ?>
                                                <option value="<?php echo $category['cat_id']; ?>" <?php echo ($_GET['serchcat'] == $category['cat_id']) ? 'selected' : '' ?>><?php echo $objCommon->esc($category['cat_category']); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div> 
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="input-group margin">
                                                <input type="text" placeholder="Search by Heading or Description" name="search_field" class="form-control">
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn btn-info btn-flat">Go!</button>
                                                </span>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </form>
                                    <div class="col-lg-3">
                                        <div class="input-group margin pull-right">
                                        	<button class="btn btn-success btn-sm" onclick="parent.location='<?php echo SITE_ROOT ?>admin/index.php?page=manage_pages'" >Add New</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="input-group margin pull-right">
                                        	<button class="btn btn-danger btn-sm " id="delete-all">Delete All</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body table-responsive">
                                <form method="get" id="manage-details">
                                 <input type="hidden" value="list_page_details" name="page" />
                                  <input type="hidden" value="<?php echo $pageId; ?>" name="dept" />
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="1%"><input type="checkbox" name="checkbox" class="checkall" id="checkbox"></th>
                                                <th width="24%">Heading</th>
                                                <th width="30%">Description</th>
                                                <th width="15%">Uploaded Date</th>
                                                <th width="15%">Uploaded IP</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                        </thead>
                                     <?php
/*-----------Pagination start----------------*/
$num_results_per_page 	 		=	($_GET['new_view'])?$_GET['new_view']:10;
$num_page_links_per_page 		= 	5;
$pg_param 						= 	"";
if($search || $_GET['serchcat']){
	if($adminType == 1){
	$sql_pagination 			= 	"select con.page_id, con.cat_id, con.mcp_status, pages.* from manage_pages as pages left join manage_page_connection as con on pages.mp_id = con.mp_id where con.page_id = '".$pageId."' and";
		if($_GET['serchcat']){
			$pageCatId			=	$objCommon->esc($_GET['serchcat']);
			$sql_pagination		.=	" con.cat_id = '".$pageCatId."' and";
		}
	 $sql_pagination			.=	" (pages.mp_heading like  '%".$search."%' or pages.mp_desc like  '%".$search."%')  order by pages.mp_id desc";
	}else{
		$sql_pagination 		= 	"select con.page_id, con.cat_id, con.mcp_status, pages.* from manage_pages as pages left join manage_page_connection as con on pages.mp_id = con.mp_id where con.page_id = '".$pageId."' and pages.mp_staff_manage = 0 and";
		if($_GET['serchcat']){
			$pageCatId			=	$objCommon->esc($_GET['serchcat']);
			$sql_pagination		.=	" con.cat_id = '".$pageCatId."' and";
		}
	 $sql_pagination			.=	" (pages.mp_heading like  '%".$search."%' or pages.mp_desc like  '%".$search."%') order by pages.mp_id desc";
	}
}else{
	if($adminType == 1){
	 $sql_pagination 			= 	"select distinct con.page_id, con.cat_id, con.mcp_status, pages.* from manage_pages as pages left join manage_page_connection as con on pages.mp_id = con.mp_id where con.page_id = '".$pageId."' order by pages.mp_id desc";
	}else{
		$sql_pagination 		= 	"select con.page_id, con.cat_id, con.mcp_status, pages.* from manage_pages as pages left join manage_page_connection as con on pages.mp_id = con.mp_id where con.page_id = '".$pageId."' and pages.mp_staff_manage = 0 order by pages.mp_id desc";
	}
}
$pagesection					=	'';
pagination($sql_pagination, $num_results_per_page, $num_page_links_per_page, $pg_param,$pagesection);
$page_list						=	$objPage->listQuery($paginationQuery);
$countpageList					=	mysql_num_rows(mysql_query($sql_pagination));
if(count($page_list) >0){
	$count=	1;
	foreach($page_list as $all){
/*-----------Pagination End----------------*/
?>
                                        <tbody>
                                            <tr>
                                                <td><input type="checkbox" name="del_id[]" value="<?php echo $all['mp_id']?>" class="mglr_checkbox"></td>
                                                <td><?php echo strip_tags(substr($all['mp_heading'],0,75)); ?></td>
                                                <td><?php echo substr(strip_tags($all['mp_desc']),0,75); ?> </td>
                                                <td><?php echo $all['mp_createdon'];?></td>
                                                <td><?php echo $all['mp_ip'];?></td>
                                                <td>
                                                     <?php if($adminType == 1 && $all['mp_staff_manage'] == 1){ ?> 
                          <a class="tiptip outer_admin_action" href="<?php echo $phpSelf?>&dsid=<?php echo $all['mp_id']?>" >
                          <img  src="<?php echo SITE_ROOT; ?>admin/img/question.png" title="Deleted from Sub-Admin">
                          </a>
                          <?php }else{ ?>    	
						<a class="tiptip outer_admin_action" href="<?php echo $phpSelf ?>&sid=<?php echo $all['mp_id']?>&scat=<?php echo $all['cat_id']?>" >
                        	<?php if($all['mcp_status'] == 1){ ?>
							<img  src="img/icon_green_dot.png" title="Clik to deactivate">
                            <?php }else{ ?>
                            <img src="img/red_dot.png" title="Clik to activate">
                            <?php } ?>
						</a>
                        <?php } ?>
                        <a class="tiptip outer_admin_action" href="<?php echo SITE_ROOT?>admin/index.php?page=manage_pages&eid=<?php echo $all['mp_id']?>" title="Edit">
                        <img src="<?php echo SITE_ROOT ?>admin/images/edit.png" title="Edit this topic" >
						</a>
						<a class="tiptip outer_admin_action" href="javascript:;" title="Delete" onclick="return del(<?php echo $all['mp_id']?>);">
							<span class="inner_admin_action admin_action_delete"><i class="fa fa-trash-o"></i></span>
						</a> 
                                                </td>
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
                                    </form>
                                    <?php include_once(DIR_ROOT."admin/includes/pagination_div.php"); ?>
                                    
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
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
        <!-- page script -->
        <script type="text/javascript" language="javascript">
		function changeViewCount(newCount){
			window.location.href='<?php echo $phpSelf ?>&new_view='+newCount;
		}
		// delete user
		function del(id){ 
				if(confirm("Are you sure to delete this  selected item !")){
				var urls	=	"<?php echo $phpSelf ?>&del_id[]="+id;
				window.location.href=urls;
			}
		}
		</script>
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
    </body>
</html>