<?php 
include_once('PHPMailer-master/class.phpmailer.php');
$email 			  =  new PHPMailer();
$bodytext		  = "Hello world php mailer is testing here";
$email->From      = 'haridasukp@gmail.com';
$email->FromName  = 'Haridas K Kurup';
$email->Subject   = 'Mail Testing';
$email->Body      = $bodytext;
$email->AddAddress( 'haridasukp@gmail.com' );

// $file_to_attach = $_SERVER['DOCUMENT_ROOT'].'/imc/phpmailer/';

$email->AddAttachment('img11.jpg' );
$email->AddAttachment('img11.jpg' );
$email->IsHTML(true);

return $email->Send();

 ?>
<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>