<?php 
	include_once(DIR_ROOT.'admin/includes/header.php');
	if($adminType != 1){
		header('location:'.SITE_ROOT."admin/index.php?page=dashboard");
	}
	include_once(DIR_ROOT."admin/includes/pagination.php");
	include_once(DIR_ROOT."class/admin.php");
	$objAdmin			=	new admin();
	$search				=	$objCommon->esc($_REQUEST['search_field']);
	$sid				=	$objCommon->esc($_GET['sid']);
	$del_id				=	$_REQUEST['del_id'];
	$phpSelf			=	SITE_ROOT.'admin/index.php?page=list_staff';
	
	if(count($del_id)>0){
	foreach($del_id as $all_del_id){
		$objAdmin->delete("admin_id=".$all_del_id);	
	}
	$notfn->add_msg("Staff has been  removed successfully...!",3);
	header("location:".$phpSelf);
}
if($sid){ 
	$editData			=  $objAdmin->getRow("admin_id =".$sid, "admin_id");	
	if($editData['admin_status'] == 0){
		$objAdmin->updateField(array("admin_status"=>1),"admin_id 	=".$sid);
	}else{
		$objAdmin->updateField(array("admin_status"=>0),"admin_id 	=".$sid);
	}
	header("location:".$phpSelf);
}
/*-----------Delete content start----------------------------*/
if($_GET['did']){
	$objAdmin->delete("admin_id=".$_GET['did']);
	$notfn->add_msg("Selected User has been deleted...!",3);
	header("location:".$phpSelf);
}
/*-----------Delete content end----------------------------*/			
?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <?php include_once('includes/sidemenubar.php'); ?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        All Staffs
                        <small>list all Staffs in I M C</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">List All Staffs</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">List All Staffs</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="row">
                                	<div class="col-lg-6">
                                    <!--<div class="input-group margin">
                                        <input type="text" class="form-control">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-flat">Go!</button>
                                        </span>
                                    </div>-->
                                    </div>
                                    <div class="col-lg-6">
                                    <button class="btn btn-danger btn-sm pull-right" id="delete-user">Delete All</button>
                                    </div>
                                </div>
                                <div class="box-body table-responsive">
                                <form method="get" id="user-details">
                                <input type="hidden" value="list_staff" name="page" />
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="1%"><input type="checkbox" name="checkbox" class="checkall" id="checkbox"></th>
                                                <th width="10%">User Name</th>
                                                <th width="10%">Profile</th>
                                                <th width="15%">Password</th>
                                                <th width="14%">Create Date</th>
                                                <th width="15%">Last Visit</th>
                                                <th width="12%">Last Visited IP</th>
                                                <th width="10%">User Status</th>
                                                <th width="13%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
/*-----------Pagination start----------------*/
$num_results_per_page 	 					=	($_GET['new_view'])?$_GET['new_view']:12;
$num_page_links_per_page 					= 	5;
$pg_param 									= 	"";
if($search){
	$sql_pagination 						= 	"SELECT ad.*, secur.secur_dtil FROM admin AS ad LEFT JOIN admin_security AS secur ON ad.admin_id = secur.admin_id WHERE ad.admin_type = 2 AND admin_username LIKE '%".$search."%' ORDER BY ad.admin_username ASC";
}else{
	 $sql_pagination 						= 	"SELECT ad.*, secur.secur_dtil FROM admin AS ad LEFT JOIN admin_security AS secur ON ad.admin_id = secur.admin_id WHERE ad.admin_type = 2 ORDER BY ad.admin_username ASC";
}
$pagesection								=	'';
pagination($sql_pagination, $num_results_per_page, $num_page_links_per_page, $pg_param,$pagesection);
$page_list									=	$objAdmin->listQuery($paginationQuery);
$countpageList								=	mysql_num_rows(mysql_query($sql_pagination));
if(count($page_list) >0){
	$count=	1;
	foreach($page_list as $all){
/*-----------Pagination End----------------*/
?>                                     
                                            <tr>
                                                <td><input type="checkbox" class="mglr_checkbox" value="<?php echo $all['admin_id']?>" name="del_id[]"></td>
                                                <td><?php echo $all['admin_username']; ?></td>
                                                <td><?php if($all['admin_image'] != ""){
													$filePath		=	DIR_ROOT."admin/profile/".$all['admin_image'];
														if(file_exists($filePath)){
													 ?>
                                    			<img src="<?php echo SITE_ROOT ?>admin/profile/<?php echo $all['admin_image']; ?>" class="img-circle img-responsive" alt="User Image"   height="55"
    width="35%" />
                                    <?php } }else{ ?> 
										<img src="<?php echo SITE_ROOT ?>admin/img/avatar5.png" class="img-circle img-responsive" alt="User Image" height="55" width="35%" />
									<?php } ?>
                                    </td>
                                                <td><?php echo $all['secur_dtil'];?></td>
                                                <td><?php echo $all['admin_createdon'];?></td>
                                                <td><?php echo $all['admin_last_visit'];?></td>
                                                <td><?php echo $all['admin_last_visit_ip'];?></td>
                                                <td style="text-align:center"><?php
													if($all['admin_login_status']){ ?>
                                                    <img  src="<?php echo SITE_ROOT; ?>admin/img/online-icon.png" title=" <?php echo $all['admin_username']."  is available "; ?>">
												<?php	}else{ ?>
													<img  src="<?php echo SITE_ROOT; ?>admin/img/offline-icon.png" title=" <?php echo $all['admin_username']." Off Line "; ?>">
												<?php	}
												
												 ?></td>
                                                <td> 	
						<a class="tiptip outer_admin_action" href="<?php echo $phpSelf;?>&sid=<?php echo $all['admin_id']?>" >
                        	<?php if($all['admin_status'] == 1){ ?>
							<img  src="<?php echo SITE_ROOT; ?>admin/img/icon_green_dot.png" title="Clik to deactivate : <?php echo $all['admin_username']; ?>">
                            <?php }else{ ?>
                            <img src="<?php echo SITE_ROOT; ?>admin/img/red_dot.png" title="Clik to activate : <?php echo $all['admin_username']; ?>">
                            <?php } ?>
						</a>
						<a class="tiptip outer_admin_action" href="javascript:;" title="Delete" onclick="return del('<?php echo $phpSelf ?>&del_id[]=<?php echo $all['admin_id']?>');">
							<span class="inner_admin_action admin_action_delete"><i class="fa fa-trash-o"></i></span>
						</a> 
                        <a class="tiptip outer_admin_action" href="<?php echo SITE_ROOT; ?>admin/index.php?page=add_staff&staff=<?php echo $all['admin_id'];  ?>" title="Change User">
							<span class="inner_admin_action admin_action_delete"><i class="fa fa-pencil-square"></i></span>
						</a>
                                                </td>
                                            </tr>
                                     <?php } } ?>   
                                      </tbody>
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
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
				
            });
        </script>
   <script type="text/javascript" language="javascript">
		//delete user 
	function del(u){
	if(confirm('You are sure to delete this Staff.. Continue?')){ 
		window.location.href=u;
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
			$('#delete-user').click(function(){
				if(confirm('You are sure to delete this Staffs.. Continue?')){
				$('#user-details').submit();
				}
				});
		</script>

    </body>
</html>