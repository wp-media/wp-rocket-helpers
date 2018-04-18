<?php
/**
 * Plugin Name: WP Rocket | Disable CDN URLs on HTTPS pages
 * Description: Prevents rewriting of URLs in HTTPS pages with CDN URLs.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/various/wp-rocket-disable-cdn-on-https/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\cdn\disable_cdn_on_https;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Disable CDN functionality on HTTPS pages 
 *
 * @author Arun Basil Lal
 */
function disable_cdn_on_https() {
	
	/** 
	 * WP Rocket checks for a constant DONOTCDN before replacing links with CDN links. 
	 * @link https://github.com/wp-media/wp-rocket/blob/master/inc/functions/cdn.php#L40
	 */
	if ( is_ssl() ) {
		define( 'DONOTCDN', true );
	}
}
add_action( 'wp_rocket_loaded', __NAMESPACE__ . '\disable_cdn_on_https' );

/**
 * Cleans entire cache on activation and deactivation
 *
 * @author Arun Basil Lal
 */
function clean_domain() {
	
	if ( ! function_exists( 'rocket_clean_domain' ) ) {
		return false;
	}
	
	// Purge entire cache
	rocket_clean_domain();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\clean_domain' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\clean_domain' );