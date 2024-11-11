<?php
/**
 * Plugin Name: WP Rocket | Disable Meta Generator tag
 * Description: Disables the Meta generator in WP Rocket.
 * Plugin URI:  https://docs.wp-rocket.me/article/46-how-to-check-if-wp-rocket-is-caching-your-pages#meta-tag
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Set rocket_disable_meta_generator to TRUE.
 */
add_filter( 'rocket_disable_meta_generator', '__return_true' );
