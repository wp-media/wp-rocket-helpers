<?php
/**
 * Plugin Name: WP Rocket | No .htaccess
 * Description: Completely disable the use of .htaccess
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/htaccess/wp-rocket-no-htaccess
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */

namespace WP_Rocket\Helpers\no_htaccess;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

// Completely disable the use of .htaccess
add_filter( 'rocket_disable_htaccess', '__return_true' );

/**
 * Clear .htaccess of all WP Rocket rules on activation.
 *
 * @author Arun Basil Lal
 */
function flush_htaccess() {
	if ( function_exists( 'flush_rocket_htaccess' ) ) {
		flush_rocket_htaccess( true );
	}
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_htaccess' );

/**
 * Regenerate the .htaccess file and add rules back on deactivation.
 *
 * @author Arun Basil Lal
 */
function deactivate() {
	
	remove_filter( 'rocket_disable_htaccess', '__return_true' );

	if ( function_exists( 'flush_rocket_htaccess' ) ) {
		flush_rocket_htaccess();
	}
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );