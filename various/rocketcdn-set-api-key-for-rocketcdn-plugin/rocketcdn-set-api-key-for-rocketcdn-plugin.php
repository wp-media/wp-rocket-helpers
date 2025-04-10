<?php
/**
 * Plugin Name: RocketCDN | Set API key for RocketCDN plugin
 * Description: Set API key to website owner
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2020
 */

namespace WP_Rocket\Helpers\rocnetcdn\token;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();



function define_api_key() {
    $api_key = 'add_api_key_here';
    $api_key_exists = get_option( 'rocketcdn_api_key' );

    // Add complete CDN URL (https://abcxy.delivery.rocketcdn.me), without forward slash at the end (/).
    $cdn_url = 'add_cdn_url_here';
    $cdn_url_exists = get_option( 'rocketcdn_cdn_url' );

    // Stop the script if the token's length is not 40.
    if ( strlen( $api_key ) != 40 ) {
        return 'The length of the API key is incorrect';
    }

    // Check if the token already exists in the database.
    if ( $api_key_exists ) {
        return 'There is already this RocketCDN API key in the DB: ' . $api_key_exists;
    }

    // Update the API key in the database.
    $api_key_update_result = update_option( 'rocketcdn_api_key', $api_key );


    // Now, handle the CDN URL.
    if ( strlen( $cdn_url ) != 38 ) {
        return 'The length of the CDN URL is incorrect';
    }

    if ( $cdn_url_exists ) {
        return 'There is already this RocketCDN CDN URL in the DB: ' . $cdn_url_exists;
    }

    // Update the CDN URL in the database.
    $cdn_url_update_result = update_option( 'rocketcdn_cdn_url', $cdn_url );

}

register_activation_hook( __FILE__, __NAMESPACE__ . '\define_api_key' );
