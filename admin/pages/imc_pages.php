<?php
include_once(DIR_ROOT."admin/includes/header.php");
include_once(DIR_ROOT."admin/includes/pagination.php");
include_once(DIR_ROOT."class/imc_pages.php");
$objPages			=	new imc_pages();
$allParant			=	$objPages->getAll();

$phpSelf			=	SITE_ROOT.'admin/index.php?page=imc_pages';
if($_GET['eid']){
	$editId			=  $objCommon->esc($_GET['eid']);
	$getPage		=  $objPages->getRow('page_id ='.$editId,'page_id');
}
if($_GET['sid']){ 
	$sid			=  $objCommon->esc($_GET['sid']);
	$editData		=  $objPages->getRow("page_id =".$sid, "page_id");	
	if($editData['page_status'] == 0){
		$objPages->updateField(array("page_status"=>1),"page_id	=".$sid);
	}else{
		$objPages->updateField(array("page_status"=>0),"page_id =".$sid);
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
                        Manage I M C Pages
                        <small>International Medical Connection</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">I M C Controls</a></li>
                        <li class="active">Manage I M C Pages</li>
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
                                    <h3 class="box-title">Manage Pages</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                 <?php 
									echo $notfn->msg();
								?> 
                                <form action="<?php echo SITE_ROOT?>admin/action.php?act=mng_pages" method="post" role="form" enctype="multipart/form-data">
                                	<?php echo ($editId)?'<input type="hidden" value="'.$editId.'" name="editId" />':'';?>
                                    <div class="box-body">
                                    
                                    
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary" type="button">Page/Menu Name</button>
                                        </div><!-- /btn-group -->
                                        <input type="text" class="form-control" name="page_name" value="<?php echo $objCommon->html2text($getPage['page_name']);?>">
                                    </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary" type="button">Select Parent</button>
                                        </div><!-- /btn-group -->
                                        <select class="form-control" name="par_id">
                                        <option value=""></option>
                                        <?php foreach($allParant as $parents) {?>
                    	<option value="<?php echo $parents['page_id']; ?>" <?php echo ($parents['page_id']	==	$getPage['par_id'])?'selected=selected' : '' ?> ><?php echo $parents['page_name']; ?></option>
                        <?php } ?>
                                            </select>
                                    </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary" type="button">Position</button>
                                        </div><!-- /btn-group -->
                                        <input type="text" class="form-control" name="page_pos" value="<?php echo $objCommon->html2text($getPage['page_position']);?>">
                                    </div>
                                        </div>
                                        
                                        
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-info"><?php echo ($editId)?'Update Page':'Save Page';?></button>
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
                                    <h3 class="box-title">List Categories</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                
                                 <table class="table table-bordered table-hover" id="example2">
                                        <thead>
                                            <tr>
                                                <th width="1%"><input type="checkbox" id="checkbox" class="checkall" name="checkbox"></th>
                                                
                                                <th width="37%">Category</th>
                                                <th width="10%">ID</th>
                                                <th width="10%">Position</th>
                                                <th width="10%">Parent</th>
                                                <th width="32%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
					/*-----------Pagination start----------------*/
					$num_results_per_page 	 		=	($_GET['new_view'])?$_GET['new_view']:10;
					$num_page_links_per_page 		= 	5;
					$pg_param 						= 	"";
					if($search){
						$sql_pagination 			= 	"SELECT * FROM imc_pages  WHERE page_id != 1 AND (par_id LIKE '%".$search."%' OR page_name LIKE '%".$search."%') ORDER BY page_id DESC";
					}else{
						$sql_pagination 			= 	"SELECT * FROM imc_pages WHERE page_id != 1 ORDER BY page_id DESC";
					}
					$pagesection					=	'';
					pagination($sql_pagination, $num_results_per_page, $num_page_links_per_page, $pg_param,$pagesection);
					$page_list						=	$objPages->listQuery($paginationQuery);
					$countpageList					=	mysql_num_rows(mysql_query($sql_pagination));
					if(count($page_list) >0){
						$count=	1;
						foreach($page_list as $all){
					/*-----------Pagination End----------------*/
?>
                                            <tr>
                                                <td><input type="checkbox" class="mglr_checkbox" value="<?php echo $all['state_id']?>" name="del_id[]" ></td>
                                                <td><?php echo $all['page_name']?></td>
                                                <td><?php echo $all['page_id']; ?></td>
                                                <td><?php echo $all['page_position']; ?></td>
                                                <td><?php echo $all['par_id']; ?></td>
                                                <td>
                                                	
						<a href="<?php echo $phpSelf ?>&sid=<?php echo $all['page_id']?>" class="tiptip outer_admin_action">
                        <?php if($all['page_status'] == 0){ ?>
                        	                            <img title="Clik to activate" src="img/red_dot.png">
                                                      <?php   }else{ ?>
                                                      <img title="Clik to activate" src="img/icon_green_dot.png">
                                                  <?php  } ?>
                            						</a>
                        <a title="Edit" href="<?php echo $phpSelf?>&eid=<?php echo $all['page_id']?>" class="tiptip outer_admin_action">
                        <img title="Edit this topic" src="<?php echo SITE_ROOT; ?>/admin/images/edit.png">
						</a>
						<a onclick="return del(<?php echo $all['page_id']?>);" title="Delete" href="javascript:;" class="tiptip outer_admin_action">
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
</html>
<script language="javascript" type="text/javascript">
function changeViewCount(newCount){
	window.location.href='<?php echo SITE_ROOT?>admin/index.php?page=imc_pages&new_view='+newCount;
}
function del(u){ 
				dataString	=	"act=add_page_del&mdid="+u;
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