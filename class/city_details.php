<?php
include_once("db_functions.php");
class city_details extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"city_details";
	var $primaryKey			= 	"city_id";
	var $table_fields	  	=   array('city_id' => "",'country_id' => "",'state_id' => "",'city_name' => "",'city_status' => "");
	function city_details()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>