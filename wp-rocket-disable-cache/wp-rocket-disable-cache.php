<?php
defined( 'ABSPATH' ) or die( 'No direct access to this file.' );
/**
 * Plugin Name: WP Rocket | Disable Page Caching
 * Description: Disables WP Rocket’s page cache while preserving other optimization features.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-disable-cache/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Disable page caching in WP Rocket.
 * @link http://docs.wp-rocket.me/article/61-disable-page-caching
 */
add_filter( 'do_rocket_generate_caching_files', '__return_false' );

/**
 * Updates .htaccess, and regenerates config file.
 *
 * @return bool
 */
function wp_rocket__disable_cache__housekeeping() {

	if ( ! function_exists( 'flush_rocket_htaccess' )
	  || ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}

	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();

	return true;
}
register_activation_hook( __FILE__, 'wp_rocket__disable_cache__housekeeping' );

/**
 * Removes plugin additions, updates .htaccess, and regenerates config file.
 *
 * @return bool
 */
function wp_rocket__disable_cache__deactivate() {

	// We don’t want .htaccess rules added upon deactivation. Remove!
	remove_filter( 'do_rocket_generate_caching_files', '__return_false' );

	// Flush .htaccess rules and regenerate WP Rocket config file.
	wp_rocket__disable_cache__housekeeping();
}
register_deactivation_hook( __FILE__, 'wp_rocket__disable_cache__deactivate' );
