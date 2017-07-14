<?php
	
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

if ( ! function_exists( 'is_wp_rocket_active' ) ) {
	/**
	 * Check if WP Rocket is active
	 *
	 * @since 1.0
	 */
	function is_wp_rocket_active() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
	
		if ( is_plugin_active( 'wp-rocket/wp-rocket.php' ) ) {
			return true;
		}
	
		return false;
	}
}

/**
 * Remove feed URL from rejected URLs
 *
 * @since 1.0
 *
 * @param array $uri An array of URLs excluded from cache.
 * @return string Updated array of URLs
 */
function wp_rocket_cache_feed( $uri ) {
	$feed = '(.*)/' . $GLOBALS['wp_rewrite']->feed_base . '/?';
	if ( in_array( $feed, $uri ) ) {
		$uri = array_flip( $uri );
		unset( $uri[ $feed ] );
		$uri = array_flip( $uri );
	}

	return $uri;
}

/**
 * Display notice if WP Rocket is not active
 *
 * @since 1.0
 *
 * @return string HTML for the notice
 */
function wp_rocket_cache_feed_notice() {
	echo '<div class="error"><p>' . __( 'This plugin requires WP Rocket to be active. Please activate WP Rocket before activating WP Rocket for DreamPress.', 'wp-rocket-cache-feed' ) . '</p></div>';

	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
}
