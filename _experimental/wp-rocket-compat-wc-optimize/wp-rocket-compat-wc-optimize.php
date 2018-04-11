<?php
/**
 * Plugin Name: WP Rocket | Optimize WooCommerce Cart, Checkout, Account
 * Description: Disables page caching for WooCommerce cart, checkout, and account pages, but keeps other optimization features applicable.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Remove WP Rocket core behaviour.
 *
 * @see wp-rocket/inc/3rd-party/plugins/ecommerce/woocommerce.php#L6
 */
add_action( 'wp_rocket_loaded', function () {
	remove_filter( 'rocket_cache_reject_uri', 'rocket_exclude_woocommerce_pages' );
});

/**
 * Alters WP Rocket’s core behaviours so that page caching is still disabled on
 * cart, checkout, and account pages, but other optimization features (LazyLoad,
 * Minify, Optimize CSS, deferred JS etc.) are applied.
 *
 * @return [type] [description]
 */
add_action( 'template_redirect', function () {

	if ( ! function_exists( 'rocket_exclude_woocommerce_pages' ) ) {
		return;
	}

	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	if ( ! function_exists( 'is_cart' ) || ! function_exists( 'is_checkout' ) || ! function_exists( 'is_account_page' ) ) {
		return;
	}

	/**
	 * Disable page caching on dedicated pages.
	 *
	 * @see https://docs.woocommerce.com/document/conditional-tags/
	 */
	if ( is_cart() || is_checkout() || is_account_page() ) {
		// var_dump( 'HELLO');
		add_filter( 'rocket_override_donotcachepage', '__return_true', PHP_INT_MAX );
		add_filter( 'do_rocket_generate_caching_files', '__return_false' );
	}
});
