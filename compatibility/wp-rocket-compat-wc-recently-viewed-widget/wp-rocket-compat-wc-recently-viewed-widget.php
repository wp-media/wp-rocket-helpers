<?php
/**
 * Plugin Name: WP Rocket | WooCommerce Recently Viewed Products Widget Integration
 * Description: Adds a dedicated cache based on each value of the <code>woocommerce_recently_viewed</code> cookie.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/compatibility/wp-rocket-compat-wc-recently-viewed-widget/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2021
 */

namespace WP_Rocket\Helpers\compat\wc_recently_viewed_products_widget;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Return the cookie name set by the WooCommerce Recently Viewed Products built-in widget.
 *
 * @author Vasilis Manthos
 *
 * @param  array $cookies List of cookies.
 * @return array          List of cookies with the WooCommerce Recently Viewed Products cookie appended.
 */
function WC_recently_viewed_products_cookie( $cookies ) {
	$cookies[] = 'woocommerce_recently_viewed';
	return $cookies;
}


// Add cookie name to dynamic caches.
add_filter( 'rocket_cache_dynamic_cookies', __NAMESPACE__ . '\WC_recently_viewed_products_cookie' );// Add cookie ID to cookkies for dynamic caches.

// Add cookie name to mandatory caches.
add_filter( 'rocket_cache_mandatory_cookies', __NAMESPACE__ . '\WC_recently_viewed_products_cookie' );

// Remove .htaccess-based rewrites, since we need to detect the cookie
add_filter( 'rocket_htaccess_mod_rewrite', '__return_false' );


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

/**
 * Add customizations, updates .htaccess, regenerates config file.
 *
 * @author Vasilis Manthos
 */
function activate() {

	// Add customizations upon activation.
	add_filter( 'rocket_htaccess_mod_rewrite', '__return_false' );
	add_filter( 'rocket_cache_dynamic_cookies', __NAMESPACE__ . '\WC_recently_viewed_products_cookie' );
	add_filter( 'rocket_cache_mandatory_cookies_cookies', __NAMESPACE__ . '\WC_recently_viewed_products_cookie' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\activate' );

/**
 * Removes customizations, updates .htaccess, regenerates config file.
 *
 * @author Vasilis Manthos
 */
function deactivate() {

	// Remove customizations upon deactivation.
	remove_filter( 'rocket_htaccess_mod_rewrite', '__return_false' );
	remove_filter( 'rocket_cache_dynamic_cookies', __NAMESPACE__ . '\WC_recently_viewed_products_cookie' );
	remove_filter( 'rocket_cache_mandatory_cookies', __NAMESPACE__ . '\WC_recently_viewed_products_cookie' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );
