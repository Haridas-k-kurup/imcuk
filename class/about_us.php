<?php
include_once("db_functions.php");
class about_us extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"about_us";
	var $primaryKey			= 	"about_id";
	var $table_fields	  	=   array('about_id' => "",'about_head' => "",'about_us' => "",'about_date' => "",'about_status' => "");
	function about_us()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>