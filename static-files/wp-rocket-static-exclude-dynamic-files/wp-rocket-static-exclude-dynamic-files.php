<?php
/**
 * Plugin Name: WP Rocket | Exclude from Static File Creation
 * Description: Excludes CSS/JS generated dynamically by a PHP script from being served as static files by WP Rocket.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/static/wp-rocket-static-exclude-dynamic-files/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\static_files\exclude\dynamic_files;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude PHP files from WP Rocket’s static file creation.
 *
 * @author Caspar Hübinger
 * @param  array  $excluded_files   Array of script URLs to be excluded
 * @return array                    Extended array script URLs to be excluded
 */
 function exclude_files( array $excluded_files ) {

 	// EDIT THIS:

 	$excluded_files[] = '/wp-content/themes/example-theme/example-css.php';

 	// STOP EDITING

 	return $excluded_files;
 }
// Create a static file for dynamically generated CSS/JS from PHP
add_filter( 'rocket_exclude_static_dynamic_resources', __NAMESPACE__ . '\exclude_files' );
