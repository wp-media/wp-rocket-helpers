<?php
/**
 * Plugin Name: WP Rocket - RUCSS Debugger
 * Plugin URI:  https://wp-media.me/
 * Description: A debugging tool for Remove Unused CSS.
 * Author:      WP Rocket Support Team
 * Author URI:  https://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
**/

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


add_action( 'admin_menu', 'rockettheburger_add_admin_menu' );

function rockettheburger_add_admin_menu() {
    add_management_page( 'RUCSS Debugger', 'RUCSS Debugger', 'install_plugins', 'wprocketrucssdebuger', 'wprocketrucssdebuger_admin_page' );
}


function wprocketrucssdebuger_admin_page() {
    
    if( ! function_exists('rocket_clean_domain')) {
        
        echo 'WP Rocket not detected';
        
        die;
    }

    $actual_version = WP_ROCKET_VERSION;
    
    echo '<style>
    .completed{background:#090;color:#FFF}
    .pending{color:#F80}
    .in-progress{color:#009}
    .failed{color:#900}
    .progress{color:#900;}
    .progress.completed{color:#090}
    .complete {color: #090;}
    tr {background-color:#FFF;}
    .pagination a {display: inline-block; padding: 6px; background-color: #DDD; color: #333; text-decoration: none }
    .pagination a.current {background-color: #999; color: #FFF; }
    
    </style>
    <div id="wpbody" role="main">
    <div id="wpbody-content">
    ';
    
    // clear and regenerate used dolly_css()
    
    if( isset($_GET['clear_usedcss'] )) {
        
        $clear_usedcss = $_GET['clear_usedcss']; 
        // clear entry from the DB
        global $wpdb;
        $wpdb->delete( $wpdb->prefix."wpr_rucss_used_css", array( 'url' => $clear_usedcss ) );
        
        // clear cache
        rocket_clean_post( url_to_postid ( $clear_usedcss ) );
        
        // trigger preload          
        $args = array();
        
            if( 1 == get_rocket_option( 'cache_webp' ) ) {
                $args[ 'headers' ][ 'Accept' ]      	= 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8';
                $args[ 'headers' ][ 'HTTP_ACCEPT' ] 	= 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8';
            }
            
            // Preload desktop pages/posts.
            wp_remote_get( esc_url_raw ( $clear_usedcss ), $args );
                
            if( 1 == get_rocket_option( 'do_caching_mobile_files' ) ) {
                $args[ 'headers' ][ 'user-agent' ] 	= 'Mozilla/5.0 (Linux; Android 8.0.0;) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Mobile Safari/537.36';
               // Preload mobile pages/posts.
                wp_remote_get( esc_url_raw ( $clear_usedcss ), $args );
            }
       
        echo "<h1 class='wp-heading-inline'>[<a href='tools.php?page=wprocketrucssdebuger'>&lsaquo; back</a>] RUCSS Debugger - Clearing Used CSS</h1>";
        echo '<hr>';
        echo "<h3><strong>Cache</strong> and <strong>Used CSS</strong> cleared for <em><a href='$clear_usedcss' target='_blank'>$clear_usedcss</a></em></h3>
        <p>
        The URL will be preloaded and the used CSS will be regenerated.<br>Please <a href='tools.php?page=wprocketrucssdebuger'>go back</a> to wait for the used css status until is <strong>completed</strong>. </p>";
        echo '<hr>';
        echo "<p>If the job is taking too long, you can install WP Crontrol and run the <strong>rocket_rucss_pending_jobs_cron</strong></p>";
        echo '<hr>';
    
        }
        
    //TRUNCATE USED CSS
    elseif( isset($_GET['truncate_usedcss'] )) {
                    
            // truncate wpr_rucss_used_css from the DB
            global $wpdb;
            $wpdb->query("TRUNCATE TABLE $wpdb->wpr_rucss_used_css");
                
            echo "<h1 class='wp-heading-inline'>[<a href='tools.php?page=wprocketrucssdebuger'>&lsaquo; back</a>] RUCSS Debugger - wpr_rucss_used_css Truncated</h1>";
            echo '<hr>';
            echo "<p>
            <h3>The <strong>wpr_rucss_used_css</strong> table has been truncated.</h3>
                <ul>
                <li>- <strong>For safelisting tests</strong>: Disable preload, clear the cache, and visit one page to trigger the regeneration of that URL only</li>
                <li>- <strong>For generation tests</strong>: trigger a preload.</li> 
                    </ul>
                <p><a href='tools.php?page=wprocketrucssdebuger'>go back</a></p>";
            echo '<hr>';
    }
    
    
    // CLEAR PENDING JOBS
    elseif( isset($_GET['truncate_pending_usedcss'] )) {
                
        $status = 'pending'; 
       
        // clear entries from the DB
        global $wpdb;
        $wpdb->delete( $wpdb->prefix."wpr_rucss_used_css", array( 'status' => $status ) );     
        
        echo "<h1 class='wp-heading-inline'>[<a href='tools.php?page=wprocketrucssdebuger'>&lsaquo; back</a>] RUCSS Debugger - Pending jobs removed</h1>";
        echo '<hr>';
        echo "<p><a href='tools.php?page=wprocketrucssdebuger'>go back</a></p>";
        echo '<hr>';
    }
    
    
    // CLEAR FAILED JOBS
    elseif( isset($_GET['truncate_failed_usedcss'] )) {
                
        $status = 'failed'; 
       
        // clear entries from the DB
        global $wpdb;
        $wpdb->delete( $wpdb->prefix."wpr_rucss_used_css", array( 'status' => $status ) );     
        
        echo "<h1 class='wp-heading-inline'>[<a href='tools.php?page=wprocketrucssdebuger'>&lsaquo; back</a>] RUCSS Debugger - Failed jobs removed</h1>";
        echo '<hr>';
        echo "<p><a href='tools.php?page=wprocketrucssdebuger'>go back</a></p>";
        echo '<hr>';
    }
    
    
    // CSS VIEW
    elseif( isset($_GET['view'] )) {
    $jobid = $_GET['view'];
    global $wpdb;
    $rows = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."wpr_rucss_used_css WHERE job_id = $jobid");
    foreach ( $rows as $row )  { 
        echo "<h1 class='wp-heading-inline'>[<a href='tools.php?page=wprocketrucssdebuger'>&lsaquo; back</a>] RUCSS Debugger -  CSS view</h1>";
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
    
    // DB queries and calculations
    $totalrows = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->wpr_rucss_used_css");
    $completedcount = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->wpr_rucss_used_css WHERE status = 'completed'");
    $inprogresscount = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->wpr_rucss_used_css WHERE status = 'in-progress'");
    $failedcount = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->wpr_rucss_used_css WHERE status = 'failed'");
    $pendingcount = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->wpr_rucss_used_css WHERE status = 'pending'");
    $rows = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."wpr_rucss_used_css $search  ORDER BY job_id LIMIT $rows_per_page offset $pg " );
    
    if($totalrows != 0 ) {
        $percentaje = intval($completedcount/$totalrows*100);
    } else {
        $percentaje = 0;
    }
    
    echo "<h1 class='wp-heading-inline'><a href='tools.php?page=wprocketrucssdebuger'>RUCSS Debugger</a> -  contents of $wpdb->prefix wpr_rucss_used_css</h1>";
    echo '<hr>';
    echo '<a href="'.get_site_url().'/wp-cron.php?doing_wp_cron" id="doing-cron-button">Run WP-Cron</a><span id="doing-cron-status"></span><br><br>';
    echo '<script src="'. esc_url( plugins_url( 'main.js', __FILE__ ) ) .'"></script>';

    
    
    // Percentaje calculations
    echo '<p>'.$percentaje.'% completed - ' . $completedcount . ' of '.  $totalrows. ' urls<br>';
    
    echo '<p><span class="complete">'.$completedcount.' Completed</span> - ';
    echo '<span class="pending">'.$pendingcount.' Pending - ';
    echo '<span class="in-progress">'.$inprogresscount.' In-Progress - ';
    echo '<span class="failed">'.$failedcount.' Failed </p>';
    
    
    // SEARCH form
    ?>
    <form method="post" action="tools.php?page=wprocketrucssdebuger">
    <input name="s" value="<?php if(isset($_POST['s'])) { echo $search_string; } ?>" />
    <input type="submit" value="Search" />
    </form>
    
    
    <?php
    
    if(isset ($_POST['s'])) { 
    echo '<p><a href="tools.php?page=wprocketrucssdebuger">Back</a> - Search results for <strong>'.$search_string.'</strong></p>'; 
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
     
     $pagination .= 'href="tools.php?page=wprocketrucssdebuger&pg='.$page.'">'.$page.'</a> &nbsp;';
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
    
    <td>#</td>
    <td>url</td>
    <td>Error Code</td>
    <td>Error Message</td>
    <td>is_mobile</td>
    <td>status</td>
    <td>modified</td>
    <td>last_accessed</td>
    <td>Used CSS</td>
    
    </tr>";
    foreach ( $rows as $row )  { 
     
    echo "<tr>";
    
    echo "<td class='".$row->status."'>".$i."</td>";
    echo "<td><a target='_blank' href='".$row->url."'>".$row->url."</a></td>";
    echo "<td>".$row->error_code."</td>";
    echo "<td>".$row->error_message."</td>";
    echo "<td align='center'>".$row->is_mobile."</td>";
    echo "<td align='center' class='".$row->status."'>".$row->status."</td>";
    echo "<td align='center'>".$row->modified."</td>";
    echo "<td align='center'>".$row->last_accessed."</td>";
    echo "<td align='center'><a href='tools.php?page=wprocketrucssdebuger&clear_usedcss=".$row->url."'>Regenerate</a></td>";
    
    echo "</tr>";
    
    $i ++;
    } 
    echo  "</table>";
    
    echo $pagination;
    
    }
    
    echo '</div></div>';
}

