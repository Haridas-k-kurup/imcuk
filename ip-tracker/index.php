<?php 
session_start();
include_once('action_functions.php');
$objAction		= new common_functions();
 ?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IP TRACKERS</title>
<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>
</head>
<body>
	<div style="background:#000; padding:5%; text-align:center;">
    	
        <img src="slid1.jpg"> <br>
        <button id="reg-now" style="background:#090; padding:1%"><b>Register Now</b></button>
    </div>
    
    <?php

$user_agent     = $_SERVER['HTTP_USER_AGENT'];

function getOS() { 

    global $user_agent;

    $os_platform    =   "Unknown OS Platform";

    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }   

    return $os_platform;

}

function getBrowser() {

    global $user_agent;

    $browser        =   "Unknown Browser";

    $browser_array  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/edge/i'       =>  'Edge',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser'
                        );

    foreach ($browser_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }

    }
    return $browser;
}
					$user_os        			=   getOS();
					$user_browser   			=   getBrowser();
					
					$device_details 			=   "<strong>IP Address: </strong>".$objAction->get_ip()."<strong>Browser: </strong>".$user_browser."<br /><strong>Operating System: </strong>".$user_os."";

					$to  						= 	"admin@websoftcreators.com"; // note the comma
			
					// subject
					$subject 					= 	'IP Address of the tracking users';
					// message
					$message					= 	"<table border=\"1\"><tr> <td colspan=\"2\">User details are here</td></tr>";
					$message					.=	"<tr><td>System Details</td><td>".$device_details."</td></tr>";
					$message					.=	"<tr><td>USER AGENT</td><td>".$_SERVER['HTTP_USER_AGENT']."</td></tr>";
					$message					.=	"</table>";
					// To send HTML mail, the Content-type header must be set
					$headers  					= 	'MIME-Version: 1.0' . "\r\n";
					$headers 					.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					
					// Additional headers
					//$headers 					.= 	'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
					$headers 					.= 	'From: international medical connection <admin@websoftcreators.com>' . "\r\n";
					//$headers 					.= 	'Cc: birthdayarchive@example.com' . "\r\n";
					//$headers 					.= 	'Bcc: birthdaycheck@example.com' . "\r\n";
					// Mail it
					mail($to, $subject, $message, $headers);


/*print_r($device_details);
echo "<br><br>";
echo "<b>USER AGENT</b><br>"; 
echo("<br />".$_SERVER['HTTP_USER_AGENT']."");*/

?>
<script type="text/javascript" language="javascript">
$(function(){
		$('#reg-now').click(function() {alert("Oops ! something went wrong. Try again later");});
	});
</script>
</body>
</html>