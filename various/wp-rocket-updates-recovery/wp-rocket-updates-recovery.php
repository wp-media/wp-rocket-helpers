<?php
/**
 * Plugin Name: WP Rocket - Updates Recovery
 * Description: Recovers licensed WP Rocket updates when WP Rocket is inactive, newly installed, or paused by Recovery Mode.
 * Version: 1.4.1
 * Author: WP Rocket Support Team
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WP_Rocket_Updates_Recovery', false ) ) {
	final class WP_Rocket_Updates_Recovery {
		const EXPECTED_PLUGIN_FILE = 'wp-rocket/wp-rocket.php';
		const LICENSE_FILE     = 'licence-data.php';
		const SETTINGS_OPTION  = 'wp_rocket_settings';
		const API_HOST          = 'api.wp-rocket.me';
		const UPDATE_ENDPOINT  = 'https://api.wp-rocket.me/check_update.php';
		const CACHE_TRANSIENT   = 'wp_rocket_updates_recovery_data';
		const FORCE_QUERY_PARAM = 'rocket_force_update';

		/**
		 * Remote response cached for the current request.
		 *
		 * @var stdClass|WP_Error|null
		 */
		private static $request_cache;

		/**
		 * Register Updates Recovery independently from WP Rocket.
		 */
		public static function bootstrap() {
			add_filter( 'http_request_args', array( __CLASS__, 'maybe_add_rocket_user_agent' ), 10, 2 );
			add_filter( 'pre_set_site_transient_update_plugins', array( __CLASS__, 'add_update' ), 20 );
			add_filter( 'site_transient_update_plugins', array( __CLASS__, 'add_update' ), 20 );
			add_filter( 'plugin_row_meta', array( __CLASS__, 'add_check_updates_link' ), 20, 2 );
			add_action( 'deleted_site_transient', array( __CLASS__, 'maybe_clear_cache' ) );
			add_action( 'admin_init', array( __CLASS__, 'maybe_force_update_check' ), 1 );
			add_action( 'admin_init', array( __CLASS__, 'maybe_redirect_after_activation' ), 2 );
			add_action( 'admin_notices', array( __CLASS__, 'display_folder_notice' ) );
			add_action( 'admin_post_wp_rocket_updates_recovery_restore_folder', array( __CLASS__, 'restore_folder_name' ) );
		}

		/**
		 * Authenticate both update checks and package downloads from WP Rocket's API.
		 *
		 * WordPress downloads the update package in a separate HTTP request. That
		 * request must carry the same customer information as the version check or
		 * the downloaded response may not be a valid ZIP archive.
		 *
		 * @param array  $request HTTP request arguments.
		 * @param string $url     Request URL.
		 * @return array
		 */
		public static function maybe_add_rocket_user_agent( $request, $url ) {
			if ( self::wp_rocket_is_loaded() || ! is_string( $url ) ) {
				return $request;
			}

			$host = wp_parse_url( $url, PHP_URL_HOST );
			if ( self::API_HOST !== strtolower( (string) $host ) ) {
				return $request;
			}

			$current_user_agent    = isset( $request['user-agent'] ) ? (string) $request['user-agent'] : '';
			$request['user-agent'] = sprintf( '%s;%s', $current_user_agent, self::get_rocket_user_agent() );

			return $request;
		}

		/**
		 * Remember that the activating administrator should run an immediate check.
		 */
		public static function activate() {
			$user_id = get_current_user_id();

			if ( $user_id ) {
				set_transient( self::get_activation_transient_name( $user_id ), 1, MINUTE_IN_SECONDS );
			}
		}

		/**
		 * Redirect once after activation so Updates Recovery is tested immediately.
		 */
		public static function maybe_redirect_after_activation() {
			if ( ! current_user_can( 'update_plugins' ) || wp_doing_ajax() ) {
				return;
			}

			$user_id        = get_current_user_id();
			$transient_name = self::get_activation_transient_name( $user_id );

			if ( ! $user_id || ! get_transient( $transient_name ) ) {
				return;
			}

			delete_transient( $transient_name );

			wp_safe_redirect(
				add_query_arg( self::FORCE_QUERY_PARAM, '1', self_admin_url( 'plugins.php' ) )
			);
			exit;
		}

		/**
		 * Add a manual check to the end of WP Rocket's metadata row.
		 *
		 * @param array  $plugin_meta Plugin metadata links.
		 * @param string $plugin_file Plugin basename.
		 * @return array
		 */
		public static function add_check_updates_link( $plugin_meta, $plugin_file ) {
			if ( self::get_wp_rocket_plugin_file() !== $plugin_file ) {
				return $plugin_meta;
			}

			$plugin_meta['wp-rocket-updates-recovery-check'] = sprintf(
				'<a href="%s"><strong><span class="dashicons dashicons-update" aria-hidden="true"></span> %s</strong></a>',
				esc_url( add_query_arg( self::FORCE_QUERY_PARAM, '1', self_admin_url( 'plugins.php' ) ) ),
				esc_html__( 'Check Available Updates Now', 'wp-rocket-updates-recovery' )
			);

			return $plugin_meta;
		}

		/**
		 * Warn when WP Rocket was deactivated by renaming its plugin folder.
		 */
		public static function display_folder_notice() {
			global $pagenow;

			if ( 'plugins.php' !== $pagenow || ! current_user_can( 'update_plugins' ) ) {
				return;
			}

			$result = isset( $_GET['wp_rocket_updates_recovery_folder'] ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				? sanitize_key( wp_unslash( $_GET['wp_rocket_updates_recovery_folder'] ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				: '';

			if ( 'restored' === $result ) {
				echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'WP Rocket\'s plugin folder was restored to wp-rocket.', 'wp-rocket-updates-recovery' ) . '</p></div>';
				return;
			}

			$error_messages = array(
				'destination_exists' => __( 'The wp-rocket destination folder already exists, so the renamed folder was not moved.', 'wp-rocket-updates-recovery' ),
				'invalid_source'      => __( 'The detected WP Rocket folder is not a safe direct child of the plugins directory.', 'wp-rocket-updates-recovery' ),
				'move_failed'         => __( 'WordPress could not rename the WP Rocket folder. Check filesystem permissions.', 'wp-rocket-updates-recovery' ),
				'not_found'           => __( 'WP Rocket could no longer be found.', 'wp-rocket-updates-recovery' ),
				'plugin_active'       => __( 'WP Rocket must be inactive before its folder can be restored.', 'wp-rocket-updates-recovery' ),
			);

			if ( isset( $error_messages[ $result ] ) ) {
				echo '<div class="notice notice-error"><p>' . esc_html( $error_messages[ $result ] ) . '</p></div>';
			}

			$plugin_file = self::get_wp_rocket_plugin_file();
			if ( ! $plugin_file ) {
				return;
			}

			$current_folder = dirname( $plugin_file );
			if ( 'wp-rocket' === $current_folder ) {
				return;
			}

			if ( ! function_exists( 'is_plugin_active' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$plugin_active = is_plugin_active( $plugin_file ) || ( is_multisite() && is_plugin_active_for_network( $plugin_file ) );

			$restore_url = wp_nonce_url(
				self_admin_url( 'admin-post.php?action=wp_rocket_updates_recovery_restore_folder' ),
				'wp_rocket_updates_recovery_restore_folder'
			);

			echo '<div class="notice notice-error"><p>';
			echo '<strong>' . esc_html__( 'WP Rocket folder renamed:', 'wp-rocket-updates-recovery' ) . '</strong> ';
			echo esc_html(
				sprintf(
					/* translators: %s is the detected plugin folder name. */
					__( 'WP Rocket was found in “%s” instead of “wp-rocket”.', 'wp-rocket-updates-recovery' ),
					$current_folder
				)
			);
			if ( $plugin_active ) {
				echo ' <strong>' . esc_html__( 'Deactivate WP Rocket before restoring its folder name.', 'wp-rocket-updates-recovery' ) . '</strong>';
			} else {
				echo ' <a class="button button-primary" href="' . esc_url( $restore_url ) . '">' . esc_html__( 'Restore folder name', 'wp-rocket-updates-recovery' ) . '</a>';
			}
			echo '</p></div>';
		}

		/**
		 * Restore the expected folder name of an inactive WP Rocket installation.
		 */
		public static function restore_folder_name() {
			if ( ! current_user_can( 'update_plugins' ) ) {
				wp_die( esc_html__( 'You are not allowed to update plugins.', 'wp-rocket-updates-recovery' ) );
			}

			check_admin_referer( 'wp_rocket_updates_recovery_restore_folder' );

			$plugin_file = self::get_wp_rocket_plugin_file();
			if ( ! $plugin_file ) {
				self::redirect_folder_result( 'not_found' );
			}

			$current_folder = dirname( $plugin_file );
			if ( 'wp-rocket' === $current_folder ) {
				self::redirect_folder_result( 'restored', true );
			}

			$plugins_root = realpath( WP_PLUGIN_DIR );
			$source       = realpath( WP_PLUGIN_DIR . '/' . $current_folder );

			if ( ! $plugins_root || ! $source || dirname( $source ) !== $plugins_root ) {
				self::redirect_folder_result( 'invalid_source' );
			}

			$destination = $plugins_root . '/wp-rocket';
			if ( file_exists( $destination ) ) {
				self::redirect_folder_result( 'destination_exists' );
			}

			if ( ! function_exists( 'is_plugin_active' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			if ( is_plugin_active( $plugin_file ) || ( is_multisite() && is_plugin_active_for_network( $plugin_file ) ) ) {
				self::redirect_folder_result( 'plugin_active' );
			}

			if ( ! rename( $source, $destination ) ) {
				self::redirect_folder_result( 'move_failed' );
			}

			delete_site_transient( self::CACHE_TRANSIENT );
			delete_site_transient( 'update_plugins' );
			self::redirect_folder_result( 'restored', true );
		}

		/**
		 * Add WP Rocket's vendor-provided update offer to WordPress update data.
		 *
		 * @param mixed $updates Current update transient value.
		 * @return mixed
		 */
		public static function add_update( $updates ) {
			if ( self::wp_rocket_is_loaded() || ! self::wp_rocket_is_installed() ) {
				return $updates;
			}

			$plugin_file = self::get_wp_rocket_plugin_file();
			if ( ! $plugin_file ) {
				return $updates;
			}

			$installed_version = self::get_installed_version();
			if ( '' === $installed_version ) {
				return $updates;
			}

			$remote_data = self::get_remote_data();
			if ( is_wp_error( $remote_data ) ) {
				return $updates;
			}

			if ( ! is_object( $updates ) ) {
				$updates = new stdClass();
			}

			if ( ! isset( $updates->response ) || ! is_array( $updates->response ) ) {
				$updates->response = array();
			}

			if ( ! isset( $updates->checked ) || ! is_array( $updates->checked ) ) {
				$updates->checked = array();
			}

			if ( version_compare( $installed_version, $remote_data->new_version, '<' ) ) {
				$updates->response[ $plugin_file ] = $remote_data;
			} else {
				// Remove an update offer that may have been cached before the latest check.
				unset( $updates->response[ $plugin_file ] );
			}

			$updates->checked[ $plugin_file ] = $installed_version;

			return $updates;
		}

		/**
		 * Clear the recovery cache whenever WordPress clears its plugin update cache.
		 *
		 * @param string $transient Deleted site transient name.
		 */
		public static function maybe_clear_cache( $transient ) {
			if ( 'update_plugins' === $transient ) {
				delete_site_transient( self::CACHE_TRANSIENT );
				self::$request_cache = null;
			}
		}

		/**
		 * Support the same manual refresh URL used by WP Rocket.
		 */
		public static function maybe_force_update_check() {
			if ( self::wp_rocket_is_loaded() || ! current_user_can( 'update_plugins' ) ) {
				return;
			}

			if ( ! isset( $_GET[ self::FORCE_QUERY_PARAM ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				return;
			}

			delete_site_transient( self::CACHE_TRANSIENT );
			delete_site_transient( 'update_plugins' );
			self::$request_cache = null;
		}

		/**
		 * Return update data from cache or WP Rocket's update API.
		 *
		 * @return stdClass|WP_Error
		 */
		private static function get_remote_data() {
			if ( null !== self::$request_cache ) {
				return self::$request_cache;
			}

			$force_update = is_admin()
				&& current_user_can( 'update_plugins' )
				&& isset( $_GET[ self::FORCE_QUERY_PARAM ] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

			if ( ! $force_update ) {
				$cached = get_site_transient( self::CACHE_TRANSIENT );
				if ( is_object( $cached ) ) {
					self::$request_cache = $cached;
					return self::$request_cache;
				}
			}

			self::$request_cache = self::request_remote_data();
			$cache_duration      = 12 * HOUR_IN_SECONDS;

			if ( is_wp_error( self::$request_cache ) ) {
				$error_data = self::$request_cache->get_error_data();
				if ( isset( $error_data['transport_error'] ) ) {
					$cache_duration = HOUR_IN_SECONDS;
				} elseif ( isset( $error_data['http_code'] ) && $error_data['http_code'] >= 400 ) {
					$cache_duration = 2 * HOUR_IN_SECONDS;
				}
			}

			set_site_transient( self::CACHE_TRANSIENT, self::$request_cache, $cache_duration );

			return self::$request_cache;
		}

		/**
		 * Contact WP Rocket's licensing/update endpoint.
		 *
		 * @return stdClass|WP_Error
		 */
		private static function request_remote_data() {
			$response = wp_remote_get(
				self::UPDATE_ENDPOINT,
				array(
					'timeout' => 30,
				)
			);

			if ( is_wp_error( $response ) ) {
				return new WP_Error(
					'wp_rocket_updates_recovery_transport_error',
					$response->get_error_message(),
					array( 'transport_error' => $response->get_error_code() )
				);
			}

			$body = trim( wp_remote_retrieve_body( $response ) );
			$code = wp_remote_retrieve_response_code( $response );

			if ( 200 !== $code ) {
				return new WP_Error(
					'wp_rocket_updates_recovery_http_error',
					'WP Rocket update API returned an unexpected HTTP status.',
					array( 'http_code' => $code )
				);
			}

			if ( ! preg_match( '@^(?<stable_version>\d+(?:\.\d+){1,3}[^|]*)\|(?<package>(?:http.+\.zip)?)\|(?<user_version>\d+(?:\.\d+){1,3}[^|]*)(?:\|+)?$@', $body, $matches ) ) {
				return new WP_Error( 'wp_rocket_updates_recovery_invalid_response', 'WP Rocket update API returned an invalid response.' );
			}

			$data                 = new stdClass();
			$data->slug           = 'wp-rocket';
			$data->plugin         = self::get_wp_rocket_plugin_file();
			$data->new_version    = $matches['user_version'];
			$data->stable_version = $matches['stable_version'];
			$data->url            = 'https://wp-rocket.me/';
			$data->package        = $matches['package'];

			return $data;
		}

		/**
		 * Build the license-bearing User-Agent fragment expected by WP Rocket's API.
		 *
		 * @return string
		 */
		private static function get_rocket_user_agent() {
			$credentials  = self::get_license_credentials();
			$php_version = preg_replace( '@^(\d+\.\d+).*@', '$1', PHP_VERSION );

			$user_agent = sprintf(
				'WP-Rocket|%s|%s|%s|%s|%s;',
				self::get_installed_version(),
				$credentials['consumer_key'],
				$credentials['consumer_email'],
				home_url(),
				$php_version
			);

			// Never allow stored values to inject additional HTTP headers.
			return preg_replace( '/[\r\n]+/', '', $user_agent );
		}

		/**
		 * Get license credentials without loading any WP Rocket PHP file.
		 *
		 * Constants and saved settings take precedence. A newly downloaded copy of
		 * WP Rocket can instead provide the values in its generated licence-data.php.
		 *
		 * @return array
		 */
		private static function get_license_credentials() {
			$options = get_option( self::SETTINGS_OPTION, array() );
			$options = is_array( $options ) ? $options : array();

			$credentials = array(
				'consumer_key'   => defined( 'WP_ROCKET_KEY' ) ? (string) WP_ROCKET_KEY : ( isset( $options['consumer_key'] ) ? (string) $options['consumer_key'] : '' ),
				'consumer_email' => defined( 'WP_ROCKET_EMAIL' ) ? (string) WP_ROCKET_EMAIL : ( isset( $options['consumer_email'] ) ? (string) $options['consumer_email'] : '' ),
			);

			if ( '' === $credentials['consumer_key'] || '' === $credentials['consumer_email'] ) {
				$file_credentials = self::get_license_file_credentials();

				foreach ( $credentials as $name => $value ) {
					if ( '' === $value && isset( $file_credentials[ $name ] ) ) {
						$credentials[ $name ] = $file_credentials[ $name ];
					}
				}
			}

			return $credentials;
		}

		/**
		 * Extract generated credentials from licence-data.php without executing it.
		 *
		 * Only literal string values assigned to the two expected constants are
		 * accepted. Nothing else in the file is evaluated.
		 *
		 * @return array
		 */
		private static function get_license_file_credentials() {
			$wp_rocket_path = self::get_wp_rocket_path();
			if ( ! $wp_rocket_path ) {
				return array();
			}

			$license_file = dirname( $wp_rocket_path ) . '/' . self::LICENSE_FILE;

			if ( ! is_readable( $license_file ) ) {
				return array();
			}

			$contents = file_get_contents( $license_file );
			if ( false === $contents ) {
				return array();
			}

			$constants = array(
				'consumer_key'   => 'WP_ROCKET_KEY',
				'consumer_email' => 'WP_ROCKET_EMAIL',
			);
			$credentials = array();

			foreach ( $constants as $name => $constant ) {
				$pattern = '/define\s*\(\s*[\'\"]' . preg_quote( $constant, '/' ) . '[\'\"]\s*,\s*[\'\"]([^\'\"]+)[\'\"]\s*\)\s*;/i';

				if ( preg_match( $pattern, $contents, $match ) ) {
					$credentials[ $name ] = trim( $match[1] );
				}
			}

			return $credentials;
		}

		/**
		 * Return to the Plugins screen after attempting a folder restoration.
		 *
		 * @param string $result       Result code displayed as an admin notice.
		 * @param bool   $force_update Whether to run a fresh update check.
		 */
		private static function redirect_folder_result( $result, $force_update = false ) {
			$query_args = array(
				'wp_rocket_updates_recovery_folder' => $result,
			);

			if ( $force_update ) {
				$query_args[ self::FORCE_QUERY_PARAM ] = '1';
			}

			wp_safe_redirect( add_query_arg( $query_args, self_admin_url( 'plugins.php' ) ) );
			exit;
		}

		/**
		 * Return the current administrator's activation redirect transient name.
		 *
		 * @param int $user_id WordPress user ID.
		 * @return string
		 */
		private static function get_activation_transient_name( $user_id ) {
			return 'wp_rocket_updates_recovery_activation_redirect_' . absint( $user_id );
		}

		/**
		 * Read the plugin version without executing WP Rocket.
		 *
		 * @return string
		 */
		private static function get_installed_version() {
			static $version;

			if ( null !== $version ) {
				return $version;
			}

			$wp_rocket_path = self::get_wp_rocket_path();
			if ( ! $wp_rocket_path ) {
				$version = '';
				return $version;
			}

			$data    = get_file_data( $wp_rocket_path, array( 'Version' => 'Version' ), 'plugin' );
			$version = isset( $data['Version'] ) ? trim( $data['Version'] ) : '';

			return $version;
		}

		/**
		 * Determine whether WP Rocket completed enough of its bootstrap to own updates.
		 *
		 * @return bool
		 */
		private static function wp_rocket_is_loaded() {
			return defined( 'WP_ROCKET_VERSION' );
		}

		/**
		 * Determine whether WP Rocket exists on disk.
		 *
		 * @return bool
		 */
		private static function wp_rocket_is_installed() {
			return false !== self::get_wp_rocket_plugin_file();
		}

		/**
		 * Find WP Rocket by its plugin header, even if its folder was renamed.
		 *
		 * @return string|false Plugin basename, or false when it cannot be identified.
		 */
		private static function get_wp_rocket_plugin_file() {
			static $resolved = false;
			static $plugin_file;

			if ( $resolved ) {
				return $plugin_file;
			}

			$resolved      = true;
			$expected_path = WP_PLUGIN_DIR . '/' . self::EXPECTED_PLUGIN_FILE;

			if ( is_readable( $expected_path ) ) {
				$plugin_file = self::EXPECTED_PLUGIN_FILE;
				return $plugin_file;
			}

			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$matches = array();
			foreach ( get_plugins() as $candidate => $data ) {
				if ( 'WP Rocket' === $data['Name'] && 'wp-rocket.php' === basename( $candidate ) ) {
					$matches[] = $candidate;
				}
			}

			$plugin_file = 1 === count( $matches ) ? reset( $matches ) : false;

			return $plugin_file;
		}

		/**
		 * Return WP Rocket's detected main plugin path.
		 *
		 * @return string|false
		 */
		private static function get_wp_rocket_path() {
			$plugin_file = self::get_wp_rocket_plugin_file();

			return $plugin_file ? WP_PLUGIN_DIR . '/' . $plugin_file : false;
		}
	}

	WP_Rocket_Updates_Recovery::bootstrap();
	register_activation_hook( __FILE__, array( 'WP_Rocket_Updates_Recovery', 'activate' ) );
}
