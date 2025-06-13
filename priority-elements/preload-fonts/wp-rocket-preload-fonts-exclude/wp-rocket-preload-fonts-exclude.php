<?php
/**
 * Plugin Name: WP Rocket | Exclude Fonts from Preload Fonts
 * Description: Filter font detection from WP Rocket's Fonts Preload feature using the font name or extension.
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
 * Exclude specific fonts from WP Rocket Fonts preload
 *
 * @param array $exclusions Fonts to exclude (e.g. ['font.woff2', 'OpenSans.woff']).
 * @return array
 */
function wpr_exclude_fonts_from_preload( array $exclusions ): array {
    // START editing — add full or partial font filenames to exclude
    
    //$exclusions[] = 'OpenSans.woff2';

    // END editing
    return $exclusions;
}
add_filter( 'rocket_preload_fonts_excluded_fonts', __NAMESPACE__ . '\wpr_exclude_fonts_from_preload' );


function wpr_filter_font_extensions_from_preload( array $extensions ): array {
    // Use this to remove or add font extensions. By default we detect: 'woff2', 'woff', 'ttf' 
    
    // START editing

    // Remove these
    //$remove[] = 'ttf';
    //$remove[] = 'woff2';

    // Add these
    //$add[] = 'otf';
    //$add[] = 'eot';

    // END editing

    $extensions = array_filter( $extensions, function( $ext ) use ( $remove ) {
        return ! in_array( $ext, $remove, true );
    });

    $extensions = array_merge( $extensions, $add );

    return array_unique( $extensions );
}

add_filter( 'rocket_preload_fonts_processed_extensions', __NAMESPACE__ . '\wpr_filter_font_extensions_from_preload' );