<?php
/**
 * Plugin Name: WP Rocket | No LazyLoad On Search Results
 * Description: Disables LazyLoad on search result pages
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/lazyload/wp-rocket-no-lazyload/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\lazyload\no_lazyload_search_results;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Disable LazyLoad on search result views.
 *
 * @author Arun Basil Lal
 */
function deactivate_on_search_results() {

	// Disable LazyLoad for images on a search results template.
	if ( is_search() ) {
		add_filter( 'do_rocket_lazyload', '__return_false' );
		remove_action( 'wp_footer', 'rocket_lazyload_script', PHP_INT_MAX );
	}
}
add_action( 'wp', __NAMESPACE__ . '\deactivate_on_search_results' );