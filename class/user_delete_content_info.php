<?php
include_once("db_functions.php");
class user_delete_content_info extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"user_delete_content_info";
	var $primaryKey			= 	"entity_id";
	var $table_fields	  	=   array('entity_id' => "",'user_id' => "",'heading'=>"", 'link' => "", 'status' => "");
	function user_delete_content_info()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>