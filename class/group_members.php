<?php
include_once("db_functions.php");
class group_members extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"group_members";
	var $primaryKey			= 	"group_m_id";
	var $table_fields	  	=   array('group_m_id' => "",'group_id'	=>	"",'reg_id' => "",'group_m_add_on' => "",'group_m_status' => "");
	function group_members()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>