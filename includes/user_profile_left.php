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