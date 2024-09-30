<?php
/**
 * Plugin Name: WP Rocket | Exclude elements from Automatic Lazy Rendering
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


function wpr_alr_exclusions( $exclusions ) {
    
    // Replace 'id="main-footer" with the element you'd like to exclude from the optimization. 
    // This filter matches HTML, so you have to use a portion of the HTML you want to exclude.
    // If you want to exclude more elements you can uncomment and duplicate this line: 
    // $exclusions[] = 'class="popup-builder"';
    
    // START editing
    $exclusions[] = 'id="main-footer"';
    //$exclusions[] = 'class="popup-builder"';
    // END editing

    return $exclusions;
}

add_filter( 'rocket_lrc_exclusions', __NAMESPACE__ .'\wpr_alr_exclusions' );


