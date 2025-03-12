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

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();
 

add_filter( 'rocket_enable_rucss_fonts_preload', '__return_false' );


// Regenerate all cache on activation
function activate_or_deactivate_helper() {
  // Clear domain cache
  if ( function_exists( 'rocket_clean_domain' ) ) {
    rocket_clean_domain();
  }
}
register_activation_hook(__FILE__, __NAMESPACE__ .'\activate_or_deactivate_helper');
register_deactivation_hook( __FILE__ , __NAMESPACE__ . '\activate_or_deactivate_helper' );