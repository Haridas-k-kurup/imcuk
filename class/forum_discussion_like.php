<?php
include_once("db_functions.php");
class forum_discussion_like extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"forum_discussion_like";
	var $primaryKey			= 	"dis_like_id";
	var $table_fields	  	=   array('dis_like_id' => "",'dis_id' => "",'dis_like_ip' => "",'dis_like' => "",'dis_dislike' => "",'dis_like_status' => "");
	function forum_discussion_like()
	{
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>