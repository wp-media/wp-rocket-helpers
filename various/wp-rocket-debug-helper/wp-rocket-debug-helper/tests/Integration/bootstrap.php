<?php
namespace WPRocketDebugHelper\Tests\Integration;

define( 'WP_ROCKET_DEBUG_HELPER_PLUGIN_ROOT', dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR );
define( 'WP_ROCKET_DEBUG_HELPER_TESTS_FIXTURES_DIR', dirname( __DIR__ ) . '/Fixtures' );
define( 'WP_ROCKET_DEBUG_HELPER_TESTS_DIR', __DIR__ );
define( 'WP_ROCKET_DEBUG_HELPER_IS_TESTING', true );

// Manually load the plugin being tested.
tests_add_filter(
    'muplugins_loaded',
    function() {
        // Load the plugin.
        require WP_ROCKET_DEBUG_HELPER_PLUGIN_ROOT . '/wp-rocket-debug-helper.php';
    }
);
