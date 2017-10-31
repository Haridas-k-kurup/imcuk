<?php
include_once("db_functions.php");
class ad_management extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"ad_management";
	var $primaryKey			= 	"ad_id";
	var $table_fields	  	=   array('ad_id' => "",'ad_name' => "",'ad_adver_name' => "",'page_id' => "",'pos_id' => "", 'ad_position' => "", 'ad_publish_from' => "",'ad_publish_to' => "",'ad_hyper_link' => "",'ad_image' => "",'ad_create_date' => "",'ads_staff_manage' => "",'ad_status' => "");
	function ad_management(){
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>