<?php

defined( 'ABSPATH' ) || exit;

$plugin_name = 'WP Rocket Debug Helper';

$plugin_launcher_path = dirname(__DIR__) . '/';

return [
    'plugin_name' => $plugin_name,
    'plugin_slug' => sanitize_key( $plugin_name ),
    'plugin_version' => '1.0.0',
    'plugin_launcher_file' => $plugin_launcher_path . '/' . basename($plugin_launcher_path) . '.php',
    'plugin_launcher_path' => $plugin_launcher_path,
    'plugin_inc_path' => realpath( $plugin_launcher_path . 'inc/' ) . '/',
    'prefix' => 'wp_rocket_debug_helper_',
    'translation_key' => 'wprocketdebughelper',
    'is_mu_plugin' => false,
    'template_path' => $plugin_launcher_path . 'templates/',
    'root_directory' =>  WP_CONTENT_DIR . '/cache/',
    'renderer_cache_enabled' => false,
    'renderer_caching_solution' => [],
];
