<?php
defined( 'ABSPATH' ) or die();
/**
 * Plugin Name: WP Rocket | VG Wort Pixel
 * Description: Disables LazyLoad for VG Wort tracking pixels.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-vg-wort-pixel/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Applies data-no-lazy attribute to images from vgwort.de.
 *
 * @param  string $content Post content HTML
 * @return string          Modified post content HTML
 */
function wp_rocket__vg_wort_pixel( $content_html ) {

	$dom = new DOMDocument();
	$dom->loadHTML( $content_html );
	$dom->preserveWhiteSpace = false;

	$images = $dom->getElementsByTagName( 'img' );

	foreach ( $images as $image ) {

		$src = $image->getAttribute ( 'src' );

		// Detect VG Wort pixel images.
		if ( strpos( $src, 'vgwort.de' ) !== false ) {

			// Add data-no-lazy attribut.
			$image->setAttribute( 'data-no-lazy', '1' );

			// Remove parent <p> if <img> is its only child node.
			$parent = $image->parentNode;

			if ( 'p' === $parent->tagName && 1 === $parent->childNodes->length ) {
				$parent->parentNode->replaceChild( $image, $parent );
			}
		}
	}

	$content_html = $dom->saveHTML();

	return $content_html;
}
add_filter( 'the_content', 'wp_rocket__vg_wort_pixel' );
