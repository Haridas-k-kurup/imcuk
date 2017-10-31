<?php
include_once("db_functions.php");
class forum_discussion extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"forum_discussion";
	var $primaryKey			= 	"dis_id";
	var $table_fields	  	=   array('dis_id' => "",'topic_id' => "",'reg_id' => "",'dis_reply_of' => "",'dis_quote' => "",'discussion' => "",'dis_created_on' => "",'dis_edited_on' => "",'dis_ip' => "", 'dis_staff_manage' => "", 'dis_status' => "");
	function forum_discussion()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>