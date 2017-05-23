<?php
defined( 'ABSPATH' ) or die( 'No direct access to this file.' );
/**
* Plugin Name: WP Rocket | Redirect HTTP to HTTPS
* Description: Adds rules to the .htaccess file in order to always redirect HTTP requests to HTTPS.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-https-redirect/
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
function wp_rocket_htaccess_redirect_to_https__before_rocket_htaccess_rules( $marker ) {

	$redirection  = '# Redirect http to https' . PHP_EOL;
	$redirection .= 'RewriteEngine On' . PHP_EOL;
	$redirection .= 'RewriteCond %{HTTPS} !on' . PHP_EOL;
	$redirection .= 'RewriteCond %{SERVER_PORT} !^443$' . PHP_EOL;
	$redirection .= 'RewriteCond %{HTTP:X-Forwarded-Proto} !https' . PHP_EOL;
	$redirection .= 'RewriteRule ^(.*)$ https://%{HTTP_HOST}/$1 [R=301,L]' . PHP_EOL;
	$redirection .= '# END https redirect' . PHP_EOL . PHP_EOL;

	// Prepend redirection rules to WP Rocket block.
	$marker = $redirection . $marker;

	return $marker;
}
add_filter( 'before_rocket_htaccess_rules', 'wp_rocket_htaccess_redirect_to_https__before_rocket_htaccess_rules' );

/**
 * Updates .htaccess, and regenerates config file.
 *
 * @return bool
 */
function wp_rocket_htaccess_redirect_to_https__housekeeping() {

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
register_activation_hook( __FILE__, 'wp_rocket_htaccess_redirect_to_https__housekeeping' );

/**
 * Removes plugin additions, updates .htaccess, and regenerates config file.
 *
 * @return bool
 */
function wp_rocket_htaccess_redirect_to_https__deactivate() {

	// We don’t want .htaccess rules added upon deactivation. Remove!
	remove_filter( 'before_rocket_htaccess_rules', 'wp_rocket_htaccess_redirect_to_https__before_rocket_htaccess_rules' );

	// Flush .htaccess rules and regenerate WP Rocket config file.
	wp_rocket_htaccess_redirect_to_https__housekeeping();
}
register_deactivation_hook( __FILE__, 'wp_rocket_htaccess_redirect_to_https__deactivate' );
