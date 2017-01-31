<?php
defined( 'ABSPATH' ) or die( 'No direct access to this file.' );
/**
 * Plugin Name: WP Rocket | No Cache for Admins
 * Description: Never serve cached pages to logged-in administrators. Ever.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/wp-rocket-no-cache-for-admins/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Never serve cached pages to logged-in administrators.
 *
 * @return bool TRUE when current user is administrator, else FALSE
 */
function wp_rocket_no_cache_for_admins() {

	// Only for admins.
	if ( ! current_user_can( 'administrator' ) )
		return false;

	//  Only when WP Rocket is active.
	if ( ! function_exists( 'get_rocket_option' ) )
		return false;

	// Only when cache for logged-in users is active.
	if ( ! get_rocket_option( 'cache_logged_user' ) )
		return false;

	// Display admin notice when same cache for all logged-in users is active.
	if ( get_rocket_option( 'common_cache_logged_users' ) ) {

		add_action( 'admin_notices', 'wp_rocket_no_cache_for_admins__nope' );

		return false;
	}

	// Finally: prevent caching for administrators.
	add_action( 'template_redirect', 'wp_rocket_no_cache_for_admins__yep' );

	return true;
}
add_action( 'init', 'wp_rocket_no_cache_for_admins' );

/**
 * Prevent caching.
 *
 * @return bool TRUE
 */
function wp_rocket_no_cache_for_admins__yep() {

	define( 'DONOTCACHEPAGE', true );

	return true;
}

/**
 * Render admin notice on WP Rocket settings page.
 *
 * @return bool TRUE when admin notice has been rendered, else FALSE.
 */
function wp_rocket_no_cache_for_admins__nope() {

	$current_screen = get_current_screen();

	// Only on WP Rocket settings pages.
	if ( 'admin_notices' === current_filter() && ( isset( $current_screen ) && 'settings_page_wprocket' === $current_screen->base ) ) {

		// Render admin notice.
		printf(
			'<div class="notice notice-warning"><p>%s</p></div>',
			__( '☝️&#160;<strong>WP Rocket | No Cache for Admins:</strong> You’re using the same cache for all logged-in users. Therefore this plugin won’t be able to prevent caching for administrators. You will see cached pages when you visit your website, even as an administrator.' )
		);

		return true;
	}

	return false;
}
