<?php
include_once("db_functions.php");
class imc_message extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"imc_message";
	var $primaryKey			= 	"message_id";
	var $table_fields	  	=   array('message_id' => "",'message_code' => "",'message' => "",'created_at' => "",'message_status' => "");
	function imc_message() {
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>