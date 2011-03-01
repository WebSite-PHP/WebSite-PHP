<?php
/**
 * Description of PHP file wsp\class\display\advanced_object\Video.class.php
 * Class Video
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 22/10/2010
 *
 * @version     1.0.30
 * @access      public
 * @since       1.0.17
 */

class Video extends WebSitePhpObject {
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
	
	function __construct($id, $video, $width, $height, $snapshot='') {
		parent::__construct();
		
		if (!isset($id) || !isset($video) || !isset($width) || !isset($height)) {
			throw new NewException("4 arguments for ".get_class($this)."::__construct() are mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->id = $id;
		$this->video = $video;
		$this->width = $width;
		$this->height = $height;
		$this->snapshot = $snapshot;
		
		$this->addJavaScript(BASE_URL."wsp/js/swfobject.js", "", true);
	}
	
	public function setSnapshot($snapshot) {
		$this->snapshot = $snapshot;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setScreencolor($screencolor) {
		$this->screencolor = $screencolor;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setControlbar($controlbar) {
		$this->controlbar = $controlbar;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setRepeat($repeat) {
		$this->repeat = $repeat;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function activeAutostart() {
		$this->autostart = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function render($ajax_render=false) {
		$video_object = new SwfObject($this->id, BASE_URL."wsp/flash/mediaplayer.swf", $this->width, $this->height);
		$video_object->addParam("allowfullscreen","true");
		$video_object->addVariable("file",$this->video);
		$video_object->addVariable("autostart",($this->autostart)?"true":"false");
		if ($this->controlbar != "") {
			$video_object->addVariable("controlbar",$this->controlbar);
		}
		if ($this->screencolor != "") {
			$video_object->addVariable("screencolor",$this->screencolor);
		}if ($this->snapshot != "") {
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
