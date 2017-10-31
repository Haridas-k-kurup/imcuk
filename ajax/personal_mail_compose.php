<?php
	$id			=	$_POST['letter'];
 ?>
<div class="mail_area_wrapper">
<div class="mail_header">
    <span>New Message</span><span class="compose-close fr"><a href="javascript:;"><i class="fa fa-times"></i></a>
</span><span class="clear"></span>
</div>
<form action="mail_action.php?act=firstMail" method="post" enctype="multipart/form-data" id="mail_form">
<div class="contant_block msgtype" style="padding:0;">
  
<div class="contant_block" id="recipient" >
    <input type="hidden" name="details[]" id="msg_to" value="<?php echo $id; ?>" placeholder="Recipients" required />
</div>
<div class="contant_block">
    <input type="text" name="subject" placeholder="Subject" id="subject" />
</div>
<div class="contant_block msg-body">
    <textarea name="body" id="body" required></textarea>
</div>
<div class="btn_msg_send_wrap ovr">
<ul>
<li class="fl">
	<div class="email-send-btn-wrapp">
		<button type="submit" id="send-email" name="send-email" >Send</button>
    </div>
</li>
<li class="fl" style="margin-left:2%;">
<div class="email-attach-bt" >
	<input type="file" name="mailattachment" id="mailattachment" class="email-attachment" />
</div>
</li>
<li class="fl">
    <div id="mail-att-preview">
    	<img src="img/493.png" class="mail-loader"/>
    </div>
</li>
<li class="fl">
    <a href="javascript:;" class="delete-mail-reply" onclick="return saveDraft(); " title="Save"><i class="fa fa-floppy-o"></i>
</a>
</li>
 </ul>
</div>

<script type="text/javascript" language="javascript">
$('.compose-close').click(function(){
	$('.mail_area_wrapper').remove();
});
</script>
<script type="text/javascript" language="javascript">
$('.sendtype').click(function(){
	var sendType	=	$(this).val();
	getRecipient(sendType);
});
function getRecipient(sendType){ // fro get recipient
	var dataString	=	"type="+sendType;
	$.ajax({
				type:"POST",
				url:"ajax/email_sent_to.php",
				data:dataString,
				cache:false,
				success:function(data){ 
					$("#recipient").html(data);
				}
				
			});
}
</script>
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
	function saveDraft(){
		var subject		=	$('#subject').val();
		var dtils		=	$('#body').val();
		var attach		=	$('#mailattached').val();
		var act			=	"draft";
		var dataString	=	"subject="+subject+"&dtils="+dtils+"&attach="+attach+"&act="+act;
		$.ajax({
				type:"POST",
				url:"mail_action.php",
				data:dataString,
				cache:false,
				success:function(data){ 
					if(data == 1){
						location.reload();
					}else{
						alert("Sorry! Error occured in your action");
					}
				}
				
			});
	}
</script>
</form>
</div>
