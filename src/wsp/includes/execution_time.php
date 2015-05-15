<?php
/**
 * PHP file wsp\includes\execution_time.php
 */
/**
 * WebSite-PHP file execution_time.php
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.1.5
 */

/////////////////////////////////////////////////////////////////
// Title: execution_time.php
// Description: Displays how long a script took
// http://www.codecall.net
//
// Usage:
//      include execution_time.php
//      In header place 
//				$startTime = slog_time();
//      In footer place 
//				$totalTime = elog_time($startTime);
//              print "Execution Time: $totalTime Seconds";
/////////////////////////////////////////////////////////////////

// Determine Start Time
function slog_time() {
	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];
	$starttime = $mtime; 
	
	// Return our time
	return $starttime;
}

// Determine end time
function elog_time($starttime) {
	$mtime = microtime();
   $mtime = explode(" ",$mtime);
   $mtime = $mtime[1] + $mtime[0];
   $endtime = $mtime;
   $totaltime = ($endtime - $starttime);
   
   // Return our display
   return $totaltime;
}
?>
