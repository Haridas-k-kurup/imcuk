<?php
include_once("db_functions.php");
class admin_mailbox extends db_functions{
	var $todays_date;
	var $tablename			= 	"admin_mailbox";
	var $primaryKey			= 	"mail_id";
	var $table_fields	  	=   array('mail_id' => "",'mail_from' => "",'mail_to' => "",'mail_subject' => "",'mail_body' => "",'mail_created' => "",'mail_edited' => "",'mail_from_read' => "", 'mail_to_read' => "", 'mail_from_del' => "", 'mail_to_del' => "", 'mail_status' => "");
	function admin_mailbox()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields); 	
	}	
}
?>