<?php
/**
 * Plugin Name: WP Rocket | Change Preload Parameters
 * Description: Reduce the CPU usage by changing the default Preload parameters (batch size, interval, pause between requests)
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/preload/wp-rocket-preload-change-parameters/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2022
 */

namespace WP_Rocket\Helpers\static_files\preload\change_parameters;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


/**
 *  1) BATCH SIZE
 *  Change the number of URLs to preload on each batch, 45 is the default.
 *  A lower value can help the server to work on fewer requests at a time
 */     
function preload_batch_size( $value ) {     
      
     // change this value, default is 45 urls:
     $value = 30; 
   
     return $value;
 }
     
add_filter( 'rocket_preload_cache_pending_jobs_cron_rows_count', __NAMESPACE__ .'\preload_batch_size'  );



/**
 *  2) CRON INTERVAL:
 *  Set the desired cron interval in seconds
 *  By setting a higher value the server will have more time to rest between processing batches.
 */
 function preload_cron_interval( $interval ) {   
     
     // change this value, default is 60 seconds:
     $interval = 120;
     
     return $interval;
 }
	 
add_filter( 'rocket_preload_pending_jobs_cron_interval', __NAMESPACE__ .'\preload_cron_interval'  );



/**
 *  3) DELAY BETWEEN REQUESTS:
 *  This is the delay between requests. A higher delay will reduce the CPU usage.
 *  Default is 0.5 seconds (500000 microseconds)
 */
 function preload_requests_delay( $delay_between ) {   
     
     // Edit this value, change the number of seconds
     $seconds = 0.6;
     // finish editing
     
     // All done, don't change this part. 
     $delay_between = $seconds * 1000000;
     
     return $delay_between;
 }
      
add_filter( 'rocket_preload_delay_between_requests', __NAMESPACE__ .'\preload_requests_delay'  );



