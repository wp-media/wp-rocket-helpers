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


/**
 * Generate multiple config files, add each URL at the $extra_url[] array
 *
 */
function clone_config( $config_files_path ) {

	$extra_url[] = 'another-url.com';
	$extra_url[] = 'and-another-url.com';
		
	foreach($extra_url as $url) {

		$sanitized_url =  preg_replace('#^https?://#', '', untrailingslashit( $url )).'.php' ;

		$mirror_config_file 	= WP_ROCKET_CONFIG_PATH . $sanitized_url;	
		
		$config_files_path[] = $mirror_config_file;
		
	}
	
	return $config_files_path;

}
	
add_filter( 'rocket_config_files_path', __NAMESPACE__ . '\clone_config' );


/**
 * Regenerates WP Rocket config file.
 *
 */
 
function flush_wp_rocket() {
	if ( ! function_exists( 'flush_rocket_htaccess' )
	  || ! function_exists( 'rocket_generate_config_file' )
	  || ! function_exists( 'rocket_delete_config_file' ) ) {
		return false;
	}
	
	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();

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
	
	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();

}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );