<?php
/*
 * Website RSS Generation
 * Exemple of RSS feed for your website
 */
 
class Rss extends Page {
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		parent::$PAGE_TITLE = "RSS";
		
		// Create the new instance of the RSS Feed
		$rssFeed = new RSSFeed('utf-8');
		// Activate the string protection
		$rssFeed->setProtectString(true);
		// Set the feed title
		$rssFeed->setTitle(SITE_NAME);
		// Set the feed description
		$rssFeed->setDescription(SITE_DESC);
		// Set the feed link
		$rssFeed->setLink(BASE_URL);
		// Set the feed publication date
		$rssFeed->setPubDate('2007-08-01');
		// Set the feed last build date
		$rssFeed->setLastBuildDate(date('Y-m-d'));
		// Set the feed webmaster
		$rssFeed->setWebMaster(SMTP_MAIL, SMTP_NAME);
		// Set the feed managing editor
		$rssFeed->setManagingEditor(SMTP_MAIL, SMTP_NAME);
		// Set the feed image
		//$rssFeed->setImage(BASE_URL.'img/logo.png',SITE_NAME, SITE_NAME,100,200);
		
		// Creating a new feed item
		$rssItem = new RSSFeedItem();
		$rssItem->setTitle('Test');
		$rssItem->setDescription('Test description');
		$rssItem->setLink(BASE_URL);
		$rssItem->setGuid(BASE_URL, true);
		$rssItem->setAuthor(SMTP_MAIL, SMTP_NAME);
		$rssItem->setPubDate(date('Y-m-d H:i:s'));
		
		// Add the item to the feed
		$rssFeed->appendItem($rssItem);
		
		$this->render = $rssFeed;
	}
}
?>