<?php
/**
 * Plugin Name: WP Rocket | Shortcode based cache exclusions
 * Description: Exclude posts from cache and optimizations based on shortcodes present at the post content.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2020
 */

namespace WP_Rocket\Helpers\cache\no_cache_content_shortcodes;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

function never_cache_urls_shortcode() {

 	if(has_shortcode()) {
		
		define( 'DONOTCACHEPAGE', true );
		define( 'DONOTROCKETOPTIMIZE', true );
		
	}
}

add_action( 'wp', __NAMESPACE__ . '\never_cache_urls_shortcode' );


// search for custom string in the post content
function has_shortcode() {
     global $post;
     $all_content = get_the_content();
     
     // Edit the '[shortcode' string to match the shortcode you'd like to exclude from cache.
     if (strpos($all_content, '[shortcode') !== false) {
	 	return true;
     } else {
	 	return false;
     }
}

