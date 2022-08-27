<?php 

if( ! function_exists('rocket_clean_domain')) {
	echo 'WP Rocket not detected';
	die;
}



function wpr_rocket_debug_human_filesize($bytes, $decimals = 2) {
	$sz = 'BKMGTP';
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
  }


function do_the_preload( $url ) {
	$args = array();

	if( 1 == get_rocket_option( 'cache_webp' ) ) {
		$args[ 'headers' ][ 'Accept' ]      	= 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8';
		$args[ 'headers' ][ 'HTTP_ACCEPT' ] 	= 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8';
	}
	// Preload desktop pages/posts.
	wp_remote_get( esc_url_raw ( $url ), $args );
	
		
	if( 1 == get_rocket_option( 'do_caching_mobile_files' ) ) {
		$args[ 'headers' ][ 'user-agent' ] 	= 'Mozilla/5.0 (Linux; Android 8.0.0;) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Mobile Safari/537.36';
	   // Preload mobile pages/posts.
		wp_remote_get( esc_url_raw ( $url ), $args );
	}
} 


$actual_version = WP_ROCKET_VERSION;
$plugin_dir = site_url() . '/wp-content/plugins/wp-rocket-dbugger';


