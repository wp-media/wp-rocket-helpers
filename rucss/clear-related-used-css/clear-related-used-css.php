<?php
/**
 * Plugin Name: WP Rocket | Clear the Used CSS of Related Posts
 * Description: Clears the Used CSS of related posts, after a post has been updated.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\clear_related_rucss_posts;

// Standard plugin security, keep this line in place.
defined('ABSPATH') or die();

// Clear Used CSS for specific page
function wpr_clear_unused_css($pageId) {
    if (defined('WP_ROCKET_VERSION')) {
      // access rocket's injection container
      $container = apply_filters( 'rocket_container', null );
      // get the rucss subscriber from the container
      $subscriber = $container->get('rucss_admin_subscriber');
      // Delete Used CSS for page
      $subscriber->delete_used_css_on_update_or_delete($pageId);
    }
  }

  // clear the posts and the homepage
function clear_related_rucss_posts($purge_urls) {
	$purge_urls[] = rocket_get_home_url();
	foreach ( $purge_urls as $purge_url ) {
        $post_id = url_to_postid($purge_url);
        if ($post_id > 0) {
    		wpr_clear_unused_css($post_id);
        }
	}	
	return $purge_urls;
}

add_action( 'rocket_post_purge_urls', __NAMESPACE__.'\clear_related_rucss_posts' );


// clear the terms
/*
function clear_related_rucss_terms( $urls ) {
	error_log(print_r($urls, true)); // Logs the URLs to debug.log
	// from test, this array is empty
	foreach ( $urls as $url ) {
		wpr_clear_unused_css($url);
	}		
	return $urls;
}*/

//add_action( 'rocket_after_clean_terms', __NAMESPACE__.'\clear_related_rucss_terms' );

// Function to purge only the terms related to the post
function clear_rucss_for_post_terms($post_id) {
    // Check if it's a valid post type
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
        return;
    }

    // Get post terms for taxonomies (e.g., categories, tags)
    $taxonomies = get_object_taxonomies(get_post_type($post_id), 'names');
    $terms = wp_get_post_terms($post_id, $taxonomies);

    if (empty($terms) || is_wp_error($terms)) {
        return;
    }

    $purge_urls = [];

    // Get term URLs
    foreach ($terms as $term) {
        $purge_urls[] = get_term_link($term);
    }

    // Purge the Used CSS for each term URL
    foreach ($purge_urls as $url) {
        wpr_clear_unused_css($url);
    }
}

// Hook into post save/update to trigger Used CSS removal for related terms
add_action('rocket_after_clean_terms', __NAMESPACE__ . '\clear_rucss_for_post_terms');