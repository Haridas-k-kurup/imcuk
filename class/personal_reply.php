<?php
include_once("db_functions.php");
class personal_reply extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"personal_reply";
	var $primaryKey			= 	"preply_id";
	var $table_fields	  	=   array('preply_id' => "",'msg_id' => "",'preply_from' => "",'preply_body' => "",'preply_attachment' => "",'preply_created_on' => "",'preply_status' => "");
	function personal_reply()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>