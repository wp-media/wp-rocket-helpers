<?php

/**
 * Plugin Name: WP Rocket | Logging cache clearing
 * Description: Log the Full and Partial cache clearing
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\logs;

// Standard plugin security, keep this line in place.
defined('ABSPATH') or die();

/**
 * Logging cache clearing
 *
 */

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

/***************************************************************************************/
//FULL CACHE CLEARING
/***************************************************************************************/
add_action('before_rocket_clean_domain', function () {
    error_log("\n\n*****************************************************************\n[" . date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . "]\n#CALLSTACK#####\n" . print_r(generateCallTrace(), true), 3, ABSPATH . "01-full-cache-clear.txt");
});


/***************************************************************************************/
//PARTIAL CACHE CLEARING
/***************************************************************************************/
function log_partialcacheclear($post, $purge_url, $lang)
{
    error_log("\n\n*****************************************************************\n[" . date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . "]\n#CALLSTACK#####\n" . print_r(generateCallTrace(), true), 3, ABSPATH . "02-partial-cache-clear.txt");
    error_log("\n\nPOST\n ID: " . print_r($post->ID, true), 3, ABSPATH . "02-partial-cache-clear.txt");
    error_log("\n URL: " . print_r(get_permalink($post->ID), true), 3, ABSPATH . "02-partial-cache-clear.txt");
    error_log("\n Post_type: " . print_r($post->post_type, true), 3, ABSPATH . "02-partial-cache-clear.txt");

    error_log("\n\n#PURGED_URLS#####\n" . print_r($purge_url, true), 3, ABSPATH . "02-partial-cache-clear.txt");
}
add_action('after_rocket_clean_post', __NAMESPACE__ . '\log_partialcacheclear', 1000, 3);

/***************************************************************************************/
//rocket_clean_files
/***************************************************************************************/

function log_rocket_clean_files($purge_url)
{
    error_log("\n\n*****************************************************************\n[" . date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . "]\n#CALLSTACK#####\n" . print_r(generateCallTrace(), true), 3, ABSPATH . "03-rocket_clean_files_log.txt");
    error_log("\n\n#PURGED_URLS#####\n" . print_r($purge_url, true), 3, ABSPATH . "03-rocket_clean_files_log.txt");
}

add_action('before_rocket_clean_files', __NAMESPACE__ . '\log_rocket_clean_files');
