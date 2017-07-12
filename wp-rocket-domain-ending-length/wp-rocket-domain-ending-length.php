<?php
defined( 'ABSPATH' ) or die( 'No direct access to this file.' );
/**
 * Plugin Name: WP Rocket | Domain Ending Length
 * Description: Sets a custom length for TLD endings to pass WP Rocket’s domain validation.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-custom-tld-length/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Number of characters considered a valid TLD by WP Rocket.
 * @param  string $length TLD character count; default: '6'
 * @return string         Customised TLD character count
 */
function wp_rocket__custom_tld_length( $length ) {

	// EDIT THIS TO REFLECT THE NUMBER OF CHARACTERS IN YOUR DOMAIN ENDING.
	$length = '7';
	// STOP EDITING.

	return $length;
}
add_filter( 'rocket_get_domain_preg', 'wp_rocket__custom_tld_length' );
