<?php
/**
 * Plugin Name: WP Rocket | Clear Preload Errors
 * Description: Deletes the transient that stores preload errors on activation. 
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/preload/wp-rocket-preload-clear-errors
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */

namespace WP_Rocket\Helpers\preload\preload_clear_errors;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Clears old preload errors
 *
 * @author Arun Basil Lal
 */
function activation_todo() {
	delete_transient( 'rocket_preload_errors' );
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\activation_todo' );