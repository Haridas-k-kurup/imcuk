<?php
include_once("db_functions.php");
class reset_password extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"reset_password";
	var $primaryKey			= 	"reset_id";
	var $table_fields	  	=   array('reset_id' => "",'reg_id' =>	"",'reset_code' => "",'reset_date' => "",'reset_status' => "");
	function reset_password()
	{
		$this->todays_date 	= 	date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>