<?php


/**
 * Converts a file size from getSize into human readable format
 *
 * @param integer $bytes description
 * @param integer $decimals number of decimals
 *
 * @return void  human readable format
 */
function wpr_rocket_debug_human_filesize($bytes, $decimals = 2)
{
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

/**
 * Preloads a URL
 *
 * @param string $url the URL to preload
 *
 */
function do_the_preload($url)
{
    $args = array();

    if (1 == get_rocket_option('cache_webp')) {
        $args[ 'headers' ][ 'Accept' ]      	= 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8';
        $args[ 'headers' ][ 'HTTP_ACCEPT' ] 	= 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8';
    }
    // Preload desktop pages/posts.
    wp_remote_get(esc_url_raw($url), $args);


    if (1 == get_rocket_option('do_caching_mobile_files')) {
        $args[ 'headers' ][ 'user-agent' ] 	= 'Mozilla/5.0 (Linux; Android 8.0.0;) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Mobile Safari/537.36';
        // Preload mobile pages/posts.
        wp_remote_get(esc_url_raw($url), $args);
    }
}


/**
 * Checks if a log option is enabled or disabled
 *
 * @param string $option_name the name of the log option to check
 *
 * @return 'enabled' or 'disabled'
    */
function get_wpr_rocket_debug_log_status($option_name)
{
    $options = get_option('wpr_rocket_debug_log_settings');

    if (isset($options['wpr_rocket_debug_log_status']) && (isset($options['wpr_rocket_debug_log_status'] [$option_name]))
                && $options['wpr_rocket_debug_log_status'][$option_name] != '') {
        return 'enabled';
    } else {
        return 'disabled';
    }
}

/**
 * Adds a checkbox for a specific log
 *
 * @param string $log_display_name The display name of the Log type
 * @param string $log_name The name of the log type
 *
 * @return void html content
 */
function logs_add_checkbox($log_name, $log_display_name)
{
    echo '<tr>
        <td style="text-align:center;"><span class="status '.get_wpr_rocket_debug_log_status($log_name).'"></span></td>
        <td>'.$log_display_name.'</td>
        <td><input name="wpr_rocket_debug_log_settings[wpr_rocket_debug_log_status]['.$log_name.']" type="checkbox" id="wpr_rocket_debug_log_status" value="1"';
    if (get_wpr_rocket_debug_log_status($log_name) == 'enabled') {
        echo ' checked="checked"';
    }
    echo '"/>
</td>
</tr>';
}

/**
 * Scans a folder for a specific file extension, and returns a looped <tr> with the list of files
 *
 * @param string $logs_file_dir The dir where the logs will be created
 * @param string $logs_file_url The URL where the logs will be linked to
 * @param string $file_extension the file extension to scan inside the $logs_file_dir folder
 * @param string $type the current view inside the logs tab
 *
 * @return void  HTML response
 */
function logs_get_logs($logs_file_dir, $logs_file_url, $file_extension, $type)
{
    $files = new GlobIterator($logs_file_dir.$file_extension);

    foreach ($files as $file) {
        if ($file->getFilename() == 'index.html') {
            continue;
        }

        echo "<tr>";

        $file_url = $logs_file_url.''.$file->getFilename();

        echo "<td><a href='?page=wprockettoolset&mode=logs&view_file=".$file_url."'><strong>".$file->getFilename()."</strong></a></td>";
        echo "<td>".gmdate("H:i:s m-d-Y", $file->getMTime())."</td>";
        echo "<td>".wpr_rocket_debug_human_filesize($file->getSize())."</td>";
        echo "<td>
        
        <a class='button-secondary' title='Load file in viewer' href='?page=wprockettoolset&mode=logs&view_file=".$logs_file_url."".$file->getFilename()."'><span class='dashicons dashicons-visibility'></span></a>
        <a class='button-secondary' title='Open file in new tab' target='_blank' href='".$logs_file_url."".$file->getFilename()."'><span class='dashicons dashicons-external'></span></a>
        <a class='button-secondary' title='download file' target='_blank' href='".site_url()."/downloader/?url=".$logs_file_url."".$file->getFilename()."'><span class='dashicons dashicons-download'></span></a>
        <a class='button-secondary' title='Delete file' onclick=\"return confirm('Are you sure?')\" href='tools.php?page=wprockettoolset&mode=logs&action=delete&clear_file=".$file->getFilename()."&type=".$type."'><span class='dashicons dashicons-trash'></span></a>
        
        </td>";
        echo "</tr>";
    }
}

function show_arr($col, $sort, $order)
{
    if ($col == $sort) {
        if ($order == 'asc') {
            return '<span class="highlighted">&darr;</span>';
        } else {
            return '<span class="highlighted">&uarr;</span>';
        }
    } else {
        return '';
    }
}

/**
 * Returns a readable stack of the functions history based on getTraceAsString
 * https://www.php.net/manual/en/exception.gettraceasstring.php
 * @return void string
 */
function generateCallTrace()
{
    $e = new Exception();
    $trace = explode("\n", $e->getTraceAsString());
    // reverse array to make steps line up chronologically
    $trace = array_reverse($trace);
    array_shift($trace); // remove {main}
        array_pop($trace); // remove call to this method
        $length = count($trace);
    $result = array();

    for ($i = 0; $i < $length; $i++) {
        $result[] = ($i + 1)  . ')' . substr($trace[$i], strpos($trace[$i], ' '));
    }

    return "" . implode("\n", $result);
}


/**
 * This function finds a string inside a file
 *
 * @param string $string_to_find the string to find, for example wp_footer();
 * @param string $file_to_check the path to the file.
 *
 * @return void  string "disabled" or "enabled"
 */
function file_needler($string_to_find, $file_to_check)
{
    $handle = fopen($file_to_check, 'r');
    $valid = 'disabled'; // init as disabled
    while (($buffer = fgets($handle)) !== false) {
        if (strpos($buffer, $string_to_find) !== false) {
            $valid = 'enabled';
            break; // Once you find the string, you should break out the loop.
        }
    }
    fclose($handle);
    return $valid;
}

/**
 * Gets the hosting provider of the current domain
 *
 * @return void String
 */
function get_hosting_provider()
{
    $url = get_site_url();
    $url = preg_replace('#^https?://#i', '', $url);
    $ip_info = 'https://ipwhois.app/json/'.$url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $ip_info);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    $org = strtolower(json_decode($result)->org);
    return $org;
}


function dbugger_template_redirect()
{
    if ($_SERVER['SCRIPT_URL']=='/downloader/') {
        $filename = str_replace('url=', '', $_SERVER['QUERY_STRING']);
        $site_url = site_url();
        $site_url = preg_replace('#^https?://#i', '', $site_url);
        header("Content-type: application/x-msdownload", true, 200);
        header("Content-Disposition: attachment; filename=".$site_url."-".basename($filename));
        header("Pragma: no-cache");
        header("Expires: 0");
        header('Content-Length: ' . filesize($filename));
        flush();
        readfile($filename);

        exit();
    }
}

add_action('template_redirect', 'dbugger_template_redirect');

function wprdbugger_enable_debug_mode()
{
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    $log_path =  ABSPATH . '/wp-content/wpr-logs/debug.txt';
    ini_set('error_log', $log_path);
}

//LOGS
 // first, lets see what is enabled
 $options = get_option('wpr_rocket_debug_log_settings');

// RUCSS
 if (get_wpr_rocket_debug_log_status('wprocketdebug') == 'enabled') {
     define('WP_ROCKET_DEBUG', true);
     
     
 }

// WP_DEBUG
     add_action('template_redirect', 'wprdbugger_enable_debug_mode');




// CRON
if (get_wpr_rocket_debug_log_status('cron') == 'enabled') {
    add_action('init', function () {
        if (! defined('DOING_CRON') || ! DOING_CRON) {
            return;
        }
        error_log("\n" . date('[Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . "] Cron: " . $_SERVER['HTTP_USER_AGENT'], 3, ABSPATH . "/wp-content/wpr-logs/01-cron.txt");
    });
}

// FULL CACHE CLEAR
if (get_wpr_rocket_debug_log_status('fullcacheclear') == 'enabled') {
    add_action('before_rocket_clean_domain', function () {
        error_log("\n\n====================================================================\n[" . date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . "]\n#CALLSTACK#####\n" . print_r(generateCallTrace(), true), 3, ABSPATH . "/wp-content/wpr-logs/02-full-cache-clear.txt");
    });
}

// PARTIAL CACHE CLEAR
if (get_wpr_rocket_debug_log_status('partialcacheclear') == 'enabled') {
    function log_partialcacheclear($post, $purge_url, $lang)
    {
        error_log("\n====================================================================\n[" . date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . "]\n#CALLSTACK#####\n" . print_r(generateCallTrace(), true), 3, ABSPATH . "/wp-content/wpr-logs/03-partial-cache-clear.txt");
        error_log("\n\n#POST####\n ID: " . print_r($post->ID, true), 3, ABSPATH . "/wp-content/wpr-logs/03-partial-cache-clear.txt");
        error_log("\n URL: " . print_r(get_permalink($post->ID), true), 3, ABSPATH . "/wp-content/wpr-logs/03-partial-cache-clear.txt");
        error_log("\n Post_type: " . print_r($post->post_type, true), 3, ABSPATH . "/wp-content/wpr-logs/03-partial-cache-clear.txt");
        error_log("\n\n#PURGED_URLS#####\n" . print_r($purge_url, true), 3, ABSPATH . "/wp-content/wpr-logs/03-partial-cache-clear.txt");
    }
    add_action('before_rocket_clean_post', 'log_partialcacheclear', 1000, 3);
}

add_filter( 'rocket_buffer', function($html){
     preg_match( '@WP Rocket/(Homepage_Preload_After_Purge_Cache|Homepage\sPreload|Preload){1}@i', $_SERVER['HTTP_USER_AGENT'] ) ?
         $html .= '<!-- Cached by Preload -->':
     $html .= '<!-- Cached by ' . $_SERVER['HTTP_USER_AGENT'] . ' -->';
      return $html;
  }, PHP_INT_MAX );
