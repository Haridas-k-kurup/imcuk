<?php 
session_start();
include_once("../../includes/site_root.php");
include_once(DIR_ROOT."class/admin.php");
include_once(DIR_ROOT."class/admin_draft.php");
$objAdmin				=	new admin();
$objDraft				=	new admin_draft();

$adminSession			=	$_SESSION['adminid'];
$adminType				=	$_SESSION['admintype'];
$allAdmins				=	$objAdmin->getAll('admin_status = 1','admin_id');
if($adminSession){
	if(isset($_POST['fe']) && $_POST['fe']){
		$draftId		=	$_POST['fe'];
		$draftDtil		=	$objDraft->getRow('draft_id = "'.$draftId.'" and draft_from = "'.$adminSession.'"');
		if(count($draftDtil)){ ?>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">TO:</span>
                    <select id="email_to"  name="email_to" class="form-control" required>
                                     <optgroup label="ADMINISTRATOR">
                                    	<?php foreach($allAdmins as $admins){ 
											if($admins['admin_id'] == 1 && $admins['admin_type'] == 1){
										?>
                                       
                                            <option value="<?php echo $admins['admin_id']; ?>" <?php echo ($admins['admin_id']==$draftDtil['draft_to'])? 'selected' : '' ?>>Administrator</option>
                                          <?php } } ?>
                                          </optgroup>
                                           <optgroup label="MODERATOR">
                                          <?php 
										  foreach($allAdmins as $admins){
											  if($admins['admin_type'] == 2){
											   ?>
											<option value="<?php echo $admins['admin_id']; ?>" <?php echo ($admins['admin_id']==$draftDtil['draft_to'])? 'selected' : '' ?>><?php echo $admins['admin_username'] ?></option>	
											<?php } } ?>
                                             </optgroup> 
                   </select>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">Subject:</span>
                    <input id="email_sbject" name="subject" type="text" class="form-control" value="<?php echo $draftDtil['draft_subject']; ?>" placeholder="Sbject" required>
                </div>
            </div>
            <div class="form-group">
                <textarea name="message" id="email_message" class="form-control ckeditor" placeholder="Message" ><?php echo $draftDtil['draft_body']; ?></textarea>
            </div>		
<?php			
		}else{
			echo 1;
		}
		
	}
}else{
	header("location:../index.php");
}
 ?>