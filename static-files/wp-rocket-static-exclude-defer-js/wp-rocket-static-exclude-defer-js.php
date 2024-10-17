<?php
/**
 * Plugin Name: WP Rocket | Exclude Scripts from Defer JS
 * Description: Exclude scripts from the defer JS option.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/static/wp-rocket-static-exclude-defer-js/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\static_files\exclude\defer_js;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

if ( ! defined( 'WPRHELPERS_LJD_EXCLUDE_CONFIGS' ) ) {
  define( 'WPRHELPERS_LJD_EXCLUDE_CONFIGS',
    [
			// EDIT HERE

			/**
			 * Uncomment (remove //) and edit below line as needed to exclude files.
			 * To exclude mupltiple files, copy entire line into a new line for each file you wish you exclude.
			 */
			'external_file_exclusions' => [
				// '/wp-includes/js/jquery/jquery.masonry.min.js',
			],

			/**
			 * Uncomment (remove //) and edit below line as needed to exclude inline JS.
			 * To exclude mupltiple inline JS scripts, copy entire line into a new line for each inline script.
			 * Specify a unique string from an inline script to exclude it.
			 */
			'inline_exclusions' => [
				// 'example-inline-exclusion',
			],

			/**
			 * When set to true (default), exclusions will be applied for all pages.
			 * Set to false if you would prefer to apply exclusions only to pages specified below.
			 */
			'exclude_from_all_pages' => true,

			/**
			 * Change to true if need to apply exclusions to the home page.
			 */
			'exclude_from_home' => false,

			/**
			 * Uncomment (remove //) and edit below line if need to specify only specific pages to apply exclusions.
			 * To specify multiple pages, copy entire line into a new line and specify slug for each page.
			 */
			'specific_pages_to_exclude' => [
				// 'example-slug',
			],

			// STOP EDITING
		],
	);
}



/**
 * Either apply exclusions to all pages if no specific page(s) specified
 * or apply exclusions only to specified pages.
 */
function is_page_to_apply_exclusions( $excluded_slugs = array() ) {

	if ( 
		WPRHELPERS_LJD_EXCLUDE_CONFIGS['exclude_from_all_pages']
		|| ( WPRHELPERS_LJD_EXCLUDE_CONFIGS['exclude_from_home'] && function_exists( 'is_front_page' ) && is_front_page() )
		|| ( !empty( $excluded_slugs ) && function_exists( 'is_page' ) && is_page( $excluded_slugs ) )
		|| ( !empty( $excluded_slugs ) && function_exists( 'is_single' ) && is_single( $excluded_slugs ) )
	) {
		return true;
	}
	return false;
}



/**
 * Apply exclusions to specified JS files.
 */
function exclude_files_from_defer_js( $excluded_files = array() ) {

	if ( ! is_page_to_apply_exclusions( WPRHELPERS_LJD_EXCLUDE_CONFIGS['specific_pages_to_exclude'] ) ) {
		return $excluded_files;
	}

	return array_merge( $excluded_files, WPRHELPERS_LJD_EXCLUDE_CONFIGS['external_file_exclusions'] );
}

if ( ! empty( WPRHELPERS_LJD_EXCLUDE_CONFIGS['external_file_exclusions'] ) ) {
	add_filter( 'rocket_exclude_defer_js', __NAMESPACE__ . '\exclude_files_from_defer_js' );
}



/**
 * Apply exclusions to specified inline JS scripts.
 */
function exclude_inline_from_defer_js( $inline_exclusions = array() ) {

	if ( ! is_page_to_apply_exclusions( WPRHELPERS_LJD_EXCLUDE_CONFIGS['specific_pages_to_exclude'] ) ) {
		return $inline_exclusions;
	}

	return array_merge( $inline_exclusions, WPRHELPERS_LJD_EXCLUDE_CONFIGS['inline_exclusions'] );
}

if ( empty( WPRHELPERS_LJD_EXCLUDE_CONFIGS['inline_exclusions'] ) ) {
	add_filter( 'rocket_defer_inline_exclusions', __NAMESPACE__ . '\exclude_inline_from_defer_js' );
}