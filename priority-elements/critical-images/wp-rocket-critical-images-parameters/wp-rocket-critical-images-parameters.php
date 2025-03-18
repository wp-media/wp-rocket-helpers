<?php
/**
 * Plugin Name: WP Rocket | Critical Images Parameters
 * Description: Customize the parameters applied by Optimize Critical Images.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\priorityelements\criticalimages\critical_images_parameters;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


if ( ! defined( 'WPROCKETHELPERS_OCI_PARAMETERS' ) ) {
	define( 'WPROCKETHELPERS_OCI_PARAMETERS',
    [

      // EDIT HERE

      // Number of links fetched during warmup
      'rocket_oci_warmup_links_number' => 10,

      // Height and height thresholds for Critical Images optimization
      'rocket_oci_width_threshold_mobile' => 393,
      'rocket_oci_width_threshold_desktop' => 1600,
      'rocket_oci_height_threshold_mobile' => 830,
      'rocket_oci_height_threshold_desktop' => 700,

      // The delay before the beacon script is triggered. Default is 500.
      'rocket_oci_delay' => 1000,

      // Elements considered for Critical Images optimization
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
function change_rocket_oci_warmup_links_number( $limit ) {

  return WPROCKETHELPERS_OCI_PARAMETERS['rocket_oci_warmup_links_number'];
}
add_filter( 'rocket_performance_hints_warmup_links_number', __NAMESPACE__ . '\change_rocket_oci_warmup_links_number', 9999 );



/**
 * Change the width thresholds for the beacon.
 *
 * @param int    $width_threshold The width threshold.
 * @param bool   $is_mobile       True if the current device is mobile, false otherwise.
 * @param string $url             The current URL.
 *
 * @return int The filtered width threshold.
 */
function change_rocket_oci_width_threshold( $width_threshold, $is_mobile, $url ) {

  if ( $is_mobile ) {
      // For mobile devices
      return WPROCKETHELPERS_OCI_PARAMETERS['rocket_oci_width_threshold_mobile'];
  } else {
      // For other devices
      return WPROCKETHELPERS_OCI_PARAMETERS['rocket_oci_width_threshold_desktop'];
  }
}
add_filter( 'rocket_performance_hints_optimization_width_threshold', __NAMESPACE__ . '\change_rocket_oci_width_threshold', 9999, 3 );



/**
 * Change the height thresholds for the beacon.
 *
 * @param int    $height_threshold The height threshold.
 * @param bool   $is_mobile        True if the current device is mobile, false otherwise.
 * @param string $url              The current URL.
 *
 * @return int The filtered height threshold.
 */
function change_rocket_oci_height_threshold( $height_threshold, $is_mobile, $url ) {

  if ( $is_mobile ) {
      // For mobile devices
      return WPROCKETHELPERS_OCI_PARAMETERS['rocket_oci_height_threshold_mobile'];
  } else {
      // For other devices
      return WPROCKETHELPERS_OCI_PARAMETERS['rocket_oci_height_threshold_desktop'];
  }
}
add_filter( 'rocket_performance_hints_optimization_height_threshold', __NAMESPACE__ . '\change_rocket_oci_height_threshold', 9999, 3 );



/**
 * Change the delay before the beacon script is triggered.
 */
function change_rocket_oci_delay( $delay ) {

    return WPROCKETHELPERS_OCI_PARAMETERS['rocket_oci_delay'];
}
add_filter('rocket_performance_hints_optimization_delay', __NAMESPACE__ . '\change_rocket_oci_delay', 9999);



/**
 * Change the elements to be considered for the Above the Fold optimization.
 *
 * @param array $elements List of HTML element types.
 */
function change_rocket_atf_elements( $elements ) {

  return WPROCKETHELPERS_OCI_PARAMETERS['rocket_atf_elements'];
}
add_filter( 'rocket_atf_elements', __NAMESPACE__ . '\change_rocket_atf_elements', 9999 );



/**
 * Change the interval (in months) to determine when an Above The Fold entry is considered 'old'.
 *
 * @param int $interval The interval in months after which an ATF entry is considered old.
 */
function change_rocket_atf_cleanup_interval( $interval ) {

  return WPROCKETHELPERS_OCI_PARAMETERS['rocket_atf_cleanup_interval'];
}
add_filter( 'rocket_atf_cleanup_interval', __NAMESPACE__ . '\change_rocket_atf_cleanup_interval', 9999 );



// Clear Above the Fold and RUCSS data
function wpr_clear_priority_elements_data() {
  
  if ( defined( 'WP_ROCKET_VERSION' ) ) {
    // access rocket's injection container
    $container = apply_filters( 'rocket_container', null );

    // Get the Priority Elements subscriber from the container
    $perfhints_subscriber = $container->get( 'performance_hints_admin_subscriber' );
    // call the Priority Elements truncate tables method.
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