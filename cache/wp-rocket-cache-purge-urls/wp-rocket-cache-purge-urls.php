<?php
/**
 * Plugin Name: WP Rocket | Purge Custom Post URLs
 * Description: Purges a custom set of URLs additional to WP Rocket’s automatic cache purging when a post is updated.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-cache-purge-urls/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\cache\purge_urls;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Filters URLs to be purged from the cache when a post is updated.
 *
 * @author Caspar Hübinger
 *
 * @param  array $purge_urls Array with URLs to be purged
 * @param  object $post      Post object
 * @return array             Modified array with URLs to be purged
 */
function purge_custom_post_urls( $urls_to_purge, $post ) {

	if ( empty( $urls_to_purge ) || ! is_array( $urls_to_purge ) )
		return $urls_to_purge;

	/**
	 * ADD CUSTOM CONDITION FOR POST HERE!
	 * Optionally add a custom condition for the post to define which posts the
	 * further code of this plugin should get applied to.
	 *
	 * For example, the following condition would make the URLs defined below
	 * only be purged from cache if the post updated belongs to a specific
	 * category with the slug `example-category`.
	 *
	 * Uncomment and edit to use:
	 */
	// if ( ! has_category( 'example-category', $post->ID ) ) {
	// 	return $urls_to_purge;
	// }


	/**
	 * ADD CUSTOM URLS HERE!
	 * Add your custom URLs that you want purged whenever the post gets updated.
	 *
	 * For example, there could be a page displaying a custom category query.
	 * Such a query template would not be covered by WP Rocket’s default procedure
	 * for smart post cache purging. You would have to manually add the URL of
	 * said page to the set of URLs to be purged upon a post update.
	 *
	 * Uncomment and edit to use:
	 */
	// $urls_to_purge[] = 'http://example.com/example-page/';
	// $urls_to_purge[] = 'http://example.com/another-example-page/';

	/**
	 * DANGER ZONE!
	 * You could even unset the default set of URLs to be purged entirely and
	 * re-define your complete custom procedure.
	 *
	 * This is absolutely not recommended, though!
	 * The following lines of code are merely a proof of concept, so don’t use
	 * them unless you’re Obi Wan Kenobi and know a shitload about page caching
	 * and WordPress development in general.
	 */
	// unset( $urls_to_purge );
	// $urls_to_purge   = array();

	/* Adds the current post back to purge set. */
	// $urls_to_purge[] = get_permalink( $post->ID );

	/* Add custom URLs here. */
	// $urls_to_purge[] = 'http://example.com/example-page/';
	// $urls_to_purge[] = 'http://example.com/category/example-category/';


	/**
	 * Return modified purge set to filter.
	 */
	return $urls_to_purge;
}
add_filter( 'rocket_post_purge_urls', __NAMESPACE__ . '\purge_custom_post_urls', 10, 2 );
