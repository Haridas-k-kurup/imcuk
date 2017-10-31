<?php if($_POST['to']) { ?>
<form action="mail_action.php?act=gReply" method="post" enctype="multipart/form-data">
<input type="hidden" name="mesg" value="<?php echo $_POST['to'];  ?>">
<textarea class="reply-text-box" name="greplay"></textarea>
<div class="btn_msg_send_wrap ovr">
<ul>
<li class="fl">
	<button name="send-email" class="send-mail-btn" type="submit">Send</button>
 </li>
<li class="fl">
<div class="email-attach-bt">
	<input type="file" name="mailattachment" id="mailattachment" class="email-attachment" />
</div>
</li>
<li class="fl">
    <div id="mail-att-preview">
    	<img src="img/493.png" class="mail-loader"/>
    </div>
</li>
<li class="fl">
	<a href="javascript:;" class="delete-mail-reply" title="Discard"><i class="fa fa-trash"></i></a>
</li>
</ul>
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
