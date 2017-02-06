<?php
defined( 'ABSPATH' ) or die( 'No direct access here, kiddo.' );
/**
 * Plugin Name: WP Rocket | External Script Handler
 * Description: Prevents external JavaScript calls from being moved to the top of the document during WP Rocket’s minification process.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/wp-rocket-external-js/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Exclude external scripts from WP Rocket’s file optimization.
 *
 * @param  array  $external_js_urls Array of external domains
 * @return array                    Extended array of external domains
 */
function wp_rocket_exclude_external_js_from_optimization( $external_js_hosts ) {

	/**
	 * These are sample hosts, define your own!
	 * @link http://docs.wp-rocket.me/article/39-excluding-external-js-from-minification
	 */
	$external_js_hosts[] = 'apis.google.com';
	$external_js_hosts[] = 'assets.pinterest.com';
	$external_js_hosts[] = 'cdnjs.cloudflare.com';
	$external_js_hosts[] = 'code.jquery.com';
	$external_js_hosts[] = 'connect.facebook.net';
	$external_js_hosts[] = 'js.metrix.getconversion.net';
	$external_js_hosts[] = 'maps.googleapis.com';
	$external_js_hosts[] = 'platform.twitter.com';
	$external_js_hosts[] = 'scripts.mediavine.com';
	$external_js_hosts[] = 'www.google-analytics.com';
	$external_js_hosts[] = 'www.youtube.com';

	/**
	 * This excludes s0.wp.com and s1.wp.com up to s9.wp.com and
	 * v1.wordpress.com (VideoPress) up to v9.wordpress.com.
	 */
	foreach ( range( 0, 9 ) as $n ) {
		$external_js_hosts[] = "s$n.wp.com";
		$external_js_hosts[] = "v$n.wordpress.com";
	}

	return $external_js_hosts;
}
add_filter( 'rocket_minify_excluded_external_js', 'wp_rocket_exclude_external_js_from_optimization' );
