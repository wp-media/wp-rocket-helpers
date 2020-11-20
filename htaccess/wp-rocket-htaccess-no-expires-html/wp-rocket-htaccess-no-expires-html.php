<?php
/**
 * Plugin Name: WP Rocket | Remove HTML Expires from .htaccess rules
 * Description: Remove HTML expires rules from .htaccess rules.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2020
 */
 
 namespace WP_Rocket\Helpers\htaccess\remove_html_expires;


// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


function remove_htaccess_html_expire( $rules ) {
	
	$rules = preg_replace( '@\s*#\s*Your document html@', '', $rules );
	$rules = preg_replace( '@\s*ExpiresByType text/html\s*"access plus \d+ (seconds|minutes|hour|week|month|year)"@', '', $rules );

	return $rules;
}

add_filter('rocket_htaccess_mod_expires', __NAMESPACE__ . '\remove_htaccess_html_expire');


/**
 * Updates .htaccess, regenerates WP Rocket config file.
 *
 */
function flush_wp_rocket() {

	if ( ! function_exists( 'flush_rocket_htaccess' ) ) {
		return false;
	}

	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_wp_rocket' );


/**
 * Removes customizations, updates .htaccess, regenerates config file.
 *
 */
function deactivate() {
	
	remove_filter( 'rocket_htaccess_mod_expires', __NAMESPACE__ . '\remove_htaccess_html_expire' );
	
	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
	
}

register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );

