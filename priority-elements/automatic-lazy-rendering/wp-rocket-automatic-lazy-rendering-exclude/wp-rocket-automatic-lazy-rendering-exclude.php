<?php
/**
 * Plugin Name: WP Rocket | Exclude specific elements from Automatic Lazy Rendering
 * Description: Allows to exclude specific elements from the Automatic Lazy Rendering optimization
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\alr_exclude;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();



// Prevent the content-visibility optimization
function wpr_alr_override_style() {

    // Replace ".site-footer" with the element you'd like to exclude. 
    // you can use IDs, Classes, etc
    // if you want to exclude more than one element, you can separate with comma: 
    // .element1, #element2, svg {...
    
    // START editing

    $custom_css = "
    
    .site-footer  
    
    {content-visibility:visible!important}";
    
    // STOP editing


    wp_add_inline_style('rocket-lazyrender-inline-css-exclusions', $custom_css);
}
add_action('wp_enqueue_scripts', __NAMESPACE__ .'\wpr_alr_override_style', PHP_INT_MAX);



// register the style sheet
function wpr_alr_custom_enqueue_styles() {

    wp_register_style('rocket-lazyrender-inline-css-exclusions', false);
    wp_enqueue_style('rocket-lazyrender-inline-css-exclusions');
}
add_action('wp_enqueue_scripts', __NAMESPACE__.'\wpr_alr_custom_enqueue_styles', 20);



// exclude this inline style from Remove Unused CSS
function inline_atts_exclusions($inline_atts_exclusions) {

    $inline_atts_exclusions[] = "rocket-lazyrender-inline-css-exclusions";
    return $inline_atts_exclusions;
}
add_filter( 'rocket_rucss_inline_atts_exclusions', __NAMESPACE__ . '\inline_atts_exclusions' );

