<?php
include_once("db_functions.php");
class state_details extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"state_details";
	var $primaryKey			= 	"state_id";
	var $table_fields	  	=   array('state_id' => "",'country_id' => "",'state_name' => "",'state_capital' => "",'state_status' => "");
	function state_details()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>