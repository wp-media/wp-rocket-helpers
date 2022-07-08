<?php
/**
 * Plugin Name: WP Rocket | Cache Feed
 * Description: Activate caching of WordPress RSS feeds by WP Rocket
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-cache-feed/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

require( plugin_dir_path( __FILE__ ) . '/inc/functions.php' );

/**
 * Run when plugin is loaded
 *
 * @author Remy Perona
 * @since 1.0
 */
function wp_rocket_cache_feed_init() {
	if ( ! is_wp_rocket_active() ) {
		return;
	}

	add_filter( 'rocket_cache_reject_uri', 'wp_rocket_cache_feed' );
}
add_action( 'plugins_loaded', 'wp_rocket_cache_feed_init' );

/**
 * Deactivate the plugin if WP Rocket is not active
 *
 * @author Remy Perona
 * @since 1.0
 */
function wp_rocket_cache_feed_maybe_deactivate() {
	if ( ! is_wp_rocket_active() ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		add_action( 'admin_notices', 'wp_rocket_cache_feed_notice' );
		return;
	}
}
add_action( 'admin_init', 'wp_rocket_cache_feed_maybe_deactivate' );



/**
 * Run when plugin is activated
 *
 * @author Remy Perona
 * @since 1.0
 */
function wp_rocket_cache_feed_activate() {
	if (  ! is_wp_rocket_active() ) {
		return;
	}

    add_filter( 'rocket_sitemap_preload_list', 'wp_rocket_preload_feeds' );
	add_filter( 'rocket_cache_reject_uri', 'wp_rocket_cache_feed' );
	rocket_generate_config_file();
	flush_rocket_htaccess();
}
register_activation_hook( __FILE__, 'wp_rocket_cache_feed_activate' );

/**
 * Run when plugin is deactivated
 *
 * @author Remy Perona
 * @since 1.0
 */
function wp_rocket_cache_feed_deactivate() {
	if ( ! is_wp_rocket_active() ) {
		return;
	}

	remove_filter( 'rocket_cache_reject_uri', 'wp_rocket_cache_feed' );
	rocket_generate_config_file();
	flush_rocket_htaccess();
	rocket_clean_home_feeds();
}
register_deactivation_hook( __FILE__, 'wp_rocket_cache_feed_deactivate' );
