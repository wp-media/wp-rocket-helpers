<?php
/**
 * Plugin Name: WP Rocket - D-bugger
 * Plugin URI:  https://wp-media.me/
 * Description: A set of debugging tools for WP Rocket.
 * Version: 1.2.0
 * Author:      WP Rocket Support Team
 * Author URI:  https://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
**/

namespace WP_Rocket\Helpers\various\debugging;

// Exit if accessed directly.
defined('ABSPATH') || exit;

include('inc/functions.php');

add_action('admin_menu', __NAMESPACE__ .'\rockettoolset_add_admin_menu');
function rockettoolset_add_admin_menu()
{
    add_management_page('WPR D-bugger', 'WPR D-bugger', 'install_plugins', 'wprockettoolset', __NAMESPACE__.'\wprockettoolset_admin_page');
}




function wprockettoolset_admin_page()
{
    $mode = empty($_GET['mode']) ? '' : $_GET['mode'];

    include('inc/globals.php');


    echo '<div class="wrap"><div id="wpbody" role="main"><div id="wpbody-content">';
    echo '<h1 class="wp-heading-inline">WPR D-bugger <span class="dbugger-version">'.$wpr_dbugger_version.' - WPR '.$actual_version.' - '.ini_get('memory_limit').' - PHP'.phpversion().' - </span><a href="tools.php?page=wprockettoolset&mode=deactivate" class="button-secondary deactivate" onclick="return confirm(\'Are you sure?\')">Deactivate</a>

    </h1>';




    include('inc/menu.php');


    if ($mode == 'rucss' || $mode == '') {
        include('tests/rucss.php');
    }
    if ($mode == 'preload') {
        include('tests/preload.php');
    }
    if ($mode == 'logs') {
        include('tests/logs.php');
    }
    if ($mode == 'check_ips') {
        include('tests/check-ips.php');
    }

    if ($mode == 'configs') {
        include('tests/configs.php');
    }

    if ($mode == 'tests') {
        include('tests/tests.php');
    }
    if ($mode == 'database') {
        include('tests/database.php');
    }

    if ($mode == 'deactivate') {
        include('inc/deactivate.php');
    }

    if ($mode == 'filemanager') {
        include('tests/checks/filemanager.php');
    }

    echo '</div></div></div>';
}



 // enqueue styles on needed pages
if (!empty($_GET['page']) && $_GET['page'] == 'wprockettoolset') {
    add_action('admin_enqueue_scripts', __NAMESPACE__ .'\enqueue_admin_assets');
}

 function enqueue_admin_assets()
 {
     wp_enqueue_script('prism-js', plugins_url('assets/prism.js', __FILE__), '1.0.0', false);
     wp_enqueue_style('prism-css', plugins_url('assets/prism.css', __FILE__), '1.0.0', false);
     wp_enqueue_style('plugin-css', plugins_url('assets/style.css', __FILE__), '1.0.0', false);
 }


 add_action('admin_init', __NAMESPACE__ .'\wpr_rocket_debug_log_register_settings');
 function wpr_rocket_debug_log_register_settings()
 {
     register_setting('wpr_rocket_debug_log_settings', 'wpr_rocket_debug_log_settings', 'wpr_rocket_debug_log_settings_validate');
 }


 // validate the options
 function wpr_rocket_debug_log_settings_validate($args)
 {
     //$args will contain the values posted in your settings form,
     return $args;
 }
