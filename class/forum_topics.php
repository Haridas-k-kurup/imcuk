<?php
include_once("db_functions.php");
class forum_topics extends db_functions 
{
	var $todays_date;
	var $tablename			= 	"forum_topics";
	var $primaryKey			= 	"topic_id";
	var $table_fields	  	=   array('topic_id' => "",'page_id' => "",'sub_menu_id' => "",'reg_id' => "",'topic' => "",'topic_desc' => "", 'topic_notice' => "", 'topic_view' => "",'topic_created_on' => "",'topic_edited' => "", 'topic_ip'=>"",'topic_staff_manage' =>"",'topic_status'=>"");
	function forum_topics(){
		$this->todays_date = date("Y-m-d");
		parent::db_functions($this->tablename, $this->primaryKey, $this->table_fields);
	}	
}
?>