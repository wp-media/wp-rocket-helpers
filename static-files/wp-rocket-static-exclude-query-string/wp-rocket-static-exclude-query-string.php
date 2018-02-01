<?php
/**
 * Plugin Name: WP Rocket | Exclude Files from Cache Busting
 * Description: Excludes CSS/JS files from being served as static files by WP Rocket.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/static/wp-rocket-static-exclude-query-string/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\static_files\exclude\remove_query_string;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude files from WP Rocket’s cache busting.
 *
 * @author Caspar Hübinger
 * @param  array  $excluded_files   Array of file URLs to be excluded
 * @return array                    Extended array of file URLs to be excluded
 */
function exclude_files( array $excluded_files ) {

	// EDIT THIS:

	$excluded_files[] = '/wp-content/themes/example-theme/example.css';

	// STOP EDITING

	return $excluded_files;
}
add_filter( 'rocket_exclude_cache_busting', __NAMESPACE__ . '\exclude_files' );
