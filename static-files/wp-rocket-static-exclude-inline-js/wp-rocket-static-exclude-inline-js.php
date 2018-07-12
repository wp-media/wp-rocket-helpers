<?php
/**
 * Plugin Name: WP Rocket | Exclude Inline JS From Combine
 * Description: Exclude specified inline JS from WP Rocket JS combine. 
 * Plugin URI:  {GitHub repo URL of this plugin}
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\exclude_inline_js;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Filter inline JS excluded from being combined.
 * 
 * @param (array) $pattern Patterns to match in inline JS content. 
 * 
 * @author Arun Basil Lal
 */
function exclude_inline_js( $pattern ) {
	
	/**
	 * EDIT BELOW LINE and replace excludethis with a unique string in the inline js that you wish to exclude. 
	 * WP Rocket will search for this string in the inline JS to decide if it should be excluded or not. 
	 * 
	 * Note to developers: A match is looked for using strpos()
	 * 
	 * To exclude mupltiple files, copy the entire line into a new line for each file you wish you exclude.
	 */
	$pattern[] = 'excludethis';
	// STOP EDITING
	
	return $pattern;
}
add_filter( 'rocket_excluded_inline_js_content', __NAMESPACE__ . '\exclude_inline_js' );

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