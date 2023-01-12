<ol class="needler">
	<li>
		<div class="col">Hosting Provider:</div>
		<div class="col"><strong><?php echo get_hosting_provider(); ?></strong>  </div>

	</li>
<li>
	<div class="col">Domain Consistency:</div>
	<div class="col">$_SERVER['HTTP_HOST'] is <strong><?php echo $_SERVER['HTTP_HOST']; ?></strong> <<<>>> <strong><?php echo rocket_get_home_url(); ?></strong> is rocket_get_home_url()</div>
</li>

<li>
	<div class="col">WP Content path:</div>
	<div class="col"><strong><?php echo WP_CONTENT_DIR; ?></strong></div>
</li>

</ol>

<p>Hosting Provider: <strong><?php echo get_hosting_provider(); ?></strong></p>

<h2>PHP Info</h2>

<iframe class="fileviewer" src="<?php echo $plugin_dir ?>/tests/checks/info.php"></iframe>