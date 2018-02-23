<?php
/**
 * Plugin Name: WP Rocket | No LazyLoad for Mobile Devices (Mobile Cache only)
 * Description: Disables LazyLoad for mobile devices when Mobile Cache with separate cache files is active.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/lazyload/wp-rocket-no-lazyload-mobile-cache/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\lazyload\no_lazyload\mobile_cache;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Disable LazyLoad on mobile devices (as detected by WP Rocket).
 *
 * @author Caspar Hübinger
 */
function deactivate_for_mobile_devices() {

	if( class_exists( 'Rocket_Mobile_Detect' ) && get_rocket_option( 'do_caching_mobile_files', false ) ) {

		$detect = new Rocket_Mobile_Detect();

		if ( $detect->isMobile() && ! $detect->isTablet() ) {

			// Deactivate LazyLoad for images.
			add_filter( 'do_rocket_lazyload', '__return_false' );

			// Deactivate LazyLoad for iframes.
			add_filter( 'do_rocket_lazyload_iframes', '__return_false' );
		}
	}
}
add_filter( 'wp', __NAMESPACE__ . '\deactivate_for_mobile_devices' );
