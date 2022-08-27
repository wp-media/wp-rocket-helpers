<?php

// WPR_DEBUG_LOG viewer   
	  
// Delete log
if( isset($_GET['clear_file'] )) {

		$file = $_GET['clear_file']; 
		$file_url = ABSPATH .'wp-content/wp-rocket-config/'.$file;
		
		unlink($file_url);
		
		echo "<h1>WPR DEBUG LOG</h1>";
		echo '<hr>';
		echo '<div class="message"><p>Log file deleted</p></div>';
		echo '<a href="tools.php?page=wprockettoolset&mode=debug" class="button-secondary">&lsaquo; go back</a>';
		
 }
 
 else {
	  

   $options = get_option( 'wpr_rocket_debug_log_settings' ); 
   if (isset($options['wpr_rocket_debug_log_status']) && $options['wpr_rocket_debug_log_status'] != '' ) {   
	   
	  $wpr_status = 'enabled';
	   
	 } else {
		 $wpr_status = 'disabled';

	 }
   
   ?>
	 <div class="wrap">
	 <h1>WPR DEBUG LOG <span class="<?php echo $wpr_status; ?>"></span></h1>
	 <hr>

	 <form class="debugger" action="options.php" method="post"><?php
		 settings_fields( 'wpr_rocket_debug_log_settings' );
		 do_settings_sections( __FILE__ );
 
		 //get the older values, wont work the first time
		 $options = get_option( 'wpr_rocket_debug_log_settings' ); ?>
							 
							 <label> Enable WP_ROCKET_DEBUG 
								 
							 <input name="wpr_rocket_debug_log_settings[wpr_rocket_debug_log_status]" type="checkbox" id="wpr_rocket_debug_log_status" 
							
							 <?php 
							 // checked status
							 if (isset($options['wpr_rocket_debug_log_status']) && $options['wpr_rocket_debug_log_status'] != '' ) {
								 
								 echo ' checked="checked"';
											
							   }?>
							   
							   "/>
							 
						 </label>
						 
					 <input type="submit" value="Save option" class="button-primary" />
					 
					 
 
					 
	 </form>
 </div>
 
					 
	 <h2>LOG File</h2>
	 
	 <?php 
	 
	 
	 $files = new GlobIterator(WP_ROCKET_CONFIG_PATH.'*.html');
	 
	 
	 echo  "<table class='debugger' border='1' cellspacing='0' cellpadding='4'>";
	 echo "<tr class='header'>
	 
	 <td>file</td>
	 <td>date</td>
	 <td>size</td>
	 <td>delete</td>
	 </tr>";
	 foreach ( $files as $file )  { 
	  if($file->getFilename() == 'index.html' ) {continue;}
	 echo "<tr>";
	 
	 $file_url = content_url() .'/wp-rocket-config/'.$file->getFilename();
	 
	 echo "<td><a target='_blank' href='".$file_url."'><strong>".$file->getFilename()."</strong></a></td>";
	 echo "<td>".gmdate("H:i:s m-d-Y", $file->getMTime())."</td>";
	 echo "<td>".wpr_rocket_debug_human_filesize($file->getSize())."</td>";
	 echo "<td><a onclick=\"return confirm('Are you sure?')\" href='tools.php?page=wprockettoolset&mode=debug&action=delete&clear_file=".$file->getFilename()."'>Delete</a></td>";
	 
	 
	 echo "</tr>";
	 
	 } 
	 echo  "</table>";
	
	if( $file->getFilename() !="index.html" && $file->getFilename() !="" ) {
	
	 echo '<iframe class="debugger" width="90%" height="500px" src="'.$file_url.'"></iframe>';
	 
	 } else {
		 echo '<div class="message"><p>The log file is not generated yet</p></div>';
	 }
	 
 }
 
 
 
 