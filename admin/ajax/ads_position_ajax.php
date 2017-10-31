<?php 
	session_start();
	include_once("../../includes/site_root.php");
	include_once(DIR_ROOT."class/ad_management.php");
	$objAds			=	new ad_management();
	
	$crtOrder		=	mysql_real_escape_string($_POST['crt_pos']);
	$adPos			=	mysql_real_escape_string($_POST['pos']);
	$page			=	mysql_real_escape_string($_POST['page']);
?>
    	<?php
			$position		=	$objAds->getAll('page_id = "'.$page.'" and pos_id = "'.$adPos.'"');
		 ?>
         <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa  fa-sort-amount-desc"></i> Arrange Advertisement</h4>
                    </div>
                    <form action="#" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" id="page" value="<?php echo $page; ?>" />
                                <input type="hidden" id="crt_pos" value="<?php echo $crtOrder; ?>" />
                                <input type="hidden" id="ad_position" value="<?php echo $adPos; ?>" />
                                <label>Assign New Position</label>
                                <select class="form-control" id="new_pos">
                                    <?php foreach($position as $ads){ ?>
                                    <option value="<?php echo $ads['ad_position']; ?>" <?php echo ($ads['ad_position'] == $crtOrder) ? 'selected' : '' ?>><?php echo $ads['ad_position']; ?></option>
                                   <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                            <button type="button" id="change-pos" class="btn btn-primary pull-left"><i class="fa fa-eject"></i> Save Changes</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        	
                         
    <script type="application/javascript" language="javascript">
$('#change-pos').click(function(){ 
		var crt_pos		=	$('#crt_pos').val();
		var new_pos		=	$('#new_pos').val();
		var	ad_position	=	$('#ad_position').val();
		var	pageId		=	$('#page').val();
		if(new_pos){
		var dataString	=	"crt_pos="+crt_pos+"&new_pos="+new_pos+'&ad_position='+ad_position+'&pageId='+pageId;
		$.ajax({
					type:"POST",
					data:dataString,
					url:"action.php",
					cache:true,
					success:function(el){
							//alert(el);
							if(el == 1){
									$('#aio_popup_wrapper').hide();
									$('.aio_popup_div').hide();
									window.location.reload();
								}else{
									alert("An error occured in this action !")
								}
						}
					});
		}
		
	});
	</script>