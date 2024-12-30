<?php
/**
 * Plugin Name: WP Rocket | RUCSS Set Minimum Acceptable Size
 * Description: Set the minimum size of Used CSS that can be acceptable to avoid broken pages.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\rucss\set_rucss_min_css_size;

// Standard plugin security, keep this line in place.
defined('ABSPATH') or die();


/**
 *  SET THE MIN CSS SIZE
 *  You can change the size of the minimun acceptable value. 150 is the default.
 *
 *  1) Use Postman to see the size of the usedCSS, is at the very bottom as shakedCSS_size
 *  The size in in bytes. So for example, if the shakedCSS_size is 131827 this equals 132KB, this is the "good size".
 *
 *  2) Copy and paste the used css from a broken URL on a tool as https://www.javainuse.com/bytesize. This is the "bad size".
 *  The "bad" size should much lower than the "good" size, and this will give you the limit you have to set at rucss_min_css_size.
 *  
 *  Some examples of limits: 
 *  
 *  2kb  = 2000
 *  4kb  = 4000
 *  8kb  = 8000
 *  10kb = 10000
 *  12kb = 12000
 *  14kb = 14000
 */
function rucss_min_css_size($value) {

    // change this value to be a bit bigger than the "bad size", default is 150 (bytes):
    $value = 10000; // 10kb

    return $value;
}

add_filter('rocket_min_rucss_size', __NAMESPACE__ . '\rucss_min_css_size');

