<?php
/**
 * Plugin Name: WP Rocket | No LazyLoad
 * Description: Disables LazyLoad for specified page types.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/lazyload/wp-rocket-no-lazyload/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\lazyload\no_lazyload;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

// DELETE/EDIT ANY OF THE FOLLOWING AS NEEDED:

/**
 * Disable LazyLoad on single post views.
 *
 * @author Caspar Hübinger
 */
function deactivate_on_single_post() {

	// Stop if not on a 'post' post type singular template.
	if ( ! is_singular( 'post' ) ) {
		return false;
	}

	// Disable LazyLoad for images.
	add_filter( 'do_rocket_lazyload', '__return_false' );
}
add_filter( 'wp', __NAMESPACE__ . '\deactivate_on_single_post' );

/**
 * Disable LazyLoad on single product views.
 *
 * @author Caspar Hübinger
 */
function deactivate_on_single_product() {

	// Stop if not on a 'product' post type singular template.
	if ( ! is_singular( 'product' ) ) {
		return false;
	}

	// Disable LazyLoad for images.
	add_filter( 'do_rocket_lazyload', '__return_false' );
}
add_filter( 'wp', __NAMESPACE__ . '\deactivate_on_single_product' );

/**
 * Disable LazyLoad on search result views.
 *
 * @author Caspar Hübinger
 */
function deactivate_on_search_results() {

	// Stop if not on a search results template.
	if ( ! is_search() ) {
		return false;
	}

	// Disable LazyLoad for images.
	add_filter( 'do_rocket_lazyload', '__return_false' );
}
add_filter( 'wp', __NAMESPACE__ . '\deactivate_on_search_results' );

// STOP DELETING/EDITING.

/**
 * Maybe render admin notice.
 *
 * @author Caspar Hübinger
 */
function maybe_render_admin_notice() {

	if ( ! maybe_is_admin_on_settings_page() ) {
		return false;
	}

	// Only if LazyLoad is enabled.
	if ( ! get_rocket_option( 'lazyload' ) ) {
		return false;
	}

	// Render message.
	printf(
		'<div class="notice notice-info"><p>%s</p></div>',
		__( '<strong>WP Rocket | No LazyLoad:</strong> LazyLoad is programmatically disabled on one or more page types.' )
	);
}
add_action( 'admin_notices', __NAMESPACE__ . '\maybe_render_admin_notice', 100 );

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
		return false;
	}

	// Only if WP Rocket is active.
	if ( ! function_exists( 'get_rocket_option' ) ) {
		return false;
	}

	// Only for WP Rocket administrators.
	if ( ! current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) ) ) {
		return false;
	}

	// Determine screen ID, we may be in white-label mode!
	$current_screen      = get_current_screen();
	$rocket_wl_name      = get_rocket_option( 'wl_plugin_name', null );
	$wp_rocket_screen_id = isset( $rocket_wl_name ) ? 'settings_page_' . sanitize_key( $rocket_wl_name ) : 'settings_page_wprocket';

	// Only on WP Rocket settings page.
	if ( $wp_rocket_screen_id !== $current_screen->base ) {
		return false;
	}

	return true;
}
