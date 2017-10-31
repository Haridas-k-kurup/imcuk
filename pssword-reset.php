<?php
ob_start();
session_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past 
date_default_timezone_set("asia/kolkata");
include_once('includes/site_root.php');
include_once(DIR_ROOT."includes/action_functions.php");
$notfn				=	new notification_types();
$objCommon			=	new common_functions();
?>
<!DOCTYPE html >
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Password Change | IMC</title>
<link rel="icon" href="<?php echo SITE_ROOT; ?>images/object956289543.png" media="screen">
<link rel="stylesheet" href="css/bootstrap.css">
<script type="text/javascript" language="javascript" src="js/bootstrap.js"></script>
<style>
body.mail-body{
	background:#2a3753 url("img/password.jpg") no-repeat fixed center center / 100% 100%;
}
#email-block{
	margin-top: 7%;
    padding-bottom: 25px;
    padding-top: 75px;
}
.col-md-offset-4 {
    margin-left: 33.3333%;
}
.flipInY {
    animation-name: flipInY;
    backface-visibility: visible !important;
}
.animated {
    animation-duration: 1s;
    animation-fill-mode: both;
}
.login-box {
    background: rgba(0, 0, 0, 0) url("img/loginHeaderBg.png") repeat scroll 0 0 !important;
    border-radius: 3px;
    margin-top: 80px;
    max-width: 480px;
    padding-bottom: 20px;
    position: relative;
}
.login-logo {
    text-align: center;
}
hr {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: #eee -moz-use-text-color -moz-use-text-color;
    border-image: none;
    border-style: solid none none;
    border-width: 1px 0 0;
    margin-bottom: 20px;
    margin-top: 20px;
}
.login-box .page-icon {
    animation-delay: 0.8s;
}
.bounceInDown {
    animation-name: bounceInDown;
}
.page-icon {
    background: #12181f none repeat scroll 0 0;
    border-radius: 100px;
    height: 100px;
    margin: -60px auto 0;
    text-align: center;
    width: 100px;
}
.login-form{
	text-align:center;
}
.email-head{
	font-size:20px;
	font-weight:bold;
	color:#fff;
}
.btn.btn-login {
    background: #12181f none repeat scroll 0 0;
    border: 1px solid rgba(0, 0, 0, 0);
    color: #fff;
    display: block;
    margin: 20px auto;
    text-transform: uppercase;
    transition: all 0.5s ease-in-out 0s;
    width: 120px;
}
.btn.btn-login:hover{
	border:1px solid #fff;
	opacity:0.8;
}
.email-field{
	margin-top:3%;
}
</style>
</head>

<body class="mail-body">
<div id="email-block" class="container">
	<?php echo $notific	= $notfn->msg(); ?>
	<div class="row">
    	<div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
        	<div class="login-box loginBox clearfix animated flipInY">
            	<div class="page-icon animated bounceInDown">
                	<img alt="Key icon" src="images/object956289543.png" class="">
                </div>
            	<div class="login-logo">
                </div>
                <hr>
                <div class="login-form">
                	<label class="email-head">Forgot your password / username</label><br>
                    <span for="email">Let’s find your account</span><br>
                    <form method="post" action="<?php echo SITE_ROOT; ?>reset_action.php">
                        <input type="email" id="email" required class="input-field form-control email-field" placeholder="Email address" name="account">
                        <button class="btn btn-login login-btn" type="submit">Continue</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>