<?php
/**
 * Plugin Name: WP Rocket Helper Plugin | Cookie Notice Integration
 * Description: Adds compatibility with Cookie Notice by dFactory to WP Rocket.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/compatibility/wp-rocket-compat-cookie-notice/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\compat\cookie_notice;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Return the cookie name set by Cookie Notice plugin
 *
 * @author Arun Basil Lal
 * @return string the cookie name.
 */
function cookie_name () {

	$cookie[] = 'cookie_notice_accepted';

	return $cookie;
}

/**
 * Update WP Rocket config to serve cache based on value of 'cookie_notice_accepted'
 *
 * Config is in wp-content/wp-rocket-config
 * @author Arun Basil Lal
 */
function update_config() {

	// Create cache version based on value set in cookie_notice_accepted cookie.
	add_filter( 'rocket_cache_dynamic_cookies', __NAMESPACE__ . '\cookie_name' );

	// Update the WP Rocket rules on the .htaccess file.
	if ( function_exists('flush_rocket_htaccess') ) {
		flush_rocket_htaccess();
	}

	// Regenerate the config file.
	if ( function_exists('rocket_generate_config_file') ) {
		rocket_generate_config_file();
	}

	// Clear WP Rocket cache
	if ( function_exists('rocket_clean_domain') ) {
		rocket_clean_domain();
	}
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\update_config' );

/**
 * Revert WP Rocket config when plugin is uninstalled
 *
 * Config is in wp-content/wp-rocket-config
 * @author Arun Basil Lal
 */
function restore_config () {

	remove_filter( 'rocket_cache_dynamic_cookies', __NAMESPACE__ . '\cookie_name' );

	// Update the WP Rocket rules on the .htaccess file.
	if ( function_exists('flush_rocket_htaccess') )
		flush_rocket_htaccess();

	// Regenerate the config file.
	if ( function_exists('rocket_generate_config_file') )
		rocket_generate_config_file();

	// Clear WP Rocket cache
	if ( function_exists('rocket_clean_domain') )
		rocket_clean_domain();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ .'\restore_config' );
