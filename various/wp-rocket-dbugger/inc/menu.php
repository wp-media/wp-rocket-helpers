<div class="menu">
    <a href="tools.php?page=wprockettoolset&mode=rucss" class="button-<?php if ($mode == 'rucss' || $mode == '') {
    echo 'primary';
} else {
    echo 'secondary';
}?>">RUCSS</a>
    <a href="tools.php?page=wprockettoolset&mode=preload" class="button-<?php if ($mode == 'preload') {
    echo 'primary';
} else {
    echo 'secondary';
}?>">Preload</a>
    <a href="tools.php?page=wprockettoolset&mode=logs" class="button-<?php if ($mode == 'logs') {
    echo 'primary';
} else {
    echo 'secondary';
}?>">Logs</a>

    <a href="tools.php?page=wprockettoolset&mode=checks" class="button-<?php if ($mode == 'checks') {
    echo 'primary';
} else {
    echo 'secondary';
}?>">Checks</a>

    <a href="tools.php?page=wprockettoolset&mode=configs" class="button-<?php if ($mode == 'configs') {
    echo 'primary';
} else {
    echo 'secondary';
}?>">Config Files</a>

    <a href="<?php echo get_site_url();?>/wp-cron.php?doing_wp_cron" target="_blank" class="button-secondary" id="doing-cron-button">Run WP-Cron <span id="doing-cron-status"> </span></a>
    <script src="<?php echo esc_url(plugins_url('../assets/main.js', __FILE__))?>"></script>


</div>