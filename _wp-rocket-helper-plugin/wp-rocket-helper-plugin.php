<?php
/**
 * Plugin Name: WP Rocket | {What This Plugin Does}
 * Description: {What this plugin does in one clear sentence.}
 * Plugin URI:  {GitHub repo URL of this plugin}
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

// EDIT THIS: Replace `boilerplate` with your custom subnamespace.
// Namespaces must be declared before any other declaration.
namespace WP_Rocket\Helpers\boilerplate;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


// BEFORE YOU MOVE ON:
// Do a file search for `boilerplate` and replace it with your
// custom subnamespace defined above.



/**
 * Adds customizations once WP Rocket has loaded.
 * HEADS UP: If you keep the deactivation hook further down this file,
 * you will have to edit it to remove_filter() this function.
 *
 * @author {Author Name}
 */
function do_stuff() {

	// Do something here.
	// Example: Disable page caching.
	add_filter( 'do_rocket_generate_caching_files', '__return_false' );

}
// Hooking into `wp_rocket_loaded` is a safe way to make sure all WP Rocket
// features are available, however, it’s not required.
// Using other hooks directly will be just fine in most cases.
add_action( 'wp_rocket_loaded', __NAMESPACE__ . '\do_stuff' );



// OPTIONAL: Flush .htaccess and re-generate a new config file.
// Edit, or remove below functions as you see fit for your customization.

/**
 * Updates .htaccess, regenerates WP Rocket config file.
 *
 * @author {Author Name}
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
 * @author {Author Name}
 */
function deactivate() {

	// Remove all functionality added above.
	remove_filter( 'wp_rocket_loaded', __NAMESPACE__ . '\do_stuff' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );
