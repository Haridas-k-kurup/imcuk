<?php
include_once("db_functions.php");
class promotional_ads extends db_functions 
{
	var $todays_date;
	var $tablename			= "promotional_ads";
	var $primaryKey			= "p_ads_id";
	var $table_fields	  	= array('p_ads_id' => "",'p_cat_id' => "",'p_ads_link' => "",'p_ads_status' => "");
	function promotional_ads() {
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>