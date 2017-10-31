<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../ckeditor/ckfinder.js"></script>
<style>

.overlay {
background-color: rgba(0, 0, 0, 0.6);
bottom: 0;
cursor: default;
left: 0;
opacity: 0;
position: fixed;
right: 0;
top: 0;
visibility: hidden;
display:none;
z-index: 1;
-webkit-transition: opacity .5s;
-moz-transition: opacity .5s;
-ms-transition: opacity .5s;
-o-transition: opacity .5s;
transition: opacity .5s;
}
.overlay:target {
visibility: visible;
opacity: 1;
display:block;
}
.popup {
background-color: #fff;
border: 3px solid #fff;
display: inline-block;
left: 50%; color:#666;
opacity: 0;
padding: 15px;
position: fixed;
text-align: justify;
top: 40%;
visibility: hidden;
z-index: 10;
-webkit-transform: translate(-50%, -50%);
-moz-transform: translate(-50%, -50%);
-ms-transform: translate(-50%, -50%);
-o-transform: translate(-50%, -50%);
transform: translate(-50%, -50%);
-webkit-border-radius: 10px;
-moz-border-radius: 10px;
-ms-border-radius: 10px;
-o-border-radius: 10px;
border-radius: 10px;
-webkit-box-shadow: 0 1px 1px 2px rgba(0, 0, 0, 0.4) inset;
-moz-box-shadow: 0 1px 1px 2px rgba(0, 0, 0, 0.4) inset;
-ms-box-shadow: 0 1px 1px 2px rgba(0, 0, 0, 0.4) inset;
-o-box-shadow: 0 1px 1px 2px rgba(0, 0, 0, 0.4) inset;
box-shadow: 0 1px 1px 2px rgba(0, 0, 0, 0.4) inset;
-webkit-transition: opacity .5s, top .5s;
-moz-transition: opacity .5s, top .5s;
-ms-transition: opacity .5s, top .5s;
-o-transition: opacity .5s, top .5s;
transition: opacity .5s, top .5s;
width:60%;
}
.overlay:target+.popup {
top: 50%;
opacity: 1;
visibility: visible;
}
.close {
background-color: rgba(0, 0, 0, 0.8);
height: 30px;
line-height: 30px;
position: absolute;
right: 0;
text-align: center;
text-decoration: none;
top: -15px;
width: 30px;
-webkit-border-radius: 15px;
-moz-border-radius: 15px;
-ms-border-radius: 15px;
-o-border-radius: 15px;
border-radius: 15px;
}
.close:before {
color: rgba(255, 255, 255, 0.9);
content: "X";
font-size: 24px;
text-shadow: 0 -1px rgba(0, 0, 0, 0.9);
}
.close:hover {
background-color: rgba(64, 128, 128, 0.8);
}
.popup p, .popup div {
margin-bottom: 10px;
}
.popup label {
display: inline-block;
text-align: left;
width: 180px;
}


.replay_editor{
	width:100%;
	overflow:hidden;
}
.forum_post_replay_btn{
	background-color: #101F5B;
    border-radius: 15px;
    color: #FFFFFF;
    font-weight: bold;
    height: 36px;
    width: 100px;
	cursor:pointer;
}
.forum_post_replay_btn:hover{
	background-color: #3551C0;
}
.fr{
	float:right;
}
.fr img{
	opacity:0.70;
	cursor:pointer;
}
.fr img:hover{
	opacity:1;
	transition:all 1s;
}
</style>
<!-- panel with buttons -->
<div class="main">
<div class="panel">
<a href="#login_form" id="login_pop">Log In</a>
<a href="#join_form" id="join_pop">Sign Up</a>
</div>
</div>
<!-- popup form #1 -->
<a href="#x" class="overlay" id="login_form"></a>
<div class="popup">
<div class="replay_wrapper">
    	
    	<form action="" method="post" enctype="multipart/form-data">
            <table width="100%">
                <tr>
                    <td>
                    	<div class="replay_editor">
                        	<textarea id="editor1" name="text"  class=" clear ckeditor admin_add_content_textarea" placeholder="Write here..." ></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                	<table width="40%" style="margin:0 auto">
                    	<tr>
                        	<td style="text-align:center;"><input type="submit" name="forum_post_replay" value="SUBMIT" class="forum_post_replay_btn"></td>
                            <td style="text-align:center;"><input type="button" name="forum_post_preview" value="PREVIEW" class="forum_post_replay_btn"></td>
                        </tr>
                    </table>
                </tr>
            </table>
        </form>
    </div>
<a class="close" href="#close"></a>
</div>

