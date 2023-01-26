<div class="menu">
    <a href="tools.php?page=wprockettoolset&mode=rucss" class="button-<?php if ($mode == 'rucss' || $mode == '') {
    echo 'primary';
} else {
    echo 'secondary';
}?>"><span class="dashicons dashicons-media-code"></span> RUCSS</a>
    <a href="tools.php?page=wprockettoolset&mode=preload" class="button-<?php if ($mode == 'preload') {
    echo 'primary';
} else {
    echo 'secondary';
}?>"><span class="dashicons dashicons-networking"></span> Preload</a>
    <a href="tools.php?page=wprockettoolset&mode=logs" class="button-<?php if ($mode == 'logs') {
    echo 'primary';
} else {
    echo 'secondary';
}?>"><span class="dashicons dashicons-search"></span> Logging</a>

<a href="tools.php?page=wprockettoolset&mode=configs" class="button-<?php if ($mode == 'configs') {
echo 'primary';
} else {
echo 'secondary';
}?>"><span class="dashicons dashicons-media-document"></span>Config Files</a>

    <a href="tools.php?page=wprockettoolset&mode=tests" class="button-<?php if ($mode == 'tests') {
    echo 'primary';
} else {
    echo 'secondary';
}?>"><span class="dashicons dashicons-clipboard"></span> Tests & PHP Info</a>

<a href="tools.php?page=wprockettoolset&mode=check_ips" class="button-<?php if ($mode == 'check_ips') {
    echo 'primary';
} else {
    echo 'secondary';
}?>"><span class="dashicons dashicons-rest-api"></span> Check IPs</a>

    - <a target="_blank" href="<?php echo $plugin_dir ?>/tests/checks/dam.php?username=<?php echo DB_USER; ?>&db=<?php echo DB_NAME; ?>" class="button-<?php if ($mode == 'database') {
    echo 'primary';
    } else {
        echo 'secondary';
    }?>"><span class="dashicons dashicons-database"></span> Adminer</a>
 

    <a href="<?php echo get_site_url();?>/wp-cron.php?doing_wp_cron" target="_blank" class="button-secondary" id="doing-cron-button">Run WP-Cron <span id="doing-cron-status"> </span></a>
    <script src="<?php echo esc_url(plugins_url('../assets/main.js', __FILE__))?>"></script>


</div>