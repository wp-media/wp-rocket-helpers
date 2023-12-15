<?php
/**
 * Plugin Name: WP Rocket | Clear the Used CSS of related posts and taxonomies
 * Description: Clears the Used CSS of related posts and categories after a post has been updated.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\rucss\rucss_clear_related_posts;

// Standard plugin security, keep this line in place.
defined('ABSPATH') or die();

function wpr_clear_used_css( $the_post ) {
	
	$the_post = rtrim($the_post,"/");
	
	global $wpdb;
    $wpdb->delete($wpdb->prefix."wpr_rucss_used_css", array( 'url' => $the_post ));
}

// clear the posts and the homepage
function clear_related_rucss_posts( $purge_urls,  ) {
	$purge_urls[] = rocket_get_home_url();
	foreach ( $purge_urls as $purge_url ) {
		wpr_clear_used_css($purge_url);
	}	
	return $purge_urls;
}

add_action( 'rocket_post_purge_urls', __NAMESPACE__.'\clear_related_rucss_posts' );


// clear the terms
function clear_related_rucss_terms( $urls ) {
	foreach ( $urls as $url ) {
		wpr_clear_used_css($url);
	}		
	return $urls;
}

add_action( 'rocket_after_clean_terms', __NAMESPACE__.'\clear_related_rucss_terms' );
