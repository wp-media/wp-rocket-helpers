<?php 
/**
 * Plugin Name: WP Rocket | Remove Plugin Conflict Warning
 * Plugin URI: https://github.com/wp-media/wp-rocket-helpers/tree/master/various/wp-rocket-remove-plugin-conflict-warning
 * Description: Remove the admin notice that warns about plugins that might conflict with WP Rocket. 
 * Version: 1.0
 * Author: WP Rocket Support Team
 * Author URI: https://wp-rocket.me
 * License:	GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright 2018 WP Media <support@wp-rocket.me>
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit; 

add_filter( 'rocket_plugins_to_deactivate', '__return_empty_array' );