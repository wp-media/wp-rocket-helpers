<?php
defined( 'ABSPATH' ) or die( 'No direct access here, kiddo.' );
/**
 * Plugin Name: WP Rocket | Force Page Caching
 * Description: Ensures caching even when <code>DONOTCACHEPAGE</code> is set.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-override-donotcachepage/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Override DONOTCACHEPAGE behavior for WP Rocket cache.
 */
add_filter( 'rocket_override_donotcachepage', '__return_true', PHP_INT_MAX );
