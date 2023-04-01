<?php
/**
 * Plugin Name: WP Rocket | Disable automatic RUCSS IP safelist on Wordfence
 * Description: Exclude sitemap from Preload.
 * Plugin URI:  
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */
namespace WP_Rocket\Helpers\disable\automatic_rucss_ip_safelist_wordfence;

add_filter('rocket_wordfence_whitelisted_ips', function ($ips) {
    $ips = array_filter($ips, function($value) {
        return $value !== '141.94.254.72'; 
    });
    return $ips;
});