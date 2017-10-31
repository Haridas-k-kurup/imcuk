<?php
include_once("db_functions.php");
class manage_category extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"manage_category";
	var $primaryKey			= 	"cat_id";
	var $table_fields	  	=   array('cat_id' => "",'par_id' => "",'cat_category' => "", 'is_menu_category' => "", 'cat_status' => "");
	function manage_category()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>