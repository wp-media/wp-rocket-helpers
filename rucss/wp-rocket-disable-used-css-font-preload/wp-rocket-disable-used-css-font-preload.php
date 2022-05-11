<?php
/**
 * Plugin Name: WP Rocket | Disable Used CSS Fonts Preload 
 * Author:      WP Rocket Support Team
 * Description: Disables the preloading of fonts found in the used CSS.
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2022
 */

namespace WP_Rocket\Helpers\rucss\disable_preload_fonts;

/*
 * Disable font preloading in used CSS.
 * Filter: https://github.com/wp-media/wp-rocket/blob/3a5b9b11dbda004854d54a4f07dc4ddc95bf2dbc/inc/Engine/Optimization/RUCSS/Controller/UsedCSS.php#L636
 */

add_action( 'init', function(){
	if( is_rucss_enabled() ){
		add_filter( 'rocket_enable_rucss_fonts_preload', '__return_false' );
	}
});

/*
 * Clear used CSS and the cache and run preloading.
 */
function clear_used_css_and_cache(){
	if( ! is_rucss_enabled() ){
		return;
	}

	
	if( function_exists( 'rocket_clean_domain' ) ){
		$container = apply_filters( 'rocket_container', null );
		$rucss_subscriber = $container->get('rucss_admin_subscriber');
		$rucss_subscriber->truncate_used_css(); // Clear the used CSS.
		
		rocket_clean_domain(); // Clear the cache.
		
		preload_cache(); // Preload the cache.
	}
}

/*
 * Preloads WP Rocket's cache.
 */
function preload_cache(){
	if ( get_rocket_option( 'sitemap_preload' ) ) {
			run_rocket_sitemap_preload();// Preload the sitemap if sitemap preloading is enabled.
			return;
	}
		
	if( get_rocket_option( 'manual_preload' ) ){
		run_rocket_bot(); // Preload the homepage cache if preload is enabled but sitemap preloading is disabled.
	}
}

/*
 * Checks if Remove Unused CSS is enabled.
 */
function is_rucss_enabled(){
	
	static $is_rucss_enabled;
	
	if ( isset( $is_rucss_enabled ) ) {
		return $is_rucss_enabled;
	}
	
	if( function_exists( 'get_rocket_option' ) ){
		$is_rucss_enabled = get_rocket_option( 'remove_unused_css', 0 );
	}
	
	return $is_rucss_enabled;
}

register_activation_hook( __FILE__ , __NAMESPACE__ . '\clear_used_css_and_cache' );

register_deactivation_hook( __FILE__ , __NAMESPACE__ . '\clear_used_css_and_cache' );
