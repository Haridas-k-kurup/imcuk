<?php
include_once("db_functions.php");
class manage_pages extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"manage_pages";
	var $primaryKey			= 	"mp_id";
	var $table_fields	  	=   array('mp_id' => "",'pos_id' => "",'mp_heading' => "",'mp_alias' => "",'mp_desc' => "",'mp_createdon' => "",'mp_ip' => "", 'mp_staff_manage' => "", 'mp_status' => "");
	function manage_pages()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields); 	
	}	
}
?>