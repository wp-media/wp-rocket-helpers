<?php

/**
 * Plugin Name: WP Rocket | Change Expires
 * Description: Change browser cache expires set by WP Rocket
 * Plugin URI:  
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\htaccess\change_expires;

// Standard plugin security, keep this line in place.
defined('ABSPATH') or die();

/**
 * Replaces the browser caching values
 *
 * @author Vasilis Manthos
 *
 */
function rocket_change_expires($rules)
{
	$rules_to_replace = array(
		'ExpiresByType text/html                     "access plus 0 seconds"' => 'ExpiresByType text/html                     "access plus 600 seconds"', // sample / old rule => new rule / Duplicate as needed
	);
	foreach ($rules_to_replace as $old_rule => $new_rule) {
		$rules = str_replace($old_rule, $new_rule, $rules);
	}
	return $rules;
}
add_filter('rocket_htaccess_mod_expires', __NAMESPACE__ . '\rocket_change_expires');

/**
 * Updates .htaccess, regenerates WP Rocket config file.
 *
 * @author Caspar Hübinger
 */
function flush_wp_rocket()
{

	if (
		!function_exists('flush_rocket_htaccess')
		|| !function_exists('rocket_generate_config_file')
	) {
		return false;
	}

	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();
}
register_activation_hook(__FILE__, __NAMESPACE__ . '\flush_wp_rocket');

/**
 * Removes customizations, updates .htaccess, regenerates config file.
 *
 * @author Caspar Hübinger
 */
function deactivate()
{

	// Remove all functionality added above. Please remove the correct filter.
	remove_filter('rocket_htaccess_mod_expires', __NAMESPACE__ . '\rocket_change_expires');

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook(__FILE__, __NAMESPACE__ . '\deactivate');
