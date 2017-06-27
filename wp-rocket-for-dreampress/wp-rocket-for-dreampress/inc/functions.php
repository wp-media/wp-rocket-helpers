<?php
	
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

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

/**
 * Remove expiration on HTML to prevent issue with Varnish cache
 *
 * @since 1.0
 *
 * @param string $rules htaccess rules.
 * @return Updated htaccess rules
 */
function wp_rocket_remove_html_expire_dreampress( $rules ) {
	$rules = <<<HTACCESS
# Expires headers (for better cache control)
<IfModule mod_expires.c>
	ExpiresActive on

	# Perhaps better to whitelist expires rules? Perhaps.
	ExpiresDefault                          "access plus 1 month"

	# cache.appcache needs re-requests in FF 3.6 (thanks Remy ~Introducing HTML5)
	ExpiresByType text/cache-manifest       "access plus 0 seconds"

	# Data
	ExpiresByType text/xml                  "access plus 0 seconds"
	ExpiresByType application/xml           "access plus 0 seconds"
	ExpiresByType application/json          "access plus 0 seconds"

	# Feed
	ExpiresByType application/rss+xml       "access plus 1 hour"
	ExpiresByType application/atom+xml      "access plus 1 hour"

	# Favicon (cannot be renamed)
	ExpiresByType image/x-icon              "access plus 1 week"

	# Media: images, video, audio
	ExpiresByType image/gif                 "access plus 1 month"
	ExpiresByType image/png                 "access plus 1 month"
	ExpiresByType image/jpeg                "access plus 1 month"
	ExpiresByType video/ogg                 "access plus 1 month"
	ExpiresByType audio/ogg                 "access plus 1 month"
	ExpiresByType video/mp4                 "access plus 1 month"
	ExpiresByType video/webm                "access plus 1 month"

	# HTC files  (css3pie)
	ExpiresByType text/x-component          "access plus 1 month"

	# Webfonts
	ExpiresByType application/x-font-ttf    "access plus 1 month"
	ExpiresByType font/opentype             "access plus 1 month"
	ExpiresByType application/x-font-woff   "access plus 1 month"
	ExpiresByType application/x-font-woff2  "access plus 1 month"
	ExpiresByType image/svg+xml             "access plus 1 month"
	ExpiresByType application/vnd.ms-fontobject "access plus 1 month"

	# CSS and JavaScript
	ExpiresByType text/css                  "access plus 1 year"
	ExpiresByType application/javascript    "access plus 1 year"
</IfModule>


HTACCESS;

	return $rules;
}

/**
 * Add query string to bypass Varnish on minified files
 *
 * @since 1.0
 *
 * @param string $url Minification URL.
 * @return string Minification URL with additional parameter
 */
function wp_rocket_dreampress_minify_compatibility( $url ) {
	return add_query_arg(  'varnish', 'bypass', $url );
}

/**
 * Display notice if WP Rocket is not active
 *
 * @since 1.0
 *
 * @return string HTML for the notice
 */
function wp_rocket_dreampress_notice() {
	echo '<div class="error"><p>' . __( 'This plugin requires WP Rocket to be active. Please activate WP Rocket before activating WP Rocket for DreamPress.', 'wp-rocket-for-dreampress' ) . '</p></div>';

	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
}
