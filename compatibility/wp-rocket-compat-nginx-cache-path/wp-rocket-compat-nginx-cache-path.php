<?php
/**
 * Plugin Name: WP Rocket | Define NGINX FastCGI cache path
 * Description: Changes default NGINX FastCGI /var/run/nginx-cache path to the desired one
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/compatibility/wp-rocket-compat-nginx-cache-path/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */
 
namespace WP_Rocket\Helpers\compat\nginx_cache_path;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Filters the default NGINX FastCGI cache path
 * It's necessary in order to purge whole NGINX cache
 *
 * @author Piotr Bąk
 */
function define_nginx_path($nginx_path){
	
	//CHANGE THIS PATH TO THE DESIRED ONE
	$nginx_path = '/var/run/nginx-cache';
	
	return $nginx_path;
}
add_filter( 'rocket_nginx_cache_path', __NAMESPACE__ . '\define_nginx_path' );