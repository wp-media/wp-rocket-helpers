<?php
/**
 * Plugin Name: WP Rocket | Exclude Files from Async CSS
 * Description: Exclude files from Optimize CSS Delivery option.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/static/wp-rocket-static-exclude-opt-css/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\static_files\exclude\optimized_css;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude scripts from WP Rocket’s asnyc CSS option.
 *
 * @author Caspar Hübinger
 * @param  array  $excluded_files   Array of script URLs to be excluded
 * @return array                    Extended array script URLs to be excluded
 */
function exclude_files( $excluded_files = array() ) {

	/**
	 * EDIT THIS:
	 * Replace, or multiply and edit below line as needed to exclude files.
	 */
	$excluded_files[] = '/wp-content/themes/example-theme/style.css';
	// STOP EDITING

	return $excluded_files;
}
add_filter( 'rocket_exclude_async_css', __NAMESPACE__ . '\exclude_files' );
