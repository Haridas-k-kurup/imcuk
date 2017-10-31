<?php 
include_once('includes/header.php'); 
include_once(DIR_ROOT.'class/manage_page_connection.php');
include_once(DIR_ROOT.'class/forum_topics.php');
include_once(DIR_ROOT.'class/imc_message.php');
$objCon			=	new manage_page_connection();
$objForum		=	new forum_topics();
$objMessage		= 	new imc_message();
$allDashPages	=	$objImcPage->getAll();
?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
             <?php include_once('includes/sidemenubar.php'); ?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                    <?php 
					 $i	= 1;
					 $j	= 0;
					 foreach($allDashPages as $pages){ ?>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box <?php if($j%2 == 0){ echo "bg-aqua"; }else if($j%3 == 0){ echo "bg-green"; }else if($j%4 == 0){ echo "bg-yellow"; }else if($j%5 == 0){ echo "bg-red"; } else { echo "bg-yellow"; } ?>">
                                <div class="inner">
                                    <h4>
                                    Total Slider <?php echo  $objCon->count('page_id='.$pages['page_id']); ?><br />
                                    Total Forum <?php echo  $objForum->count('page_id='.$pages['page_id']); ?>
                                    </h4>
                                    <p class="">
                                      <b>  <?php echo strtoupper($pages['page_name']);  ?></b>
                                    </p>
                                </div>
                                <div class="icon"> 
                                    <i class="fa fa-stethoscope"></i>
                                </div>
                                <a href="<?php echo SITE_ROOT; ?>admin/index.php?page=list_page_details&dept=<?php echo  $pages['page_id']; ?>" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <?php  echo ($i%4 == 0) ? "</div><div class=\"row\">" : "" ;  $i++; $j++ ;} ?>
                    </div><!-- /.row -->
					
                    <!-- top row -->
                    <?php 
						$allAlerts			= $objMessage->getAll('', 'message_id desc');
					 ?>
                    <div class="row">
                        <div class="col-xs-12 connectedSortable">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Alerts and Messages</h3>
                                    <!--<div class="box-tools pull-right">
                                        <ul class="pagination pagination-sm inline">
                                            <li><a href="#">&laquo;</a></li>
                                            <li><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">&raquo;</a></li>
                                        </ul>
                                    </div>-->
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <ul class="todo-list">
                                    <?php if (!empty($allAlerts)) {
											foreach ($allAlerts as $alert) { 
										 ?>
                                        <li>
                                            <!-- drag handle -->
                                            <span class="handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>  
                                            <!-- checkbox -->
                                            <input type="checkbox" value="" name=""/>                                            
                                            <!-- todo text -->
                                            <span class="text"><?php echo $alert['message']?></span>
                                            <!-- Emphasis label -->
                                            <small class="label label-danger"><i class="fa fa-clock-o"></i> Forum Alert </small>
                                            <!-- General tools such as edit or delete-->
                                            <div class="tools">
                                                <a href="javascript:;" onclick="return edit_alert(<?php echo $alert['message_id']; ?>)"><i class="fa fa-edit"></i></a>
                                                <i class="fa fa-trash-o"></i>
                                            </div>
                                        </li> 
                                         <?php } } else {  ?>
                                         <li>
                                            <!-- drag handle -->
                                            <span class="handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>  
                                                                                    
                                            <!-- todo text -->
                                            <span class="text">No alerts or messages are exist</span>
                                            
                                            
                                        </li>
                                         <?php  } ?>
                                    </ul>
                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix no-border">
                                    <button class="btn btn-default pull-right" data-toggle="modal" data-target="#alert-modal"><i class="fa fa-plus"></i> Add Message</button>
                                </div>
                            </div>
                        </div><!-- /.col -->
                    </div>
                    <!-- /.row -->
					<div id="alert-modal" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Alerts and Messages</h4>
                          </div>
                          <div class="modal-body">
                          <form action="<?php echo SITE_ROOT ?>admin/action.php?act=manage-message-alert" method="post" id="alert-form">
                            	<div class="form-group has-success">
                                            <label for="inputSuccess" class="control-label"><i class="fa fa-list"></i> Message Type</label>
                                            <select id="inputSuccess" class="form-control" name="message_type">
                                            	<option value="">SELECT MESSAGE TYPE</option>
                                                <option value="forum-notice">Forum Notice</option>
                                            </select>
                                        </div>
                                 <div class="form-group has-success">
                                            <label for="inputarea" class="control-label"><i class="fa fa-list"></i> Message</label>
                                            <textarea  placeholder="Enter message..." id="inputarea" name="message" class="form-control"></textarea>
                                        </div>
                             </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-success" id="submit-alert">Submit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                    
                      </div>
                    </div>
                    <!--Edit alert -->
                    <div id="alert-edit-modal" class="modal fade" role="dialog">
                      
                    </div>
                    <!-- Main row -->
                    <!-- /.row (main row) -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Morris.js charts -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="js/plugins/morris/morris.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- fullCalendar -->
        <script src="js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="js/AdminLTE/dashboard.js" type="text/javascript"></script>        
		<script type="text/javascript" language="javascript">
        	$('#submit-alert').click(function(){
					$('#alert-form').submit();
				});
        </script>
        <script type="text/javascript" language="javascript">
        	function edit_alert(id) {
					var dataString 	= 'alert='+id;
					$.ajax({
						type: "POST",
						url: "ajax-edit-alert.php",
						data: dataString,
						cache: false,
						async:false,
						success: function(data){ 
								$('#alert-edit-modal').html(data);
								$("#alert-edit-modal").modal();
							}
						});
			}
        </script>
    </body>
</html>