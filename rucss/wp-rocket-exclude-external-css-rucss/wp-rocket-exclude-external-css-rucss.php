<?php
/**
 * Plugin Name: WP Rocket | Exclude CSS files from Remove Unused CSS
 * Description: Exclude CSS files from being removed by WP Rocket’s Remove Unused CSS optimizations.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2022
 */

namespace WP_Rocket\Helpers\rucss\rucss_external_style_exclusions;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude CSS Files styles from being removed by WP Rocket’s Remove Unused CSS optimization.
 */
function external_exclusions( $external_exclusions = array() ) {

	/**
	 * EDIT THIS:
	 * Edit below line as needed to exclude specific CSS files.
     * Replace "/wp-content/plugins/plugin-name/css/file.css" with the path of the file you want to exclude.
	 * To exclude multiple files, copy the entire line into a new line for each style declaration you want you exclude.
	 */
     $external_exclusions[] = '/wp-content/plugins/plugin-name/css/file.css';
	 //$external_exclusions[] = '/wp-content/themes/css/another-file.css';

	// STOP EDITING

	return $external_exclusions;
}
add_filter( 'rocket_rucss_external_exclusions', __NAMESPACE__ . '\external_exclusions' );