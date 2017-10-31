<?php if($_POST['to']) { ?>
<form action="mail_action.php?act=reply" method="post" enctype="multipart/form-data">
<input type="hidden" name="forhim" value="<?php echo $_POST['to'];  ?>">
<textarea class="reply-text-box" name="replay"></textarea>
<div class="btn_msg_send_wrap ovr">
<div class="box">
                                
                                <div class="box-body">
                                    
                                        <button type="submit"  name="send-email" class="btn btn-primary"><i class="fa fa-share-square-o" aria-hidden="true"></i>
 Send</button>
                                        <a class="btn btn-dropbox email-attach-bt"><input class="email-attachment" type="file"  name="mailattachment" id="mailattachment" /></a>
                                        <a class="btn btn-dropbox">
                                            <div id="mail-att-preview">
                                                <img src="img/493.png" class="mail-loader"/>
                                            </div>
                                        </a>
                                        <a class="btn btn-info delete-mail-reply" title="Delete"><i class="fa fa-trash-o"></i></a>
                                        
                                </div><!-- /.box-body -->
                            </div>

</div>
<script language="javaScript" type="text/javascript">
	$("#mailattachment").on('change',function(){
		if($("#mailattachment").val()!=""){
			$('.mail-loader').show();
			setTimeout(function(){
			$("#mailattachment").upload('ajax/upload_mail_attachment.php', function(res) {
				if(res!=""){
					$("#mail-att-preview").html(res);
					//$("#fileName").val('');
				}
				else{
					alert("Sorry file is not attached !");
				}
			});
		},1000);
	}
});
</script>
<script type="text/javascript" language="javascript">
$('.delete-mail-reply').click(function(){
	$(this).parents().eq(3).remove();
	});
</script>
</form>
<?php } ?>

