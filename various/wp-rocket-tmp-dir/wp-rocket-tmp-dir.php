<?php
/**
 * Plugin Name: WP Rocket | TMP Directory
 * Description: Sets a custom tmp directory for WP Rocket.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/various/wp-rocket-tmp-dir/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\file_system;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


// EDIT THIS TO REFLECT THE ABSOLUTE PATH TO YOUR CUSTOM TMP DIRECTORY:

define( 'WPROCKETHELPERS_CUSTOM_TMP_DIR', '/path/to/tmp_dir/' );

// STOP EDITING.


/**
 * Returns the custom path from above.
 *
 * @author Caspar Hübinger
 * @return string
 */
function render_custom_tmp_dir_path() {

	return WPROCKETHELPERS_CUSTOM_TMP_DIR;
}

// Do not process example code.
if ( '/path/to/tmp_dir/' !== WPROCKETHELPERS_CUSTOM_TMP_DIR ) {
	add_filter( 'rocket_override_min_cachepath', '__return_true' );
	add_filter( 'rocket_min_cachePath', __NAMESPACE__ . '\render_custom_tmp_dir_path' );
}
