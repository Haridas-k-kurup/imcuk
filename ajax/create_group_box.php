<?php 
session_start();
include_once('../includes/site_root.php');
include_once(DIR_ROOT."includes/session_check.php"); 
include_once(DIR_ROOT."class/registration_details.php");
$objReg				=	new registration_details();
$userQuery			=	"select reg.*, user.ud_name_title, user.ud_first_name, user.ud_country, user.ud_pofile_pic from registration_details as reg left join user_details as user on reg.reg_id = user.reg_id left join user_professionals_details as prof on reg.reg_id = prof.reg_id left join user_organizations_details as org on reg.reg_id = org.reg_id left join user_patient_details as pat on reg.reg_id = pat.reg_id where reg.reg_status = 1";
$userData			=	$objReg->listQuery($userQuery);
?>
<script src="<?php echo SITE_ROOT; ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo SITE_ROOT; ?>select_box/src/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="<?php echo SITE_ROOT; ?>select_box/styles/token-input.css" type="text/css" />
    <form method="post" action="action.php?act=gpadd" enctype="multipart/form-data">  
    <div style="border:8px double #000066; border-radius:10px;">
        
        <div class="modal-body">
        <div class="row">
        <div class="col-lg-4 labletext1">Group Name</div>
        <div class="col-lg-8" style="padding:0"><input type="text" style="width:100%" placeholder="Enter Group Name" class="form-control" name="ggName" required></div>
        </div>
        <br />
        <div class="row">
        <div class="col-lg-4 labletext1">Add Member</div>
        <div class="col-lg-8" style="border:1px solid #ccc; max-height:100px; overflow-x:none; overflow-y:scroll;">
        <input type="hidden" name="gn[]" value="<?php echo $activeMem; ?>" />
        <input type="text" id="demo-input-local-custom-formatters" class="grup-details form-control" name="blah" />
        <script type="text/javascript">
        $(document).ready(function() {
            $("#demo-input-local-custom-formatters").tokenInput([
			
				<?php  foreach($userData as $users){ 
					if($users['ud_name_title']){
						$name		=	$users['ud_name_title'].": ".$users['ud_first_name'];
					}else{
						$name		=	$users['ud_first_name'];
						}
						$country	=	$users['ud_country'];
						$profPic	=	DIR_ROOT."profiles/".stripslashes($users['ud_pofile_pic']);
					if(file_exists($profPic)){	
                	 $pic			=	SITE_ROOT."profiles/".stripslashes($users['ud_pofile_pic']);
                    }else{ 
					$pic			=	SITE_ROOT."images/profile.jpg";
                    }
					$regId			=	$users['reg_id'];
					?>
					
			{
                "first_name": "<?php echo $name; ?>",
                "country": "<?php echo $country; ?>",
                "url": "<?php echo $pic; ?>",
				"info": "<?php echo $regId; ?>"
            },
			<?php } ?>
          ], {
              propertyToSearch: "first_name",
              resultsFormatter: function(item){ return "<li>" + "<img src='" + item.url + "' title='" + item.first_name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.first_name + "</div><div class='email'>" + item.country + "</div></div></li>" },
              tokenFormatter: function(item) { return '<li><p>' + item.first_name+ '</p><input type="hidden" name="gn[]" value='+item.info+' /></li>' },
          });
        });
        </script>
        </div>
        </div>
        
        </div>
        
        
        <div class="popup-btn_wrap" align="center">
  		<button class="popup-button" data-dismiss="modal" name="submit" type="submit">Save</button>
        <button id="create-group-close" data-dismiss="modal" class="popup-button" name="submit" type="submit">Close</button>
</div>
      </div>
   </form>
   <script type="text/javascript" language="javascript">
$('#create-group-close').click(function(){
		$('.pro-second-wrap').remove();
		$('.pro-popup').hide();
		$('.popup_wrapper').hide();
	});
</script>