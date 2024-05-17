<?php
/**
 * Plugin Name: WP Rocket | Debug Helper
 * Version: 1.0.0
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wprocketdebughelper
 * Domain Path: /languages
 */
use function WPRocketDebugHelper\Dependencies\LaunchpadCore\boot;

defined( 'ABSPATH' ) || exit;


require __DIR__ . '/vendor-prefixed/wp-launchpad/core/inc/boot.php';

boot(__FILE__);
