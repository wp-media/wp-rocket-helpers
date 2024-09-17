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


// /**
//  * DISABLE LRC	
//  * Enable or disable Lazy Render Content (LRC) optimization.
//  */
// function set_custom_rocket_lrc_optimization( $enable_lrc ) {
//    // return false; // EDIT HERE uncomment disable LRC.
// }

// add_filter( 'rocket_lrc_optimization', __NAMESPACE__.'\set_custom_rocket_lrc_optimization' );



if ( ! defined( 'WPROCKETHELPERS_LRC_PARAMETERS' ) ) {
  define( 'WPROCKETHELPERS_LRC_PARAMETERS',
    [

      // EDIT HERE

      // Threshold in pixels for content to be considered below the fold.
      'rocket_lrc_threshold' => 1800,

      // Max levels nested from the body element to still be eligible for lazy rendering.
      'rocket_lrc_depth' => 2,

      // Max number of processed tags (higher numbers process more elements but may risk performance issues).
      'rocket_lrc_max_hashes' => 200,

      // Specify elements eligible for Lazy Render Content optimization.
      'rocket_lrc_processed_tags' => [
				'DIV',
				'MAIN',
				'FOOTER',
				'SECTION',
				'ARTICLE',
				'HEADER',
      ],

      // STOP EDITING

    ]
  );
}




/**
 * THRESHOLD	
 * Sets the custom threshold for lazy rendering content. 
 * Default value: 1800
 * The threshold is the point in pixels that determines when lazy rendering
 * is triggered, you cna change this value with the below filter. 
 * Any content placed after this position will be lazy rendered. 
 */

function set_custom_rocket_lrc_threshold( $threshold ) {
    return WPROCKETHELPERS_LRC_PARAMETERS['rocket_lrc_threshold'];
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
    return WPROCKETHELPERS_LRC_PARAMETERS['rocket_lrc_depth'];
}
add_filter( 'rocket_lrc_depth', __NAMESPACE__.'\set_custom_rocket_lrc_depth' );

/**
 * MAX HASHES
 */
function set_custom_rocket_lrc_max_hashes ( $hashes ) {
  return WPROCKETHELPERS_LRC_PARAMETERS['rocket_lrc_max_hashes'];
}
add_filter( 'rocket_lrc_max_hashes', __NAMESPACE__.'\set_custom_rocket_lrc_max_hashes' );


/**
 * ADDITIONAL TAGS
 * Add additional HTML tags to be processed by LRC.
 * You can duplicate the line `$tags[] = "h1";` to add more tags
 */
function set_custom_rocket_lrc_processed_tags( $tags ) {
  return WPROCKETHELPERS_LRC_PARAMETERS['rocket_lrc_processed_tags'];
}
add_filter( 'rocket_lrc_processed_tags', __NAMESPACE__.'\set_custom_rocket_lrc_processed_tags' );