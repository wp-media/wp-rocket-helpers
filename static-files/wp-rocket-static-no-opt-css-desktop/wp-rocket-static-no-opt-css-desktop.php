<?php
/**
 * Plugin Name: WP Rocket | No Optimized CSS Delivery on Desktop
 * Description: Disables optimized CSS delivery for desktop devices.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2021
 */
 
namespace WP_Rocket\Helpers\static_files\exclude\optimized_css_desktop;
 
// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();
 
function maybe_no_optimized_css() {
 
 
	// Only on the front-end.
	if ( is_admin() ) {
		return false;
	}
 
	// Only if WP Rocket is active.
	if ( ! function_exists( 'get_rocket_option' ) ) {
		return false;
	}
 
	// Only activate it on mobile views.
	if ( wp_is_mobile() ) {
		return false;
	}
 
	// Disable Optimize CSS delivery.
	add_filter( 'pre_get_rocket_option_async_css', '__return_zero' );
 
	return true;
}
add_action( 'wp', __NAMESPACE__ . '\maybe_no_optimized_css' );
