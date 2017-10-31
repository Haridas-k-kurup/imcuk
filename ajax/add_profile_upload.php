<?php
session_start();
function addIMG($file,$folder,$name,$width,$height,$thump){
	$ret="";
	if(isset($file)){
		$ext=explode(".",$file['name']);
		$ext=(count($ext)!=0)?strtolower($ext[count($ext)-1]):"";
		$path="$folder$name";
		$name="$name";
		if(@copy($file['tmp_name'],$path)){
			$proc=false;
			switch($ext){
				case "jpg": $proc=true; $im=imagecreatefromjpeg($path); break;
				case "jpeg": $proc=true; $im=imagecreatefromjpeg($path); break;
				case "gif": $proc=true; $im=imagecreatefromgif($path); break;
				case "png": $proc=true; $im=imagecreatefrompng($path); break;
			}
			if($proc){
				$ow=imagesx($im);
				$oh=imagesy($im);
				$bow=$ow;
				$boh=$oh;
				$posX=0;
				$posY=0;
				if($ow>$width||$oh>$height){
					if($thump){ 
						$cmp=1; 
						if($oh>$ow){ $cmp = $ow/$width; }
						if($ow>$oh){ $cmp = $oh/$height; }
						if($ow==$oh){ $cmp = $oh/$height; }
						$ow=round($ow/$cmp); 
						$oh=round($oh/$cmp);
						if($ow<$width){
							$cmp = $ow/$width;
							$ow=round($ow/$cmp); 
							$oh=round($oh/$cmp);
						}
						if($oh<$height){
							$cmp = $oh/$height;
							$ow=round($ow/$cmp); 
							$oh=round($oh/$cmp);
						}
					}else{
						$cmp=1; 
						if($ow>$oh){ $cmp = $ow/$width; }
						if($ow<$oh){ $cmp = $oh/$height; }
						if($ow==$oh){ $cmp = $oh/$height; }
						$ow=round($ow/$cmp); 
						$oh=round($oh/$cmp);
					}
					//echo $ow."x".$oh."<br />";
				}
				if($thump){ 
					$posX=round(($width-$ow)/2); 
					$posY=round(($height-$oh)/2); 
				}
				$bow1=$ow; 
				$boh1=$oh; 
				if($thump){ 
					$ow=$width; 
					$oh=$height; 
				}
				$newImg = imagecreatetruecolor($ow,$oh);
				if($ext=="png"){
					imagealphablending($newImg, false);
					imagesavealpha($newImg,true);
					$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
					imagefilledrectangle($newImg, 0, 0, $ow, $oh, $transparent);
				}
				imagecopyresampled($newImg, $im, $posX, $posY, 0, 0 , $bow1, $boh1, $bow, $boh);
				if($ext=="png"){ 
					imagepng($newImg,$path); 
				}else if($ext=="jpg"){ 
					imagejpeg($newImg,$path); 
				}else if($ext=="gif"){ 
					imagegif($newImg,$path); 
				}
				$ret= $name;
			}
		}
	}
	return $ret;
}


$path 		= 	"../profiles/";
$filePath	=	"profiles/";	
$valid_formats = array("jpg","JPG", "png", "gif", "bmp", "jpeg");
$name = $_FILES['attachement']['name'];
$size = $_FILES['attachement']['size'];
$fileName	=	$_REQUEST['filename'];
if(strlen($name)){
	list($txt, $ext) = explode(".", $name);
	if(in_array($ext,$valid_formats)){
		$actual_image_name = time().substr($txt, 5).".".$ext;
		$tmp = $_FILES['attachement']['tmp_name'];
		$imagename = $path."".$actual_image_name;
		if(move_uploaded_file($tmp, $path.$actual_image_name)){
			$fileArray	=	array("attachment"=>$fileName,"filename"=>$actual_image_name);
			$_SESSION['attachment'][]	=	$fileArray;
			
			$result	=	'<div class="photo-confirm-wrap">
						<input type="hidden" name="pofile_pic" id="pofile_pic" value="'.$actual_image_name.'">
						<div class="photo-wrap">
                                    	<img src="'.$filePath.$actual_image_name.'" width="100%" />
                                    </div>
									<div class="photo-confirm_btns text-center">
                                    	<input type="button" value="Cancel" onclick = "return changeFrime();"  class="btn btn-warning prof-cancel-btn" />
                                        <input type="button" value="Save" onclick="return changeProfile();" class="btn btn-success prof-save-btn"/>
                                    </div>
			
			</div>';
			
			
			
			
			/*$result	=	'<input type="hidden" name="pofile_pic" value="'.$actual_image_name.'"><td style="text-align:right;"><div class="profile_preview ovr"><img src="'.$path.$actual_image_name.'" width="100%" height="112px" title="'.$actual_image_name.'"></div>';*/
						echo $result;
						
		}
	}				
}
?>
<script type="text/javascript" language="javascript">
function changeProfile(){
	var img		=	$('#pofile_pic').val();
	var type	=	"changedp";
	if(img){
	var image	=	'type='+type+'&image='+img;
	$.ajax({
			type:"POST",
			url:'ajax_action.php',
			data:image,
			cache:false,
			success:function(data){
					location.reload();
				}
		
		});
	}
}
function changeFrime(){
	$('.change-image_wrap').hide();
	$('.proff-pic-area').show();
	var img		=	$('#pofile_pic').val();
	var type	=	"unlinkdp";
	if(img){
	var image	=	'type='+type+'&unimage='+img;
	$.ajax({
			type:"POST",
			url:'ajax_action.php',
			data:image,
			cache:false,
			success:function(data){
					location.reload();
				}
		
		});
	}
	
}
</script>