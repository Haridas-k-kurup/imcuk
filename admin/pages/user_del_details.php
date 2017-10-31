<?php
include_once(DIR_ROOT."admin/includes/header.php");
include_once(DIR_ROOT."admin/includes/pagination.php");
include_once(DIR_ROOT."includes/datetime-converter.php");
include_once(DIR_ROOT.'class/user_delete_content_info.php');
$obj_con_info		= new user_delete_content_info();

if($_REQUEST['del_id']){
	$del_id			=	$_REQUEST['del_id'];
 if(count($del_id)>0){
	
		foreach($del_id as $all_del_id){
		$obj_con_info->delete("entity_id=".$all_del_id);	
	
	}
	$notfn->add_msg("Selected item has been removed successfully...!",3);
	header("location:".SITE_ROOT."admin/index.php?page=user_del_details");
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
                       Staff Deleted contents
                        <small>International Medical Connection</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Deleted Content</li>
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
                                    <h3 class="box-title"><?php echo ucfirst($_GET['abtype']); ?>&nbsp;Item List</h3>
                                    <div class="box-tools pull-right">
                                         <?php //include_once(DIR_ROOT."admin/includes/pagination_div.php"); ?>
                                    </div>
                                </div><!-- /.box-header -->
                                
                                <div class="box-body">
                                <form method="get" id="manage-details" style="width:100%">
                                <input type="hidden" value="user_del_details" name="page" />
                                
                                    <ul class="todo-list">
    <?php
/*-----------Pagination start----------------*/
$num_results_per_page 	 		=	($_GET['new_view'])?$_GET['new_view']:10;
$num_page_links_per_page 		= 	5;
$pg_param 						= 	"";
if($search){
	$sql_pagination 			= 	"SELECT * FROM user_delete_content_info ORDER BY entity_id DESC";
}else{
	$sql_pagination 			= 	"SELECT * FROM user_delete_content_info ORDER BY entity_id DESC";
}
$pagesection					=	'';
pagination($sql_pagination, $num_results_per_page, $num_page_links_per_page, $pg_param,$pagesection);
$page_list						=	$obj_con_info->listQuery($paginationQuery);
$countpageList					=	mysql_num_rows(mysql_query($sql_pagination));
if(count($page_list) >0){
	$count=	1;
	foreach($page_list as $all){
/*-----------Pagination End----------------*/
?>
			<?php 
				$status			=	$all['status'];
			?>
   
                                        <li style=" <?php echo ($status) ? '' : 'background:#ccc;' ?>">
                                            <!-- drag handle -->
                                            <span class="handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>  
                                            <!-- checkbox -->
                                            <input type="checkbox" name="del_id[]" value="<?php echo $all['entity_id']?>" class="mglr_checkbox"/>                                            
                                            <!-- todo text -->
                                           <a href="<?=stripslashes($all['link'])?>" style="color:#444;"> <span class="text"> <?php echo substr(stripslashes($all['heading']),0,200); ?></span></a>
                                            <!-- Emphasis label -->
                                            
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
                                            <span class="text">Sorry no content found</span>
                                            
                                            
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
				var urls	=	"<?php SITE_ROOT.'admin/index.php?page=user_del_details'?>&del_id[]="+id;
				alert(urls);
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