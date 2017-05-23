<?php
defined( 'ABSPATH' ) or die( 'No direct access here, kiddo.' );
/**
 * Plugin Name: WP Rocket | EDD Cookie Cache
 * Description: Sets a custom cookie for WP Rocket to generate cache files from.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-edd-cookie/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Adds custom cookie ID to dynamic cache cookies in WP Rocket.
 *
 * @param  array $cookies Dynamic cache cookies
 * @return array          Altered cookie array
 */
function wp_rocket_edd_cookie__dynamic_cookies( $cookies ) {

	$cookies[] = 'wp_rocket_edd';

	return $cookies;
}

/**
 * Register and enqueue script.
 *
 * @return void
 */
function wp_rocket_edd_cookie__enqueue_scripts() {

	$url = plugins_url( 'wp-rocket-edd-cookie.js', __FILE__ );
	$plugin_data = get_file_data( __FILE__, array( 'version' => 'Version' ) );

	wp_register_script( 'wp-rocket-edd-cookie', $url, array( 'edd-ajax' ), $plugin_data['version'] );
	wp_enqueue_script( 'wp-rocket-edd-cookie' );
}
add_action( 'wp_enqueue_scripts', 'wp_rocket_edd_cookie__enqueue_scripts' );


////////////////////////////////////////////////////////////////////////////////
// From here: WP Rocket housekeeping only
////////////////////////////////////////////////////////////////////////////////

/**
 * Register cookies for WP Rocket when plugin is activated.
 *
 * @return bool
 */
function wp_rocket_edd_cookie__activation() {

	// Add required filters.
	add_filter( 'rocket_cache_dynamic_cookies', 'wp_rocket_edd_cookie__dynamic_cookies' );

	// Perform required actions for WP Rocket.
	wp_rocket_edd_cookie__housekeeping();
}
add_action(
	'activate_wp-rocket-edd-cookie/wp-rocket-edd-cookie.php',
	'wp_rocket_edd_cookie__activation',
	11
);

/**
 * Deregister cookies for WP Rocket when plugin is deactivated.
 *
 * @return bool
 */
function wp_rocket_edd_cookie__deactivation() {

	// Remove previously added filters.
	remove_filter( 'rocket_cache_dynamic_cookies', 'wp_rocket_edd_cookie__dynamic_cookies' );

	// Perform required actions for WP Rocket.
	wp_rocket_edd_cookie__housekeeping();
}
add_action(
	'deactivate_wp-rocket-edd-cookie/wp-rocket-edd-cookie.php',
	'wp_rocket_edd_cookie__deactivation',
	11
);


/**
 * Updates WP Rocket .htaccess rules and regenerates config file.
 *
 * @return bool
 */
function wp_rocket_edd_cookie__housekeeping() {

	if ( ! function_exists( 'flush_rocket_htaccess' ) )
		return false;

	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();

	// Return a value for testing.
	return true;
}
