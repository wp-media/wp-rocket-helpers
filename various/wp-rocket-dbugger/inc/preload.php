<?php

// PRELOAD debugging tools

	
//TRUNCATE TABLE CSS
if( isset($_GET['rebuild_cache'] )) {
				
		$rebuild_cache = $_GET['rebuild_cache']; 

		rocket_clean_post( url_to_postid ( $rebuild_cache ) );
		
		do_the_preload( $rebuild_cache );
		
		echo "<h1>PRELOAD</h1>";
		echo '<hr>';
		echo '<div class="message"><p>Cache for <strong>'.$rebuild_cache.'</strong> rebuilt</p></div>';
		echo '<a href="tools.php?page=wprockettoolset&mode=preload" class="button-secondary">&lsaquo; go back</a>';


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
$search = 'WHERE url LIKE "%'.$search_string.'%" OR id LIKE "%'.$search_string.'%" OR status LIKE "%'.$search_string.'%"';
} else {
 $search = '';
}

// DB queries and calculations
$totalrows = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->wpr_rocket_cache");
$completedcount = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->wpr_rocket_cache WHERE status = 'completed'");
$inprogresscount = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->wpr_rocket_cache WHERE status = 'in-progress'");
$failedcount = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->wpr_rocket_cache WHERE status = 'failed'");
$pendingcount = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->wpr_rocket_cache WHERE status = 'pending'");
$rows = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."wpr_rocket_cache $search  ORDER BY id LIMIT $rows_per_page offset $pg " );

if($totalrows != 0 ) {
	$percentaje = intval($completedcount/$totalrows*100);
} else {
	$percentaje = 0;
}

echo "<h1>PRELOAD</h1>";

echo '<hr>';


// Percentaje calculations
echo '<p>'.$percentaje.'% completed - ' . $completedcount . ' of '.  $totalrows. ' urls<br>';

echo '<p><span class="complete">'.$completedcount.' Completed</span> - ';
echo '<span class="pending">'.$pendingcount.' Pending - ';
echo '<span class="in-progress">'.$inprogresscount.' In-Progress - ';
echo '<span class="failed">'.$failedcount.' Failed </p>';


// SEARCH form
?>
<form method="post" action="tools.php?page=wprockettoolset&mode=preload">
<input name="s" value="<?php if(isset($_POST['s'])) { echo $search_string; } ?>" />
<input type="submit" value="Search" />
</form>


<?php

if(isset ($_POST['s'])) { 
echo '<p><a href="tools.php?page=wprockettoolset&mode=preload">Back</a> - Search results for <strong>'.$search_string.'</strong></p>'; 
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
 
 $pagination .= 'href="tools.php?page=wprockettoolset&mode=preload&pg='.$page.'">'.$page.'</a> &nbsp;';
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

<td>id</td>
<td>url</td>
<td>status</td>
<td>modified</td>
<td>last_accessed</td>
<td>rebuild</td>

</tr>";
foreach ( $rows as $row )  { 
 
echo "<tr>";

echo "<td class='".$row->status."'>".$row->id."</td>";
echo "<td><a target='_blank' href='".$row->url."'>".$row->url."</a></td>";
echo "<td align='center' class='".$row->status."'>".$row->status."</td>";
echo "<td align='center'>".$row->modified."</td>";
echo "<td align='center'>".$row->last_accessed."</td>";

echo "<td align='center'><a href='tools.php?page=wprockettoolset&mode=preload&rebuild_cache=".$row->url."'>Rebuild Cache</a></td>";
echo "</tr>";

$i ++;
} 
echo  "</table>";

echo $pagination;

}


