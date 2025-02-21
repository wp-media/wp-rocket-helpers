<?php
/**
 * Plugin Name: WP Rocket | Disable WP Rocket Features For Specific Mobile Pages
 * Description: Disables WP Rocket on specific mobile pages when Mobile Cache with separate cache files is active.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/various/wp-rocket-no-features-for-mobile-page
 * Author:      WP Rocket Support Team
 * Author URI:  https://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */

namespace WP_Rocket\Helpers\various\no_wp_rocket_for_mobile_page;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Disable WP Rocket on specific mobile pages when Mobile Cache with separate cache files is active.
 *
 * @author Caspar Hübinger
 * @author Piotr Bąk
 */
function deactivate_for_mobile_devices() {
	
	if( class_exists( 'WP_Rocket_Mobile_Detect' ) && get_rocket_option( 'do_caching_mobile_files', false ) ) {
		
		$detect = new \WP_Rocket_Mobile_Detect();
		
		// You can change is_page condition or add new to target whatever you want
		if ( $detect->isMobile() && ! $detect->isTablet() && is_page( array( 2374 ) ) ) {
			
			// Finally: prevent caching for mobiles for particular pages.
			add_action( 'template_redirect', __NAMESPACE__ . '\donotcache' );
			
			return true;
			
		}
		
	}
	
}
add_action( 'wp', __NAMESPACE__ . '\deactivate_for_mobile_devices' );

/**
 * Prevent caching and optimization.
 *
 * @author Caspar Hübinger
 * @author Piotr Bąk
 */
function donotcache() {
	
	// Comment the line below out if you want to enable page caching
	define( 'DONOTCACHEPAGE', true );
	
	// Comment the line below out if you want to enable WP Rocket optimizations
	define( 'DONOTROCKETOPTIMIZE', true );
	
	return true;
	
}

/**
 * Cleans entire cache folder on activation.
 *
 * @author Arun Basil Lal
 */
function clean_wp_rocket_cache() {

	if ( ! function_exists( 'rocket_clean_domain' ) ) {
		return false;
	}

	// Purge entire WP Rocket cache.
	rocket_clean_domain();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\clean_wp_rocket_cache' );
