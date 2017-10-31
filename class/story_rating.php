<?php
include_once("db_functions.php");
class story_rating extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"story_rating";
	var $primaryKey			= 	"rating_id";
	var $table_fields	  	=   array('rating_id' => "",'mp_id' => "",'rate_like' => "",'rate_dislike' => "",'rate_ip' => "", 'rate_status' => "");
	function story_rating(){
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>