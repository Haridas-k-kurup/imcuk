<?php
include_once("db_functions.php");
class user_professionals_details extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"user_professionals_details";
	var $primaryKey			= 	"up_id";
	var $table_fields	  	=   array('up_id' => "",'reg_id' => "",'up_student_course' => "",'up_profession_type' => "", 'up_profession_name' => "",'up_profession_speciality' => "",'up_profession_sup_speciality' => "",'up_profession_grade' => "",'up_profession_hosp_addr'=>"",'up_profession_med_addr'=>"",'up_profession_company_name'=>"",'up_profession_acheive'=>"");
	function user_professionals_details()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>