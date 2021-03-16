<?php
/**
 * Plugin Name: WP Rocket | Change CPCSS sample URLs
 * Description: Change CPCSS URL we use to build CPCSS for each post type.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/static/wp-rocket-static-wp-rocket-static-change-cpcss-sample-urls/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\static_files\change\optimized_css;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude scripts from WP Rocket’s asnyc CSS option.
 *
 * @author Adame Dahmani
 * @param  array  $items   Array containing the type/url pair for each item to send
 * @return array           Array containing the type/url pair for each item to send
 */

function cpcss_urls_to_change_per_posttype( $items ) {
    $items['post']['url'] = 'https://domain.ext/slug/';
    $items['page']['url'] = 'https://domain.ext/slug/';
    return $items;
}

add_filter( 'rocket_cpcss_items',  __NAMESPACE__ . '\cpcss_urls_to_change_per_posttype' );