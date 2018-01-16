<?php 
/**
 * Plugin Name: WP Rocket Helper Plugin | YITH WooCommerce recently viewed products Integration
 * Plugin URI: https://wp-rocket.me
 * Description: Create a specific cache for each value of woocommerce_recently_viewed cookie
 * Version: 1.0
 * Author: WP Rocket Awesome Support Team
 * Author URI: http://wp-media.me
 * Licence: GPLv2
 **/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit; 

/**
 * Update WP Rocket config to serve a different cache for cache based on value set in cookie 'yith_wrvp_list_0'
 *
 * Config is in wp-content/wp-rocket-config
 * @since	1.0
 */
function abl1635_yihh_wcrvp_integration () {
	
	add_filter( 'rocket_htaccess_mod_rewrite' , '__return_false' );
	
	add_filter( 'rocket_cache_dynamic_cookies', '__rocket_dynamic_cache_wc_recently_viewed_products' );
	
	// Update the WP Rocket rules on the .htaccess file.
	if ( function_exists('flush_rocket_htaccess') )
		flush_rocket_htaccess();

	// Regenerate the config file.
	if ( function_exists('rocket_generate_config_file') )
		rocket_generate_config_file();
	
	// Clear WP Rocket cache
	if ( function_exists('rocket_clean_domain') )
		rocket_clean_domain();
}
register_activation_hook( __FILE__, 'abl1635_yihh_wcrvp_integration' );

/**
 * Returns the cookie name used by Recently Viewed Products plugin
 *
 * @return	String 	Name of the cookie
 * @since	1.0
 */
function __rocket_dynamic_cache_wc_recently_viewed_products( $dynamic_cookies ) {
	
	$dynamic_cookies[] = 'yith_wrvp_list_0';
	return $dynamic_cookies;
}

/**
 * Revert WP Rocket config when plugin is uninstalled
 *
 * Config is in wp-content/wp-rocket-config
 * @since	1.0
 */
function wrcabl1400_restore_config () {
	
	// Update the WP Rocket rules on the .htaccess file.
	if ( function_exists('flush_rocket_htaccess') )
		flush_rocket_htaccess();

	// Regenerate the config file.
	if ( function_exists('rocket_generate_config_file') )
		rocket_generate_config_file();
	
	// Clear WP Rocket cache
	if ( function_exists('rocket_clean_domain') )
		rocket_clean_domain();
}
register_deactivation_hook( __FILE__, 'wrcabl1400_restore_config' );