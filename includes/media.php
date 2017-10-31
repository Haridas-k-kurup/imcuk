<?php 
$imgDir					=		"uploades/";
$imgSit					=		"uploades/";
$directory			    =       $imgDir;

if(isset($_GET['deleteimg']))
				{
					$delImg		=	$_GET['deleteimg'];
					$fname		=	$imgDir.$delImg;	
					unlink($fname);
				}
?>
<link rel="stylesheet" href="css/font-awesome.min.css" />
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<style>
li
	{
		list-style:none;
	}
a
	{
		text-decoration:none;
		
	}
.clear
	{
	clear:both;
	}
.ovr{
	overflow:hidden;
}
.click_div {
		background: none repeat scroll 0 0 #333333;
		height: 100%;
		opacity: 0.69;
		position: fixed;
		top: 0;
		width: 100%;
		z-index: 1010;
		display:none;
}
.media_wrapper {
	background: none repeat scroll 0 0 #F7F7F7;
	display: none;
	height: 95%;
	left: 0px;
    margin: 0 auto;
    overflow: hidden;
    position: relative;
     top: -419px;
    width: 95%;
    z-index: 1094;
}
.media_wrapper  a{
		color:#0074A2;
}
.fl{
		float:left;
}
.fr{
		float:right;
}
.media_wrapper h1,h2{
		font-size: 22px;
		line-height: 60px;
		margin: 0;
		padding: 0 16px;
		font-family: "Open Sans",sans-serif;
  		color: #666666;
}

.media_left {
		background: none repeat scroll 0 0 #F3F3F3;
		border-right: 1px solid #DDDDDD;
		height: 100%;
		width: 15%;
}
.media_right{
		height: 100%;
    	width:100%;
		
}
	
.tab_menu{
		height: 45px;
		width: 100%;
}
.tab_menu li { 
		background: none repeat scroll 0 0 #FFFFFF;
    	border-bottom-color: #fff;
		border:1px solid #ddd;
		margin-left:2px;
		border-radius:5px;
		width: 125px;
		padding: 5px;
}
.tab_contant {
	background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #DDDDDD;
    display: none;
    height: 90%;
    margin: 0 auto;
    width: 95%;
}
.media_save{  
	    background: none repeat scroll 0 0 #298CBA !important;
		border: medium none;
		border-radius: 5px;
		cursor: pointer;
		margin: 0 25%;
		padding: 4%;
		text-align: center;
}
.media-submit{
		
}
.media_side_list{
		margin-bottom:25px;
}
#media_browse{
		width: 50px;
		height: 50px;
		background-image:url(img/file1.png);
		border:none;
		overflow:hidden;
		margin:5px auto;		
}

#file_browse {
		opacity: 0;
		height:50px;
}
.media_head {
    height: 15%;
}
.media_upload_details{
		height: 50%;
		margin: 10% auto;
		text-align: center;
		width: 50%;
}
.media_second_tab{
		width:100%;
		height:100%;
}
.media_second_tab_right{
	height: 88%;
    margin-top: 35px;
    width: 77%;
}
.media_second_tab_left{
		width:22%;
		background:#F3F3F3;
		height:100%;
}
.media_second_tab_toolbar
	{
		height:20%;
	}
media_second_tab_toolbar_second{
		height: 100%;
    	margin: 0 15px;
}
.media_second_tab_toolbar_drop{
	 	margin-right: 10px;
    	margin-top: 11px;
}
.media_second_tab_toolbar_search{
		margin-top: 11px;
		padding-right:20px;
}
.media_attachments{
		margin: 0 12px 12px 0;
}
.media_attachments_div{
		height: 110px;
    	width: 110px;
		background: none repeat scroll 0 0 #EEEEEE;
		box-shadow: 0 0 15px rgba(0, 0, 0, 0.1) inset, 0 0 0 1px rgba(0, 0, 0, 0.05) inset;
		cursor: pointer;
		position: relative;
		-moz-user-select: none;
		border: 1px solid #DDDDDD;
		padding: 6px;
}
.media_attachments_div2{
		bottom: 0;
    	box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1) inset;
    	content: "";
    	display: block;
    	overflow: hidden;
		width:95%;
		margin:0 auto;
    	
}
.media_attachments_div2:after{
    	box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1) inset;
    	content: "";
    	display: block;
    	overflow: hidden;
    	position: absolute;
}

.centered{
		height: 100%;
		width: 100%;
}
.media_second_tab_left_contant{
    	height: 100%;
		margin: 0 5px;
		width: 95%;
}
.media_second_tab_left_contant h3{
		color: #666666;
		font-size: 12px;
		font-weight: 700;
		margin: 24px 0 8px;
		position: relative;
		text-transform: uppercase;
}
.media_second_tab_left_contant_info{
		border-bottom: 1px solid #CCCCCC;
		box-shadow: 0 1px 0 #FFFFFF;
		color: #666666;
		line-height: 18px;
		margin: 0 auto;
		min-height: 60px;
		overflow: hidden;
		padding-bottom: 11px;
		width: 99%;
}
.media_second_tab_left_contant_img{
		
		max-width: 50%;
		position: relative;
}

.media_second_tab_left_contant_img_details{
		 font-size: 12px;
    	 width: 35%;
		 margin-right: 25px;
}
.media_second_tab_left_contant_img_details h4{
	margin-top:0;
}
.delete_attachment {
		color: #BC0B0B !important;
}
.all_attachments{
	height: 100%; 
}
.all_attachments:hover{
	overflow-x: hidden;
    overflow-y: scroll;
}
.img_border {
        background: none repeat scroll 0 0 #0088CC;
}
#media_tabs{
	height: 85%;
}

.search {
    width: 50%;
}
.close
{
	padding-right: 36px;
    width: 4%;
}
.close i.fa{
	color: #666666;
    font-size: 20px;
	cursor: pointer;
}
.close i.fa:hover{
	color: #0088CC;
}
.data_table {
    margin: 208px 0 57px;
}
.data_table table tr td{
	color:#666;
	font-size:14px;
	font-weight:700;
}
.data_table input {
    width: 95%;
}
.see{
display:block;
}
.see2{
	display:block;
}
</style>

<div class="click_div"></div>
<div class="media_wrapper">
  
    
    <div class="media_right ovr">
    <div class="media_head">
      <h1 style="width:50%;">Image Gallary</h1>
	  <div class="close fr"><i class="fa fa-times" onClick="popClose()" title="close"></i></div>
    </div>
    <div id="media_tabs">
      <div class="tab_menu ovr">
        <ul>
          <li class="fl" id="first_tab" title="Upload Flie"><a href="#tabs-1" class="see" onClick="tabChange(1)">Upload Image</a></li>
          <li class="fl" id="second_tab" title="Media Library"><a class="see2" href="#tabs-2" onClick="tabChange(2)">Image Library</a></li>
        </ul>
      </div>
      <div id="tabs-1" class="tab_contant" style="display:block;">
        <div class="media_upload_details">
          <h2>Drop files anywhere to upload</h2>
          <div id='media_browse'>
		  <form action='ajaximage.php?path=<?php echo $imgDir;?>' method="post" enctype="multipart/form-data" id="media_form">
            <input type='file' id='file_browse' name="file" />
			</form>
          </div>
		  
          <div id='preview'></div>
        </div>
      </div>
      <div id="tabs-2" class="tab_contant">
        <div class="media_second_tab">
          <div class="media_second_tab_right fl">
            <div class="all_attachments ovr">
              <ul id="attachments" class="media_attachments">
              </ul>
            </div>
          </div>
          <div class="media_second_tab_left fr ovr"> </div><div class="clear"></div>
        </div>
      </div>
    <div class="clear"></div>
  
</div>

</div>
<script type="text/javascript">
		var $con	=	jQuery.noConflict();
		
		function clickMe()
			{
				$con('.click_div').show();
				$con('.media_wrapper').slideDown('500');
			}
		function popClose()
			{
				$con('.click_div').hide();
				$con('.media_wrapper').slideUp('500');
			}
		function loadImageDetails(image,val)
			{
				$con(".media_attachments_div").removeClass("img_border");
				$con(val).addClass("img_border");
				$con.get('image_details.php',{image:image},function(imgdetails){
						$con('.media_second_tab_left').html(imgdetails);
					});
			}
			
		$con('#tabs-2').click(function(){
			$con('.media-submit').css("display","block");
		});
		$con('.see').click(function(){
			$con('.media-submit').css("display","none");
			$con('.media_second_tab_left_contant').css("display","none");
			$con(".media_attachments_div").removeClass("img_border");
		});
		$con('.see2').click(function(){
			$con('.media_second_tab_left_contant').css("display","none");
		});
		function tabChange(val){
		$con(".media_attachments_div").removeClass("img_border");
			if(val	==	1)
				{
						$con('#tabs-1').show();
						$con('#tabs-2').hide();
				}
			else
				{
						$con('#tabs-2').show();
						$con('#tabs-1').hide();
				}
			
		}
		
</script>
<script type="text/javascript">
	var $con	=	jQuery.noConflict();
		$con(document).ready(function(){
		imageLoading();
		$con('#media_form').on('change', function(){ 
			$con("#preview").html('');
			$con("#preview").html('<img src="img/720(2).GIF" alt="Uploading...."/>');
			$con("#media_form").ajaxForm(
			{
				target: '#preview'
				
			}).submit();
			timeLoad();
			tabChange(2);
		});
	}); 
	function timeLoad(){
		$con('.media_attachments').html('<div style="margin:150px 0px; text-align:center;"><img src="img/713.GIF" alt="Uploading...." width="80" height="80"/></div>');
		$con('.media_second_tab_left').html('<div style="margin:210px 0px; text-align:center;"><img src="img/713(1).GIF" alt="Uploading...."/></div>');
		setTimeout(imageLoading,5000);
		$con('.media-submit').css("display","block");
	}
	function imageLoading(){
	$con('.media_second_tab_left_contant').css("display","block");
		var lastImg	= $con('#upload_img_id').val();
		if(lastImg)
			{
			 	loadImageDetails(lastImg);
			}
		else
			{
				$con('.media_second_tab_left_contant').hide();
			}
		$con('.media_attachments').load("imageList.php");
		$con('#upload_img_id').val("");
		}
	
</script>