<?php
/**
 * Plugin Name: WP Rocket | Desktop version of Critical CSS on Mobile
 * Description: Makes sure that Desktop version of Critical CSS is beign used on mobiles when Separate Cache for Mobile Devices is enabled.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/static/wp-rocket-static-desktop-opt-css-mobile/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2020
 */

namespace WP_Rocket\Helpers\static_files\exclude\desktop_optimized_css_mobile;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Maybe disable optimized CSS delivery.
 *
 * @author Arun Basil Lal
 * @author Caspar Hübinger
 * @author Piotr Bak
 *
 * @return bool True if desktop critical CSS was used on a mobile view, else false
 */
function maybe_desktop_optimized_css() {

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

	// Disable Mobile specific Optimize CSS delivery but preserve the real one.
	add_filter( 'pre_get_rocket_option_async_css_mobile', '__return_zero' );

	return true;
}
add_action( 'wp', __NAMESPACE__ . '\maybe_desktop_optimized_css' );
