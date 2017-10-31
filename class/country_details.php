<?php
include_once("db_functions.php");
class country_details extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"country_details";
	var $primaryKey			= 	"country_id";
	var $table_fields	  	=   array('country_id' => "",'country_name' => "",'country_capital' => "",'country_status' => "");
	function country_details()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>