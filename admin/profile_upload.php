<?php
session_start();
//include_once("class/common_class.php");
//include_once("class/attachments.php");
//$objCommon		=	new common();
//$objAttachments	=	new attachments();
include_once('../includes/site_root.php');
$path 			= 	"profile/";
$adPath			=	SITE_ROOT."admin/profile/";
$valid_formats 	= 	array("jpg","JPG", "png", "gif", "bmp", "jpeg");
$name 			= 	$_FILES['staff_attachement']['name'];
$size 			= 	$_FILES['staff_attachement']['size'];
$fileName		=	$_REQUEST['filename'];
if(strlen($name)){
	list($txt, $ext) = explode(".", $name);
	if(in_array($ext,$valid_formats)){
		$actual_image_name 	= 	time().substr($txt, 5).".".$ext;
		$tmp 				= 	$_FILES['staff_attachement']['tmp_name'];
		$imagename 			= 	$path."".$actual_image_name;
		if(move_uploaded_file($tmp, $path.$actual_image_name)){
			$fileArray		=	array("attachment"=>$fileName,"filename"=>$actual_image_name);
			$_SESSION['attachment'][]	=	$fileArray;
			$result			=	'<input type="hidden" name="staff_image" value="'.$actual_image_name.'"><div class="profile_preview ovr" style="width:20%;margin:0 auto; text-align:center;"><h4>Profile Image</h4><br/><img src="'.$adPath.$actual_image_name.'" width="100%" height="112px" title="'.$actual_image_name.'"></div>';
						echo $result;
						
		}
	}				
}
?>
