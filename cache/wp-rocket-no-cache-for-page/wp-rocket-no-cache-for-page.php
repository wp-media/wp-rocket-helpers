<?php
/**
 * Plugin Name: WP Rocket | Disable Page Caching For Specific Pages or Posts
 * Description: Disables WP Rocket’s page cache file generation on specific pages while preserving other optimization features.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-no-cache-for-page/
 * Author:      WP Rocket Support Team
 * Author URI:  https://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\cache\no_cache_for_page;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Disable cache file generation on specific pages or posts
 * 
 * @author Arun Basil Lal
 */
function no_cache_for_page( $filter ) {
	
	/**
	 * EDIT THIS: Change the ID's (1,2 in this example) to the page or post ID's you want to exclude.
	 **/
	$excluded_ids = array( 1,2 );
	
	// STOP EDITING

	if ( ( function_exists( 'is_page' ) && is_page( $excluded_ids ) ) || ( function_exists( 'is_single' ) && is_single( $excluded_ids ) ) ) {
		return false;
	}
	
	return $filter;
}
add_filter( 'do_rocket_generate_caching_files', __NAMESPACE__ . '\no_cache_for_page' );

/**
 * Cleans entire cache folder on activation.
 *
 * @author Arun Basil Lal
 */
function clean_wp_rocket_cache() {

	if ( ! function_exists( 'rocket_clean_domain' ) ) {
		return false;
	}

	// Purge entire WP Rocket cache.
	rocket_clean_domain();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\clean_wp_rocket_cache' );