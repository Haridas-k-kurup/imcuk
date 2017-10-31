<?php
include_once("db_functions.php");
class admin_security extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"admin_security";
	var $primaryKey			= 	"secur_id";
	var $table_fields	  	=   array('secur_id' => "",'admin_id' => "",'secur_dtil' => "");
	function admin_security()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>