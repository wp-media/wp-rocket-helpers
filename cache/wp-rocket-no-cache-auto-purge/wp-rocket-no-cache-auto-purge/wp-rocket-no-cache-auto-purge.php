<?php
/**
 * Plugin Name: WP Rocket | Disable Cache Clearing
 * Description: Disables all of WP Rocket’s automatic cache clearing.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-no-cache-auto-purge/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2020
 */

namespace WP_Rocket\Helpers\cache\no_cache_auto_purge;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Remove all of WP Rocket's cache purging actions.
 *
 * @author Caspar Hübinger
 */
function remove_purge_hooks() {

	// WP core action hooks rocket_clean_domain() gets hooked into.
	$clean_domain_hooks = array(
		// When user changes the theme
		'switch_theme',
		// When a user is added
		'user_register',
		// When a user is updated
		'profile_update',
		// When a user is deleted
		'deleted_user',
		// When a custom menu is updated
		'wp_update_nav_menu',
		// When any theme modifications are updated
		'update_option_theme_mods_' . get_option( 'stylesheet' ),
		// When you change the order of widgets
		'update_option_sidebars_widgets',
		// When category permalink prefix is update
		'update_option_category_base',
		// When tag permalink prefix is update
		'update_option_tag_base',
		// When permalink structure is update
		'permalink_structure_changed',
		// When a term is created (before WP Rocket 3.5.5)
		'create_term',
		// When a term is updated (before WP Rocket 3.5.5)
		'edited_terms',
		// When a term is deleted (before WP Rocket 3.5.5)
		'delete_term',
		// When a link (post type) is added
		'add_link',
		// When a link (post type) is updated
		'edit_link',
		// When a link (post type) is deleted
		'delete_link',
		// When resulty are saved in the Customizer
		'customize_save',
		// When Avada theme purges its own cache
		'avada_clear_dynamic_css_cache',
	);

	// WP core action hooks rocket_clean_post() gets hooked into.
	$clean_post_hooks = array(
		// Disables the refreshing of partial cache when content is edited
		'wp_trash_post',
		'delete_post',
		'clean_post_cache',
		'wp_update_comment_count',
	);

	// Remove rocket_clean_domain() from core action hooks.
	foreach ( $clean_domain_hooks as $key => $handle ) {
		remove_action( $handle, 'rocket_clean_domain' );
	}

	// Remove rocket_clean_post() from core action hooks.
	foreach ( $clean_post_hooks as $key => $handle ) {
		remove_action( $handle, 'rocket_clean_post' );
	}
	
	// Prevent cache purge when a widget is updated.
	remove_filter( 'widget_update_callback'	, 'rocket_widget_update_callback' );
	
	// Prevent cache purge when current theme is updated.
	remove_action( 'upgrader_process_complete', 'rocket_clean_cache_theme_update', 10, 2 ); 
}
add_action( 'wp_rocket_loaded', __NAMESPACE__ . '\remove_purge_hooks' );

/**
 * Disable cache clearing when term is created/updated/deleted for WP Rocket 3.5.5 or later.
 * Disable user cache purging for WP Rocket 3.5 or later.
 *
 *	@author Vasilis Manthos
 * 	@author Piotr Bak
 */
function wp_rocket_disable_user_cache_purging(){
	
	$container = apply_filters( 'rocket_container', '');
	// After profile is updated (User cache only)
	$container->get('event_manager')->remove_callback( 'profile_update', [ $container->get('purge_actions_subscriber'), 'purge_user_cache'] );
	// After user is deleted (User cache only)
	$container->get('event_manager')->remove_callback( 'delete_user', [ $container->get('purge_actions_subscriber'), 'purge_user_cache'] );
	// After term is created
	$container->get('event_manager')->remove_callback( 'create_term' , [ $container->get('purge_actions_subscriber'), 'maybe_purge_cache_on_term_change'] );
	// After term is edited
	$container->get('event_manager')->remove_callback( 'edit_term' , [ $container->get('purge_actions_subscriber'), 'maybe_purge_cache_on_term_change'] );
	// After term is removed
	$container->get('event_manager')->remove_callback( 'delete_term' , [ $container->get('purge_actions_subscriber'), 'maybe_purge_cache_on_term_change'] );

}

add_action( 'wp_rocket_loaded', __NAMESPACE__ . '\wp_rocket_disable_user_cache_purging' );

// Prent cache clearing when Elementor is used
function wp_rocket_disable_elementor_cache_clearing(){

		add_action( 'wp_loaded', function() {
		$container = apply_filters( 'rocket_container', '');
		$container->get('event_manager')->remove_callback( 'added_post_meta', [ $container->get('elementor_subscriber'), 'maybe_clear_cache'], 10, 3 );
		$container->get('event_manager')->remove_callback( 'deleted_post_meta', [ $container->get('elementor_subscriber'), 'maybe_clear_cache'], 10, 3 );
		$container->get('event_manager')->remove_callback( 'elementor/core/files/clear_cache', [ $container->get('elementor_subscriber'), 'clear_cache'] );
		$container->get('event_manager')->remove_callback( 'update_option__elementor_global_css', [ $container->get('elementor_subscriber'), 'clear_cache'] );
		$container->get('event_manager')->remove_callback( 'delete_option__elementor_global_css', [ $container->get('elementor_subscriber'), 'clear_cache'] );
		} );
}

add_action( 'wp_rocket_loaded',  __NAMESPACE__  . '\wp_rocket_disable_elementor_cache_clearing' );

// Prent cache clearing when Avada is used
add_action( 'wp', function(){ 
	remove_action( 'avada_clear_dynamic_css_cache', 'rocket_clean_domain' );
	remove_action( 'fusion_cache_reset_after', 'rocket_avada_clear_cache_fusion_patcher' );
});