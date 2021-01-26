<?php
/**
 * Plugin Name: WP Rocket | Disable WP Rocket's Emoji optimization
 * Description: This helper plugin will disable WP Rocket's emoji optimization. This means your website will use the Emoji file from WordPress.org instead of the default Emoji from vistor's browser. 
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2021
 */
 
namespace WP_Rocket\Helpers\various\emoji;
 
// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();
 

// Deactivate WP Rocket's Emoji Optimization
add_filter( 'pre_get_rocket_option_emoji', function($value){
    return 0;
} );