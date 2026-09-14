<?php
/**
 * Plugin Name: WP Rocket - Update Notification Recovery
 * Description: Recovers WP Rocket update notifications and licensed downloads on single-site and Multisite installations.
 * Version: 1.6.0
 * Author: WP Rocket Support Team
 * Network: true
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WP_Rocket_Update_Notification_Recovery', false ) ) {
	final class WP_Rocket_Update_Notification_Recovery {
		const EXPECTED_PLUGIN_FILE = 'wp-rocket/wp-rocket.php';
		const LICENSE_FILE     = 'licence-data.php';
		const SETTINGS_OPTION  = 'wp_rocket_settings';
		const API_HOST          = 'api.wp-rocket.me';
		const UPDATE_ENDPOINT  = 'https://api.wp-rocket.me/check_update.php';
		const CACHE_TRANSIENT   = 'wp_rocket_update_notification_recovery_data';
		const CONTEXT_TRANSIENT = 'wp_rocket_update_notification_recovery_context';
		const FORCE_QUERY_PARAM = 'rocket_force_update';

		/**
		 * Remote response cached for the current request.
		 *
		 * @var stdClass|WP_Error|null
		 */
		private static $request_cache;

		/**
		 * Site context used by the HTTP request currently in progress.
		 *
		 * @var array|null
		 */
		private static $http_context;

		/**
		 * Cached IDs for sites in the current network.
		 *
		 * @var int[]|null
		 */
		private static $network_site_ids;

		/**
		 * Register Update Notification Recovery independently from WP Rocket.
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
			add_action( 'network_admin_notices', array( __CLASS__, 'display_folder_notice' ) );
			add_action( 'admin_post_wp_rocket_update_notification_recovery_restore_folder', array( __CLASS__, 'restore_folder_name' ) );
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

			$context = self::$http_context;
			if ( ! is_array( $context ) ) {
				$context = self::get_saved_update_context();
			}

			if ( ! is_array( $context ) ) {
				$contexts = self::get_update_contexts();
				$context  = $contexts ? reset( $contexts ) : null;
			}

			if ( ! is_array( $context ) || empty( $context['consumer_key'] ) || empty( $context['consumer_email'] ) ) {
				return $request;
			}

			$current_user_agent    = isset( $request['user-agent'] ) ? (string) $request['user-agent'] : '';
			$request['user-agent'] = sprintf( '%s;%s', $current_user_agent, self::get_rocket_user_agent( $context ) );

			return $request;
		}

		/**
		 * Remember that the activating administrator should run an immediate check.
		 */
		public static function activate() {
			$user_id = get_current_user_id();

			if ( $user_id ) {
				self::set_activation_redirect( $user_id );
			}
		}

		/**
		 * Redirect once after activation so Update Notification Recovery is tested immediately.
		 */
		public static function maybe_redirect_after_activation() {
			if ( ! current_user_can( 'update_plugins' ) || wp_doing_ajax() ) {
				return;
			}

			$user_id        = get_current_user_id();
			$transient_name = self::get_activation_transient_name( $user_id );

			if ( ! $user_id || ! self::get_activation_redirect( $transient_name ) ) {
				return;
			}

			self::delete_activation_redirect( $transient_name );

			wp_safe_redirect(
				add_query_arg( self::FORCE_QUERY_PARAM, '1', self::get_plugins_page_url() )
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

			$plugin_meta['wp-rocket-update-notification-recovery-check'] = sprintf(
				'<a href="%s"><strong><span class="dashicons dashicons-update" aria-hidden="true"></span> %s</strong></a>',
				esc_url( add_query_arg( self::FORCE_QUERY_PARAM, '1', self::get_plugins_page_url() ) ),
				esc_html__( 'Check Available Updates Now', 'wp-rocket-update-notification-recovery' )
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

			$result = isset( $_GET['wp_rocket_update_notification_recovery_folder'] ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				? sanitize_key( wp_unslash( $_GET['wp_rocket_update_notification_recovery_folder'] ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				: '';

			if ( 'restored' === $result ) {
				echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'WP Rocket\'s plugin folder was restored to wp-rocket.', 'wp-rocket-update-notification-recovery' ) . '</p></div>';
				return;
			}

			$error_messages = array(
				'destination_exists' => __( 'The wp-rocket destination folder already exists, so the renamed folder was not moved.', 'wp-rocket-update-notification-recovery' ),
				'invalid_source'      => __( 'The detected WP Rocket folder is not a safe direct child of the plugins directory.', 'wp-rocket-update-notification-recovery' ),
				'move_failed'         => __( 'WordPress could not rename the WP Rocket folder. Check filesystem permissions.', 'wp-rocket-update-notification-recovery' ),
				'not_found'           => __( 'WP Rocket could no longer be found.', 'wp-rocket-update-notification-recovery' ),
				'plugin_active'       => __( 'WP Rocket must be inactive before its folder can be restored.', 'wp-rocket-update-notification-recovery' ),
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

			$plugin_active = self::is_wp_rocket_active_anywhere( $plugin_file );

			$restore_url = wp_nonce_url(
				admin_url( 'admin-post.php?action=wp_rocket_update_notification_recovery_restore_folder' ),
				'wp_rocket_update_notification_recovery_restore_folder'
			);

			echo '<div class="notice notice-error"><p>';
			echo '<strong>' . esc_html__( 'WP Rocket folder renamed:', 'wp-rocket-update-notification-recovery' ) . '</strong> ';
			echo esc_html(
				sprintf(
					/* translators: %s is the detected plugin folder name. */
					__( 'WP Rocket was found in “%s” instead of “wp-rocket”.', 'wp-rocket-update-notification-recovery' ),
					$current_folder
				)
			);
			if ( $plugin_active ) {
				echo ' <strong>' . esc_html__( 'Deactivate WP Rocket before restoring its folder name.', 'wp-rocket-update-notification-recovery' ) . '</strong>';
			} else {
				echo ' <a class="button button-primary" href="' . esc_url( $restore_url ) . '">' . esc_html__( 'Restore folder name', 'wp-rocket-update-notification-recovery' ) . '</a>';
			}
			echo '</p></div>';
		}

		/**
		 * Restore the expected folder name of an inactive WP Rocket installation.
		 */
		public static function restore_folder_name() {
			if ( ! current_user_can( 'update_plugins' ) ) {
				wp_die( esc_html__( 'You are not allowed to update plugins.', 'wp-rocket-update-notification-recovery' ) );
			}

			check_admin_referer( 'wp_rocket_update_notification_recovery_restore_folder' );

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

			if ( self::is_wp_rocket_active_anywhere( $plugin_file ) ) {
				self::redirect_folder_result( 'plugin_active' );
			}

			if ( ! rename( $source, $destination ) ) {
				self::redirect_folder_result( 'move_failed' );
			}

			delete_site_transient( self::CACHE_TRANSIENT );
			delete_site_transient( self::CONTEXT_TRANSIENT );
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
				delete_site_transient( self::CONTEXT_TRANSIENT );
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
			delete_site_transient( self::CONTEXT_TRANSIENT );
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
			$contexts = self::get_update_contexts();
			if ( ! $contexts ) {
				return new WP_Error(
					'wp_rocket_update_notification_recovery_missing_credentials',
					'WP Rocket license credentials could not be found.'
				);
			}

			$last_error = null;
			foreach ( $contexts as $context ) {
				$result = self::request_remote_data_for_context( $context );
				if ( ! is_wp_error( $result ) ) {
					self::save_update_context( $context );
					return $result;
				}

				$last_error = $result;
			}

			return $last_error;
		}

		/**
		 * Contact WP Rocket's licensing/update endpoint for one site context.
		 *
		 * @param array $context Site URL and license context.
		 * @return stdClass|WP_Error
		 */
		private static function request_remote_data_for_context( $context ) {
			self::$http_context = $context;
			$response = wp_remote_get(
				self::UPDATE_ENDPOINT,
				array(
					'timeout' => 30,
				)
			);
			self::$http_context = null;

			if ( is_wp_error( $response ) ) {
				return new WP_Error(
					'wp_rocket_update_notification_recovery_transport_error',
					$response->get_error_message(),
					array( 'transport_error' => $response->get_error_code() )
				);
			}

			$body = trim( wp_remote_retrieve_body( $response ) );
			$code = wp_remote_retrieve_response_code( $response );

			if ( 200 !== $code ) {
				return new WP_Error(
					'wp_rocket_update_notification_recovery_http_error',
					'WP Rocket update API returned an unexpected HTTP status.',
					array( 'http_code' => $code )
				);
			}

			if ( ! preg_match( '@^(?<stable_version>\d+(?:\.\d+){1,3}[^|]*)\|(?<package>(?:http.+\.zip)?)\|(?<user_version>\d+(?:\.\d+){1,3}[^|]*)(?:\|+)?$@', $body, $matches ) ) {
				return new WP_Error( 'wp_rocket_update_notification_recovery_invalid_response', 'WP Rocket update API returned an invalid response.' );
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
		 * @param array $context Site URL and license context.
		 * @return string
		 */
		private static function get_rocket_user_agent( $context ) {
			$php_version = preg_replace( '@^(\d+\.\d+).*@', '$1', PHP_VERSION );

			$user_agent = sprintf(
				'WP-Rocket|%s|%s|%s|%s|%s;',
				self::get_installed_version(),
				$context['consumer_key'],
				$context['consumer_email'],
				$context['site_url'],
				$php_version
			);

			// Never allow stored values to inject additional HTTP headers.
			return preg_replace( '/[\r\n]+/', '', $user_agent );
		}

		/**
		 * Get license credentials without loading any WP Rocket PHP file.
		 *
		 * On single-site, constants and saved settings take precedence. On Multisite,
		 * the shared licence-data.php is preferred and per-site settings are fallback.
		 *
		 * @param int $blog_id Blog ID, or zero on a single-site installation.
		 * @return array
		 */
		private static function get_license_credentials( $blog_id = 0 ) {
			if ( is_multisite() && $blog_id ) {
				$options = get_blog_option( $blog_id, self::SETTINGS_OPTION, array() );
			} else {
				$options = get_option( self::SETTINGS_OPTION, array() );
			}
			$options          = is_array( $options ) ? $options : array();
			$file_credentials = self::get_license_file_credentials();

			if ( is_multisite() ) {
				// licence-data.php belongs to the shared codebase, so it is the
				// authoritative network license. Per-site options are a fallback.
				$credentials = array(
					'consumer_key'   => defined( 'WP_ROCKET_KEY' ) ? (string) WP_ROCKET_KEY : ( isset( $file_credentials['consumer_key'] ) ? (string) $file_credentials['consumer_key'] : '' ),
					'consumer_email' => defined( 'WP_ROCKET_EMAIL' ) ? (string) WP_ROCKET_EMAIL : ( isset( $file_credentials['consumer_email'] ) ? (string) $file_credentials['consumer_email'] : '' ),
				);
			} else {
				$credentials = array(
					'consumer_key'   => defined( 'WP_ROCKET_KEY' ) ? (string) WP_ROCKET_KEY : ( isset( $options['consumer_key'] ) ? (string) $options['consumer_key'] : '' ),
					'consumer_email' => defined( 'WP_ROCKET_EMAIL' ) ? (string) WP_ROCKET_EMAIL : ( isset( $options['consumer_email'] ) ? (string) $options['consumer_email'] : '' ),
				);
			}

			foreach ( $credentials as $name => $value ) {
				if ( '' !== $value ) {
					continue;
				}

				if ( isset( $options[ $name ] ) ) {
					$credentials[ $name ] = (string) $options[ $name ];
				} elseif ( isset( $file_credentials[ $name ] ) ) {
					$credentials[ $name ] = (string) $file_credentials[ $name ];
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
		 * Get the site contexts that may authenticate the shared WP Rocket copy.
		 *
		 * Single-site installations have one context. On Multisite, the main site
		 * and the first configured child site are enough because the plugin files
		 * and licence-data.php are shared across the network.
		 *
		 * @return array[]
		 */
		private static function get_update_contexts() {
			if ( ! is_multisite() ) {
				$context = self::build_site_context( 0 );

				return $context ? array( $context ) : array();
			}

			$main_site_id  = (int) get_main_site_id();
			$site_ids      = self::get_network_site_ids();
			$candidate_ids = array();

			if ( self::site_has_wp_rocket_context( $main_site_id ) ) {
				$candidate_ids[] = $main_site_id;
			}

			foreach ( $site_ids as $site_id ) {
				if ( $main_site_id === $site_id || ! self::site_has_wp_rocket_context( $site_id ) ) {
					continue;
				}

				$candidate_ids[] = $site_id;
				break;
			}

			// The main URL is a final fallback for a new network whose only license
			// source is the shared licence-data.php file.
			if ( ! in_array( $main_site_id, $candidate_ids, true ) ) {
				$candidate_ids[] = $main_site_id;
			}

			$contexts = array();
			$site_urls = array();
			foreach ( $candidate_ids as $site_id ) {
				$context = self::build_site_context( $site_id );
				if ( ! $context || in_array( $context['site_url'], $site_urls, true ) ) {
					continue;
				}

				$contexts[] = $context;
				$site_urls[] = $context['site_url'];
			}

			return $contexts;
		}

		/**
		 * Build the API authentication context for one site.
		 *
		 * @param int $blog_id Blog ID, or zero on a single-site installation.
		 * @return array|false
		 */
		private static function build_site_context( $blog_id ) {
			if ( is_multisite() && ( ! $blog_id || ! get_site( $blog_id ) ) ) {
				return false;
			}

			$credentials = self::get_license_credentials( $blog_id );
			$site_url    = is_multisite() ? get_home_url( $blog_id ) : home_url();
			$site_url    = esc_url_raw( $site_url );

			if ( empty( $credentials['consumer_key'] ) || empty( $credentials['consumer_email'] ) || ! $site_url ) {
				return false;
			}

			return array(
				'blog_id'        => (int) $blog_id,
				'site_url'       => $site_url,
				'consumer_key'   => (string) $credentials['consumer_key'],
				'consumer_email' => (string) $credentials['consumer_email'],
			);
		}

		/**
		 * Restore the context that produced the current update offer.
		 *
		 * @return array|null
		 */
		private static function get_saved_update_context() {
			$saved = get_site_transient( self::CONTEXT_TRANSIENT );
			if ( ! is_array( $saved ) || ! isset( $saved['blog_id'] ) ) {
				return null;
			}

			$context = self::build_site_context( (int) $saved['blog_id'] );

			return $context ? $context : null;
		}

		/**
		 * Remember which site URL authenticated the update and package download.
		 *
		 * @param array $context Successful request context.
		 */
		private static function save_update_context( $context ) {
			set_site_transient(
				self::CONTEXT_TRANSIENT,
				array( 'blog_id' => (int) $context['blog_id'] ),
				12 * HOUR_IN_SECONDS
			);
		}

		/**
		 * Determine whether a site is a useful WP Rocket update context.
		 *
		 * @param int $blog_id Blog ID.
		 * @return bool
		 */
		private static function site_has_wp_rocket_context( $blog_id ) {
			$plugin_file = self::get_wp_rocket_plugin_file();
			$active      = get_blog_option( $blog_id, 'active_plugins', array() );
			$settings    = get_blog_option( $blog_id, self::SETTINGS_OPTION, array() );

			if ( is_array( $active ) && in_array( $plugin_file, $active, true ) ) {
				return true;
			}

			return is_array( $settings )
				&& ( ! empty( $settings['consumer_key'] ) || ! empty( $settings['consumer_email'] ) );
		}

		/**
		 * Return every non-deleted site ID without get_sites()' default limit.
		 *
		 * @return int[]
		 */
		private static function get_network_site_ids() {
			if ( null !== self::$network_site_ids ) {
				return self::$network_site_ids;
			}

			self::$network_site_ids = array();
			$offset                 = 0;
			$batch_size             = 100;

			do {
				$site_ids = get_sites(
					array(
						'fields'   => 'ids',
						'number'   => $batch_size,
						'offset'   => $offset,
						'spam'     => 0,
						'deleted'  => 0,
						'archived' => 0,
					)
				);

				$site_ids = array_map( 'intval', $site_ids );
				self::$network_site_ids = array_merge( self::$network_site_ids, $site_ids );
				$offset += $batch_size;
			} while ( count( $site_ids ) === $batch_size );

			return self::$network_site_ids;
		}

		/**
		 * Return to the Plugins screen after attempting a folder restoration.
		 *
		 * @param string $result       Result code displayed as an admin notice.
		 * @param bool   $force_update Whether to run a fresh update check.
		 */
		private static function redirect_folder_result( $result, $force_update = false ) {
			$query_args = array(
				'wp_rocket_update_notification_recovery_folder' => $result,
			);

			if ( $force_update ) {
				$query_args[ self::FORCE_QUERY_PARAM ] = '1';
			}

			wp_safe_redirect( add_query_arg( $query_args, self::get_plugins_page_url() ) );
			exit;
		}

		/**
		 * Return the Plugins screen that owns updates for this installation.
		 *
		 * @return string
		 */
		private static function get_plugins_page_url() {
			return is_multisite() ? network_admin_url( 'plugins.php' ) : self_admin_url( 'plugins.php' );
		}

		/**
		 * Return the current administrator's activation redirect transient name.
		 *
		 * @param int $user_id WordPress user ID.
		 * @return string
		 */
		private static function get_activation_transient_name( $user_id ) {
			return 'wp_rocket_update_notification_recovery_activation_redirect_' . absint( $user_id );
		}

		/**
		 * Store an activation redirect in the appropriate scope.
		 *
		 * @param int $user_id WordPress user ID.
		 */
		private static function set_activation_redirect( $user_id ) {
			$name = self::get_activation_transient_name( $user_id );

			if ( is_multisite() ) {
				set_site_transient( $name, 1, MINUTE_IN_SECONDS );
				return;
			}

			set_transient( $name, 1, MINUTE_IN_SECONDS );
		}

		/**
		 * Read an activation redirect flag.
		 *
		 * @param string $name Transient name.
		 * @return mixed
		 */
		private static function get_activation_redirect( $name ) {
			return is_multisite() ? get_site_transient( $name ) : get_transient( $name );
		}

		/**
		 * Delete an activation redirect flag.
		 *
		 * @param string $name Transient name.
		 */
		private static function delete_activation_redirect( $name ) {
			if ( is_multisite() ) {
				delete_site_transient( $name );
				return;
			}

			delete_transient( $name );
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
		 * Determine whether WP Rocket is active in any network context.
		 *
		 * Folder restoration is a filesystem-wide operation, so it must be
		 * refused if any subsite is actively using the detected plugin basename.
		 *
		 * @param string $plugin_file Detected WP Rocket plugin basename.
		 * @return bool
		 */
		private static function is_wp_rocket_active_anywhere( $plugin_file ) {
			if ( ! function_exists( 'is_plugin_active' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			if ( ! is_multisite() ) {
				return is_plugin_active( $plugin_file );
			}

			if ( is_plugin_active_for_network( $plugin_file ) ) {
				return true;
			}

			foreach ( self::get_network_site_ids() as $blog_id ) {
				$active = get_blog_option( $blog_id, 'active_plugins', array() );
				if ( is_array( $active ) && in_array( $plugin_file, $active, true ) ) {
					return true;
				}
			}

			return false;
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

	WP_Rocket_Update_Notification_Recovery::bootstrap();
	register_activation_hook( __FILE__, array( 'WP_Rocket_Update_Notification_Recovery', 'activate' ) );
}
