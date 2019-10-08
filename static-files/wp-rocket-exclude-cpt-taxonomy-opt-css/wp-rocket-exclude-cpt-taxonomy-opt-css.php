<?php
/**
 * Plugin Name: WP Rocket | Exclude Post Types and Taxonomies from CPCSS generation
 * Description: Exclude Post Types and Taxonomies from the Optimize CSS Delivery feature
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */


// Namespaces must be declared before any other declaration.
namespace WP_Rocket\Helpers\static_files\exclude\optimized_css_cpt_taxonomy;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude Post Types from the Optimize CSS Delivery feature
 *
 * @author Vasilis Manthos
 */
function wp_rocket_exclude_CPCSS_CPT( $excluded_CPT ){
	
	// EDIT: add the name of the post type here. Duplicate this line to exlude more post types.
	$excluded_CPT[] = 'post_type_to_exlude';
	
	return $excluded_CPT;
}

add_filter( 'rocket_cpcss_excluded_post_types',  __NAMESPACE__ . '\wp_rocket_exclude_CPCSS_CPT');

/**
 * Exclude taxonomies from the Optimize CSS Delivery feature
 *
 * @author Vasilis Manthos
 */
function wp_rocket_exclude_CPCSS_taxonomies( $excluded_taxonomies ){

	// EDIT: add the name of the taxonomy to exlude here. Duplicate this line to exlude more taxonomies.
	$excluded_taxonomies[] = 'taxonomy_to_exlude';
	
	return $excluded_taxonomies;
}

add_filter( 'rocket_cpcss_excluded_taxonomies',  __NAMESPACE__ . '\wp_rocket_exclude_CPCSS_taxonomies');
