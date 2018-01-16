<?php
/**
 * Plugin Name: WP Rocket | Varnish IP
 * Description: Sets a custom Varnish IP to sync WP Rocket’s cache with.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-varnish-ip/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Copyright WP Media 2018
 */

// Standard plugin security, don’t remove this line.
defined( 'ABSPATH' ) or die();


//// REPLACE 123.456.78 WITH YOUR CUSTOM VARNISH IP:
define( 'WP_ROCKET_CUSTOM_VARNISH_IP', '123.456.78' );
//// STOP EDITING ////


/**
 * Adds customizations once WP Rocket has loaded.
 */
function wp_rocket_varnish_ip__custom_ip() {

	// Returns false if example value hasn’t been changed.
	return '123.456.78' === WP_ROCKET_CUSTOM_VARNISH_IP ? false : WP_ROCKET_CUSTOM_VARNISH_IP;

}
add_action( 'rocket_varnish_ip', 'wp_rocket_varnish_ip__custom_ip' );

/**
 * Updates .htaccess, regenerates WP Rocket config file.
 */
function wp_rocket_varnish_ip__flush() {

	if ( ! function_exists( 'flush_rocket_htaccess' )
	  || ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}

	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();
}
register_activation_hook( __FILE__, 'wp_rocket_varnish_ip__flush' );

/**
 * Removes customizations, updates .htaccess, regenerates config file.
 */
function wp_rocket_varnish_ip__deactivate() {

	// Remove all added functionality.
	remove_action( 'rocket_varnish_ip', 'wp_rocket_varnish_ip__custom_ip' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	wp_rocket_varnish_ip__flush();
}
register_deactivation_hook( __FILE__, 'wp_rocket_varnish_ip__deactivate' );
