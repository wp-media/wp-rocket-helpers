<?php
/**
 * Plugin Name: WP Rocket | Deactivate WooCommerce Refresh Cart Fragments Cache
 * Description: Deactivate the WP Rocket feature that caches WooCommerce Refresh Cart Fragments.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/compatibility/wp-rocket-compat-wc-cart-fragments
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

// Namespaces must be declared before any other declaration.
namespace WP_Rocket\Helpers\wc_cart_fragments_cache;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

// Deactivate WooCommerce Refresh Cart Fragments Cache
add_filter( 'rocket_cache_wc_empty_cart', '__return_false' );

/**
 * Cleans entire cache folder on activation.
 *
 * @author Arun Basil Lal
 */
function clean_wp_rocket_cache() {

	if ( ! function_exists( 'rocket_clean_domain' ) ) {
		return false;
	}

	// Purge entire WP Rocket cache.
	rocket_clean_domain();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\clean_wp_rocket_cache' );