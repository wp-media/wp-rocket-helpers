<?php
/**
 * Plugin Name: WP Rocket | Change Remove Unused CSS Parameters
 * Description: Change the number of URLs per batch, and the CRON interval of Remove Unused CSS
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/rucss/wp-rocket-rucss-change-parameters/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2021
 */

namespace WP_Rocket\Helpers\static_files\rucss\change_parameters;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


/**
 *  BATCH SIZE
 *  Change the processing batch value.
 *  A lower value can help the server to work on fewer requests at a time
 */     
function rucss_batch_size( $rucss_batch_size ) {   
    
     // change this value, default is 100 urls:
     $rucss_batch_size = 10; 
     
     return $rucss_batch_size;
 }
     
add_filter( 'rocket_rucss_pending_jobs_cron_rows_count', __NAMESPACE__ .'\rucss_batch_size'  );



/**
 *  CRON Interval:
 *  Set the desired cron interval in seconds
 *  By setting a higher value the server will have more time to rest between processing batches.
 */
 function rucss_cron_interval( $cron_interval ) {   
     
     // change this value, default is 60 seconds:
     $cron_interval = 300; 
     
     return $cron_interval;
 }
	 
add_filter( 'rocket_rucss_pending_jobs_cron_interval', __NAMESPACE__ .'\rucss_cron_interval'  );


