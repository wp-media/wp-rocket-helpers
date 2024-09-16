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
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\customize_mobile_cache;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


// Upon activation change mobile cache options 
register_activation_hook(__FILE__, __NAMESPACE__ .'\prepare_things_upon_activation');



function prepare_things_upon_activation() {
    
    $_POST['wpr_test'] = 1;
    
    $options = get_option('wp_rocket_settings', []);

    // Disable Separate Cache Files for Mobile Devices
    $options['do_caching_mobile_files'] = 0;

    // If you want to disable Mobile Cache alltogether, uncomment the next line    
    // $options['cache_mobile'] = 0;
    
    update_option('wp_rocket_settings', $options);


}

// Upon dectivation change back the mobile cache options to its defaults 
register_deactivation_hook( __FILE__ , __NAMESPACE__ . '\deactivate_plugin' );

function deactivate_plugin() {
    
    $_POST['wpr_test'] = 1;
    
    $options = get_option('wp_rocket_settings', []);
    $options['do_caching_mobile_files'] = 1;
    $options['cache_mobile'] = 1;
    
    update_option('wp_rocket_settings', $options);

}

// Unless both mobile cache options are enabled, disable rocket_above_the_fold_optimization
add_filter( 'rocket_above_the_fold_optimization', function( $enabled ) {
    $options = get_option('wp_rocket_settings', []);
    return $enabled && isset($options['do_caching_mobile_files'], $options['cache_mobile']) && $options['do_caching_mobile_files'] == 1 && $options['cache_mobile'] == 1;
} );

// Unless both mobile cache options are enabled, disable rocket_lrc_optimization
add_filter( 'rocket_lrc_optimization', function( $enabled ) {
    $options = get_option('wp_rocket_settings', []);
    return $enabled && isset($options['do_caching_mobile_files'], $options['cache_mobile']) && $options['do_caching_mobile_files'] == 1 && $options['cache_mobile'] == 1;
} );
