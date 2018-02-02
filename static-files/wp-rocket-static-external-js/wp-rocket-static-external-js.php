<?php
/**
 * Plugin Name: WP Rocket | External JS Hosts
 * Description: Prevents external JavaScript calls from being moved to the top of the document during WP Rocket’s minification process.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/static/wp-rocket-static-external-js/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\static_files\external_js;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude external scripts from WP Rocket’s file optimization.
 *
 * @param  array  $external_js_urls Array of external domains
 * @return array                    Extended array of external domains
 */
function hosts( $external_js_hosts ) {

	/**
	 * EDIT THIS:
	 * Uncomment and add your custom external host here.
	 * Duplicate line to add more.
	 */

	// $external_js_hosts[] = 'example.com';

	// STOP EDITING.

	/**
	 * These are popular JS hosts. Make sure to define your own above.
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
	$external_js_hosts[] = 'use.fontawesome.com';      // FontAwesome
	$external_js_hosts[] = 'use.typekit.net';          // Typekit fonts
	$external_js_hosts[] = 'www.google.com';           // Google re-captcha
	$external_js_hosts[] = 'www.google-analytics.com'; // Google Analytics
	$external_js_hosts[] = 'www.googletagmanager.com'; // Google Tag Manager
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

	return $external_js_hosts;
}
add_filter( 'rocket_minify_excluded_external_js', __NAMESPACE__ . '\hosts' );
