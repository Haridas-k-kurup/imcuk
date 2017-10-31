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
$paginate = '';
$result = '';
/*$max_pages = '';
$page_id = '';
$page_numbers_per_page = '';
$pg_user_param = '';*/

function pagination($sql_pagination,$num_results_per_page){
	global $paginate, $result, $pageQuery;	
	$targetpage = htmlspecialchars($_SERVER['PHP_SELF'] );
	$qs =	'';
	if (!empty($_SERVER['QUERY_STRING'])) {
		$parts = explode("&", $_SERVER['QUERY_STRING']);
		$newParts = array();
		foreach ($parts as $val) {
			if (stristr($val, 'page') == false)  {
				array_push($newParts, $val);
			}
		}
		if (count($newParts) != 0) {
			$qs = "&".implode("&", $newParts);
		} 
	}
	
	$limit = $num_results_per_page; 
	$query = $sql_pagination;
	$total_pages = mysql_query($query);
	$counts		=	mysql_num_rows($total_pages);	
	$total_pages = $counts;
	$lastpage = ceil($total_pages/$limit);		
	$LastPagem1 = $lastpage - 1;	
	$stages = 2;
	$page = mysql_real_escape_string($_GET['page']);
	if($page){
		$start = ($page - 1) * $limit; 
	}else{
		$start = 0;	
		}
	
    // Get page data
	$pageQuery = $query." limit $start,$limit";
	//$result = mysql_query($pageQuery);
	
	// Initial page num setup
	if ($page == 0){$page = 1;}
	$prev = $page - 1;	
	$next = $page + 1;							
	
	
	$paginate = '';
	if($lastpage > 1)
	{	
		$paginate .= "<div class='paginate'>";
		// Previous
		if ($page > 1){
			$paginate.= "<a href='$targetpage?page=$prev$qs'>previous</a>";
		}else{
			$paginate.= "<span class='disabled'>previous</span>";	}
		
		// Pages	
		if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up
		{	
			for ($counter = $lastpage; $counter >= 1; $counter--)
			{
				if ($counter == $page){
					$paginate.= "<span class='current'>$counter</span>";
				}else{
					$paginate.= "<a href='$targetpage?page=$counter$qs'>$counter</a>";}					
			}
		}
		elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?
		{
			// Beginning only hide later pages
			if($page < 1 + ($stages * 2))		
			{
				$paginate.= "<a href='$targetpage?page=$lastpage$qs'>$lastpage</a>";
				$paginate.= "<a href='$targetpage?page=$LastPagem1$qs'>$LastPagem1</a>";
				$paginate.= "...";
				for ($counter = 4 + ($stages * 2); $counter >= 1; $counter--)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						$paginate.= "<a href='$targetpage?page=$counter$qs'>$counter</a>";}					
				}
						
			}
			// Middle hide some front and some back
			elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
			{
				$paginate.= "<a href='$targetpage?page=$lastpage$qs'>$lastpage</a>";
				$paginate.= "<a href='$targetpage?page=$LastPagem1$qs'>$LastPagem1</a>";
				$paginate.= "...";
				for ($counter =$page + $stages; $counter <= $page - $stages; $counter--)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						$paginate.= "<a href='$targetpage?page=$counter$qs'>$counter</a>";}					
				}
					
				
				$paginate.= "...";	
				$paginate.= "<a href='$targetpage?page=2$qs'>2</a>";
				$paginate.= "<a href='$targetpage?page=1$qs'>1</a>";
				
			}
			// End only hide early pages
			else
			{
				
				for ($counter =$lastpage; $counter >= $lastpage - (2 + ($stages * 2)) ; $counter--)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						$paginate.= "<a href='$targetpage?page=$counter$qs'>$counter</a>";}					
				}
				$paginate.= "...";
				$paginate.= "<a href='$targetpage?page=2$qs'>2</a>";
				$paginate.= "<a href='$targetpage?page=1$qs'>1</a>";
			}
		}
					
				// Next
		if ($page < $counter - 1){ 
			$paginate.= "<a href='$targetpage?page=$next$qs'>next</a>";
		}else{
			$paginate.= "<span class='disabled'>next</span>";
			}
			
		$paginate.= "</div>";		
	
	
}
 //echo $total_pages.'Results';
 // pagination
  $paginate;
}
?>
