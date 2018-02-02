<?php
/**
 * Plugin Name: WP Rocket | No CORS for Fonts
 * Description: Prevents WP Rocket from automatically adding CORS rules for web fonts to the .htaccess file.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/htaccess/wp-rocket-htaccess-fonts-no-cors/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Copyright SAS WP Media 2018
 */

namespace WP_Rocket\Helpers\htaccess\fonts_no_cors;

// Standard plugin security, don’t remove this line.
defined( 'ABSPATH' ) or die();

/**
 * Removes CORS for web fonts from .htaccess.
 */
add_filter( 'rocket_htaccess_web_fonts_access', '__return_false' );

/**
 * Updates .htaccess, regenerates WP Rocket config file.
 *
 * @author Caspar Hübinger
 */
function flush_wp_rocket() {

	if ( ! function_exists( 'flush_rocket_htaccess' )
	  || ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}

	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_wp_rocket' );

/**
 * Removes customizations, updates .htaccess, regenerates config file.
 *
 * @author Caspar Hübinger
 */
function deactivate() {

	// Remove all added functionality.
	remove_filter( 'rocket_htaccess_web_fonts_access', '__return_false' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );
