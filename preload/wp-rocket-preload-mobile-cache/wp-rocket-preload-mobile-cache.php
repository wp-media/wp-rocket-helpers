<?php
/**
 * Plugin Name: WP Rocket | Preload mobile cache
 * Description: Will preload the mobile cache instead of the desktop cache
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */


// Namespaces must be declared before any other declaration.
namespace WP_Rocket\Helpers\preload\mobile_cache;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


/**
 * Change the user-agent that's used for proeloading to a mobile one.
 *
 * @param array $args Array holding the request arguments.
 * @author Vasilis Manthos
 */
 
 function rocket_preload_mobile_cache( $args ) {
	 
	 // Android Chrome user agent supporting WebP
	 
    $args['user-agent'] = 'Mozilla/5.0 (Linux; Android 8.0.0;) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.116 Mobile Safari/537.36';
    
    return $args;
}

// Full preload

 add_filter( 'rocket_preload_url_request_args', __NAMESPACE__ . '\rocket_preload_mobile_cache');
 
 
// Partial preload
 
 add_filter( 'rocket_partial_preload_url_request_args', __NAMESPACE__ . '\rocket_preload_mobile_cache');


// Sitemap preload

 add_filter( 'rocket_preload_sitemap_request_args', __NAMESPACE__ . '\rocket_preload_mobile_cache');
