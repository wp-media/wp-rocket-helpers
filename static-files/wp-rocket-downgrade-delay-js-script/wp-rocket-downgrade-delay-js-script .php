<?php
/**
 * Plugin Name: WP Rocket | Downgrade Delay JS Execution Script
 * Plugin URI: https://github.com/wp-media/wp-rocket-helpers/tree/master/static-files/wp-rocket-downgrade-delay-js-script/
 * Author:      WP Rocket Support Team
 * Description: Downgrade the Delay JavaScript Execution Feature's Script
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2025
 */

namespace WP_Rocket\Helpers\static_files\downgrade_delay_js_script;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();
 
//For now it is only possible to downgrade to '1.2.6'. Default value is 2.0.3
add_filter( 'rocket_delay_js_version_js_script', function () {
  return '1.2.6';
  });

// Clear all cache on activation
function activate_or_deactivate_helper() {
  // Clear domain cache
  if ( function_exists( 'rocket_clean_domain' ) ) {
    rocket_clean_domain();
  }
}
register_activation_hook(__FILE__, __NAMESPACE__ .'\activate_or_deactivate_helper');
register_deactivation_hook( __FILE__ , __NAMESPACE__ . '\activate_or_deactivate_helper' );