<?php 
	include_once('../includes/site_root.php');
	include_once(DIR_ROOT."class/imc_message.php");
	$objMessage			= new imc_message();
	$messageId			= $_POST['alert'];
	$getMessage			= $objMessage->getRow('message_id = '.$messageId);
 ?>
<div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Alerts and Messages</h4>
                          </div>
                          <div class="modal-body">
                          <form action="<?php echo SITE_ROOT ?>admin/action.php?act=manage-message-alert" method="post" id="alert-edit-form">
                          <input type="hidden" name="edit_id" value="<?php echo $messageId; ?>">
                            	<div class="form-group has-success">
                                            <label for="input-success" class="control-label"><i class="fa fa-list"></i> Message Type</label>
                                            <select id="input-success" class="form-control" name="message_type">
                                            	<option value="">SELECT MESSAGE TYPE</option>
                                                <option value="forum-notice" <?php echo ($getMessage['message_code'] == "forum-notice") ? "selected" : '' ?>>Forum Notice</option>
                                            </select>
                                        </div>
                                 <div class="form-group has-success">
                                            <label for="input-area" class="control-label"><i class="fa fa-list"></i> Message</label>
                                            <textarea  placeholder="Enter message..." id="input-area" name="message" class="form-control"><?php echo stripslashes($getMessage['message']); ?></textarea>
                                        </div>
                             </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-success" id="edit-submit-alert">Submit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                    
                      </div>
                      <script type="text/javascript" language="javascript">
        	$('#edit-submit-alert').click(function(){
					$('#alert-edit-form').submit();
				});
        </script>