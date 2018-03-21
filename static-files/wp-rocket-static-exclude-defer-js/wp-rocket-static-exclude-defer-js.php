<?php
/**
 * Plugin Name: WP Rocket | Exclude Files from Defer JS
 * Description: Exclude files from defer JS option.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/static/wp-rocket-static-exclude-defer-js/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\static_files\exclude\defer_js;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude scripts from WP Rocket’s defer JS option.
 *
 * @author Caspar Hübinger
 * @param  array  $excluded_files   Array of script URLs to be excluded
 * @return array                    Extended array script URLs to be excluded
 */
function exclude_files( $excluded_files = array() ) {

	/**
	 * EDIT THIS:
	 * Edit below line as needed to exclude files.
	 * To exclude mupltiple files, copy the entire line into a new line for each file you wish you exclude.
	 */
	$excluded_files[] = '/wp-includes/js/jquery/jquery.masonry.min.js';
	// STOP EDITING

	return $excluded_files;
}
add_filter( 'rocket_exclude_defer_js', __NAMESPACE__ . '\exclude_files' );
