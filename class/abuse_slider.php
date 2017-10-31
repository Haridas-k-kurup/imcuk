<?php
include_once("db_functions.php");
class abuse_slider extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"abuse_slider";
	var $primaryKey			= 	"abuse_id";
	var $table_fields	  	=   array('abuse_id' => "",'reg_id' => "", 'mp_id' => "",'abuse' => "",'abuse_ip' => "",'abuse_read_status' => "", 'abuse_date' => "",  'abuse_status' => "");
	function abuse_slider(){
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>