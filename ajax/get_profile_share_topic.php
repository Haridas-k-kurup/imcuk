<?php
session_start();
include_once('../includes/site_root.php');
include_once(DIR_ROOT."includes/session_check.php");
include_once(DIR_ROOT.'includes/action_functions.php');
include_once(DIR_ROOT."class/forum_topics.php");
$objThread		=	new forum_topics();

if(isset($_POST['id'])){
$id				=	$_POST['id'];
$allData		=	$objThread->getRow('topic_id = "'.$id.'"', 'topic_id');
}
if($allData['reg_id']	==	$activeMem){
 ?>
<div class="shareupdate share_edit">
  <!-- edit area start -->
  <div class="replay_wrapper">
    <form enctype="multipart/form-data" method="post" action="" >
      <table width="100%">
        <tbody>
          <tr height="60">
            <td><label class="create_thread_label">Topic</label>
              &nbsp;&nbsp;&nbsp;
              <input type="text" placeholder="Please enter your title" id="topic" style="width:100%;" value="<?php echo $allData['topic']; ?>" name="topic" required>
              <input type="hidden" value="<?php echo $allData['topic_id']; ?>" name="tNo" id="tNo" autocomplete="off"></td>
          </tr>
          <tr>
            <td><textarea class="ckeditor" name="topic_share" id="tds"><?php echo stripslashes($allData['topic_desc']); ?></textarea></td>
          </tr>
          <tr>
            <td></td>
          </tr>
          <tr> </tr>
        </tbody>
      </table>
      <table width="40%" style="margin:0 auto">
        <tbody>
          <tr>
            <td style="text-align:center;"><input type="button" onClick="return submitTopic();" class="forum_post_replay_btn" value="SUBMIT" name="forum_post_replay" id="submit_data"></td>
            <td style="text-align:center;"><input type="button" id="cancel" class="forum_post_replay_btn" value="CANCEL" name="cancel"></td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
  <!-- edit area end --> 
  <script type="text/javascript" language="javascript">
$('#cancel').click(function(){
	$('.share_edit').remove();
});
function submitTopic(){
	var tId			=	$('#tNo').val();
	var tHead		=	$('#topic').val();
	var tBody		=	CKEDITOR.instances.tds.getData();
	var type		=	"ft";
	var dataString	=	'type='+type+'&tId='+tId+'&tHead='+tHead+'&tBody='+tBody;
	$.ajax({
			type:"POST",
			url:"ajax_action.php",
			data:dataString,
			cache:false,
			success:function(data){ //alert(data);
					if(data = 1){ 
					location.reload();
					}else{
						alert("Sorry! Try again.");
						location.reload();
					}
			}
			
		});
}
</script>
</div>
<?php } ?>