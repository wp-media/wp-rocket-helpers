<?php
/**
 * Plugin Name: WP Rocket | Preload dynamic cookie values
 * Description: Allows the preload of custom cookie values when using Dynamic Cookies
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2022
 */
 
namespace WP_Rocket\Helpers\preload\custom_cookie_preload;
 
// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();
 
function rocket_get_combinations(...$arrays)
{
    $result = [[]];
    foreach ($arrays as $property => $property_values) {
        $tmp = [];
        foreach ($result as $result_item) {
            foreach ($property_values as $property_value) {
                $tmp[] = array_merge($result_item, [$property => $property_value]);
            }
        }
        $result = $tmp;
    }
    return $result;
}
 
function rocket_flatten_array($array) {
    $output = [];
    foreach ($array as $item => $values) {
        $row = [];
        foreach ($values as $value) {
            $row[] = [$item, $value];
        }
        $output[] = $row;
    }
    return $output;
}
 
function custom_cookie_preload( $requests ) {
    
    // edit the cookie names and values you want to preload here
    // you can uncomment the 2nd set if you want to preload the values of two different cookies
    $cookies = [
        'currency' => [
            'usd',
            'eur',
        ],
        /*
        'lang' => [
            'en',
            'es',
        ],*/
    ];
 
    $cookies = rocket_flatten_array($cookies);
 
    $cookies_combines = rocket_get_combinations(...$cookies);
 
    foreach ($cookies_combines as $cookies) {
        foreach($requests as $request) {
            $wp_cookies = [];
            foreach($cookies as $cookie => $values) {
                    $wp_cookie = new \WP_Http_Cookie($values[0] );
                    $wp_cookie->name = $values[0];
                    $wp_cookie->value = $values[1];
                    $wp_cookies[] = $wp_cookie;
            }
            $request['headers']['cookies'] = $wp_cookies;
            $output [] = $request;
        }
    }
 
    
    return $output;
 
}
 
add_filter( 'rocket_preload_before_preload_url', __NAMESPACE__ . '\custom_cookie_preload', PHP_INT_MAX );