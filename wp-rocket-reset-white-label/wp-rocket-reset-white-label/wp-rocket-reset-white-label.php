<?php
/**
 * Plugin Name: WP Rocket Reset White Label
 * Plugin URI: https://wp-rocket.me
 * Description: Reset White Label to new default values
 * Version: 1.0
 * Author: WP Media
 * Contributors: Remy Perona
 * Author URI: http://wp-media.me
 * Licence: GPLv2 or later
 *
 * Copyright 2017 WP Rocket
 * */
 
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

function wp_rocket_reset_white_label_values() {
	if ( ! is_plugin_active( 'wp-rocket/wp-rocket.php' ) ) {
		return;
	}

	if ( function_exists( 'update_rocket_option' ) ) {
		update_rocket_option( 'wl_plugin_name', 'WP Rocket' );
		update_rocket_option( 'wl_plugin_slug', 'wprocket' );
		update_rocket_option( 'wl_plugin_URI', 'https://wp-rocket.me' );
		update_rocket_option( 'wl_description', array( 'The best WordPress performance plugin.' ) );
		update_rocket_option( 'wl_author', 'WP Media' );
		update_rocket_option( 'wl_author_URI', 'https://wp-media.me' );
	}
}
register_activation_hook( __FILE__, 'wp_rocket_reset_white_label_values' );
