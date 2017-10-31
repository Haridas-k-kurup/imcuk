<div class="col-lg-3">
    <div class=" border_style1">
    <div class="proff-pic-area ovr" style="">   
    <?php if($userData['ud_pofile_pic']){
							 
			$profPic	=  "profiles/".stripslashes($userData['ud_pofile_pic']);
			if(file_exists($profPic)){
		?>
	<img src="<?php echo SITE_ROOT.$profPic; ?>" class="img-responsive img-thumbnail" width="100%" alt="<?php echo stripcslashes($userData['reg_private_id']); ?>" >
	<?php } else{ ?>
	<img src="<?php echo SITE_ROOT; ?>images/profile.jpg" class="img-responsive img-thumbnail" width="100%" >
	<?php }  }else{ ?>
	<img src="<?php echo SITE_ROOT; ?>images/profile.jpg" class="img-responsive img-thumbnail" width="100%" >
	<?php } ?>
    <div class="img-edit-area">
    <a href="javascript:;" id="change-profile" onclick="return loadFrame();" title="Upload Profile Picture"><i class="fa fa-pencil"></i></a>
              </div>
                    
                </div>
                
                <div class="change-image_wrap">
                    	<div class="browse-btn-wrap">
                        	<div class="upload">
        							<input type="file" id="attachmentFile" name="attachement"/>
                                    
    						</div>
                            <div style="border: medium none;display:none; " class="profile_preview" id="imageloadstatus"><img alt="Uploading..." src="img/profload.gif"></div>
                            
                        </div>
                        <div id="preview" class="photo-confirm">
                            	
                           </div>
                           <div class="img-edit-area" id="cancel-window">
                    			<a href="javascript:;" id="close-window" onclick="return loadFrame();" title="Close Window"><i class="fa fa-times"></i></a>
                    		</div>
                    </div>
    
    <div class="proff-icon-wrapp">
    <a onclick="return loadFrame();" href="javascript:;" class="proff-msg-btn"><i class="fa fa-user"></i>&nbsp;&nbsp; Change Profile Picture</a>
    </div>
    
    <div class="proff-icon-wrapp">
    <a href="javascript:;" id="compose" class="proff-msg-btn"><i class="fa fa-pencil"></i>&nbsp;&nbsp; Create Message</a>
    </div>
    
    <div class="proff-icon-wrapp">
    <a href="<?php echo SITE_ROOT; ?>mail_list.php" class="proff-msg-btn"><i class="fa fa-envelope"></i>&nbsp;&nbsp; Inbox</a>
    </div>
    
    <div class="proff-icon-wrapp">
    <a href="<?php echo SITE_ROOT; ?>mail_sent_items.php" class="proff-msg-btn"><i class="fa fa-sign-out"></i>&nbsp;&nbsp; Sent Items</a>
    </div>
    
    <div class="proff-icon-wrapp">
    <a href="<?php echo SITE_ROOT; ?>message_draft.php" class="proff-msg-btn"><i class="fa fa-pencil-square"></i>&nbsp;&nbsp; Draft</a>
    </div>
    
    <div class="proff-icon-wrapp">
    <a  href="javascript:;" class="proff-msg-btn" id="create-group"><i class="fa fa-user-plus"></i>&nbsp;&nbsp; Create Group</a>
    </div>
    
    <div class="proff-icon-wrapp">
    <a href="<?php echo SITE_ROOT; ?>profile_group_details.php" class="proff-msg-btn"><i class="fa fa-users"></i>&nbsp;&nbsp; Your Groups [<?php echo $groupCount; ?>]</a>
    </div>
    
    <div class="proff-info-head">
                    	<span>Informations</span>
                    </div>
    <div style="padding-top:5px; padding-left:2%;">
    <h5 style="padding:0px; margin:0px;" class="prof-info-head">Birthday </h5>
<span class="prof-info-details"> 
<?php 
	$birthDay		= $userData['ud_dob'];
 ?>
<?php echo $birthDay; ?> </span>
</div>
<br />
<div style="padding-top:5px; padding-left:2%;">
    <h5 style="padding:0px; margin:0px;" class="prof-info-head">Hometown </h5>
<span class="prof-info-details"><?php 
											if ($userData['ud_city']) {
										echo $userData['ud_city'];
											} else {
												echo "------------------";
											}?> </span>
</div>
<br />
<div style="padding-top:5px; padding-left:2%;">
    <h5 style="padding:0px; margin:0px;" class="prof-info-head">Profession </h5>
<span class="prof-info-details"><?php 
											if ($userData['up_profession_name']) {
										echo stripcslashes($userData['up_profession_name']);
											} else {
												echo "------------------";
											}?> </span>
</div>
<br />
<div style="padding-top:5px; padding-left:2%;">
    <h5 style="padding:0px; margin:0px;" class="prof-info-head">Mobile Number </h5>
<span class="prof-info-details"><?php 
											if($userData['ud_tel_mob']){
										echo stripcslashes($userData['ud_tel_mob']);
											}else{
												echo "------------------";
											}?> </span>
</div>
<br />
<div style="padding-top:5px; padding-left:2%;">
    <h5 style="padding:0px; margin:0px;" class="prof-info-head">Email Address</h5>
<span class="prof-info-details"><?php 
											if($userData['ud_email']){
										echo stripcslashes($userData['ud_email']);
											}else{
												echo "------------------";
											}?> </span>
</div>
<br />
<div style="padding-top:5px; padding-left:2%;">
    <h5 style="padding:0px; margin:0px;" class="prof-info-head">Facebook Address</h5>
<span class="prof-info-details"><?php 
											if($userData['ud_facebook']){
										echo stripcslashes($userData['ud_facebook']);
											}else{
												echo "------------------";
											}?> </span>
</div>
<?php  if($userData['uo_collage_addr']){ ?>
<br />
<div style="padding-top:5px; padding-left:2%;">
    <h5 style="padding:0px; margin:0px;" class="prof-info-head">Collage Address</h5>
<span class="prof-info-details">
											<?php 
											if($userData['uo_collage_addr']){
										echo stripcslashes($userData['uo_collage_addr']);
											}else{
												echo "------------------";
											}?> </span>
</div> <?php } ?>
<?php  if($userData['uo_hospital_addr']){ ?>
<br />
<div style="padding-top:5px; padding-left:2%;">
    <h5 style="padding:0px; margin:0px;" class="prof-info-head">Hospital Address</h5>
<span class="prof-info-details">
											<?php 
											if($userData['uo_hospital_addr']){
										echo stripcslashes($userData['uo_hospital_addr']);
											}else{
												echo "------------------";
											}?> </span>
</div> <?php } ?>
<?php  if($userData['uo_company_addr']){ ?>
<br />
<div style="padding-top:5px; padding-left:2%;">
    <h5 style="padding:0px; margin:0px;" class="prof-info-head">Company Address</h5>
<span class="prof-info-details">
											<?php 
											if($userData['uo_company_addr']){
										echo stripcslashes($userData['uo_company_addr']);
											}else{
												echo "------------------";
											}?> </span>
</div> <?php } ?>
    </div>
    </div>
    
    <!--compose window start-->
    <div class="modal" id="myModal" role="dialog" style="right:5px; bottom:-29px; left:auto; top:auto; ">
    
    </div>
    <!--compose window end-->
    <!--CREATE GROUP POPUP WINDOW START-->
    <div class="modal fade" id="create-group-window" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" id="group-create-window">
      </div>
      </div>
  </div>
  <script type="text/javascript" language="javascript">
 $('#create-group').click(function(){// GET CREATE GROUP POPUP
	 	$('#create-group-window').modal('show');
		
		var preload		=	'<img src="img/small.gif" class="preloadersmall" style="margin:0 auto; display:block; " />';
		$('#group-create-window').html(preload);
		$.ajax({
				type:"POST",
				url:"ajax/create_group_box.php",
				cache:false,
				success:function(data){
					$("#group-create-window").html(data);
				}
				
			});
	 	
	 });
	 
 </script>
    <!--CREATE GROUP POPUP WINDOW END-->
    <!--Change password popup start-->
    <div class="modal fade" id="change-pass" role="dialog">
    
    </div>
    <!--Change password popup end-->