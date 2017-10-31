<?php
include_once(DIR_ROOT."admin/includes/header.php");
include_once(DIR_ROOT."class/country_details.php");
include_once(DIR_ROOT."class/state_details.php");
include_once(DIR_ROOT."admin/includes/pagination.php");
include_once(DIR_ROOT."class/city_details.php");
$objCountry			=	new country_details();
$objState			=	new state_details();
$objCity			=	new city_details();
$allCountry			= 	$objCountry->getAll('country_status = 1', 'country_name asc');
$allState			=	$objState->getAll('state_status = 1', 'state_name asc');

$phpSelf			=	SITE_ROOT.'admin/index.php?page=city_controls';
if($_GET['eid']){
	$editId			=  $objCommon->esc($_GET['eid']);
	$getPage		=  $objCity->getRow('city_id ='.$editId,'city_id');
	
}
if($_GET['sid']){ 
	$sid			=  $objCommon->esc($_GET['sid']);
	$editData		=  $objCity->getRow("city_id =".$sid, "city_id");	
	if($editData['city_status'] == 0){
		$objCity->updateField(array("city_status"=>1),"city_id	=".$sid);
	}else{
		$objCity->updateField(array("city_status"=>0),"city_id =".$sid);
	}
	header("location:".$phpSelf);
}
?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <?php include_once('includes/sidemenubar.php'); ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Manage I M C Cities 
                        <small>International Medical Connection</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Manage States</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Add City </h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                 <?php 
									echo $notfn->msg();
								?> 
                                <form action="<?php echo SITE_ROOT?>admin/action.php?act=addcities" method="post" role="form" enctype="multipart/form-data">
                                	<?php echo ($editId)?'<input type="hidden" value="'.$editId.'" name="editId" />':'';?>
                                    <div class="box-body">
                                    <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary" type="button">Select Country</button>
                                        </div><!-- /btn-group -->
                                        <select class="form-control" name="country_id" id="country_id">
                                        	<option value="">------------------------------ Select Country ------------------------------</option>
                                                 <?php 
												foreach($allCountry	as $countryName){
					 							?>
                    							<option value="<?php echo $countryName['country_id']; ?>"  <?php echo ($getPage['country_id'] == $countryName['country_id'])? 'selected="selected"' : '' ?> required><?php echo $countryName['country_name']; ?></option>
                      							  <?php } ?>
                                            </select>
                                    </div>
                                        </div>
                                    <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary" type="button">State Name</button>
                                        </div><!-- /btn-group -->
                                        <select class="form-control" name="state" id="state">
                                        <option>------------------------------------ Select State ------------------------------------</option>
                                                 <?php
												foreach($allState	as $stateName){
					 							?>
                    							<option value="<?php echo $stateName['state_id']; ?>"  <?php echo ($getPage['state_id'] == $stateName['state_id'])? 'selected="selected"' : '' ?> required><?php echo $stateName['state_name']; ?></option>
                      							  <?php } ?>
                                            </select>
                                    </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary" type="button">City Name</button>
                                        </div><!-- /btn-group -->
                                        <input type="text" class="form-control" name="city_name" value="<?php echo $objCommon->html2text($getPage['city_name']);?>">
                                    </div>
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-info"><?php echo ($editId)?'Update City':'Save City';?></button>
                                    </div>
                                </form>
                            </div><!-- /.box -->

                            <!-- Form Element sizes -->
                           

                            <!-- Input addon -->
                            <!-- /.box -->

                        </div><!--/.col (left) -->
                        <!-- right column -->
                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">List States</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                
                                 <table class="table table-bordered table-hover" id="example2">
                                        <thead>
                                            <tr>
                                                <th width="1%"><input type="checkbox" id="checkbox" class="checkall" name="checkbox"></th>
                                                <th width="5%">ID</th>
                                                <th width="20%">City</th>
                                                <th width="20%">State</th>
                                                <th width="22%">Country</th>
                                                <th width="32%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
					/*-----------Pagination start----------------*/
					$num_results_per_page 	 		=	($_GET['new_view'])?$_GET['new_view']:12;
					$num_page_links_per_page 		= 	5;
					$pg_param 						= 	"";
					if($search){
						$sql_pagination 			= 	"select * from city_details as city left join country_details as country on city.country_id = country.country_id left join state_details as state on city.state_id = state.state_id where city.city_name = '".$search."' order by city.city_id desc";
					}else{
						$sql_pagination 			= 	"select * from city_details as city left join country_details as country on city.country_id = country.country_id left join state_details as state on city.state_id = state.state_id order by  	city.city_id desc";
					}
					$pagesection					=	'';
					pagination($sql_pagination, $num_results_per_page, $num_page_links_per_page, $pg_param,$pagesection);
					$page_list						=	$objCity->listQuery($paginationQuery);
					$countpageList					=	mysql_num_rows(mysql_query($sql_pagination));
					if(count($page_list) >0){
						$count=	1;
						foreach($page_list as $all){
					/*-----------Pagination End----------------*/
?>
                                            <tr>
                                                <td><input type="checkbox" class="mglr_checkbox" value="<?php echo $all['state_id']?>" name="del_id[]" ></td>
                                                <td><?php echo $all['city_id']; ?></td>
                                                <td><?php echo $all['city_name']?></td>
                                               	<td><?php echo $all['state_name']?></td>
                                                 <td><?php echo $all['country_name']; ?></td>
                                                <td>
                                                	
						<a href="<?php echo $phpSelf ?>&sid=<?php echo $all['city_id']?>" class="tiptip outer_admin_action">
                        <?php if($all['city_status'] == 0){ ?>
                        	                            <img title="Clik to activate" src="img/red_dot.png">
                                                      <?php   }else{ ?>
                                                      <img title="Clik to activate" src="img/icon_green_dot.png">
                                                  <?php      } ?>
                            						</a>
                        <a title="Edit" href="<?php echo $phpSelf?>&eid=<?php echo $all['city_id']?>" class="tiptip outer_admin_action">
                        <img title="Edit this topic" src="<?php echo SITE_ROOT; ?>admin/images/edit.png">
						</a>
						<a onclick="return del(<?php echo $all['city_id']?>);" title="Delete" href="javascript:;" class="tiptip outer_admin_action">
							<span class="inner_admin_action admin_action_delete"><i class="fa fa-trash-o"></i></span>
						</a> 
                                                </td>
                                            </tr>
                                            
                                            
                                        <?php 
	}
}
										?>
                                        </tbody>
                                        
                                    </table>
                                <?php include_once(DIR_ROOT."admin/includes/pagination_div.php"); ?>
                            </div><!-- /.box -->

                            <!-- Form Element sizes -->
                           

                            <!-- Input addon -->
                            <!-- /.box -->

                        </div>
                        <!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
    </body>
    <script language="javascript" type="text/javascript">
function changeViewCount(newCount){
	window.location.href='<?php echo SITE_ROOT?>admin/index.php?page=city_countrols&new_view='+newCount;
}
function del(u){ 
				dataString	=	"act=det_city&citydid="+u; 
				if(confirm("Are you sure to delete this  selected item !")){ 
			$.ajax({
					type:"POST",
					data:dataString,
					url:"action.php",
					cache:true,
					success:function(el){
							location.reload();
						}
					});
			}
		}
</script>
<script type="text/javascript" language="javascript">
	$('#country_id').on('change',function(){
			var country		=	$(this).val();
			if(country){
				dataString	=	"country="+country;
				$.ajax({
					type:"POST",
					data:dataString,
					url:"ajax/get_states.php",
					cache:true,
					success:function(el){
							$('#state').html(el);
						}
					});
			}
		});
</script>
</html>
