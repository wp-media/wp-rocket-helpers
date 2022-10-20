<?php

// RUCSS debugging tools

// clear and regenerate used _css()

if( isset($_GET['clear_usedcss'] )) {
	
	$clear_usedcss = $_GET['clear_usedcss']; 
	$jobid_usedcss = $_GET['jobid_usedcss']; 
	
	// clear entry from the DB
	global $wpdb;
	$wpdb->delete( $wpdb->prefix."wpr_rucss_used_css", array( 'job_id' => $jobid_usedcss ) );
	
	// clear cache
	rocket_clean_post( url_to_postid ( $clear_usedcss ) );
	
	// trigger preload          

	do_the_preload( $clear_usedcss );
   
	echo "<h1>RUCSS - Clearing Used CSS</h1>";
	echo '<hr>';
	echo '<div class="message"><p><strong>Cache</strong> and <strong>Used CSS</strong> cleared for <a href="'.$clear_usedcss.'" target="_blank">'.$clear_usedcss.'</a></p></div>

	<p>
	The URL will be preloaded and the used CSS will be regenerated.<br>Please <a href="tools.php?page=wprockettoolset&mode=rucss">go back</a> to wait for the used css status until is <strong>completed</strong>. </p>';
	echo '<hr>';
	echo "<p>If the job is taking too long, you can install WP Crontrol and run the <strong>rocket_rucss_pending_jobs_cron</strong></p>";
	
	echo '<hr>';

echo '<a href="tools.php?page=wprockettoolset&mode=rucss" class="button-secondary">&lsaquo; go back</a>';

	echo '<hr>';

	}
	
//TRUNCATE USED CSS
elseif( isset($_GET['truncate_usedcss'] )) {
				
		// truncate wpr_rucss_used_css from the DB
		global $wpdb;
		$wpdb->query("TRUNCATE TABLE $wpdb->wpr_rucss_used_css");
			
		echo "<h1 class='wp-heading-inline'>RUCSS - Used CSS table truncated</h1>";
		echo '<hr>';
		echo '<div class="message"><p><strong>wpr_rucss_used_css</strong> table truncated! all rows removed</p></div>';
		echo "
			<ul>
			<li>- <strong>For safelisting tests</strong>: Disable preload, clear the cache, and visit one page to trigger the regeneration of that URL only</li>
			<li>- <strong>For generation tests</strong>: trigger a preload.</li> 
				</ul>
			";

echo '<a href="tools.php?page=wprockettoolset&mode=rucss" class="button-secondary">&lsaquo; go back</a>';
}


// CLEAR PENDING JOBS
elseif( isset($_GET['truncate_pending_usedcss'] )) {
			
	$status = 'pending'; 
   
	// clear entries from the DB
	global $wpdb;
	$wpdb->delete( $wpdb->prefix."wpr_rucss_used_css", array( 'status' => $status ) );     
	
	echo "<h1 class='wp-heading-inline'>RUCSS - Pending jobs cleanup</h1>";
	echo '<hr>';
	echo '<div class="message"><p><strong>Pending</strong> RUCSS jobs deleted from the database</p></div>';
	echo '<a href="tools.php?page=wprockettoolset&mode=rucss" class="button-secondary">&lsaquo; go back</a>';
}


// CLEAR FAILED JOBS
elseif( isset($_GET['truncate_failed_usedcss'] )) {
			
	$status = 'failed'; 
   
	// clear entries from the DB
	global $wpdb;
	$wpdb->delete( $wpdb->prefix."wpr_rucss_used_css", array( 'status' => $status ) );     
	
	
	echo "<h1 class='wp-heading-inline'>RUCSS - Failed jobs cleanup</h1>";
	echo '<hr>';
	echo '<div class="message"><p><strong>Failed</strong> RUCSS jobs deleted from the database</p></div>';
	echo '<a href="tools.php?page=wprockettoolset&mode=rucss" class="button-secondary">&lsaquo; go back</a>';

}


// CSS VIEW
elseif( isset($_GET['view'] )) {
$jobid = $_GET['view'];
global $wpdb;
$rows = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."wpr_rucss_used_css WHERE job_id = $jobid");
foreach ( $rows as $row )  { 
	echo "<h1>RUCSS -  CSS view</h1>";
	echo "<table border='1' cellspacing='1' cellpadding='4'><tr><td>url</td>";
	echo "<td><a target='_blank' href='".$row->url."'>".$row->url."</a></td></tr>";	
	
	if ( version_compare( $actual_version, '3.11.4' )  >= 0 ) {
	
	 $link = get_site_url().'/wp-content/cache/used-css/'.get_current_blog_id().'/'.$row->hash[0].'/'.$row->hash[1].'/'.$row->hash[2].'/'.substr($row->hash, 3).'.css.gz';
		
		echo "<tr><td>hash</td><td><a target='_blank' href='".$link."'>".$row->hash."</a></td></tr>";
	} 
					
	echo "<tr><td>unprocessedcss</td><td> ".$row->unprocessedcss."</td></tr>";	
	echo "<tr><td>retries</td><td> ".$row->retries."</td></tr>";	
	echo "<tr><td>is_mobile</td><td> ".$row->is_mobile."</td></tr>";	
	echo "<tr><td>Job Id</td><td>".$row->job_id."</td></tr>";	
	echo "<tr><td>queue_name</td><td> ".$row->queue_name."</td></tr>";	
	echo "<tr><td>status</td><td>".$row->status."</td></tr>";	
	echo "<tr><td>modified</td><td>".$row->modified."</td></tr>";	
	echo "<tr><td>last_accessed</td><td>".$row->last_accessed."</td></tr></table>";	
	
	if ( version_compare( $actual_version, '3.11.4' )  >= 0 ) {
		
		echo "<h2>Used CSS</h2>";
		$file_contents = file_get_contents(ABSPATH.'/wp-content/cache/used-css/'.get_current_blog_id().'/'.$row->hash[0].'/'.$row->hash[1].'/'.$row->hash[2].'/'.substr($row->hash, 3).'.css.gz');
		
		$css = gzdecode( $file_contents );	
		echo "<textarea cols='120' rows='50'>$css</textarea>";
		
	} else {
		
		echo "<h2>Used CSS</h2>";
		echo "<textarea cols='120' rows='50'>".$row->css."</textarea>";

	}

	
	}

} else {	

// TABLE VIEW
global $wpdb;

// PAGINATION number of rows per page, you can change this value
$rows_per_page = 100;

if( isset($_GET['pg'])) {
$pg = $_GET['pg'];
if($pg == 1 ) { $pg = 0; } else { ($pg = $pg*$rows_per_page); }

} else {
 $pg = 0; 
}


// SEARCH 
if( isset($_POST['s'])) {
$search_string = $_POST['s'];
$search = 'WHERE url LIKE "%'.$search_string.'%" OR job_id LIKE "%'.$search_string.'%" OR status LIKE "%'.$search_string.'%"';
} else {
 $search = '';
}


// filter
if( isset($_GET['filterstatus'])) {
	$status_string = $_GET['filterstatus'];
	$status = "WHERE status = '$status_string'";
	} else {
	 $status = '';
}

// sort
if( isset($_GET['sort'])) {
	$sort_string = $_GET['sort'];
	$sort = "ORDER BY $sort_string";
	} else {
	 $sort = 'ORDER BY job_id';
}

if( isset($_GET['order'])) {
	$order = $_GET['order'];
		if ($order == 'desc') { $asc = 'asc'; $arr = '&uarr;';} else { $asc = 'desc'; $arr = '&darr;';}
	} else {
		$order = 'asc'; $asc = 'desc'; $arr = '&uarr;';
	}



// DB queries and calculations
$totalrows = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->wpr_rucss_used_css");
$completedcount = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->wpr_rucss_used_css WHERE status = 'completed'");
$inprogresscount = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->wpr_rucss_used_css WHERE status = 'in-progress'");
$failedcount = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->wpr_rucss_used_css WHERE status = 'failed'");
$pendingcount = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->wpr_rucss_used_css WHERE status = 'pending'");
$rows = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."wpr_rucss_used_css $search $status $sort $order LIMIT $rows_per_page offset $pg " );

count($rows);

if($totalrows != 0 ) {
	$percentaje = intval($completedcount/$totalrows*100);
} else {
	$percentaje = 0;
}

echo "<h1 class='wp-heading-inline'>RUCSS</h1>";

echo '<hr>';
echo " <a class='button-secondary' href='tools.php?page=wprockettoolset&mode=rucss&truncate_pending_usedcss'  onclick=\"return confirm('Are you sure?')\">Clear PENDING</a>  ";
echo " <a  class='button-secondary' href='tools.php?page=wprockettoolset&mode=rucss&truncate_failed_usedcss'  onclick=\"return confirm('Are you sure?')\">Clear FAILED</a>  ";
echo " <a  class='button-secondary danger' class='failed' href='tools.php?page=wprockettoolset&mode=rucss&truncate_usedcss' onclick=\"return confirm('Are you sure?')\"><strong>Truncate wpr_rucss_used_css</strong></a>";


// Percentaje calculations
echo '<p>'.$percentaje.'% completed - ' . $completedcount . ' of '.  $totalrows. ' urls<br>';

echo '<p><span><a href="tools.php?page=wprockettoolset&mode=rucss"> All ('.$totalrows.')</a></span> - ';
echo '<span class="complete"><a href="tools.php?page=wprockettoolset&mode=rucss&filterstatus=completed">'.$completedcount.' Completed</a></span> - ';
echo '<span class="pending"><a href="tools.php?page=wprockettoolset&mode=rucss&filterstatus=pending">'.$pendingcount.' Pending</a> - ';
echo '<span class="in-progress"><a href="tools.php?page=wprockettoolset&mode=rucss&filterstatus=in-progress">'.$inprogresscount.' In-Progress</a> - ';
echo '<span class="failed"><a href="tools.php?page=wprockettoolset&mode=rucss&filterstatus=failed">'.$failedcount.' Failed</a></p>';


// SEARCH form
?>
<form method="post" action="tools.php?page=wprockettoolset&mode=rucss">
<input name="s" value="<?php if(isset($_POST['s'])) { echo $search_string; } ?>" />
<input type="submit" value="Search" />
</form>


<?php

if(isset ($_POST['s'])) { 
echo '<p><a href="tools.php?page=wprockettoolset&mode=rucss">Back</a> - Search results for <strong>'.$search_string.'</strong></p>'; 
}

//pagination
$pages = intval($totalrows/$rows_per_page);

if(isset($_GET['pg'])) {
	$pg = $_GET['pg'];
} else {
	$pg = 1;
}
$page = 1;
$pagination = '<p class="pagination">';

while ($page <= $pages ) {
 $pagination .= '<a ';
 if( $pg == $page ) { $pagination .= ' class="current" '; }
 
 $pagination .= 'href="tools.php?page=wprockettoolset&mode=rucss&pg='.$page.'">'.$page.'</a> &nbsp;';
 $page ++;
}

$pagination .= '</p>';

if( !isset($_POST['s'])) {
	echo $pagination;
}

// table view
$numerator = $pg ;
$i = $numerator; 

echo  "<table border='1' cellspacing='4' cellpadding='4'>";
echo "<tr>

<td><a href='tools.php?page=wprockettoolset&mode=rucss&sort=id&order=".$asc."'>#</a></td>
<td><a href='tools.php?page=wprockettoolset&mode=rucss&sort=url&order=".$asc."'>url</a></td>
<td>hash</td>
<td>unprocessed css</td>
<td>retries</td>
<td>is_mobile</td>
<td><a href='tools.php?page=wprockettoolset&mode=rucss&sort=job_id&order=".$asc."'>job_id</a></td>
<td>queue_name</td>
<td>status</td>
<td>modified</td>
<td>last_accessed</td>
<td>Used CSS</td>

</tr>";


foreach ( $rows as $row )  { 
	
 
echo "<tr>";

echo "<td class='".$row->status."'>".$row->id."</td>";

if( $row->url == home_url() ) { $is_home = 1; $home_tag ="<span class='is-home'>homepage</span>"; } else { $is_home = 0; $home_tag ="";}

echo "<td><a target='_blank' href='".$row->url."'>".$row->url."</a> ".$home_tag." </td>";

if ( version_compare( $actual_version, '3.11.4' )  >= 0 ) {

echo "<td><a target='_blank' href='tools.php?page=wprockettoolset&mode=rucss&view=".$row->job_id."'>".$row->hash."</a></td>";

} else {
echo "<td><a target='_blank' href='tools.php?page=wprockettoolset&mode=rucss&view=".$row->job_id."'>view css</a></td>";    
}

// check if the current page is the home

echo "<td>".$row->unprocessedcss."</td>";
echo "<td align='center'>".$row->retries."</td>";
echo "<td align='center'>".$row->is_mobile."</td>";

// only available for jobs not older than 1 hour
$dateString = $row->last_accessed;
$timestamp = strtotime($dateString);

if($timestamp >= strtotime("-1 hour")){
echo "<td align='center'><a title='Check the SaaS response for this job' target='_blank' href='https://saas.wp-rocket.me/rucss-job?id=".$row->job_id."&force_queue=".$row->queue_name."&is_home=".$is_home."&credentials[wpr_email]=".$rocket_options['consumer_email']."&credentials[wpr_key]=".$rocket_options['consumer_key']."'>".$row->job_id."</a></td>";
	} else {
echo "<td align='center'>".$row->job_id."</td>";
	}
	
echo "<td align='center'>".$row->queue_name."</td>";

echo "<td align='center' class='".$row->status."'>".$row->status."</td>";
echo "<td align='center'>".$row->modified."</td>";
echo "<td align='center'>".$row->last_accessed."</td>";
echo "<td align='center'><a href='tools.php?page=wprockettoolset&mode=rucss&clear_usedcss=".$row->url."&jobid_usedcss=".$row->job_id."'>Regenerate</a></td>";

echo "</tr>";

$i ++;
} 
echo  "</table>";

echo $pagination;

}


