<?php
/*
 * Website Sitemap Generation
 * Use addItem function to add pages on your sitemap
 */
 
class Sitemap extends Page {
	function __construct() {
		parent::__construct();
	}
	
	public function Load() {
		parent::$PAGE_TITLE = "SITEMAP";
		
		$sitemap = new GoogleSitemap();
		$sitemap->addItem(new GoogleSitemapItem(BASE_URL, new DateTime(), GoogleSitemap::CHANGEFREQ_HOURLY, "1"));
		
		$this->render = $sitemap;
	}
}
?>