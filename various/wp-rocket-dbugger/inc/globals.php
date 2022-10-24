<?php

if (! function_exists('rocket_clean_domain')) {
    echo 'WP Rocket not detected';
    die;
}


$wpr_dbugger_version = '1.0.2';
$actual_version = WP_ROCKET_VERSION;
$plugin_dir = site_url() . '/wp-content/plugins/wp-rocket-dbugger';
$logs_file_dir = WP_CONTENT_DIR . '/wpr-logs/';
$logs_file_url = site_url() . '/wp-content/wpr-logs/';
$wpr_config_folder_url= content_url().'/wp-rocket-config/';
$rows_per_page = 100;
$rocket_options = get_option('wp_rocket_settings');
