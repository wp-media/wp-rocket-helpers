<?php
defined( 'ABSPATH' ) or die( 'No direct access here, kiddo.' );
/**
 * Plugin Name: WP Rocket | Regex Exclusions
 * Description: Adds custom cache exclusions based on real Regular Expressions.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-regex-exclusions/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */


function wp_rocket_regex_exclusions( $uri ) {

	/**
	 * Sample expression, will match:
	 * /sample/2016/
	 * /sample/2016/01/
	 * /sample/2016/01/02/
	 * …but not:
	 * /sample/
	 * /sample/page/
	 * /sample/2016-01/
	 */
	$uri[] = '/sample/[0-9]{4}?\/(.*)';

	return $uri;
}
add_filter( 'rocket_cache_reject_uri', 'wp_rocket_regex_exclusions' );
