<?php
/**
 * Plugin Name: WP Rocket | Custom cURL Timeout For Preload Requests
 * Description: Increase the timeout for cURL from 5 seconds for preload requests.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/preload/wp-rocket-custom-preload-curl-timeout
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\preload\custom_request_curl_timeout;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Increase cURL timeout for preload request. 
 * 
 * @link https://github.com/wp-media/wp-rocket/blob/5caf48cafa91dec035c51264bc0aef6aae84112c/inc/functions/bots.php#L196-L207
 * @link https://codex.wordpress.org/Function_Reference/wp_remote_get
 * 
 * @author Arun Basil Lal
 */
function custom_curl_timeout( $args ) {
	
	/** 
	 * Making sure that the timeout set here is not changed.
	 * https://github.com/wp-media/wp-rocket/blob/82680e5c8884c4c08bf547f4d4802d4b7d8cb93f/inc/classes/preload/class-partial-process.php#L54
	 */
	if ( isset( $args['timeout'] ) && ( $args['timeout'] === 0.01 ) ) {
		return $args;
	}
	
	// EDIT HERE: Specify the timeout in seconds. Default is 5 seconds. 
	$args['timeout'] = 30;
	
	return $args;
}
add_filter( 'rocket_preload_sitemap_request_args', __NAMESPACE__ . '\custom_curl_timeout' );
add_filter( 'rocket_partial_preload_url_request_args', __NAMESPACE__ . '\custom_curl_timeout' );