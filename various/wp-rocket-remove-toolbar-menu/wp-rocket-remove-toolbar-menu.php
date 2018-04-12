<?php
/**
 * Plugin Name: WP Rocket | Remove Toolbar Menu
 * Description: Removes the WP Rocket menu from the WordPress toolbar (admin bar).
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/various/wp-rocket-remove-toolbar-menu/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\toolbar;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Removes WP Rocket toolbar menu.
 *
 * @author Caspar Hübinger
 */
function remove_menu() {
	remove_action( 'admin_bar_menu', 'rocket_admin_bar', PHP_INT_MAX );
}
add_action( 'wp_rocket_loaded', __NAMESPACE__ . '\remove_menu' );
