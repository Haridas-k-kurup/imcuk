<?php
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

$path = "profiles/";
$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","JPG", "PNG", "GIF", "BMP","JPEG");
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
$name = $_FILES['attachement']['name'];
$size = $_FILES['attachement']['size'];
if(strlen($name))
{
list($txt, $ext) = explode(".", $name);
if(in_array($ext,$valid_formats))
{
if($size<(3072*10240)) // Image size max 1 MB
{
$actual_image_name = time().substr($txt, 5).".".$ext;
//$actual_image_name =$name;
$tmp = $_FILES['attachement']['tmp_name'];
if(!file_exists($path."thumb")){
	mkdir($path."thumb");
}
if(!file_exists($path."small-thumb")){
	mkdir($path."small-thumb");
}
if(!file_exists($path."file100")){
	mkdir($path."file100");
}

addIMG($_FILES['attachement'],$path."thumb/",$actual_image_name,190,90,true);
addIMG($_FILES['attachement'],$path."small-thumb/",$actual_image_name,40,30,true);
addIMG($_FILES['attachement'],$path."file100/",$actual_image_name,100,100,true);
if(addIMG($_FILES['attachement'],$path,$actual_image_name,419,393,true))
{
//echo '<font color="#00351A">Successfully Uploaded</font>';
 echo '<input type="hidden" name="ud_pofile_pic" value="'.$actual_image_name.'"><td style="text-align:right;"><div class="profile_preview ovr"><img src="'.$path."file100/".$actual_image_name.'" title="'.$actual_image_name.'"></div>'; 

$imgSize	= $size;

}
else
echo '<font color="#CC0000">failed</font>';
}
else
echo '<font color="#CC0000">Image file size max 1 MB</font>'; 
}
else
echo '<font color="#CC0000">Invalid file format..</font>'; 
}
else
echo '<font color="#CC0000">Please select image..!</font>';
exit;
}
?>
