<?php      
/**      
 * Plugin Name: WP Rocket | Disable URL Validation
 * Description: Disables WP Rocket's URL validation to allow caching of invalid taxonomy pages      
 * Author:      WP Rocket Support Team    
 * Author URI:  http://wp-rocket.me/    
 * License:     GNU General Public License v2 or later    
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html    
 *    
 * Copyright SAS WP MEDIA 2018    
 */    
    
namespace WP_Rocket\Helpers\cache\url_validation\disable;   
    
// Standard plugin security, keep this line in place.    
defined( 'ABSPATH' ) or die();    
  
// Disable URL validation for all URL validation subscribers  
add_filter( 'rocket_disable_url_validation', '__return_true' );