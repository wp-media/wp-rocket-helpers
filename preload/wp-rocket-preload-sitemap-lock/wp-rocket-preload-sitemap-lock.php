<?php
/**
 * Plugin Name: WP Rocket | Only preload URLs in a sitemap
 * Description: Instruct WP Rocket's preload to only use the URLs present in a specific sitemap. Any extra URL won't be preloaded. 
 * Plugin URI:  https://docs.wp-rocket.me/article/1723-customize-preload-sitemaps-and-priority
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\common_cache_loggedin;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

// EDIT $my_custom_sitemap and add your sitemap
$my_custom_sitemap = 'https://www.example.com/sitemap_index.xml';
// STOP editing


defined( 'WPR_HELPER_CUSTOM_SITEMAP_URL' ) || define( 'WPR_HELPER_CUSTOM_SITEMAP_URL', $my_custom_sitemap );


// Use your provided sitemap as source for the preload 
add_filter( 'rocket_sitemap_preload_list', function( $sitemaps ){
    return [ WPR_HELPER_CUSTOM_SITEMAP_URL ];
});
 
 

// Exclude other URLs from being added to the preload table.
// these will still be cached after a visit, but not preloaded 
add_filter( 'rocket_preload_exclude_urls', function( $regexes, $url ) {
    $url = untrailingslashit( $url );
    $sitemap_urls = array_map( function( $sitemap_url ){
        return untrailingslashit( $sitemap_url );
    }, rocket_helper_get_sitemap_urls() );
 
    if ( ! in_array( $url, $sitemap_urls, true ) ) {
        $regexes[] = $url;
    }
    return $regexes;
}, 10, 2 );


 
function rocket_helper_get_sitemap_urls() {
    if( false !== get_transient( 'rocket_custom_sitemap_links') ) {
        return get_transient( 'rocket_custom_sitemap_links');
    }
 
    $container = apply_filters( 'rocket_container', null );
 
    $sitemap_parser = $container->get( 'sitemap_parser' );
    $response = wp_safe_remote_get( WPR_HELPER_CUSTOM_SITEMAP_URL );
 
    if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
        return;
    }
 
    $data = wp_remote_retrieve_body( $response );
 
    if ( ! $data ) {
        return;
    }
 
    $sitemap_parser->set_content( $data );
    $links = $sitemap_parser->get_links();
    set_transient( 'rocket_custom_sitemap_links', $links, DAY_IN_SECONDS );
    return $links;
}

