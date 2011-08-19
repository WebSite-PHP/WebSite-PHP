<?php
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