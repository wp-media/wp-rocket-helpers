<?php
defined( 'ABSPATH' ) or die( 'No direct access here.' );
/**
 * Plugin Name: WP Rocket | Exclude Dynamic Files
 * Description: Exclude specific dynamic files from being served as static files.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/wp-rocket-exclude-dynamic-files/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Exclude scripts from WP Rocket’s cache busting.
 *
 * @param  array  $excluded_files   Array of script URLs to be excluded
 * @return array             Extended array script URLs to be excluded
 */
function wprocket_exclude_dynamic_files( $excluded_files = array() ) {

	/**
	 * This is a sample file URL, define your own!
	 */
	$excluded_files[] = '/wp-content/themes/example-theme/example-css.php';

	return $excluded_files;
}
add_filter( 'rocket_exclude_static_dynamic_resources', 'wprocket_exclude_dynamic_files' );
