<?php
/**
 * Plugin Name: WP Rocket | Disable Cache Clearing When Slug Change
 * Description: Disables all of WP Rocket’s automatic cache clearing.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-no-cache-auto-purge/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2021
 */

namespace WP_Rocket\Helpers\cache\no_cache_auto_purge;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Prevent cache purge when a post's slug is changed.
 */
function disable_cache_purge_on_slug_change() {
    remove_action( 'pre_post_update', 'rocket_clean_post_cache_on_slug_change', PHP_INT_MAX, 2 );
}

add_action( 'wp_rocket_loaded', __NAMESPACE__ . '\disable_cache_purge_on_slug_change' );