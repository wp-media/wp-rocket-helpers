<?php

// Config files viewer   
	
 ?>
 
 <div class="wrap">

					
<h1>Config files</h1>
<hr>


 <?php 
 
 $config_files = array(
	 ABSPATH.'.htaccess',
	 ABSPATH.'wp-config.php',
	 ABSPATH.'wp-content/advanced-cache.php',
	 WP_ROCKET_CONFIG_PATH.'*.php' 
 );
 
 function configs_get_files( $config_file ) {
	 
	 $files = new GlobIterator( $config_file);
	 foreach ( $files as $file )  { 
			if($file->getFilename() == 'index.html' ) {continue;}
		   echo "<tr>";
		   echo "<td><strong>".$file->getFilename()."</strong></td>";
		   echo "<td>".gmdate("H:i:s m-d-Y", $file->getMTime())."</td>";
		   echo "<td>".wpr_rocket_debug_human_filesize($file->getSize())."</td>";
		   echo "<td><a target href='tools.php?page=wprockettoolset&mode=configs&action=view&view_file=".$file->getPath()."/".$file->getFilename()."'>View</a></td>";
	
		   
		   echo "</tr>";
		   
		   } 
 };

  
  
  echo  "<table class='debugger' border='1' cellspacing='0' cellpadding='4' '>";
  echo "<tr class='header'>
  
  <td>file</td>
  <td>date</td>
  <td>size</td>
  <td>delete</td>
  </tr>";

  foreach($config_files as $config_file) {

  	echo configs_get_files($config_file);

  }
  echo  "</table>";
 

if( isset($_GET['view_file'] )) {

	$file = $_GET['view_file']; 

	echo "<h3>Viewing $file</h3>";
	echo '<hr>';

	echo '<pre><code class="language-php">';
	echo htmlentities(file_get_contents($file));
	echo '</code></pre>';

	echo '<a href="tools.php?page=wprockettoolset&mode=debug" class="button-secondary">&lsaquo; go back</a>';
	
	
	
}





