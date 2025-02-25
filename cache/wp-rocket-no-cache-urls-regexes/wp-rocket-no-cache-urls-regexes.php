<?php
/**
 * Plugin Name: WP Rocket | Regex Exclusions
 * Description: Adds custom cache exclusions based on real Regular Expressions.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-no-cache-urls-regexes/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\cache\no_cache_urls_regexes;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * @param  array $uri  Paths to exclude from caching
 * @return array       Maybe modfied paths to exclude from caching
 */
function never_cache_urls( $uri ) {

	// EDIT HERE:
	/**
	 * Use any regex you'd like, but only target paths of pages (no https:// protocol or domain)
	 * The regex must start with a / to work correctly
	 * Apply as many regexes as you'd like by copying the line below.
	 */
	$uri[] = '/sample/page/[0-9]{4}?\/(.*)';
	// STOP EDITING

	foreach ( $uri as $uri_to_check_key => $uri_to_check_val ) {
		$uri[$uri_to_check_key] = str_starts_with( $uri_to_check_val, '/' ) ? $uri_to_check_val : '/' . $uri_to_check_val;
	}

	return $uri;
}
add_filter( 'rocket_cache_reject_uri', __NAMESPACE__ . '\never_cache_urls' );


/**
 * Apply exclusions on activation and remove them upon deactivation.
 */
function prepare_on_activation() {

	if ( ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\prepare_on_activation' );


function cleanup_on_deactivation() {

	if ( ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}

	remove_filter( 'rocket_cache_reject_uri', __NAMESPACE__ . '\never_cache_urls' );

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\cleanup_on_deactivation' );