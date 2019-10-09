<?php
/**
 * Plugin Name: WP Rocket | Enable Native Lazyload
 * Description: Enables the application of native lazyload 
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */


// Namespaces must be declared before any other declaration.
namespace WP_Rocket\Helpers\lazyload\enable_native_lazyload;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Enable WP Rocket's lazyload feature
 *
 * @link filter: https://github.com/wp-media/wp-rocket/blob/163a03f4495a5d2e78c9822b9a3ac00f76485bd5/inc/classes/subscriber/Optimization/class-lazyload-subscriber.php#L158
 * @author Vasilis Manthos
 */
 
add_filter( 'rocket_use_native_lazyload', '__return_true' );
