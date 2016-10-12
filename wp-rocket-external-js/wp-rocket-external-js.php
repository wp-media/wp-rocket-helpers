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
function wp_rocket_exclude_external_js_from_optimization( $external_js_urls ) {

	/**
	 * These are sample, define your own!
	 * @link http://docs.wp-rocket.me/article/39-excluding-external-js-from-minification
	 */
	$external_js_urls[] = 'cdnjs.cloudflare.com';
	$external_js_urls[] = 'ajax.googleapis.com';
	$external_js_urls[] = 'ssl.google-analytics.com';
	$external_js_urls[] = 'use.typekit.net';

	return $external_js_urls;
}
add_filter( 'rocket_minify_excluded_external_js', 'wp_rocket_exclude_external_js_from_optimization' );
