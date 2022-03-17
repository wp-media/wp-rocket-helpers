<?php
/**
 * Plugin Name: WP Rocket | No Cache for Admins
 * Description: Disable WP Rocket caching and optimizations for logged-in administrators.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-no-cache-for-admins/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\cache\no_cache_for_admins;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();



/**
 * Never serve cached pages to logged-in administrators.
 *
 * @author Vasilis Manthos
 */
function handle_cache_for_admins() {
	// Only for admins.
	if ( ! current_user_can( 'administrator' ) ) {
		return false;
	}

	//  Only when WP Rocket is active.
	if ( ! function_exists( 'get_rocket_option' ) ) {
		return false;
	}

	// Only when cache for logged-in users is active.
	if ( ! get_rocket_option( 'cache_logged_user' ) ) {
		return false;
	}

	// Display admin notice when cache for all logged-in users is active.
	if( class_exists( 'WP_Rocket\Buffer\Config' ) ) { 

	$config_dir_path = array();
	$config = new \WP_Rocket\Buffer\Config( $config_dir_path );

		if ( $config->get_config( 'common_cache_logged_users' ) ) {
			add_action( 'admin_notices', __NAMESPACE__ . '\maybe_render_admin_notice' );
		}
	}
	
	// Display admin notice when deprecated cache for all logged-in users is active.
	if ( get_rocket_option( 'common_cache_logged_users' ) ) {
		add_action( 'admin_notices', __NAMESPACE__ . '\maybe_render_admin_notice' );
		return false;
	}
	
	// Finally: prevent caching for administrators.
	add_action( 'template_redirect', __NAMESPACE__ . '\donotcache', 1 );

	return true;
}
add_action( 'init', __NAMESPACE__ . '\handle_cache_for_admins' );

/**
 * Prevent caching and optimization.
 *
 * @author Caspar Hübinger
 */
function donotcache() {

	if ( ! defined( 'DONOTCACHEPAGE' ) ) {
		define( 'DONOTCACHEPAGE', true );
		//error_log( date('[ Y-m-d H:i:s ] ', $_SERVER['REQUEST_TIME'] ) ."donotcache\n", 3, ABSPATH . "/no_admin_cache.log" );
	}
	
	if ( ! defined( 'DONOTROCKETOPTIMIZE' ) ) {
		define( 'DONOTROCKETOPTIMIZE', true );
		//error_log( date('[ Y-m-d H:i:s ] ', $_SERVER['REQUEST_TIME'] ) ."donotoptimize\n", 3, ABSPATH . "/no_admin_cache.log" );
	}
	
	return true;
}

/**
 * Render admin notice on WP Rocket settings page.
 *
 * @author Caspar Hübinger
 */
function maybe_render_admin_notice() {
	//error_log( date('[ Y-m-d H:i:s ] ', $_SERVER['REQUEST_TIME'] ) ."maybe_render_admin_notice\n", 3, ABSPATH . "/no_admin_cache.log" );
	if ( ! maybe_is_admin_on_settings_page() ) {
		//error_log( date('[ Y-m-d H:i:s ] ', $_SERVER['REQUEST_TIME'] ) ."Returned in line ". __LINE__ . "\n", 3, ABSPATH . "/no_admin_cache.log" );
		return false;
	}

	// Render admin notice.
	printf(
		'<div class="notice notice-warning"><p>%s</p></div>',
		__( '<strong>No Cache for Admins:</strong> You are using the same cache for all logged-in users. Therefore this plugin will not be able to prevent caching for administrators. You will see cached pages when you visit your website, even as an administrator.' )
	);
}

/**
 * Check if we’re inside the admin_notices filter, on WP Rocket’s settings page,
 * and the current user has permission to manage WP Rocket.
 *
 * @author Caspar Hübinger
 *
 * @return bool True if all of the above, else false
 */
function maybe_is_admin_on_settings_page() {

	// Only to be used in admin_notices filter.
	if ( 'admin_notices' !== current_filter() ) {
		//error_log( date('[ Y-m-d H:i:s ] ', $_SERVER['REQUEST_TIME'] ) ."Returned in line ". __LINE__ . "\n", 3, ABSPATH . "/no_admin_cache.log" );
		return false;
	}

	// Only if WP Rocket is active.
	if ( ! function_exists( 'get_rocket_option' ) ) {
		//error_log( date('[ Y-m-d H:i:s ] ', $_SERVER['REQUEST_TIME'] ) ."Returned in line ". __LINE__ . "\n", 3, ABSPATH . "/no_admin_cache.log" );
		return false;
	}

	// Only for WP Rocket administrators.
	if ( ! current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) ) ) {
		//error_log( date('[ Y-m-d H:i:s ] ', $_SERVER['REQUEST_TIME'] ) ."Returned in line ". __LINE__ . "\n", 3, ABSPATH . "/no_admin_cache.log" );
		return false;
	}

	// Determine screen ID, we may be in white-label mode!
	$current_screen      = get_current_screen();
	$rocket_wl_name      = get_rocket_option( 'wl_plugin_name', null );
	$wp_rocket_screen_id = isset( $rocket_wl_name ) ? 'settings_page_' . sanitize_key( $rocket_wl_name ) : 'settings_page_wprocket';

	// Only on WP Rocket settings page.
	if ( $wp_rocket_screen_id !== $current_screen->base ) {
		//error_log( date('[ Y-m-d H:i:s ] ', $_SERVER['REQUEST_TIME'] ) ."Returned in line ". __LINE__ . "\n", 3, ABSPATH . "/no_admin_cache.log" );
		return false;
	}

	return true;
}
