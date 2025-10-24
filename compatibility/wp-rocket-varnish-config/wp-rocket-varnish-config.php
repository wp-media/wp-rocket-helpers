<?php
/**
 * Plugin Name: WP Rocket | Varnish customize parameters
 * Description: Sets a custom Varnish IP and host name to sync WP Rocket’s cache with.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/
 * Author:      WP Rocket Support Team
 * Author URI:  https://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA
 */

namespace WP_Rocket\Helpers\compat\varnish_ip_host;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Add custom Varnish IPs.
 */
function set_custom_varnish_ips( $ips ) {
	if ( ! is_array( $ips ) ) {
		$ips = (array) $ips;
	}

	// Add your Varnish IPs here. Add the port if needed, like this $ips[] = '13.1.2.3:23457';
	$ips[] = '127.0.0.1:80';
	
	return $ips;
}
add_filter( 'rocket_varnish_ip', __NAMESPACE__ . '\set_custom_varnish_ips' );


/**
 * Override the URL used in purge requests useful when using a proxy.
 */
function set_custom_varnish_host( $host ) {
	
	// Replace with your site’s public hostname. Example: 'example.com'
	
	$custom_host = 'example.com';	
	
	if ( ! empty( $custom_host ) ) {
		return $custom_host;
	}

	return $host;
}
add_filter( 'rocket_varnish_purge_request_host', __NAMESPACE__ . '\set_custom_varnish_host' );


/**
 * Customize the scheme (http/https) used in purge requests.
 */
function set_custom_varnish_scheme( $scheme ) {
	
	// Change to 'https' if your Varnish listens on secure port
	return 'http'; // or 'https'
}
add_filter( 'rocket_varnish_http_purge_scheme', __NAMESPACE__ . '\set_custom_varnish_scheme' );



/**
 * Customize Varnish purge request args.
 */
function set_custom_varnish_args( $args ) {
	// Example: change method from PURGE to BAN
	$args['method'] = 'PURGE'; // or 'BAN'

	// Example: make it blocking if you want to wait for response
	$args['blocking'] = false;

	// Example: no redirects
	$args['redirection'] = 0;

	// You can also add or override headers here
	if ( isset( $args['headers'] ) && is_array( $args['headers'] ) ) {
		$args['headers']['X-Debug'] = 'WP-Rocket-Varnish-Helper';
	}

	return $args;
}
add_filter( 'rocket_varnish_purge_request_args', __NAMESPACE__ . '\set_custom_varnish_args' );
