<?php
/**
 * Plugin Name: WP Rocket | No LazyLoad for WooCommerce Product Images
 * Description: Disables LazyLoad on WooCommerce main shop page, product category pages, product tag pages, and single product pages.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/compatibility/wp-rocket-compat-wc-product-images/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\compat\wc_product_images;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Programmatically disables LazyLoad for specific WooCommerce pages.
 *
 * @author Caspar Hübinger
 * @link   https://docs.woothemes.com/document/conditional-tags/
 * @link   http://docs.wp-rocket.me/article/16-disabling-lazyload-on-specific-posts
 */
function no_lazyload_for_products() {

	// Make sure WooCommerce is active and running.
	if (
		   ! class_exists( 'WooCommerce' )
		|| ! function_exists( 'is_shop' )
		|| ! function_exists( 'is_product_category' )
		|| ! function_exists( 'is_product_tag' )
		|| ! function_exists( 'is_product' )
		) {
			return false;
		}

	/**
	 * Disable LazyLoad on:
	 * - main shop page
	 * - product category pages,
	 * - product tag pages,
	 * - single product pages
	 */
	if( is_shop() || is_product_category() || is_product_tag() || is_product() ) {
		add_filter( 'do_rocket_lazyload', '__return_false' );
	}
}
add_filter( 'wp', __NAMESPACE__ . '\no_lazyload_for_products' );

/**
 * Maybe render admin notice.
 *
 * @author Caspar Hübinger
 */
function maybe_render_admin_notice() {

	if ( ! maybe_is_admin_on_settings_page() ) {
		return false;
	}

	// Only if LazyLoad is enabled.
	if ( ! get_rocket_option( 'lazyload' ) ) {
		return false;
	}

	// Render message.
	printf(
		'<div class="notice notice-info"><p>%s</p></div>',
		__( '<strong>Note:</strong> LazyLoad is programmatically disabled on WooCommerce product pages by the <em>No LazyLoad for WooCommerce Product Images</em> plugin.' )
	);
}
add_action( 'admin_notices', __NAMESPACE__ . '\maybe_render_admin_notice', 100 );

/**
 * Check if we’re inside the admin_notices filter, on WP Rocket’s settings page,
 * and the current user has permission to manage WP Rocket.
 *
 * @author Caspar Hübinger
 *
 * @return bool True if all of the above, else false
 */
function maybe_is_admin_on_settings_page() {

	// Only to be used in admin_notices filter.
	if ( 'admin_notices' !== current_filter() ) {
		return false;
	}

	// Only if WP Rocket is active.
	if ( ! function_exists( 'get_rocket_option' ) ) {
		return false;
	}

	// Only for WP Rocket administrators.
	if ( ! current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) ) ) {
		return false;
	}

	// Determine screen ID, we may be in white-label mode!
	$current_screen      = get_current_screen();
	$rocket_wl_name      = get_rocket_option( 'wl_plugin_name', null );
	$wp_rocket_screen_id = isset( $rocket_wl_name ) ? 'settings_page_' . sanitize_key( $rocket_wl_name ) : 'settings_page_wprocket';

	// Only on WP Rocket settings page.
	if ( $wp_rocket_screen_id !== $current_screen->base ) {
		return false;
	}

	return true;
}
