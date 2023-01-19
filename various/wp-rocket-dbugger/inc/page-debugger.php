<?php
// Based in WP Rocket | Debug Helper

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

class PageDebugger {
	private  $html;
	public function __construct() {
		$this->html = $this->generate_formatted_debug_notice();
	}
	public function render_debug() {
		print $this->html;
	}
	public function log_to_file() {
		$log_path =  WP_CONTENT_DIR . '/wpr-logs/page-debugger-log.txt';
		$header = date("d/m/Y H:i:s") . " - " . home_url($_SERVER['REQUEST_URI']) . PHP_EOL;
		error_log( $header . $this->html. PHP_EOL . PHP_EOL , 3, $log_path );
	}
	/**
	 * Render complete formatted debug notice
	 *
	 * @author Caspar Hübinger
	 */
	private function generate_formatted_debug_notice() {

		if ( ! function_exists( 'get_rocket_option' ) ) {
			return;
		}

		/**
		 * BEGIN
		 */
		$html  = $this->render_begin();
		$html .= PHP_EOL . PHP_EOL;

		/**
		 * CONSTANTS
		 */
		$html .= '## Constants' . PHP_EOL;
		$html .= PHP_EOL;
		$html .= $this->render_constants();
		$html .= PHP_EOL;

		/**
		 * FILTERS
		 */
		$html .= '## Filters' . PHP_EOL;
		$html .= 'Note: Filter `rocket_override_donotcachepage` gets set by WP Rocket core in certain environments.';
		$html .= PHP_EOL . PHP_EOL;
		$html .= $this->render_filters();
		$html .= PHP_EOL;
		
		/**
		 * FUNCTIONS
		 */
		$html .= '## Functions' . PHP_EOL;
		$html .= PHP_EOL;
		$html .= $this->render_functions();
		$html .= PHP_EOL;
		
		/**
		 * KNOWN PLUGIN/THEME CONFLCITS
		 */
		$html .= '## Known Plugin / Theme Conflicts' . PHP_EOL;
		$html .= PHP_EOL;
		$html .= $this->render_known_conflicts();
		$html .= PHP_EOL;

		/**
		 * Only on singular views: Cache Options metabox values
		 */
		if ( is_singular() ) {

			// Get current post ID.
			$current_post_id = absint( $GLOBALS['post']->ID );

			/**
			 * METABOX
			 */
			$html .= '## Cache Options metabox' . PHP_EOL;
			$html .= sprintf( 'Note: You’re viewing post ID #%s', $current_post_id );
			$html .= PHP_EOL . PHP_EOL;

			// Excluded from cache?
			$html .= $this->render_cache_reject( $current_post_id );
			$html .= PHP_EOL;

			// Other cache options
			$html .= $this->render_metabox( $current_post_id );
			$html .= PHP_EOL;
		}
		
		/**
		 * MISCELLANEOUS CHECKS
		 */
		$html .= '## Miscellaneous' . PHP_EOL;
		$html .= PHP_EOL;
		$html .= $this->render_miscellaneous();
		$html .= PHP_EOL;

		/**
		 * END
		 */
		$html .= $this->render_end();
		$html .= PHP_EOL;

		return $html;
	}
	/**
	 * Render begin of debug notice
	 *
	 * @author Caspar Hübinger
	 */
	private function render_begin() {

		$html  = PHP_EOL . PHP_EOL;
		$html .= '<!--' . PHP_EOL;
		$html .= '#################################################### ';
		$html .= PHP_EOL;
		$html .= '## WP ROCKET PAGE DEBUGGER ##';

		return $html;
	}

	/**
	 * Render end of debug notice
	 *
	 * @author Caspar Hübinger
	 */
	private function render_end() {

		$html  = PHP_EOL . '####################################################';
		$html .= PHP_EOL;
		$html .= '-->';

		return $html;
	}

	/**
	 * Render section: Contants
	 *
	 * @author Caspar Hübinger
	 */
	private function render_constants() {

		$html = '';

		/**
		 * Cannot use var_export() or print_r() inside an output buffer, so
		 * apologies, this looks a bit wonky.
		 */
		$constant_names = array(
			'WP_CACHE',
			'DONOTCACHEPAGE',
			'DONOTMINIFY',
			'DONOTMINIFYCSS',
			'DONOTMINIFYJS',
		);

		$constant_values = array();

		foreach ( $constant_names as $constant ) {

			if( ! defined( $constant ) ) {
				$constant_values[ $constant ] = 'not defined';
			} else {
				$constant_values[ $constant ] = true === constant( $constant ) || 'true' === constant( $constant ) ? 'TRUE' : 'FALSE';
			}

			$html .= sprintf(
				'- constant %1$s is: %2$s',
				$constant,
				$constant_values[ $constant ]
			);
			$html .= PHP_EOL;
		}
		
		$html .= '- constant ABSPATH is:' . ABSPATH ;
		$html .= PHP_EOL;

		return $html;
	}

	/**
	 * Render section: Filters
	 *
	 * @author Caspar Hübinger
	 */
	private function render_filters( $filters = array(
		'do_rocket_generate_caching_files',
		'rocket_override_donotcachepage'
	) ) {

		$html = '';

		foreach ( $filters as $filter ) {

			$html_filter = 'not set';

			global $wp_filter;

			foreach ( $wp_filter as $filter_name => $filter_value ) {
				if ( false !== strpos( $filter_name, $filter ) ) {

					$current_filter = $filter_value->current();

					foreach ( $current_filter as $key => $value ) {

						$html_filter  = 'set';
						$html_filter .= sprintf( ' (%s)', var_export( $value['function'], true ) );

						if ( 'rocket_override_donotcachepage_on_thrive_leads' === $value['function'] ) {
							$html_filter = sprintf( 'default (%s)', var_export( $value['function'], true ) );
						}

					}

				}
			}

			$html .= sprintf( '- filter %1$s is: %2$s', $filter, $html_filter );
			$html .= PHP_EOL;
		}

		return $html;
	}

	/**
	 * Render section: Cache options metabox
	 *
	 * @author Caspar Hübinger
	 */
	private function render_metabox() {

		$html = '';

		$cache_options = array(
			'lazyload',
			'lazyload_iframes',
			'minify_css',
			'minify_js',
			'cdn',
			'async_css',
			'defer_all_js',
		);

		foreach ( $cache_options as $cache_option ) {

			$value = get_rocket_option( $cache_option );
			$value = is_rocket_post_excluded_option( $cache_option );

			if ( '1' === $value ) {
				$formatted_value = 'DEACTIVATED';
			} else {
				$formatted_value = 'unchanged';
			}

			$html .= sprintf( '- Cache option %1$s: %2$s',
				$cache_option,
				$formatted_value
			);
			$html .= PHP_EOL;
		}

		return $html;
	}

	/**
	 * Helper: Check for cache exclusion
	 *
	 * @author Caspar Hübinger
	 */
	private function render_cache_reject( $current_post_id ) {

		// No way to find out if the “Never cache this page” option is checked,
		// but we can find out whether or not this post is excluded from cache.
		$excluded_post_paths = get_rocket_option( 'cache_reject_uri', array() );
		$current_post_path   = rocket_clean_exclude_file( get_permalink( $current_post_id ) );
		$maybe_post_excluded = in_array( $current_post_path, $excluded_post_paths);

		$html_maybe_excluded = 'not excluded from caching via “Never cache this page”, or “Never cache (URL)”';

		if ( $maybe_post_excluded ) {
			$html_maybe_excluded = 'EXCLUDED from caching via “Never cache this page”, or “Never cache (URL)”';
		}

		return sprintf( '- This post is %s', $html_maybe_excluded );
	}
	/**
	 * Render section: Functions
	 *
	 * @author Arun Basil Lal
	 */
	private function render_functions() {

		$html = '';

		$functions = array(
			'mb_substr_count',
		);

		foreach ( $functions as $function ) {

			if( ! function_exists( $function ) ) {
				$html .= '- function ' . $function . ' does not exist';
			} else {
				$html .= $function . ' exists';
			}

			$html .= PHP_EOL;
		}

		return $html;
	}

	/**
	 * Render section: Known Plugin / Theme Conflicts
	 *
	 * @author Arun Basil Lal
	 */
	private function render_known_conflicts() {

		$html = '';

		$known_plugin_conflicts = array(
			'geoip-detect/geoip-detect.php',
			'email-to-download/email-to-download.php',
			'yet-another-stars-rating/yet-another-stars-rating.php',
			'ezoic-integration/ezoic-integration.php',
			'bulk-image-alt-text-with-yoast/bulk-image-alt-text-with-yoast.php',
			'wp-facebook-open-graph-protocol/wp-facebook-ogp.php',
			'password-protected/password-protected.php',
			'wp-social-seo-booster/wpsocial-seo-booster.php',
			'cookie-law-info/cookie-law-info.php'
		);

		foreach ( $known_plugin_conflicts as $plugin ) {

			if( is_plugin_active( $plugin ) ) {
				$html .= '- plugin ' . $plugin . ' is active.';
				$html .= PHP_EOL;
			}
		}
		
		if ( strcmp( $html, '' ) === 0 ) {
			$html = '- No known conflicts found.';
			$html .= PHP_EOL;
		}

		return $html;
	}

	/**
	 * Render section: Miscellaneous Checks
	 *
	 * @author Arun Basil Lal
	 */
	private function render_miscellaneous() {

		$html = '';
		
		// Check for SSL Cache
		if ( 1 === (int) get_rocket_option( 'cache_ssl' ) ) {
			$html = '- SSL Cache is enabled.';
		} else {
			$html = '- SSL Cache is disabled. If site uses https, enable using helper.';
		}

		return $html;
	}
}

