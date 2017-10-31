<?php
include_once("db_functions.php");
class contact_us_form extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"contact_us_form";
	var $primaryKey			= 	"contact_id";
	var $table_fields	  	=   array('contact_id' => "",'contact_name' => "",'reg_id'=>"", 'topic_type' => "", 'topic_id' => "", 'contact_email' => "",'contact_ip' => "",'contact_type_id' => "",'contact_subject' => "",'contact_message' => "",'contact_created' => "", 'read_status' => "", 'reply_status' => "",'staff_delete' =>"",'contact_status' => "");
	function contact_us_form()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>