<?php
/**
 * Plugin Name: WP Rocket | Customize Mobile Cache options
 * Description: Customize WP Rocket's mobile cache by changing the default settings.
 * Plugin URI:  https://docs.wp-rocket.me/article/708-mobile-cache
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2022
 */

namespace WP_Rocket\Helpers\customize_mobile_cache;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


// Upon activation change mobile cache options 
register_activation_hook(__FILE__, __NAMESPACE__ .'\prepare_things_upon_activation');

function prepare_things_upon_activation() {
    
    
    // 1 - Get WP Rocket options
    $options = get_option('wp_rocket_settings', []);

    // 2 - Disable "Separate Cache Files for Mobile Devices"
    $options['do_caching_mobile_files'] = 0;
    update_option('wp_rocket_settings', $options);
    
    // 3 - Disable Cache for Mobile Devices altogheter, 
    // EDIT: change this value to 0 if you also want to disable the cache for mobile devices
    $options['cache_mobile'] = 1;
    update_option('wp_rocket_settings', $options);


	// 4 - Regenerate Config files
	if( function_exists('rocket_generate_config_file')) {
		rocket_generate_config_file();
	}


}

// Upon dectivation change back the mobile cache options to its defaults 
register_deactivation_hook( __FILE__ , __NAMESPACE__ . '\deactivate_plugin' );

function deactivate_plugin() {
    
   
 	// 1 - Get WP Rocket options
    $options = get_option('wp_rocket_settings', []);


    // 2 - Enable "Separate Cache Files for Mobile Devices"
    $options['do_caching_mobile_files'] = 1;
    update_option('wp_rocket_settings', $options);
    
    
    // 3 - Enable Cache for Mobile Devices altogheter
    $options['cache_mobile'] = 1;
    update_option('wp_rocket_settings', $options);


	// 4 - Regenerate Config files
	if( function_exists('rocket_generate_config_file')) {
		rocket_generate_config_file();
	}
    

}

