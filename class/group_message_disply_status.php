<?php
include_once("db_functions.php");
class group_message_disply_status extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"group_message_disply_status";
	var $primaryKey			= 	"group_display_id";
	var $table_fields	  	=   array('group_display_id' => "",'group_m_id' => "",'gmsg_id' => "");
	function group_message_disply_status()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>