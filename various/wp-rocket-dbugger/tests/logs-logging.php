<div class="column">
<?php

// create the uploads/wpr-logs folder if not exists.
if (!file_exists($logs_file_dir)) {
    wp_mkdir_p($logs_file_dir);
}


// Delete log
if (isset($_GET['clear_file'])) {
    $file = $_GET['clear_file'];

    if ($file == 'wp-rocket-debug.log.html') {
        $file_url = ABSPATH .'wp-content/wp-rocket-config/'.$file;
    } else {
        $file_url = ABSPATH .'wp-content/wpr-logs/'.$file;
    }
    unlink($file_url);

    echo "<h1>LOGS</h1>";
    echo '<hr>';
    echo '<div class="message"><p>File <strong>'.$file.'</strong> deleted</p></div>';
    echo '<a href="tools.php?page=wprockettoolset&mode=logs" class="button-secondary">&lsaquo; go back</a>';
} else {
 ?>

<h2>Enable/disable logging</h2>

<form action="options.php" method="post"><?php
settings_fields('wpr_rocket_debug_log_settings');
do_settings_sections(__FILE__);

$options = get_option('wpr_rocket_debug_log_settings'); ?>


    <table class='debugger' border='1' cellspacing='0' cellpadding='4'>
        <tr class='header'>
            <td>status</td>
            <td>Log name</td>
            <td></td>
        </tr>

        <?php
                        $logs = [
                                'wprocketdebug' => 'WP_ROCKET_DEBUG',
                                'cron' => '01-CRON periodicity',
                                'fullcacheclear' => '02-Full cache clear',
                                'partialcacheclear' => '03-Partial cache clear',
                                'wprd-page-debugger-html' => '04-Page Debugger (Old debugger plugin)',
                                'wprd-page-debugger-file' => '05-Page Debugger (Log file)'
                        ];

foreach ($logs as $log_name => $log_display_name) {
    logs_add_checkbox($log_name, $log_display_name);
} ?>


        <tr>
            <td colspan=" 3" style="text-align:right;"><input type="submit" value="Save options" class="button-primary" /></td>
        </tr>

    </table>
</form>


</div>
<div class="column">


    <h2>Files</h2>

    <?php
echo  "
<table class='debugger' border='1' cellspacing='0' cellpadding='4'>
<tr class='header'>

<td>file</td>
<td>date</td>
<td>size</td>
<td>actions</td>
</tr>";
logs_get_logs(WP_ROCKET_CONFIG_PATH, $wpr_config_folder_url, '*.html', $type);
logs_get_logs($logs_file_dir, $logs_file_url, '*.txt', $type);
echo  "</table>";

}
     ?>
</div>
<div class="column two-cols">
<?php
 if (isset($_GET['view_file'])) {
     $file = $_GET['view_file'];
     echo '<hr>';
     echo "<h3><a href='tools.php?page=wprockettoolset&mode=logs'>Back</a> - Viewing <span class='highlighted'>$file</span></h3>";
     echo '<iframe class="fileviewer" src='.$file.'></iframe>';
 }
 
 ?>
</div>
 
