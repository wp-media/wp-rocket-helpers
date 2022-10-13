<?php 

// If uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// let's do the cleanup

// first, delete /wpr-logs from the uploads folder, and also the WP_ROCKET_LOG output
$wp_rocket_debug_uploads_dir = WP_CONTENT_DIR . '/wpr-logs/';
$wp_rocket_debug_log_file = WP_ROCKET_CONFIG_PATH . '/wp-rocket-debug.log.html';

$fileSystemDirect = new WP_Filesystem_Direct(false);
$fileSystemDirect->rmdir($wp_rocket_debug_uploads_dir, true);
$fileSystemDirect->delete($wp_rocket_debug_log_file, true);


// second, remove wpr_rocket_debug_log_settings option from database
delete_option('wpr_rocket_debug_log_settings');

