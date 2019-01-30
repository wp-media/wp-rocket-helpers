<?php
/**
 * Plugin Name: WP Rocket | HTACCESS Authorization For Preload
 * Description: Adds the .htaccess username and password to the preload request so that WP Rocket can preload pages that are password protected. 
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/preload/wp-rocket-preload-htaccess-auth
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */

namespace WP_Rocket\Helpers\preload\preload_htaccess_auth;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

// EDIT_HERE
if ( ! defined( 'WPROCKETHELPERS_HTACCESS_USERNAME' ) ) {
	define( 'WPROCKETHELPERS_HTACCESS_USERNAME', 'EDIT_ME' );
}

if ( ! defined( 'WPROCKETHELPERS_HTACCESS_PASSWORD' ) ) {
	define( 'WPROCKETHELPERS_HTACCESS_PASSWORD', 'EDIT_ME' );
}
// STOP_EDITING

/**
 * Filters the arguments for wp_remote_get requests
 *
 * @author Arun Basil Lal
 */
function filter_wp_remote_get_args() {
	add_filter( 'rocket_preload_url_request_args', __NAMESPACE__ . '\add_htaccess_authorization_header' );
	add_filter( 'rocket_preload_sitemap_request_args', __NAMESPACE__ . '\add_htaccess_authorization_header' );
	add_filter( 'rocket_partial_preload_url_request_args', __NAMESPACE__ . '\add_htaccess_authorization_header' );
	// add_filter( 'rocket_htaccess_rules_test_args', __NAMESPACE__ . '\add_htaccess_authorization_header' );
}
add_action( 'wp_rocket_loaded', __NAMESPACE__ . '\filter_wp_remote_get_args' );

/**
 * Adds a headers argument with .htaccess authorization
 * 
 * @param (array) $args Array of arguments passed to wp_remote_get
 * 
 * @return (array) $args Array with Authorization 'headers' added.
 * 
 * @author Arun Basil Lal
 */
function add_htaccess_authorization_header( $args ) {
	
	$args['headers'] = array( 
		'Authorization' => 'Basic ' . base64_encode( WPROCKETHELPERS_HTACCESS_USERNAME . ':' . WPROCKETHELPERS_HTACCESS_PASSWORD )
	);
	
	return $args;
}

/**
 * Clears old preload process and makes way for new one. 
 *
 * @author Arun Basil Lal
 */
function activation_todo() {
	
	if ( class_exists( '\WP_Rocket\Preload\Full_Process' ) ) {
		$preload_process = new \WP_Rocket\Preload\Full_Process();
		$preload_process->complete();
	}
	
	delete_transient( 'rocket_preload_complete' );
	delete_transient( 'rocket_preload_errors' );
	
	delete_transient( 'doing_cron' );
	spawn_cron();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\activation_todo' );