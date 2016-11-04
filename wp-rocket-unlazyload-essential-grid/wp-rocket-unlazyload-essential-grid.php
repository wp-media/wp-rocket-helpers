<?php
defined( 'ABSPATH' ) or die( 'No direct access to this file.' );
/**
 * Plugin Name: WP Rocket | UnLazyLoad Essential Grid
 * Description: Disables WP Rocket’s LazyLoad feature on pages with <a href="https://www.themepunch.com/portfolio/essential-grid-wordpress-plugin/">Essential Grid</a>.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/wp-rocket-unlazyload-essential-grid/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Disables WP Rocket’s LazyLoad feature on pages with Essential Grid.
 * @param  string $content WP Post content
 * @return string          WP Post content
 */
function wp_rocket_unlazyload_essential_grid( $content ) {

	if ( is_admin() || ! class_exists( 'Essential_Grid' ) || ! function_exists( 'has_shortcode' ) )
		return $content;

	if ( has_shortcode( $content, 'ess_grid' )
	  || has_shortcode( $content, 'ess_grid_search' )
	  || has_shortcode( $content, 'ess_grid_nav' )
	  || has_shortcode( $content, 'ess_grid_ajax_target' ) ) {
		add_filter( 'do_rocket_lazyload', '__return_false' );
	}

	return $content;
}
add_filter( 'the_content', 'wp_rocket_unlazyload_essential_grid', 100 );

/**
 * Render admin notice.
 * @return bool
 */
function wp_rocket_unlazyload_essential_grid__render_admin_notice() {

	// Only for admins.
	if ( ! current_user_can( 'manage_options' ) )
		return false;


	$current_screen = get_current_screen();

	// Only on WP Rocket settings pages.
	if ( 'admin_notices' === current_filter() && ( isset( $current_screen ) && 'settings_page_wprocket' !== $current_screen->base ) ) {
		return false;
	}

	// Only if LazyLoad is enabled.
	if ( ! get_rocket_option( 'lazyload' ) )
		return false;

	// Render message.
	printf(
		'<div class="notice notice-info"><p>%s</p></div>',
		__( '<strong>Note:</strong> LazyLoad is programmatically disabled on pages with <em>Essential Grid</em>.' )
	);

	// Return a value for tests.
	return true;
}
add_action( 'admin_notices', 'wp_rocket_unlazyload_essential_grid__render_admin_notice', 100 );
