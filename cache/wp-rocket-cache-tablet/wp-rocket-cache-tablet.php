<?php
/**
 * Plugin Name: WP Rocket | Set Tabelts As Mobiles
 * Description: WP Rocket by default considers tablets as desktops. This helper plugin will set Tablets as mobile devices. Useful if your theme uses wp_is_mobile function.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-cache-tablet
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\cache_tablet;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Set Tablets As Mobiles.
 * 
 * @param $cache_tablet (string) The string passed from the filter rocket_cache_mobile_files_tablet.
 * 
 * @return (string) the keyword 'mobile'. It can be either 'mobile' or 'desktop'.
 *
 * @author Arun Basil Lal
 */
function tablets_as_mobiles( $cache_tablet ) {
	return 'mobile';
}
add_filter( 'rocket_cache_mobile_files_tablet', __NAMESPACE__ . '\tablets_as_mobiles' );

/**
 * Regenerates WP Rocket config file and clear entire cache on activation.
 *
 * @author Arun Basil Lal
 */
function flush_wp_rocket() {

	if ( ! ( function_exists( 'rocket_generate_config_file' ) || function_exists( 'rocket_clean_domain' ) ) ) {
		return false;
	}

	/**
	 * Regenerate WP Rocket config file. 
	 * During this process the value of $rocket_cache_mobile_files_tablet in the WP Rocket config file
	 * will be changed from the default value 'desktop' to 'mobile'. 
	 */
	rocket_generate_config_file();
	
	// Clear the cache.
	rocket_clean_domain();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_wp_rocket' );

/**
 * Regenerates WP Rocket config file and clears the cache on deactivation.
 *
 * @author Arun Basil Lal
 */
function deactivate() {

	// Remove the filter.
	remove_filter( 'rocket_cache_mobile_files_tablet', __NAMESPACE__ . '\tablets_as_mobiles' );

	// Regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );