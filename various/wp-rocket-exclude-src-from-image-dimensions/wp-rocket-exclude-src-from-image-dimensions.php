<?php
/**
 * Plugin Name: WP Rocket | Exclude Custom Image Sources from Image Dimensions
 * Description: Disables Image Dimensions for image sources specified in this plugin.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/ImageDimensions/exclude-src-from-image-dimensions/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\imagedimesions\exclude_sources;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude specified image sources from Image Dimensions.
 *
 * @author Ahmed Saed
 *
 * @param  array  $images Image tags found on the current page.
 * @return array  Image tags after removing the exclusions.
 */
function exclude_src( array $images ) {

	// EDIT/REPLACE THESE EXAMPLES:

	$excluded_src = [
		'https://domain.ext/path/to/image.ext',
		'https://domain.ext/path/to/image-2.ext',
	];

	// STOP EDITING.

	$excluded_src = array_map(function($src){
		return preg_quote($src, '#');
	}, $excluded_src);

	$filtered_images = array_filter($images, function($img) use ($excluded_src) {
	    return ! preg_match('#'.implode('|', $excluded_src).'#', $img);
	});
	

	return $filtered_images;
}

add_filter( 'rocket_specify_dimension_images', __NAMESPACE__ . '\exclude_src' );
