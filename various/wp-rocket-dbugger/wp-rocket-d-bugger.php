<?php
/**
 * Plugin Name: WP Rocket - D-bugger
 * Plugin URI:  https://wp-media.me/
 * Description: A set of debugging tools for WP Rocket.
 * Author:      WP Rocket Support Team
 * Author URI:  https://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
**/

namespace WP_Rocket\Helpers\various\debugging;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


add_action( 'admin_menu',  __NAMESPACE__ .'\rockettoolset_add_admin_menu' );
function rockettoolset_add_admin_menu() {
    add_management_page( 'WPR D-bugger', 'WPR D-bugger', 'install_plugins', 'wprockettoolset', __NAMESPACE__.'\wprockettoolset_admin_page' );
}



//RUCSS
function wprockettoolset_admin_page() {

  include('inc/globals.php'); 
  include('inc/functions.php'); 

  $mode = empty( $_GET['mode'] ) ? '' : $_GET['mode'];
   
  echo '<div class="wrap"><div id="wpbody" role="main"><div id="wpbody-content">';
  echo '<h1 class="wp-heading-inline">WPR D-bugger <span class="dbugger-version">'.$wpr_dbugger_version.'</span></h1>';
    
  include('inc/menu.php'); 

    
  if($mode == 'rucss' || $mode == '') { include('tests/rucss.php'); }
  if($mode == 'preload') { include('tests/preload.php'); }
  if($mode == 'logs') { include('tests/logs.php'); }
  if($mode == 'configs') { include('tests/configs.php'); }
  if($mode == 'phpinfo') { include('tests/phpinfo.php'); }
  if($mode == 'readme') { include('inc/testslist.php'); }

  echo '</div></div></div>';

 }
 
 
 
 // enqueue styles on needed pages
if ( !empty( $_GET['page'] ) && $_GET['page'] == 'wprockettoolset' ) {

   add_action( 'admin_enqueue_scripts',  __NAMESPACE__ .'\enqueue_admin_assets' );
 }
 
 function enqueue_admin_assets(){
   wp_enqueue_script( 'prism-js', plugins_url('assets/prism.js', __FILE__ ) , '1.0.0', false );
   wp_enqueue_style( 'prism-css', plugins_url('assets/prism.css', __FILE__ ) , '1.0.0', false);
   wp_enqueue_style( 'plugin-css', plugins_url('assets/style.css', __FILE__ ) , '1.0.0', false);
 }
 
 
 add_action('admin_init',  __NAMESPACE__ .'\wpr_rocket_debug_log_register_settings');
 function wpr_rocket_debug_log_register_settings(){
     register_setting('wpr_rocket_debug_log_settings', 'wpr_rocket_debug_log_settings', 'wpr_rocket_debug_log_settings_validate');   
 }
 
 
 // validate the options
 function wpr_rocket_debug_log_settings_validate($args){
     //$args will contain the values posted in your settings form,
     return $args;
 }
 
 //LOGS
 
 // first, lets see what is enabled
 $options = get_option( 'wpr_rocket_debug_log_settings' ); 

 //RUCSS

// RUCSS 
 if (isset($options['wpr_rocket_debug_log_status']) && $options['wpr_rocket_debug_log_status']['rucss'] != '' ) {   
     define('WP_ROCKET_DEBUG', true); 
   }
   

// CRON   
if (isset($options['wpr_rocket_debug_log_status']) && $options['wpr_rocket_debug_log_status']['cron'] != '' ) {
  
      add_action( 'init', function (){
        if ( ! defined('DOING_CRON') || ! DOING_CRON ) {
            return;
        }
      error_log( "\n" . date('[Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . "] Cron: " . print_r(($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Triggered by the server', true),  3, ABSPATH . "/wp-content/wpr-logs/01-cron.txt" );
    
        } );
    
    }
 

 
 
