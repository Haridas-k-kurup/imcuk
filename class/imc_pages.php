<?php
include_once("db_functions.php");
class imc_pages extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"imc_pages";
	var $primaryKey			= 	"page_id";
	var $table_fields	  	=   array('page_id' => "", 'par_id' =>"", 'page_name' => "", 'page_position' => "", 'page_status' => "");
	function imc_pages()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>