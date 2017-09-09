<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
/**
 * Plugin Name: WP Rocket | Enforce Trailing Slash on URLs
 * Description: Enforces Trailing Slash on URLs
 * Author: WP Rocket Support Team
 * Author URI: https://wp-rocket.me
 */

/**
 * Forces trailing slash on GET request.
 *
 * @param string $marker WP Rocket htaccess rules.
 * @return Updated htaccess rules
 */
function wp_rocket_force_trailing_slash( $marker ) {
    $redirection = '# Force trailing slash' . PHP_EOL;
    $redirection .= 'RewriteEngine On' . PHP_EOL;
    $redirection .= 'RewriteCond %{REQUEST_FILENAME} !-f' . PHP_EOL;
    $redirection .= 'RewriteCond %{REQUEST_METHOD} GET' . PHP_EOL;
    $redirection .= 'RewriteCond %{REQUEST_URI} !(.*)/$' . PHP_EOL;
    $redirection .= 'RewriteRule ^(.*)$ http' . ( is_ssl() ? 's' : '' ) . '://%{HTTP_HOST}/$1/ [L,R=301]' . PHP_EOL . PHP_EOL;
    $marker = $redirection . $marker;
    return $marker;
}
add_filter( 'before_rocket_htaccess_rules', 'wp_rocket_force_trailing_slash' );

/**
 * Updates .htaccess on activation
 */
function wp_rocket_force_trailing_slash_activate() {
	if ( ! function_exists( 'flush_rocket_htaccess' ) ) {
		return false;
	}
	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();
}
register_activation_hook( __FILE__, 'wp_rocket_force_trailing_slash_activate' );

/**
 * Removes plugin additions, updates .htaccess
 */
function wp_rocket_force_trailing_slash_deactivate() {
	// We don’t want .htaccess rules added upon deactivation. Remove!
	remove_filter( 'before_rocket_htaccess_rules', 'wp_rocket_force_trailing_slash' );

	if ( ! function_exists( 'flush_rocket_htaccess' ) ) {
		return false;
	}
	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();
}
register_deactivation_hook( __FILE__, 'wp_rocket_force_trailing_slash_deactivate' );
