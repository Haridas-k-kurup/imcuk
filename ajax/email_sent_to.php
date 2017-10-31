<?php 
session_start();
include_once('../includes/site_root.php');
include_once(DIR_ROOT."includes/session_check.php"); 
include_once(DIR_ROOT."class/registration_details.php");
include_once(DIR_ROOT."class/group_info.php");
$objReg				=	new registration_details();
$objGroup			=	new group_info();
$sendType			=	$_POST['type'];
if($sendType == 1 || $sendType == 2){
	if($sendType == 1){
$userQuery			=	"select reg.*, user.ud_name_title, user.ud_first_name, user.ud_country, user.ud_pofile_pic from registration_details as reg left join user_details as user on reg.reg_id = user.reg_id left join user_professionals_details as prof on reg.reg_id = prof.reg_id left join user_organizations_details as org on reg.reg_id = org.reg_id left join user_patient_details as pat on reg.reg_id = pat.reg_id where reg.reg_status = 1";
$userData			=	$objReg->listQuery($userQuery);
?>
<script src="<?php echo SITE_ROOT; ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo SITE_ROOT; ?>select_box/src/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="<?php echo SITE_ROOT; ?>select_box/styles/token-input.css" type="text/css" />

            
              
       <div class="member-box" style="margin:0; height:50px;">
        <input type="hidden" name="gn[]" value="<?php echo $activeMem; ?>" />
        <input type="text" id="demo-input-local-custom-formatters" class="grup-details" name="persons" placehoder="Recipients" />
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
              tokenFormatter: function(item) { return '<li><p>' + item.first_name+ '</p><input type="hidden" name="details[]" value='+item.info+' /></li>' },
          });
        });
        </script>
        
    </div>
  <?php }else if($sendType == 2){
	  	$listGroupSql		=	"select grp.group_id, grp.group_name from group_members as mem left join group_info as grp on mem.group_id = grp.group_id where mem.reg_id = '".$activeMem."' and grp.group_status = 1 order by group_name";
		$groupData			=	$objGroup->listQuery($listGroupSql);
?>
<script src="<?php echo SITE_ROOT; ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo SITE_ROOT; ?>select_box/src/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="<?php echo SITE_ROOT; ?>select_box/styles/token-input.css" type="text/css" />

            
              
       <div class="member-box" style="margin:0; height:50px;">
        <input type="text" id="demo-input-local-custom-formatters" class="grup-details" name="group" placehoder="Recipients" />
        <script type="text/javascript">
        $(document).ready(function(){
            $("#demo-input-local-custom-formatters").tokenInput([
			
				<?php  foreach($groupData as $users){ 
					if($users['group_id']){
						$name		=	$users['group_name'];
						$groupId	=	$users['group_id'];
						}
					
					?>
					
			{
                "first_name": "<?php echo $name; ?>",
				"info": "<?php echo $groupId; ?>"
            },
			<?php } ?>
          ], {
              propertyToSearch: "first_name",
              resultsFormatter: function(item){ return "<li>" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.first_name + "</div></div></li>" },
              tokenFormatter: function(item) { return '<li><p>' + item.first_name+ '</p><input type="hidden" name="groups[]" value='+item.info+' /></li>' },
          });
        });
        </script>
        
    </div>
	  
<?php	  } } ?>