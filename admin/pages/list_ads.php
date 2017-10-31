<?php
include_once(DIR_ROOT."admin/includes/header.php");
include_once(DIR_ROOT."admin/includes/pagination.php");
include_once(DIR_ROOT."class/manage_topic_position.php");
include_once(DIR_ROOT."class/imc_pages.php");
include_once(DIR_ROOT."class/ad_management.php");
$objPos				=	new manage_topic_position();
$objImcPage			=	new imc_pages();
$objAds				=	new ad_management();
$allPos				=	$objPos->getAll('pos_id != 4 and pos_status = 1','pos_name asc');
$allPages			=	$objImcPage->getAll('page_status = 1','page_name asc');
if(isset($_GET['dept'])){
	$pageId			=	$objCommon->esc($_GET['dept']);
	$pageDtils		=	$objImcPage->getRow('page_id = "'.$pageId.'"');
}
$phpSelf			=	SITE_ROOT.'admin/index.php?page=list_ads';
$search				=	$objCommon->esc($_REQUEST['search_field']);
$sid				=	$objCommon->esc($_GET['sid']);
$del_id				=	$_REQUEST['del_id'];

if(count($del_id)>0){
	if($adminType == 1){
	foreach($del_id as $all_del_id){
		$objAds->delete("ad_id=".$all_del_id);	
	}
	}else{
		foreach($del_id as $all_del_id){
		$objAds->updateField(array("ads_staff_manage"=>1),"ad_id =".$all_del_id);
	}
		}
	$notfn->add_msg("Selected advertisement has been removed successfully...!",3);
	header("location:".$phpSelf);
}
if($sid){ 
	$editData		=  $objAds->getRow("ad_id =".$sid, "ad_id");	
	if($editData['ad_status'] == 0){
		$objAds->updateField(array("ad_status"=>1),"ad_id	=".$sid);
	}else{
		$objAds->updateField(array("ad_status"=>0),"ad_id 	=".$sid);
	}
	header("location:".$phpSelf);
}
/*-----------Recover content from staff start----------------------------*/
if(isset($_GET['dsid']) && $_GET['dsid'] > 0 && $adminType == 1){
	$mpID			=	$objCommon->esc($_GET['dsid']);
	$objAds->updateField(array("ads_staff_manage"=>0),"ad_id =".$mpID);
	$notfn->add_msg("Advertisement Detail has been Recovered...!",3);
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
                       List All I M C Advertisement Details
                        <small>International Medical Connection</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
                        <li><a href="#"> Advertisement  </a></li>
                        <li class="active">List Advertisement</li>
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
                                    <h3 class="box-title">List Advertisement Details</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="row">
                                <form action="#" method="get">
                    			<input type="hidden" name="page" value="<?php echo $page; ?>" />
                                <?php if(isset($_GET['dept'])){ ?>
                    				<input type="hidden" name="dept" value="<?php echo $_GET['dept']; ?>" />
                    			<?php } ?>
                                	<div class="col-lg-8">
                                        <div class="row">
                                        <div class="col-lg-3  bg-blue">
                                           <div class="form-group margin">
                                            <select class="form-control" name="serchcat">
                                                <option value="">POSITIONS</option>
                                                <?php foreach($allPos as $position){ ?>
                                                <option value="<?php echo $position['pos_id']; ?>" <?php echo ($_GET['serchcat'] == $position['pos_id']) ? 'selected' : '' ?>><?php echo $objCommon->esc($position['pos_name']); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div> 
                                        </div>
                                        <div class="col-lg-3 bg-blue">
                                           <div class="form-group margin">
                                            <select class="form-control" name="serchpages">
                                                <option value="">PAGES</option>
                                                <?php foreach($allPages as $pages){ ?>
                                                <option value="<?php echo $pages['page_id']; ?>" <?php echo ($_GET['serchpages'] == $pages['page_id']) ? 'selected' : '' ?>><?php echo $objCommon->esc($pages['page_name']); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div> 
                                        </div>
                                        <div class="col-lg-6 bg-blue">
                                            <div class="input-group margin">
                                                <input type="text" placeholder="Search by Advertisement Name or Advertiser Name" name="search_field" class="form-control">
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn btn-info btn-flat">Go!</button>
                                                </span>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </form>
                                    <div class="col-lg-4">
                                        <div class="input-group margin pull-right">
                                        	<button class="btn btn-danger btn-sm " id="delete-all">Delete All</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body table-responsive">
                                <form method="get" id="manage-details">
                                 <input type="hidden" value="list_ads" name="page" />
                                  <input type="hidden" value="<?php echo $pageId; ?>" name="dept" />
                                    <table id="example2" class="table table-bordered table-hover text-center">
                                        <thead>
                                            <tr>
                                                <th width="1%"><input type="checkbox" name="checkbox" class="checkall" id="checkbox"></th>
                                                <th width="15%">Ad Name</th>
                                                <th width="15%">Advertiser</th>
                                                <th width="10%">Publish From</th>
                                                <th width="10%">Publish To</th>
                                                <th width="5%">Advertisement</th>
                                                <th width="10%">Page</th>
                                                 <th width="10%">Position</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                        </thead>
                                     <?php
/*-----------Pagination start----------------*/
$num_results_per_page 	 		=	($_GET['new_view'])?$_GET['new_view']:10;
$num_page_links_per_page 		= 	5;
$pg_param 						= 	"";
if($search || $_GET['serchcat'] || $_GET['serchpages']){
	if($adminType == 1){
	$sql_pagination 			= 	"SELECT ads.*, page.page_id, page.page_name FROM ad_management AS ads LEFT JOIN imc_pages AS page ON ads.page_id = page.page_id WHERE";
		if($_GET['serchcat']){
			$pageCatId			=	$objCommon->esc($_GET['serchcat']);
			$sql_pagination		.=	" ads.pos_id = '".$pageCatId."' AND";
		}
		if($_GET['serchpages']){
			$srpageId			=	$objCommon->esc($_GET['serchpages']);
			$sql_pagination		.=	" ads.page_id = '".$srpageId."' AND";
			
		}
	 $sql_pagination			.=	" (ads.ad_name LIKE  '%".$search."%' OR ads.ad_adver_name LIKE  '%".$search."%')  ORDER BY ads.ad_position";
	}else{
		$sql_pagination 		= 	"SELECT ads.*, page.page_id, page.page_name FROM ad_management AS ads LEFT JOIN imc_pages AS page ON ads.page_id = page.page_id WHERE ads.ads_staff_manage = 0 AND";
		if($_GET['serchcat']){
			$pageCatId			=	$objCommon->esc($_GET['serchcat']);
			$sql_pagination		.=	" ads.pos_id = '".$pageCatId."' AND";
		}
		if($_GET['serchpages']){
			$srpageId			=	$objCommon->esc($_GET['serchpages']);
			$sql_pagination		.=	" ads.page_id = '".$srpageId."' AND";
			
		}
	 $sql_pagination			.=	" (ads.ad_name LIKE  '%".$search."%' OR ads.ad_adver_name LIKE  '%".$search."%')  ORDER BY ads.ad_position";
	}
}else{
	if($adminType == 1){
	 $sql_pagination 			= 	"SELECT ads.*, page.page_id, page.page_name FROM ad_management AS ads LEFT JOIN imc_pages AS page ON ads.page_id = page.page_id ORDER BY ads.ad_position";
	}else{
		$sql_pagination 		= 	"SELECT ads.*, page.page_id, page.page_name FROM ad_management AS ads LEFT JOIN imc_pages AS page ON ads.page_id = page.page_id WHERE ads.ads_staff_manage = 0 ORDER BY ads.ad_position";
	}
}
$pagesection					=	'';
pagination($sql_pagination, $num_results_per_page, $num_page_links_per_page, $pg_param,$pagesection);
$page_list						=	$objAds->listQuery($paginationQuery);
$countpageList					=	mysql_num_rows(mysql_query($sql_pagination));
if(count($page_list) >0){
	$count=	1;
	foreach($page_list as $all){
/*-----------Pagination End----------------*/
?>
                                        <tbody>
                                            <tr>
                                                <td><input type="checkbox" name="del_id[]" value="<?php echo $all['ad_id']?>" class="mglr_checkbox"></td>
                                                <td><?php echo strip_tags(substr($all['ad_name'],0,75)); ?></td>
                                                <td><?php echo substr(strip_tags($all['ad_adver_name']),0,75); ?> </td>
                                                <td><?php echo $all['ad_publish_from'];?></td>
                                                <td><?php echo $all['ad_publish_to'];?></td>
                                                <td><img src="<?php echo SITE_ROOT."advertisement/".$all['ad_image'];?>" width="100%" height="75" /></td>
                                                <td><?php echo $all['page_name'];?></td>
                                                <td>
                                                	<button type="button" data-toggle="modal" onclick="return position(<?php echo $all['ad_position']; ?>,<?php echo $all['pos_id']; ?>,<?php echo $all['page_id']; ?>)" data-target="#compose-modal" class="btn btn-info btn-lg"> <?php echo $all['ad_position'];?></button></td>
                                                <td>
                                                     <?php if($adminType == 1 && $all['ads_staff_manage'] == 1){ ?> 
                          <a class="tiptip outer_admin_action" href="<?php echo $phpSelf?>&dsid=<?php echo $all['ad_id']?>" >
                          	<img  src="<?php echo SITE_ROOT; ?>admin/img/question.png" title="Deleted from Sub Admin">
                          </a>
                          <?php }else{ ?>    	
						  <a class="tiptip outer_admin_action" href="<?php echo $phpSelf ?>&sid=<?php echo $all['ad_id']?>" >
                        	<?php if($all['ad_status'] == 1){ ?>
							<img  src="img/icon_green_dot.png" title="Clik to deactivate">
                            <?php }else{ ?>
                            <img src="img/red_dot.png" title="Clik to activate">
                            <?php } ?>
						</a>
                        <?php } ?>
                        <a class="tiptip outer_admin_action" href="<?php echo SITE_ROOT?>admin/index.php?page=add_ad&eid=<?php echo $all['ad_id']?>" title="Edit">
                        <img src="<?php echo SITE_ROOT ?>admin/images/edit.png" title="Edit this topic" >
						</a>
						<a class="tiptip outer_admin_action" href="javascript:;" title="Delete" onclick="return del(<?php echo $all['ad_id']?>);">
							<span class="inner_admin_action admin_action_delete"><i class="fa fa-trash-o"></i></span>
						</a> 
                                                </td>
                                            </tr>
                                        </tbody>
                                     <?php } 
									
									 }else{ ?>  
                                     <tr>
                                     	<td colspan="9">
                                        	<p class="alert-warning">Sorry ! No Advertisement Found</p>
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
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        

        <!-- page script -->
       <!-- <script type="text/javascript">
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
        </script>-->
         <!-- COMPOSE MESSAGE MODAL -->
        <div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
            
        </div><!-- /.modal -->
       
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
        <script type="text/javascript" language="javascript">
			// popup position

function position(odr,pos,page){ 
	if(odr && pos && page){
	var dataString	=	'crt_pos='+odr+'&pos='+pos+'&page='+page;
	$.ajax({
					type:"POST",
					data:dataString,
					url:"ajax/ads_position_ajax.php",
					cache:true,
					success:function(el){
							$('#compose-modal').html(el);
						}
					});
	}
}
		</script>
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
    </body>
</html>