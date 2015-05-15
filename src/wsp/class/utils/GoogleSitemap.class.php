<?php
/**
 * PHP file wsp\class\utils\GoogleSitemap.class.php
 * @package utils
 */
/**
 * Class GoogleSitemap
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package utils
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

class GoogleSitemap
{
  /**#@+
	* Box style
	* @access public
	* @var string
	*/
	const CHANGEFREQ_ALWAYS = "always";
	const CHANGEFREQ_HOURLY = "hourly";
	const CHANGEFREQ_DAILY = "daily";
	const CHANGEFREQ_WEEKLY = "weekly";
	const CHANGEFREQ_MONTHLY = "monthly";
	const CHANGEFREQ_YEARLY = "yearly";
	const CHANGEFREQ_NEVER = "never";
	/**#@-*/
	
	
  private $tag_open = "<";
  private $tag_close = ">";
  private $header1 = "?xml version=\"1.0\" encoding=\"UTF-8\"?";
  private $header2 = "\t<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">";
  private $charset = "UTF-8";
  private $footer = "\t</urlset>\n";
  private $items = array();

	/**
	 * Method addItem
	 * Adds a new item to the channel contents.
	 * @access public
	 * @param google_sitemap item $new_item 
	 * @since 1.0.59
	 */
  public function addItem($new_item) {
    //Make sure $new_item is an 'google_sitemap item' object
    if(!is_a($new_item, "GoogleSitemapItem")) {
      //Stop execution with an error message
      trigger_error("Can't add a non-GoogleSitemapItem object to the sitemap items array");
    }
    $this->items[] = $new_item;
  }

	/**
	 * Method build
	 * Generates the sitemap XML data based on object properties.
	 * @access public
	 * @param string $file_name ( optional ) if file name is supplied the XML data is saved in it otherwise returned as a string. [default value:  null]
	 * @return [void|string]
	 * @since 1.0.35
	 */
  public function build($file_name = null) {
    //$map = $this->tag_open.$this->header1.$this->tag_close . "\n";
    $map = "";
    $map .= $this->header2 . "\n";

    foreach($this->items as $item) {
	  $item->loc = htmlentities($item->loc, ENT_QUOTES);
      $map .= "\t\t<url>\n\t\t\t<loc>".$item->loc."</loc>\n";

	  // lastmod
      if ($item->lastmod != "") {
      	if (get_class($item->lastmod) == "DateTime") {
      		$map .= "\t\t\t<lastmod>".$item->lastmod->format("Y-m-d")."</lastmod>\n";
      	} else {
      		$map .= "\t\t\t<lastmod>".$item->lastmod."</lastmod>\n";
      	}
      }
	  // changefreq
      if ($item->changefreq != "" ) {
      	$map .= "\t\t\t<changefreq>".$item->changefreq."</changefreq>\n";
      }
      // priority
      if ($item->priority != "") {
      	$map .= "\t\t\t<priority>".$item->priority."</priority>\n";
      }
      // video
      if ($item->video_content != "") {
      	$map .= "\t\t\t<video:video>\n";
      	$map .= "\t\t\t\t<video:content_loc>".$item->video_content."</video:content_loc>\n";
      	if ($item->video_title != "") {
      		$map .= "\t\t\t\t<video:title>".$item->video_title."</video:title>\n";
      	}
      	if ($item->video_description != "") {
      		$map .= "\t\t\t\t<video:description>".$item->video_description."</video:description>\n";
      	}
      	if ($item->video_thumbnail != "") {
      		$map .= "\t\t\t\t<video:thumbnail_loc>".$item->video_thumbnail."</video:thumbnail_loc>\n";
      	}
      	if ($item->video_player_loc != "") {
      		$map .= "\t\t\t\t<video:player_loc allow_embed=\"yes\">".$item->video_player_loc."</video:player_loc>\n";
      	}
      	$map .= "\t\t\t</video:video>\n";
      }

      $map .= "\t\t</url>\n\n";
    }

    $map .= $this->footer;

    if(!is_null($file_name)) {
      $fh = fopen($file_name, 'w');
      fwrite($fh, $map);
      fclose($fh);
    } else {
      return $map;
    }
  }

	/**
	 * Method render
	 * @return mixed
	 * @since 1.0.35
	 */
  function render() {
  	return $this->build();
  }
}

class GoogleSitemapItem
{
	public $loc = "";
    public $lastmod = "";
    public $changefreq = "";
    public $priority = "";
    
    public $video_content = "";
    public $video_title = "";
    public $video_description = "";
    public $video_thumbnail = "";
    public $video_player_loc = "";

	/**
	 * Constructor GoogleSitemap
	 * @param string $loc location
	 * @param string $lastmod date (optional) format in YYYY-MM-DD or in "ISO 8601" format
	 * @param string $changefreq 
	 * @param string $priority (optional) current link's priority (0.0-1.0)
	 */
  function __construct($loc, $lastmod = '', $changefreq = '', $priority = '') {
    $this->loc = $loc;
    $this->lastmod = $lastmod;
    $this->changefreq = $changefreq;
    $this->priority = $priority;
  }
  
	/**
	 * Method setVideo
	 * @access public
	 * @param object $video_content 
	 * @param mixed $video_title 
	 * @param string $video_description 
	 * @param string $video_thumbnail 
	 * @param string $video_player_loc 
	 * @since 1.0.59
	 */
  public function setVideo($video_content, $video_title, $video_description = '', $video_thumbnail = '', $video_player_loc = '') {
  	$this->video_content = $video_content;
    $this->video_title = $video_title;
    $this->video_description = $video_description;
    $this->video_thumbnail = $video_thumbnail;
    $this->video_player_loc = $video_player_loc;
  } 
}

?>
