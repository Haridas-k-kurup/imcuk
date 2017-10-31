<?php
session_start();
//include_once("class/common_class.php");
//include_once("class/attachments.php");
//$objCommon		=	new common();
//$objAttachments	=	new attachments();

$path 		= 	"../mailattachment/";
$filePath	=	"mailattachment/";	
$valid_formats = array("jpg","JPG", "png", "gif", "bmp", "jpeg","doc","docx");
$name = $_FILES['mailattachment']['name'];
$size = $_FILES['mailattachment']['size'];
$fileName	=	$_REQUEST['filename'];
if(strlen($name)){
	list($txt, $ext) = explode(".", $name);
	if(in_array($ext,$valid_formats)){
		$actual_image_name = time().substr($txt, 5).".".$ext;
		$tmp = $_FILES['mailattachment']['tmp_name'];
		$imagename = $path."".$actual_image_name;
		if(move_uploaded_file($tmp, $path.$actual_image_name)){
			$fileArray	=	array("attachment"=>$fileName,"filename"=>$actual_image_name);
			$_SESSION['attachment'][]	=	$fileArray;
			
			$result	=	'<div class="email-attached-file">
						<input type="hidden" name="mailattached" id="mailattached" value="'.$actual_image_name.'">
						</div>';
			
			/*$result	=	'<input type="hidden" name="pofile_pic" value="'.$actual_image_name.'"><td style="text-align:right;"><div class="profile_preview ovr"><img src="'.$path.$actual_image_name.'" width="100%" height="112px" title="'.$actual_image_name.'"></div>';*/
						echo $result;
						
		}
	}				
}
?>