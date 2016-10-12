<?php
defined( 'ABSPATH' ) or die( 'No direct access here, kiddo.' );
/**
 * Plugin Name: WP Rocket | Events Calendar Unminify
 * Description: Programmatically deactivates minification for events posts, events archives, events taxonomy pages, and posts/pages containing events shortcodes.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/wp-rocket-events-calendar-unminify/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Forces DONOTMINIFYCSS for events posts, archives, and taxnomy pages.
 *
 * @return void
 */
function wp_rocket_unminify_events_calendar() {

	// Make sure WP Rocket and Events plugin are both active.
	if ( ! class_exists( 'Tribe__Events__Main' )
	  || ! function_exists( 'rocket_define_donotminify_constants' ) ) {
		return;
	}

	/**
	 * Event post type + taxonomy:
	 * @link https://github.com/moderntribe/the-events-calendar/blob/develop/src/Tribe/Main.php#L30-L31
	 */
	if (
		   is_post_type_archive( 'tribe_events' ) // events archive
		|| is_singular( 'tribe_events' ) // single events post
		|| is_tax( 'tribe_events_cat' ) // events category archive
	) {
		rocket_define_donotminify_constants( 'true' );
	}
}
add_action( 'template_redirect', 'wp_rocket_unminify_events_calendar' );

/**
 * Forces DONOTMINIFYCSS for posts containing [tribe_mini_calendar] shortcode.
 * 
 * @param  string $content Post content
 * @return string          Post content
 */
function wp_rocket_unminify_events_calendar__shortcode( $content ) {

	// Make sure WP Rocket and Events plugin are both active.
	if ( ! class_exists( 'Tribe__Events__Main' )
	  || ! function_exists( 'rocket_define_donotminify_constants' ) ) {
		return $content;
	}

	/**
	 * Events shortcode:
	 * @link https://theeventscalendar.com/knowledgebase/inserting-calendar-content-post-page-content/
	 */
	if ( has_shortcode( $content, 'tribe_mini_calendar' ) ) {
		rocket_define_donotminify_constants( 'true' );
	}

	return $content;
}
add_action( 'the_content', 'wp_rocket_unminify_events_calendar__shortcode' );
