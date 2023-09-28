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

// Sets how old the failed job should be to be cleared
add_filter(
	'rocket_delay_remove_rucss_failed_jobs',
	function () {
		// START EDITING - (You can use hours, minutes, days / day)
		$new_interval = '2 days';
		// STOP EDITING
		return $new_interval;
	}
);
// Reduces the interval of the cron
add_filter('rocket_remove_rucss_failed_jobs_cron_interval', function () {
	// No need to edit this (Hours in seconds).
	$new_interval = 6 * 3600;
	return $new_interval;
}, 9999);
