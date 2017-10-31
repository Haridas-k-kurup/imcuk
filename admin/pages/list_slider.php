<?php
include_once(DIR_ROOT."admin/includes/header.php");
include_once(DIR_ROOT."admin/includes/pagination.php");
include_once(DIR_ROOT."class/manage_category.php");
include_once(DIR_ROOT."class/manage_pages.php");
$objCat				=	new manage_category();
$objPage			=	new manage_pages();
$search				=	$objCommon->esc($_REQUEST['search_field']);
$sid				=	$objCommon->esc($_GET['sid']);
$del_id				=	$_REQUEST['del_id'];
$actid				=	$_GET['actid'];
$phpSelf			=	SITE_ROOT.'admin/index.php?page=list_slider&type=2';
if(count($del_id)>0){
	foreach($del_id as $all_del_id){
		$objPage->delete("mp_id=".$all_del_id);	
	}
	$notfn->add_msg("Selected item has been removed successfully...!",3);
	header("location:".$phpSelf);
}
if($sid){ 
	$editData		=  $objPage->getRow("mp_id =".$sid, "mp_id");	
	if($editData['mp_status'] == 0){
		$objPage->updateField(array("mp_status"=>1),"mp_id	=".$sid);
	}else{
		$objPage->updateField(array("mp_status"=>0),"mp_id 	=".$sid);
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
                       List All I M C Main Slider
                        <small>International Medical Connection</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
                        <li><a href="#">List Main Slider</a></li>
                        <li class="active">List All I M C Main Slider</li>
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
                                    <h3 class="box-title">List Main Slider</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
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
if($search){
	$sql_pagination 			= 	"SELECT * FROM manage_pages WHERE  page_id = '2' AND (mp_heading LIKE  '%".$search."%' OR mp_desc LIKE  '%".$search."%')  ORDER BY mp_id DESC";
}else{
	 $sql_pagination 			= 	"SELECT * FROM manage_pages WHERE page_id = '2'  ORDER BY mp_id DESC";
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
                                                <td><?php echo strip_tags(substr($all['mp_desc'],0,75)); ?> </td>
                                                <td><?php echo $all['mp_createdon'];?></td>
                                                <td><?php echo $all['mp_IP'];?></td>
                                                <td>
                                                	
						<a class="tiptip outer_admin_action" href="<?php echo $phpSelf ?>&sid=<?php echo $all['mp_id']?>" >
                        	<?php if($all['mp_status'] == 1){ ?>
							<img  src="img/icon_green_dot.png" title="Clik to deactivate">
                            <?php }else{ ?>
                            <img src="img/red_dot.png" title="Clik to activate">
                            <?php } ?>
						</a>
                        <a class="tiptip outer_admin_action" href="<?php echo SITE_ROOT?>admin/index.php?page=forum_edit&eid=<?php echo $all['mp_id']?>" title="Edit">
                        <img src="<?php echo SITE_ROOT ?>admin/images/edit.png" title="Edit this topic" >
						</a>
						<a class="tiptip outer_admin_action" href="javascript:;" title="Delete" onclick="return del(<?php echo $all['mp_id']?>);">
							<span class="inner_admin_action admin_action_delete"><i class="fa fa-trash-o"></i></span>
						</a> 
                                                </td>
                                            </tr>
                                        </tbody>
                                     <?php } 
									
									 } ?>   
                                    </table>
                                    
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
		/*Check all*/	
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
		function changeViewCount(newCount){
			window.location.href='<?php echo $phpSelf ?>&new_view='+newCount;
		}
		// delete user
		function del(u){ 
				dataString	=	"act=pageDetId&pdid="+u;
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

    </body>
</html>