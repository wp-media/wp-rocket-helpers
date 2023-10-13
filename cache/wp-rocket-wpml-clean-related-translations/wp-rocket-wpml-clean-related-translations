<?php
/**
 * Plugin Name: WP Rocket | Clean related translations (WPML)
 * Description: Clears the cache of related translations and their categories when updating a post, page, product or any other specified post type to keep the translations in sync.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\htaccess\wp_rocket_wpml_clean_related_translations;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

function rocket_clean_related_post_translations( $post ) {

  $types_to_clear = array(
    // EDIT HERE: Add or remove lines to specify what translated post types should be cleared
    'post',
    'page',
    'product',
    // STOP EDITING
  );

  $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );

  $post_type = $post->post_type;
  $id = $post->ID;

  if ( !empty( $languages ) && in_array( $post_type, $types_to_clear ) ) {

    foreach( $languages as $l ) {
        
      $icl_id = icl_object_id( $id, $post_type, false, $l['language_code'] );

      if( $icl_id != $id ) {
          
        //clean the translations cache
        if ( function_exists( 'rocket_clean_post' ) ) {
          rocket_clean_post( $icl_id );						
        }
      }
    }
  }
}
add_action( 'after_rocket_clean_post', __NAMESPACE__.'\rocket_clean_related_post_translations' );
