<?php
include_once("db_functions.php");
class personal_msg_draft extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"personal_msg_draft";
	var $primaryKey			= 	"personal_draft_id";
	var $table_fields	  	=   array('personal_draft_id' => "",'personal_draft_from' => "",'personal_draft_to' => "",'personal_draft_subject' => "",'personal_draft_body' => "",'personal_draft_attachment' => "",'personal_draft_date' => "",'personal_draft_status' => "");
	function personal_msg_draft()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>