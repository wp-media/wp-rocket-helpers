<?php
/**
 * Plugin Name: WP Rocket | YouTube Preview Image Resolution
 * Description: Customizes the resolution of the YouTube preview image for videos.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/lazyload/wp-rocket-lazyload-youtube-preview-image/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\lazyload\youtube_preview_image;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


// EDIT THIS:
// Possibles values: default, mqdefault, sddefault, hqdefault, maxresdefault

define( 'WPROCKETHELPERS_LL_YT_PREVIEW_RESOLUTION', 'hqdefault' );

// STOP EDITING


/**
 * Customise YouTube preview image resolution.
 *
 * @author Remy Perona
 * @param  string $thumbnail_resolution Predefined keyword for preview image resolution, default: hqdefault
 *                                      Possibles values: default, mqdefault, sddefault, hqdefault, maxresdefault
 * @return string                       Maybe modfied resolution keyword
 */
function resolution( $thumbnail_resolution ) {

	$thumbnail_resolution = WPROCKETHELPERS_LL_YT_PREVIEW_RESOLUTION;

	return $thumbnail_resolution;
}
add_filter( 'rocket_lazyload_youtube_thumbnail_resolution', __NAMESPACE__ . '\resolution' );