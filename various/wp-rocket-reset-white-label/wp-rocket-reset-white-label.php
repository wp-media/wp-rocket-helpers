<?php
/**
 * Plugin Name: WP Rocket | Reset White Label
 * Description: Resets White Label options to default values.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/various/wp-rocket-reset-white-label/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\white_label;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Resets WP Rocket’s white-label options.
 *
 * @author Remy Perona
 */
function reset_white_label_values() {

	if ( ! is_plugin_active( 'wp-rocket/wp-rocket.php' ) ) {
		return;
	}

	if ( function_exists( 'update_rocket_option' ) ) {
		update_rocket_option( 'wl_plugin_name', 'WP Rocket' );
		update_rocket_option( 'wl_plugin_slug', 'wprocket' );
		update_rocket_option( 'wl_plugin_URI', 'https://wp-rocket.me' );
		update_rocket_option( 'wl_description', array( 'The best WordPress performance plugin.' ) );
		update_rocket_option( 'wl_author', 'WP Media' );
		update_rocket_option( 'wl_author_URI', 'https://wp-media.me' );
	}
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\reset_white_label_values' );
