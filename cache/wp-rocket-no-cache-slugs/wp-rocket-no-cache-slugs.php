<?php
/**
 * Plugin Name: WP Rocket | Disable Cache and Optimizations on specific pages 
 * Description: Use slugs to disable WP Rocket's caching and optimizations on specific pages or posts.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/cache/wp-rocket-no-cache-slugs
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2021
 */

namespace WP_Rocket\Helpers\cache\no_cache_for_specific_pages;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


function handle_cache_for_specific_pages() {


	//Only when is one of the excluded posts, edit to add your own list of slugs here
	$excluded_slugs = array( 
		'first-slug', 
		'other-slug', 
		'another-slugs'
	);	
	
	if ( ( !is_page( $excluded_slugs )) && ( !is_single( $excluded_slugs ))  )  {
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

