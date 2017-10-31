<?php
	error_reporting(E_ALL ^ E_NOTICE);
	ini_set('max_execution_time', 500); 
	require_once 'connect.php';
	date_default_timezone_set('Asia/Kolkata');
	ini_set('date.timezone', 'Asia/Kolkata');
	$ObjConnect 				= 	new connect();
	$dbconnect 					= 	$ObjConnect->db_connect() or trigger_error("SQL", E_USER_ERROR);
	##############	The type of query to be generated for execution.	#############
	define("EXECUTE_SELECT", 1);
	define("EXECUTE_INSERT", 2);
	define("EXECUTE_UPDATE", 3);
	define("EXECUTE_DELETE", 4);
	##############	The type of query to be generated for execution.	##############
	define("OK", 1);
	define("ERROR", -1);
	define("ERROR_ALREADY_EXISTS", -2);
	define("ERROR_INVALID_ARGUMENT", -3);
	define("ERROR_NO_DATA", -4);
	define("ERROR_UNKNOWN_OPTION", -5);
	define("ERROR_DELETION_DENIED", -6);
	define("ERROR_RANGE_EXISTS", -7);
	define("ERROR_INVALID_MOVE", -8);
	
	class db_functions extends connect
	{
		var $table;	          // table name
		var $dbname;            // database name
		var $primarykey;		 // primary key
		var $rows_per_page;     // used in pagination
		var $pageno;            // current page number
		var $lastpage;          // highest page number
		var $arrfields;         // list of fields in this table
		var $data_array;        // data from the database
		var $errors;            // array of error messages
		var $insert_id   = 0;	  
		function db_functions($table,$primarykey,$fields)
		{
			$this->table	       	= 	$table;
			$this->dbname          	= 	$ObjConnect->dbname;
			$this->rows_per_page   	= 	10;
			$this->arrfields 		= 	$fields;
			$this->primarykey		= 	$primarykey;
			$this->insert_id		= 	$insert_id;
		} // constructor
		function esc($s)
		{ 
		   //$s=htmlentities($s);
		   $s=strip_tags($s);
		   $s=str_replace("'","&#39;",$s);
		   $s=mysql_real_escape_string($s);
		   return $s;
		}
		function simple_esc($s)
		{ 
		   $s=str_replace("'","&#39;",$s);
		   return $s;
		}
		function build_result_insert($sql)
		{
			//echo $sql;
			//exit;	
			$result 				= 	@mysql_query($sql) or trigger_error("SQL", E_USER_ERROR);
			return OK;
		}
		function build_result($sql)
		{	
		//echo $sql;
			$data_array1 			= 	array();
			$result 				= 	@mysql_query($sql) or trigger_error("SQL", E_USER_ERROR);
			while ($data_array1[] 	= 	mysql_fetch_assoc($result)) 
			{
			
			} // while
		   	mysql_free_result($result);
		  	return $data_array1;
		}
		function build_result_row($sql)
		{
			//echo $sql;
			//exit;
			$result 				= 	@mysql_query($sql) ;//or trigger_error("SQL", E_USER_ERROR);
			if($result)
			{
				$this->data_array 	= 	mysql_fetch_array($result); 
				mysql_free_result($result);
			}
	   		return $this->data_array;
		}
		function execute($values = NULL, $mode = EXECUTE_INSERT, $where = NULL, $order = NULL)
	  	{
			if (($mode == EXECUTE_INSERT || $mode == EXECUTE_UPDATE) &&	(!is_array($values) || count($values)==0))
			{
				return $this->raiseError(ERROR_INVALID_ARGUMENT,array("file" => __FILE__, "line" => __LINE__));
			}
			$values					= 	$this->_clearArray($values);
			$sql					= 	$this->buildQuery($values, $mode, $where, $order);
			$res  					= 	$this->build_result_insert($sql);
			$this->insert_id 		= 	mysql_insert_id();
			return  OK;
		}
			
		function buildQuery($value = NULL, $mode = EXECUTE_SELECT, $where = FALSE, $order = FALSE)
		{
		//echo $sql;
		//exit;
			//$where				=	mysql_real_escape_string($where);			
			$where					= 	($where) ? " WHERE $where " 		: "";
			//$order				=	mysql_real_escape_string($order);	
			$order					= 	($order) ? " ORDER BY $order " 	: " ORDER BY {$this->primarykey} ";
			//	echo 	$this->table	;
			$temp					= 	"";
			switch ($mode) 
			{
				case EXECUTE_SELECT:
					$temp			= 	implode(",", array_keys($this->arrfields));
					//print_r($temp);
					//exit;
					return "SELECT $temp FROM {$this->table} $where $order ";
				case EXECUTE_UPDATE:
					//$this->alter_walk($value,);
					array_walk($value, 'alter_walk');
					$temp			= 	implode(", ", array_values($value));
					//echo "UPDATE {$this->table} SET $temp $where "; 
					//exit;
					return "UPDATE {$this->table} SET $temp $where ";
				case EXECUTE_INSERT:
					//print_r($value);
					array_walk($value,"myfunction");
					//print_r($value);
					$tempF			= 	implode(",", array_keys($value));
					$tempV			= 	implode("', '", array_values($value));
					//$tempV	= addslashes($tempV);
					//echo "INSERT INTO {$this->table} ($tempF) VALUES ('$tempV')";
					//exit;
					return "INSERT INTO {$this->table} ($tempF) VALUES ('$tempV')";
				case EXECUTE_DELETE:
					return "DELETE FROM {$this->table} $where ";
				default:
			}
		}
		function insert($array)
		{
			// 	function to check read settings 
			//	if($_SESSION['write_approved']== ""  )	{ check_page_protection('r'); 	}
		//echo $sql;
			return $this->execute($array);
		}	
	    function delete($cond)
	   	{
			return $this->execute($array = "", EXECUTE_DELETE, $cond);
	  	}
		 function deleterow($cond)
	   	{
			$this->execute($array = "", EXECUTE_DELETE, $cond);
			return mysql_affected_rows();
	  	}
		function update($array, $cond)
		{ 
					
				return  $this->execute($array, EXECUTE_UPDATE, $cond);
		}
		function updateField($array, $cond)
		{
			return   $this->execute($array, EXECUTE_UPDATE, $cond);
		}
	  	function count($where = NULL)
	  	{
			$where					= 	($where) ? " WHERE $where " 		: "";
			$prime					=	$this->primaryKey;
			$sql 					= 	"SELECT count($prime) FROM {$this->table} $where";
				//echo $sql;
			$res  					= 	$this->build_result_row($sql);
			$res  					= 	$res['count('.$prime.')'];
			
			return $res;
		}
		function countRows($sql)
		{
           	//	echo $sql;
			//echo "<br>".$sql;
			$rst					=	@mysql_query($sql)or trigger_error("SQxxxL", E_USER_ERROR);
			return $numrows 		        = 	mysql_num_rows($rst);
		}
		function countResultSet($rst)
		{
			return $numrows 		        = 	mysql_num_rows($rst);
		}

		function getMax($where = NULL)
		{
		 	$where					=	($where) ? " WHERE $where " 		: "";
			$sql 					= 	"SELECT max({$this->primaryKey}) FROM {$this->table} $where";
			//echo $sql;
			//exit;
			$res  					=	$this->build_result_row($sql);
			return $res[0];
		}
		function getAll($where = NULL, $order = NULL)
		{
			// function to check read settings 
			//if($_SESSION['read_approved']== "")	{ check_page_protection('r'); 	}
			$sql					= 	$this->buildQuery(NULL, EXECUTE_SELECT, $where, $order);
			//exit;
			$res  					= 	$this->build_result($sql);
			return array_filter($res);
		}
		function getFields($fields, $where = NULL, $order = NULL)
		{
		
			$fields					= 	($fields) ? " $fields " 			: " * ";
			$where					= 	($where) ? " WHERE $where " 		: "";
			$order					= 	($order) ? " ORDER BY $order " 	: " ORDER BY {$this->primaryKey} ";
			$sql					= 	"SELECT $fields FROM {$this->table} $where $order ;";
			//echo $sql;
			$res  					= 	$this->build_result($sql);
			$res						=	array_filter($res);
			return $res;
		}
		function listQuery($sql)
		{ 
		  //echo  $sql;
			$data_array1 			= 	array();
			//exit;
			$result 				= 	@mysql_query($sql) or trigger_error("SQL", E_USER_ERROR);
			
			while ($data_array1[] 	= 	mysql_fetch_assoc($result)) 
			{
			
			} // while
			
		   	mysql_free_result($result);
		  	return array_filter($data_array1);
		}
		function updateFieldRow($array, $cond)
		{
			$this->execute($array, EXECUTE_UPDATE, $cond);
			return mysql_affected_rows();
		}
		function updatestatus($array, $cond)
		{		
			return $this->execute($array, EXECUTE_UPDATE, $cond);
		}
		function getOne($sql)
		{
			$res  					= 	$this->build_result($sql);
			return $res;
		}
		function getRow($where = NULL, $order = NULL)
		{
			//echo $where;
			$sql 					= 	$this->buildQuery(NULL, EXECUTE_SELECT, $where, $order);
 			//echo  $sql;
			//exit;
			$res  					= 	$this->build_result_row($sql);
			//print_r($res);
			return $res;
		}
		function getRowSql($sql)
		{
			//echo $where;
			//$sql 	= $this->buildQuery(NULL, EXECUTE_SELECT, $where, $order);
 			//echo $sql;
			$res  					= 	$this->build_result_row($sql);
			return $res;
		}
		function delete_new($my_sql)
		{  
			//echo $my_sql;
			mysql_query($my_sql);
		}
		function simpleupdate($my_sql)
		{
			//return $this->insert_id;
			$my_sql;
			$resultup 				= 	mysql_query($my_sql);//or trigger_error("SQL", E_USER_ERROR);
			return $resultup;
		}
		function simpleupdaterow($my_sql)
		{
			//return $this->insert_id;
			//echo $my_sql;
			$resultup 				= 	mysql_query($my_sql);//or trigger_error("SQL", E_USER_ERROR);
			return mysql_affected_rows();
		}
		function insertId()
		{
			return $this->insert_id;
		}
		function _clearArray($array)
		{
			if (!is_array($array) || count($array)==0)
			{
				//echo "empty";
				return $this->raiseError(ERROR_INVALID_ARGUMENT, array("file" => __FILE__, "line" => __LINE__));
			}
			foreach ($array as $key => $val)
			{
				//print_r($this->arrfields);
				//echo $this->fields;
				if (!array_key_exists($key, $this->arrfields))
				{
					unset($array[$key]);
				}
				else
				{
//					$array[$key]	=	mysql_real_escape_string($array[$key]);
				}
			}
		//	print_r($array);
			return $array;
		}
		function raiseError($code, $info = array())
		{
			$message				= 	$this->errorMessage($code);
			return $message ;
		}
		function errorMessage($code)
		{
			static $errorMessages;
			if (!isset($errorMessages)) 
			{
				$errorMessages 	= 	array(
											ERROR						=> "unknown errors",
											ERROR_ALREADY_EXISTS		=> "The data you entered already exists",
											ERROR_INVALID_ARGUMENT		=> "Invalid argument",
											ERROR_NO_DATA				=> "No data exists",
											ERROR_UNKNOWN_OPTION		=> "Unknown option",
											ERROR_DELETION_DENIED		=> "Deletion denied for the current record",
											OK							=> "No error",
											ERROR_RANGE_EXISTS			=> "The range already exists. Please check the range.",
											ERROR_INVALID_MOVE			=> "Updation denied: Invalid move"
										);
			}
			if (array_key_exists($code, $errorMessages)) 
			{
				return $errorMessages[$code];
			}
			return $errorMessages["ERROR"];		
		}

				
		function max($sql)
		{
			return	$this->build_result_row("select max(priority) as max_count from {$this->table}");
		}
		function max_id($priority)
		{
			return	$this->build_result_row("select max($priority) as max_id from {$this->table}");
		}
	

	} // end class
	function esc($s){ 
	// $s=htmlentities($s);
	   $s=str_replace("'","&#39;",$s);
	   $s=mysql_real_escape_string($s);
	   return $s;
	}
	function alter_walk(&$val, $key)
	{
		$val 		= 	"$key = '".esc($val)."'";
	}
	function myfunction(&$value,$key) 
	{
	   $value=esc($value);
		//echo $value;
	}
?>