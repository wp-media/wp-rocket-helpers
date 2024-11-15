<?php
/**
 * Plugin Name: WP Rocket | Export WP Rocket Settings
 * Description: Allows you to export WP Rocket settings when WP Rocket cannot be activated.
 * Plugin URI:  https://docs.wp-rocket.me/article/1137-tools-tab-export-import-settings-and-version-rollback#tip-no-access
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\export_wprocket_settings;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

function wprocket_export_settings_admin_menu_item() {

  add_management_page(
    __( 'Export WP Rocket Settings', 'wprocket_export_settings_domain' ),
    __( 'Export WP Rocket Settings', 'wprocket_export_settings_domain' ),
    'manage_options',
    'export-wprocket-settings',
    __NAMESPACE__ . '\render_wprocket_export_page'
  );
}
add_action( 'admin_menu', __NAMESPACE__ . '\wprocket_export_settings_admin_menu_item' );

// Display the admin page content with a form to trigger export.
function render_wprocket_export_page() {
  ?>
  <div class="wrap">
    <h1><?php esc_html_e( 'Export WP Rocket Settings', 'wprocket_export_settings_domain' ); ?></h1>
    <p style="margin-top:40px;"><?php esc_html_e( 'Click the button below to export your WP Rocket settings.', 'wprocket_export_settings_domain' ); ?></p>
    <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
      <input type="hidden" name="action" value="wprocket_download_settings">
      <?php submit_button( __( 'Download WP Rocket Settings', 'wprocket_export_settings_domain' ) ); ?>
    </form>
  </div>
  <?php
}

// Export WP Rocket settings when button is clicked
function wprocket_handle_download_settings() {

  if ( ! current_user_can( 'manage_options' ) ) {
    wp_die( __( 'You do not have sufficient permissions to access this action.', 'wprocket_export_settings_domain' ) );
  }

  $settings = get_option( 'wp_rocket_settings' );

  if ( ! $settings ) {
    wp_die( __( 'No WP Rocket settings found to export.', 'wprocket_export_settings_domain' ) );
  }

  // Generate the filename.
  $domain_name = str_replace( '/', '_', parse_url( get_home_url(), PHP_URL_HOST ) );
  $domain_name = is_string( $domain_name ) ? '-' . $domain_name : '';
  $filename = sprintf(
    'wp-rocket-settings%s-%s-%s.json',
    $domain_name,
    date( 'Y-m-d' ),
    uniqid()
  );

  // Set headers and output the JSON.
  header( 'Content-Type: application/json' );
  header( 'Content-Disposition: attachment; filename=' . $filename );
  echo wp_json_encode( $settings, JSON_PRETTY_PRINT );

  exit;
}
add_action( 'admin_post_wprocket_download_settings', __NAMESPACE__ . '\wprocket_handle_download_settings' );