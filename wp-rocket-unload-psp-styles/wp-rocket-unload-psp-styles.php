<?php 
/**
 * Plugin Name: WP Rocket Helper Plugin | Unload PSP Styles
 * Plugin URI: https://wp-rocket.me
 * Description: Unload Premium SEO pack styles on WP Rocket settings page
 * Version: 1.0
 * Author: WP Rocket Awesome Support Team
 * Author URI: http://wp-media.me
 * Licence: GPLv2
 **/ 
 
// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit;

function abl1351_unload_psp_styles( ) {
	
	// Retun on all pages but WP Rocket settings page
	$screen = get_current_screen();
	if ( $screen->id != 'settings_page_wprocket' ) {
		return;
	}

	// Dequeueing this style unfreezes WP Rocket 
	wp_dequeue_style( 'psp-main-style' );
}
add_action( 'admin_print_styles', 'abl1351_unload_psp_styles', 11 );