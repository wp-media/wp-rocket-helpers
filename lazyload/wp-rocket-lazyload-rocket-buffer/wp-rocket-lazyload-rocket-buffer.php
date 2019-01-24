<?php
/**
 * Plugin Name: WP Rocket | LazyLoad on rocket_buffer
 * Description: Applies WP Rocket LazyLoad on rocket_buffer filter.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/lazyload/wp-rocket-lazyload-rocket-buffer
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\lazyload\rocket_buffer;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Applies LazyLoad on the rocket_buffer filter. 
 *
 * @author Arun Basil Lal
 */
function apply_lazyload_on_rocket_buffer() {

	if ( function_exists( 'rocket_lazyload_images' ) ) {
		add_filter( 'rocket_buffer', 'rocket_lazyload_images', PHP_INT_MAX );
	}
}
add_action( 'wp_rocket_loaded', __NAMESPACE__ . '\apply_lazyload_on_rocket_buffer' );

/**
 * Clean WP Rocket cache
 *
 * @author Arun Basil Lal
 */
function flush_wp_rocket() {

	if ( function_exists( 'rocket_clean_domain' ) ) {
		rocket_clean_domain();
	}
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_wp_rocket' );