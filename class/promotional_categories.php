<?php
include_once("db_functions.php");
class promotional_categories extends db_functions 
{
	var $todays_date;
	var $tablename			= "promotional_categories";
	var $primaryKey			= "p_cat_id";
	var $table_fields	  	= array('p_cat_id' => "",'p_cat_name' => "",'p_cat_status' => "");
	function promotional_categories(){
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>