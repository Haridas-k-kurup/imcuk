<?php
include_once("db_functions.php");
class ask_q_like extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"ask_q_like";
	var $primaryKey			= 	"q_like_id";
	var $table_fields	  	=   array('q_like_id' => "",'ask_q_id' => "",'q_like_ip' => "",'q_like' => "",'q_dislike' => "", 'q_like_status' => "");
	function ask_q_like(){
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>