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
 * Copyright SAS WP MEDIA 2021
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
		// When user changes the theme.
		'switch_theme',
		// When a user is added.
		'user_register',
		// When a user is updated.
		'profile_update',
		// When a user is deleted.
		'deleted_user',
		// When a custom menu is updated.
		'wp_update_nav_menu',
		// When any theme modifications are updated.
		'update_option_theme_mods_' . get_option( 'stylesheet' ),
		// When you change the order of widgets.
		'update_option_sidebars_widgets',
		// When category permalink prefix is update.
		'update_option_category_base',
		// When tag permalink prefix is update.
		'update_option_tag_base',
		// When permalink structure is update.
		'permalink_structure_changed',
		// When a term is created (before WP Rocket 3.5.5).
		'create_term',
		// When a term is updated (before WP Rocket 3.5.5).
		'edited_terms',
		// When a term is deleted (before WP Rocket 3.5.5).
		'delete_term',
		// When a link (post type) is added.
		'add_link',
		// When a link (post type) is updated.
		'edit_link',
		// When a link (post type) is deleted.
		'delete_link',
		// When resulty are saved in the Customizer.
		'customize_save',
		// When Avada theme purges its own cache.
		'avada_clear_dynamic_css_cache',
	);

	// WP core action hooks rocket_clean_post() gets hooked into.
	$clean_post_hooks = array(
		// Disables the refreshing of partial cache when content is edited.
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
	
	// Prevent cache purge when the current theme is updated.
	remove_action( 'upgrader_process_complete', 'rocket_clean_cache_theme_update', 10, 2 ); 
	
	// Prevent cache purge when post status is changed from publish to draft.
	remove_action( 'pre_post_update', 'rocket_clean_post_cache_on_status_change', 10, 2 );
	
	// Prevent cache purge when a post's slug is changed.
	remove_action( 'pre_post_update', 'rocket_clean_post_cache_on_slug_change', PHP_INT_MAX, 2 );
	
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
	// After profile is updated (User cache only).
	$container->get('event_manager')->remove_callback( 'profile_update', [ $container->get('purge_actions_subscriber'), 'purge_user_cache'] );
	// After user is deleted (User cache only).
	$container->get('event_manager')->remove_callback( 'delete_user', [ $container->get('purge_actions_subscriber'), 'purge_user_cache'] );
	// After term is created.
	$container->get('event_manager')->remove_callback( 'create_term' , [ $container->get('purge_actions_subscriber'), 'maybe_purge_cache_on_term_change'] );
	// After term is edited.
	$container->get('event_manager')->remove_callback( 'edit_term' , [ $container->get('purge_actions_subscriber'), 'maybe_purge_cache_on_term_change'] );
	// After term is removed.
	$container->get('event_manager')->remove_callback( 'delete_term' , [ $container->get('purge_actions_subscriber'), 'maybe_purge_cache_on_term_change'] );

}

add_action( 'wp_rocket_loaded', __NAMESPACE__ . '\wp_rocket_disable_user_cache_purging' );

// Prevent cache clearing when Elementor is used.
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

// Prevent cache clearing when Avada is used.
add_action( 'wp', function(){ 
	remove_action( 'avada_clear_dynamic_css_cache', 'rocket_clean_domain' );
	remove_action( 'fusion_cache_reset_after', 'rocket_avada_clear_cache_fusion_patcher' );
});

/**
 * Disable cache clearing after saving a WooCoommerce product variation.
 *
 *	@author Vasilis Manthos
 */
function wp_rocket_disable_woocommerce_variation_cache_clear(){
	$container = apply_filters( 'rocket_container', '');
	$container->get('event_manager')->remove_callback( 'woocommerce_save_product_variation', [ $container->get('woocommerce_subscriber'), 'clean_cache_after_woocommerce_save_product_variation'] );
}

add_action( 'wp_rocket_loaded', __NAMESPACE__ . '\wp_rocket_disable_woocommerce_variation_cache_clear' );


/**
 * Disable cache clearing after updating dynamic lists.
 *
 *	@author Ahmed Saeed
 */
 function wp_rocket_disable_rocket_after_save_dynamic_lists(){
	 
	$container = apply_filters( 'rocket_container', [] );
	if ( ! empty( $container ) ) {
		remove_action( 'rocket_after_save_dynamic_lists', [ $container->get( 'purge_actions_subscriber' ), 'purge_cache' ] );
		remove_action( 'rocket_after_save_dynamic_lists', [ $container->get( 'purge_actions_subscriber' ), 'purge_cache_after_saving_dynamic_lists' ] );
	}

 }
 
 add_action( 'init', __NAMESPACE__ . '\wp_rocket_disable_rocket_after_save_dynamic_lists' );
 
 
/**
 * Maybe render admin notice.
 *
 * @author Caspar Hübinger
 */
function maybe_render_admin_notice() {


	if ( ! maybe_is_admin_on_settings_page() ) {
		return false;
	}

	// Render message.
	printf(
		'<div class="notice notice-info"><p>%s</p></div>',
		__( '<strong>WP Rocket | Disable Cache Clearing:</strong> Automatic Cache Clearing is programmatically disabled.' )
	);
}
add_action( 'admin_notices', __NAMESPACE__ . '\maybe_render_admin_notice', 100 );


/**
 * Check if we’re inside the admin_notices filter, on WP Rocket’s settings page,
 * and the current user has permission to manage WP Rocket.
 *
 * @author Caspar Hübinger
 *
 * @return bool True if all of the above, else false
 */
function maybe_is_admin_on_settings_page() {


	// Only to be used in admin_notices filter.
	if ( 'admin_notices' !== current_filter() ) {
		return false;
	}


	// Only if WP Rocket is active.
	if ( ! function_exists( 'get_rocket_option' ) ) {
		return false;
	}


	// Only for WP Rocket administrators.
	if ( ! current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) ) ) {
		return false;
	}


	// Determine screen ID, we may be in white-label mode - compatibility for WP Rocket <= 2.9.11.
	$current_screen      = get_current_screen();
	$rocket_wl_name      = get_rocket_option( 'wl_plugin_name', null );
	$wp_rocket_screen_id = isset( $rocket_wl_name ) ? 'settings_page_' . sanitize_key( $rocket_wl_name ) : 'settings_page_wprocket';
	
	// Only on WP Rocket settings page.
	if ( $wp_rocket_screen_id !== $current_screen->base ) {
		return false;
	}

	return true;
}
