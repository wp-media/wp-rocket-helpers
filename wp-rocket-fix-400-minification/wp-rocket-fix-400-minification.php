<?php
defined( 'ABSPATH' ) or die( 'No direct access to this file.' );
/**
 * Plugin Name: WP Rocket | Fix Minification Error 400
 * Description: Fixes rare appearance of an error 400 (Bad Request) when minification is enabled.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/wp-rocket-fix-400-minification/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

add_filter( 'rocket_override_min_documentRoot', '__return_true' );
