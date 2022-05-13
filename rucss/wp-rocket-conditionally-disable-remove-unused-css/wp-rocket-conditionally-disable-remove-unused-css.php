<?php
/**
 * Plugin Name: WP Rocket | Conditionally Disable Remove Unused CSS
 * Description: Disable WP Rocket Remove Unused CSS for groups of pages, based on their URLs slugs 
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/various/wp-rocket-conditionally-toggle-options/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2022
 */

 
namespace WP_Rocket\Helpers\rucss\disable_rucss_under_some_conditions;
 
// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();
 
 
function deactivate_options() {
 

    $url =  "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    
    // edit this line to add the condition. 
    //Use a portion of the URL that when detected, will deactivate Remove Unused CSS for that page. 
    
    // SINGLE CONDITION
    if ( strpos( $url, '/product' ) !== false )
        {
            add_filter( 'pre_get_rocket_option_remove_unused_css', '__return_zero' );
        }

    /*
    // MULTIPLE CONDITIONS
    if ( 
        strpos( $url, '/product' ) !== false    || 
        strpos( $url, '/tag' ) !== false        || 
        strpos( $url, '/category' ) !== false   || 
        strpos( $url, '/size' ) !== false 
        ) {
        
            add_filter( 'pre_get_rocket_option_remove_unused_css', '__return_zero' );
            
        }
	*/
}
add_action( 'wp', __NAMESPACE__ . '\deactivate_options' );


/**
 * Cleans entire cache on activation and deactivation
 *
 * @author Arun Basil Lal
 */
function clean_domain() {
	
	if ( ! function_exists( 'rocket_clean_domain' ) ) {
		return false;
	}
	
	// Purge entire cache
	rocket_clean_domain();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\clean_domain' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\clean_domain' );