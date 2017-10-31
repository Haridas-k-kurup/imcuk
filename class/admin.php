<?php
include_once("db_functions.php");
class admin extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"admin";
	var $primaryKey			= 	"admin_id";
	var $table_fields	  	=   array('admin_id' => "",'admin_type' => "",'admin_username' => "",'admin_password' => "", 'admin_image' => "",'admin_createdon' => "",'admin_editedon' => "",'admin_last_visit' => "",'admin_last_visit_ip' => "",'admin_login_status' => "",'admin_status' => "");
	function admin()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>