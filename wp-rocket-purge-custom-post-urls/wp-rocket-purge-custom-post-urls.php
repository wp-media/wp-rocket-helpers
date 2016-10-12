<?php
defined( 'ABSPATH' ) or die( 'No direct access to this file.' );
/**
 * Plugin Name: WP Rocket | Purge Custom Post URLs
 * Description: Adds a custom set of URLs to be purged from the cache when a post is updated.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/wp-rocket-purge-custom-post-urls/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Filters URLs to be purged from the cache when a post is updated.
 *
 * @param  array $purge_urls Array with URLs to be purged
 * @param  object $post      Post object
 * @return array             Modified array with URLs to be purged
 */
function wp_rocket_purge_custom_post_urls( $purge_urls, $post ) {

	if ( empty( $purge_urls ) || ! is_array( $purge_urls ) )
		return $purge_urls;

	/**
	 * ADD CUSTOM CONDITION FOR POST HERE!
	 * Optionally add a custom condition for the post to define which posts the
	 * further code of this plugin should get applied to.
	 *
	 * For example, the following condition would make the URLs defined below
	 * only be purged from cache if the post updated belongs to a specific
	 * category with the slug `example-category`.
	 *
	 * Uncomment and edit to use.
	 */
	// if ( ! has_category( 'example-category', $post->ID ) )
		// return $purge_urls;

	/**
	 * ADD CUSTOM URLS HERE!
	 * Add your custom URLs that you want purged whenever the post gets updated.
	 *
	 * For example, there could be a page displaying a custom category query.
	 * Such a query template would not be covered by WP Rocket’s default procedure
	 * for smart post cache purging. You would have to manually add the URL of
	 * said page to the set of URLs to be purged upon a post update.
	 *
	 * Uncomment and edit to use.
	 */
	// $purge_urls[] = 'http://example.com/example-page/';
	// $purge_urls[] = 'http://example.com/another-example-page/';

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
	// unset( $purge_urls );
	// $purge_urls   = array();

	/* Adds the current post back to purge set. */
	// $purge_urls[] = get_permalink( $post->ID );

	/* Add custom URLs here. */
	// $purge_urls[] = 'http://example.com/example-page/';
	// $purge_urls[] = 'http://example.com/category/example-category/';


	/**
	 * Return modified purge set to filter.
	 */
	return $purge_urls;
}
add_filter( 'rocket_post_purge_urls', 'wp_rocket_purge_custom_post_urls', 10, 2 );
