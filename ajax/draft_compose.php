<?php 
	session_start();
	include_once('../includes/site_root.php'); 
	include_once(DIR_ROOT."includes/session_check.php");
	include_once(DIR_ROOT.'class/personal_msg_draft.php');
	$objDraft		=	new personal_msg_draft();
	if ($_POST['mid']) {
		$mid		=	$_POST['mid'];
		$getMsg		=	$objDraft->getRow('personal_draft_id = "'.$mid.'"','personal_draft_id');
		if ($getMsg['personal_draft_from'] == $activeMem) {
?>
<div class="modal-dialog modal-lg">
  <div class="modal-content" style="box-shadow:none; border-radius:0px;">
    <div class="compose_mail_h2">
      <h4 class="modal-title">New Message<img class="compose_mail_close"  data-dismiss="modal" src="assets/images/icon-close.png"> </h4>
    </div>
    <form action="mail_action.php?act=sendDraft" method="post" enctype="multipart/form-data" id="mail_form">
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
      <input type="hidden" name="draftId" value="<?php echo $mid; ?>">
       <input type="text" name="dft_subject" value="<?php echo $getMsg['personal_draft_subject']; ?>" placeholder="Subject" id="subject" class="grup-details" >
      </div>
      <div class="msg-body">
        <textarea style="height:100%; width:100%" required id="body" name="body"><?php echo $getMsg['personal_draft_body']; ?></textarea>
      </div>
      <div class="modal-body createMsg">
          <div class="box">
                                
                                <div class="box-body">
                                    
                                        <button type="submit" id="send-email"  name="send-email" class="btn btn-social-icon btn-primary"><i class="fa fa-share-square-o" aria-hidden="true"></i>
 Send</button>
                                        <a class="btn btn-social-icon btn-dropbox email-attach-bt"><input class="email-attachment" type="file"  name="mailattachment" id="mailattachment" /></a>
                                        <a class="btn btn-social-icon btn-dropbox">
                                            <div id="mail-att-preview">
                                            <?php if($getMsg['personal_draft_attachment']){ ?>
        									<div class="email-attached-file" title="<?php echo $getMsg['personal_draft_attachment']; ?>">
											<input type="hidden" value="<?php echo $getMsg['personal_draft_attachment']; ?>" id="mailattached" name="mailattached">
											</div>
                       						 <?php } ?>
                                                <img src="img/493.png" class="mail-loader"/>
                                            </div>
                                        </a>
                                        <a class="btn btn-social-icon btn-info" onclick="return deleteDraft(<?php echo $mid; ?>); " title="Delete"><i class="fa fa-trash-o"></i> Save</a>
                                        
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
function getRecipient(sendType) { //fro get recipient
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
function deleteDraft(did){
	window.location		=	"<?php echo SITE_ROOT; ?>message_draft.php?dmail[]="+did;
}
</script>
<?php } } ?>