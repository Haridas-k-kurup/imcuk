<?php
include_once("db_functions.php");
class user_organizations_details extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"user_organizations_details";
	var $primaryKey			= 	"uo_id";
	var $table_fields	  	=   array('uo_id' => "",'reg_id' => "",'uo_collage_addr' => "",'uo_hospital_addr' => "",'uo_company_addr'=>"",'uo_other_addr'=>"");
	function user_organizations_details()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>