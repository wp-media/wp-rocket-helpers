<?php
/**
 * Plugin Name: WP Rocket | Meta Charset
 * Description: Moves the <code>&lt;meta charset></code> tag back to the top of <code>&lt;head></code>.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/various/wp-rocket-meta-charset/
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
 * Filter cache buffer, extract meta tag, inject right after opening head tag.
 * @var  $buffer
 * @return void
 */
function wp_rocket_meta_charset_hack( $buffer ) {

	// Find meta charset tag.
	preg_match_all( '/<meta\s+charset=[\'|"]+([^"\']+)(["\'])(\s*\/)?>/iU', $buffer, $meta_tag_matches );

	if ( ! $meta_tag_matches[0] )
		return $buffer;

	// Remove tag from original position, store in variable.
	foreach ( $meta_tag_matches[0] as $tag ) {
		$buffer = str_replace( $tag, '', $buffer );
		$meta_tag = $tag;
		break;
	}

	// Find opening head tag.
	preg_match_all( '/<head(\s+.*)?>/i', $buffer, $head_tag_matches );

	// Inject meta tag right after head tag.
	foreach ( $head_tag_matches[0] as $tag ) {
		$buffer = str_replace( $tag, $tag . $meta_tag, $buffer );
		break;
	}

	return $buffer;
}
add_filter( 'rocket_buffer', 'wp_rocket_meta_charset_hack', 100 );
