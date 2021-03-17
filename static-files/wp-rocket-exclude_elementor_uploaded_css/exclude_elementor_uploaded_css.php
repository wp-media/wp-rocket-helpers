<?php
/**
 * Plugin Name: WP Rocket | Exclude Uploaded Elementor CSS from CPCSS
 * Description: Excludes all CSS files in the uploads/elementor/css by elementor from CPCSS.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/static-files/exclude_elementor_uploaded_css
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2021
 */
namespace WP_Rocket\Helpers\static_files\exclude\exclude_elementor_uploaded_css;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


function get_elementor_uploaded_css($css_files = array()){
    $uploads_dir = wp_upload_dir( null, false);
    $css_uploads  =  scandir($uploads_dir["basedir"]."/elementor/css");
    
    foreach($css_uploads as $css){
        $file = pathinfo(scandir($uploads_dir["basedir"]."/elementor/css").$css);
        if ($file["extension"] == "css" && $file["filename"] != "Arrayglobal"){
            $css = "/wp-content/uploads/elementor/css/".$css;
            array_push ( $css_files , $css );
        }
    }
    return $css_files;
}

add_filter( 'rocket_exclude_async_css', __NAMESPACE__ . '\get_elementor_uploaded_css' );