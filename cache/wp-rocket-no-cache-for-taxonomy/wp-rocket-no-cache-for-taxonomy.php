<?php
/**
 * Editted from "WP Rocket | Disable Page Caching For Specific Pages or Posts" by NguyenKhang.me
 * Plugin Name: WP Rocket | Disable Taxonomy Caching For Specific Taxonomy
 * Description: Disables WP Rocket’s taxonomy cache file generation on specific taxonomy while preserving other optimization features.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-no-cache-for-taxonomy/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\cache\no_cache_for_taxonomy;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Disable cache file generation on specific taxonomy
 * 
 * @author Arun Basil Lal and NguyenKhang.me
 */
function no_cache_for_taxonomy( $filter ) {
	
	/**
	 * EDIT THIS: Change the taxonomy name ( it can be 'category','post_tag','link_category','your_taxonomy') to the taxonomy name you want to exclude.
	 **/
	$excluded_tax = 'category';
	
	// STOP EDITING

	if ( ( function_exists( 'taxonomy_exists' ) && taxonomy_exists( $excluded_tax ) ) || ( function_exists( 'is_single' ) && is_single( $excluded_tax ) ) ) {
		return false;
	}
	
	return $filter;
}
add_filter( 'do_rocket_generate_caching_files', __NAMESPACE__ . '\no_cache_for_taxonomy' );

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