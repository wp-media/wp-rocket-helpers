<?php
/**
 * Plugin Name: WP Rocket | Cache WP Rest API
 * Description: Force WP Rocket to cache WP REST API
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-cache-rest-api
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\cache_wp_rest_api;

defined( 'ABSPATH' ) or die();

add_filter( 'rocket_cache_reject_wp_rest_api', '__return_false' );

/**
 * Updates .htaccess, regenerates WP Rocket config file.
 *
 * @author Arun Basil Lal
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
register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_wp_rocket' );

/**
 * Removes customizations, updates .htaccess, regenerates config file.
 *
 * @author Arun Basil Lal
 */
function deactivate() {

	// Remove all functionality added above.
	remove_filter( 'rocket_cache_reject_wp_rest_api', '__return_false' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );