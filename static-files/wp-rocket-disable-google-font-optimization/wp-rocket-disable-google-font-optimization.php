<?php
/**
 * Plugin Name: WP Rocket | Disable Google Font Optimization
 * Description: Disable Google Font Optimization in WP Rocket. To re-enable the option, visit Tools tab of WP Rocket. 
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/static-files/wp-rocket-disable-google-font-optimization
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2026
 */

namespace WP_Rocket\Helpers\static_files\disable_google_font_optimization;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Disable Google Font Optimization in database.
 *
 * @author Arun Basil Lal
 */
function disable_google_font_optimization() {

	if ( ! function_exists( 'update_rocket_option' ) || ! function_exists( 'rocket_clean_domain' ) ) {
		return false;
	}
	
	// Disable Google Fonts Optimization
	update_rocket_option( 'minify_google_fonts', 0 );
	
	// Clear cache
	rocket_clean_domain();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\disable_google_font_optimization' );


/**
 * Reenable Google Fonts and clear WP Rocket's cache.
 */
function rollback_changes(){
	
	if ( ! function_exists( 'update_rocket_option' ) || ! function_exists( 'rocket_clean_domain' ) ) {
		return false;
	}
	
	// Enable Google Fonts Optimization
	update_rocket_option( 'minify_google_fonts', 1 );
	
	// Clear cache
	rocket_clean_domain();

}

register_deactivation_hook( __FILE__, __NAMESPACE__ . '\rollback_changes' );