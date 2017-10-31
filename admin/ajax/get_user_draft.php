<?php 
session_start();
include_once("../../includes/site_root.php");
include_once(DIR_ROOT."class/admin.php");
include_once(DIR_ROOT."class/personal_msg_draft.php");
$objAdmin				=	new admin();
$objPDraft				=	new personal_msg_draft();

$adminSession			=	$_SESSION['adminid'];
$adminType				=	$_SESSION['admintype'];
$allAdmins				=	$objAdmin->getAll('admin_status = 1','admin_id');
if($adminSession){
	if(isset($_POST['fe']) && $_POST['fe']){
		$draftId		=	$_POST['fe'];
		$draftDtil		=	$objPDraft->getRow('personal_draft_id = "'.$draftId.'" and personal_draft_from = 1');
		if(count($draftDtil)){ ?>
            
            <div class="form-group">
            		<input type="hidden" name="user_draftid"  value="<?php echo $draftId; ?>" />
                                    <div class="row">
                                    	<div class="col-sm-6">
                                        <div class="input-group bg-gray">
                                    <span class="input-group-addon">Select All:</span>
                                    
                                    <input type="checkbox" class="form-control" name="notice_all" value="1" />
                                </div>
                                        </div>
                                        <div class="col-sm-6">
                                        <div class="input-group">
                                    <span class="input-group-addon">Select Category:</span>
                                    <select  name="notice_to" class="form-control">
                                        <option value="">--- Select ---</option>   
                                        <option value="1">Medical Related Professionals</option>
                                        <option value="2">Medical Organizations</option>
                                        <option value="3">Patient(Non Medical Persons)</option> 
                                    </select>
                                </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Subject:</span>
                                    <input name="notice_subject" id="notice_subject" type="text" value="<?php echo $draftDtil['personal_draft_subject']; ?>" class="form-control" placeholder="Sbject" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea id="notice_message" id="notice_message" name="notice_message" class="form-control" placeholder="Message" ><?php echo $draftDtil['personal_draft_subject']; ?></textarea>
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