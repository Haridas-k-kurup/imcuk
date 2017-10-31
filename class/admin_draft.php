<?php
include_once("db_functions.php");
class admin_draft extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"admin_draft";
	var $primaryKey			= 	"draft_id";
	var $table_fields	  	=   array('draft_id' => "",'draft_from' => "",'draft_to' => "",'draft_subject' => "",'draft_body' => "",'draft_created' => "",'draft_status' => "");
	function admin_draft()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>