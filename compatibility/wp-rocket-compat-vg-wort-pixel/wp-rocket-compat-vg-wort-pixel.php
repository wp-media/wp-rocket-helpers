<?php
/**
 * Plugin Name: WP Rocket | VG Wort Pixel
 * Description: Disables LazyLoad for VG Wort tracking pixels.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/compatibility/wp-rocket-compat-vg-wort-pixel/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\compat\vg_wort_pixel;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude VG Wort host from LazyLoad.
 *
 * @author Caspar Hübinger
 *
 * @param  array  $excluded_src Sources to exclude from LazyLoad
 * @return array                Extended sources to exclude from LazyLoad
 */
function exclude_src( array $excluded_src ) {

	$excluded_src[] = 'vgwort.de';

	return $excluded_src;
}
add_filter( 'rocket_lazyload_excluded_src', __NAMESPACE__ . '\exclude_src' );
