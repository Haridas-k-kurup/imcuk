<?php
include_once("db_functions.php");
class manage_sub_pages extends db_functions{
	var $todays_date;
	var $tablename			= 	"manage_sub_pages";
	var $primaryKey			= 	"sub_id";
	var $table_fields	  	=   array('sub_id' => "",'cat_id' => "",'subcat_id' => "", 'sub_heading' => "", 'sub_information' => "", 'sub_create_time' => "", 'sub_status' => "");
	function manage_sub_pages()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>