<?php
defined( 'ABSPATH' ) or die( 'No direct access here.' );
/**
 * Plugin Name: WP Rocket | Debug Helper
 * Description: Checks for various constants, filters, and per-page cache options, prints their values as an HTML comment in the footer of the HTML source code.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-debug-helper/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */


/**
 * Print debug output to footer of HTML source.
 */
function wp_rocket_debug_helper() {

	/**
	 * Disable HTML minification on the fly, otherwise the HTML comment would
	 * get stripped from the source code.
	 */
	add_filter( 'get_rocket_option_minify_html', '__return_false' );

	$html  = PHP_EOL . PHP_EOL;
	$html .= '<!--' . PHP_EOL;
	$html .= '#################################################### ' . PHP_EOL;
	$html .= '## WP ROCKET DEBUG ##' . PHP_EOL;
	$html .= '(HTML minification disabled “on the fly” by this helper plugin in order for this comment to be displayed.)' . PHP_EOL . PHP_EOL;

	/**
	 * Constants
	 */
	$html .= '## Constants' . PHP_EOL . PHP_EOL;

	/**
	 * Cannot use var_export() or print_r() inside an output buffer, so
	 * apologies, this looks a bit wonky.
	 */
	$constant_names = array(
		'WP_CACHE',
		'DONOTCACHEPAGE',
		'DONOTMINIFY',
		'DONOTMINIFYCSS',
		'DONOTMINIFYJS',
	);

	$constant_values = array();

	foreach ( $constant_names as $constant ) {

		if( ! defined( $constant ) ) {
			$constant_values[ $constant ] = 'not defined';
		} else {
			$constant_values[ $constant ] = true === constant( $constant ) || 'true' === constant( $constant ) ? 'true' : 'false';
		}

		$html .= sprintf(
			'- constant %1$s is %2$s',
			$constant,
			$constant_values[ $constant ]
		);
		$html .= PHP_EOL;
	}

	/**
	 * Filters
	 */
	$html .= PHP_EOL . '## Filters' . PHP_EOL . PHP_EOL;

	$maybe_filter = has_filter( 'do_rocket_generate_caching_files' );
	$filter_output = true === $maybe_filter || 'true' === $maybe_filter ? 'set' : 'not set';

	global $wp_filter;

	foreach ( $wp_filter as $filter_name => $filter_value ) {
		if ( false !== strpos( $filter_name, 'do_rocket_generate_caching_files' ) ) {

			$current_filter = $filter_value->current();

			foreach ( $current_filter as $key => $value ) {

				$filter_output .= sprintf( ', value is: %s', var_export( $value['function'], true ) );
			}

		}
	}

	$html .= sprintf( '- filter do_rocket_generate_caching_files is %s', $filter_output ) . PHP_EOL;

	/**
	 * Per-page cache options
	 */
	$html .= PHP_EOL . '## Per-page cache options: ' . PHP_EOL . PHP_EOL;

	$html .= PHP_EOL . '- Cache option rocket_post_nocache: handled through do_rocket_generate_caching_files filter as listed above' . PHP_EOL;

	$cache_options = array(
		'lazyload',
		'lazyload_iframes',
		'minify_html',
		'minify_css',
		'minify_js',
		'cdn',
		'async_css',
		'defer_all_js',
	);

	foreach ( $cache_options as $cache_option ) {

		if ( 0 === get_rocket_option( $cache_option ) ) {

			$html .= sprintf( '- Cache option %s on this page is 0', $cache_option ) . PHP_EOL;

		} elseif ( 0 === get_rocket_option( $cache_option ) ) {

			$html .= sprintf( '- Cache option %s on this page is 1', $cache_option ) . PHP_EOL;

		} elseif ( false === get_rocket_option( $cache_option ) ) {

			$html .= sprintf( '- Cache option %s on this page is false', $cache_option ) . PHP_EOL;

		} else {
			// silence
		}
	}

	$html .= PHP_EOL . '####################################################' . PHP_EOL;
	$html .= '-->' . PHP_EOL;

	echo $html;

}
add_action( 'wp_footer', 'wp_rocket_debug_helper', PHP_INT_MAX );

/**
 * Try to override DONOTCACHEPAGE constant.
 */
// add_filter( 'rocket_override_donotcachepage', '__return_true', PHP_INT_MAX );
