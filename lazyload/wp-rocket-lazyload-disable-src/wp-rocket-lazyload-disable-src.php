<?php
/**
 * Plugin Name: WP Rocket | No LazyLoad for Custom Image Sources
 * Description: Disables LazyLoad for image sources specified in this plugin.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/lazyload/wp-rocket-lazyload-disable-src/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\lazyload\exclude_sources;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude specified image sources from LazyLoad.
 *
 * @author Caspar Hübinger
 *
 * @param  array  $excluded_src Sources to exclude from LazyLoad
 * @return array                Extended sources to exclude from LazyLoad
 */
function exclude_src( array $excluded_src ) {

	// EDIT/REPLACE THESE EXAMPLES:

	$excluded_src[] = 'example.com';    // <img src="example.com">
	$excluded_src[] = '/example-path';  // <img src="/example-path/image.jpg">
	$excluded_src[] = '/example?query'; // <img src="example?query=image.jpg">

	// STOP EDITING.

	return $excluded_src;
}
add_filter( 'rocket_lazyload_excluded_src', __NAMESPACE__ . '\exclude_src' );
