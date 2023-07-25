<?php
/**
 * Plugin Name: WP Rocket | Reduce failed RUCSS jobs clearing interval
 * Description: Reduce failed RUCSS jobs clearing interval for cases that require less than the default 3 days.
 * Plugin URI:  
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */
namespace WP_Rocket\Helpers\rucss\change_failed_interval;

add_filter( 'rocket_remove_rucss_failed_jobs_cron_interval', function ( $interval ) {
    // START EDITING - HOURS IN SECONDS
    $new_interval = 1 * 60 * 60;
    // STOP EDITING
    return $new_interval;
} );