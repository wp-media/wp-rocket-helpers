<?php
/**
 * Plugin Name: WP Rocket | No Optimized CSS Delivery on Mobile
 * Description: Disables optimized CSS delivery for mobile devices.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/static/wp-rocket-static-no-opt-css-mobile/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\static_files\exclude\optimized_css_mobile;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Maybe disable optimized CSS delivery.
 *
 * @author Arun Basil Lal
 * @author Caspar Hübinger
 *
 * @return bool True if optimized CSS delivery was deactivated on a mobile view, else false
 */
function maybe_no_optimized_css() {


	// Only on the front-end.
	if ( is_admin() ) {
		return false;
	}

	// Only if WP Rocket is active.
	if ( ! function_exists( 'get_rocket_option' ) ) {
		return false;
	}

	// Only if “Mobile Cache” is active.
	if ( 1 !== get_rocket_option( 'cache_mobile' ) ) {
		return false;
	}

	// Only if “Separate cache files for mobile devices” is active.
	if ( 1 !== get_rocket_option( 'do_caching_mobile_files' ) ) {
		return false;
	}

	// Only on mobile views.
	if ( ! wp_is_mobile() ) {
		return false;
	}

	// Disable Optimize CSS delivery.
	add_filter( 'pre_get_rocket_option_async_css', '__return_zero' );

	return true;
}
add_action( 'wp', __NAMESPACE__ . '\maybe_no_optimized_css' );
