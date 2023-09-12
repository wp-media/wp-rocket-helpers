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

use WP_Rocket\Dependencies\Database\Query;

add_filter('rocket_remove_rucss_failed_jobs_cron_interval', function () {
	// START EDITING - HOURS IN SECONDS
	$new_interval = 48 * 3600;
	// STOP EDITING
	return $new_interval;
}, 9999);

add_action('rocket_remove_rucss_failed_jobs', function ()
{
	global $wpdb;
	$container = apply_filters('rocket_container', null);
	$rucss_used  = $container->get('rucss_used_css_query');

	$query_find_failed_items = "SELECT * FROM {$wpdb->prefix}wpr_rucss_used_css WHERE status = 'failed'";

	$failed_items = $wpdb->get_results(
		$wpdb->prepare($query_find_failed_items),
		ARRAY_A
	);
	
	$pages_to_clean_preload = [];

	foreach ($failed_items as $failed_item) {
		$pages_to_clean_preload[] = $failed_item["url"];
		$rucss_used->delete_by_url($failed_item["url"]);
	}

	if (function_exists('rocket_clean_post')) {
		foreach ($pages_to_clean_preload as $page_to_clean) {
			rocket_clean_post($page_to_clean);
		}
	}
}, 9999);