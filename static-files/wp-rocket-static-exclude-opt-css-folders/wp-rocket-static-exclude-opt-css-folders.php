<?php
/**
 * Plugin Name: WP Rocket | Exclude Folders from Async CSS
 * Description: Excludes all CSS files in the specified folders and subfolders from CPCSS.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/static-files/wp-rocket-static-exclude-opt-css-folders
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Copyright SAS WP MEDIA 2021
 */
namespace WP_Rocket\Helpers\static_files\exclude\exclude_folders_css;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use RegexIterator;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();
/**
 * Exclude CSS in specific folders and subfolders from the Optimize CSS Delivery feature
 *
 * @author Sandy Figueroa
 *
 * */

function get_excluded_files($excluded_files = array() ): array {
	$wp_root = strval(substr(ABSPATH, 0, -1));
	$excluded_folders = array();

	/** Edit excluded folders **/

	$excluded_folders[] = '/wp-content/themes/example-theme/assets/css';
	
	// You can add more folders you want to exclude
	// $excluded_folders[] = '';

	/** Stop editing **/
	

	foreach($excluded_folders as $folder) {
		if (file_exists($wp_root.$folder)) {
			$allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($wp_root.$folder));
			$cssFiles = new RegexIterator($allFiles, '/\.css$/i');
	
			foreach($cssFiles as $cssFile){
				$css = str_replace ( $wp_root , '' , $cssFile->getPathname() );
				array_push ( $excluded_files , $css);
	
			}
		}
	}
	
	/** Edit excluded files **/
	
	// Add additional individual css files to the exclusions
	// $excluded_files[] = '/wp-content/themes/example-theme/assets/css/style.css';
	
	/** Stop editing **/
	
	return $excluded_files;

}
add_filter( 'rocket_exclude_async_css', __NAMESPACE__ . '\get_excluded_files' );