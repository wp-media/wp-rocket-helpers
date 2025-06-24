<?php    
/**    
 * Plugin Name: WP Rocket | Taxonomy Cache Override    
 * Description: Removes WP Rocket's taxonomy validation filters to allow caching of invalid taxonomy pages    
 * Author:      WP Rocket Support Team  
 * Author URI:  http://wp-rocket.me/  
 * License:     GNU General Public License v2 or later  
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html  
 *  
 * Copyright SAS WP MEDIA 2018  
 */  
  
namespace WP_Rocket\Helpers\cache\taxonomy\override;  
  
// Standard plugin security, keep this line in place.  
defined( 'ABSPATH' ) or die();  
  
/**  
 * Override taxonomy subscriber to allow caching of invalid taxonomy pages.  
 */  
function override_taxonomy_subscriber() {  
    $container = apply_filters( 'rocket_container', null );  
  
    if ( ! $container ) {  
        return;  
    }  
  
    // Get the actual instance of TaxonomySubscriber  
    $taxonomy_subscriber = $container->get( 'taxonomy_subscriber' );  
  
    if ( ! $taxonomy_subscriber ) {  
        return;  
    }  
  
    // Remove filter from 'rocket_buffer'  
    remove_filter( 'rocket_buffer', [ $taxonomy_subscriber, 'stop_optimizations_for_not_valid_taxonomy_pages' ], 1 );  
  
    // Remove action from 'do_rocket_generate_caching_files'  
    remove_action( 'do_rocket_generate_caching_files', [ $taxonomy_subscriber, 'disable_cache_on_not_valid_taxonomy_pages' ] );  
}  
add_action( 'wp_rocket_loaded', __NAMESPACE__ . '\override_taxonomy_subscriber', PHP_INT_MAX );