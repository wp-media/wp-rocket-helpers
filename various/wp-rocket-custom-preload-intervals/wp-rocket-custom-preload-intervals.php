<?php
/**
 * Plugin Name: WP Rocket | Custom Sitemap Preload Intervals
 * Description: Adds a custom set of sitemap preload intervals in WP Rocket’s Preload settings tab.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/various/wp-rocket-custom-preload-intervals/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\preload\sitemap;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Add custom values to sitemap preload intervals option.
 *
 * @author Caspar Hübinger
 * 
 * @param  array $intervals  Default intervals
 * @return array             Extended intervals
 */
function custom_intervals( array $intervals ) {

	// See wp-rocket/inc/admin/ui/modules/preload.php for default values.
	$intervals[ '3000000' ] = '3s';
	$intervals[ '4000000' ] = '4s';
	$intervals[ '5000000' ] = '5s';

	return $intervals;
}
add_filter( 'rocket_sitemap_preload_interval', __NAMESPACE__ . '\custom_intervals' );
