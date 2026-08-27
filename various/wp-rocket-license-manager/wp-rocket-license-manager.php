<?php
/**
 * Plugin Name: WP Rocket - License Manager
 * Description: Safely switch your license email and API Key preserving the current plugin settings.
 * Version: 1.1.8
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * Author: WP Rocket Support Team
 * License: GPL-2.0-or-later
 */

defined( 'ABSPATH' ) || exit;

const WPRLM_CREDENTIALS_OPTION = 'wprlm_credentials';
const WPRLM_PAGE_SLUG          = 'wprlm-license-manager';
const WPRLM_BOOTSTRAP_FILENAME = 'wp-rocket-license-manager-bootstrap.php';
const WPRLM_BOOTSTRAP_MARKER   = 'WP Rocket License Manager bootstrap';

/**
 * Get the bundled and installed bootstrap paths.
 *
 * @return array{source:string,target:string}
 */
function wprlm_get_bootstrap_paths() {
	return [
		'source' => __DIR__ . '/bootstrap/' . WPRLM_BOOTSTRAP_FILENAME,
		'target' => WPMU_PLUGIN_DIR . '/' . WPRLM_BOOTSTRAP_FILENAME,
	];
}

/**
 * Install or refresh the early-loading MU bootstrap.
 *
 * @return true|\WP_Error
 */
function wprlm_install_bootstrap() {
	$paths = wprlm_get_bootstrap_paths();

	if ( ! is_readable( $paths['source'] ) ) {
		return new WP_Error( 'missing_source', 'The bundled MU bootstrap file is missing.' );
	}

	if ( ! is_dir( WPMU_PLUGIN_DIR ) && ! wp_mkdir_p( WPMU_PLUGIN_DIR ) ) {
		return new WP_Error( 'mkdir_failed', 'WordPress could not create the mu-plugins directory.' );
	}

	if ( file_exists( $paths['target'] ) ) {
		$existing = file_get_contents( $paths['target'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

		if ( false === $existing || false === strpos( $existing, WPRLM_BOOTSTRAP_MARKER ) ) {
			return new WP_Error( 'bootstrap_conflict', 'A different file already uses the MU bootstrap filename.' );
		}
	}

	if ( ! copy( $paths['source'], $paths['target'] ) ) { // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_copy
		return new WP_Error( 'copy_failed', 'WordPress could not install the MU bootstrap. Check wp-content/mu-plugins permissions.' );
	}

	return true;
}

/**
 * Report whether the installed bootstrap matches the bundled version.
 *
 * @return string active, missing, outdated, or conflict.
 */
function wprlm_get_bootstrap_status() {
	$paths = wprlm_get_bootstrap_paths();

	if ( ! file_exists( $paths['target'] ) ) {
		return 'missing';
	}

	$existing = file_get_contents( $paths['target'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

	if ( false === $existing || false === strpos( $existing, WPRLM_BOOTSTRAP_MARKER ) ) {
		return 'conflict';
	}

	if ( ! is_readable( $paths['source'] ) || hash_file( 'sha256', $paths['source'] ) !== hash_file( 'sha256', $paths['target'] ) ) {
		return 'outdated';
	}

	return 'active';
}

/**
 * Activate the normal plugin and install its early-loading bootstrap.
 *
 * @return void
 */
function wprlm_activate() {
	$result = wprlm_install_bootstrap();

	if ( is_wp_error( $result ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		wp_die(
			esc_html( $result->get_error_message() ),
			esc_html__( 'WP Rocket - License Manager could not be activated.' ),
			[ 'back_link' => true ]
		);
	}
}
register_activation_hook( __FILE__, 'wprlm_activate' );

/**
 * Refresh a missing or outdated bootstrap after plugin updates.
 *
 * @return void
 */
function wprlm_maybe_repair_bootstrap() {
	if ( ! current_user_can( 'manage_options' ) || 'active' === wprlm_get_bootstrap_status() ) {
		return;
	}

	wprlm_install_bootstrap();
}
add_action( 'admin_init', 'wprlm_maybe_repair_bootstrap' );

/**
 * Remove only the bootstrap file owned by this plugin.
 *
 * @return void
 */
function wprlm_remove_bootstrap() {
	$paths = wprlm_get_bootstrap_paths();

	if ( ! is_readable( $paths['target'] ) ) {
		return;
	}

	$existing = file_get_contents( $paths['target'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

	if ( false !== $existing && false !== strpos( $existing, WPRLM_BOOTSTRAP_MARKER ) ) {
		unlink( $paths['target'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.unlink_unlink
	}
}

/**
 * Deactivation stops early constant loading but preserves validated settings.
 *
 * @return void
 */
function wprlm_deactivate() {
	wprlm_remove_bootstrap();
}
register_deactivation_hook( __FILE__, 'wprlm_deactivate' );

/**
 * Remove helper-owned data during uninstall.
 *
 * @return void
 */
function wprlm_uninstall() {
	wprlm_remove_bootstrap();
	delete_option( WPRLM_CREDENTIALS_OPTION );
}
register_uninstall_hook( __FILE__, 'wprlm_uninstall' );

/**
 * Read credentials saved by this helper plugin.
 *
 * @return array{key:string,email:string}
 */
function wprlm_get_credentials() {
	$credentials = get_option( WPRLM_CREDENTIALS_OPTION, [] );

	if ( ! is_array( $credentials ) ) {
		$credentials = [];
	}

	return [
		'key'   => isset( $credentials['key'] ) && is_string( $credentials['key'] ) ? $credentials['key'] : '',
		'email' => isset( $credentials['email'] ) && is_string( $credentials['email'] ) ? $credentials['email'] : '',
	];
}

/**
 * Detect the credentials WP Rocket currently exposes.
 *
 * WP Rocket's getter is preferred because it accounts for constants and its
 * public option filters. Raw database values are used as a fallback.
 *
 * @return array{key:string,email:string}
 */
function wprlm_get_current_rocket_credentials() {
	$settings = get_option( 'wp_rocket_settings', [] );
	$settings = is_array( $settings ) ? $settings : [];

	$key   = isset( $settings['consumer_key'] ) && is_string( $settings['consumer_key'] ) ? $settings['consumer_key'] : '';
	$email = isset( $settings['consumer_email'] ) && is_string( $settings['consumer_email'] ) ? $settings['consumer_email'] : '';

	if ( function_exists( 'get_rocket_option' ) ) {
		$key   = (string) get_rocket_option( 'consumer_key', $key );
		$email = (string) get_rocket_option( 'consumer_email', $email );
	} else {
		$key   = defined( 'WP_ROCKET_KEY' ) ? (string) WP_ROCKET_KEY : $key;
		$email = defined( 'WP_ROCKET_EMAIL' ) ? (string) WP_ROCKET_EMAIL : $email;
	}

	return [
		'key'   => sanitize_text_field( $key ),
		'email' => sanitize_email( $email ),
	];
}

$wprlm_credentials = wprlm_get_credentials();

// MU plugins load before regular plugins, so these constants exist before
// WP Rocket reads its bundled licence-data.php file.
if ( '' !== $wprlm_credentials['key'] && ! defined( 'WP_ROCKET_KEY' ) ) {
	define( 'WP_ROCKET_KEY', $wprlm_credentials['key'] );
	define( 'WPRLM_OWNS_WP_ROCKET_KEY', true );
}

if ( '' !== $wprlm_credentials['email'] && ! defined( 'WP_ROCKET_EMAIL' ) ) {
	define( 'WP_ROCKET_EMAIL', $wprlm_credentials['email'] );
	define( 'WPRLM_OWNS_WP_ROCKET_EMAIL', true );
}

unset( $wprlm_credentials );

/**
 * Whether this plugin defined the WP Rocket key constant for this request.
 *
 * @return bool
 */
function wprlm_owns_key_constant() {
	return defined( 'WPRLM_OWNS_WP_ROCKET_KEY' ) && WPRLM_OWNS_WP_ROCKET_KEY;
}

/**
 * Whether this plugin defined the WP Rocket email constant for this request.
 *
 * @return bool
 */
function wprlm_owns_email_constant() {
	return defined( 'WPRLM_OWNS_WP_ROCKET_EMAIL' ) && WPRLM_OWNS_WP_ROCKET_EMAIL;
}

/**
 * Add the license manager under Settings.
 *
 * @return void
 */
function wprlm_add_admin_page() {
	add_options_page(
		'WP Rocket - License Manager',
		'WP Rocket License',
		'manage_options',
		WPRLM_PAGE_SLUG,
		'wprlm_render_admin_page'
	);
}
add_action( 'admin_menu', 'wprlm_add_admin_page' );

/**
 * Add the utility at the bottom of WP Rocket's admin-bar dropdown.
 *
 * WP Rocket builds its menu at PHP_INT_MAX - 10. The later priority keeps this
 * entry after WP Rocket's own links, including Support and debugging tools.
 *
 * @param \WP_Admin_Bar $wp_admin_bar WordPress admin-bar instance.
 * @return void
 */
function wprlm_add_rocket_admin_bar_item( $wp_admin_bar ) {
	if (
		! current_user_can( 'manage_options' )
		|| ! is_object( $wp_admin_bar )
		|| ! $wp_admin_bar->get_node( 'wp-rocket' )
	) {
		return;
	}

	$wp_admin_bar->add_menu(
		[
			'parent' => 'wp-rocket',
			'id'     => 'wprlm-license-manager',
			'title'  => 'License Manager',
			'href'   => admin_url( 'options-general.php?page=' . WPRLM_PAGE_SLUG ),
		]
	);
}
add_action( 'admin_bar_menu', 'wprlm_add_rocket_admin_bar_item', PHP_INT_MAX - 1 );

/**
 * Add a direct Settings link on the Plugins screen.
 *
 * @param string[] $links Existing plugin action links.
 * @return string[]
 */
function wprlm_add_plugin_action_links( $links ) {
	array_unshift(
		$links,
		'<a href="' . esc_url( admin_url( 'options-general.php?page=' . WPRLM_PAGE_SLUG ) ) . '">Settings</a>'
	);

	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wprlm_add_plugin_action_links' );

/**
 * Mask a license key for display.
 *
 * @param string $key License key.
 * @return string
 */
function wprlm_mask_key( $key ) {
	$length = strlen( $key );

	if ( 0 === $length ) {
		return 'Not configured';
	}

	if ( $length <= 4 ) {
		return str_repeat( '*', $length );
	}

	return str_repeat( '*', $length - 4 ) . substr( $key, -4 );
}

/**
 * Get and consume the current user's one-time admin notice.
 *
 * @return array{type:string,message:string}|null
 */
function wprlm_get_notice() {
	$key    = 'wprlm_notice_' . get_current_user_id();
	$notice = get_transient( $key );

	delete_transient( $key );

	if ( ! is_array( $notice ) || empty( $notice['message'] ) ) {
		return null;
	}

	return [
		'type'    => isset( $notice['type'] ) && 'success' === $notice['type'] ? 'success' : 'error',
		'message' => (string) $notice['message'],
	];
}

/**
 * Store a one-time admin notice for the current user.
 *
 * @param string $type    Notice type.
 * @param string $message Notice message.
 * @return void
 */
function wprlm_set_notice( $type, $message ) {
	set_transient(
		'wprlm_notice_' . get_current_user_id(),
		[
			'type'    => 'success' === $type ? 'success' : 'error',
			'message' => $message,
		],
		MINUTE_IN_SECONDS
	);
}

/**
 * Render the Settings page.
 *
 * @return void
 */
function wprlm_render_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to manage these settings.' ) );
	}

	$current          = wprlm_get_current_rocket_credentials();
	$notice           = wprlm_get_notice();
	$rocket_available = function_exists( 'rocket_check_key' );
	$bootstrap_status = wprlm_get_bootstrap_status();
	$external_key     = defined( 'WP_ROCKET_KEY' ) && ! wprlm_owns_key_constant();
	$external_email   = defined( 'WP_ROCKET_EMAIL' ) && ! wprlm_owns_email_constant();
	?>
	<div class="wrap">
		<h1>WP Rocket - License Manager</h1>

		<?php if ( $notice ) : ?>
			<div class="notice notice-<?php echo esc_attr( $notice['type'] ); ?> is-dismissible">
				<p style="white-space: pre-line; line-height: 1.6;"><?php echo esc_html( $notice['message'] ); ?></p>
			</div>
		<?php endif; ?>

		<?php if ( ! $rocket_available ) : ?>
			<div class="notice notice-error"><p>WP Rocket is not active or did not finish loading. Credentials cannot be validated.</p></div>
		<?php endif; ?>

		<?php if ( 'active' !== $bootstrap_status ) : ?>
			<div class="notice notice-error"><p>
				The early-loading MU bootstrap is <?php echo esc_html( $bootstrap_status ); ?>. The plugin cannot reliably manage WP Rocket constants until WordPress can write <code><?php echo esc_html( WPMU_PLUGIN_DIR ); ?></code>.
			</p></div>
		<?php endif; ?>

		<?php if ( $external_key || $external_email ) : ?>
			<div class="notice notice-warning"><p>
				WP_ROCKET_KEY or WP_ROCKET_EMAIL is currently defined outside this manager. If it is defined in <code>wp-config.php</code> or another MU plugin, remove that definition before changing credentials here. A bundled WP Rocket <code>licence-data.php</code> file is handled automatically after successful validation.
			</p></div>
		<?php endif; ?>

		<div class="notice notice-info inline" style="max-width: 720px; margin: 20px 0;">
			<p><strong>What this change does</strong></p>
			<ul style="list-style: disc; margin-left: 20px;">
				<li>The new credentials are tested with WP Rocket before anything is saved.</li>
				<li>Only the license credentials change; cache, optimization, exclusion, CDN, and other WP Rocket settings are preserved.</li>
				<li>The change is permanent after successful validation. Deactivating or deleting this helper does not restore the previous account.</li>
				<li>After deactivation, WP Rocket continues using the validated credentials saved in its own database settings.</li>
			</ul>
		</div>

		<h2>Current License Information</h2>
		<table class="widefat striped" style="max-width: 760px; margin: 10px 0 20px;">
			<tbody>
				<tr>
					<th style="width: 220px;">Current WP Rocket API key</th>
					<td><code><?php echo esc_html( wprlm_mask_key( $current['key'] ) ); ?></code></td>
				</tr>
				<tr>
					<th>Current WP Rocket email</th>
					<td><?php echo '' !== $current['email'] ? esc_html( $current['email'] ) : 'Not detected'; ?></td>
				</tr>
			</tbody>
		</table>

		<h2>Change WP Rocket license</h2>
		<p>New credentials are committed only after WP Rocket validates them. If validation fails, the current account and settings remain unchanged.</p>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="max-width: 760px;">
			<input type="hidden" name="action" value="wprlm_update_credentials">
			<?php wp_nonce_field( 'wprlm_update_credentials' ); ?>

			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="wprlm_key">New API key</label></th>
					<td>
						<input name="wprlm_key" id="wprlm_key" type="password" class="regular-text" required autocomplete="new-password">
						<p class="description">Enter the complete WP Rocket API key provided by WP Rocket Support.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="wprlm_email">Account email</label></th>
					<td>
						<input name="wprlm_email" id="wprlm_email" type="email" class="regular-text" value="<?php echo esc_attr( $current['email'] ); ?>" required autocomplete="email">
						<p class="description">
							<?php if ( '' !== $current['email'] ) : ?>
								This is the current WP Rocket account email detected on this site. You can change it to use a different account.
							<?php else : ?>
								No current WP Rocket account email was detected. Enter the email belonging to the new API key.
							<?php endif; ?>
						</p>
					</td>
				</tr>
			</table>

			<?php submit_button( 'Validate and change license', 'primary', 'submit', true, $rocket_available && 'active' === $bootstrap_status ? [] : [ 'disabled' => 'disabled' ] ); ?>
		</form>
	</div>
	<?php
}

/**
 * Redirect back to this plugin's admin page.
 *
 * @return void
 */
function wprlm_redirect_to_page() {
	wp_safe_redirect( admin_url( 'options-general.php?page=' . WPRLM_PAGE_SLUG ) );
	exit;
}

/**
 * Return a readable message from WP Rocket's license error transient.
 *
 * @return string
 */
function wprlm_get_rocket_error_message() {
	$errors = get_transient( 'rocket_check_key_errors' );

	if ( ! is_array( $errors ) || empty( $errors ) ) {
		return 'WP Rocket could not validate those credentials.';
	}

	$errors = array_map(
		static function ( $error ) {
			$error = (string) $error;

			// Repair the malformed empty list item used by some WP Rocket
			// license messages before converting the markup to readable text.
			$error = str_ireplace( '<li></li>', '</li><li>', $error );
			$error = preg_replace( '/<br\s*\/?>/i', "\n", $error );
			$error = preg_replace( '/<li[^>]*>/i', "\n• ", $error );
			$error = preg_replace( '/<\/li>/i', "\n", $error );
			$error = preg_replace( '/<\/?(?:ul|ol|p)[^>]*>/i', "\n", $error );
			$error = wp_strip_all_tags( $error );
			$error = html_entity_decode( $error, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
			$error = preg_replace( '/[ \t]+/', ' ', $error );
			$error = preg_replace( '/ *\n */', "\n", $error );
			$error = preg_replace( '/\n{2,}/', "\n", $error );
			$error = trim( $error );

			// Put WP Rocket's standard error heading on its own line.
			return preg_replace( '/^(License validation failed:)\s*/i', '$1' . "\n\n", $error );
		},
		$errors
	);

	return implode( "\n\n", $errors );
}

/**
 * Determine whether an immutable external constant prevents the requested change.
 *
 * WP Rocket's bundled licence-data.php is safe: WP Rocket deletes it following a
 * successful validation. Constants defined in wp-config.php or another MU plugin
 * cannot be replaced by this plugin.
 *
 * @param string $key   Proposed API key.
 * @param string $email Proposed email address.
 * @return bool
 */
function wprlm_has_blocking_external_constants( $key, $email ) {
	$external_key   = defined( 'WP_ROCKET_KEY' ) && ! wprlm_owns_key_constant();
	$external_email = defined( 'WP_ROCKET_EMAIL' ) && ! wprlm_owns_email_constant();

	if ( ! $external_key && ! $external_email ) {
		return false;
	}

	$key_matches   = ! $external_key || hash_equals( (string) WP_ROCKET_KEY, $key );
	$email_matches = ! $external_email || 0 === strcasecmp( (string) WP_ROCKET_EMAIL, $email );

	if ( $key_matches && $email_matches ) {
		return false;
	}

	$license_file = defined( 'WP_ROCKET_PATH' ) ? WP_ROCKET_PATH . 'licence-data.php' : '';

	return '' === $license_file || ! is_readable( $license_file );
}

/**
 * Save credentials in a non-autoloaded helper option.
 *
 * @param string $key   Validated API key.
 * @param string $email Validated email address.
 * @return bool
 */
function wprlm_store_credentials( $key, $email ) {
	$value = [
		'key'   => $key,
		'email' => $email,
	];
	$old_value = get_option( WPRLM_CREDENTIALS_OPTION, false );

	if ( false === $old_value ) {
		return add_option( WPRLM_CREDENTIALS_OPTION, $value, '', 'no' );
	}

	if ( $old_value === $value ) {
		return true;
	}

	return update_option( WPRLM_CREDENTIALS_OPTION, $value, false );
}

/**
 * Validate and transactionally commit new WP Rocket credentials.
 *
 * @return void
 */
function wprlm_handle_update() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to perform this action.' ) );
	}

	check_admin_referer( 'wprlm_update_credentials' );

	if ( ! function_exists( 'rocket_check_key' ) ) {
		wprlm_set_notice( 'error', 'WP Rocket is not active or its license API is unavailable.' );
		wprlm_redirect_to_page();
	}

	if ( 'active' !== wprlm_get_bootstrap_status() ) {
		wprlm_set_notice( 'error', 'The early-loading MU bootstrap is unavailable. Check the wp-content/mu-plugins directory permissions and try again.' );
		wprlm_redirect_to_page();
	}

	$key   = isset( $_POST['wprlm_key'] ) ? sanitize_text_field( wp_unslash( $_POST['wprlm_key'] ) ) : '';
	$email = isset( $_POST['wprlm_email'] ) ? sanitize_email( wp_unslash( $_POST['wprlm_email'] ) ) : '';

	if ( 8 !== strlen( $key ) || ! is_email( $email ) ) {
		wprlm_set_notice( 'error', 'Enter a valid email address and an 8-character WP Rocket API key.' );
		wprlm_redirect_to_page();
	}

	if ( wprlm_has_blocking_external_constants( $key, $email ) ) {
		wprlm_set_notice( 'error', 'WP_ROCKET_KEY or WP_ROCKET_EMAIL is defined in wp-config.php or another MU plugin. Remove the external definition before changing it here.' );
		wprlm_redirect_to_page();
	}

	$settings = get_option( 'wp_rocket_settings', [] );

	if ( ! is_array( $settings ) ) {
		wprlm_set_notice( 'error', 'The wp_rocket_settings option is not an array, so it cannot be preserved safely.' );
		wprlm_redirect_to_page();
	}

	$key_filter = static function ( $pre, $default ) use ( $key ) {
		return $key;
	};

	$email_filter = static function ( $pre, $default ) use ( $email ) {
		return $email;
	};

	// Force rocket_valid_key() to perform remote validation instead of accepting
	// the secret belonging to the previous account.
	$secret_filter = static function () {
		return '';
	};

	add_filter( 'pre_get_rocket_option_consumer_key', $key_filter, PHP_INT_MAX, 2 );
	add_filter( 'pre_get_rocket_option_consumer_email', $email_filter, PHP_INT_MAX, 2 );
	add_filter( 'pre_get_rocket_option_secret_key', $secret_filter, PHP_INT_MAX, 2 );

	try {
		$result = rocket_check_key();
	} finally {
		remove_filter( 'pre_get_rocket_option_consumer_key', $key_filter, PHP_INT_MAX );
		remove_filter( 'pre_get_rocket_option_consumer_email', $email_filter, PHP_INT_MAX );
		remove_filter( 'pre_get_rocket_option_secret_key', $secret_filter, PHP_INT_MAX );
	}

	// rocket_check_key() uses this transient to merge license fields into WP
	// Rocket's own form submission. This request performs an explicit safe merge.
	delete_transient( 'wp_rocket_settings' );

	if (
		! is_array( $result )
		|| empty( $result['secret_key'] )
		|| empty( $result['consumer_key'] )
		|| empty( $result['consumer_email'] )
		|| ! hash_equals( $key, (string) $result['consumer_key'] )
		|| 0 !== strcasecmp( $email, (string) $result['consumer_email'] )
	) {
		wprlm_set_notice( 'error', wprlm_get_rocket_error_message() );
		wprlm_redirect_to_page();
	}

	$allowed_license_fields = [
		'consumer_key'   => true,
		'consumer_email' => true,
		'secret_key'     => true,
		'license'        => true,
	];
	$license_fields         = array_intersect_key( $result, $allowed_license_fields );
	$updated_settings       = array_replace( $settings, $license_fields );

	// The constants still contain the previous credentials until the next
	// request. Keep the validated values visible while WP Rocket runs its
	// update_option callbacks (config generation, license checks, and so on).
	add_filter( 'pre_get_rocket_option_consumer_key', $key_filter, PHP_INT_MAX, 2 );
	add_filter( 'pre_get_rocket_option_consumer_email', $email_filter, PHP_INT_MAX, 2 );

	try {
		update_option( 'wp_rocket_settings', $updated_settings );
	} finally {
		remove_filter( 'pre_get_rocket_option_consumer_key', $key_filter, PHP_INT_MAX );
		remove_filter( 'pre_get_rocket_option_consumer_email', $email_filter, PHP_INT_MAX );
	}

	if ( ! wprlm_store_credentials( (string) $result['consumer_key'], (string) $result['consumer_email'] ) ) {
		// Do not leave WP Rocket and the MU-plugin bootstrap on different
		// credentials if the helper option could not be written.
		delete_transient( 'wp_rocket_settings' );
		update_option( 'wp_rocket_settings', $settings );
		wprlm_set_notice( 'error', 'The license was valid, but the helper credentials could not be saved. The previous WP Rocket settings were restored.' );
		wprlm_redirect_to_page();
	}

	wprlm_set_notice( 'success', 'The WP Rocket license was validated and changed. Existing WP Rocket settings were preserved.' );
	wprlm_redirect_to_page();
}
add_action( 'admin_post_wprlm_update_credentials', 'wprlm_handle_update' );
