<?php 
	include_once(DIR_ROOT.'admin/includes/header.php');
	include_once(DIR_ROOT."admin/includes/pagination.php");
	include_once(DIR_ROOT."class/registration_details.php");
	include_once(DIR_ROOT.'class/country_details.php');
	include_once(DIR_ROOT."class/user_delete_content_info.php");
	$objreg				=	new registration_details();
	$search				=	$objCommon->esc($_REQUEST['search_field']);
	$sid				=	$objCommon->esc($_GET['sid']);
	$objCountry			=	new country_details();
	$obj_del_con		=   new user_delete_content_info();
	$del_id				=	$_REQUEST['del_id'];
	$phpSelf			=	SITE_ROOT.'admin/index.php?page=login_details';
	if(isset($_GET['userSes']) && $_GET['userSes']){
		if($adminType == 1){
		$sesUser				=	$objCommon->esc($_GET['userSes']);
		unset($_SESSION['loginId']);
		$_SESSION['loginId']	=	$sesUser;
		$profile				=	SITE_ROOT."my_profile.php";
		header('location:'.$profile);
		}
	}
	if(count($del_id)>0){
		if($adminType == 1){
	foreach($del_id as $all_del_id){
		$objreg->delete("reg_id=".$all_del_id);	
		}
		}else{
			foreach($del_id as $all_del_id){
				$user_info				= $objreg->getRow('reg_id = "'.$all_del_id.'"');
				$objreg->updateField(array("reg_staff_manage"=>1),"reg_id =".$all_del_id);
				$_POST['user_id']		= $_SESSION['adminid'];
				$_POST['heading']		= $user_info['reg_private_id'].'<strong style="color:red">( User Delete )</strong>';
				$_POST['link']			= '';
				$_POST['status']		= 1;
				$obj_del_con->insert($_POST);
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
 <!-- daterange picker -->
        <link href="css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
         <link href="css/timepicker/bootstrap-timepicker.min.css" rel="stylesheet"/>
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
                                    <button class="btn btn-danger btn-sm pull-right margin" id="delete-user">Delete All</button>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <!-- Loading (remove the following to stop the loading)-->
                                <div  id="body-overlay"></div>
                                <div id="body-loader"></div>


                                <!-- end loading -->
                                <div class="box box-solid box-info">
                                <div class="box-header">
                                    <h3 class="box-title text-white">Search Area</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <div class="row margin">
                                	<div class="col-sm-12 col-lg-3">
                                    	<div class="form-group has-success">
                                            <label for="name-tittle" class="control-label"><i class="fa  fa-tag"></i> Name Tittle</label>
                                                <select class="form-control" id="name-tittle">
                                                  <option value="">------------ Name Tittle ------------</option>
                                                  <option value="Mr">Mr</option>
                                                  <option value="Mrs">Mrs</option>
                                                  <option value="Ms">Ms</option>
                                                  <option value="Miss">Miss</option>
                                                  <option value="Dr">Dr</option>
                                                  <option value="Prof">Prof</option>
                                                  <option value="">Others</option>
                                               </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                    	<div class="form-group has-success">
                                            <label for="registration-type" class="control-label" ><i class="fa fa-thumb-tack"></i> Registration Type</label>
                                            <select class="form-control" id="registration-type">
                                            <option value="">------------ Registration Type ------------</option>
                                            <option value="1">Medical Related Professionals</option>
                                            <option value="2">Medical Organizations</option>
                                            <option value="3">Patient(Non Medical Persons)</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                    	<div class="form-group has-success">
                                           <label for="profession-type" class="control-label"><i class="fa fa-user"></i> Profession Type</label>
                                            <select class="form-control" id="profession-type">
                                            <option value="">------------  Profession Type ------------</option>
                                            <option value="Medical">Medical</option>
                                            <option value="Dental">Dental</option>
                                            <option value="Nursing">Nursing</option>
                                            <option value="Pharmacy">Pharmacy</option>
                                            <option value="Physiotherapy">Physiotherapy</option>
                                            <option value="Management">Management</option>
                                            <option value="Nutrition">Nutrition</option>
                                            <option value="Homeopathy">Homeopathy</option>
                                            <option value="Ayurvedic">Ayurvedic</option>
                                            <option value="Chinese Medicine">Chinese Medicine</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                    	<div class="form-group has-success">
                                            <label for="student-type" class="control-label"><i class="fa fa-user"></i> Student Type</label>
                                            <select class="form-control" id="student-type">
                                            <option value="">------------ Student Type ------------</option>
                                            <option value="Medical">Medical</option>
                                            <option value="Dental">Dental</option>
                                            <option value="Nursing">Nursing</option>
                                            <option value="Pharmacy">Pharmacy</option>
                                            <option value="Physiotherapy">Physiotherapy</option>
                                            <option value="Management">Management</option>
                                            <option value="Nutrition">Nutrition</option>
                                            <option value="Homeopathy">Homeopathy</option>
                                            <option value="Ayurvedic">Ayurvedic</option>
                                            <option value="Chinese Medicine">Chinese Medicine</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row margin">
                                	<div class="col-sm-12 col-lg-3">
                                    	<div class="form-group has-success">
                                            <label for="country-list" class="control-label"><i class="fa fa-globe"></i> Country</label>
                                            <select class="form-control" id="country-list">
                                             <?php $listCountry	=	$objCountry->getAll('country_status = 1', 'country_name'); ?>
                                            <option value="">------------ Select Country ------------</option>
                                            <?php foreach($listCountry as $country){ ?>
                                            <option data-id="<?php echo $country['country_id']; ?>" value="<?php echo $country['country_name']; ?>"><?php echo $country['country_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                    	<div class="form-group has-success">
                                            <label for="state" class="control-label" ><i class="fa fa-globe"></i> State</label>
                                            <select class="form-control" id="state">
                                            <option value="">------------ Select Country ------------</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                    	<div class="form-group has-success">
                                            <label for="city" class="control-label"><i class="fa fa-globe"></i> City</label>
                                            <select class="form-control" id="city">
                                            <option value="">------------ Select Country ------------</option>
                                        </select>
                                        </div>
                                    </div>
                                    <!--<div class="col-sm-12 col-lg-3">
                                    	<div class="form-group has-success">
                                            <label for="inputSuccess" class="control-label"><i class="fa fa-globe"></i> Town</label>
                                            <select class="form-control">
                                            <option>option 1</option>
                                            <option>option 2</option>
                                            <option>option 3</option>
                                            <option>option 4</option>
                                            <option>option 5</option>
                                        </select>
                                        </div>
                                    </div>-->
                                </div>
                                <div class="row margin">
                                <div class="col-sm-3">
                                <div class="form-group has-success">
                                    <label for="age_range" class="control-label"><i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp;Age Range</label>
                                    <select id="age_range" class="form-control">
                                            <option value="">------------ SELECT RANGE ------------</option>
                                            <option value="10-20">10-20</option>
                                            <option value="20-30">20-30</option>
                                            <option value="30-40">30-40</option>
                                            <option value="40-50">40-50</option>
                                            <option value="50-60">50-60</option>
                                            <option value="60-70">60-70</option>
                                            <option value="70-80">70-80</option>
                                            <option value="80-90">80-90</option>
                                            <option value="90-100">90-100</option>
                                    </select>
                                </div>
                                </div>
                                <div class="col-sm-3">
                                	 <div class="form-group has-success">
                                    <label for="by-name" class="control-label"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</label>
                                    <input type="text" id="by-name" class="form-control" placeholder="Search by name, name tittle ...etc ">
                                </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group has-error pull-right">
                                        <label for="inputSuccess" class="control-label">List Users In Date Wise:</label>
                                        <div class="input-group">
                                            <button class="btn btn-default pull-right" id="daterange-btn">
                                                <i class="fa fa-calendar"></i> Date Range
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                    </div>
                                	<div class="col-sm-3">
                                    	<button class="btn btn-primary pull-right" id="search-memberes"><i class="fa fa-search"></i> Search</button>
                                    </div>      
                                </div>
                                </div>
                                </div>
                                <div class="box-body table-responsive" id="mem-list">
                                <form method="get" id="user-details">
                                <input type="hidden" value="login_details" name="page" />
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="1%"><input type="checkbox" name="checkbox" class="checkall" id="checkbox"></th>
                                                <th	width="3%">Sl No</th>
                                                <th width="12%">Name</th>
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
$num_results_per_page 	 					=	($_GET['new_view'])?$_GET['new_view']:25;
$num_page_links_per_page 					= 	5;
$pg_param 									= 	"";
if($search){
	if($adminType == 1){
	$sql_pagination 						= 	"select reg.*, user.ud_id, user.ud_name_title, user.ud_first_name, user.ud_country, user.ud_email, user.ud_pofile_pic from registration_details as reg left join user_details as user on reg.reg_id = user.reg_id where user.ud_name_title like '%".$search."%' or user.ud_first_name like '%".$search."%' or user.ud_country like '%".$search."%' or user.ud_state like '%".$search."%' or user.ud_city like '%".$search."%' or user.ud_town like '%".$search."%' or user.ud_street_name like '%".$search."%' or user.ud_post_code like '%".$search."%' or user.ud_dob like '%".$search."%' or user.ud_email like '%".$search."%' or user.ud_tel_home like '%".$search."%' or user.ud_tel_work like '%".$search."%' or user.ud_tel_mob like '%".$search."%' order by reg.reg_id desc";
	}else{
		$sql_pagination 					= 	"select reg.*, user.ud_id, user.ud_name_title, user.ud_first_name, user.ud_country, user.ud_email, user.ud_pofile_pic from registration_details as reg left join user_details as user on reg.reg_id = user.reg_id where reg.reg_staff_manage = 0 and (user.ud_name_title like '%".$search."%' or user.ud_first_name like '%".$search."%' or user.ud_country like '%".$search."%' or user.ud_state like '%".$search."%' or user.ud_city like '%".$search."%' or user.ud_town like '%".$search."%' or user.ud_street_name like '%".$search."%' or user.ud_post_code like '%".$search."%' or user.ud_dob like '%".$search."%' or user.ud_email like '%".$search."%' or user.ud_tel_home like '%".$search."%' or user.ud_tel_work like '%".$search."%' or user.ud_tel_mob like '%".$search."%') order by reg.reg_id desc";
	}
}else{
	if($adminType == 1){
	 $sql_pagination 						= 	"SELECT reg.*, user.ud_id, user.ud_name_title, user.ud_first_name, user.ud_country, user.ud_email, user.ud_pofile_pic FROM registration_details AS reg LEFT JOIN user_details AS user ON reg.reg_id = user.reg_id ORDER BY reg.reg_id DESC";
	}else{
		$sql_pagination 					= 	"SELECT reg.*, user.ud_id, user.ud_name_title, user.ud_first_name, user.ud_country, user.ud_email, user.ud_pofile_pic FROM registration_details AS reg LEFT JOIN user_details AS user ON reg.reg_id = user.reg_id WHERE reg.reg_staff_manage = 0 ORDER BY reg.reg_id DESC";
	}
}
$pagesection								=	'';
pagination($sql_pagination, $num_results_per_page, $num_page_links_per_page, $pg_param,$pagesection);
$page_list									=	$objreg->listQuery($paginationQuery);
$countpageList								=	mysql_num_rows(mysql_query($sql_pagination));
if(count($page_list) >0){
	?>
	<tr>
          <td colspan="9"><label class="btn bg-maroon btn-flat btn-xs"><?php echo count($page_list); ?> User Found</label></td>
     </tr> 
	<?php 
	$count=	1;
	$slNo									=	count($page_list);
	foreach($page_list as $all){
					
/*-----------Pagination End----------------*/
								if($all['reg_id'] == 1){
									$userName		=	"<label class=\"text-red\">IMC-ADMIN</label>";
								}
								else if($all['ud_name_title']){
									$userName		=	$all['ud_name_title']." : ".$all['ud_first_name'];
								}else{
									$userName		=	$all['ud_first_name'];
								} ?>   
                                              <tr>
                                                <td><input type="checkbox" class="mglr_checkbox" value="<?php echo $all['reg_id']?>" name="del_id[]"></td>
                                                <td><?php echo $slNo; ?></td>
                                                <td><?php echo $userName; ?><br /><br /><?php echo $all['reg_private_id']; ?></td>
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
                                                <?php if($all['reg_id'] != 1){ ?>
                          <?php if($adminType == 1 && $all['reg_staff_manage'] == 1){ ?> 
                          <a class="tiptip outer_admin_action" data-original-title="Click For all delete" data-toggle="tooltip" title="Appeal" href="<?php echo SITE_ROOT?>admin/index.php?page=login_details&dsid=<?php echo $all['reg_id']?>" >
                          <img  src="<?php echo SITE_ROOT; ?>admin/img/question.png" title="Deleted from Sub-Admin">
                          </a>
                          <?php }else{ ?>                     	
						<a class="tiptip outer_admin_action" data-original-title="Click For all delete" data-toggle="tooltip" title="Block/Unblock" href="<?php echo SITE_ROOT?>admin/index.php?page=login_details&sid=<?php echo $all['reg_id']?>" >
                        	<?php if($all['reg_status'] == 1){ ?>
							<img  src="<?php echo SITE_ROOT; ?>admin/img/icon_green_dot.png" title="Clik to deactivate : <?php echo $all['ud_name_title']." : ";  echo $all['ud_first_name']; ?>">
                            <?php }else{ ?>
                            <img src="<?php echo SITE_ROOT; ?>admin/img/red_dot.png" title="Clik to activate : <?php echo $all['ud_name_title']." : ";  echo $all['ud_first_name']; ?>">
                            <?php } ?>
						</a>
                        <?php } ?>
						<a class="tiptip outer_admin_action" data-original-title="Click For all delete" data-toggle="tooltip" href="javascript:;" title="Delete" onclick="return del('<?php echo $phpSelf ?>&del_id[]=<?php echo $all['reg_id']?>');">
							<span class="inner_admin_action admin_action_delete"><i class="fa fa-trash-o"></i></span>
						</a> 
                        <a class="tiptip outer_admin_action" href="javascript:;" onClick="return getProfile(<?php echo $all['reg_id']?>);" data-original-title="Click For View Profile" data-toggle="tooltip"  title="Click for View Profile" >
							<span class="inner_admin_action admin_action_delete"><i class="fa fa-user"></i></span>
						</a>
                        <?php } ?>
                                                </td>
                                            </tr>
                                     <?php $slNo--; } } ?>   
                                      </tbody>
                                    </table>
                                    </form>
                                    <div class="overlay"></div>
									<div class="loading-img"></div>
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
        <!-- date-range-picker -->
        <script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
          <script src="js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- page script -->
        <script type="text/javascript">
		
            $(function() { 
                $('#daterange-btn').daterangepicker(
                        {
                            ranges: {
                                'Today': [moment(), moment()],
                                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                                'Last 7 Days': [moment().subtract('days', 6), moment()],
                                'Last 30 Days': [moment().subtract('days', 29), moment()],
                                'This Month': [moment().startOf('month'), moment().endOf('month')],
                                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                            },
                            startDate: moment().subtract('days', 29),
                            endDate: moment()
                        },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
                );
                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                    checkboxClass: 'icheckbox_minimal',
                    radioClass: 'iradio_minimal'
                });
                //Red color scheme for iCheck
                $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                    checkboxClass: 'icheckbox_minimal-red',
                    radioClass: 'iradio_minimal-red'
                });
                //Flat red color scheme for iCheck
                $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                    checkboxClass: 'icheckbox_flat-red',
                    radioClass: 'iradio_flat-red'
                });
            });
			function getDaterange(){
				var startDate		=  $("input[name='daterangepicker_start']").val();
			 	var endDate			=  $("input[name='daterangepicker_end']").val();
				$('#body-overlay').addClass("overlay");
				$('#body-loader').addClass("loading-img");
				if(startDate && endDate){
					var dataString	=	"startDate="+startDate+"&endDate="+endDate;	
					$.ajax({
					type:"POST",
					url:"ajax/get_imc_fulloption_mem_search.php",
					data:dataString,
					cache:false,
					success:function(data){
							$('#mem-list').html(data);
							$('#body-overlay').removeClass("overlay");
							$('#body-loader').removeClass("loading-img");
						}	
				});
				}
			}
			function getProfile(data){
				var url		=	"<?php echo $phpSelf ?>&userSes="+data;
				window.location.href=url;
			}
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
<script type="text/javascript" language="javascript">
	$('#name-tittle, #profession-type, #student-type').on('change', function(){
			var arg				=	$(this).val();
			if(arg){
				getMembers(arg);
			}
		});
</script>
<script type="text/javascript" language="javascript">
		$('#search-memberes').click(function(){
			$('#body-overlay').addClass("overlay");
			$('#body-loader').addClass("loading-img");
			 var nameTittle			=	$('#name-tittle').val();
			 var regType			=	$('#registration-type').val();
			 var proType			=	$('#profession-type').val();
			 var stuType			=	$('#student-type').val();
			 var country			=	$('#country-list').val();
			 var state				=	$('#state').val();
			 var city				=	$('#city').val();
			 var ageRange			=	$('#age_range').val();
			
			 if(nameTittle || regType || proType || stuType || country || state || city || ageRange){
				 var dataString		=	"nameTittle="+nameTittle+"&regType="+regType+"&proType="+proType+"&stuType="+stuType+"&country="+country+"&state="+state+"&city="+city+"&age="+ageRange;	
					$.ajax({
					type:"POST",
					url:"ajax/get_imc_fulloption_mem_search.php",
					data:dataString,
					cache:false,
					success:function(data){
							$('#mem-list').html(data);
							$('#body-overlay').removeClass("overlay");
							$('#body-loader').removeClass("loading-img");
						}	
				});
			 }
		});
		$('#by-name').keyup(function(){ 
			$('#body-overlay').addClass("overlay");
			$('#body-loader').addClass("loading-img");
				var byName			=	$(this).val(); 
			 if(byName){
				 var dataString		=	"byName="+byName;	
					$.ajax({
					type:"POST",
					url:"ajax/get_full_serch_by_name.php",
					data:dataString,
					cache:false,
					success:function(data){ 
							$('#mem-list').html(data);
							$('#body-overlay').removeClass("overlay");
							$('#body-loader').removeClass("loading-img");
						}	
				});
			 }else{
				 $('#body-overlay').removeClass("overlay");
				 $('#body-loader').removeClass("loading-img");
			 }
		});
</script>

<script type="text/javascript" language="javascript">
		$('#country-list').on('change', function(e){
				var dataId			=	$(this).find(':selected').data('id');
				
				if(dataId){
					var dataString	=	"dataId="+dataId;	
					$.ajax({
					type:"POST",
					url:"ajax/get_state.php",
					data:dataString,
					cache:false,
					success:function(data){
							$('#state').html(data);
					}	
				});
				var cityString		=	"countyId="+dataId;
				$.ajax({
					type:"POST",
					url:"ajax/get_cities.php",
					data:cityString,
					cache:false,
					success:function(data){
							$('#city').html(data);
						}	
				});
				}
			});
		$('#state').on('change', function(e){
				//var info			=	$(this).val();
				var dataId			=	$(this).find(':selected').data('id');
				
				if(dataId){ 
					var dataString	=	"dataId="+dataId;	
					$.ajax({
					type:"POST",
					url:"ajax/get_cities.php",
					data:dataString,
					cache:false,
					success:function(data){
							$('#city').html(data);
						}	
				});
				}
			});	
	</script>
  
    </body>
</html>