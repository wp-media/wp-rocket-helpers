<?php
/**
 * Plugin Name: WP Rocket | Preload Customize Sitemap 
 * Description: Customize WP Rocket's preload by modifying the sitemaps to be used.
 * Plugin URI:  https://docs.wp-rocket.me/article/1723-customize-preload-sitemaps-and-priority
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\customize_preload_sitemaps;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


// CASE 1) ONLY these sitemap(s)
// Use this if you need to preload URLs in custom sitemaps replacing the automatic sitemaps detection.
function wprocket_preload_only_sitemap() {
    return [
        'https://example.com/page-sitemap.xml', // duplicate this line you want to add more sitemaps
        ];
}

add_filter( 'rocket_sitemap_preload_list', __NAMESPACE__ .'\wprocket_preload_only_sitemap', PHP_INT_MAX );



// CASE 2) ADDITIONAL sitemap(s)
// Ucomment the next function to ensure specific sitemaps are included in the preloading process, in ADDITION to the compatible sitemaps.

/*
function wprocket_preload_add_custom_sitemaps ( $sitemaps ){
    
    $sitemaps[] = 'https://example.com/page-sitemap.xml';  // duplicate this line you want to add more sitemaps
    
    return $sitemaps;
}
add_filter( 'rocket_sitemap_preload_list', __NAMESPACE__ .'\wprocket_preload_add_custom_sitemaps', PHP_INT_MAX );
*/


// 3) Customize Preload Priority sitemap(s)
// Uncomment the next lines to make the Preload run on URLs according to their id instead of their modified value.

/*
add_filter( 'rocket_preload_order', function( $order ){
    return true;
}, 1);
*/


// Upon activation, prepare the table, clear the cache and deactivate/reactivate Preload 
register_activation_hook(__FILE__, __NAMESPACE__ .'\prepare_things_upon_activation');

function prepare_things_upon_activation() {
    
    // 1 - truncate cache table upon plugin activation
    global $wpdb;
    $table_name = $wpdb->prefix . 'wpr_rocket_cache';
    $wpdb->query("TRUNCATE TABLE $table_name");
    
    
    // 2 clear the cache
    if( function_exists('rocket_clean_domain')) {
        rocket_clean_domain();
    }
    
    
    // 3 - Disable and reenable preload, so the sitemap change kicks in immediately

    $options = get_option('wp_rocket_settings', []);

    // disable preload
    $options['manual_preload'] = 0;
    update_option('wp_rocket_settings', $options);
    
    // enable preload
    $options['manual_preload'] = 1;
    update_option('wp_rocket_settings', $options);


}

// Upon deactivation, remove the filter and deactivate/reactivate Preload 
register_deactivation_hook( __FILE__ , __NAMESPACE__ . '\deactivate_plugin' );

function deactivate_plugin() {
    
    // Unhook any sitemap changes
    remove_filter( 'rocket_sitemap_preload_list', __NAMESPACE__ . '\wprocket_preload_only_sitemap', PHP_INT_MAX );
   
    $options = get_option('wp_rocket_settings', []);

    // disable preload
    $options['manual_preload'] = 0;
    update_option('wp_rocket_settings', $options);
    
    // enable preload
    $options['manual_preload'] = 1;
    update_option('wp_rocket_settings', $options);

}




