<?php
/**
 * Plugin Name: WP Rocket | Remove X-Powered-By: WP Rocket from headers
 * Description: This helper plugin removes WP Rocket’s x-powered-by signature from the response headers.  
 * Plugin URI:  
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2021
 */

namespace WP_Rocket\Helpers\htaccess\remove_xpoweredby;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


add_filter( 'rocket_htaccess_files_match', __NAMESPACE__ .'\wprocket_remove_xpoweredby' );


function wprocket_remove_xpoweredby( $rules ) {
    return str_replace( 'Header set X-Powered-By "WP Rocket/' . WP_ROCKET_VERSION . '"' . PHP_EOL, '', $rules );

}


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

}
register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_wp_rocket' );

/**
 * Removes customizations, updates .htaccess, regenerates config file.
 *
 * @author Caspar Hübinger
 */
function deactivate() {

	// Remove all functionality added above.
	remove_filter('rocket_htaccess_files_match',  __NAMESPACE__ .'\wprocket_remove_xpoweredby');

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );
