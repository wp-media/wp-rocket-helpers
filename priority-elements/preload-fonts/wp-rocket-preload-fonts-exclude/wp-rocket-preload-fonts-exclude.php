<?php
/**
 * Plugin Name: WP Rocket | Exclude Fonts from Preload Fonts
 * Description: Exclude specific fonts from WP Rocket's Fonts Preload feature using the `rocket_preload_fonts_excluded_fonts` filter.
 * Author:      WP Rocket Support Team
 * Author URI:  https://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2025
 */

namespace WP_Rocket\Helpers\exclude_fonts_preload;

// Standard plugin security
defined( 'ABSPATH' ) or die();

/**
 * Exclude specific fonts from WP Rocket preload
 *
 * @param array $exclusions Fonts to exclude (e.g. ['font.woff2', 'OpenSans.woff']).
 * @return array
 */
function wpr_exclude_fonts_from_preload( array $exclusions ): array {
    // START editing — add full or partial font filenames to exclude
    
    //$exclusions[] = 'OpenSans.woff2';
    //$exclusions[] = 'my-font-subset.woff';

    // END editing
    return $exclusions;
}

add_filter( 'rocket_preload_fonts_excluded_fonts', __NAMESPACE__ . '\wpr_exclude_fonts_from_preload' );
