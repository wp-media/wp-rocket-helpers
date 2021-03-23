<?php
/**
 * Plugin Name: WP Rocket | Remove Custom Post URLs from purge
 * Description: Removes a custom set of URLs from WP Rocket’s automatic cache purging when a post is updated.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-cache-no-purge-urls/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\cache\no_purge_urls;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude URLs WP Rocket’s automatic cache purging.
 *
 * @param  array  $urls    Array with URLs to be purged
 * @return array           Modified array with URLs to be purged
 */

function disable_cache_clearing_files( $urls ){
		
		$exluded_urls = [		
			'https://example.com/shop/index-httpspage',		
			'https://example.com/shop/index-https.html_gzip',		
			'https://example.com/shop/index-https.html',				
			'/shop/index-httpspage',		
			'/shop/index-https.html_gzip',		
			'/shop/index-https.html',				
		];
		$urls = array_diff( $urls, $exluded_urls);
		
		return $urls;
	}

	add_filter( 'rocket_post_purge_urls', __NAMESPACE__ . '\disable_cache_clearing_files');
