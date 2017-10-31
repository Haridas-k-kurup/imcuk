<?php
include_once("db_functions.php");
class manage_sub_sub_pluse extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"manage_sub_sub_pluse";
	var $primaryKey			= 	"sub_pluse_id";
	var $table_fields	  	=   array('sub_pluse_id' => "",'sub_sub_id' => "",'sub_pluse_menu' => "",'sub_pluse_details' => "", 'position' => "", 'sub_pluse_status' => "");
	function manage_sub_sub_pluse()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>