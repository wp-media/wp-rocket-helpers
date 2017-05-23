<?php
defined( 'ABSPATH' ) or die( 'No direct access here.' );
/**
 * Plugin Name: WP Rocket | External Script Handler
 * Description: Prevents external JavaScript calls from being moved to the top of the document during WP Rocket’s minification process.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-external-js/
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
	 * These are popular JS hosts. Make sure to define your own furhter below.
	 * @link http://docs.wp-rocket.me/article/39-excluding-external-js-from-minification
	 */
	$external_js_hosts[] = 'ajax.googleapis.com';      // custom jQuery
	$external_js_hosts[] = 'apis.google.com';          // Google+ sharing
	$external_js_hosts[] = 'assets.pinterest.com';     // Pinterest sharing
	$external_js_hosts[] = 'cdnjs.cloudflare.com';     // custom jQuery
	$external_js_hosts[] = 'code.jquery.com';          // custom jQuery
	$external_js_hosts[] = 'connect.facebook.net';     // Facebook sharing
	$external_js_hosts[] = 'maps.googleapis.com';      // Google maps
	$external_js_hosts[] = 'platform.twitter.com';     // embedded Twitter
	$external_js_hosts[] = 'secure.gravatar.com';      // Gravatar pictures
	$external_js_hosts[] = 'use.typekit.net';          // Typekit fonts
	$external_js_hosts[] = 'www.google.com';           // Google re-captcha
	$external_js_hosts[] = 'www.google-analytics.com'; // Google Analytics
	$external_js_hosts[] = 'www.youtube.com';          // embedded YouTube

	/**
	 * This excludes s0.wp.com and s1.wp.com up to s9.wp.com and
	 * v1.wordpress.com (VideoPress) up to v9.wordpress.com.
	 * Not sure how many of those exist, so 0-9 seemed safe. :)
	 */
	foreach ( range( 0, 9 ) as $n ) {
		$external_js_hosts[] = "s$n.wp.com";
		$external_js_hosts[] = "v$n.wordpress.com";
	}

	/**
	 * Put your custom code here!
	 */
	// $external_js_hosts[] = 'example.com';

	return $external_js_hosts;
}
add_filter( 'rocket_minify_excluded_external_js', 'wp_rocket_exclude_external_js_from_optimization' );
