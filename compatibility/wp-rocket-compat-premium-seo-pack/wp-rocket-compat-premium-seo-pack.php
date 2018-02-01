<?php
/**
 * Plugin Name: WP Rocket | Unload PSP Styles
 * Description: Premium SEO Pack (PSP) loads styles and scripts on all WordPress admin pages which makes WP Rocket’s settings page unusable. This helper plugin unloads PSP styles just on WP Rocket’s settings page.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/compatibility/wp-rocket-compat-premium-seo-pack/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\compat\premium_seo_pack;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Maybe dequeue PSP admin stylesheet.
 *
 * @author Arun Basil Lal
 * @author Caspar Hübinger
 */
function maybe_unload_psp_styles( ) {

	if ( ! function_exists( 'get_rocket_option' ) ) {
		return false;
	}

	// Determine screen ID, we may be in white-label mode!
	$current_screen      = get_current_screen();
	$rocket_wl_name      = get_rocket_option( 'wl_plugin_name', null );
	$wp_rocket_screen_id = isset( $rocket_wl_name ) ? 'settings_page_' . sanitize_key( $rocket_wl_name ) : 'settings_page_wprocket';

	// Retun on all pages but WP Rocket settings page.
	if ( $wp_rocket_screen_id !== $current_screen->base ) {
		return false;
	}

	// Dequeueing this style unfreezes WP Rocket.
	wp_dequeue_style( 'psp-main-style' );
}
add_action( 'admin_print_styles', __NAMESPACE__ . '\maybe_unload_psp_styles', 11 );
