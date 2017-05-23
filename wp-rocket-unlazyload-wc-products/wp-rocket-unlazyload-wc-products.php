<?php
defined( 'ABSPATH' ) or die( 'No direct access to this file.' );
/**
 * Plugin Name: WP Rocket | Unlazyload WooCommerce Product Images
 * Description: Disables LazyLoad on WooCommerce main shop page, product category pages, product tag pages, and single product pages.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-unlazyload-wc-products/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Programmatically disables LazyLoad for specific WooCommerce pages.
 *
 * @link https://docs.woothemes.com/document/conditional-tags/
 * @link http://docs.wp-rocket.me/article/16-disabling-lazyload-on-specific-posts
 * @return bool
 */
function wp_rocket_unlazyload_products() {

	// Make sure WooCommerce is active and running.
	if (
		   ! class_exists( 'WooCommerce' )
		|| ! function_exists( 'is_shop' )
		|| ! function_exists( 'is_product_category' )
		|| ! function_exists( 'is_product_tag' )
		|| ! function_exists( 'is_product' )
		) {
			return;
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

	// Return a value for tests.
	return true;
}
add_filter( 'wp', 'wp_rocket_unlazyload_products' );

/**
 * Render admin notice.
 * @return bool
 */
function wp_rocket_unlazyload_products__render_admin_notice() {

	// Only for admins.
	if ( ! current_user_can( 'manage_options' ) )
		return;

	$current_screen = get_current_screen();

	// Only on WP Rocket settings pages.
	if ( 'admin_notices' === current_filter() && ( isset( $current_screen ) && 'settings_page_wprocket' !== $current_screen->base ) ) {
		return;
	}

	// Only if LazyLoad is enabled.
	if ( ! get_rocket_option( 'lazyload' ) )
		return false;

	// Render message.
	printf(
		'<div class="notice notice-info"><p>%s</p></div>',
		__( '<strong>Note:</strong> LazyLoad is programmatically disabled on WooCommerce product pages by the <em>Unlazyload WooCommerce Product Images</em> plugin.' )
	);

	// Return a value for tests.
	return true;
}
add_action( 'admin_notices', 'wp_rocket_unlazyload_products__render_admin_notice', 100 );
