<?php
/**
 * PHP file wsp\class\modules\RSS-Reader\scripts\magpie_simple.php
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

$url = $_GET['url'];

if ( $url ) {
	$rss = fetch_rss( $url );
	echo "Channel: " . $rss->channel['title'] . "<p>";
	echo "<ul>";
	foreach ($rss->items as $item) {
		$href = $item['link'];
		$title = $item['title'];	
		echo "<li><a href=$href>$title</a></li>";
	}
	echo "</ul>";
}
?>
<form>
	RSS URL: <input type="text" size="30" name="url" value="<?php echo $url ?>"><br />
	<input type="submit" value="Parse RSS">
</form>
  
<p>
<h2>Security Note:</h2>
This is a simple <b>example</b> script.  If this was a <b>real</b> script we probably wouldn't allow  strangers to submit random URLs, and we certainly wouldn't simply echo anything passed in the URL.  Additionally its a bad idea to leave this example script lying around.
</p>
