<?php
include_once(DIR_ROOT."admin/includes/header.php");
include_once(DIR_ROOT."admin/includes/pagination.php");
include_once(DIR_ROOT."includes/datetime-converter.php");
if(!$_GET['abtype']){
	//header('location:index.php?page=dashboard');
	
}else{
$phpSelf			=	SITE_ROOT.'admin/index.php?page=abuse_details&abtype='.$_GET['abtype'];
}
if($_REQUEST['del_id']){
	$del_id			=	$_REQUEST['del_id'];
 if(count($del_id)>0){
	if($_GET['abtype'] == "forum"){
	foreach($del_id as $all_del_id){
		$objAbuseForum->delete("abuse_id=".$all_del_id);	
	}
	}else if($_GET['abtype'] == "slider"){
		foreach($del_id as $all_del_id){
		$objAbuseSlider->delete("abuse_id=".$all_del_id);	
	}
	}
	$notfn->add_msg("Selected item has been removed successfully...!",3);
	header("location:".$phpSelf);
	exit;
}
}
?>
<script type="text/javascript" src="<?php echo SITE_ROOT; ?>ckeditor/ckeditor.js"></script>
<!--<script type="text/javascript" src="<?php echo SITE_ROOT; ?>ckeditor/ckfinder.js"></script>-->
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <?php include_once('includes/sidemenubar.php'); ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                       Abuse
                        <small>International Medical Connection</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Abuse</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <div class="row">
                	<div class="col-sm-12">
                    	<div class="input-group margin pull-right">
                                        	<button class="btn btn-danger btn-sm " disabled="disabled" id="delete-all"><i class="fa fa-trash-o"></i>&nbsp;DELETE</button>
                                        </div>
                    </div>
                </div>
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <!-- /.box -->
								<?php 
									echo $notfn->msg();
								?> 
                            <!-- Form Element sizes -->
                            
                           <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title"><?php echo ucfirst($_GET['abtype']); ?>&nbsp;Abuse List</h3>
                                    <div class="box-tools pull-right">
                                         <?php //include_once(DIR_ROOT."admin/includes/pagination_div.php"); ?>
                                    </div>
                                </div><!-- /.box-header -->
                                
                                <div class="box-body">
                                <form method="get" id="manage-details" style="width:100%">
                                <input type="hidden" value="abuse_details" name="page" />
                                 <input type="hidden" value="<?php echo $_GET['abtype'] ?>" name="abtype" />
                                    <ul class="todo-list">
    <?php
/*-----------Pagination start----------------*/
$num_results_per_page 	 		=	($_GET['new_view'])?$_GET['new_view']:10;
$num_page_links_per_page 		= 	5;
$pg_param 						= 	"";
if($search){
	if($_GET['abtype'] == "forum"){
	$sql_pagination 			= 	"select ab.*, user.ud_first_name, user.ud_pofile_pic from abuse_forum as ab left join user_details as user on ab.reg_id = user.reg_id where ab.abuse like '%".$search."%' or ab.abuse_date like '%".$search."%' or user.ud_first_name like '%".$search."%'";
	}else if($_GET['abtype'] == "slider"){
		$sql_pagination 		= 	"select ab.*, user.ud_first_name, user.ud_pofile_pic from abuse_slider as ab left join user_details as user on ab.reg_id = user.reg_id where ab.abuse like '%".$search."%' or ab.abuse_date like '%".$search."%' or user.ud_first_name like '%".$search."%'";
	}
}else{
	if($_GET['abtype'] == "forum"){
	 $sql_pagination 			= 	"select abuse.*, user.ud_first_name, user.ud_pofile_pic from abuse_forum as abuse left join user_details as user on abuse.reg_id = user.reg_id order by abuse.abuse_id desc";
	}else if($_GET['abtype'] == "slider"){
		$sql_pagination 		= 	"select abuse.*, user.ud_first_name, user.ud_pofile_pic from abuse_slider as abuse left join user_details as user on abuse.reg_id = user.reg_id order by abuse.abuse_id desc";
	}
}
$pagesection					=	'';
pagination($sql_pagination, $num_results_per_page, $num_page_links_per_page, $pg_param,$pagesection);
$page_list						=	$objAbuseForum->listQuery($paginationQuery);
$countpageList					=	mysql_num_rows(mysql_query($sql_pagination));
if(count($page_list) >0){
	$count=	1;
	foreach($page_list as $all){
/*-----------Pagination End----------------*/
?>
			<?php 
				$time			=	strtotime($all['abuse_date']);
				$readStatus		=	$all['abuse_read_status'];
			?>
   
                                        <li style=" <?php echo ($readStatus) ? '' : 'background:#ccc;' ?>">
                                            <!-- drag handle -->
                                            <span class="handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>  
                                            <!-- checkbox -->
                                            <input type="checkbox" name="del_id[]" value="<?php echo $all['abuse_id']?>" class="mglr_checkbox"/>                                            
                                            <!-- todo text -->
                                           <a href="<?php echo SITE_ROOT; ?>admin/index.php?page=abuse-info&abtype=<?php echo $_GET['abtype']; ?>&id=<?php  echo $all['abuse_id']; ?>" style="color:#444;"> <span class="text"><?php echo '<span class="text-warning">'.ucfirst($all['ud_first_name']).'</span>'; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo substr(stripslashes($all['abuse']),0,100); ?></span>
                                            <!-- Emphasis label -->
                                            <small class="label <?php echo ($readStatus) ? 'label-success' : 'label-danger' ?>"><i class="fa fa-clock-o"></i> <?php echo convertTiming($time); ?></small>
                                            </a>
                                            <!-- General tools such as edit or delete-->
                                            <div class="tools">
                                                <a href="javascript:;" onclick="return del(<?php echo $all['abuse_id']?>);" style="color:#C30"> <i class="fa fa-trash-o"></i></a>
                                            </div>
                                        </li>
                                       <?php } 
									
									 }else{ ?>  
                                     <li>
                                            <!-- drag handle -->
                                            <span class="handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>  
                                            <!-- checkbox -->                                        
                                            <!-- todo text -->
                                            <span class="text">Sorry no abuse found</span>
                                            
                                            
                                        </li>
                                      <?php } ?> 
                                    </ul>
                                    </form>
                                    <?php include_once(DIR_ROOT."admin/includes/pagination_div.php"); ?>
                                </div><!-- /.box-body -->
                                
                            </div>

                            <!-- Input addon -->
                            <!-- /.box -->
							
                        </div><!--/.col (left) -->
                        <!-- right column -->
                        <!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        
        <script type="text/javascript" language="javascript">
        	function del(id){ 
				if(confirm("Are you sure to delete this  selected item !")){
				var urls	=	"<?php echo $phpSelf ?>&del_id[]="+id;
				window.location.href=urls;
			}
		}
        </script>
        <script type="text/javascript" language="javascript">
        	$('.mglr_checkbox').click(function(){
					var checked_status = this.checked;
					$(".mglr_checkbox").each(function(){
						if(this.checked == true){
							$('#delete-all').prop('disabled', false);
							return false
						}else{
							$('#delete-all').prop('disabled', true);
						}
						
						
					});
				});
        </script>
        <script type="text/javascript" language="javascript">
		$('#delete-all').click(function(){
				if(confirm('You are sure to delete this Item... Continue?')){
				$('#manage-details').submit();
				}
				});
		</script>
        <script type="text/javascript" language="javascript">
		function changeViewCount(newCount){
			window.location.href='<?php echo $phpSelf ?>&new_view='+newCount;
		}
		</script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
    </body>
</html>