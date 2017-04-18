<?php
defined( 'ABSPATH' ) or die( 'No direct access here.' );
/**
 * Plugin Name: WP Rocket | Constants Debug Helper
 * Description: Checks for defined constants (WP_CACHE, DONOTCACHEPAGE, DONOTMINIFY, DONOTMINIFYCSS, DONOTMINIFYJS) and prints their values as an HTML comment in the footer of the HTML source code.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/wp-rocket-constants-debug-helper/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */


/**
 * Print debug output to footer of HTML source.
 */
function wp_rocket_constants_debug_helper() {

	/**
	 * Disable HTML minification on the fly, otherwise the HTML comment would
	 * get stripped from the source code.
	 */
	add_filter( 'get_rocket_option_minify_html', '__return_false' );

	$html  = PHP_EOL . PHP_EOL;
	$html .= '<!--' . PHP_EOL;
	$html .= '#################################################### ' . PHP_EOL . PHP_EOL;
	$html .= '## WP ROCKET DEBUG ##' . PHP_EOL;
	$html .= '(HTML minification disabled "on the fly" by this helper plugin.)' . PHP_EOL . PHP_EOL;

	$html .= '- constant WP_CACHE is ';
	$html .= defined( 'WP_CACHE' ) ? '"' . var_export( WP_CACHE, true ) . '"' : 'not defined';
	$html .= PHP_EOL . PHP_EOL;

	$html .= '- constant DONOTCACHEPAGE is ';
	$html .= defined( 'DONOTCACHEPAGE' ) ? '"' . var_export( DONOTCACHEPAGE, true ) . '"' : 'not defined';
	$html .= PHP_EOL . PHP_EOL;

	$html .= '- constant DONOTMINIFY is ';
	$html .= defined( 'DONOTMINIFY' ) ? '"' . var_export( DONOTMINIFY, true ) . '"' : 'not defined';
	$html .= PHP_EOL . PHP_EOL;

	$html .= '- constant DONOTMINIFYCSS is ';
	$html .= defined( 'DONOTMINIFYCSS' ) ? '"' . var_export( DONOTMINIFYCSS, true ) . '"' : 'not defined';
	$html .= PHP_EOL . PHP_EOL;

	$html .= '- constant DONOTMINIFYJS is ';
	$html .= defined( 'DONOTMINIFYJS' ) ? '"' . var_export( DONOTMINIFYJS, true ) . '"' : 'not defined';
	$html .= PHP_EOL . PHP_EOL;

	$html .= '####################################################' . PHP_EOL;
	$html .= '-->' . PHP_EOL . PHP_EOL;

	echo $html;

}
add_action( 'wp_footer', 'wp_rocket_constants_debug_helper', PHP_INT_MAX );

/**
 * Try to override DONOTCACHEPAGE constant.
 */
// add_filter( 'rocket_override_donotcachepage', '__return_true', PHP_INT_MAX );
