<?php
/**
 * Plugin Name: WP Rocket | Exclude X first images from Lazy Load by Attribute
 * Description: Disables lazy load for the first X images by Attribute.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/lazyload/wp-rocket-exclude-x-first-images-by-attribute/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */
namespace WP_Rocket\Helpers\lazyload\exclude_by_attribute;
// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

// EDIT ANY OF THE FOLLOWING AS NEEDED

// change class="ct-image to attribute of your choosing
$pattern = 'class="ct-image';

// change 2 to the how many images need to be skipped from the lazy load
$count = 2;

// STOP EDITING
/**
 * Disable LazyLoad on single post views.
 *
 * @author Adame Dahmani
 * @param  string $html HTML contents.
 * 
 */

add_filter( 'rocket_buffer', function ( $html ) use ($pattern, $count) {
	$html = preg_replace( '/'. $pattern .'/i', 'data-no-lazy="" '. $pattern, $html, $count );
	return $html;
} , 17 );
