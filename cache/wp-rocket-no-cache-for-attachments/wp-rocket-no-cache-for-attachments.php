<?php
/**
 * Plugin Name: WP Rocket | Disable Page Caching for Attachment Pages
 * Description: Disables WP Rocket’s page cache file generation on WordPress Attachment pages while preserving other optimization features.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-no-cache-for-attachments/
 * Author:      WP Rocket Support Team
 * Author URI:  https://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\cache\no_cache_for_attachments;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Disable cache file generation on specific pages
 *
 * @author Arun Basil Lal
 * @author Caspar Hübinger
 */
function no_cache_for_attachments( $filter ) {

	if ( function_exists( 'is_attachment' ) && ! is_attachment() ) {
		return $filter;
	}

	return false;
}
add_filter( 'do_rocket_generate_caching_files', __NAMESPACE__ . '\no_cache_for_attachments' );

/**
 * Cleans entire cache folder on activation.
 *
 * @author Arun Basil Lal
 */
function clean_wp_rocket_cache() {

	if ( ! function_exists( 'rocket_clean_domain' ) ) {
		return false;
	}

	// Purge entire WP Rocket cache.
	rocket_clean_domain();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\clean_wp_rocket_cache' );
