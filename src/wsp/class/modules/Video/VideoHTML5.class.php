<?php
/**
 * PHP file wsp\class\modules\Video\VideoHTML5.class.php
 * @package modules
 * @subpackage Video
 */
/**
 * Class VideoHTML5
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage Video
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 20/06/2011
 * @version     1.0.87
 * @access      public
 * @since       1.0.87
 */

class VideoHTML5 extends WebSitePhpObject {
	const STYLE_NONE = "";
	const STYLE_TUBE = "tube";
	const STYLE_VIM = "vim";
	const STYLE_HU = "hu";
	
	/**#@+
	* @access private
	*/
	private $video_mp4 = "";
	private $video_webm = "";
	private $video_ogg = "";
	private $width = 0;
	private $height = 0;
	private $snapshot = "";
	private $autoplay = false;
	private $autobuffering = true;
	private $style = "";
	/**#@-*/
	
	/**
	 * Constructor VideoHTML5
	 * @param integer $width 
	 * @param integer $height 
	 */
	function __construct($width, $height) {
		parent::__construct();
		
		if (!isset($width) || !isset($height)) {
			throw new NewException("2 arguments for ".get_class($this)."::__construct() are mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->width = $width;
		$this->height = $height;
		
		$this->addJavaScript(BASE_URL."wsp/js/video.js", "", true);
		$this->addCss(BASE_URL."wsp/css/video/video-js.css", "", true);
	}
	
	/**
	 * Method setVideo
	 * @access public
	 * @param mixed $video_mp4 
	 * @param string $video_webm 
	 * @param string $video_ogg 
	 * @return VideoHTML5
	 * @since 1.0.87
	 */
	public function setVideo($video_mp4, $video_webm='', $video_ogg='') {
		if ($video_mp4 == "") {
			throw new NewException("VideoHTML5->setVideo() error: MP4 video is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->video_mp4 = $video_mp4;
		$this->video_webm = $video_webm;
		$this->video_ogg = $video_ogg;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setSnapshot
	 * @access public
	 * @param mixed $snapshot 
	 * @return VideoHTML5
	 * @since 1.0.87
	 */
	public function setSnapshot($snapshot) {
		$this->snapshot = $snapshot;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setStyle
	 * @access public
	 * @param mixed $style 
	 * @return VideoHTML5
	 * @since 1.0.87
	 */
	public function setStyle($style) {
		$this->style = $style;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setAutoBuffering
	 * @access public
	 * @param mixed $autobuffering 
	 * @return VideoHTML5
	 * @since 1.0.87
	 */
	public function setAutoBuffering($autobuffering) {
		$this->autobuffering = $autobuffering;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method activeAutostart
	 * @access public
	 * @return VideoHTML5
	 * @since 1.0.87
	 */
	public function activeAutostart() {
		$this->autostart = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object VideoHTML5
	 * @since 1.0.87
	 */
	public function render($ajax_render=false) {
		if ($this->video_mp4 == "" && $this->video_webm == "" && $this->video_ogg == "") {
			throw new NewException("You must specify at least one video (please call method setVideo)", 0, 8, __FILE__, __LINE__);
		}
		if ($this->video_mp4 == "") {
			throw new NewException("MP4 video is mandatory (please call method setVideo)", 0, 8, __FILE__, __LINE__);
		}
		
		if ($this->style != "") {
			$this->addCss(BASE_URL."wsp/css/video/video-".$this->style.".css", "", true);
		}
		
		$html = "";
		$html .= "<div class=\"video-js-box";
		if ($this->style != "") {
			$html .= " ".$this->style."-css";
		}
		$html .= "\" width=\"".$this->width."\">\n";
		$html .= "  <video class=\"video-js\" width=\"".$this->width."\" height=\"".$this->height."\" controls preload poster=\"".$this->snapshot."\">\n";
		if ($this->video_mp4 != "") {
			$html .= "    <source src=\"".$this->video_mp4."\" type='video/mp4; codecs=\"avc1.42E01E, mp4a.40.2\"' />\n";
		}
		if ($this->video_webm != "") {
			$html .= "    <source src=\"".$this->video_webm."\" type='video/webm; codecs=\"vp8, vorbis\"' />\n";
		}
		if ($this->video_ogg != "") {
			$html .= "    <source src=\"".$this->video_ogg."\" type='video/ogg; codecs=\"theora, vorbis\"' />\n";
		}
		if ($this->video_mp4 != "") {
			$html .= "    <object class=\"vjs-flash-fallback\" width=\"".$this->width."\" height=\"".$this->height."\" type=\"application/x-shockwave-flash\"\n";
			$html .= "      data=\"".BASE_URL."wsp/flash/flowplayer.swf\">\n";
			$html .= "      <param name=\"movie\" value=\"".BASE_URL."wsp/flash/flowplayer.swf\" />\n";
			$html .= "      <param name=\"allowfullscreen\" value=\"true\" />\n";
			$html .= "      <param name=\"flashvars\" value='config={\"playlist\":[\"".$this->snapshot."\", {\"url\": \"".$this->video_mp4."\",\"autoPlay\":".($this->autoplay?"true":"false").",\"autoBuffering\":".($this->autobuffering?"true":"false")."}]}' />\n";
			$html .= "      <img src=\"".$this->snapshot."\" width=\"".$this->width."\" height=\"".$this->height."\" alt=\"Poster Image\"\n";
			$html .= "        title=\"".__(MOD_VID_NO_VIDEO)."\" />\n";
			$html .= "    </object>\n";
		}
		$html .= "  </video>\n";
		$html .= "  <p class=\"vjs-no-video\"><strong>".__(MOD_VID_DOWNLOAD_VIDEO).":</strong>\n";
		if ($this->video_mp4 != "") {
			$html .= "    <a href=\"".$this->video_mp4."\">MP4</a>,\n";
		}
		if ($this->video_webm != "") {
			$html .= "    <a href=\"".$this->video_webm."\">WebM</a>,\n";
		}
		if ($this->video_ogg != "") {
			$html .= "    <a href=\"".$this->video_ogg."\">Ogg</a><br>\n";
		}
		$html .= "  </p>\n";
		$html .= "</div>\n";
		
		$html .= $this->getJavascriptTagOpen();
		$html .= "	VideoJS.setupAllWhenReady();\n";
		$html .= $this->getJavascriptTagClose();
		
		
		$this->object_change = false;
		return $html;
	}
}
?>
