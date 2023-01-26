<?php
defined('ABSPATH') || exit;
include('checks/ips-checker.php');
$iPChecker = new IPChecker();
$responses = $iPChecker->run();
?>
<h1>IPs Checker</h1>

<hr />

<h2>Result</h2>
<ol class="needler">

<?php
if ($responses === 'windows') {
    ?>
    <li>
        <div class="col"><span class="status <?php echo 'disabled'?>"></span></div>
        <div class="col"><strong>Windows servers</strong> are not supported.</div>
    </li>
    <?php
} else if ($responses === 'no-shell-exec') {
    ?>
    <li>
        <div class="col"><span class="status <?php echo 'disabled'?>"></span></div>
        <div class="col"><strong>shell_exec</strong> function is not available in this server. Test can't run.</div>
    </li>
    <?php
} else if (gettype($responses) !== 'array') {
    ?>
    <li>
        <div class="col"><span class="status <?php echo 'disabled'?>"></span></div>
        <div class="col">An unknown error has occurred.</div>
    </li>
    <?php
} else {
    foreach ($responses as $host => $value) {
    ?>
    <li>
        <div class="col"><span class="status <?php echo $value ? 'enabled' : 'disabled' ?>"></span></div>
        <div class="col"><strong><?php echo $host ?>:</strong> <?php echo $value ? 'Successful connection' : 'Connection <strong>failed</strong>' ?></div>
    </li>
    <?php
    }
}
?>
</ol>