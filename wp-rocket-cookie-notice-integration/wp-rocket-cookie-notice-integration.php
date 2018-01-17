<?php 
/**
 * Plugin Name: WP Rocket Helper Plugin | Cookie Notice Integration
 * Plugin URI: https://wp-rocket.me
 * Description: A helper plugin for WP Rocket to integrate with Cookie Notice by dFactory
 * Version: 1.0
 * Author: WP Rocket Awesome Support Team
 * Author URI: http://wp-media.me
 * Licence: GPLv2
 **/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) exit; 

/**
 * Update WP Rocket config to serve cache based on value of 'cookie_notice_accepted'
 *
 * Config is in wp-content/wp-rocket-config
 * @author Arun Basil Lal
 */
function wrcabl1400_update_config_cookie_specific_cache () {
	
	// Create cache version based on value set in cookie_notice_accepted cookie.
	add_filter( 'rocket_cache_dynamic_cookies', 'wrcabl1400_cookie_name' );
	
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
register_activation_hook( __FILE__, 'wrcabl1400_update_config_cookie_specific_cache' );

/**
 * Return the cookie name set by Cookie Notice plugin
 *
 * @return string the cookie name.
 * @author Arun Basil Lal
 */
function wrcabl1400_cookie_name () {
	
	$cookie[] = 'cookie_notice_accepted';
	return $cookie;
}

/**
 * Revert WP Rocket config when plugin is uninstalled
 *
 * Config is in wp-content/wp-rocket-config
 * @author Arun Basil Lal
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