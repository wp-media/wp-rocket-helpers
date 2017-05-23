<?php
defined( 'ABSPATH' ) or die( 'No direct access to this file.' );
/**
 * Plugin Name: WP Rocket | TMP Directory
 * Description: Sets a custom tmp directory for WP Rocket.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-tmp-dir/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Defines a custom tmp directory on your server.
 * @return string        Absolute path to custom tmp dir
 */
function wp_rocket__tmp_dir() {

	/**
	 * EDIT THIS TO REFLECT YOUR CUSTOM TMP PATH.
	 */
	return '/path/to/tmp_dir/';
	/**
	 * Stop editing.
	 */
}

// Do not process example code.
if ( '/path/to/tmp_dir/' !== wp_rocket__tmp_dir() ) {

	add_filter( 'rocket_override_min_cachepath', '__return_true' );
	add_filter( 'rocket_min_cachePath', 'wp_rocket__tmp_dir' );
}
