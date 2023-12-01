<?php
/**
 * Plugin Name: WP Rocket | Logging cron periodicity
 * Description: Log the cron periodicity
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\logs;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


function generateCallTrace()
{
    $e = new \Exception();
    $trace = explode("\n", $e->getTraceAsString());
    // reverse array to make steps line up chronologically
    $trace = array_reverse($trace);
    array_shift($trace); // remove {main}
        array_pop($trace); // remove call to this method
        $length = count($trace);
    $result = array();

    for ($i = 0; $i < $length; $i++) {
        $result[] = ($i + 1)  . ')' . substr($trace[$i], strpos($trace[$i], ' '));
    }

    return "" . implode("\n", $result);
}

//Loggin the cron periodicity
add_action('init', function () {
    if (! defined('DOING_CRON') || ! DOING_CRON) {
        return;
    }
    error_log( "\n [" . date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . "] Cron: " . print_r(($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Triggered by the server', true), 3, "wpr-cron-periodicity.txt" );
});