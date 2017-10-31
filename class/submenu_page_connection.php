<?php
include_once("db_functions.php");
class submenu_page_connection extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"submenu_page_connection";
	var $primaryKey			= 	"subcon_id";
	var $table_fields	  	=   array('subcon_id' => "",'sub_id' => "",'page_id' => "",'subcon_status' => "");
	function submenu_page_connection() {
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>