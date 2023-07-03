<?php
/**
 * Plugin Name: WP Rocket | Clean product related translations (WPML)
 * Description: Clears the cache of product translations when updating the main language, to keep the translated posts in sync
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2022
 */

namespace WP_Rocket\Helpers\htaccess\wp_rocket_clean_product_related_translations;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

function rocket_clean_related_post_translations( $post ) {
 
    $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
  
     if ( !empty( $languages ) && $post->post_type == 'product' ) {
                     
         foreach( $languages as $l ) {
             
             $id = icl_object_id($post->ID, 'product', false, $l['language_code']);
             if($id != $post->ID) {
                 
                 //clean the translations cache
                 if ( function_exists( 'rocket_clean_post' ) ) {
                         rocket_clean_post(  $id  );						
                 }

             }
         }
     }
 }	
 
add_action( 'after_rocket_clean_post', __NAMESPACE__.'\rocket_clean_related_post_translations' );