<?php
defined( 'ABSPATH' ) or die( 'No direct access here, kiddo.' );
/**
 * Plugin Name: WP Rocket | Unforce GZIP
 * Description: Removes GZIP-related .htaccess rules.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-unforce-gzip/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Removes GZIP-related .htaccess rules.
 *
 * @link http://docs.wp-rocket.me/article/52-fix-for-weird-characters-displaying-on-your-web-page
 */
add_filter( 'rocket_force_gzip_htaccess_rules', '__return_false' );

/**
 * Updates .htaccess, and regenerates config file.
 *
 * @return bool
 */
function wp_rocket_unforce_gzip__housekeeping() {

	if ( ! function_exists( 'flush_rocket_htaccess' )
	  || ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}

	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();

	// Return a value for testing.
	return true;
}
register_activation_hook( __FILE__, 'wp_rocket_unforce_gzip__housekeeping' );

/**
 * Removes plugin additions, updates .htaccess, and regenerates config file.
 *
 * @return bool
 */
function wp_rocket_unforce_gzip__deactivate() {

	// We don’t want .htaccess rules added upon deactivation. Remove!
	remove_filter( 'rocket_force_gzip_htaccess_rules', '__return_false' );

	// Flush .htaccess rules and regenerate WP Rocket config file.
	wp_rocket_unforce_gzip__housekeeping();
}
register_deactivation_hook( __FILE__, 'wp_rocket_unforce_gzip__deactivate' );
