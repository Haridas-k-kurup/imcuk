<?php
include_once("db_functions.php");
class forum_topic_like extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"forum_topic_like";
	var $primaryKey			= 	"topic_like_id";
	var $table_fields	  	=   array('topic_like_id' => "",'topic_id' => "",'topic_like_ip' => "",'topic_like' => "",'topic_dislike' => "",'topic_like_status' => "");
	function forum_topic_like()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>