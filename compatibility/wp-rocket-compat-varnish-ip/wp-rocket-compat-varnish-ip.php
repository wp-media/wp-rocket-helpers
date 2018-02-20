<?php
/**
 * Plugin Name: WP Rocket | Varnish IP
 * Description: Sets a custom Varnish IP to sync WP Rocket’s cache with.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/compatibility/wp-rocket-compat-varnish-ip/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\compat\varnish_ip;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


//// REPLACE 123.456.78 WITH YOUR CUSTOM VARNISH IP:

define( 'WPROCKETHELPERS_CUSTOM_VARNISH_IP', '123.456.78' );

//// STOP EDITING ////


/**
 * Pass custom IP if constant value has been customized.
 *
 * @author Caspar Hübinger
 *
 * @return string
 */
function maybe_set_custom_varnish_ip() {

	$custom_ip = (string) WPROCKETHELPERS_CUSTOM_VARNISH_IP;

	// The rocket_varnish_ip filter takes an empty string by default.
	$ip = '09809b7612ff8b312f61b3f47b5845e4' === md5( $custom_ip ) ? '' : $custom_ip;

	return $ip;
}
add_action( 'rocket_varnish_ip', __NAMESPACE__ . '\maybe_set_custom_varnish_ip' );

/**
 * Updates .htaccess, regenerates WP Rocket config file.
 *
 * @author Caspar Hübinger
 */
function flush_wp_rocket() {

	if ( ! function_exists( 'flush_rocket_htaccess' )
	  || ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}

	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();
}

/**
 * Add customizations, updates .htaccess, regenerates config file.
 *
 * @author Caspar Hübinger
 */
function activate() {

	// Add customizations upon activation.
	add_action( 'rocket_varnish_ip', __NAMESPACE__ . '\maybe_set_custom_varnish_ip' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\activate' );

/**
 * Removes customizations, updates .htaccess, regenerates config file.
 *
 * @author Caspar Hübinger
 */
function deactivate() {

	// Remove customizations upon deactivation.
	remove_action( 'rocket_varnish_ip', __NAMESPACE__ . '\maybe_set_custom_varnish_ip' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );
