<?php
/**
 * Plugin Name: WP Rocket | Insert JS into Footer
 * Description: Injects a custom JavaScript tag before closing body tag.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/various/wp-rocket-footer-insert-js/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

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
