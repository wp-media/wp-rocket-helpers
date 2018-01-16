<?php
/**
 * Plugin Name: WP Rocket | Cache Search Results
 * Description: Enables caching for search result pages.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-cache-search-results/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Copyright WP Media 2018
 */

// Standard plugin security, don’t remove this line.
defined( 'ABSPATH' ) or die();

/**
 * This is, in fact, it.
 */
add_filter( 'rocket_cache_search', '__return_true' );
