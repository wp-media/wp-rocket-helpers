<?php
defined( 'ABSPATH' ) or die( 'No direct access here, kiddo.' );
/**
 * Plugin Name: WP Rocket | Force Page Caching
 * Description: Ensures caching even when <code>DONOTCACHEPAGE</code> is set.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/wp-rocket-override-donotcachepage/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Override DONOTCACHEPAGE behavior for WP Rocket cache.
 */
add_filter( 'rocket_override_donotcachepage', '__return_true', PHP_INT_MAX );

/**
 * Updates .htaccess and re-generate config file when plugin is activated.
 */
add_action(
	'activate_wp-rocket-override-donotcachepage/wp-rocket-override-donotcachepage.php',
	'wp_rocket_override_donotcachepage__housekeeping',
	11
);

/**
 * Updates .htaccess and re-generate config file when plugin is deactivated.
 */
add_action(
	'deactivate_wp-rocket-override-donotcachepage/wp-rocket-override-donotcachepage.php',
	'wp_rocket_override_donotcachepage__housekeeping',
	11
);

/**
 * Updates WP Rocket .htaccess rules and regenerates config file.
 *
 * @return bool
 */
function wp_rocket_override_donotcachepage__housekeeping() {

	if ( ! function_exists( 'flush_rocket_htaccess' ) )
		return false;

	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();

	// Return a value for testing.
	return true;
}
