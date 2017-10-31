<div class="modal-dialog modal-lg">
      <div class="modal-content">
      
    <div style="border:8px double #000066; border-radius:10px;">
        <form method="post" action="action.php?act=changepass" enctype="multipart/form-data">
        <div class="modal-body">
        <div class="row">
        <div class="col-lg-4 labletext1">Current Password</div>
        <div class="col-lg-8"><input type="password" style="width:100%" required placeholder="Enter Current Password" class="inputstyle1" name="curpass" kl_virtual_keyboard_secure_input="on"></div>
        </div>
        <div class="row">
        <div class="col-lg-4 labletext1">New Password</div>
        <div class="col-lg-8"><input type="password" style="width:100%" required placeholder="Enter New Password" class="inputstyle1" name="npass" id="npass" kl_virtual_keyboard_secure_input="on" title="Password must contain at least 6 characters" pattern=".{6,}" onchange=" this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); if(this.checkValidity()) form.repass.pattern = this.value;"></div>
        </div>
        <div class="row">
        <div class="col-lg-4 labletext1">Re-Type Password</div>
        <div class="col-lg-8"><input type="password" style="width:100%" required placeholder="Re-Enter New Password" class="inputstyle1"  pattern=".{6,}" name="repass" onchange=" this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); " kl_virtual_keyboard_secure_input="on"></div>
        </div>
        </div>
        
        
        <div class="popup-btn_wrap" align="center">
            <button class="popup-button" name="submit" type="submit">Save</button>
            <button id="create-group-close" data-dismiss="modal" class="popup-button" name="submit" type="submit">Close</button>
		</div>
		</form>
      </div>
    </div>
    </div>