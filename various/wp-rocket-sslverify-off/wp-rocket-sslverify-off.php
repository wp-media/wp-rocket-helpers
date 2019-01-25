<?php
/**
 * Plugin Name: WP Rocket | Disable SSL Certificate Validation
 * Description: Disable SSL Certificate Validation for wp_remote_get requests in WP Rocket by setting sslverify to false. 
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/various/wp-rocket-sslverify-off
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */

// EDIT THIS: Replace `boilerplate` with your custom subnamespace.
// Namespaces must be declared before any other declaration.
namespace WP_Rocket\Helpers\preload\wp_rocket_sslverify_off;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Disable SSL Cerfiticate Validation for WP Rocket's wp_remote_get requests. 
 *
 * Used mostly for preload requests. 
 * 
 * @author Arun Basil Lal
 */
function disable_ssl_validation() {
	add_filter( 'https_local_ssl_verify', '__return_false' );
}
add_action( 'wp_rocket_loaded', __NAMESPACE__ . '\disable_ssl_validation' );