<?php

/* GoogleSitemap.class.php

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

-------------------------------------------------------------------------------
$Id: $

*/

/** A class for generating simple google sitemaps
 *@author Svetoslav Marinov <svetoslav.marinov@gmail.com>
 *@copyright 2005-2010
 *@version 0.2
 *@access public
 *@link http://devquickref.com
 *
 *Modify bu Emilien MOREL (add video tag) - 03/2010
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

  /** Adds a new item to the channel contents.
   *@param google_sitemap item $new_item
   *@access public
   */
  public function addItem($new_item) {
    //Make sure $new_item is an 'google_sitemap item' object
    if(!is_a($new_item, "GoogleSitemapItem")) {
      //Stop execution with an error message
      trigger_error("Can't add a non-GoogleSitemapItem object to the sitemap items array");
    }
    $this->items[] = $new_item;
  }

  /** Generates the sitemap XML data based on object properties.
   *@param string $file_name ( optional ) if file name is supplied the XML data is saved in it otherwise returned as a string.
   *@access public
   *@return [void|string]
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

  function render() {
  	return $this->build();
  }
}

/** A class for storing google_sitemap items and will be added to google_sitemap objects.
 *@author Svetoslav Marinov <svetoslav.marinov@gmail.com>
 *@copyright 2005
 *@access public
 *@link http://devquickref.com
 *@version 0.1
*/
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
	
  /** Assigns constructor parameters to their corresponding object properties.
   *@access public
   *@param string $loc location
   *@param string $lastmod date (optional) format in YYYY-MM-DD or in "ISO 8601" format
   *@param string $changefreq (optional)( always,hourly,daily,weekly,monthly,yearly,never )
   *@param string $priority (optional) current link's priority ( 0.0-1.0 )
   */
  function __construct($loc, $lastmod = '', $changefreq = '', $priority = '') {
    $this->loc = $loc;
    $this->lastmod = $lastmod;
    $this->changefreq = $changefreq;
    $this->priority = $priority;
  }
  
  public function setVideo($video_content, $video_title, $video_description = '', $video_thumbnail = '', $video_player_loc = '') {
  	$this->video_content = $video_content;
    $this->video_title = $video_title;
    $this->video_description = $video_description;
    $this->video_thumbnail = $video_thumbnail;
    $this->video_player_loc = $video_player_loc;
  } 
}

?>
