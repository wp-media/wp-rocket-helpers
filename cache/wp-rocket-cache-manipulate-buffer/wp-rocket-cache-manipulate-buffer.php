<?php
/**
 * Plugin Name: WP Rocket | Manipulate buffer
 * Description: Searches for occurences of desired strings in the buffer and replaces them with custom value
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-cache-manipulate-buffer
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */
 
// Namespaces must be declared before any other declaration.
namespace WP_Rocket\Helpers\wp_rocket_cache_manipulate_buffer;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Set up custom value to be inserted before closing title tag.
 *
 * @return string custom value
 */
function wp_rocket_define_tag() {
	/**
	 * SET DESIRED OUTPUT
	 */
	$value = '<style id="custom-critical-css" src="https://example.com/example.css"></style>';
	return sprintf( $value );
}

/**
 * Filter cache buffer, injects value after closing title tag.
 *
 * @uses   wp_rocket_define_tag
 * @var    $buffer
 * @return string
 */
function wp_rocket_replace_tag( $buffer ) {
	
	$value_tag = wp_rocket_define_tag();
	
	preg_match_all( '/(<\/title>)/i', $buffer, $tags_match );
	foreach ( $tags_match[0] as $tag ) {
		$buffer = str_replace( $tag, $tag . $value_tag, $buffer );
	}
	
	return $buffer;
}
add_filter( 'rocket_buffer', __NAMESPACE__ . '\wp_rocket_replace_tag', 100 );

/**
 * Clear cache when plugin is activated.
 *
 */
function flush_wp_rocket() {

	if ( ! function_exists( 'rocket_clean_domain' )){
		return false;
	}

	// Clean whole cache.
	rocket_clean_domain();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_wp_rocket' );

/**
 * Clear cache on deactivation
 *
 */
function deactivate() {

	// Clear cache
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );