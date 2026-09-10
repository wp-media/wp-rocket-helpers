<?php
/**
 * Plugin Name: WP Rocket - Custom LazyLoad Placeholder
 * Description: Replaces the WP Rocket LazyLoad placeholder with a transparent 1x1 GIF.
 * Version: 1.0.0
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * Author: WP Rocket Helper
 * License: GPL-2.0-or-later
 */

defined( 'ABSPATH' ) || exit;

/**
 * Use a transparent 1x1 GIF as the WP Rocket LazyLoad placeholder.
 *
 * @return string Placeholder data URI.
 */
function custom_wpr_lazyload_placeholder() {
	return 'data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=';
}
add_filter( 'rocket_lazyload_placeholder', 'custom_wpr_lazyload_placeholder' );
