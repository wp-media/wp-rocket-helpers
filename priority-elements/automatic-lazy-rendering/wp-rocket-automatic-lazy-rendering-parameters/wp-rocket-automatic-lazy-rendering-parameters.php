<?php
/**
 * Plugin Name: WP Rocket | Automatic Lazy Rendering Parameters
 * Description: Customize the parameters applied to the Automatic Lazy Rendering optimization.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\priority_elements\automatic_lazy_renering\lrc_parameters;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();



if ( ! defined( 'WPROCKETHELPERS_LRC_PARAMETERS' ) ) {
  define( 'WPROCKETHELPERS_LRC_PARAMETERS',
    [

      // EDIT HERE

      /**
       * Sets the custom threshold for Automatic Lazy Rendering content. 
       * Default value: 1800
       * The threshold is the point in pixels that determines when lazy rendering
       * is triggered, you can change this value with the below filter. 
       * Any content placed lower in the page than this position will be lazy rendered. 
       */
      'rocket_lrc_threshold' => 1800,

      /**
       * Sets the depth of elements for the LRC optimization.
       * Default value: 2
       * The actual applied depth in the source is the depth value + 1 after the body
       * So when set to 2, LRC will search for elements that can be lazy loaded 
       * up to 3 levels deep in the DOM hierarchy (from the body element).
       * This filter allows you to change the default depth.
       * Use with caution, as adjusting the depth value may affect performance 
       * based on the complexity of the page structure.
       */
      'rocket_lrc_depth' => 2,

      /**
       * Sets max number of processed HTML tags that will be processed on a page.
       * Default value: 200
       * This filter allows you to change the default max hashes.
       * Use with caution, as adjusting the max hashes value may affect performance 
       * based on the complexity of the page structure.
       */
      'rocket_lrc_max_hashes' => 200,

      /**
       * Customize the HTML tags to be processed by Automatic Lazy Rendering.
       * Default values are listed below
       * You can add or remove tags from the list below depending on your needs.
       */
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



function set_custom_rocket_lrc_threshold( $threshold ) {
    return WPROCKETHELPERS_LRC_PARAMETERS['rocket_lrc_threshold'];
}
add_filter( 'rocket_lrc_threshold', __NAMESPACE__.'\set_custom_rocket_lrc_threshold' );



function set_custom_rocket_lrc_depth( $depth ) {
    return WPROCKETHELPERS_LRC_PARAMETERS['rocket_lrc_depth'];
}
add_filter( 'rocket_lrc_depth', __NAMESPACE__.'\set_custom_rocket_lrc_depth' );



function set_custom_rocket_lrc_max_hashes ( $hashes ) {
  return WPROCKETHELPERS_LRC_PARAMETERS['rocket_lrc_max_hashes'];
}
add_filter( 'rocket_lrc_max_hashes', __NAMESPACE__.'\set_custom_rocket_lrc_max_hashes' );



function set_custom_rocket_lrc_processed_tags( $tags ) {
  return WPROCKETHELPERS_LRC_PARAMETERS['rocket_lrc_processed_tags'];
}
add_filter( 'rocket_lrc_processed_tags', __NAMESPACE__.'\set_custom_rocket_lrc_processed_tags' );



// Clear Priority Elements and RUCSS data
function wpr_clear_priority_elements_data() {
  
  if ( defined( 'WP_ROCKET_VERSION' ) ) {
    // access rocket's injection container
    $container = apply_filters( 'rocket_container', null );

    // Get the Performance Hints subscriber from the container
    $perfhints_subscriber = $container->get( 'performance_hints_admin_subscriber' );
    // call the Performance Hints truncate tables method.
    $perfhints_subscriber->truncate_tables();

    // Get the rucss subscriber from the container
    $rucss_subscriber = $container->get( 'rucss_admin_subscriber' );
    // Call the RUCSS truncate method.
    $rucss_subscriber->truncate_used_css();
  }

  // Clear domain cache
  if ( function_exists( 'rocket_clean_domain' ) ) {
    rocket_clean_domain();
  }

  // Clear minified CSS and JavaScript files.
  if ( function_exists( 'rocket_clean_minify' ) ) {
    rocket_clean_minify();
  }
}



// Regenerate all cache and data on activation
function prepare_things_upon_activation() {
  wpr_clear_priority_elements_data();
}
register_activation_hook(__FILE__, __NAMESPACE__ .'\prepare_things_upon_activation');



// Regenerate all cache and data on deactivation
function deactivate_plugin() {
  wpr_clear_priority_elements_data();
}
register_deactivation_hook( __FILE__ , __NAMESPACE__ . '\deactivate_plugin' );