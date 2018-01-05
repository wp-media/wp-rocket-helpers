<?php
defined( 'ABSPATH' ) or die( 'No direct access here.' );
/**
 * Plugin Name: WP Rocket | Remove Rewrite Rules
 * Description: Removes Rewrite Rules block of WP Rocket from .htaccess.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */


// Remove rewrite rules block of WP Rocket from .htaccess.
add_filter('rocket_htaccess_mod_rewrite', '__return_false');

/**
 * Updates .htaccess, and regenerates config file.
 */
function wp_rocket_remove_rewrite_rules__housekeeping() {

	if ( ! function_exists( 'flush_rocket_htaccess' )
	  || ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}

	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();
}
register_activation_hook( __FILE__, 'wp_rocket_remove_rewrite_rules__housekeeping' );

/**
 * Removes plugin additions, updates .htaccess, and regenerates config file.
 */
function wp_rocket_remove_rewrite_rules__deactivate() {

	// We don’t want .htaccess rules added upon deactivation. Remove!
	remove_filter( 'rocket_htaccess_mod_rewrite', '__return_false' );

	// Flush .htaccess rules and regenerate WP Rocket config file.
	wp_rocket_remove_rewrite_rules__housekeeping();
}
register_deactivation_hook( __FILE__, 'wp_rocket_remove_rewrite_rules__deactivate' );
