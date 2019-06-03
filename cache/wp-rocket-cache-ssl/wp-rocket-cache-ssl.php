<?php
/**
 * Plugin Name: WP Rocket | Enable SSL Cache
 * Description: Enables SSL cache so that WP Rocket caches pages with SSL.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-cache-ssl
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */

namespace WP_Rocket\Helpers\cache\ssl;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Enables SSL Cache in database and regenerates WP Rocket config file.
 *
 * @author Arun Basil Lal
 */
function enable_ssl_cache() {

	if ( ! function_exists( 'update_rocket_option' ) || ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}
	
	// Enable SSL Cache
	update_rocket_option( 'cache_ssl', 1 );

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\enable_ssl_cache' );