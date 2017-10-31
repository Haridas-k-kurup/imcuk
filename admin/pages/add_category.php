<?php
include_once(DIR_ROOT."admin/includes/header.php");
include_once(DIR_ROOT."admin/includes/pagination.php");
include_once(DIR_ROOT."class/manage_category.php");
$objCat				= new manage_category();
$allParant			= $objCat->getAll();

$phpSelf			= SITE_ROOT.'admin/index.php?page=add_category';
if($_GET['eid']){
	$editId			= $objCommon->esc($_GET['eid']);
	$getPage		= $objCat->getRow('cat_id ='.$editId,'cat_id');
}
if($_GET['sid']){ 
	$sid			= $objCommon->esc($_GET['sid']);
	$editData		= $objCat->getRow("cat_id =".$sid, "cat_id");	
	if($editData['cat_status'] == 0){
		$objCat->updateField(array("cat_status"=>1),"cat_id	=".$sid);
	}else{
		$objCat->updateField(array("cat_status"=>0),"cat_id =".$sid);
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
                        Manage I M C Categories
                        <small>International Medical Connection</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">I M C Controls</a></li>
                        <li class="active">Manage I M C Categories</li>
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
                                    <h3 class="box-title">Manage Categories </h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                 <?php 
									echo $notfn->msg();
								?> 
                                <form action="<?php echo SITE_ROOT?>admin/action.php?act=mng_category" method="post" role="form" enctype="multipart/form-data">
                                	<?php echo ($editId)?'<input type="hidden" value="'.$editId.'" name="editId" />':'';?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary" type="button">Category Name</button>
                                        </div><!-- /btn-group -->
                                        <input type="text" class="form-control" name="cat_category" value="<?php echo $objCommon->html2text($getPage['cat_category']);?>">
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
                    	<option value="<?php echo $parents['cat_id']; ?>" <?php echo ($parents['cat_id']	==	$getPage['par_id'])?'selected=selected' : '' ?> ><?php echo $parents['cat_category']; ?></option>
                        <?php } ?>
                                            </select>
                                    </div>
                                        </div>  
                                    </div><!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-info"><?php echo ($editId)?'Update Category':'Save Category';?></button>
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
                                                <th width="15%">ID</th>
                                                <th width="15%">Parent</th>
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
						$sql_pagination 			= 	"SELECT * FROM manage_category  WHERE cat_id != 4 AND (par_id LIKE '%".$search."%' OR cat_category LIKE '%".$search."%' ) ORDER BY cat_id DESC";
					}else{
						$sql_pagination 			= 	"SELECT * FROM manage_category WHERE cat_id != 4 ORDER BY cat_id DESC";;
					}
					$pagesection					=	'';
					pagination($sql_pagination, $num_results_per_page, $num_page_links_per_page, $pg_param,$pagesection);
					$page_list						=	$objCat->listQuery($paginationQuery);
					$countpageList					=	mysql_num_rows(mysql_query($sql_pagination));
					if(count($page_list) >0){
						$count=	1;
						foreach($page_list as $all){
					/*-----------Pagination End----------------*/
?>
                                            <tr>
                                                <td><input type="checkbox" class="mglr_checkbox" value="<?php echo $all['state_id']?>" name="del_id[]" ></td>
                                                <td><?php echo $all['cat_category']?></td>
                                                <td><?php echo $all['cat_id']; ?></td>
                                                <td><?php echo $all['par_id']; ?></td>
                                                <td>
                                                	
						<a href="<?php echo $phpSelf ?>&sid=<?php echo $all['cat_id']?>" class="tiptip outer_admin_action">
                        <?php if ($all['cat_status'] == 0) { ?>
                        	                            <img title="Clik to activate" src="img/red_dot.png">
                                                      <?php   }else{ ?>
                                                      <img title="Clik to activate" src="img/icon_green_dot.png">
                                                  <?php      } ?>
                            						</a>
                        <a title="Edit" href="<?php echo $phpSelf?>&eid=<?php echo $all['cat_id']?>" class="tiptip outer_admin_action">
                        <img title="Edit this topic" src="<?php echo SITE_ROOT ?>admin/images/edit.png">
						</a>
						<a onclick="return del(<?php echo $all['cat_id']?>);" title="Delete" href="javascript:;" class="tiptip outer_admin_action">
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
	window.location.href='<?php echo $phpSelf?>&new_view='+newCount;
}
function del(u){ 
				dataString	=	"act=add_category_del&cdid="+u;
				if (confirm("Are you sure to delete this  selected item !")) {
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