<?php
/**
 * Plugin Name: WP Rocket | Preload Sitemap Control
 * Description: Customize WP Rocket's preload by modifying the sitemaps to be used.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\customize_preload_sitemaps;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

define( 'WPROCKETHELPERS_PRELOAD_CONTROL_CONFIGS', [

  // EDIT HERE:

  // true - Only custom sitemaps listed below will be used for Preload
  // false - Default sitemaps and custom sitemaps will both be used for Preload
  'use_only_specified_sitemaps' => true,

  // true - Only pages in your sitemaps will ever be preloaded
  // false - Pages not in your sitemaps will be added to Preload cache table and will be preloaded
  'preload_only_pages_in_sitemaps' => true,

  // true -  Makes pages preload by their last modified value (oldest preloaded first)
  // false - Makes pages preload in the order they appear in sitemaps (by their id value)
  'preload_by_last_modified' => false,

  // true - Allows preloading of attachments (not usually recommended)
  // false - Prevents preloading of attachments
  'preload_attachments' => false,

  // Input your site's domain (include the https:// part) and all custom sitemaps for it
  'sites' => [

    'https://www.example1.com' => [
      'https://www.example1.com/custom-sitemap-1.xml',
      'https://www.example1.com/custom-sitemap-2.xml',
    ],

    // For multisite setups, you can add multiple domains and specifiy the sitemaps for each. 
    // Uncomment the block of code below and add the domain and sitemap details for the next subsite.
    // You can add as many additional blocks of code as needed to customize Preload for all your subsites.
    // 'https://www.example2.com' => [
    //   'https://www.example2.com/custom-sitemap-1.xml',
    //   'https://www.example2.com/custom-sitemap-2.xml',
    // ],

  // STOP EDITING
  ],

] );



// DO NOT CHANGE ANYTHING BELOW HERE UNLESS YOU KNOW WHAT YOU'RE DOING



function set_rocket_sitemap_preload_list( $sitemaps ) {

  $current_site = get_bloginfo( 'url' );

  // Remove sitemaps not defined in this helper from Preload if preferred
  if ( WPROCKETHELPERS_PRELOAD_CONTROL_CONFIGS['use_only_specified_sitemaps'] ) {
    $sitemaps = [];
  }

  // Return all sitemaps defined for the current site
  foreach ( WPROCKETHELPERS_PRELOAD_CONTROL_CONFIGS['sites'] as $user_defined_site => $user_defined_sitemaps ) {

    if ( untrailingslashit( $current_site ) === untrailingslashit( $user_defined_site ) ) {
      $sitemaps = array_merge( $sitemaps, $user_defined_sitemaps );
    }
  }

	return $sitemaps;
}

add_filter( 'rocket_sitemap_preload_list', __NAMESPACE__ . '\set_rocket_sitemap_preload_list', PHP_INT_MAX );



// Preload pages by their order in sitemaps or by cache files' last defined value
add_filter( 'rocket_preload_order', function( $order ){
  return WPROCKETHELPERS_PRELOAD_CONTROL_CONFIGS['preload_by_last_modified'];
}, 1);



if ( WPROCKETHELPERS_PRELOAD_CONTROL_CONFIGS['preload_only_pages_in_sitemaps'] ) {

  // Exclude URLs that are not in sitemaps from being added to the preload table.
  // These will still be cached after a visit, but not preloaded
  add_filter( 'rocket_preload_exclude_urls', function( $regexes, $current_url ) {

    // Prevent Home Page from being excluded from preload/database
    if ( is_front_page() ) {
      return $regexes;
    }

    // Get transient containing all pages from sitemaps for current site if it exists
    if ( false !== get_transient( 'rocket_custom_sitemap_pages') ) {

      $sitemap_pages = get_transient( 'rocket_custom_sitemap_pages');

    } else {

      $current_site = get_bloginfo( 'url' );
      $sitemap_pages = [];

      // Collect all pages from all sitemaps added for the current site
      foreach ( WPROCKETHELPERS_PRELOAD_CONTROL_CONFIGS['sites'] as $user_defined_site => $user_defined_sitemaps ) {

        if ( untrailingslashit( $current_site ) !== untrailingslashit( $user_defined_site ) ) {
          continue;
        }

        $sitemap_pages = array_merge(
          array_map(
            function( $page ) { return untrailingslashit( $page ); },
            get_sitemap_pages( $user_defined_sitemaps )
          ),
          $sitemap_pages
        );
      }

      set_transient( 'rocket_custom_sitemap_pages', $sitemap_pages, DAY_IN_SECONDS );
    }

    // Prevent page from being added to Preload table if it's not in one of the sitemaps
    if ( ! in_array( untrailingslashit( $current_url ), $sitemap_pages, true ) ) {
      $regexes[] = $current_url;
    }

    return $regexes;
  }, 10, 2 );


  function get_sitemap_pages( $user_defined_sitemaps ) {

    $container = apply_filters( 'rocket_container', null );
    $sitemap_parser = $container->get( 'sitemap_parser' );

    $sitemap_pages = [];

    // Collect all pages from all sitemaps added for the current site
    foreach( $user_defined_sitemaps as $user_defined_sitemap ) {

      $response = wp_safe_remote_get( $user_defined_sitemap );

      if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
        continue;
      }

      $data = wp_remote_retrieve_body( $response );

      if ( ! $data ) {
        continue;
      }

      $sitemap_parser->set_content( $data );
      $sitemap_pages = array_merge( $sitemap_pages, $sitemap_parser->get_links() );
    }

    return $sitemap_pages;
  }

}



if ( ! WPROCKETHELPERS_PRELOAD_CONTROL_CONFIGS['preload_attachments'] ) {

  // Prevent attachments from being preloaded
  add_filter( 'rocket_preload_exclude_urls', function( $regexes, $current_url ) {
    
    // Stop if is a WordPress attachment
    if ( is_attachment() ) {
      $regexes[] = $current_url;
    }
    
    return $regexes;
  }, 9999, 2 );
}



// Upon activation, prepare the table, clear the cache and deactivate/reactivate Preload 
register_activation_hook(__FILE__, __NAMESPACE__ . '\prepare_things_upon_activation');

function prepare_things_upon_activation() {

  // Clear transient containing all pages from sitemaps for current site if it exists
  if ( false !== get_transient( 'rocket_custom_sitemap_pages') ) {
    delete_transient( 'rocket_custom_sitemap_pages');
  }

  // Truncate cache table
  global $wpdb;
  $table_name = $wpdb->prefix . 'wpr_rocket_cache';
  $wpdb->query("TRUNCATE TABLE $table_name");


  // Clear the cache
  if ( function_exists( 'rocket_clean_domain' ) ) {
      rocket_clean_domain();
  }

  // Disable and reenable preload so the sitemap change kicks in immediately
  $options = get_option( 'wp_rocket_settings', [] );

  // Disable preload
  $options['manual_preload'] = 0;
  update_option( 'wp_rocket_settings', $options );

  // Enable preload
  $options['manual_preload'] = 1;
  update_option( 'wp_rocket_settings', $options );
}



// Upon deactivation, remove the filter and deactivate/reactivate Preload 
register_deactivation_hook( __FILE__ , __NAMESPACE__ . '\deactivate_plugin' );

function deactivate_plugin() {

  // Clear transient containing all pages from sitemaps for current site if it exists
  if ( false !== get_transient( 'rocket_custom_sitemap_pages') ) {
    delete_transient( 'rocket_custom_sitemap_pages');
  }
    
  // Unhook any sitemap changes
  remove_filter( 'rocket_sitemap_preload_list', __NAMESPACE__ . '\set_rocket_sitemap_preload_list', PHP_INT_MAX );

  // Disable and reenable preload so the sitemap change kicks in immediately
  $options = get_option( 'wp_rocket_settings', [] );

  // Disable preload
  $options['manual_preload'] = 0;
  update_option( 'wp_rocket_settings', $options );

  // Enable preload
  $options['manual_preload'] = 1;
  update_option( 'wp_rocket_settings', $options );
}