<?php
include_once("db_functions.php");
class contact_us_type extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"contact_us_type";
	var $primaryKey			= 	"contact_type_id";
	var $table_fields	  	=   array('contact_type_id' => "",'contact_type_name' => "",'contact_type_status' => "");
	function contact_us_type()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>