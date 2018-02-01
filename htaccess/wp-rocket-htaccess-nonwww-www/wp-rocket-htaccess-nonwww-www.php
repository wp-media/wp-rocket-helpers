<?php
/**
 * Plugin Name: WP Rocket | Redirect non-www to www
 * Description: Redirects traffic from non-www to www URLs.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/htaccess/wp-rocket-htaccess-nonwww-www/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\htaccess\redirect\nonwww_www;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Add redirection rules to .htaccess file.
 *
 * @author Caspar Hübinger
 * @param  string $marker Block of WP Rocket rules
 * @return string         Extended block of WP Rocket rules
 */
function render_rewrite_rules( $marker ) {

	$redirection = '# Redirect non-www to www' . PHP_EOL;
	$redirection .= 'RewriteEngine On' . PHP_EOL;

	//// EDIT THESE 2 LINES ////
	$redirection .= 'RewriteCond %{HTTP_HOST} ^example\.com [NC]' . PHP_EOL;
	$redirection .= 'RewriteRule ^(.*)$ http://www.example.com/$1 [L,R=301]' . PHP_EOL . PHP_EOL;
	//// STOP EDITING ////

	// Prepend redirection rules to WP Rocket block.
	$marker = $redirection . $marker;

	return $marker;
}
add_filter( 'before_rocket_htaccess_rules', __NAMESPACE__ . '\render_rewrite_rules' );

/**
 * Updates .htaccess, regenerates WP Rocket config file.
 *
 * @author Caspar Hübinger
 */
function flush_wp_rocket() {

	if ( ! function_exists( 'flush_rocket_htaccess' )
	  || ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}

	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_wp_rocket' );

/**
 * Removes customizations, updates .htaccess, regenerates config file.
 *
 * @author Caspar Hübinger
 */
function deactivate() {

	// Remove all functionality added above.
	remove_filter( 'before_rocket_htaccess_rules', __NAMESPACE__ . '\render_rewrite_rules' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );
