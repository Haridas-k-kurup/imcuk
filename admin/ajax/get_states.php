<?php 
include_once('../../includes/site_root.php');
include_once(DIR_ROOT."includes/action_functions.php");
include_once(DIR_ROOT."class/state_details.php");
$objCommon		=	new common_functions();
$objState		=	new state_details();
$countryId		=	$objCommon->esc($_POST['country']);
$getState		=	$objState->getAll('country_id = "'.$countryId.'"  and state_status = 1', 'state_name');	
?>
<option value="">------------------------------------ Select State ------------------------------------</option>
<?php foreach($getState as $state){ ?>
	<option value="<?php echo $state['state_id']; ?>"><?php echo $state['state_name']; ?></option>
<?php } ?>