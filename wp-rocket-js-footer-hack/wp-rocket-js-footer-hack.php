<?php
defined( 'ABSPATH' ) or die( 'No direct access to this file.' );
/**
 * Plugin Name: WP Rocket | JS Footer Hack
 * Description: Injects a custom JavaScript tag before closing body tag.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-js-footer-hack/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Set up custom <script> tag to be injected before </body>.
 *
 * @return string Custom <script> tag
 */
function wp_rocket_js_footer_hack__print_js() {

	/**
	 * SET CUSTOM JAVASCRIPT URL HERE!
	 */
	$script_url = 'http://example.com/example.js';

	return sprintf( '<script type="text/javascript" src="%1$s"></script>', $script_url );
}

/**
 * Filter cache buffer, inject script tag before body.
 *
 * @uses   wp_rocket_js_footer_hack__print_js
 * @var    $buffer
 * @return string
 */
function wp_rocket_js_footer_hack( $buffer ) {

	$script_tag = wp_rocket_js_footer_hack__print_js();

	// Do not process example code.
	if ( 'http://example.com/example.js' === $script_tag ) {
		
		return $buffer;
	}

	preg_match_all( '/(<\/body>)/i', $buffer, $tags_match );

	foreach ( $tags_match[0] as $tag ) {
		$buffer = str_replace( $tag, $script_tag . $tag, $buffer );
	}

	return $buffer;
}
add_filter( 'rocket_buffer', 'wp_rocket_js_footer_hack', 100 );
