<?php
include_once("db_functions.php");
class registration_details extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"registration_details";
	var $primaryKey			= 	"reg_id";
	var $table_fields	  	=   array('reg_id' => "",'reg_user_name' => "",'reg_pass_word' => "",'reg_private_id' => "",'reg_type' => "",'reg_createdon' => "",'reg_editedon' => "",'reg_last_visit' => "",'last_visit_ip' => "",'reg_login_status' => "",'reg_staff_manage'=>"",'reg_status'=>"");
	function registration_details()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>