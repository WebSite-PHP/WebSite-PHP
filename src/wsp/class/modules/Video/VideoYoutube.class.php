<?php
/**
 * PHP file wsp\class\modules\Video\VideoYoutube.class.php
 * @package modules
 * @subpackage Video
 */
/**
 * Class VideoYoutube
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
 * @since       1.2.10
 */

class VideoYoutube extends WebSitePhpObject {
	const THEME_NONE = "";
	const THEME_LIGHT = "light";
	const THEME_DARK = "dark";
	
	/**#@+
	* @access private
	*/
	private $youtube_video_key = "";
	private $width = 560;
	private $height = 315;
	
	private $theme = "";
	private $autoplay = false;
	private $related_video = true;
	private $control_bar = true;
	private $show_title = true;
	/**#@-*/
	
	/**
	 * Constructor VideoYoutube
	 * @param mixed $youtube_video_key 
	 * @param integer $width 
	 * @param integer $height 
	 */
	function __construct($youtube_video_key, $width, $height) {
		parent::__construct();
		
		if (!isset($youtube_video_key) && !isset($width) && !isset($height)) {
			throw new NewException("3 arguments for ".get_class($this)."::__construct() are mandatory", 0, getDebugBacktrace(1));
		}

		$this->youtube_video_key = $youtube_video_key;
		$this->width = $width;
		$this->height = $height;
	}
	
	/**
	 * Method disableRelatedVideo
	 * @access public
	 * @return VideoYoutube
	 * @since 1.2.10
	 */
	public function disableRelatedVideo() {
		$this->related_video = false;
		return $this;
	}
	
	/**
	 * Method disableControlBar
	 * @access public
	 * @return VideoYoutube
	 * @since 1.2.10
	 */
	public function disableControlBar() {
		$this->control_bar = false;
		return $this;
	}
	
	/**
	 * Method disableTitle
	 * @access public
	 * @return VideoYoutube
	 * @since 1.2.10
	 */
	public function disableTitle() {
		$this->show_title = false;
		return $this;
	}
	
	/**
	 * Method activateAutoPlay
	 * @access public
	 * @return VideoYoutube
	 * @since 1.2.10
	 */
	public function activateAutoPlay() {
		$this->autoplay = true;
		return $this;
	}
	
	/**
	 * Method setTheme
	 * @access public
	 * @param mixed $theme 
	 * @return VideoYoutube
	 * @since 1.2.10
	 */
	public function setTheme($theme) {
		$this->theme = $theme;
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object VideoYoutube
	 * @since 1.2.10
	 */
	public function render($ajax_render=false) {
		$html = "";
        if ($this->getPage()->isThirdPartyCookiesFilterEnable()) {
            $html .= "<div class=\"youtube_player\" videoID=\"".$this->youtube_video_key."\" width=\"".$this->width."\" height=\"".$this->height."\"";
            if (!$this->related_video) {
                $html .= " rel=\"0\"";
            }
            if (!$this->control_bar) {
                $html .= " controls=\"0\"";
            }
            if (!$this->show_title) {
                $html .= " showinfo=\"0\"";
            }
            if ($this->autoplay) {
                $html .= " autoplay=\"1\"";
            }
            if ($this->theme != "") {
                $html .= " theme=\"" . $this->theme."\"";
            }
            if ($this->width != "" || $this->height != "") {
                $html .= " style=\"";
                if ($this->width != "") {
                    $html .= "width:".$this->width."px;";
                }
                if ($this->height != "") {
                    $html .= "height:".$this->height."px;";
                }
                $html .= "\"";
            }
            $html .= "></div>";
            $html .= "<script type=\"text/javascript\">(tarteaucitron.job = tarteaucitron.job || []).push('youtube');</script>";
        } else {
            $html .= "<iframe width=\"".$this->width."\" height=\"".$this->height."\" src=\"//www.youtube.com/embed/".$this->youtube_video_key."?";
            if (!$this->related_video) {
                $html .= "&amp;rel=0";
            }
            if (!$this->control_bar) {
                $html .= "&amp;controls=0";
            }
            if (!$this->show_title) {
                $html .= "&amp;showinfo=0";
            }
            if ($this->autoplay) {
                $html .= "&amp;autoplay=1";
            }
            if ($this->theme != "") {
                $html .= "&amp;theme=" . $this->theme;
            }
            $html .= "\" frameborder=\"0\" allowfullscreen></iframe>\n";
        }
		$this->object_change = false;
		return $html;
	}
}
?>
