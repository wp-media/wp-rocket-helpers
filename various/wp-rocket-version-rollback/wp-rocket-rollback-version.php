<?php
/**
 * Plugin Name: WP Rocket | Choose Version Rollback
 * Description: Allows choosing a specific version for WP Rocket rollback via a settings page.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\VersionRollback;

defined( 'ABSPATH' ) or die();

define( 'WP_ROCKET_ROLLBACK_VERSION', 'wp_rocket_last_version' );

// Define the constant dynamically based on the saved version
$stored_version = get_option( WP_ROCKET_ROLLBACK_VERSION, '3.18.2' );
define( 'WP_ROCKET_LASTVERSION', $stored_version );


// Connect to GitHub and get the latest releases
function getAllGitHubReleases($repo) {
    
    // first, check if the wp_rocket_versions transient exists
    $cached_versions = get_transient( 'wp_rocket_versions' );
    if ( $cached_versions !== false ) {
        return $cached_versions;
    }
    
    // if it doesn't exist, pull the versions from github
    $releases = [];
    $page = 1;

    do {
        $url = "https://api.github.com/repos/$repo/releases?per_page=100&page=$page";

        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "User-Agent: PHP\r\n"
            ]
        ];

        $context = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);

        if (!$response) {
            die("Error fetching GitHub releases.");
        }

        $data = json_decode($response, true);
        if (!is_array($data) || empty($data)) {
            break;
        }

        $releases = array_merge($releases, $data);
        $page++;
    } while (count($data) === 100); // Continue if we get 100 results (indicating more pages exist)

    // set the transient, and store it for 12 hours
    set_transient( 'wp_rocket_versions', $releases, 12 * HOUR_IN_SECONDS ); 

    return $releases;

}

// Skip tags that contain alpha, beta, or pre-release terms
function isValidReleaseTag($tagName) {
    return !preg_match('/(alpha|beta|rc|v\.)/i', $tagName);
}


// Adds the settings menu
function add_settings_page() {
    add_options_page(
        'WP Rocket Version',
        'WP Rocket - Version Rollback',
        'manage_options',
        'wp-rocket-version',
        __NAMESPACE__ . '\render_settings_page'
    );
}
add_action( 'admin_menu', __NAMESPACE__ . '\add_settings_page' );

// Renders the settings page
function render_settings_page() {
    if ( isset( $_POST['wp_rocket_version'] ) && check_admin_referer( 'wp_rocket_version_save', 'wp_rocket_version_nonce' ) ) {
        update_option( WP_ROCKET_ROLLBACK_VERSION, sanitize_text_field( $_POST['wp_rocket_version'] ) );
    }
    
    $current_version = get_option( WP_ROCKET_ROLLBACK_VERSION, '3.18.2' );

    // Repository owner/name format
    $repo = "wp-media/wp-rocket";
    $versions = getAllGitHubReleases($repo);
    
    ?>
    <div class="wrap">
        <h1>WP Rocket - Version Rollback</h1>
        <form method="post" style="display: inline-block; padding: 20px 20px; background: #FFF;">
            <?php wp_nonce_field( 'wp_rocket_version_save', 'wp_rocket_version_nonce' ); ?>
            
            <h3>Current version installed: <?php echo WP_ROCKET_VERSION; ?></h3>

            <p><label for="wp_rocket_version">Set WP_ROCKET_ROLLBACK_VERSION to:</label></p>
            <select name="wp_rocket_version" id="wp_rocket_version">
                
                <?php 
                    foreach ( array_slice( $versions, 0, 100 ) as $version ) { 	                
                    $tagName = str_replace('v', '', $version['tag_name']);
                    if (isValidReleaseTag($tagName)) { ?>
                    
                    <option value="<?php echo esc_attr( $tagName ); ?>" <?php selected( $current_version, $tagName ); ?>>
                        <?php echo esc_html( $tagName ); ?>
                        <?php if (esc_html( $tagName ) == WP_ROCKET_VERSION) { echo '<<< installed';}?>
                    </option>
                    
                    <?php } ?>
                <?php } ?>
            </select>
            <input type="submit" value="Save as rollback to version" class="button button-primary">
            <a href="<?php echo  admin_url( 'options-general.php?page=wprocket#tools' ); ?>" target="_blank" class="button button-secondary" style="margin-left:10px;">Go to WP Rocket Tools</a>

           <p>This action is not rolling back the plugin, you have to manually do it from WP Rocket settings page. <a target="_blank" href="https://docs.wp-rocket.me/article/1137-tools-tab-export-import-settings-and-version-rollback#version-rollback">Read More</a></ol></p>
        </form>
        <h3>How to use it</h3>

        <ul>
            <ol>1. before rolling back, <strong>Save a copy of the current WP Rocket settings </strong></ol>
            <ol>2. <strong>Choose the WP Rocket version</strong> you'd like to rollback to, and click "Save Version". This will set the WP_ROCKET_ROLLBACK_VERSION to the selected one. </ol>
            <ol>3. <strong>Go to <em>WP Rocket settings > Export/import settings and version rollback</em> and refresh</strong> it, the version number should update accordingly to the selection.</ol>
            <ol>4. Click <strong>REINSTALL VERSION <?php echo $current_version ?></strong></ol>
            <ol>5. You can choose and <strong>older or newer version</strong>, the rollback will still work to update WP Rocket from older to newer.</ol>
        </ul>

    </div>
    <?php
}

// Cleanup on plugin deactivation.

function deactivate() {
    delete_option( WP_ROCKET_ROLLBACK_VERSION );
    delete_transient( 'wp_rocket_versions' );

}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );
