<?php
include_once("db_functions.php");
class ask_question extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"ask_question";
	var $primaryKey			= 	"ask_q_id";
	var $table_fields	  	=   array('ask_q_id' => "",'reg_id' => "",'ask_q_heading' => "",'ask_q_message' => "",'ask_q_views' => "", 'ask_q_created' => "", 'ask_q_edited' => "",'ask_q_ip' => "",'ask_q_staff_manage' => "",'ask_q_status' => "");
	function ask_question(){
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>