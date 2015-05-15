<?php
/**
 * PHP file wsp\class\modules\Video\VideoFlv.class.php
 * @package modules
 * @subpackage Video
 */
/**
 * Class VideoFlv
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
 * @since       1.0.17
 */

class VideoFlv extends WebSitePhpObject {
	const CONTROLBAR_NONE = "none";
	const CONTROLBAR_BOTTOM = "bottom";
	const CONTROLBAR_TOP = "top";
	const CONTROLBAR_OVER = "over";
	
	const REPEAT_NONE = "none";
	const REPEAT_ALWAYS = "always";
	const REPEAT_LIST = "list";
	
	/**#@+
	* @access private
	*/
	private $id = "";
	private $video = "";
	private $width = 0;
	private $height = 0;
	private $snapshot = "";
	private $autostart = false;
	private $screencolor = "";
	private $controlbar = "";
	private $repeat = "";
	/**#@-*/
	
	/**
	 * Constructor VideoFlv
	 * @param string $id 
	 * @param string $video 
	 * @param integer $width 
	 * @param integer $height 
	 * @param string $snapshot 
	 */
	function __construct($id, $video, $width, $height, $snapshot='') {
		parent::__construct();
		
		if (!isset($id) || !isset($video) || !isset($width) || !isset($height)) {
			throw new NewException("4 arguments for ".get_class($this)."::__construct() are mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->id = $id;
		$this->video = $video;
		$this->width = $width;
		$this->height = $height;
		$this->snapshot = $snapshot;
		
		$this->addJavaScript(BASE_URL."wsp/js/swfobject.js", "", true);
	}
	
	/**
	 * Method setSnapshot
	 * @access public
	 * @param string $snapshot 
	 * @return Video
	 * @since 1.0.35
	 */
	public function setSnapshot($snapshot) {
		$this->snapshot = $snapshot;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setScreencolor
	 * @access public
	 * @param string $screencolor 
	 * @return Video
	 * @since 1.0.35
	 */
	public function setScreencolor($screencolor) {
		$this->screencolor = $screencolor;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setControlbar
	 * @access public
	 * @param string $controlbar 
	 * @return Video
	 * @since 1.0.35
	 */
	public function setControlbar($controlbar) {
		$this->controlbar = $controlbar;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setRepeat
	 * @access public
	 * @param string $repeat 
	 * @return Video
	 * @since 1.0.35
	 */
	public function setRepeat($repeat) {
		$this->repeat = $repeat;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method activeAutostart
	 * @access public
	 * @return Video
	 * @since 1.0.35
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
	 * @return string html code of object Video
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$video_object = new SwfObject($this->id, BASE_URL."wsp/flash/mediaplayer.swf", $this->width, $this->height);
		$video_object->addParam("allowfullscreen","true");
		if (strtoupper(substr($this->video, 0, 7)) != "HTTP://" && strtoupper(substr($this->video, 0, 8)) != "HTTPS://") {
			$this->video = BASE_URL.$this->video;
		}
		$video_object->addVariable("file",$this->video);
		$video_object->addVariable("autostart",($this->autostart)?"true":"false");
		if ($this->controlbar != "") {
			$video_object->addVariable("controlbar",$this->controlbar);
		}
		if ($this->screencolor != "") {
			$video_object->addVariable("screencolor",$this->screencolor);
		}
		if ($this->snapshot != "") {
			if (strtoupper(substr($this->snapshot, 0, 7)) != "HTTP://" && strtoupper(substr($this->snapshot, 0, 8)) != "HTTPS://") {
				$this->snapshot = BASE_URL.$this->snapshot;
			}
			$video_object->addVariable("image",$this->snapshot);
		}
		if ($this->repeat != "") {
			$video_object->addVariable("repeat",$this->repeat);
		}
		$this->object_change = false;
		return $video_object->render();
	}
}
?>
