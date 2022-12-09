<?php
/**
 * Plugin Name: WP Rocket | Disable automatic dynamic lists updates
 * Description: Disables WP Rocket’s updates of dynamic lists while preserving the possibility of manual update.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/various/wp-rocket-disable-auto-list-updates
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2022
 */

namespace WP_Rocket\Helpers\various\disable_auto_list_updates;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Remove the callback scheduling cron
 */
 
function prevent_dynamic_lists_update(){
	$container = apply_filters( 'rocket_container', '');
	$container->get('event_manager')->remove_callback( 'init', [ $container->get('dynamic_lists_subscriber'), 'schedule_lists_update'] );
}
add_action( 'wp_rocket_loaded', __NAMESPACE__ . '\prevent_dynamic_lists_update' );

/**
 * Remove the schedule on activation
 */
 
function remove_schedule_lists_update() {
	if ( wp_next_scheduled( 'rocket_update_dynamic_lists' ) ) {
		wp_clear_scheduled_hook( 'rocket_update_dynamic_lists' );
	}
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\remove_schedule_lists_update' );





