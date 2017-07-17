<?php
/**
 * Plugin Name: WP Rocket Cache Feed
 * Plugin URI: https://wp-rocket.me
 * Description: Activate caching of WordPress RSS feeds by WP Rocket
 * Version: 1.0
 * Author: WP Media
 * Contributors: Remy Perona
 * Author URI: http://wp-media.me
 * Licence: GPLv2
 *
 * Text Domain: wp-rocket-cache-feed
 * Domain Path: languages
 *
 * Copyright 2017 WP Rocket
 * */
 
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

require( plugin_dir_path( __FILE__ ) . '/inc/functions.php' );

/**
 * Run when plugin is loaded
 *
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
 * @since 1.0
 */
function wp_rocket_cache_feed_activate() {
	if (  ! is_wp_rocket_active() ) {
		return;
	}

	add_filter( 'rocket_cache_reject_uri', 'wp_rocket_cache_feed' );
	rocket_generate_config_file();
	flush_rocket_htaccess();
}
register_activation_hook( __FILE__, 'wp_rocket_cache_feed_activate' );

/**
 * Run when plugin is deactivated
 *
 * @since 1.0
 */
function wp_rocket_cache_feed_deactivate() {
	if ( ! is_wp_rocket_active() ) {
		return;
	}

	remove_filter( 'rocket_cache_reject_uri', 'wp_rocket_cache_feed' );
	rocket_generate_config_file();
	flush_rocket_htaccess();
}
register_deactivation_hook( __FILE__, 'wp_rocket_cache_feed_deactivate' );
