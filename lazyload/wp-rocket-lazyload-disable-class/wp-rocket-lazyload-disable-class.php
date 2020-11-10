<?php
/**
 * Plugin Name: WP Rocket | No LazyLoad for Custom Image Classes
 * Description: Disables LazyLoad for images classes specified in this plugin.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/lazyload/wp-rocket-lazyload-disable-class/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2020
 */

namespace WP_Rocket\Helpers\lazyload\exclude_classes;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude specified image sources from LazyLoad.
 *
 * @author Caspar Hübinger
 *
 * @param  array  $attributes Classes to exclude from LazyLoad
 * @return array  				Extended sources to exclude from LazyLoad
 */
function rocket_lazyload_exclude_class( array $attributes ) {

	// EDIT/REPLACE THESE EXAMPLES:
	// you can add as many classes as you want, one per line.
	// IMPORTANT: The string match is literal, the string assigned to $attributes must exactly match the HTML markup.

	$attributes[] = 'class="divi-slider"';  
	//In above example, the class must be exactly class="divi-slider". If the actual class attribute is class="divi-slider something-else", the exclusion will not work.

	$attributes[] = 'class="some-image-'; 	
	// In the above example, note the missing double quotes at the end. This would exclude all images with a class of some-image-123, some-image-bla-bla, some-image-whatever-else etc. from being lazy-loaded, and it will also include cases where other classes are present: class="some-image-123 other-class and-other-one".

	$attributes[] = 'specific-class-name'; 	
	// You can also target one specific class name using only the name of the class. Any image using that class name will be excluded. it will cover cases like class="some-image-123 other-class specific-class-name and-other-one"


	// STOP EDITING.

	return $attributes;
}
add_filter( 'rocket_lazyload_excluded_attributes', __NAMESPACE__ . '\rocket_lazyload_exclude_class' );
