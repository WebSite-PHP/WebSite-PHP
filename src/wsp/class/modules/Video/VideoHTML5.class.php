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
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage Video
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.87
 */

class VideoHTML5 extends WebSitePhpObject {
	const STYLE_NONE = "";
	const STYLE_TUBE = "tube";
	
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
	
	private $onplay = "";
	private $onpause = "";
	private $onended = "";
	private $track_categ = "";
	private $track_action = "";
	private $track_label = "";
	private $display_download_link = false;
	/**#@-*/
	
	/**
	 * Constructor VideoHTML5
	 * @param integer $width 
	 * @param integer $height 
	 */
	function __construct($width, $height) {
		parent::__construct();
		
		if (!isset($width) || !isset($height)) {
			throw new NewException("2 arguments for ".get_class($this)."::__construct() are mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->width = $width;
		$this->height = $height;
		
		$this->addJavaScript(BASE_URL."wsp/js/video.js", "", true);
		$this->addCss(BASE_URL."wsp/css/video/video-js.css");
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
			throw new NewException("VideoHTML5->setVideo() error: MP4 video is mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->video_mp4 = $video_mp4;
		$this->video_webm = $video_webm;
		$this->video_ogg = $video_ogg;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setMP4Video
	 * @access public
	 * @param mixed $video_mp4 
	 * @return VideoHTML5
	 * @since 1.2.2
	 */
	public function setMP4Video($video_mp4) {
		if ($video_mp4 == "") {
			throw new NewException("VideoHTML5->setMp4Video() error: MP4 video is mandatory", 0, getDebugBacktrace(1));
		}
		$this->video_mp4 = $video_mp4;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setWebMVideo
	 * @access public
	 * @param mixed $video_webm 
	 * @return VideoHTML5
	 * @since 1.2.2
	 */
	public function setWebMVideo($video_webm) {
		if ($video_webm == "") {
			throw new NewException("VideoHTML5->setWebMVideo() error: WebM video is mandatory", 0, getDebugBacktrace(1));
		}
		$this->video_webm = $video_webm;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setOggVideo
	 * @access public
	 * @param mixed $video_ogg 
	 * @return VideoHTML5
	 * @since 1.2.2
	 */
	public function setOggVideo($video_ogg) {
		if ($video_ogg == "") {
			throw new NewException("VideoHTML5->setOggVideo() error: Ogg video is mandatory", 0, getDebugBacktrace(1));
		}
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
		$this->addCss(BASE_URL."wsp/css/video/video-".$this->style.".css", "", true);
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
		$this->autoplay = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setTrackEvent
	 * @access public
	 * @param mixed $category 
	 * @param mixed $action 
	 * @param string $label 
	 * @return VideoHTML5
	 * @since 1.0.99
	 */
	public function setTrackEvent($category, $action, $label='') {
		if (GOOGLE_CODE_TRACKER == "") {
			throw new NewException(get_class($this)."->setTrackEvent() error: please define google code tracker in the website configuration", 0, getDebugBacktrace(1));
		}
		$this->track_categ = $category;
		$this->track_action = $action;
		$this->track_label = $label;
		return $this;
	}
	
	/**
	 * Method onPlayJs
	 * @access public
	 * @param mixed $js_function 
	 * @return VideoHTML5
	 * @since 1.0.99
	 */
	public function onPlayJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onPlayJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onplay = trim($js_function);
		return $this;
	}
	
	/**
	 * Method getOnPlayJs
	 * @access public
	 * @return mixed
	 * @since 1.0.99
	 */
	public function getOnPlayJs() {
		return $this->onplay;
	}
	
	/**
	 * Method onPauseJs
	 * @access public
	 * @param mixed $js_function 
	 * @return VideoHTML5
	 * @since 1.0.99
	 */
	public function onPauseJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onPauseJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onpause = trim($js_function);
		return $this;
	}
	
	/**
	 * Method getOnPauseJs
	 * @access public
	 * @return mixed
	 * @since 1.0.99
	 */
	public function getOnPauseJs() {
		return $this->onpause;
	}
	
	/**
	 * Method onEndedJs
	 * @access public
	 * @param mixed $js_function 
	 * @return VideoHTML5
	 * @since 1.0.99
	 */
	public function onEndedJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onEndedJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onended = trim($js_function);
		return $this;
	}
	
	/**
	 * Method getOnEndedJs
	 * @access public
	 * @return mixed
	 * @since 1.0.99
	 */
	public function getOnEndedJs() {
		return $this->onended;
	}
	
	/**
	 * Method showDownloadLinks
	 * @access public
	 * @return VideoHTML5
	 * @since 1.2.2
	 */
	public function showDownloadLinks() {
		$this->display_download_link = true;
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
			throw new NewException("You must specify at least one video (please call method setVideo)", 0, getDebugBacktrace(1));
		}
		if ($this->video_mp4 == "") {
			throw new NewException("MP4 video is mandatory (please call method setVideo)", 0, getDebugBacktrace(1));
		}
		if ($this->snapshot == "") {
			throw new NewException("You must specified a snapshot (please call method setSnapshot)", 0, getDebugBacktrace(1));
		}
		
		if (strtoupper(substr($this->snapshot, 0, 7)) != "HTTP://" && strtoupper(substr($this->snapshot, 0, 8)) != "HTTPS://") {
			$this->snapshot = BASE_URL.$this->snapshot;
		}
		if (strtoupper(substr($this->video_mp4, 0, 7)) != "HTTP://" && strtoupper(substr($this->video_mp4, 0, 8)) != "HTTPS://") {
			$this->video_mp4 = BASE_URL.$this->video_mp4;
		}
		if ($this->video_webm != "") {
			if (strtoupper(substr($this->video_webm, 0, 7)) != "HTTP://" && strtoupper(substr($this->video_webm, 0, 8)) != "HTTPS://") {
				$this->video_webm = BASE_URL.$this->video_webm;
			}
		}
		if ($this->video_ogg != "") {
			if (strtoupper(substr($this->video_ogg, 0, 7)) != "HTTP://" && strtoupper(substr($this->video_ogg, 0, 8)) != "HTTPS://") {
				$this->video_ogg = BASE_URL.$this->video_ogg;
			}
		}
		
		$html = "";
		$html .= "  <video id=\"video-".md5($this->video_mp4)."\" class=\"video-js";
		if ($this->style != "") {
			$html .= " ".$this->style."css";
		}
		$html .= "\" width=\"".$this->width."\" height=\"".$this->height."\" controls poster=\"".$this->snapshot."\"".($this->autoplay?" autoplay=\"true\"":"").($this->autobuffering?" preload=\"auto\"":"").">\n";
		if ($this->video_mp4 != "") {
			$html .= "    <source src=\"".$this->video_mp4."\" type='video/mp4' />\n";
		}
		if ($this->video_webm != "") {
			$html .= "    <source src=\"".$this->video_webm."\" type='video/webm' />\n";
		}
		if ($this->video_ogg != "") {
			$html .= "    <source src=\"".$this->video_ogg."\" type='video/ogg' />\n";
		}
		if ($this->video_mp4 != "") {
			$html .= "    <object class=\"vjs-flash-fallback\" width=\"".$this->width."\" height=\"".$this->height."\" type=\"application/x-shockwave-flash\"\n";
			$html .= "      data=\"".BASE_URL."wsp/flash/flowplayer.swf\">\n";
			$html .= "      <param name=\"movie\" value=\"".BASE_URL."wsp/flash/flowplayer.swf\" />\n";
			$html .= "      <param name=\"allowfullscreen\" value=\"true\" />\n";
			$html .= "      <param name=\"flashvars\" value='config={\"playlist\":[\"".$this->snapshot."\", {\"url\": \"".$this->video_mp4."\",\"autoPlay\":".($this->autoplay?"true":"false").",\"autoBuffering\":".($this->autobuffering?"true":"false")."}]}' />\n";
			$html .= "      <img src=\"".$this->snapshot."\" width=\"".$this->width."\" height=\"".$this->height."\" alt=\"".__(MOD_VID_NO_VIDEO)."\"\n";
			$html .= "        title=\"".__(MOD_VID_NO_VIDEO)."\" />\n";
			$html .= "    </object>\n";
		}
		$html .= "  </video>\n";
		if ($this->display_download_link) {
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
		}
		
		$html .= $this->getJavascriptTagOpen();
		$html .= "	_V_(\"video-".md5($this->video_mp4)."\").ready(function() {\n";
		$html .= "	var video_".md5($this->video_mp4)." = this;\n";
		if ($this->track_categ != "" || $this->onplay != "") {
			$html .= "	video_".md5($this->video_mp4).".addEvent(\"play\", function(){\n";
			if (GOOGLE_CODE_TRACKER != "" && !isLocalDebug() && 
				!defined('GOOGLE_CODE_TRACKER_NOT_ACTIF')) {
					if ($this->track_categ != "") {
						$html .= "if (isGoogleAnalyticsLoaded()) { ga('send', 'event', '".addslashes($this->track_categ)."', '".addslashes($this->track_action)."', '".addslashes($this->track_label)."'); }";
					}
			}
			if ($this->onplay != "") {
				$html .= $this->onplay;
			}
			$html .= "  });\n";
		}
		if ($this->onpause != "") {
			$html .= "	video_".md5($this->video_mp4).".addEvent(\"pause\", function(){\n";
			$html .= $this->onpause;
			$html .= "  });\n";
		}
		if ($this->onended != "") {
			$html .= "	video_".md5($this->video_mp4).".addEvent(\"ended\", function(){\n";
			$html .= $this->onended;
			$html .= "  });\n";
		}
		$html .= "	});\n";
		$html .= $this->getJavascriptTagClose();
		
		
		$this->object_change = false;
		return $html;
	}
}
?>
