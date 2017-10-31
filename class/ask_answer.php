<?php
include_once("db_functions.php");
class ask_answer extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"ask_answer";
	var $primaryKey			= 	"ask_a_id";
	var $table_fields	  	=   array('ask_a_id' => "",'ask_q_id' => "",'reg_id' => "",'ask_reply_of' => "",'ask_a_discussion' => "", 'ask_a_created' => "", 'ask_a_edited' => "",'ask_a_ip' => "",'ask_a_staff_manage' => "",'ask_a_status' => "");
	function ask_answer(){
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>