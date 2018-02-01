<?php
/**
 * Plugin Name: WP Rocket | Settings Access
 * Description: Allows access to WP Rocket’s settings for other user roles than Administrators.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/various/wp-rocket-settings-access/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\settings;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Set minimum user capability for WP Rocket.
 * @param  string $capability WordPress user capability
 * @return string             WordPress user capability
 */
function set_user_capacity( $user_capability ) {

	/**
	 * Allow Editors to manage WP Rocket settings.
	 */
	if ( current_user_can( 'editor' ) ) {
		$user_capability = 'editor';
	}

	/**
	 * Alternate example: restrict settings access to Multisite super admins.
	 */
	// if ( ! current_user_can( 'manage_network' ) ) {
	// 	$user_capability = 'manage_network';
	// }

	return $user_capability;
}
add_filter( 'rocket_capacity', __NAMESPACE__ . '\set_user_capacity' );
