<?php
include_once("db_functions.php");
class user_details extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"user_details";
	var $primaryKey			= 	"ud_id";
	var $table_fields	  	=   array('ud_id' => "",'reg_id' =>	"",'ud_name_title' => "",'ud_first_name' => "",'ud_second_name' => "",'ud_gender'=> "",'ud_country' => "",'ud_state' => "",'ud_city' => "",'ud_town' => "",'ud_place' => "",'ud_street_name'=>"",'ud_house_name'=>"",'ud_post_code'=>"",'cur_country'=>"", 'cur_state' => "", 'cur_city' => "", 'cur_town' => "", 'cur_place' => "", 'cur_street_name' => "", 'cur_house_name' => "",'cur_post_code' =>"",  'ud_dob' => "", 'ud_age' => "", 'ud_email'=>"",'ud_facebook'=>"",'ud_other_id'=>"",'ud_tel_home'=>"",'ud_tel_work'=>"",'ud_tel_mob'=>"",'ud_pofile_pic'=>"",'reg_other_info'=>"");
	function user_details()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>