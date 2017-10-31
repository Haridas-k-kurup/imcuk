<div class="modal-dialog modal-lg">
  <div class="modal-content" style="box-shadow:none; border-radius:0px;">
    <div class="compose_mail_h2">
      <h4 class="modal-title">New Message<img class="compose_mail_close"  data-dismiss="modal" src="assets/images/icon-close.png"> </h4>
    </div>
    <form action="mail_action.php?act=firstMail" method="post" enctype="multipart/form-data" id="mail_form">
      <div class="msgtype">
        <label class="msgtype">
          <input type="radio" class="msgtype sendtype" value="1" name="msgtype">
          Personal</label>
        <label class="msgtype">
          <input type="radio" class="msgtype sendtype" value="2" name="msgtype">
          Group</label>
      </div>
      <div class="member-box-list" id="recipient">
        <input type="text" name="to" id="msg_to" value="" placeholder="Recipients" required class="grup-details">
      </div>
      <div class="member-box">
        <input type="text" name="subject" placeholder="Subject" id="subject" class="grup-details" >
      </div>
      <div class="msg-body">
        <textarea style="height:100%; width:100%" required id="body" name="body"></textarea>
      </div>
      <div class="modal-body createMsg">
          <div class="box">
                                
                                <div class="box-body">
                                    
                                        <button type="submit" id="send-email"  name="send-email" class="btn btn-social-icon btn-primary"><i class="fa fa-share-square-o" aria-hidden="true"></i>
 Send</button>
                                        <a class="btn btn-social-icon btn-dropbox email-attach-bt"><input class="email-attachment" type="file"  name="mailattachment" id="mailattachment" /></a>
                                        <a class="btn btn-social-icon btn-dropbox">
                                            <div id="mail-att-preview">
                                                <img src="img/493.png" class="mail-loader"/>
                                            </div>
                                        </a>
                                        <a class="btn btn-social-icon btn-info" onclick="return saveDraft(); " title="Save"><i class="fa fa-save"></i> Save</a>
                                        
                                </div><!-- /.box-body -->
                            </div>
          
          
      </div>
    </form>
  </div>
</div>
<script type="text/javascript" language="javascript">
$('#msg_to').click(function(){
		if(!$('.sendtype').is(':checked')){
			getRecipient(1);
		}
	});
</script> 
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
				if (res != "") {
					$("#mail-att-preview").html(res);
					//$("#fileName").val('');
				}
				else {
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