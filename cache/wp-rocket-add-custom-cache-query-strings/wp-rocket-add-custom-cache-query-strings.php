<?php  
/**  
 * Plugin Name: WP Rocket | Add Custom Cache Query Strings  
 * Description: Adds custom query strings to WP Rocket's cache list that would normally be ignored.   
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/  
 * Author:      WP Rocket Support Team  
 * Author URI:  http://wp-rocket.me/  
 * License:     GNU General Public License v2 or later  
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html  
 *  
 * Copyright SAS WP MEDIA 2024  
 */  
  
namespace WP_Rocket\Helpers\cache\query_strings\add_custom;  
  
// Standard plugin security, keep this line in place.  
defined( 'ABSPATH' ) or die();  
  
/**  
 * Add custom query strings to WP Rocket's cache list.  
 *  
 * @param  array  $query_strings   Array of query strings to be cached  
 * @return array                   Extended array of query strings to be cached  
 */  
function add_custom_query_strings( array $query_strings ) {  
  
	// EDIT THIS:  
  
	//$query_strings[] = 'custom_param';
	$query_strings[] = 'attribute_%e9%a1%8f%e8%89%b2';   
  
	// STOP EDITING  
  
	return $query_strings;  
}  
add_filter( 'rocket_cache_query_strings', __NAMESPACE__ . '\add_custom_query_strings' );  
  
/**  
 * Regenerate config file when plugin is activated.  
 */  
function regenerate_config_on_activation() {  
	if ( function_exists( 'rocket_generate_config_file' ) ) {  
		rocket_generate_config_file();  
	}  
}  
register_activation_hook( __FILE__, __NAMESPACE__ . '\regenerate_config_on_activation' );  
  
/**  
 * Regenerate config file when plugin is deactivated.  
 */  
function regenerate_config_on_deactivation() {  
	if ( function_exists( 'rocket_generate_config_file' ) ) {  
		rocket_generate_config_file();  
	}  
}  
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\regenerate_config_on_deactivation' );