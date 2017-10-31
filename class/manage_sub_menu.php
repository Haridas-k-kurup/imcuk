<?php
include_once("db_functions.php");
class manage_sub_menu extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"manage_sub_menu";
	var $primaryKey			= 	"sub_menu_id";
	var $table_fields	  	=   array('sub_menu_id' => "",'sub_id' => "",'sub_menu_name' => "", 'sub_menu_details' => "", 'position' => "", 'sub_menu_status' => "");
	function manage_sub_menu()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>