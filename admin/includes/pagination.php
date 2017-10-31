<?php

/* 
 * url: http://kuppiya.com/download_video.php
 *
 * apprciate if you can leave the above link.
 *
 * Free to use, modofy, distribute, do anything you like :) 
 *
*/
$pg_error = '';
$paginationQuery = '';
$pagination_output = '';
$max_pages = '';
$page_id = '';
$page_numbers_per_page = '';
$pg_user_param = '';
function pagination($sql, $num_results_per_page, $num_page_links_per_page, $pg_param,$pagecnt)
{
	global $pg_error, $paginationQuery, $max_pages, $page_id, $page_numbers_per_page, $pg_user_param,$pagecnt;
	
	$user_sql = $sql;
	$page_numbers_per_page = $num_page_links_per_page;
	$results_per_page = $num_results_per_page;
	$pg_user_param = $pg_param;
	
	$all_results = mysql_query($user_sql);	//get all the results
	if($all_results)
	{	
		if(empty($all_results))
		{
			//if the query returns 0 results set the $total_results to 0
			$total_results = 0; 
		}
		else
		{
			//else set number of returned results to $total_results
			
			$total_results = mysql_num_rows($all_results); 
		}
		
		/*
		Calculate max number of pages for the given query
		note why ceil is used
		*/
		$max_pages = ceil($total_results / $results_per_page);		
		
		//if url parameter page_id is set		
		if(isset($_GET['page_id']))
		{			
			$page_id = (int) $_GET['page_id'];			
			
			//Check for errors in passed $page_id
			if($page_id > $max_pages || empty($page_id))
			{
				$page_id = 1;				
			}
		}
		else
		{
			$page_id = 1;			
		}
		
		// ($page_id - 1) is because table row index start with 0
		$page_id_temp = ($page_id - 1) * $results_per_page;
		
		//sql limit starting point
		$sql_offset = $page_id_temp;
		
		//concatenate limit clause to the $user_sql with the offset and number of results per page
		$user_sql .= " limit $sql_offset, $results_per_page";		
		
		//run the new sql query to get the relavent result set
		//$pg_result = mysql_query($user_sql);
		$paginationQuery = $user_sql;
		
		
		//Call the function Creating the Links
		Create_Links();
		
	}
	else
	{
		$pg_error = 'Error with the sql query you entered: '.mysql_error();
	}
}





function Create_Links()
{
	global $pagination_output, $max_pages, $page_id, $page_numbers_per_page, $pg_user_param;
	//Get the php file name
	$pg_page_name = htmlspecialchars($_SERVER['PHP_SELF'] );
	$qs =	'';
	if (!empty($_SERVER['QUERY_STRING'])) {
		$parts = explode("&", $_SERVER['QUERY_STRING']);
		$newParts = array();
		foreach ($parts as $val) {
			if (stristr($val, 'page_id') == false)  {
				array_push($newParts, $val);
			}
		}
		if (count($newParts) != 0) {
			$qs = "&".implode("&", $newParts);
		} 
	}
	//You only need to create pagination if $max_pages is greater than 1
	if($max_pages > 1)
	{		
		//First Link		
		if($page_id > 1)
		{			
			$first_link = '<li class="prev "><a href="'.$pg_page_name.'?page_id=1'.$pg_user_param.$qs.'">First</a></li> ';
		}
		
		//Last Link		
		if($page_id < $max_pages)
		{			
			$last_link = '<li class="prev "><a href="'.$pg_page_name.'?page_id='.$max_pages . $pg_user_param.$qs.'">Last</a></li> ';
		}
		
		//Previous Link
		//previous id will always be 1 minus $page_id and should not equal to 0
		$pre_id = $page_id - 1;
		if($pre_id != 0)
		{
			$pre_link = '<li class="prev "><a href="'.$pg_page_name.'?page_id='.$pre_id . $pg_user_param.$qs.'">Previous</a></li> ';
		}		
		
		//Next Link
		//next id will always be 1 plus $page_id and should not be greater than $max_pages
		$next_id = $page_id + 1;
		if($next_id <= $max_pages)
		{
			$next_link = '<li class="prev "><a href="'.$pg_page_name.'?page_id='.$next_id . $pg_user_param.$qs.'">Next</a> </li>';
		}
		
		
		//Starting Page Number
		if($page_id >= $page_numbers_per_page)
		{
			/*
			if current $page_id greater than equal to $page_numbers_per_pages
			shift the starting page number
			*/
			$start_point = ($page_id - $page_numbers_per_page) + 2;
		}
		else
		{			
			$start_point = 1;
		}
		
		//Loop Amount
		// minus 1 is because inside the for loop its less than or equal
		$loop_num = ($start_point + $page_numbers_per_page) - 1; 
		if($loop_num > $max_pages)
		{
			//$loop_num cannot be greater than $max_pages
			$loop_num = $max_pages;
		}
		
		/* Creating Pagination Output Start */
		
		$pagination_output = '<ul class="pagination"> ';
		
		//remove or comment this line if you don't want first link displayed
		$pagination_output .= @$first_link;
		//remove or comment this line if you don't want previous link displayed
		$pagination_output .= @$pre_link;	
		
		for($i = $start_point; $i <= $loop_num; $i++)
		{
			if($i == $page_id)
			{
				$pagination_output .= ' <li class="prev  active"><a class="current">'.$i.'</a></li> ';
			}
			else
			{
				$pagination_output .= ' <li class="prev "><a href="'.$pg_page_name.'?page_id='.$i . $pg_user_param.$qs.'">'.$i.'</a></li> ';
			}
		}
		
		//remove or comment this line if you don't want first link displayed
		$pagination_output .= @$next_link;
		//remove or comment this line if you don't want previous link displayed
		$pagination_output .= @$last_link;
		
		$pagination_output .= '</ul><br />';
		
		/* Creating Pagination Output End */
	}
}
?>
