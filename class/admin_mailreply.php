<?php
include_once("db_functions.php");
class admin_mailreply extends db_functions{
	var $todays_date;
	var $tablename			= 	"admin_mailreply";
	var $primaryKey			= 	"reply_id";
	var $table_fields	  	=   array('reply_id' => "",'mail_id' => "",'reply_from' => "",'reply_body' => "",'reply_date' => "",'reply_from_del' => "",'reply_to_del' => "",'reply_status' => "");
	function admin_mailreply()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields); 	
	}	
}
?>