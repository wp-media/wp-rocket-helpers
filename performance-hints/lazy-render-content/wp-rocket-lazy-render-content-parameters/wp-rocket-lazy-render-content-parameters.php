<?php
/**
 * Plugin Name: WP Rocket | Lazy Render Content Parameters
 * Description: Customize the parameters applied to Lazy Render Content Optimization.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\lrc_parameters;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


/**
 * DISABLE LRC	
 * Enable or disable Lazy Render Content (LRC) optimization.
 */
function set_custom_rocket_lrc_optimization( $enable_lrc ) {
   // return false; // EDIT HERE uncomment disable LRC.
}

add_filter( 'rocket_lrc_optimization', __NAMESPACE__.'\set_custom_rocket_lrc_optimization' );



/**
 * ADDITIONAL TAGS
 * Add additional HTML tags to be processed by LRC.
 * You can duplicate the line `$tags[] = "h1";` to add more tags
 */
function set_custom_rocket_lrc_processed_tags( $tags ) {
    // $tags[] = "h1"; // EDIT HERE uncomment and duplicate this line to add more tags.
    return $tags;
}

add_filter( 'rocket_lrc_processed_tags', __NAMESPACE__.'\set_custom_rocket_lrc_processed_tags' );



/**
 * THRESHOLD	
 * Sets the custom threshold for lazy rendering content. 
 * Default value: 1800
 * The threshold is the point in pixels that determines when lazy rendering
 * is triggered, you cna change this value with the below filter. 
 * Any content placed after this position will be lazy rendered. 
 */

function set_custom_rocket_lrc_threshold( $threshold ) {
    return 1800; // EDIT HERE to start lazy rendering before or after 
}

add_filter( 'rocket_lrc_threshold', __NAMESPACE__.'\set_custom_rocket_lrc_threshold' );


/**
 * DEPTH	
 * Sets the depth of elements for the LRC optimization.
 * Default depth: 2
 * By default, LRC will seach lor elements that can be lazy-loaded up to two levels deep in the DOM hierarchy.
 * This filter allows you to change the default depth.
 * Use with caution, as adjusting the depth value may affect performance based on the complexity of the page structure.
 */
function set_custom_rocket_lrc_depth( $depth ) {
    return 2; // EDIT HERE to adjust the depth of the LRC search.
}

add_filter( 'rocket_lrc_depth', __NAMESPACE__.'\set_custom_rocket_lrc_depth' );
