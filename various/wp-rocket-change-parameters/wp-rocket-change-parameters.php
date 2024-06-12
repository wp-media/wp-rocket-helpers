<?php
/**
 * Plugin Name: WP Rocket | Change Parameters
 * Description: Reduce the CPU usage by changing the default Preload and RUCSS parameters
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2022
 */

namespace WP_Rocket\Helpers\static_files\various\change_parameters;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

// EDIT HERE: (Change to false if using WP Rocket version earlier than 3.16)
$is_after_atf_introduced = true;
// STOP EDITING

/**
 *  1) PRELOAD BATCH SIZE
 *  Change the number of URLs to preload on each batch, 45 is the default.
 *  A lower value can help the server to work on fewer requests at a time
 */
function preload_batch_size( $value ) {

    // change this value, default is 45 urls:
    $value = 25;

    return $value;
}

add_filter( 'rocket_preload_cache_pending_jobs_cron_rows_count', __NAMESPACE__ . '\preload_batch_size' );



/**
 *  2) PRELOAD CRON INTERVAL:
 *  Set the desired cron interval in seconds
 *  By setting a higher value the server will have more time to rest between processing batches.
 */
function preload_cron_interval( $interval ) {

    // change this value, default is 60 seconds:
    $interval = 120;

    return $interval;
}

add_filter( 'rocket_preload_pending_jobs_cron_interval', __NAMESPACE__ . '\preload_cron_interval' );



/**
 *  3) PRELOAD DELAY BETWEEN REQUESTS:
 *  This is the delay between requests made to the same URL.
 *  for example, for Separate cache files for mobile devices.
 *  Default is 0.5 seconds (500000 microseconds)
 */
function preload_requests_delay( $delay_between ) {

    // Edit this value, change the number of seconds
    $seconds = 1;
    // finish editing

    // All done, don't change this part.
    $delay_between = $seconds * 1000000;

    return $delay_between;
}

add_filter( 'rocket_preload_delay_between_requests', __NAMESPACE__ . '\preload_requests_delay' );



/**
 * 4) RUCSS BATCH SIZE
 *  Change the processing batch value.
 *  A lower value can help the server to work on fewer requests at a time
 */
function rucss_batch_size( $rucss_batch_size ) {

    // change this value, default is 100 urls:
    $rucss_batch_size = 25;

    return $rucss_batch_size;
}

if ( $is_after_atf_introduced ) {
    add_filter( 'rocket_saas_pending_jobs_cron_rows_count', __NAMESPACE__ . '\rucss_batch_size' );
} else {
    add_filter( 'rocket_rucss_pending_jobs_cron_rows_count', __NAMESPACE__ . '\rucss_batch_size' );
}



/**
 *  5) RUCSS CRON Interval:
 *  Set the desired cron interval in seconds
 *  By setting a higher value the server will have more time to rest between processing batches.
 */
function rucss_cron_interval( $cron_interval ) {

    // change this value, default is 60 seconds:
    $cron_interval = 120;

    return $cron_interval;
}

if ( $is_after_atf_introduced ) {
    add_filter( 'rocket_sass_pending_jobs_cron_interval', __NAMESPACE__ . '\rucss_cron_interval' );
} else {
    add_filter( 'rocket_rucss_pending_jobs_cron_interval', __NAMESPACE__ . '\rucss_cron_interval' );
}