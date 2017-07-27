<?php
defined( 'ABSPATH' ) or die( 'No direct access to this file.' );
/**
 * Plugin Name: WP Rocket | Settings Access
 * Description: Allows access to WP Rocket’s settings for other user roles than Administrators.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-settings-access/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Set minimum user capability for WP Rocket.
 * @param  string $capability WordPress user capability
 * @return string             WordPress user capability
 */
function wp_rocket__settings_access( $capability ) {

	/**
	 * Allow Editors to manage WP Rocket settings.
	 */
	if ( current_user_can( 'editor' ) ) {
		$capability = 'editor';
	}

	/**
	 * Alternate example: restrict settings access to Multisite super admins.
	 */
	// if ( ! current_user_can( 'manage_network' ) ) {
	// 	$capability = 'manage_network';
	// }

	return $capability;
}
add_filter( 'rocket_capacity', 'wp_rocket__settings_access' );

/**
 * Only required before WP Rocket 2.8.9:
 */
// add_filter( 'rocket_capability', 'wp_rocket__settings_access' );
