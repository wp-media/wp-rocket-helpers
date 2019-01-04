<?php
/**
 * Plugin Name: WP Rocket | Disable Cache Clearing On Widget Update
 * Description: Disables WP Rocket cache clearing when a widget is updated. 
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-no-cache-purge-widget-update
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */

namespace WP_Rocket\Helpers\cache\no_cache_auto_purge_widget_update_callback;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Disable Cache Clearing On Widget Update
 * 
 * @author Arun Basil Lal
 */
function remove_purge_hooks() {
	remove_filter( 'widget_update_callback'	, 'rocket_widget_update_callback' );
}
add_action( 'wp_rocket_loaded', __NAMESPACE__ . '\remove_purge_hooks' );