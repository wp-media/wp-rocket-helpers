<?php
/**
 * Plugin Name: WP Rocket – Update Recovery Helper
 * Description: Prevents the fatal error in WP Rocket 3.23.2.1 and WordPress 7.1, allowing to re-enable WP Rocket and update it to the latest version
 * Version:     1.0.0
 * Author:      WP Rocket Support
 *
 * WHAT THIS FIXES
 * ---------------
 * WP Rocket's Cloudflare subscriber runs unregister_cloudflare_clean_on_post()
 * on `init` (priority 10). It loops the callbacks registered on 'deleted_post'
 * and 'transition_post_status' and calls substr( $key, ... ) on each callback
 * key. If another plugin's callback has an INTEGER key (PHP casts numeric-string
 * array keys to int), substr() throws a TypeError on PHP 8+, fataling the site.
 *
 * HOW IT WORKS
 * ------------
 * On `init` @ priority 9 (just before WP Rocket's 10) we rename any integer keys
 * on those two hooks to temporary string keys, so WP Rocket's substr() is safe.
 * On `init` @ priority 11 (just after) we restore the exact original integer
 * keys, so no other plugin is affected. Those hooks don't fire during init, so
 * this window is invisible to everything else.
 */

defined( 'ABSPATH' ) || exit;

final class WPR_CF_Intkey_Fix {

	/** hook => priority => [ tempStringKey => originalIntKey ] */
	private static $restore = array();

	/** The two hooks WP Rocket's unregister_cloudflare_clean_on_post() scans. */
	private static $hooks = array( 'deleted_post', 'transition_post_status' );

	private static $prefix = 'wpr_cf_intkey_fix_';

	/**
	 * Boot the helper.
	 */
	public static function boot() {
		add_action( 'init', array( __CLASS__, 'stringify_keys' ), 9 );
		add_action( 'init', array( __CLASS__, 'restore_keys' ), 11 );

		add_action( 'admin_notices', array( __CLASS__, 'activation_notice' ) );
		add_action( 'admin_post_wpr_cf_fix_activate_rocket', array( __CLASS__, 'activate_rocket' ) );
	}

	/**
	 * Rename integer callback keys to strings before WP Rocket's cleanup runs.
	 */
	public static function stringify_keys() {
		global $wp_filter;

		foreach ( self::$hooks as $hook ) {
			if ( empty( $wp_filter[ $hook ] ) || ! $wp_filter[ $hook ] instanceof WP_Hook ) {
				continue;
			}

			foreach ( $wp_filter[ $hook ]->callbacks as $priority => $callbacks ) {
				foreach ( $callbacks as $key => $config ) {
					if ( is_int( $key ) ) {
						$temp_key = self::$prefix . $key;

						$wp_filter[ $hook ]->callbacks[ $priority ][ $temp_key ] = $config;
						unset( $wp_filter[ $hook ]->callbacks[ $priority ][ $key ] );

						self::$restore[ $hook ][ $priority ][ $temp_key ] = $key;
					}
				}
			}
		}
	}

	/**
	 * Put the original integer keys back, leaving the site exactly as it was.
	 */
	public static function restore_keys() {
		global $wp_filter;

		foreach ( self::$restore as $hook => $priorities ) {
			if ( empty( $wp_filter[ $hook ] ) || ! $wp_filter[ $hook ] instanceof WP_Hook ) {
				continue;
			}

			foreach ( $priorities as $priority => $map ) {
				foreach ( $map as $temp_key => $original_int_key ) {
					if ( isset( $wp_filter[ $hook ]->callbacks[ $priority ][ $temp_key ] ) ) {
						$wp_filter[ $hook ]->callbacks[ $priority ][ $original_int_key ] =
							$wp_filter[ $hook ]->callbacks[ $priority ][ $temp_key ];

						unset( $wp_filter[ $hook ]->callbacks[ $priority ][ $temp_key ] );
					}
				}
			}
		}

		self::$restore = array();
	}

	/**
	 * Show an admin notice when WP Rocket is installed but inactive.
	 */
	public static function activation_notice() {

		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$rocket_plugin = 'wp-rocket/wp-rocket.php';

		// WP Rocket is already active.
		if ( is_plugin_active( $rocket_plugin ) ) {
			return;
		}

		// WP Rocket is not installed.
		if ( ! file_exists( WP_PLUGIN_DIR . '/' . $rocket_plugin ) ) {
			return;
		}

		$activate_url = wp_nonce_url(
			admin_url( 'admin-post.php?action=wpr_cf_fix_activate_rocket' ),
			'wpr_cf_fix_activate_rocket'
		);

		?>
		<div class="notice notice-success">
			<p>
				<strong>WP Rocket temporary fix is active.</strong>
			</p>

			<p>
				You can now safely activate WP Rocket. After activating it,
				update WP Rocket to version 3.23.2.2 or later.
			</p>

			<p>
				<a href="<?php echo esc_url( $activate_url ); ?>" class="button button-primary">
					Activate WP Rocket
				</a>
			</p>
		</div>
		<?php
	}

	/**
	 * Activate WP Rocket and redirect to its filtered Plugins screen,
	 * forcing WP Rocket to refresh its update information.
	 */
	public static function activate_rocket() {

		if ( ! current_user_can( 'activate_plugins' ) ) {
			wp_die( 'You do not have permission to activate plugins.' );
		}

		check_admin_referer( 'wpr_cf_fix_activate_rocket' );

		if ( ! function_exists( 'activate_plugin' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$rocket_plugin = 'wp-rocket/wp-rocket.php';

		$result = activate_plugin( $rocket_plugin );

		if ( is_wp_error( $result ) ) {
			wp_die(
				esc_html(
					'WP Rocket could not be activated: ' . $result->get_error_message()
				)
			);
		}

		$url = add_query_arg(
			array(
				'rocket_force_update' => '1',
				's'                   => 'WP Rocket',
			),
			admin_url( 'plugins.php' )
		);

		wp_safe_redirect( $url );
		exit;
	}
}

WPR_CF_Intkey_Fix::boot();