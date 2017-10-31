<?php
include_once("db_functions.php");
class group_messages extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"group_messages";
	var $primaryKey			= 	"gmsg_id";
	var $table_fields	  	=   array('gmsg_id' => "",'gmsg_from' => "",'group_id' => "",'gmsg_subject' => "",'gmsg_body' => "",'gmsg_attachment' => "",'gmsg_created_on' => "",'gmsg_status' => "");
	function group_messages()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>