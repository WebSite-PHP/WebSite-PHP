<?php
/**
 * PHP file wsp\class\modules\RSS-Generator\info\examples\example1.php
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
 * @since       1.2.2
 */


	// Import the RSSFeed class
	require_once('path/to/RSSFeed/RSSFeed.class.php');

	// MySQL Connection
	$connection = mysql_connect('localhost','root','example');
	mysql_select_db('website', $connection);
	
	try
	{
		// Create the new instance of the RSS Feed
		$rssFeed = new RSSFeed('utf-8');
		// Activate the string protection
		$rssFeed->setProtectString(true);
		// Set the feed title
		$rssFeed->setTitle('My blog : the best in the world');
		// Set the feed description
		$rssFeed->setDescription('A little blog, which talks about Web programming');
		// Set the feed link
		$rssFeed->setLink('http://www.mywebsite.com/blog/rss/posts.php');
		// Set the feed publication date
		$rssFeed->setPubDate('2007-08-01');
		// Set the feed last build date
		$rssFeed->setLastBuildDate(date('Y-m-d'));
		// Set the feed webmaster
		$rssFeed->setWebMaster('me@mywebsite.com','John Doe');
		// Set the feed managing editor
		$rssFeed->setManagingEditor('me@mywebsite.com','John Doe');
		// Set the feed image
		$rssFeed->setImage('http://www.mywebsite.com/image/logo.jpg','My Logo','My blog',100,200);
		
		// Adding items
		$request = mysql_query('SELECT post_id, post_title, post_description, post_author_email, post_author_name, post_date FROM post WHERE post_valid=1 LIMIT 10');
		
		while($row = mysql_fetch_object($request))
		{
			// Creating a new feed item
			$rssItem = new RSSFeedItem();
			$rssItem->setTitle($row->post_title);
			$rssItem->setDescription($row->post_description);
			$rssItem->setLink('http://www.mywebsite.com/blog/post.php?id='. $row->post_id);
			$rssItem->setGuid('http://www.mywebsite.com/blog/post.php?id='. $row->post_id, true);
			$rssItem->setComments('http://www.mywebsite.com/blog/post.php?id='. $row->post_id .'#comments');
			$rssItem->setAuthor($row->post_author_email, $row->post_author_name);
			$rssItem->setPubDate($row->post_date);
			
			// Add the item to the feed
			$rssFeed->appendItem($rssItem);
		}
		
		// Save the feed
		$rssFeed->save();
		
		// SQL connection closing
		mysql_close();
		
		// Send headers to the browser
		header('Content-Type: text/xml; charset=utf-8');
		// Display the feed
		$rssFeed->display();
	}
	catch(RSSFeedException $e)
	{
		echo $e->getErrorMessage();	
	}
?>
