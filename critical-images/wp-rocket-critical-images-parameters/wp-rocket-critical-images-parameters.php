<?php
/**
 * Plugin Name: WP Rocket | Critical Images Parameters
 * Description: Customize the parameters applied to Critical Images optimizations.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\critical_images_parameters;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();



function set_critical_images_parameters() {

  $critical_images_parameters = array(

  // EDIT HERE
    // Interval (in months) for when DB entries considered old
    // Cron for this runs daily and deletes any older than this value
    'rocket_atf_cleanup_interval' => 1,

    // Number of links fetched during warmup
    'rocket_atf_warmup_links_number' => 5,

    // Height and height thresholds for critical images optimization
    'rocket_lcp_width_threshold_mobile' => 393,
    'rocket_lcp_width_threshold_desktop' => 1600,
    'rocket_lcp_height_threshold_mobile' => 830,
    'rocket_lcp_height_threshold_desktop' => 700,

    // Elements considered for critical images optimization
    'rocket_atf_elements' => array(
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
    ),
      // The delay before the LCP beacon is triggered.
      'rocket_lcp_delay' => 500,
  // STOP EDITING  
  );

  return $critical_images_parameters;
}



/**
 * Change the interval (in months) to determine when an Above The Fold (ATF) entry is considered 'old'.
 *
 * @param int $interval The interval in months after which an ATF entry is considered old.
 */
function change_rocket_atf_cleanup_interval( $interval ) {

  $critical_images_parameters = set_critical_images_parameters();

  return $critical_images_parameters['rocket_atf_cleanup_interval'];
}
add_filter( 'rocket_atf_cleanup_interval', __NAMESPACE__ . '\change_rocket_atf_cleanup_interval', PHP_INT_MAX );



/**
 * Changes the number of links to return from the homepage during warmup
 *
 * @param int $limit number of links to return.
 */
function change_rocket_atf_warmup_links_number( $limit ) {

  $critical_images_parameters = set_critical_images_parameters();

  return $critical_images_parameters['rocket_atf_warmup_links_number'];
}
add_filter( 'rocket_atf_warmup_links_number', __NAMESPACE__ . '\change_rocket_atf_warmup_links_number', PHP_INT_MAX );



/**
 * Change the width threshold for the LCP beacon.
 *
 * @param int    $width_threshold The width threshold.
 * @param bool   $is_mobile       True if the current device is mobile, false otherwise.
 * @param string $url             The current URL.
 *
 * @return int The filtered width threshold.
 */
function change_rocket_lcp_width_threshold( $width_threshold, $is_mobile, $url ) {

  $critical_images_parameters = set_critical_images_parameters();

  if ( $is_mobile ) {
      // For mobile devices
      return $critical_images_parameters['rocket_lcp_width_threshold_mobile'];
  } else {
      // For other devices
      return $critical_images_parameters['rocket_lcp_width_threshold_desktop'];
  }
}
add_filter( 'rocket_lcp_width_threshold', __NAMESPACE__ . '\change_rocket_lcp_width_threshold', PHP_INT_MAX, 3 );



/**
 * Change the height threshold for the LCP beacon.
 *
 * @param int    $height_threshold The height threshold.
 * @param bool   $is_mobile        True if the current device is mobile, false otherwise.
 * @param string $url              The current URL.
 *
 * @return int The filtered height threshold.
 */
function change_rocket_lcp_height_threshold( $height_threshold, $is_mobile, $url ) {

  $critical_images_parameters = set_critical_images_parameters();

  if ( $is_mobile ) {
      // For mobile devices
      return $critical_images_parameters['rocket_lcp_height_threshold_mobile'];
  } else {
      // For other devices
      return $critical_images_parameters['rocket_lcp_height_threshold_desktop'];
  }
}
add_filter( 'rocket_lcp_height_threshold', __NAMESPACE__ . '\change_rocket_lcp_height_threshold', PHP_INT_MAX, 3 );




/**
 * Change the elements to be considered for the lcp/above-the-fold optimization.
 *
 * @param array $elements List of HTML element types.
 */
function change_rocket_atf_elements( $elements ) {

  $critical_images_parameters = set_critical_images_parameters();

  return $critical_images_parameters['rocket_atf_elements'];
}
add_filter( 'rocket_atf_elements', __NAMESPACE__ . '\change_rocket_atf_elements', PHP_INT_MAX );


/**
 * Change the delay before the LCP beacon is triggered.
 */
function change_rocket_lcp_delay() {

    $critical_images_parameters = set_critical_images_parameters();

    return $critical_images_parameters['rocket_lcp_delay'];
}
add_filter('rocket_lcp_delay', __NAMESPACE__ . '\change_rocket_lcp_delay', PHP_INT_MAX);



// Clear Critical Images data
function wpr_clear_atf_lcp_data() {
  
  if ( defined( 'WP_ROCKET_VERSION' ) ) {
    // access rocket's injection container
    $container = apply_filters( 'rocket_container', null );

    // Get the rucss subscriber from the container
    $atf_subscriber = $container->get( 'atf_admin_subscriber' );
    // call the atf truncate method.
    $atf_subscriber->truncate_atf();

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
  wpr_clear_atf_lcp_data();
}
register_activation_hook(__FILE__, __NAMESPACE__ .'\prepare_things_upon_activation');



// Regenerate all cache and data on deactivation
function deactivate_plugin() {
  wpr_clear_atf_lcp_data();
}
register_deactivation_hook( __FILE__ , __NAMESPACE__ . '\deactivate_plugin' );