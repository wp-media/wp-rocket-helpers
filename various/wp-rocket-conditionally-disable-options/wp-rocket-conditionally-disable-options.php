<?php
/**
 * Plugin Name: WP Rocket | Conditionally disable options
 * Description: Disable WP Rocket options based on specific conditions 
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/various/wp-rocket-conditionally-disable-options/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2021
 */

 
namespace WP_Rocket\Helpers\wproptions\deactivate_options_under_some_conditions;
 
// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();
 
 
function deactivate_options_on_custom_post_type() {
 
	// a) Based on any condition, in this case when is a Product single.
	// you can use any condition here, for other custom post types, specific pages, etc.
	if ( is_singular( 'product' ) ) {
		
		// b) deactivate one option in WP Rocket 
		add_filter( 'pre_get_rocket_option_delay_js', '__return_zero' );
		
		// here is the full list of all available filters: https://snippi.com/s/d9c2h4g
	}
}
add_action( 'wp', __NAMESPACE__ . '\deactivate_options_under_some_conditions' );


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