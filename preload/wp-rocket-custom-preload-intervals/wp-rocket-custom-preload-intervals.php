<?php
/**
 * Plugin Name: WP Rocket | Custom Sitemap Preload Intervals
 * Description: Applies a custom preload interval on WP Rocket’s sitemap preload feature.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/preload/wp-rocket-custom-preload-intervals/
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

// EDIT THIS TO DEFINE A CUSTOM PRELOAD INTERVAL IN SECONDS:
define( 'WPROCKETHELPERS_PRELOAD_INTERVAL_IN_SECONDS', 5 );
// STOP EDITING.

/**
 * Set the preload interval for WP Rocket in microseconds.
 *
 * @author Arun Basil Lal
 * @author Caspar Hübinger
 * @return integer Custom preload interval in microseconds
 */
function apply_preload_interval() {
	return absint( WPROCKETHELPERS_PRELOAD_INTERVAL_IN_SECONDS ) * 1000 * 1000; // microseconds
}
add_filter( 'pre_get_rocket_option_sitemap_preload_url_crawl', __NAMESPACE__ . '\apply_preload_interval' );

/**
 * ⛔️ DEPRECATED SINCE WP ROCKET 3.0
 * IF YOU’RE ON 3.0.x OR GREATER, YOU CAN SAFELY DELETE THE FOLLOWING CODE.
 *
 * The following only works from WP Rocket 2.8 to 2.11.7.
 * We kept it here for people who still run one of those versions.
 */

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
// add_filter( 'rocket_sitemap_preload_interval', __NAMESPACE__ . '\custom_intervals' );
