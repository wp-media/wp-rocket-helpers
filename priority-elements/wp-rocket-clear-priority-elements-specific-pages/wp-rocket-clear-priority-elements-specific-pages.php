<?php
/**
 * Plugin Name: WP Rocket | Clear Priority Elements of Specific Pages
 * Description: Clears Priority Elements of specific pages when specified actions occur.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\priority_elements\clear_priority_elements_specific_pages;

if ( ! defined( 'WPRH_CLEAR_PE_PAGES_CONFIGS' ) ) {
  define( 'WPRH_CLEAR_PE_PAGES_CONFIGS',
    [
      // EDIT HERE

      'clear_triggering_actions' => [
        // Add each action below that should trigger clearing of Priority Elements on new lines.
        'publish_post',
        'post_updated',
      ],

      'page_to_be_cleared_ids' => [
        // Add page IDs below for each page whose Priority Elements should be cleared on new lines.
        '1',
      ],

      // STOP EDITING
    ]
  );
}


function wpr_clear_priority_elements_specific_pages() {

  if ( ! defined( 'WP_ROCKET_VERSION' ) ) {
    return;
  }

  // Access WP Rocket's injection container
  $container = apply_filters( 'rocket_container', null );

  // Get the Priority Elements subscriber from container
  $perfhints_subscriber = $container->get( 'performance_hints_admin_subscriber' );
  
  foreach( WPRH_CLEAR_PE_PAGES_CONFIGS['page_to_be_cleared_ids'] as $page_to_be_cleared_id ) {

    // Delete critical images data for target pages
    $perfhints_subscriber->delete_post( $page_to_be_cleared_id );

    // clear the page cache
    rocket_clean_post( $page_to_be_cleared_id );
  }

  // Clear minified CSS and JavaScript files.
  if ( function_exists( 'rocket_clean_minify' ) ) {
    rocket_clean_minify();
  }
}

foreach( WPRH_CLEAR_PE_PAGES_CONFIGS['clear_triggering_actions'] as $clear_triggering_action ) {
  add_action( $clear_triggering_action, __NAMESPACE__ . '\wpr_clear_priority_elements_specific_pages' );
}