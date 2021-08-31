<?php 
/**
 * Plugin Name: WP Rocket | Exclude JS scripts from Delay JS only at some URLs
 * Plugin URI: https://github.com/wp-media/wp-rocket-helpers/tree/master/static-files/wp-rocket-static-exclude-delay-js-per-url/
 * Description: Exclude JavaScript files from Delay JS only on specific pages instead of excluding them globally.
 * Version: 1.0
 * Author: WP Rocket Support Team
 * Author URI: https://wp-rocket.me
 * License:	GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright 2021 WP Media <support@wp-rocket.me>
 */
 

 // Namespaces must be declared before any other declaration.
 namespace WP_Rocket\Helpers\static_files\exclude\selective_delay_js_exclusions;
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit; 
 
function exclude_from_delay( $exclusions ) {

        /**
        This helper will allow you exclude JavaScript files from Delay JS only on specific pages instead of excluding them globally.
        This plugin requires a 2 steps editing.
            
        STEP #1: ON THESE PAGES...
        Change the Slugs ("first-slug", etc, in this example) to the pages where you want to apply these exclusions.
        These are the URLs where the scripts from step 2 won't be delayed.
        For example: On the following pages (STEP #1), don't delay the following OWL Carousel scripts (STEP #2).
        **/
                
        $excluded_slugs = array( 
            'first-slug', 
            //'another-slug', 
           // 'another-one', 
        );       
        // STOP EDITING
       
        if ( 
            
            ( function_exists( 'is_page' ) && is_page( $excluded_slugs ) ) 
            || ( function_exists( 'is_single' ) && is_single( $excluded_slugs ) )
           
           /* 
           IF YOU NEEED TO EXCLUDE BASED ON DIFFERENT RULES 
            you can replace lines 41 and 42 with different conditionals, or add more conditions, for example:
            || ( is_front_page() )
            || ( is_category() )
            ... etc
            */ 
           
        ) {
            
        /**
        STEP #2: DON'T DELAY THESE SCRIPTS!
        Add the scripts that need to be loaded right away ONLY on the above URLs. 
        To add multiple scripts you can duplicate these lines as meany times as needed.
        **/
        
        $exclusions[] = 'example-script.js';
        //$exclusions[] = 'script2.js';
        //$exclusions[] = 'anotherInline';        
        // STOP EDITING
   
        }
    
    return $exclusions;

}

add_filter( 'rocket_delay_js_exclusions',  __NAMESPACE__ . '\exclude_from_delay' );
