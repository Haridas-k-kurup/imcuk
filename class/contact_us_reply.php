<?php
include_once("db_functions.php");
class contact_us_reply extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"contact_us_reply";
	var $primaryKey			= 	"contact_reply_id";
	var $table_fields	  	=   array('contact_reply_id' => "",'contact_id' => "",'contact_reply'=>"",'contact_replyed' => "",'contact_reply_date' => "",'contact_reply_satus' => "");
	function contact_us_reply()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>