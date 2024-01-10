<?php
/**
 * Plugin Name: WP Rocket | Filter WP_Query Args
 * Description: This helper plugin will prevent issues caused by filters inside our rocket_url_to_postid() function.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */
 
namespace WP_Rocket\Helpers\various\suppress_filters;
 
// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();
 

// Deactivate WP Rocket's Emoji Optimization
add_filter( 'rocket_url_to_postid_query_args', function( $args ) {
    $args['suppress_filters'] = true;
    return $args;
} );