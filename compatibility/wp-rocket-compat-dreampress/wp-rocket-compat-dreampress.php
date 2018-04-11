<?php
/**
 * Plugin Name: WP Rocket for DreamPress
 * Description: Compatibility add-on for WP Rocket on DreamPress.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/compatibility/wp-rocket-compat-dreampress/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\compat\dreampress;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Run when plugin is loaded
 *
 * @author Remy Perona
 */
function init() {

	if ( ! is_wp_rocket_active() ) {
		return;
	}

	add_filter( 'do_rocket_varnish_http_purge', '__return_true' );
	add_filter( 'rocket_display_varnish_options_tab', '__return_false' );
	add_filter( 'rocket_minify_bypass_varnish', __NAMESPACE__ . '\minify_compatibility' );
	add_filter( 'rocket_htaccess_mod_expires', __NAMESPACE__ . '\remove_html_expire_dreampress' );
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\init' );

/**
 * Deactivate the plugin if WP Rocket is not active
 *
 * @author Remy Perona
 */
function maybe_deactivate() {

	if ( ! is_wp_rocket_active() ) {

		deactivate_plugins( plugin_basename( __FILE__ ) );
		add_action( 'admin_notices', __NAMESPACE__ . '\render_admin_notice' );

		return;
	}
}
add_action( 'admin_init', __NAMESPACE__ . '\maybe_deactivate' );

/**
 * Run when plugin is activated.
 *
 * @author Remy Perona
 */
function activate() {

	if (  ! is_wp_rocket_active() ) {
		return;
	}

	add_filter( 'rocket_htaccess_mod_expires', __NAMESPACE__ . '\remove_html_expire_dreampress' );
	flush_rocket_htaccess();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\activate' );

/**
 * Run when plugin is deactivated.
 *
 * @author Remy Perona
 */
function deactivate() {

	if ( ! is_wp_rocket_active() ) {
		return;
	}

	remove_filter( 'rocket_htaccess_mod_expires', __NAMESPACE__ . '\remove_html_expire_dreampress' );
	flush_rocket_htaccess();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );

/**
 * Check if WP Rocket is active
 *
 * @author Remy Perona
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
 * Remove expiration on HTML to prevent issue with Varnish cache.
 *
 * @author Remy Perona
 * @param  string $rules .htaccess rules
 * @return string        Modified .htaccess rules
 */
function remove_html_expire_dreampress( $rules ) {
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
 * @author Remy Perona
 *
 * @param  string $url Minification URL
 * @return string      Minification URL with additional parameter
 */
function minify_compatibility( $url ) {
	return add_query_arg(  'varnish', 'bypass', $url );
}

/**
 * Display notice if WP Rocket is not active.
 *
 * @author Remy Perona
 * @author Caspar Hübinger
 */
function render_admin_notice() {

	printf( '<div class="notice notice-error"><p>%s</p></div>',
		__( '<strong>WP Rocket for DreamPress</strong> requires <strong>WP Rocket</strong> to be active. Please activate WP Rocket before activating this plugin.', 'wp-rocket-for-dreampress' )
	);

	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
}
