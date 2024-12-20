<?php
/**
 * Plugin Name: WP Rocket | Disable Priority Elements
 * Description: Disables the Priority Elements optimizations, which includes Automatic Lazy Rendering and Optimize Critical Images.
 * Plugin URI:  https://docs.wp-rocket.me/article/1841-priority-elements#how-to-deactivate-this-feature
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\disable_priority_elements;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

// Disable Optimize Critical Images
add_filter( 'rocket_above_the_fold_optimization', '__return_false', 999 );

// Disable Automatic Lazy Render
add_filter( 'rocket_lrc_optimization', '__return_false', 999 );

// Clear cache on activation 
register_activation_hook(__FILE__, __NAMESPACE__ .'\prepare_things_upon_activation');

function prepare_things_upon_activation() {

  // Clear domain cache
  if ( function_exists( 'rocket_clean_domain' ) ) {
    rocket_clean_domain();
  }
}

// Clear cache on deactivation 
register_deactivation_hook( __FILE__ , __NAMESPACE__ . '\deactivate_plugin' );

function deactivate_plugin() {

  // Clear domain cache
  if ( function_exists( 'rocket_clean_domain' ) ) {
    rocket_clean_domain();
  }
}