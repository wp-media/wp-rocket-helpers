<?php
/**
 * Plugin Name: WP Rocket | Performance Hints Parameters
 * Description: Customize the parameters applied to Performance Hints Optimization.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\performance_hints_parameters;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


if ( ! defined( 'WPROCKETHELPERS_PHO_PARAMETERS' ) ) {
	define( 'WPROCKETHELPERS_PHO_PARAMETERS',
    [

      // EDIT HERE

      // Number of links fetched during warmup
      'rocket_pho_warmup_links_number' => 10,

      // Height and height thresholds for Performance Hints Optimization
      'rocket_pho_width_threshold_mobile' => 393,
      'rocket_pho_width_threshold_desktop' => 1600,
      'rocket_pho_height_threshold_mobile' => 830,
      'rocket_pho_height_threshold_desktop' => 700,

      // The delay before the beacon script is triggered.
      'rocket_pho_delay' => 500,

      // Elements considered for Critical Images Optimization
      'rocket_atf_elements' => [
        'img',
        'video',
        'picture',
        'p',
        'main',
        'div',
        'li',
        'svg',
        'section',
        'header',
        'span',
      ],
      
      // Interval (in months) for when Critical Images Optimization DB entries considered old
      // Cron for this runs daily and deletes items older than this value
      'rocket_atf_cleanup_interval' => 1,

      // STOP EDITING

    ]
  );
}



/**
 * Changes the number of links to return from the homepage during warmup
 *
 * @param int $limit number of links to return.
 */
function change_rocket_pho_warmup_links_number( $limit ) {

  return WPROCKETHELPERS_PHO_PARAMETERS['rocket_pho_warmup_links_number'];
}
add_filter( 'rocket_performance_hints_warmup_links_number', __NAMESPACE__ . '\change_rocket_pho_warmup_links_number', PHP_INT_MAX );



/**
 * Change the width thresholds for the beacon.
 *
 * @param int    $width_threshold The width threshold.
 * @param bool   $is_mobile       True if the current device is mobile, false otherwise.
 * @param string $url             The current URL.
 *
 * @return int The filtered width threshold.
 */
function change_rocket_pho_width_threshold( $width_threshold, $is_mobile, $url ) {

  if ( $is_mobile ) {
      // For mobile devices
      return WPROCKETHELPERS_PHO_PARAMETERS['rocket_pho_width_threshold_mobile'];
  } else {
      // For other devices
      return WPROCKETHELPERS_PHO_PARAMETERS['rocket_pho_width_threshold_desktop'];
  }
}
add_filter( 'rocket_performance_hints_optimization_width_threshold', __NAMESPACE__ . '\change_rocket_pho_width_threshold', PHP_INT_MAX, 3 );



/**
 * Change the height thresholds for the beacon.
 *
 * @param int    $height_threshold The height threshold.
 * @param bool   $is_mobile        True if the current device is mobile, false otherwise.
 * @param string $url              The current URL.
 *
 * @return int The filtered height threshold.
 */
function change_rocket_pho_height_threshold( $height_threshold, $is_mobile, $url ) {

  if ( $is_mobile ) {
      // For mobile devices
      return WPROCKETHELPERS_PHO_PARAMETERS['rocket_pho_height_threshold_mobile'];
  } else {
      // For other devices
      return WPROCKETHELPERS_PHO_PARAMETERS['rocket_pho_height_threshold_desktop'];
  }
}
add_filter( 'rocket_performance_hints_optimization_height_threshold', __NAMESPACE__ . '\change_rocket_pho_height_threshold', PHP_INT_MAX, 3 );



/**
 * Change the delay before the beacon script is triggered.
 */
function change_rocket_pho_delay() {

    return WPROCKETHELPERS_PHO_PARAMETERS['rocket_pho_delay'];
}
add_filter('rocket_performance_hints_optimization_delay', __NAMESPACE__ . '\change_rocket_pho_delay', PHP_INT_MAX);



/**
 * Change the elements to be considered for the Above the Fold optimization.
 *
 * @param array $elements List of HTML element types.
 */
function change_rocket_atf_elements( $elements ) {

  return WPROCKETHELPERS_PHO_PARAMETERS['rocket_atf_elements'];
}
add_filter( 'rocket_atf_elements', __NAMESPACE__ . '\change_rocket_atf_elements', PHP_INT_MAX );



/**
 * Change the interval (in months) to determine when an Above The Fold entry is considered 'old'.
 *
 * @param int $interval The interval in months after which an ATF entry is considered old.
 */
function change_rocket_atf_cleanup_interval( $interval ) {

  return WPROCKETHELPERS_PHO_PARAMETERS['rocket_atf_cleanup_interval'];
}
add_filter( 'rocket_atf_cleanup_interval', __NAMESPACE__ . '\change_rocket_atf_cleanup_interval', PHP_INT_MAX );



// Clear Performance Hints and RUCSS data
function wpr_clear_pho_data() {
  
  if ( defined( 'WP_ROCKET_VERSION' ) ) {
    // access rocket's injection container
    $container = apply_filters( 'rocket_container', null );

    // Get the Performace Hints subscriber from the container
    $perfhints_subscriber = $container->get( 'performance_hints_admin_subscriber' );
    // call the Performance Hints truncate tables method.
    $perfhints_subscriber->truncate_tables;

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
  wpr_clear_pho_data();
}
register_activation_hook(__FILE__, __NAMESPACE__ .'\prepare_things_upon_activation');



// Regenerate all cache and data on deactivation
function deactivate_plugin() {
  wpr_clear_pho_data();
}
register_deactivation_hook( __FILE__ , __NAMESPACE__ . '\deactivate_plugin' );