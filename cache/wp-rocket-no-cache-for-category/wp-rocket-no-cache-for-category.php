<?php
/**
 * Plugin Name: WP Rocket | Disable Cache for Posts under a Category
 * Description: Disable caching and optimizations for posts under a specific post category.
 * Plugin URI:  https://wp-rocket.me
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\cache\disable_cache_based_on_post_category;


// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


function handle_cache_for_specific_pages() {

    
    $excluded_categories  = array( 
        // duplicate this line if you want to exclude more categories
        'excluded', 
    );
    
    // only for posts, you can modify this if needed
    if(!is_singular('post')) {
        return false;
    }
    
    //Only when the post is udner a specific category
    if ( ( !has_category( $excluded_categories ) )  )  {
        return false;
    } 
    
    // Prevent caching
    add_action( 'template_redirect', __NAMESPACE__ . '\donotcache' );
}

add_action( 'wp', __NAMESPACE__ . '\handle_cache_for_specific_pages' );

/**
 * Prevent caching and optimization.
 *
 * @author Caspar Hübinger
 */
function donotcache() {

    if ( ! defined( 'DONOTCACHEPAGE' ) ) {
        define( 'DONOTCACHEPAGE', true );
    }
    
    if ( ! defined( 'DONOTROCKETOPTIMIZE' ) ) {
        define( 'DONOTROCKETOPTIMIZE', true );
    }
    
    return true;
}
