<?php
include_once("db_functions.php");
class manage_sub_sub_inner extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"manage_sub_sub_inner";
	var $primaryKey			= 	"sub_inner_id";
	var $table_fields	  	=   array('sub_inner_id' => "",'sub_pluse_id' => "",'sub_inner_menu' => "",'sub_inner_details' => "", 'position' => "", 'sub_inner_status' => "");
	function manage_sub_sub_inner()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>