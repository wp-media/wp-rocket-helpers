<?php
defined( 'ABSPATH' ) or die( 'No direct access to this file.' );
/**
 * Plugin Name: WP Rocket | UnLazyLoad LeadPages
 * Description: Disables LazyLoad for iFrames/videos on LeadPages URLs.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-unlazyload-leadpages/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Filter cache buffer for LeadPages meta tag,
 * disable LazyLoad for iFrames/video if applicable.
 *
 * @param  string $buffer Buffered HTML document
 * @return string         Buffered HTML document
 */
function wp_rocket_unlazyload_leadpages( $buffer ) {

	$meta_tag_matches = array();

	preg_match_all( '/<meta\s+name=[\'|"]+(leadpages-serving-domain)+(["\'])(\s.*)?(\s*\/)?>/iU', $buffer, $meta_tag_matches );

	if ( isset( $meta_tag_matches[0] ) && $meta_tag_matches[0] )
		add_filter( 'do_rocket_lazyload_iframes', '__return_false' );

	return $buffer;
}
add_filter( 'rocket_buffer', 'wp_rocket_unlazyload_leadpages' );
