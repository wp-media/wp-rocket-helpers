<?php
/**
 * WP Rocket License Manager bootstrap.
 *
 * This tiny file is installed automatically in wp-content/mu-plugins so the
 * credentials are available before normal plugins, including WP Rocket, load.
 */

defined( 'ABSPATH' ) || exit;

$wprlm_bootstrap_credentials = get_option( 'wprlm_credentials', [] );

if ( ! is_array( $wprlm_bootstrap_credentials ) ) {
	$wprlm_bootstrap_credentials = [];
}

if (
	! empty( $wprlm_bootstrap_credentials['key'] )
	&& is_string( $wprlm_bootstrap_credentials['key'] )
	&& ! defined( 'WP_ROCKET_KEY' )
) {
	define( 'WP_ROCKET_KEY', $wprlm_bootstrap_credentials['key'] );
	define( 'WPRLM_OWNS_WP_ROCKET_KEY', true );
}

if (
	! empty( $wprlm_bootstrap_credentials['email'] )
	&& is_string( $wprlm_bootstrap_credentials['email'] )
	&& ! defined( 'WP_ROCKET_EMAIL' )
) {
	define( 'WP_ROCKET_EMAIL', $wprlm_bootstrap_credentials['email'] );
	define( 'WPRLM_OWNS_WP_ROCKET_EMAIL', true );
}

unset( $wprlm_bootstrap_credentials );
