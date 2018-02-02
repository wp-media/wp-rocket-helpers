<?php
/**
 * Plugin Name: WP Rocket | No Auto-generated Critical CSS
 * Description: Disable automatic generation of critical CSS when Optimize CSS Delivery is enabled.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/static-files/wp-rocket-no-auto-critical-css/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

add_filter( 'do_rocket_critical_css_generation', '__return_false' );
