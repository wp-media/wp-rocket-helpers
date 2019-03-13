<?php
/**
 * Plugin Name: WP Rocket | Disable LazyLoad on Background Images
 * Description: Disables WP Rocket LazyLoad on background images. 
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/lazyload/wp-rocket-no-lazyload-background-images
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */

namespace WP_Rocket\Helpers\no_lazyload_background_images;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Disable LazyLoad on background images.
 *
 * @author Arun Basil Lal
 */
function do_stuff() {
	add_filter( 'rocket_lazyload_background_images', '__return_false' );
}
add_action( 'wp_rocket_loaded', __NAMESPACE__ . '\do_stuff' );

/**
 * Clean WP Rocket cache on activation.
 *
 * @author Arun Basil Lal
 */
function activate() {
	
	if ( ! function_exists( 'rocket_clean_domain' ) ) {
		return false;
	}

	// Purge entire WP Rocket cache.
	rocket_clean_domain();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\activate' );

/**
 * Clean WP Rocket cache on deactivation.
 *
 * @author Arun Basil Lal
 */
function deactivate() {

	if ( ! function_exists( 'rocket_clean_domain' ) ) {
		return false;
	}

	// Purge entire WP Rocket cache.
	rocket_clean_domain();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );