<?php
defined( 'ABSPATH' ) or die( 'Cheatin\' uh?' );
/*
Plugin Name: WP Rocket | Enforce Trailing Slash on URLs
Description: Enforces Trailing Slash on URLs
Author: WP Rocket Support Team
Author URI: https://wp-rocket.me
*/

add_filter( 'before_rocket_htaccess_rules', '__force_trailing_slash' );
function __force_trailing_slash( $marker ) {
    $redirection = '# Force trailing slash' . PHP_EOL;
    $redirection .= 'RewriteEngine On' . PHP_EOL;
    $redirection .= 'RewriteCond %{REQUEST_FILENAME} !-f' . PHP_EOL;
    $redirection .= 'RewriteCond %{REQUEST_METHOD} GET' . PHP_EOL;
    $redirection .= 'RewriteCond %{REQUEST_URI} !(.*)/$' . PHP_EOL;
    $redirection .= 'RewriteRule ^(.*)$ http' . ( is_ssl() ? 's' : '' ) . '://%{HTTP_HOST}/$1/ [L,R=301]' . PHP_EOL . PHP_EOL;
    $marker = $redirection . $marker;
    return $marker;
}
