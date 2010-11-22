<?php 
// include the phpformatter class
require_once ('phpformatter.class.php');
// create a new object 
$phpformatter = new phpformatter ();
// load PHP source code
$code = file_get_contents ('phpformatter.class.php'); 
// get the formatted code
$formatted = $phpformatter->format_string ($code);
// As an alternative it's possible to call the class methods as static
// phpformatter::format_string ($code);
// phpformatter::format_file ($filename);

// print the formatted code in a beautiful way
highlight_string ($formatted);
?>