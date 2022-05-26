<?php
/**
 * Plugin Name: WP Rocket | Set a Mandatory Cookie
 * Description: Adds a mandatory cookie to WP Rocket config.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-cache-mandatory-cookie/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2022
 */

namespace WP_Rocket\Helpers\cache\mandatory_cookie;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


/**
 * Define cookie ID for dynamic caches.
 *
 * @author Caspar Hübinger
 */
 
function cache_mandatory_cookie( array $cookies ) {
    
     // EDIT THIS (you can add more cookie names as needed, one per line):
     $cookies[] = 'your-cookie-name-here';    
     // STOP EDITING
 
     return $cookies;
 }


// Add cookie name to mandatory cookies.
add_filter( 'rocket_cache_mandatory_cookies', __NAMESPACE__ . '\cache_mandatory_cookie' );


// Remove .htaccess rewrites, since we need to detect the cookie,
add_filter( 'rocket_htaccess_mod_rewrite', '__return_false' );


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
	add_filter( 'rocket_htaccess_mod_rewrite', '__return_false' );
    add_filter( 'rocket_cache_mandatory_cookies', __NAMESPACE__ . '\cache_mandatory_cookie' );

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

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );
