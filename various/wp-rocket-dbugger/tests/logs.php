<?php

// LOGS viewer   

// create the uploads/wpr-logs folder if not exists.
if(!file_exists($logs_file_dir))wp_mkdir_p($logs_file_dir);

	  
// Delete log
if( isset($_GET['clear_file'] )) {

		$file = $_GET['clear_file']; 
		
		if( $file == 'wp-rocket-debug.log.html' ) {
		
			$file_url = ABSPATH .'wp-content/wp-rocket-config/'.$file;
		
		} else {
		
			$file_url = ABSPATH .'wp-content/wpr-logs/'.$file;
			
		}
		unlink($file_url);
		
		echo "<h1>LOGS</h1>";
		echo '<hr>';
		echo '<div class="message"><p>File <strong>'.$file.'</strong> deleted</p></div>';
		echo '<a href="tools.php?page=wprockettoolset&mode=logs" class="button-secondary">&lsaquo; go back</a>';
		
 }
 
 else {
	  
   
   ?>
<div class="wrap">
	<h1>Logs</h1>
	<hr>

	<div class="grid-container">
		<div class="column">
			<h2>Enable/disable logs</h2>

			<form action="options.php" method="post"><?php
		 settings_fields( 'wpr_rocket_debug_log_settings' );
		 do_settings_sections( __FILE__ );
 
		 $options = get_option( 'wpr_rocket_debug_log_settings' ); ?>


				<table class='debugger' border='1' cellspacing='0' cellpadding='4'>
					<tr class='header'>
						<td>status</td>
						<td>Log name</td>
						<td></td>
					</tr>
					<tr>
						<td style="text-align:center;"><span class="status <?php echo get_wpr_rocket_debug_log_status('rucss'); ?>"></span></td>
						<td>WP_ROCKET_DEBUG</td>
						<td><input name="wpr_rocket_debug_log_settings[wpr_rocket_debug_log_status][rucss]" type="checkbox" id="wpr_rocket_debug_log_status" value="1" <?php if (get_wpr_rocket_debug_log_status('rucss') == 'enabled') { echo ' checked="checked"';}?> "/>
	     </td>
</tr>
<tr>
	<td  style=" text-align:center;"> <span class="status <?php echo get_wpr_rocket_debug_log_status('cron'); ?>"></span></td>
						<td>01-CRON periodicity</td>
						<td><input name="wpr_rocket_debug_log_settings[wpr_rocket_debug_log_status][cron]" type="checkbox" id="wpr_rocket_debug_log_status" value="1" <?php if (get_wpr_rocket_debug_log_status('cron') == 'enabled') { echo ' checked="checked"';}?> "/>
	 </td>
	</tr>

	<tr>
	 <td colspan=" 3" style="text-align:right;"><input type="submit" value="Save options" class="button-primary" /></td>
					</tr>

				</table>
			</form>


		</div>
		<div class="column">


			<h2>Files</h2>

			<?php 
	 
	 
	 $files = new GlobIterator(WP_ROCKET_CONFIG_PATH.'*.html');
	 
	 
	 echo  "<table class='debugger' border='1' cellspacing='0' cellpadding='4'>";
	 echo "<tr class='header'>
	 
	 <td>file</td>
	 <td>date</td>
	 <td>size</td>
	 <td>actions</td>
	 </tr>";
	 foreach ( $files as $file )  { 
	  if($file->getFilename() == 'index.html' ) {continue;}
	 echo "<tr>";
	 
	 $file_url = content_url() .'/wp-rocket-config/'.$file->getFilename();
	 
	 echo "<td><a target='_blank' href='".$file_url."'><strong>".$file->getFilename()."</strong></a></td>";
	 echo "<td>".gmdate("H:i:s m-d-Y", $file->getMTime())."</td>";
	 echo "<td>".wpr_rocket_debug_human_filesize($file->getSize())."</td>";
	 echo "<td><a target='_blank' href='".$file_url."'>View</a> | 
	 <a onclick=\"return confirm('Are you sure?')\" href='tools.php?page=wprockettoolset&mode=logs&action=delete&clear_file=".$file->getFilename()."'>Delete</a></td>";
	 echo "</tr>";
	 
	 } 

$files = new GlobIterator($logs_file_dir.'*.txt');
 foreach ( $files as $file )  { 
  if($file->getFilename() == 'index.html' ) {continue;}
 echo "<tr>";
 $file_url = $logs_file_dir.''.$file->getFilename();

  echo "<td><a href='?page=wprockettoolset&mode=logs&view_file=".$file_url."'><strong>".$file->getFilename()."</strong></a></td>";
 echo "<td>".gmdate("H:i:s m-d-Y", $file->getMTime())."</td>";
 echo "<td>".wpr_rocket_debug_human_filesize($file->getSize())."</td>";
 echo "<td>

<a href='?page=wprockettoolset&mode=logs&view_file=".$file_url."'>View</a> | 
<a target='_blank' href='".$logs_file_url."".$file->getFilename()."'>Download</a> |
<a onclick=\"return confirm('Are you sure?')\" href='tools.php?page=wprockettoolset&mode=logs&action=delete&clear_file=".$file->getFilename()."'>Delete</a>
 
 </td>";
 echo "</tr>";
 
 } 
 echo  "</table>";	
	 
 }
 
 ?>

		</div>
	</div> <!-- grid container -->

	<?php 
 if( isset($_GET['view_file'] )) {
 
	 $file = $_GET['view_file']; 
 
	 echo "<h3>Viewing $file</h3>";
	 echo '<hr>';
 
	 echo '<pre class="logviewer"><code class="language-php">';
	 echo htmlentities(file_get_contents($file));
	 echo '</code></pre>';
 	 	 
	 
 }
 
 
 
 