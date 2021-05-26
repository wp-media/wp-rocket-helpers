<?php
/**
 * Plugin Name: WP Rocket | Disable Remove Unused CSS For Specific Pages or Posts
 * Description: Disables WP Rocket’s Remove Unused CSS feature on specific pages.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-no-cache-for-page/
 * Author:      WP Rocket Support Team
 * Author URI:  https://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\cache\no_rucss_for_page;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Disable RUCSS on specific pages
 *
 * @author Piotr
 */
function no_rucss_for_page( $filter ) {
	
	//Edit the ids here
	$excluded_ids = array( 1,2 );
	//Only edit the ids above


	if ( ( function_exists( 'is_page' ) && is_page( $excluded_ids ) ) || ( function_exists( 'is_single' ) && is_single( $excluded_ids ) ) ) {
		return false;
	}
	return $filter;
}
add_filter( 'pre_get_rocket_option_remove_unused_css', __NAMESPACE__ . '\no_rucss_for_page');

/**
 * Disable RUCSS on specific posts
 *
 * @author Piotr
 */
function no_rucss_for_url( $filter ) {
	global $wp;
	$url       = untrailingslashit( home_url( add_query_arg( [], $wp->request ) ) );
	$excluded_urls = [
		/*Insert URLs to exclude here one per line and using a comma at the end. See examples below:
	      "https://example.org/",
		  "https://example.org/page/",
		*/

		/*Stop adding exclusions here*/
	];
	if ( in_array( $url, $excluded_urls) ) {
		return false;
	}
	return $filter;
}
add_filter( 'pre_get_rocket_option_remove_unused_css', __NAMESPACE__ . '\no_rucss_for_url' );