<?php 
include_once('../../includes/site_root.php');
include_once(DIR_ROOT."includes/action_functions.php");
include_once(DIR_ROOT."class/city_details.php");
$objCommon		=	new common_functions();
$objCity		=	new city_details();

if(isset($_POST['dataId'])){
$stateId		=	$objCommon->esc($_POST['dataId']);
$getCity		=	$objCity->getAll('state_id  = "'.$stateId.'" and city_status = 1', 'city_name');	
?>
<option value="">--------- City ---------</option>
<?php foreach($getCity as $city){ ?>
	<option data-id="<?php echo $city['city_id']; ?>" value="<?php echo $city['city_name']; ?>"><?php echo $city['city_name']; ?></option>
<?php } }else if(isset($_POST['countyId'])){
	
$countryId		=	$objCommon->esc($_POST['countyId']);
$getCity		=	$objCity->getAll('country_id  = "'.$countryId.'" and city_status = 1', 'city_name');	
	?>
<option value="">--------- City ---------</option>
<?php foreach($getCity as $city){ ?>
	<option data-id="<?php echo $city['city_id']; ?>" value="<?php echo $city['city_name']; ?>"><?php echo $city['city_name']; ?></option>

<?php } } ?>