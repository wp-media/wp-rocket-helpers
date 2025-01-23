<?php
/**
 * Plugin Name: WP Rocket | Common Cache For Logged-in Users
 * Description: Use a common cache for all logged-in users instead of creating a user specific cache. Note: Logged out users will have a different cache. 
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-cache-common-cache-loggedin
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\common_cache_loggedin;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Filters the activation of the common cache for logged-in users.
 *
 * Adding the filter in itself will not enable common cache.
 * The filter is used to set the value of $rocket_common_cache_logged_users (as 1) in the WP Rocket config file. 
 * 
 * @link https://github.com/wp-media/wp-rocket/blob/33578f0dd568819d3e5912e38cafb9d51d5964d7/inc/functions/files.php#L98-L100
 */
add_action( 'update_option', function( $option_name, $old_value, $value ) {

	if ( $option_name !== 'wp_rocket_settings' ) { 
		return;
	}

	if ( $value['cache_logged_user'] ) {
		add_filter( 'rocket_common_cache_logged_users', '__return_true' );
	}
	else {
		remove_filter( 'rocket_common_cache_logged_users', '__return_true' );
	}
}, 9999, 3 );


// We also need to account for when WP Rocket is activated/deactivated while this helper plugin is activated
// The update_option hook won't fire in this case, so we check for the option directly
if ( get_option( 'wp_rocket_settings', [] )['cache_logged_user'] ) {
	add_filter( 'rocket_common_cache_logged_users', '__return_true' );
}
else {
	remove_filter( 'rocket_common_cache_logged_users', '__return_true' );
}


/**
 * Regenerates WP Rocket config file.
 *
 * @author Arun Basil Lal
 */
function flush_wp_rocket() {

	if ( ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_wp_rocket' );

/**
 * Remove common cache and regenerates WP Rocket config file.
 *
 * @author Arun Basil Lal
 */
function deactivate() {

	if ( ! is_plugin_active( 'wp-rocket/wp-rocket.php' ) ) {
		return false;
	}

	// Remove the filter to enable common cache for logged-in users. 
	remove_filter( 'rocket_common_cache_logged_users', '__return_true' );

	// Regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );