<?php  
/**  
 * Plugin Name: WP Rocket | Customize Preload Links Config  
 * Description: Exclude specific URL patterns, image or file extensions from WP Rocket's Preload Links feature.  
 * Author:      WP Rocket Support Team  
 * License:     GNU General Public License v2 or later  
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html  
 */  
  
namespace WP_Rocket\Helpers\preload_links\customize_config;  
  
// Standard plugin security, keep this line in place.  
defined( 'ABSPATH' ) or die();  
  
/**  
 * Customize preload links configuration.  
 *  
 * @param array $config Preload Links script configuration parameters.  
 * @return array Modified configuration parameters.  
 */  
function customize_preload_config( array $config ) {  
      
    // EDIT THIS:  
      
    // Add custom exclusions to excludeUris
	// Exclusion already set: /(?:.+/)?feed(?:/(?:.+/?)?)?$|/(?:.+/)?embed/|/checkout/??(.*)|/cart/?|/(index.php/)?(.*)wp-json(/.*|$)|/refer/|/go/|/recommend/|/recommends/
    $custom_exclusions = [  
        '/custom-path/',  
        // '/url-part',  
        // 'url-part/',
    ];  

	// Add custom image extensions to existing imageExt
	// Exclusion already set: jpg|jpeg|gif|png|tiff|bmp|webp|avif|pdf|doc|docx|xls|xlsx|php
    $custom_image_extensions = [  
        'svg',  
        'ico'  
    ];

    // Add custom file extensions to existing fileExt
	// Exclusion already set: html|htm
    $custom_file_extensions = [  
        'zip',  
        'rar',  
        'txt'  
    ]; 
      
    if ( isset( $config['excludeUris'] ) ) {  
        $config['excludeUris'] .= '|' . implode( '|', $custom_exclusions );  
    } else {  
        $config['excludeUris'] = implode( '|', $custom_exclusions );  
    }      
      
    if ( isset( $config['imageExt'] ) ) {  
        $config['imageExt'] .= '|' . implode( '|', $custom_image_extensions );  
    } else {  
        $config['imageExt'] = implode( '|', $custom_image_extensions );  
    }   
      
    if ( isset( $config['fileExt'] ) ) {  
        $config['fileExt'] .= '|' . implode( '|', $custom_file_extensions );  
    } else {  
        $config['fileExt'] = implode( '|', $custom_file_extensions );  
    } 
      
    // STOP EDITING  
      
    return $config;  
}  
  
// Hook into the preload links configuration filter  
add_filter( 'rocket_preload_links_config', __NAMESPACE__ . '\customize_preload_config' );