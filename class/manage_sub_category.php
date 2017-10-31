<?php
include_once("db_functions.php");
class manage_sub_category extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"manage_sub_category";
	var $primaryKey			= 	"cat_id";
	var $table_fields	  	=   array('subcat_id' => "",'cat_id' => "", 'subcat_name' => "", 'subcat_position' => "", 'subcat_status' => "");
	function manage_sub_category()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>