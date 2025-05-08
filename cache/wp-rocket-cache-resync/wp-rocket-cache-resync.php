<?php
/**
 * Plugin Name: WP Rocket | Cache Status Resync
 * Description: Synchronize the cache table with the cache folder to keep the info current after each automatic cache purge
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2025
 */

// Namespaces must be declared before any other declaration.
namespace WP_Rocket\Helpers\resync_cache;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();



function resync_cache() {
    global $wpdb;

    // Set the table name
    $table_name = $wpdb->prefix . 'wpr_rocket_cache';

    // Retrieve URLs from the table
    $urls = $wpdb->get_col("SELECT url FROM $table_name");

    // Path to the cache folder
    $cache_folder = ABSPATH . 'wp-content/cache/wp-rocket/';
    // Loop through each URL
    foreach ($urls as $url) {
        // Generate the file path based on the URL
        $file_path = $cache_folder . str_replace(['https://'], [''], $url) . '/index-https.html';
                
        // Check if the file exists
        if (file_exists($file_path)) {
            // File exists for this URL
        } else {
			// update the row status			
			$wpdb->query( "UPDATE $table_name SET status = 'pending' WHERE url = '$url' " );

        }
    }

    
}

add_action( 'rocket_after_automatic_cache_purge', __NAMESPACE__ . '\resync_cache' );
