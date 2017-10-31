<?php
	class notification_types{
		public function notification($rmsg,$n){
			$msg	=	'';
			switch($n){
				case 1:
				$msg	=	"<div class=\"alert alert-info alert-dismissable\"><i class=\"fa fa-info\"></i><button aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\">×</button><p><strong>INFORMATION: </strong>".$rmsg."</p></div>";
				break;
				case 2:
				$msg	=	"<div class=\"alert alert-warning alert-dismissable\"> <i class=\"fa fa-warning\"></i><button aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\">×</button><p><strong>WARNING: </strong>".$rmsg."</p></div>";
				break;
				case 3:
				$msg	=	"<div class=\"alert alert-success alert-dismissable\"> <i class=\"fa fa-check\"></i><button aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\">×</button><p><strong>SUCCESS: </strong>".$rmsg."</p></div>";
				break;
				case 4:
				$msg	=	"<div class=\"alert alert-danger alert-dismissable\"> <i class=\"fa fa-ban\"></i> <button aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\">×</button><p><strong>FAILURE: </strong>".$rmsg."</p></div>";
				break;
				case 5:
				$msg	=	"<div class=\"admin_n_outer admin_notfication admin_notfn_hide\"><p><strong>NOTIFICATION: </strong>".$rmsg."</p></div>";
				break;
			} 
			if(strlen($msg)>0){
				return $msg;
			} else {
				return "Invalid use ";
			}
		}
		public function add_msg($message,$type){
			$messageArray		=	array("msg"=>$message,"type"=>$type);
			$_SESSION["message"]=	$messageArray;
			return $msg;
		}
		public function msg(){
			if(isset($_SESSION['message'])){
				$message	=	$_SESSION['message']["msg"];
				$type		=	$_SESSION['message']["type"];
				$messageBox	=	$this->notification($message,$type);
				unset($_SESSION['message']);
				return $messageBox;
			}
		}
	}
	class common_functions{
			public function esc($s){
				//$s=htmlentities($s);
				//$s=str_replace("'","&#39;",$s);
				$s=mysql_real_escape_string($s);
				return $s;
			}
			public function get_ip() {
				$ipaddress = '';
				if ($_SERVER['HTTP_CLIENT_IP'])
				$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
				else if($_SERVER['HTTP_X_FORWARDED_FOR'])
				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
				else if($_SERVER['HTTP_X_FORWARDED'])
				$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
				else if($_SERVER['HTTP_FORWARDED_FOR'])
				$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
				else if($_SERVER['HTTP_FORWARDED'])
				$ipaddress = $_SERVER['HTTP_FORWARDED'];
				else if($_SERVER['REMOTE_ADDR'])
				$ipaddress = $_SERVER['REMOTE_ADDR'];
				else
				$ipaddress = 'UNKNOWN';
				return $ipaddress;
			}
			public function html2text($s){
				$s		=	stripslashes($s);
				$s		=	html_entity_decode(html_entity_decode($s));
				$s		= str_replace("rn","",$s);
				return $s;
			}
			public function getAlias($alias){
				$alias	=	strtolower($alias);	
				$alias	=	trim($alias);
				$alias	=	preg_replace("/[^a-z0-9]+/", "-", $alias);
				$alias	=	trim($alias,"-");
				return $alias;
			}
	}
?>