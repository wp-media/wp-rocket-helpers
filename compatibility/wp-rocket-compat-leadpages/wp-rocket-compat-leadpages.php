<?php
/**
 * Plugin Name: WP Rocket | No LazyLoad for iframes on LeadPages
 * Description: Disables LazyLoad for iframes/videos on LeadPages.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/compatibility/wp-rocket-compat-leadpages/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\compat\leadpages;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Filters cache buffer for LeadPages meta tag,
 * disables LazyLoad for iframes/video if applicable.
 *
 * @author Caspar Hübinger
 *
 * @param  string $buffer Buffered HTML document
 * @return string         Maybe modified buffered HTML document
 */
function maybe_disable_lazyload_for_iframes( $buffer ) {

	$meta_tag_matches = array();

	preg_match_all( '/<meta\s+name=[\'|"]+(leadpages-serving-domain)+(["\'])(\s.*)?(\s*\/)?>/iU', $buffer, $meta_tag_matches );

	if ( isset( $meta_tag_matches[0] ) && $meta_tag_matches[0] ) {
		add_filter( 'do_rocket_lazyload_iframes', '__return_false' );
	}

	return $buffer;
}
add_filter( 'rocket_buffer', __NAMESPACE__ . '\maybe_disable_lazyload_for_iframes' );
