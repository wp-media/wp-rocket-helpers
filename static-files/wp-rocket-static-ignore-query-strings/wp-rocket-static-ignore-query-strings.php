<?php
/**
 * Plugin Name: WP Rocket | Ignore Query Strings
 * Description: Define query strings that should use the same set of cache.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/static/wp-rocket-static-ignore-query-strings
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */
// Namespaces must be declared before any other declaration.
namespace WP_Rocket\Helpers\static_files\ignore_query_strings;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Add new parameters or remove existing ones.
 * You can add new parameter by copying existing line and changing its name in brackets.
 * To remove existing parameters, please comment desired parameter like it's done with 'new_query_string'.
 *
 * @author Piotr Bąk
 */
function define_ignored_parameters( array $params ) {
	
	$params = [
		'utm_source'      => 1,
		'utm_medium'      => 1,
		'utm_campaign'    => 1,
		'utm_expid'       => 1,
		'utm_term'        => 1,
		'utm_content'     => 1,
		'fb_action_ids'   => 1,
		'fb_action_types' => 1,
		'fb_source'       => 1,
		'fbclid'          => 1,
		'gclid'           => 1,
		'age-verified'    => 1,
		'ao_noptimize'    => 1,
		'usqp'            => 1,
		'cn-reloaded'     => 1,
		'_ga'             => 1,
//		'new_query_string'	=> 1,	
	];
	
	return $params;
	
}
// Filter rocket_cache_ignored_parameters parameters
add_filter( 'rocket_cache_ignored_parameters', __NAMESPACE__ . '\define_ignored_parameters' );

/**
 * Updates .htaccess, regenerates WP Rocket config file.
 *
 * @author Piotr Bąk
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
 * @author Piotr Bąk
 */
function deactivate() {

	// Remove all functionality added above.
	remove_filter( 'rocket_cache_ignored_parameters', __NAMESPACE__ . '\define_ignored_parameters' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );