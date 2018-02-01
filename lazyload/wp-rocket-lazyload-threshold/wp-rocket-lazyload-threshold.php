<?php
/**
 * Plugin Name: WP Rocket | LazyLoad Threshold
 * Description: Define a custom threshold value for lazy-loaded images.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/lazyload/wp-rocket-lazyload-threshold/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\lazyload\threshold;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * The threshold parameter defines the space in px below the browser viewport
 * where the LazyLoad script would start to load images.
 *
 * The default threshold of 300 means that when an (empty) image container gets
 * scrolled up to a position of 300 px below the viewport, the script starts
 * loading that image.
 *
 * For pages with larger images it can make sense to define a larger threshold,
 * according to the average image height.
 */

// EDIT THIS TO DEFINE YOUR CUSTOM PX VALUE:

define( 'WPROCKETHELPERS_LL_CUSTOM_THRESHOLD', 300 );

// STOP EDITING.

/**
 * Customise threshold value.
 *
 * @author Caspar Hübinger
 * @return integer Custom number of px
 */
function custom_threshold() {

	return WPROCKETHELPERS_LL_CUSTOM_THRESHOLD;
}
add_filter( 'rocket_lazyload_threshold', __NAMESPACE__ . '\custom_threshold' );
