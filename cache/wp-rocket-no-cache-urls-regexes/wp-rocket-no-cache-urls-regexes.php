<?php
/**
 * Plugin Name: WP Rocket | Regex Exclusions
 * Description: Adds custom cache exclusions based on real Regular Expressions.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-no-cache-urls-regexes/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\cache\no_cache_urls_regexes;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 *
 * @param  array $uri  Paths to exclude from caching
 * @return array       Maybe modfied paths to exclude from caching
 */
function never_cache_urls( $uri ) {

	/**
	 * Sample expression, will match:
	 * /sample/2018/
	 * /sample/2018/01/
	 * /sample/2018/01/02/
	 * …but not:
	 * /sample/
	 * /sample/page/
	 * /sample/2018-01/
	 */
	$uri[] = '/sample/[0-9]{4}?\/(.*)';

	return $uri;
}
add_filter( 'rocket_cache_reject_uri', __NAMESPACE__ . '\never_cache_urls' );
