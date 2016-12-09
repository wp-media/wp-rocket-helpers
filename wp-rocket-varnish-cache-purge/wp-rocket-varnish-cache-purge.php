<?php
defined( 'ABSPATH' ) or die( 'No direct access here, kiddo.' );
/**
 * Plugin Name: WP Rocket | Varnish Cache Purging
 * Description: Forces Varnish cache purging with WP Rocket 2.6.8 to 2.6.16.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/wp-rocket-varnish-cache-purge/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */


/**
 * Forces purging of Varnish cache.
 *
 * @return bool   True if filter was added
 */
function wp_rocket_varnish_cache_purge__do_rocket_varnish_http_purge() {

	if ( ! defined( 'WP_ROCKET_VERSION' ) )
		return false;

	$v = WP_ROCKET_VERSION;

	// v2.6.8 or higher; not needed anymore since v2.7.
	if ( version_compare( $v, '2.6.8', '<' ) || version_compare( $v, '2.7', '>' ) )
		return false;

	add_filter( 'do_rocket_varnish_http_purge', '__return_true' );

	return true;
}
add_action( 'init', 'wp_rocket_varnish_cache_purge__do_rocket_varnish_http_purge' );
