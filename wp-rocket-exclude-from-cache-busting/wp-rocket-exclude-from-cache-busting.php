<?php
defined( 'ABSPATH' ) or die( 'No direct access here.' );
/**
 * Plugin Name: WP Rocket | Exclude Files from Cache Busting
 * Description: Exclude specific files from Static Resources option.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/wp_rocket_exclude_from_cache_busting/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Exclude scripts from WP Rocket’s cache busting.
 *
 * @param  array  $excluded_files   Array of script URLs to be excluded
 * @return array             Extended array script URLs to be excluded
 */
function wp_rocket_exclude_from_cache_busting( $excluded_files = array() ) {

	/**
	 * This is a sample file URL, define your own!
	 * Duplicate below line as needed to exclude multiple files
	 */
	$excluded_files[] = '/wp-content/themes/example-theme/example-css.php';

	return $excluded_files;
}
add_filter( 'rocket_exclude_cache_busting', 'wp_rocket_exclude_from_cache_busting' );
