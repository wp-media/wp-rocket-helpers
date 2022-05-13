<?php
/**
 * Plugin Name: WP Rocket | Exclude Inline Styles from Remove Unused CSS
 * Description: Exclude inline styles from being removed by WP Rocket’s Remove Unused CSS optimizations.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2022
 */

namespace WP_Rocket\Helpers\rucss\rucss_inline_style_exclusions;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude inline styles from being removed by WP Rocket’s Remove Unused CSS optimization.
 */
function inline_exclusions( $inline_exclusions = array() ) {

	/**
	 * EDIT THIS:
	 * Edit below line as needed to exclude files.
	 * To exclude multiple inline css declarations, copy the entire line into a new line for each style declaration you want you exclude.
	 */
	$inline_exclusions[] = '.yourSelector';
	
	// STOP EDITING

	return $inline_exclusions;
}
add_filter( 'rocket_rucss_inline_content_exclusions', __NAMESPACE__ . '\inline_exclusions' );