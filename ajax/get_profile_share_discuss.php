<?php
session_start();
include_once('../includes/site_root.php');
include_once(DIR_ROOT."includes/session_check.php");
include_once(DIR_ROOT.'includes/action_functions.php');
include_once(DIR_ROOT."class/forum_discussion.php");

$objDiscuss		=	new forum_discussion();

if(isset($_POST['id'])){
$id				=	$_POST['id'];
$allData		=	$objDiscuss->getRow('dis_id  = "'.$id.'"', 'dis_id');
}
if($allData['reg_id']	==	$activeMem){
 ?>
<div class="shareupdate share_edit">
  <!-- edit area start -->
  <div class="replay_wrapper">
    <form enctype="multipart/form-data" method="post" action="" >
      <table width="100%">
        <tbody>
        <tr>
        	<input type="hidden" value="<?php echo $allData['dis_id']; ?>" name="dNo" id="dNo" autocomplete="off">
        </tr>
          <tr>
            <td><textarea class="ckeditor" name="discuss_share" id="dds"><?php echo stripslashes($allData['discussion']); ?></textarea></td>
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
            <td style="text-align:center;"><input type="button" onClick="return submitDiscuss();" class="forum_post_replay_btn" value="SUBMIT" name="forum_post_replay" id="submit_data"></td>
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
function submitDiscuss(){
	var dId			=	$('#dNo').val();
	var dBody		=	CKEDITOR.instances.dds.getData();
	var type		=	"dt";
	var dataString	=	'type='+type+'&dId='+dId+'&dBody='+dBody;
	$.ajax({
			type:"POST",
			url:"ajax_action.php",
			data:dataString,
			cache:false,
			success:function(data){ 
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
