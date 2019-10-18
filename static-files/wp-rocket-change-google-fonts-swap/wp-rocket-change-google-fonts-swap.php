<?php
/**
 * Plugin Name: WP Rocket | Change Google fonts display attribute
 * Description: Changes Google fonts' "display" attribute
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */


// Namespaces must be declared before any other declaration.
namespace WP_Rocket\Helpers\static_files\disable_google_fonts_swap;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


/**
 * Possible values: auto, block, fallback, optional
 *
 * @link: https://developers.google.com/web/updates/2016/02/font-display?utm_source=lighthouse&utm_medium=unknown#which_font-display_is_right_for_you
*/
// EDIT THIS:

define( 'WPROCKETHELPERS_CHANGE_DISPLAY_VALUE', 'swap' );

// STOP EDITING


/**
 * Change the value of the display attibute WP Rocket sets for the "Combine Google fonts" feature
 *
 * @link filter: https://github.com/wp-media/wp-rocket/blob/389f7462cd9cc8424ab0b3ab88acea4db6884cd9/inc/classes/optimization/CSS/class-combine-google-fonts.php#L153-L163
 * @author Vasilis Manthos
 */
 
 function rocket_change_display_value( $display ){
	 
	 return $display = WPROCKETHELPERS_CHANGE_DISPLAY_VALUE;
	 
 }
 
add_filter( 'rocket_combined_google_fonts_display', __NAMESPACE__ . '\rocket_change_display_value');


