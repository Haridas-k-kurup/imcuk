<?php
include_once("db_functions.php");
class user_patient_details extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"user_patient_details";
	var $primaryKey			= 	"upt_id";
	var $table_fields	  	=   array('upt_id' => "",'reg_id' => "",'upt_details' => "",'upt_occupation' => "",'utp_disease' => "",'utp_other' => "");
	function user_patient_details()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>