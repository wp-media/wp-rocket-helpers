<?php
/**
 * Plugin Name: WP Rocket | Use Only Native Lazyload
 * Description: Makes all images use native lazyload. 
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */


// Namespaces must be declared before any other declaration.
namespace WP_Rocket\Helpers\lazyload\use_only_native_lazyload;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Enable WP Rocket's lazyload feature
 *
 * @link filter: https://github.com/wp-media/wp-rocket/blob/4dd69dd73da9096d2f945f8e49b5a7b9d2dec5a7/inc/Engine/Media/Lazyload/Subscriber.php#L532
 * 
 */
 
add_filter( 'rocket_use_native_lazyload_images', '__return_true' );


// Regenerate all cache on activation
function activate_or_deactivate_helper() {
  // Clear domain cache
  if ( function_exists( 'rocket_clean_domain' ) ) {
    rocket_clean_domain();
  }
}
register_activation_hook(__FILE__, __NAMESPACE__ .'\activate_or_deactivate_helper');
register_deactivation_hook( __FILE__ , __NAMESPACE__ . '\activate_or_deactivate_helper' );