<?php 
	class connect
	{	
		var $dbconnect  		=	NULL;
		//var $dbhost     		= 	"imcuk.db.11537888.hostedresource.com";
		var $dbhost     		= 	"localhost";
		
		############## Local ##############
		var $dbname				=	"imcuk";
		var $dbusername 		= 	"root";
		var $dbuserpass			= 	"";
		############## Online ##############
		var $query     		 	= 	NULL;
		function db_connect()
		{	
			global $dbconnect;
			if (!$dbconnect)                          // SQL Connect
			{
				$dbconnect 		= 	mysql_connect($this->dbhost, $this->dbusername, $this->dbuserpass);
				//mysql_set_charset("UTF8", $dbconnect);
			}
			if (!$dbconnect) 
			{
				return 0;
			}
			elseif (!mysql_select_db($this->dbname))       //Connect to database  
			{
				return 0;
			} 
			else
			{
				return $dbconnect;
			} // if
		} // db_connect
	}
?>
