<?php
/**
 * Plugin Name: WP Rocket | Optimize WooCommerce Cart, Checkout, Account
 * Description: Disables page caching for WooCommerce cart, checkout, and account pages, but keeps other optimization features applicable.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


/**
 *
 * @param  array $uri  Paths to exclude from caching
 * @return array       Maybe modfied paths to exclude from caching
 */
function never_cache_urls( $uri ) {

	// Edit these to match the WooCommerce URLs. 
	// for multilingual sites, you can add more
	$uris_to_remove = [
		'/checkout',
		'/cart',
		'/my-account',
	];

	foreach ($uri as $key => $value) {
		foreach ($uris_to_remove as $uri_to_remove) {
			if (strpos($value, $uri_to_remove) !== false) {
				unset($uri[$key]);
				break; 
			}
		}
	}

	return $uri;
}
add_filter( 'rocket_cache_reject_uri', __NAMESPACE__ . '\never_cache_urls', PHP_INT_MAX );



/**
 * Alters WP Rocket’s core behaviours so that page caching is still disabled on
 * cart, checkout, and account pages, but other optimization features (LazyLoad,
 * Minify, Optimize CSS, deferred JS etc.) are applied.
 *
 * @return [type] [description]
 */
add_action( 'template_redirect', function () {


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


/**
 * Updates .htaccess, regenerates WP Rocket config file.
 *
 * @author Caspar Hübinger
 */
function flush_wp_rocket() {
	
	if ( ! function_exists( 'flush_rocket_htaccess' )
	  || ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}
	
	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();
	
	// Regenerate WP Rocket config file.
	rocket_generate_config_file();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_wp_rocket' );

/**
 * Removes customizations, updates .htaccess, regenerates config file.
 *
 * @author Caspar Hübinger
 */
function deactivate() {
	
	// Remove all functionality added above.
	remove_filter( 'rocket_cache_reject_uri', __NAMESPACE__ . '\never_cache_urls', PHP_INT_MAX );

	
	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );
