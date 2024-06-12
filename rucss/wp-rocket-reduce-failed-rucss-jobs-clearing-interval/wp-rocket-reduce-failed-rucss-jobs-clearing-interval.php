<?php

/**
 * Plugin Name: WP Rocket | Reduce failed RUCSS jobs clearing interval
 * Description: Temporary fix only. Reduce failed RUCSS jobs clearing interval for cases that require less than the default 3 days.
 * Plugin URI:  
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\rucss\change_failed_interval;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

// EDIT HERE: (Change to false if using WP Rocket version earlier than 3.16)
$is_after_atf_introduced = true;
// STOP EDITING

// Sets how old the failed job should be to be cleared
function set_rocket_delay_remove_rucss_failed_jobs() {
	// EDIT HERE - (You can use hours, minutes, days / day)
	$new_interval = '2 days';
	// STOP EDITING
	return $new_interval;
}

if ( $is_after_atf_introduced ) {
    add_filter( 'rocket_delay_remove_saas_failed_jobs', 'set_rocket_delay_remove_rucss_failed_jobs' );
} else {
    add_filter( 'rocket_delay_remove_rucss_failed_jobs', 'set_rocket_delay_remove_rucss_failed_jobs' );
}

// Reduces the interval of the cron
function rocket_remove_rucss_failed_jobs_cron_interval() {
	// Hours in seconds
	$new_interval = 6 * 3600;
	return $new_interval;
}

if ( $is_after_atf_introduced ) {
  add_filter('rocket_remove_saas_failed_jobs_cron_interval', 'rocket_remove_rucss_failed_jobs_cron_interval', 9999 );
} else {
  add_filter('rocket_remove_rucss_failed_jobs_cron_interval', 'rocket_remove_rucss_failed_jobs_cron_interval', 9999 );
}