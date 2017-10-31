<?php 
	include_once(DIR_ROOT.'admin/includes/header.php');
	include_once(DIR_ROOT."admin/includes/pagination.php");
	include_once(DIR_ROOT."class/registration_details.php");
	$objreg				=	new registration_details();
	$search				=	$objCommon->esc($_REQUEST['search_field']);
	$sid				=	$objCommon->esc($_GET['sid']);
	$del_id				=	$_REQUEST['del_id'];
	$phpSelf			=	SITE_ROOT.'admin/index.php?page=login_details';
	if(count($del_id)>0){
		if($adminType == 1){
	foreach($del_id as $all_del_id){
		$objreg->delete("reg_id=".$all_del_id);	
		}
		}else{
			foreach($del_id as $all_del_id){
				$objreg->updateField(array("reg_staff_manage"=>1),"reg_id =".$all_del_id);
	}
	}
	$notfn->add_msg("User has been  removed successfully...!",3);
	header("location:".$phpSelf);
}
if($sid){ 
	$editData			=  $objreg->getRow("reg_id =".$sid, "reg_id");	
	if($editData['reg_status'] == 0){
		$objreg->updateField(array("reg_status"=>1),"reg_id =".$sid);
	}else{
		$objreg->updateField(array("reg_status"=>0),"reg_id =".$sid);
	}
	header("location:".$phpSelf);
}
/*-----------Recover content from staff start----------------------------*/
if(isset($_GET['dsid']) && $_GET['dsid'] > 0 && $adminType == 1){
	$userID				=	$objCommon->esc($_GET['dsid']);
	$objreg->updateField(array("reg_staff_manage"=>0),"reg_id =".$userID);
	$notfn->add_msg("User has been Recovered...!",3);
	header("location:".$phpSelf);
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
                        All Users
                        <small>list all users in I M C</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">I M C Users</a></li>
                        <li class="active">List All Users</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">List All Users</h3>                                    
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
                                <div class="row">
                                	<div class="col-sm-12 col-lg-4">
                                    	<select class="form-control">
                                            <option>option 1</option>
                                            <option>option 2</option>
                                            <option>option 3</option>
                                            <option>option 4</option>
                                            <option>option 5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="box-body table-responsive">
                                <form method="get" id="user-details">
                                <input type="hidden" value="login_details" name="page" />
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="1%"><input type="checkbox" name="checkbox" class="checkall" id="checkbox"></th>
                                                <th width="15%">Name</th>
                                                <th width="10%" class="text-center">Profile</th>
                                                <th width="10%">Reg-Type</th>
                                                <th width="14%">Registered Date</th>
                                                <th width="10%">Country</th>
                                                <th width="15%">Email</th>
                                                <th width="15%">Last Visit IP</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
/*-----------Pagination start----------------*/
$num_results_per_page 	 					=	($_GET['new_view'])?$_GET['new_view']:12;
$num_page_links_per_page 					= 	5;
$pg_param 									= 	"";
if($search){
	if($adminType == 1){
	$sql_pagination 						= 	"SELECT * FROM registration_details as reg left join user_details as user on reg.reg_id = user.reg_id where reg.reg_login_status = 0 and (user.ud_name_title like '%".$search."%' or user.ud_first_name like '%".$search."%' or user.ud_country like '%".$search."%' or user.ud_state like '%".$search."%' or user.ud_city like '%".$search."%' or user.ud_town like '%".$search."%' or user.ud_street_name like '%".$search."%' or user.ud_post_code like '%".$search."%' or user.ud_dob like '%".$search."%' or user.ud_email like '%".$search."%' or user.ud_tel_home like '%".$search."%' or user.ud_tel_work like '%".$search."%' or user.ud_tel_mob like '%".$search."%') order by user.ud_first_name asc";
	}else{
		$sql_pagination 					= 	"SELECT * FROM registration_details as reg left join user_details as user on reg.reg_id = user.reg_id where reg.reg_staff_manage = 0 and reg.reg_login_status = 0 and (user.ud_name_title like '%".$search."%' or user.ud_first_name like '%".$search."%' or user.ud_country like '%".$search."%' or user.ud_state like '%".$search."%' or user.ud_city like '%".$search."%' or user.ud_town like '%".$search."%' or user.ud_street_name like '%".$search."%' or user.ud_post_code like '%".$search."%' or user.ud_dob like '%".$search."%' or user.ud_email like '%".$search."%' or user.ud_tel_home like '%".$search."%' or user.ud_tel_work like '%".$search."%' or user.ud_tel_mob like '%".$search."%') order by user.ud_first_name asc";
	}
}else{
	if($adminType == 1){
	 $sql_pagination 						= 	"SELECT * FROM registration_details as reg left join user_details as user on reg.reg_id = user.reg_id where reg.reg_login_status = 0 order by reg_createdon asc";
	}else{
		$sql_pagination 					= 	"SELECT * FROM registration_details as reg left join user_details as user on reg.reg_id = user.reg_id where reg.reg_login_status = 0 and reg.reg_staff_manage = 0 order by reg_createdon asc";
	}
}
$pagesection								=	'';
pagination($sql_pagination, $num_results_per_page, $num_page_links_per_page, $pg_param,$pagesection);
$page_list									=	$objreg->listQuery($paginationQuery);
$countpageList								=	mysql_num_rows(mysql_query($sql_pagination));
if(count($page_list) >0){
	$count=	1;
	foreach($page_list as $all){
/*-----------Pagination End----------------*/
?>                                     
                                            <tr>
                                                <td><input type="checkbox" class="mglr_checkbox" value="<?php echo $all['reg_id']?>" name="del_id[]"></td>
                                                <td><?php echo $all['ud_name_title']." : ";  echo $all['ud_first_name']; ?></td>
                                                <td class="text-center">
												<?php if($all['ud_pofile_pic']){
														$profPic		=  "/profiles/".stripslashes($all['ud_pofile_pic']);
														$chkProfPic		=  "../profiles/".stripslashes($all['ud_pofile_pic']);
														if(file_exists($chkProfPic)){
														?>
                                                        <img src="<?php echo SITE_ROOT.$profPic; ?>" width="75%" height="75" >
                                                        <?php } else{ ?>
                                                        <img src="<?php echo SITE_ROOT; ?>images/profile.jpg" width="75%" height="75" >
                                                        <?php }  }else{ ?>
                                                        <img src="<?php echo SITE_ROOT; ?>images/profile.jpg" width="75%" height="75" >
													<?php } ?>	 
                                                </td>
                                                <td><?php 
													$regType	 =	$all['reg_type'];
													if($regType	 ==	1){
														echo "Professional";
													}
													else if($regType ==	2){
														echo "Organization";
													}
													else if($regType ==	3){
														echo "Patient";

													} ?>
                   								</td>
                                                <td><?php echo $all['reg_createdon'];?></td>
                                                <td><?php echo $all['ud_country'];?></td>
                                                <td><?php echo $all['ud_email'];?></td>
                                                <td><?php echo $all['last_visit_ip'];?></td>
                                                <td>
                          <?php if($adminType == 1 && $all['reg_staff_manage'] == 1){ ?> 
                          <a class="tiptip outer_admin_action" href="<?php echo SITE_ROOT?>admin/index.php?page=login_details&dsid=<?php echo $all['reg_id']?>" >
                          <img  src="<?php echo SITE_ROOT; ?>admin/img/question.png" title="Deleted from Sub-Admin">
                          </a>
                          <?php }else{ ?>                     	
						<a class="tiptip outer_admin_action" href="<?php echo SITE_ROOT?>admin/index.php?page=login_details&sid=<?php echo $all['reg_id']?>" >
                        	<?php if($all['reg_status'] == 1){ ?>
							<img  src="<?php echo SITE_ROOT; ?>admin/img/icon_green_dot.png" title="Clik to deactivate : <?php echo $all['ud_name_title']." : ";  echo $all['ud_first_name']; ?>">
                            <?php }else{ ?>
                            <img src="<?php echo SITE_ROOT; ?>admin/img/red_dot.png" title="Clik to activate : <?php echo $all['ud_name_title']." : ";  echo $all['ud_first_name']; ?>">
                            <?php } ?>
						</a>
                        <?php } ?>
						<a class="tiptip outer_admin_action" href="javascript:;" title="Delete" onclick="return del('<?php echo $phpSelf ?>&del_id[]=<?php echo $all['reg_id']?>');">
							<span class="inner_admin_action admin_action_delete"><i class="fa fa-trash-o"></i></span>
						</a> 
                                                </td>
                                            </tr>
                                     <?php } }else{ ?>  
                                     <tr>
                                     	<td colspan="8"><p class="alert-danger">Sorry! No Users are in online.</p></td>
                                     </tr>
                                     <?php } ?> 
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
	if(confirm('You are sure to delete this user.. Continue?')){ 
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
				if(confirm('You are sure to delete this user.. Continue?')){
				$('#user-details').submit();
				}
				});
		</script>

    </body>
</html>