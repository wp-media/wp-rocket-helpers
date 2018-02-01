<?php
/**
 * Plugin Name: WP Rocket | Domain Ending Length
 * Description: Sets a custom length for TLD endings to pass WP Rocket’s domain validation.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-cache-domain-ending/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\cache\domain_ending;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

// EDIT THIS NUMBER TO REFLECT THE NUMBER OF CHARACTERS IN YOUR DOMAIN ENDING:

define( 'WPROCKETHELPERS_DOMAIN_ENDING', '7' );

// STOP EDITING

/**
 * Number of characters considered a valid TLD by WP Rocket.
 *
 * @author Caspar Hübinger
 * @param  string $length TLD character count (default: '6')
 * @return string         Customised TLD character count
 */
function length( $length ) {

	$length = WPROCKETHELPERS_DOMAIN_ENDING;

	return $length;
}
add_filter( 'rocket_get_domain_preg', __NAMESPACE__ . '\length' );
