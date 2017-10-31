<?php
include_once("db_functions.php");
class manage_page_connection extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"manage_page_connection";
	var $primaryKey			= 	"mpc_id";
	var $table_fields	  	=   array('mpc_id' => "",'mp_id' => "",'page_id' => "",'cat_id' => "",'mcp_status' => "");
	function manage_page_connection()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>