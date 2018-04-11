<?php
/**
 * Plugin Name: WP Rocket | Toolbar Clear Cache Link
 * Description: Adds a “Clear cache” link to the toolbar for users who can publish posts.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-cache-purge-toolbar-link/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\cache\clear_cache_toolbar_link;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * The minimum capability for users to see the new Clear cache button in the
 * toolbar is `publish_posts` which translates into the user role of “Author”.
 *
 * This makes sense in most cases, since a person who can’t publish new content
 * usually won’t have to clear the cache.
 *
 * However, if a different capability or user role is required in your case,
 * feel free to edit the following constant.
 */

// EDIT THIS TO CUSTOMIZE THE MINIMUM CAPACITY FOR THE NEW TOOLBAR LINK:
define( 'WPROCKETHELPERS_CACHE_PURGE_TOOLBAR_LINK_CAPACITY', 'publish_posts' );
// STOP EDITING.

/**
 * Renders a “Clear cache” button in the toolbar.
 *
 * @author Caspar Hübinger
 * @link   https://developer.wordpress.org/reference/classes/wp_admin_bar/
 * @param  object $wp_admin_bar WP_Admin_Bar object
 * @return object               WP_Admin_Bar object
 */
function render( $wp_admin_bar ) {

	$icon_html = '<span class="ab-icon dashicons-before dashicons-trash" style="top:2px;" aria-hidden="true"></span>';

	$wp_admin_bar->add_menu([
		'id' 	 => 'wp-rocket-clear-cache-button',
		'href'   => wp_nonce_url( admin_url( 'admin-post.php?action=purge_cache&type=all' ), 'purge_cache_all' ),
	//	'parent' => 'top-secondary', // uncomment to place next to user menu in secondary toolbar
		'title'	 => $icon_html . esc_html__( 'Clear cache', 'rocket' ),
	]);

	return $wp_admin_bar;
}

/**
 * Adds toolbar link for users with sufficient capabilities.
 *
 * @author Caspar Hübinger
 */
function maybe_add() {

	// Not for WP Rocket admins since those already have a full toolbar menu.
	if ( current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) ) ) {
		return;
	}

	// Only for users with sufficient capabilities.
	if ( ! current_user_can( WPROCKETHELPERS_CACHE_PURGE_TOOLBAR_LINK_CAPACITY ) ) {
		return;
	}

	add_action( 'admin_bar_menu', __NAMESPACE__ . '\render',
		200 // editing this priority will move the button within the toolbar
	);
}
add_action( 'wp_rocket_loaded', __NAMESPACE__ . '\maybe_add' );
