<?php
/**
 * Plugin Name: WP Rocket for DreamPress
 * Plugin URI: https://wp-rocket.me
 * Description: Compatibility add-on for WP Rocket on DreamPress.
 * Version: 1.0
 * Author: WP Media
 * Contributors: Remy Perona
 * Author URI: http://wp-media.me
 * Licence: GPLv2
 *
 * Text Domain: wp-rocket-for-dreampress
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
function wp_rocket_for_dreampress_init() {
	if ( ! is_wp_rocket_active() ) {
		return;
	}

	add_filter( 'do_rocket_varnish_http_purge', '__return_true' );
	add_filter( 'rocket_display_varnish_options_tab', '__return_false' );
	add_filter( 'rocket_minify_bypass_varnish', 'wp_rocket_dreampress_minify_compatibility' );
	add_filter( 'rocket_htaccess_mod_expires', 'wp_rocket_remove_html_expire_dreampress' );
}
add_action( 'plugins_loaded', 'wp_rocket_for_dreampress_init' );

/**
 * Deactivate the plugin if WP Rocket is not active
 *
 * @since 1.0
 */
function wp_rocket_for_dreampress_maybe_deactivate() {
	if ( ! is_wp_rocket_active() ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		add_action( 'admin_notices', 'wp_rocket_dreampress_notice' );
		return;
	}
}
add_action( 'admin_init', 'wp_rocket_for_dreampress_maybe_deactivate' );

/**
 * Run when plugin is activated
 *
 * @since 1.0
 */
function wp_rocket_for_dreampress_activate() {
	if (  ! is_wp_rocket_active() ) {
		return;
	}

	add_filter( 'rocket_htaccess_mod_expires', 'wp_rocket_remove_html_expire_dreampress' );
	flush_rocket_htaccess();
}
register_activation_hook( __FILE__, 'wp_rocket_for_dreampress_activate' );

/**
 * Run when plugin is deactivated
 *
 * @since 1.0
 */
function wp_rocket_for_dreampress_deactivate() {
	if ( ! is_wp_rocket_active() ) {
		return;
	}

	remove_filter( 'rocket_htaccess_mod_expires', 'wp_rocket_remove_html_expire_dreampress' );
	flush_rocket_htaccess();
}
register_deactivation_hook( __FILE__, 'wp_rocket_for_dreampress_deactivate' );
