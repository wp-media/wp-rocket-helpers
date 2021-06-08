<?php
/**
 * Plugin Name: WP Rocket | Conditionally toggle options
 * Description: Toggle WP Rocket options based on specific conditions 
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/various/wp-rocket-conditionally-toggle-options/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2021
 */

 
namespace WP_Rocket\Helpers\wproptions\toggle_options_under_some_conditions;
 
// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();
 
 
function deactivate_options() {
 
	// a) Based on any condition, in this case when is a Product single.
	// you can use any condition here, for other custom post types, specific pages, etc.
	if ( is_singular( 'product' ) ) {
		
		// b) deactivate one option in WP Rocket 
		add_filter( 'pre_get_rocket_option_delay_js', '__return_zero' );
		
		// here is the full list of all available filters: https://docs.wp-rocket.me/article/1564-list-of-pre-get-rocket-option-filters
	}
}
add_action( 'wp', __NAMESPACE__ . '\deactivate_options' );


/**
 * Cleans entire cache on activation and deactivation
 *
 * @author Arun Basil Lal
 */
function clean_domain() {
	
	if ( ! function_exists( 'rocket_clean_domain' ) ) {
		return false;
	}
	
	// Purge entire cache
	rocket_clean_domain();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\clean_domain' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\clean_domain' );