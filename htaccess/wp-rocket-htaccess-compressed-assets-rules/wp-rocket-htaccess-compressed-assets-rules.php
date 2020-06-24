<?php
/**
 * Plugin Name: WP Rocket | Add Compressed Assets htaccess rules
 * Description: Add compressed assets rewrite rules to the .htaccess file
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2020
 */

namespace WP_Rocket\Helpers\htaccess\compressed_assets_rules;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Add compressed assets rewrite rules to the .htaccess file.
 *
 * @return string         Block of Compressed Assets htaccess rules
 */
function rocket_add_compressed_assets_rules( $marker ) {

$customHeaders = <<<HTACCESS
<IfModule mod_headers.c>
    RewriteCond %{HTTP:Accept-Encoding} gzip
    RewriteCond %{REQUEST_FILENAME}\.gz -f
    RewriteRule \.(css|js)$ %{REQUEST_URI}.gz [L]
    # Prevent mod_deflate double gzip
	RewriteRule \.gz$ - [E=no-gzip:1]
	<FilesMatch "\.gz$">
        # Serve correct content types
        <IfModule mod_mime.c>
            # (1)
            RemoveType gz
            # Serve correct content types
            AddType text/css              css.gz
            AddType text/javascript       js.gz
            # Serve correct content charset
            AddCharset utf-8 .css.gz \
                             .js.gz
		</IfModule>
        # Force proxies to cache gzipped and non-gzipped files separately
        Header append Vary Accept-Encoding
	</FilesMatch>
    # Serve correct encoding type
    AddEncoding gzip .gz
</IfModule>
HTACCESS;

	// Prepend custom headers to WP Rocket block.
	$marker = $customHeaders . $marker;
	$marker .= PHP_EOL;

	return $marker;
}

// Write compressed assets rewrite rules to the very top of the .htaccess
add_filter( 'before_rocket_htaccess_rules', __NAMESPACE__ . '\rocket_add_compressed_assets_rules' );

/**
 * Updates .htaccess, regenerates WP Rocket config file.
 *
 * @author Caspar Hübinger
 */
function flush_wp_rocket() {

	if ( ! function_exists( 'flush_rocket_htaccess' )
	  || ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}

	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_wp_rocket' );

/**
 * Removes customizations, updates .htaccess, regenerates config file.
 *
 * @author Caspar Hübinger
 */
function deactivate() {

	// Remove all functionality added above. Please remove the correct filter.
	remove_filter( 'before_rocket_htaccess_rules', __NAMESPACE__ . '\rocket_add_compressed_assets_rules' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );
