<?php
/**
 * Plugin Name: WP Rocket | Disable Used CSS Fonts Preload 
 * Author:      WP Rocket Support Team
 * Description: Disables the preloading of fonts found in the used CSS.
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2022
 */

namespace WP_Rocket\Helpers\rucss\disable_preload_fonts;

/*
 * Disable font preloading in used CSS.
 * Filter: https://github.com/wp-media/wp-rocket/blob/3a5b9b11dbda004854d54a4f07dc4ddc95bf2dbc/inc/Engine/Optimization/RUCSS/Controller/UsedCSS.php#L636
 */

add_action( 'init', function(){
	if( is_rucss_enabled() ){
		add_filter( 'rocket_enable_rucss_fonts_preload', '__return_false' );
	}
});

/*
 * Clear cache
 */
 function only_clear_cache(){

	if( ! is_rucss_enabled() ){
		return;
	}

	
	if( function_exists( 'rocket_clean_domain' ) ){
		rocket_clean_domain(); 
	}

}

/*
 * Checks if Remove Unused CSS is enabled.
 */
function is_rucss_enabled(){
	
	static $is_rucss_enabled;
	
	if ( isset( $is_rucss_enabled ) ) {
		return $is_rucss_enabled;
	}
	
	if( function_exists( 'get_rocket_option' ) ){
		$is_rucss_enabled = get_rocket_option( 'remove_unused_css', 0 );
	}
	
	return $is_rucss_enabled;
}



register_deactivation_hook( __FILE__ , __NAMESPACE__ . '\only_clear_cache' );