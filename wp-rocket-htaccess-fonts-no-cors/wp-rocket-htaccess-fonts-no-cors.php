<?php
/**
 * Plugin Name: WP Rocket | No CORS for Fonts
 * Description: Prevents WP Rocket from automatically adding CORS rules for web fonts to the .htaccess file.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-htaccess-fonts-no-cors/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Copyright WP Media 2018
 */

// Standard plugin security, don’t remove this line.
defined( 'ABSPATH' ) or die();

/**
 * Removes CORS for web fonts from .htaccess.
 */
add_filter( 'rocket_htaccess_web_fonts_access', '__return_false' );

/**
 * Updates .htaccess, regenerates WP Rocket config file.
 */
function wp_rocket_htaccess_fonts_no_cors__flush() {

	if ( ! function_exists( 'flush_rocket_htaccess' )
	  || ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}

	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();
}
register_activation_hook( __FILE__, 'wp_rocket_htaccess_fonts_no_cors__flush' );

/**
 * Removes customizations, updates .htaccess, regenerates config file.
 */
function wp_rocket_htaccess_fonts_no_cors__deactivate() {

	// Remove all added functionality.
	remove_filter( 'rocket_htaccess_web_fonts_access', '__return_false' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	wp_rocket_htaccess_fonts_no_cors__flush();
}
register_deactivation_hook( __FILE__, 'wp_rocket_htaccess_fonts_no_cors__deactivate' );
