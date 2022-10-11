<?php
/**
 * Plugin Name: WP Rocket Helper: Exclude highlight from delay JS.
 * Plugin URI:  https://wp-rocket.me/
 * Description: Exclude code highlight from delay JS.
 * Author:      Ahmed Saeed
 * Author URI:  https://github.com/engahmeds3ed
 * Version:     0.1.1
 * License:     GPLv2 or later (license.txt)
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class WPRExcludeHighlightDelayJS {
	private static $_instance = null;

	private $search_replace = [];

	private $comment_template = '<!-- WPR_DJ_HELPER_%s -->';

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new WPRExcludeHighlightDelayJS();
		}

		return self::$_instance;
	}

	public function add_hooks() {
		if ( is_admin() ) {
			return;
		}

		add_filter( 'rocket_buffer', [ $this, 'remove_before_optimizations' ], 1 );
		add_filter( 'rocket_buffer', [ $this, 'add_after_optimizations' ], 1000 );
	}

	public function remove_before_optimizations( $html ) {
		$regex = '#<pre(.*)>(.*)</pre>#Uis';
		$replaced_html = preg_replace_callback( $regex, [ $this, 'remove_pre' ], $html );

		if ( empty( $replaced_html ) ) {
			return $html;
		}

		return $replaced_html;
	}

	public function remove_pre( $matches ) {
		$key = sprintf( $this->comment_template, uniqid('WPR') );
		$this->search_replace[ $key ] = $matches[0];
		return $key;
	}

	public function add_after_optimizations( $html ) {
		if ( empty( $this->search_replace ) ) {
			return $html;
		}

		return str_replace( array_keys( $this->search_replace ), array_values( $this->search_replace ), $html );
	}
}

add_action( 'plugins_loaded', [ WPRExcludeHighlightDelayJS::get_instance(), 'add_hooks' ] );
