<?php

// LOGS viewer


    ?>
<div class="wrap">
    <h1>Logging, Config files and Logs Finder</h1>
    <hr>
    <?php   $type = empty($_GET['type']) ? '' : $_GET['type']; ?>
    <div class="menu">
        <a href="tools.php?page=wprockettoolset&mode=logs&type=logging" class="button-<?php if ($type == 'logging' || $type == '') {
        echo 'primary';
    } else {
        echo 'secondary';
    } ?>">Logging</a>
        <a href="tools.php?page=wprockettoolset&mode=logs&type=logfinder" class="button-<?php if ($type == 'logfinder') {
        echo 'primary';
    } else {
        echo 'secondary';
    } ?>">Error Log Finder</a>

    </div>


    <div class="grid-container">


            <?php
            if ($type == 'logging' || $type == '') {
                include('logs-logging.php');
            }

            if ($type == 'configs') {
                include('logs-configs.php');
            }

            if ($type == 'logfinder') {
                include('logs-logfinder.php');
            }
            ?>
    </div> <!-- grid container -->



