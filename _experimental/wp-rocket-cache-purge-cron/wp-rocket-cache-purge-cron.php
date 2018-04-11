<?php
/**
 * *********************************************************************
 * THIS IS NOT A PLUGIN! DON’T INSTALL THIS IN YOUR WORDPRESS!
 * *********************************************************************
 * Read the documentation:
 * http://docs.wp-rocket.me/article/494-how-to-clear-cache-via-cron-job
 * *********************************************************************
 * URI:         https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-cache-purge-cron/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\cache\cron\purge_preload;

// EDIT THIS TO REFLECT THE ABSOLUTE PATH TO wp-load.php ON YOUR SERVER:

define( 'WPROCKETHELPERS_WP_LOAD_FILE', '/path/to/wp-load.php' );

// STOP EDITING.

// If we are in WordPress at this point, something is not right, so nope.
if ( defined( 'ABSPATH' ) ) {
	die( 'This is not a WordPress plugin! Read the <a href="http://docs.wp-rocket.me/article/494-how-to-clear-cache-via-cron-job">documentation</a>.' );
}

// Check if wp-load.php exists at this path.
file_exists( WPROCKETHELPERS_WP_LOAD_FILE ) or die( 'Please enter the absolute path to wp-load.php.' );

// Load WordPress.
require( WPROCKETHELPERS_WP_LOAD_FILE );

/**
 * Clear cache and run preload.
 * In a multisite network, this applies only to the main site.
 */
clear_cache_run_preload();


// Stop here if this is a regular single WordPress site, not a multisite.
if ( ! is_multisite() ) {
	return;
}

/**
 * Clear cache and run preload on each sub-site in the network.
 */
$subsites = get_sites();
foreach( $subsites as $subsite ) {

	// Check if WP Rocket is active.
	if ( wp_rocket_maybe_active() ) {

		// Clear cache, run preload.
		clear_cache_run_preload();
	}
}

/**
 * Checks functions from WP Rocket are available.
 *
 * @author Caspar Hübinger
 * @return bool True if specified functions exist, else false
 */
function wp_rocket_maybe_active() {
	return function_exists( '\rocket_clean_domain' ) && function_exists( '\run_rocket_preload_cache' );
}

/**
 * Checks if WP Rocket is active; if so, clears cache, and runs preload.
 *
 * @author Caspar Hübinger
 * @uses   wp_rocket_maybe_active
 * @return bool False if WP Rocket is not active, else true
 */
function clear_cache_run_preload() {

	if ( ! wp_rocket_maybe_active() ) {
		return false;
	}

	// Clear global cache.
	\rocket_clean_domain();

	// Run preload (bot + sitemap as configured).
	\run_rocket_preload_cache( 'cache-preload' );

	return true;
}
