<?php
/**
 * Plugin Name: WP Rocket | Image Dimensions for <picture> and external images
 * Description: Disables / Enables Add Missing Image Dimensions for <picture> and external images
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/various/wp-rocket-media-image-dimensions-picture-external-images
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2020
 */

namespace WP_Rocket\Helpers\media\image_dimensions;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


/** Processes the "img" tag that's included in <picture> tags.
 */
//add_filter( 'rocket_specify_dimension_skip_pictures', '__return_false' );//If you want to use this feature remove the "//" at the beginning of the line.


/** Enable setting image dimensions for external images.
 */
//add_filter( 'rocket_specify_image_dimensions_for_distant', '__return_true' );//If you want to use this feature remove the "//" at the beginning of the line.