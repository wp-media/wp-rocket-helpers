<?php
/**
 * Plugin Name: WP Rocket | Set Dynamic and Mandatory Cookies
 * Description: Add Mandatory and Dynamic cookies to WP Rocket configuration
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2025
 */

namespace WP_Rocket\Helpers\cache\mandatory_dynamic_cookie;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


/**
 * ===========================================================
 * MANDATORY COOKIES
 * ===========================================================
 */
function add_mandatory_cookies( array $cookies ) {
	
	// Edit below: add one cookie name per line. 
	$cookies[] = 'mandatory_cookie';
	
	return $cookies;
}

/**
 * ===========================================================
 * DYNAMIC COOKIES
 * ===========================================================
 */
function add_dynamic_cookies( array $cookies ) {
	
	// Edit below: add one cookie name per line.
	$cookies[] = 'dynamic_cookie';
	
	return $cookies;
}


// Add cookies to filter
add_filter( 'rocket_cache_mandatory_cookies', __NAMESPACE__ . '\cache_mandatory_cookie' );
add_filter( 'rocket_cache_dynamic_cookies', __NAMESPACE__ . '\cache_dynamic_cookie' );


// Remove .htaccess rewrites, since we need to detect the cookie
add_filter( 'rocket_htaccess_mod_rewrite', '__return_false' );


/**
 * Updates .htaccess, regenerates WP Rocket config file
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
	add_filter( 'rocket_htaccess_mod_rewrite', '__return_false' );
    add_filter( 'rocket_cache_mandatory_cookies', __NAMESPACE__ . '\cache_mandatory_cookie' );
	add_filter( 'rocket_cache_dynamic_cookies', __NAMESPACE__ . '\cache_dynamic_cookie' );

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
	remove_filter( 'rocket_htaccess_mod_rewrite', '__return_false' );
    remove_filter( 'rocket_cache_mandatory_cookies', __NAMESPACE__ . '\cache_mandatory_cookie' );
	remove_filter( 'rocket_cache_dynamic_cookies', __NAMESPACE__ . '\cache_dynamic_cookie' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );
