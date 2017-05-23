<?php
defined( 'ABSPATH' ) or die( 'No direct access here.' );
/**
 * Plugin Name: WP Rocket | Exclude Files from Defer JS
 * Description: Exclude specific files from defer JS option.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-exclude-from-defer-js/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Exclude scripts from WP Rocket’s defer JS option.
 *
 * @param  array  $excluded_files   Array of script URLs to be excluded
 * @return array                    Extended array script URLs to be excluded
 */
function wp_rocket__exclude_from_defer_js( $excluded_files = array() ) {

	/**
	 * This is a sample file URL, define your own!
	 * Duplicate below line as needed to exclude multiple files.
	 */
	$excluded_files[] = '/wp-includes/js/jquery/jquery.masonry.min.js';

	/**
	 * Stop editing here.
	 */
	return $excluded_files;
}
add_filter( 'rocket_exclude_defer_js', 'wp_rocket__exclude_from_defer_js' );
