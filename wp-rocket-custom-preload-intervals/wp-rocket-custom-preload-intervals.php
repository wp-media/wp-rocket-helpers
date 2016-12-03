<?php
defined( 'ABSPATH' ) or die( 'No direct access to this file.' );
/**
 * Plugin Name: WP Rocket | Custom Sitemap Preload Intervals
 * Description: Adds a custom set of sitemap preload intervals in WP Rocket’s Preload settings tab.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/wp-rocket-custom-preload-intervals/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Add custom values to sitemap preload intervals option.
 * @param  array $intervals  Default intervals
 * @return array             Extended intervals
 */
function wp_rocket_custom_sitemap_preload_intervals( $intervals ) {

	// See wp-rocket/inc/admin/ui/modules/preload.php for default values.
	$intervals[ '3000000' ] = '3s';
	$intervals[ '4000000' ] = '4s';
	$intervals[ '5000000' ] = '5s';

	return $intervals;
}
add_filter( 'rocket_sitemap_preload_interval', 'wp_rocket_custom_sitemap_preload_intervals' );
