<?php
include_once("db_functions.php");
class group_info extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"group_info";
	var $primaryKey			= 	"group_id";
	var $table_fields	  	=   array('group_id' => "",'reg_id'	=>	"",'group_name' => "",'group_crt_on' => "",'group_status' => "");
	function group_info()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>