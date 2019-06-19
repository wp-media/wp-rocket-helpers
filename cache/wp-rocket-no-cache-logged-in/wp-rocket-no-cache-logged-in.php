<?php
/**
 * Plugin Name: WP Rocket | Disable Page Caching For Logged-In Users
 * Description: Disables WP Rocket’s page cache for logged-in users (User Cache) while preserving other optimization features.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-no-cache/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */

namespace WP_Rocket\Helpers\cache\no_cache_logged_in;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Disable page caching in WP Rocket.
 *
 * @author Arun Basil Lal
 */

function disable_cache_for_logged_in_user() {
	
	// Check if user is logged-in.
	if( is_user_logged_in() ) {
		add_filter( 'do_rocket_generate_caching_files', '__return_false' );
	}
}
add_action( 'init', __NAMESPACE__ . '\disable_cache_for_logged_in_user' );

/**
 * Cleans entire cache folder on activation.
 *
 * @author Arun Basil Lal
 */
function clean_wp_rocket_cache() {

	if ( ! function_exists( 'rocket_clean_domain' ) ) {
		return false;
	}

	// Purge entire WP Rocket cache.
	rocket_clean_domain();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\clean_wp_rocket_cache' );