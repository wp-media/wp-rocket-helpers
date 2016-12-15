<?php
defined( 'ABSPATH' ) or die( 'No direct access to this file.' );
/**
* Plugin Name: WP Rocket | Redirect www to non-www
* Description: Fixes redirection from www to non-www URLs.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/wp-rocket-www-nonwww-redirect/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Add redirection rules to .htaccess file.
 * @param  string $marker Block of WP Rocket rules
 * @return string         Extended block of WP Rocket rules
 */
function wp_rocket_htaccess_redirect_www_to_nonwww( $marker ) {

	$redirection = '# Redirect www to non-www' . PHP_EOL;
	$redirection .= 'RewriteEngine On' . PHP_EOL;

	//// EDIT THESE 2 LINES ////
	$redirection .= 'RewriteCond %{HTTP_HOST} ^www.example\.com [NC]' . PHP_EOL;
	$redirection .= 'RewriteRule ^(.*)$ http://example.com/$1 [L,R=301]' . PHP_EOL . PHP_EOL;
	//// STOP EDITING ////

	// Prepend redirection rules to WP Rocket block.
	$marker = $redirection . $marker;

	return $marker;
}
add_filter( 'before_rocket_htaccess_rules', 'wp_rocket_htaccess_redirect_www_to_nonwww' );

/**
 * Updates .htaccess, and regenerates config file.
 *
 * @return bool
 */
function wp_rocket_htaccess_redirect_www_to_nonwww__housekeeping() {

	if ( ! function_exists( 'flush_rocket_htaccess' )
	  || ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}

	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();

	// Return a value for testing.
	return true;
}
register_activation_hook( __FILE__, 'wp_rocket_htaccess_redirect_www_to_nonwww__housekeeping' );

/**
 * Removes plugin additions, updates .htaccess, and regenerates config file.
 *
 * @return bool
 */
function wp_rocket_htaccess_redirect_www_to_nonwww__deactivate() {

	// We don’t want .htaccess rules added upon deactivation. Remove!
	remove_filter( 'before_rocket_htaccess_rules', 'wp_rocket_htaccess_redirect_www_to_nonwww' );

	// Flush .htaccess rules and regenerate WP Rocket config file.
	wp_rocket_htaccess_redirect_www_to_nonwww__housekeeping();
}
register_deactivation_hook( __FILE__, 'wp_rocket_htaccess_redirect_www_to_nonwww__deactivate' );
