<?php
/**
 * Plugin Name: WP Rocket | EDD Cookie Cache
 * Description: Sets a custom cookie for WP Rocket to generate cache files from, in order to keep the EDD cart widget in sync.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/compatibility/wp-rocket-compat-edd-cart-widget/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\compat\edd_cart_widget;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Adds custom cookie ID to dynamic cache cookies in WP Rocket.
 *
 * @author Caspar Hübinger
 * @param  array $cookies Dynamic cache cookies
 * @return array          Altered cookie array
 */
function dynamic_cookie( $cookies ) {

	$cookies[] = 'wp_rocket_edd';

	return $cookies;
}

/**
 * Register and enqueue script.
 *
 * @author Caspar Hübinger
 */
function enqueue_scripts() {

	wp_register_script( 'wp-rocket-compat-edd-cart-widget',
		plugins_url( 'wp-rocket-compat-edd-cart-widget.js', __FILE__ ),
		array( 'edd-ajax' ),
		filemtime()
	);

	wp_enqueue_script( 'wp-rocket-compat-edd-cart-widget' );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_scripts' );


////////////////////////////////////////////////////////////////////////////////
// From here: WP Rocket housekeeping only
////////////////////////////////////////////////////////////////////////////////

/**
 * Register cookies for WP Rocket when plugin is activated.
 *
 * @author Caspar Hübinger
 */
function edd_cookie__activation() {

	// Add required filters.
	add_filter( 'rocket_cache_dynamic_cookies', __NAMESPACE__ . '\dynamic_cookie' );

	// Perform required actions for WP Rocket.
	flush_wp_rocket();
}
add_action( __FILE__, __NAMESPACE__ . '\edd_cookie__activation', 11 );

/**
 * Deregister cookies for WP Rocket when plugin is deactivated.
 *
 * @author Caspar Hübinger
 */
function deactivation() {

	// Remove previously added filters.
	remove_filter( 'rocket_cache_dynamic_cookies', __NAMESPACE__ . '\dynamic_cookie' );

	// Perform required actions for WP Rocket.
	flush_wp_rocket();
}
add_action( __FILE__, __NAMESPACE__ . '\deactivation', 11 );


/**
 * Updates WP Rocket .htaccess rules and regenerates config file.
 *
 * @author Caspar Hübinger
 */
function flush_wp_rocket() {

	if ( function_exists( 'flush_rocket_htaccess' ) ) {
		flush_rocket_htaccess();
	}

	if ( function_exists( 'rocket_generate_config_file' ) ) {
		rocket_generate_config_file();
	}
}
