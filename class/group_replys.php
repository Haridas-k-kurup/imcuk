<?php
include_once("db_functions.php");
class group_replys extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"group_replys";
	var $primaryKey			= 	"greply_id";
	var $table_fields	  	=   array('greply_id' => "",'gmsg_id' => "",'greply_from' => "",'greply_body' => "",'greply_attachment' => "",'greply_created_on' => "",'greply_status' => "");
	function group_replys()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>