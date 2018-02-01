<?php
/**
 * Plugin Name: WP Rocket | No LazyLoad for Essential Grid
 * Description: Disables WP Rocket’s LazyLoad feature on pages with <a href="https://www.themepunch.com/portfolio/essential-grid-wordpress-plugin/">Essential Grid</a>.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/compatibility/wp-rocket-compat-essential-grid/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\compat\essential_grid;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Disables WP Rocket’s LazyLoad feature on pages with Essential Grid.
 *
 * @author Caspar Hübinger
 * @param  string $content WP Post content
 * @return string          WP Post content
 */
function filter_content( $content ) {

	if ( is_admin() || ! class_exists( 'Essential_Grid' ) || ! function_exists( 'has_shortcode' ) ) {
		return $content;
	}

	if ( has_shortcode( $content, 'ess_grid' )
	  || has_shortcode( $content, 'ess_grid_search' )
	  || has_shortcode( $content, 'ess_grid_nav' )
	  || has_shortcode( $content, 'ess_grid_ajax_target' ) ) {
		add_filter( 'do_rocket_lazyload', '__return_false' );
	}

	return $content;
}
add_filter( 'the_content', __NAMESPACE__ . '\filter_content', 100 );

/**
 * Render admin notice.
 * @author Caspar Hübinger
 */
function render_admin_notice() {

	// Only for admins.
	if ( ! current_user_can( 'manage_options' ) ) {
		return false;
	}

	// Bail if WP Rocket is not active.
	if ( ! function_exists( 'get_rocket_option' ) ) {
		return false;
	}

	// Bail if LazyLoad is disabled.
	if ( ! get_rocket_option( 'lazyload' ) ) {
		return false;
	}

	$current_screen = get_current_screen();

	// Only on WP Rocket settings pages.
	if ( 'admin_notices' === current_filter() && ( isset( $current_screen ) && 'settings_page_wprocket' !== $current_screen->base ) ) {
		return false;
	}

	// Render message.
	printf(
		'<div class="notice notice-info"><p>%s</p></div>',
		__( '<strong>Note:</strong> LazyLoad is programmatically disabled on pages with <em>Essential Grid</em>.' )
	);
}
add_action( 'admin_notices', __NAMESPACE__ . '\render_admin_notice', 100 );
