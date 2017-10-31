<?php
include_once("db_functions.php");
class manage_topic_position extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"manage_topic_position";
	var $primaryKey			= 	"pos_id";
	var $table_fields	  	=   array('pos_id' => "",'pos_name' => "",'pos_status' => "");
	function manage_topic_position()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>