<?php

// PRELOAD debugging tools


//REBUILD cache
if (isset($_GET['rebuild_cache'])) {
    $rebuild_cache = $_GET['rebuild_cache'];

    rocket_clean_post(url_to_postid($rebuild_cache));

    do_the_preload($rebuild_cache);

    echo "<h1>PRELOAD</h1>";
    echo '<hr>';
    echo '<div class="message"><p>Cache for <strong>'.$rebuild_cache.'</strong> rebuilt</p></div>';
    echo '<a href="tools.php?page=wprockettoolset&mode=preload" class="button-secondary">&lsaquo; go back</a>';
} else {

// TABLE VIEW
    global $wpdb;

    if (isset($_GET['pg'])) {
        $pg = $_GET['pg'];
        if ($pg == 1) {
            $pg = 0;
        } else {
            ($pg = ($pg-1)*$rows_per_page);
        }
    } else {
        $pg = 0;
    }




    // SEARCH
    if (isset($_GET['s'])) {
        $search_string = $_GET['s'];
        $search = 'WHERE url LIKE "%'.$search_string.'%" OR id LIKE "%'.$search_string.'%" OR status LIKE "%'.$search_string.'%"';
        $search_query = '&s='.$_GET['s'];
    } else {
        $search = '';
        $search_query = '';
    }


    // filter
    if (isset($_GET['filterstatus'])) {
        $status_string = $_GET['filterstatus'];
        $status = "WHERE status = '$status_string'";
        $status_query = '&filterstatus='.$_GET['filterstatus'];
    } else {
        $status = '';
        $status_query = '';
    }

    // sort
    if (isset($_GET['sort'])) {
        $sort_string = $_GET['sort'];
        $sort = "ORDER BY $sort_string";
        $sort_query = '&sort='.$_GET['sort'];
    } else {
        $sort_string = 'url';
        $sort = 'ORDER BY url';
        $sort_query = '';
    }

    if (isset($_GET['order'])) {
        $order = $_GET['order'];
        if ($order == 'desc') {
            $asc = 'asc';
            $arr = '&uarr;';
            $arr_query = '&order='.$_GET['order'];
        } else {
            $asc = 'desc';
            $arr = '&darr;';
            $arr_query = '';
        }
    } else {
        $order = 'asc';
        $asc = 'desc';
        $arr = '&uarr;';
        $arr_query = '';
    }


    // DB queries and calculations
    $tablecontents = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."wpr_rocket_cache ", ARRAY_A);
    $queriedrows = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->wpr_rocket_cache $search");

    $totalrows = count($tablecontents);

    $completedcount = 0;
    $inprogresscount = 0;
    $failedcount = 0;
    $pendingcount = 0;

    foreach ($tablecontents as $content) {
        if ($content['status'] == 'completed') {
            $completedcount ++;
        }
        if ($content['status'] == 'in-progress') {
            $inprogresscount ++;
        }
        if ($content['status'] == 'failed') {
            $failedcount ++;
        }
        if ($content['status'] == 'pending') {
            $pendingcount ++;
        }
    }

    $rows = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."wpr_rocket_cache $search $sort $order LIMIT $rows_per_page offset $pg ");


    $currentrows = count($rows);

    if ($totalrows != 0) {
        $percentaje = ceil($completedcount/$totalrows*100);
    } else {
        $percentaje = 0;
    }

    echo "<h1>PRELOAD</h1>";

    if (get_rocket_option('manual_preload') != 1) {
        echo '<div class="message warning"><p>Preload is disabled</p></div>';
    }
    echo '<hr>';


    // Percentaje calculations
    echo '<p>'.$percentaje.'% completed - ' . $completedcount . ' of '.  $totalrows. ' urls<br>';

    echo '<p><span class="complete">'.$completedcount.' Completed</span> - ';
    echo '<span class="pending">'.$pendingcount.' Pending - ';
    echo '<span class="in-progress">'.$inprogresscount.' In-Progress - ';
    echo '<span class="failed">'.$failedcount.' Failed </p>';


    // SEARCH form?>

<form method="get" action="tools.php">
    <input name="s" value="<?php if (isset($_GET['s'])) {
        echo $search_string;
    } ?>" />
    <input type="hidden" name="page" value="wprockettoolset" />
    <input type="hidden" name="mode" value="preload" />
    <input type="submit" value="Search" />
</form>


<?php

    if (isset($_GET['s'])) {
        echo '<p><a href="tools.php?page=wprockettoolset&mode=preload">Back</a> - <strong>'.$queriedrows.'</strong> Search results for <strong>'.$search_string.'</strong></p>';
    }

    //pagination
    $pages = ceil($queriedrows/$rows_per_page);


    if (isset($_GET['pg'])) {
        $pg = $_GET['pg'];
    } else {
        $pg = 1;
    }
    $page = 1;
    $pagination = '<p class="pagination">';

    while ($page <= $pages) {
        $pagination .= '<a ';
        if ($pg == $page) {
            $pagination .= ' class="current" ';
        }

        $pagination .= 'href="tools.php?page=wprockettoolset&mode=preload&pg='.$page.$search_query.$status_query.$sort_query.$arr_query.'">'.$page.'</a>';
        $page ++;
    }

    $pagination .= '</p>';


    echo $pagination;


    // table view
    $numerator = $pg ;
    if ($pg > 0) {
        $numerator = $pg-1;
    } else {
        $numerator = $pg;
    }
    $i = (($numerator)*$rows_per_page) + 1;



    echo  "<table border='1' cellspacing='4' cellpadding='4'>";
    echo "<tr>

<td>#</td>
<td><a href='tools.php?page=wprockettoolset&mode=preload&sort=id&order=".$asc.$search_query.$status_query."'>id ".show_arr('id', $sort_string, $order)." </a></td>
<td><a href='tools.php?page=wprockettoolset&mode=preload&sort=url&order=".$asc.$search_query.$status_query."'>url ".show_arr('url', $sort_string, $order)." </a></td>

<td><a href='tools.php?page=wprockettoolset&mode=preload&sort=status&order=".$asc.$search_query.$status_query."'>status ".show_arr('status', $sort_string, $order)." </a></td>
<td><a href='tools.php?page=wprockettoolset&mode=preload&sort=modified&order=".$asc.$search_query.$status_query."'>modified ".show_arr('modified', $sort_string, $order)." </a></td>
<td><a href='tools.php?page=wprockettoolset&mode=preload&sort=last_accessed&order=".$asc.$search_query.$status_query."'>last_accessed ".show_arr('last_accessed', $sort_string, $order)." </a></td>
<td>rebuild</td>

</tr>";

    foreach ($rows as $row) {
        if ($row->url == home_url()) {
            $is_home = 1;
            $home_tag ="<span class='highlighted'>homepage</span>";
        } else {
            $is_home = 0;
            $home_tag ="";
        }

        echo "<tr>";
        echo "<td>".$i."</td>";
        echo "<td class='".$row->status."'>".$row->id."</td>";

        echo "<td><a target='_blank' href='".$row->url."'>".$row->url." ".$home_tag."</a></td>";
        echo "<td align='center' class='".$row->status."'>".$row->status."</td>";
        echo "<td align='center'>".$row->modified."</td>";
        echo "<td align='center'>".$row->last_accessed."</td>";

        echo "<td align='center'><a href='tools.php?page=wprockettoolset&mode=preload&rebuild_cache=".$row->url."'>Rebuild Cache</a></td>";
        echo "</tr>";

        $i ++;
    }
    echo  "</table>";

    if (isset($pagination)) {
        echo  $pagination;
    }
}
