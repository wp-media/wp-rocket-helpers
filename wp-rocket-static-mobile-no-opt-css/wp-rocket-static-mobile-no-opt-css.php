<?php
/**
 * Plugin Name: WP Rocket | No Optimized CSS Delivery on Mobile
 * Description: Disables “Optimize CSS delivery” for mobile devices.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

add_action( 'wp', function () {

	// Stop here if WPR is not active.
	if ( ! function_exists( 'get_rocket_option' ) ) {
		return false;
	}

	// Just on mobile devices please
	if ( ! is_admin() && wp_is_mobile() ) {

		// Disable Optimize CSS delivery
		add_filter( 'pre_get_rocket_option_async_css', '__return_zero' );
	}
});
