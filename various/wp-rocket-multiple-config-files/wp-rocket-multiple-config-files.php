<?php
/**
 * Plugin Name: WP Rocket | Multiple Config Files
 * Description: Useful for cases where there are multiple URLs sharing the same filebase and multiple config files are needed.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2020
 */


namespace WP_Rocket\Helpers\multiple_config_files;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


function define_urls(){
	
	if ( ! is_array( $extra_url ) ) {
        $extra_url = (array) $extra_url;
    	}

	// EDIT THIS. ADD ON EXTRA LINE PER DOMAIN
	$extra_url[] = 'example.com';
	//$extra_url[] = 'example.fr';
	// STOP EDITING
	
	return $extra_url;
}

/**
 * Generate multiple config files, add each URL at the $extra_url[] array
 *
 */
function clone_config( $config_files_path ) {

	if ( ! is_array( $config_files_path ) ) {
        $config_files_path = (array) $config_files_path;
    	}

	$extra_urls = define_urls();
	
	foreach($extra_urls as $url) {

		$sanitized_url =  preg_replace('#^https?://#', '', untrailingslashit( $url )).'.php' ;

		$mirror_config_file 	= WP_ROCKET_CONFIG_PATH . $sanitized_url;	
		
		$config_files_path[] = $mirror_config_file;
		
	}
	
	return $config_files_path;

}
add_filter( 'rocket_config_files_path', __NAMESPACE__ . '\clone_config' );


/**
 * Filter rocket_clean_domain_urls to include defined domains in cache purging
 *
 */
function multi_domain_cache_clearing( $clean_domain_urls ){
		
	if ( ! is_array( $clean_domain_urls ) ) {
        $clean_domain_urls = (array) $clean_domain_urls;
   	}
		
	$extra_urls = define_urls();
	
	foreach($extra_urls as $url) {
		
		$url_with_scheme = rocket_add_url_protocol($url);
		
		$sanitized_url = untrailingslashit( $url_with_scheme );
		
		$clean_domain_urls[] = $sanitized_url;
		
	}
	
	return $clean_domain_urls;
}
add_filter( 'rocket_clean_domain_urls', __NAMESPACE__ . '\multi_domain_cache_clearing' );

/**
 * Regenerates WP Rocket config file.
 *
 */
 
function flush_wp_rocket() {
	if ( ! function_exists( 'rocket_generate_config_file' )
	  || ! function_exists( 'rocket_delete_config_file' ) ) {
		return false;
	}
	

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();
	
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_wp_rocket' );


function deactivate() {
	
	// Delete Wp Rocket config files
	if (  function_exists( 'rocket_delete_config_file' )) {
		rocket_delete_config_file();
	}
	
	// Remove customizations upon deactivation.
	remove_filter( 'rocket_config_files_path', __NAMESPACE__ . '\clone_config' );
	remove_filter( 'rocket_clean_domain_urls', __NAMESPACE__ . '\multi_domain_cache_clearing' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();

}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );
