<?php
/**
 * PHP file wsp\class\modules\RSS-Reader\scripts\magpie_slashbox.php
 */
/**
 * Class 
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


define('MAGPIE_DIR', '../');
require_once(MAGPIE_DIR.'rss_fetch.inc');
	
$url = $_GET['rss_url'];

?>
<html>
<body LINK="#999999" VLINK="#000000">

<form>
<input type="text" name="rss_url" size="40" value="<?php echo $url ?>"><input type="Submit">
</form>

<?php

if ( $url ) {
	echo "displaying: $url<p>";
	$rss = fetch_rss( $url );
	echo slashbox ($rss);
}

echo "<pre>";
print_r($rss);
echo "</pre>";
?>
</body>
</html>

<?php

# just some quick and ugly php to generate html
#
#
function slashbox ($rss) {
	echo "<table cellpadding=2 cellspacing=0><tr>";
	echo "<td bgcolor=#006666>";
	
	# get the channel title and link properties off of the rss object
	#
	$title = $rss->channel['title'];
	$link = $rss->channel['link'];
	
	echo "<a href=$link><font color=#FFFFFF><b>$title</b></font></a>";
	echo "</td></tr>";
	
	# foreach over each item in the array.
	# displaying simple links
	#
	# we could be doing all sorts of neat things with the dublin core
	# info, or the event info, or what not, but keeping it simple for now.
	#
	foreach ($rss->items as $item ) {
		echo "<tr><td bgcolor=#cccccc>";
		echo "<a href=$item[link]>";
		echo $item['title'];
		echo "</a></td></tr>";
	}		
	
	echo "</table>";
}

?>
