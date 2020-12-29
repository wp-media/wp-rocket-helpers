<?php
/**
 * Plugin Name: WP Rocket | Add WebP Target Attribute
 * Description: Extends the attributes where WP Rocket does the WebP replacement
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */


// Namespaces must be declared before any other declaration.
namespace WP_Rocket\Helpers\media\webp_attributes;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


/**
 * Extends the attributes where WP Rocket does the WebP replacement.
 *
 * @param array $attributes Array holding the list of attributes to target
 * @author Adame Dahmani
 */


function change_webp_attributes_array($attributes){
	// the default array is ['href', 'src', 'srcset', 'content'];
	$attributes[] = 'data-thumb';
    return $attributes;
}

add_filter( 'rocket_attributes_for_webp', __NAMESPACE__ . '\change_webp_attributes_array' );
