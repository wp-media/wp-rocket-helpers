<?php
/**
 * Plugin Name: WP Rocket | Exclude images from LazyLoad per page
 * Description: Disables lazy load for specific images on selected page.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2025
 */
namespace WP_Rocket\Helpers\lazyload\exclude_image_per_page;
// Standard plugin security, keep this line in place.

defined( 'ABSPATH' ) or die();

function exclude_images_from_lazyload_per_page( array $excluded_imgs ) {
	
        /**
         * Using this helper plugin lets you disable Lazyload for specific images on selected pages (by page slug), while still having it lazyloaded on other pages.
         * 
         * STEP #1: DEFINE PAGES YOU WANT TO TARGET
         * Uncomment line 29 and add the slug(s) of the page(s) where you want to disable lazyloading for specific image(s). 
         * The image will not be lazyloadload only on these pages.
         * You can duplicate the line to add multiple pages
         */

        $target_pages = array(
			//'sample-page',
			// 'sample-page-2',
			// 'sample-page-3',
		);
		
        // STOP EDITING

        if ( 
            
            ( function_exists( 'is_page' ) && is_page( $target_pages ) ) 
            || ( function_exists( 'is_single' ) && is_single( $target_pages ) )
           
           ) {

        /**
         * STEP #2: EXCLUDE IMAGE SRC(S)
         * Uncomment line 52 and add the filename (or partial path) of the image(s) you want to exclude from lazyload on the pages above.
         * This can be:
         *   - Just the filename: 'logo.png'
         *   - Relative path: 'wp-content/uploads/2024/12/logo.png'
         * You can duplicate the line to add multiple images.
         */
    
         //$excluded_imgs[] = 'my-image-here.png';

        }
    
    return $excluded_imgs;

}
add_filter( 'rocket_lazyload_excluded_src', __NAMESPACE__ . '\exclude_images_from_lazyload_per_page' );