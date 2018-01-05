<?php
defined( 'ABSPATH' ) or	die();
/**
 * Plugin Name: WP Rocket | LazyLoad Threshold
 * Description: Define a custom threshold value for lazy-loaded images.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-lazyload-threshold/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */


/**
 * DEFINE YOUR CUSTOM THRESHOLD VALUE.
 *
 * The threshold parameter defines the space in px below the browser viewport
 * where the LazyLoad script would start to load images.
 *
 * The default threshold of 300 means that when an (empty) image container gets
 * scrolled up to a position of 300 px below the viewport, the script starts
 * loading that image.
 *
 * For pages with larger images it can make sense to define a larger threshold,
 * according to the average image height.
 *
 * Define your custom value here:
 */
define( 'WP_ROCKET__LL_CUSTOM_THRESHOLD', 300 );

/**
 * STOP EDITING.
 ******************************************************************************
 */

/**
 * Customise threshold value.
 */
function wp_rocket__lazyload_threshold() {

	return WP_ROCKET__LL_CUSTOM_THRESHOLD;
}
add_filter( 'rocket_lazyload_threshold', 'wp_rocket__lazyload_threshold' );
