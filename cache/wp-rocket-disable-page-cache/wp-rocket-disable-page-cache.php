<?php
/**
 * Plugin Name: WP Rocket | Disable Page Cache
 * Description: Disable cache and (optionally) optimizations for pages.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\cache\disable_cache_optimizations;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


function disable_page_cache_and_optimization() {

  // Stop if WP Rocket not activated
  if ( ! function_exists( 'get_rocket_option' ) ) {
		return false;
	}

  // EDIT HERE:
  // If nothing is changed, this helper will exclude all pages from cache while still applying optimizations.
  // Customize the configs below to target specific pages to be excluded from cache or both cache and optimizations.
  $disable_configs = [

    // true - Use the configs below to only disable cache & optimizations for logged-in users.
    // false - Use the configs below to disable cache & optimizations regardless if logged-in or not.
    'disable_only_if_logged_in' => false,

    // true - Disable cache for all pages (none of the following configs will have any other effect).
    // false - Cache & optimizations will be applied or disabled for pages based on the config settings below.
    'disable_cache_for_all' => true,

    // Only set disable_cache_and_opts OR disable_cache_only to true at one time.
    // By default, this section does nothing while both options are set to false.
    // true - Disables cache or cache & opts for all pages except those you list in the exception_paths array.
    // false - These configs will do nothing when set to false.
    // Uncomment the exception_paths item (remove //) and customize. Copy as many lines as needed.
    // Items in exception_paths will apply to disable_cache_and_opts or disable_cache_only (whichever is set to true).
    'disable_all_with_exceptions' => [
      'disable_cache_and_opts' => false,
      'disable_cache_only' => false,
      'exception_paths' => [
        // '/specific/exception/path/',
      ],
    ],
    
    // Disable pages based on path(s) (loose matching, DO NOT include protocol or domain)
    // Uncomment items below (remove //) and customize. Copy as many lines as needed.
    'disable_by_path' => [
      'disable_cache_and_opts' => [
        // '/example/path/',
      ],
      'disable_cache_only' => [
        // '/example/path/',
      ],
    ],

    // Disable page(s) of specified ID(s).
    // Uncomment items below (remove //) and customize. Copy as many lines as needed.
    'disable_by_page_id' => [
      'disable_cache_and_opts' => [
        // 337,
      ],
      'disable_cache_only' => [
        // 337,
      ],
    ],

    // Disable pages using custom regex(es).
    // Uncomment items below (remove //) and customize. Copy as many lines as needed.
    'disable_by_regex' => [
      'disable_cache_and_opts' => [
        // '/example/(.*)',
      ],
      'disable_cache_only' => [
        // '/example/(.*)',
      ],
    ],

    // Disable posts under target categories.
    // Uncomment items below (remove //) and customize. Copy as many lines as needed.
    'disable_by_category' => [
      'disable_cache_and_opts' => [
        // 'example-category',
      ],
      'disable_cache_only' => [
        // 'example-category',
      ],
    ],

    // Disable pages that use target shortcodes (specifiy the tag name).
    // Uncomment items below (remove //) and customize. Copy as many lines as needed.
    // Example shortcode - [contact-form-7 id="123"] - contact-form-7 is what you use
    'disable_by_shortcode' => [
      'disable_cache_and_opts' => [
        // 'example-shortcode-tag',
      ],
      'disable_cache_only' => [
        // 'example-shortcode-tag',
      ],
    ],

    // Disable for pages based on various conditions.
    // Uncomment (remove //) the ones you want to apply. Leave all commented out if none should apply.
    // is-admin - Disable pages for admin users (only use if logged-in cache is enabled).
    // is_attachment - Disable pages if they are attachments.
    'disable_by_condition' => [
      'disable_cache_and_opts' => [
        // 'is_admin' => true,
        // 'is_attachment' => true,
      ],
      'disable_cache_only' => [
        // 'is_admin' => true,
        // 'is_attachment' => true,
      ],
    ],
  ];
  // STOP EDITING - DON'T CHANGE ANYTHING BEYOND THIS POINT UNLESS YOU KNOW WHAT YOU'RE DOING


  // Do nothing for logged-out users if configs set to disable cache only for logged-in users.
  if ( $disable_configs['disable_only_if_logged_in'] === true && ! is_user_logged_in() ) {
    return;
  }


  // Disable cache for all pages while preserving other optimizations & do nothing else.
  // Default behavior of this helper. If set to false, allows more granular customization of cache & optimizations.
  if ( $disable_configs['disable_cache_for_all'] === true ) {
    add_filter( 'do_rocket_generate_caching_files', '__return_false' );
    return;
  }



  // Disable cache or cache & opts for all pages except those listed as exceptions.
  function disable_all_with_exceptions( $exception_paths, $disable_cache_and_opts ) {

    $current_path = $_SERVER['REQUEST_URI'];

    if ( is_array( $exception_paths ) && ! in_array( $current_path, $exception_paths ) ) {
      
      if ( $disable_cache_and_opts === true ) {
        if ( ! defined( 'DONOTROCKETOPTIMIZE' ) ) { define( 'DONOTROCKETOPTIMIZE', true ); }
      }
      add_filter( 'do_rocket_generate_caching_files', '__return_false' );
    }
  }



  if ( $disable_configs['disable_all_with_exceptions']['disable_cache_and_opts'] === true ) {

    disable_all_with_exceptions( $disable_configs['disable_all_with_exceptions']['exception_paths'], true );
    return;
  }



  if ( $disable_configs['disable_all_with_exceptions']['disable_cache_only'] === true ) {

    disable_all_with_exceptions( $disable_configs['disable_all_with_exceptions']['exception_paths'], false );
    return;
  }



  // Disables cache or cache & optimizations based on page paths/slugs specified in the configs.
  function disable_by_path( $disable_configs_paths ) {

    $current_path = $_SERVER['REQUEST_URI'];

    foreach ( $disable_configs_paths as $disable_configs_path ) {

      if ( strpos( $current_path, $disable_configs_path ) !== false ) {

        return true;
      }
    }
    return false;
  }


  // Disables cache or cache & optimizations based on page IDs specified in the configs.
  function disable_by_page_id( $disable_configs_page_ids ) {

    if ( is_page( $disable_configs_page_ids ) || is_single( $disable_configs_page_ids ) ) {

      return true;
    }
    return false;
  }


  // Disables cache or cache & optimizations based on regexes specified in the configs.
  function disable_by_regex( $disable_configs_regexes ) {

    $current_url = $_SERVER['REQUEST_URI'];

    foreach ( $disable_configs_regexes as $disable_configs_regex ) {

      if ( preg_match( '@'.$disable_configs_regex.'@', $current_url ) === 1 ) {
        
        return true;
      }
    }
    return false;
  }


  // Disables cache or cache & optimizations based on categories specified in the configs.
  function disable_by_category( $disable_configs_categories ) {

    if ( ! is_home() && has_category( $disable_configs_categories ) ) {

      return true;
    }
    return false;
  }


  // Disables cache or cache & optimizations if shortcodes specified in the configs are present in a page.
  function disable_by_shortcode( $disable_configs_shortcodes ) {

    global $post;
    $all_content = get_the_content();

    foreach ( $disable_configs_shortcodes as $disable_configs_shortcode ) {

      if ( strpos( $all_content, '[' . $disable_configs_shortcode ) !== false ) {

        return true;
      }
    }
    return false;
  }


  // Disables cache or cache & optimizations based on various conditions specified in the configs.
  function disable_by_condition( $disable_configs_conditions ) {

      if (
        ( 
          $disable_configs_conditions['is_admin']
          && current_user_can( 'administrator' )
          && get_rocket_option( 'cache_logged_user' )
        )
        ||
        ( 
          $disable_configs_conditions['is_attachment']
          && is_attachment()
        )
      ) {
        return true;
      }
    return false;
  }

  // Processes cache or cache & optimization exclusions only if they are applied in the various configs.
  $disable_cache_and_opts['path'] = empty( $disable_configs['disable_by_path']['disable_cache_and_opts'] )
    ? false
    : disable_by_path( $disable_configs['disable_by_path']['disable_cache_and_opts'] );

  $disable_cache_only['path'] = empty( $disable_configs['disable_by_path']['disable_cache_only'] )
    ? false
    : disable_by_path( $disable_configs['disable_by_path']['disable_cache_only'] );


  $disable_cache_and_opts['page_id'] = empty( $disable_configs['disable_by_page_id']['disable_cache_and_opts'] )
    ? false
    : disable_by_page_id( $disable_configs['disable_by_page_id']['disable_cache_and_opts'] );

  $disable_cache_only['page_id'] = empty( $disable_configs['disable_by_page_id']['disable_cache_only'] )
    ? false
    : disable_by_page_id( $disable_configs['disable_by_page_id']['disable_cache_only'] );


  $disable_cache_and_opts['regex'] = empty( $disable_configs['disable_by_regex']['disable_cache_and_opts'] )
    ? false
    : disable_by_regex( $disable_configs['disable_by_regex']['disable_cache_and_opts'] );

  $disable_cache_only['regex'] = empty( $disable_configs['disable_by_regex']['disable_cache_only'] )
    ? false
    : disable_by_regex( $disable_configs['disable_by_regex']['disable_cache_only'] );


  $disable_cache_and_opts['category'] = empty( $disable_configs['disable_by_category']['disable_cache_and_opts'] )
    ? false
    : disable_by_category( $disable_configs['disable_by_category']['disable_cache_and_opts'] );

  $disable_cache_only['category'] = empty( $disable_configs['disable_by_category']['disable_cache_only'] )
    ? false
    : disable_by_category( $disable_configs['disable_by_category']['disable_cache_only'] );


  $disable_cache_and_opts['shortcode'] = empty( $disable_configs['disable_by_shortcode']['disable_cache_and_opts'] )
    ? false
    : disable_by_shortcode( $disable_configs['disable_by_shortcode']['disable_cache_and_opts'] );

  $disable_cache_only['shortcode'] = empty( $disable_configs['disable_by_shortcode']['disable_cache_only'] )
    ? false
    : disable_by_shortcode( $disable_configs['disable_by_shortcode']['disable_cache_only'] );


  $disable_cache_and_opts['condition'] = empty( $disable_configs['disable_by_condition']['disable_cache_and_opts'] )
    ? false
    : disable_by_condition( $disable_configs['disable_by_condition']['disable_cache_and_opts'] );

  $disable_cache_only['condition'] = empty( $disable_configs['disable_by_condition']['disable_cache_only'] )
    ? false
    : disable_by_condition( $disable_configs['disable_by_condition']['disable_cache_only'] );
  

  // Cache & optimizations disabled if any configs apply for the current page.
  if ( in_array( true, $disable_cache_and_opts, true ) ) {

    add_filter( 'do_rocket_generate_caching_files', '__return_false' );

    if ( ! defined( 'DONOTROCKETOPTIMIZE' ) ) { define( 'DONOTROCKETOPTIMIZE', true ); }
  }


  // Cache disabled if any configs apply for the current page.
  if ( in_array( true, $disable_cache_only, true ) ) {

    add_filter( 'do_rocket_generate_caching_files', '__return_false' );
  }

}


// Do nothing in certain cases.
if ( 
  is_admin()
  || ! isset( $_SERVER['REQUEST_URI'] )
  || $_SERVER['REQUEST_URI'] === ''
  || strpos( $_SERVER['REQUEST_URI'], '/wp-cron.php' ) !== false
) {
  return;
}


// Using template_redirect allowed the page_id to be detected where it would not with rocket_init or wp_rocket_loaded
add_action( 'template_redirect', __NAMESPACE__ . '\disable_page_cache_and_optimization' );