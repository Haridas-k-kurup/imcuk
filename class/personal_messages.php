<?php
include_once("db_functions.php");
class personal_messages extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"personal_messages";
	var $primaryKey			= 	"msg_id";
	var $table_fields	  	=   array('msg_id' => "",'msg_from' => "",'msg_to' => "",'msg_subject' => "",'msg_body' => "",'msg_attachment' => "",'msg_created_on' => "",'from_status' => "",'to_status' => "",'msg_status' => "");
	function personal_messages()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>