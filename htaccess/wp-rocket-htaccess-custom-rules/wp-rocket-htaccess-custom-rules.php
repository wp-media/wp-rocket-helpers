<?php
/**
 * Plugin Name: WP Rocket | Add custom htaccess rules
 * Description: Add custom rules to the .htaccess file
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\htaccess\custom_rules;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Add custom rules to the .htaccess file.
 *
 * @author Vasilis Manthos
 * @param  string $marker Block of WP Rocket rules
 * @return string         Extended block of WP Rocket rules
 */
function render_rewrite_rules( $marker ) {

	$customHeaders  = '# BEGIN Override default expires' . PHP_EOL;
	$customHeaders  .= '<IfModule mod_expires.c>' . PHP_EOL;
	$customHeaders  .= 'ExpiresActive on' . PHP_EOL;
	$customHeaders  .= 'ExpiresDefault "access plus 0 seconds"' . PHP_EOL;
	$customHeaders  .= '</IfModule>' . PHP_EOL;
	$customHeaders  .= '# END Override default expires' . PHP_EOL . PHP_EOL;

	// Prepend custom headers to WP Rocket block.
	$marker = $customHeaders . $marker;

	return $marker;
}

// Use one of those filters to add code before or after WP Rocket rules
// add_filter( 'before_rocket_htaccess_rules', __NAMESPACE__ . '\render_rewrite_rules' );
add_filter( 'after_rocket_htaccess_rules', __NAMESPACE__ . '\render_rewrite_rules' );

/**
 * Updates .htaccess, regenerates WP Rocket config file.
 *
 * @author Caspar Hübinger
 */
function flush_wp_rocket() {

	if ( ! function_exists( 'flush_rocket_htaccess' )
	  || ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}

	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_wp_rocket' );

/**
 * Removes customizations, updates .htaccess, regenerates config file.
 *
 * @author Caspar Hübinger
 */
function deactivate() {

	// Remove all functionality added above. Please remove the correct filter.
	// remove_filter( 'before_rocket_htaccess_rules', __NAMESPACE__ . '\render_rewrite_rules' );
	remove_filter( 'after_rocket_htaccess_rules', __NAMESPACE__ . '\render_rewrite_rules' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );
