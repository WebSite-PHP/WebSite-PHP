<?php
/**
 * PHP file wsp\class\modules\Slider\ImageRotator.class.php
 * @package modules
 * @subpackage Slider
 */
/**
 * Class ImageRotator
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage Slider
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.2.1
 */

/**
 * PHP file wsp\class\modules\ImageRotator\ImageRotator.class.php
 * @package modules
 * @subpackage ImageRotator
 */
/**
 * Class ImageRotator
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2012 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage ImageRotator
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 20/06/2011
 * @version     1.1.12
 * @access      public
 * @since       1.0.17
 */

class ImageRotator extends WebSitePhpObject {
	const TRANSITION_LINES = "lines";
	const TRANSITION_RANDOM = "random";
	const TRANSITION_CIRCLES = "circles";
	const TRANSITION_FADE = "fade";
	const TRANSITION_SLOWFADE = "slowfade";
	const TRANSITION_BGFADE = "bgfade";
	const TRANSITION_BLOCKS = "blocks";
	const TRANSITION_BUBBLE = "bubbles";
	const TRANSITION_FLUIDS = "fluids";
	
	/**#@+
	* @access private
	*/
	private $id = "";
	private $width = 0;
	private $height = 0;
	
	private $navigation_bar = true;
	private $rotate_time = '';
	private $transition = 'blocks';
	private $is_link = false;
	
	private $array_img_src = array();
	private $array_img_title = array();
	private $array_img_link = array();
	/**#@-*/
	
	/**
	 * Constructor ImageRotator
	 * @param string $id 
	 * @param integer $width 
	 * @param integer $height 
	 * @param string $transition [default value: blocks]
	 * @param integer $rotate_time 
	 */
	function __construct($id, $width, $height, $transition='blocks', $rotate_time='') {
		parent::__construct();
		
		if (!isset($id) || !isset($width) || !isset($height)) {
			throw new NewException("3 arguments for ".get_class($this)."::__construct() are mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->id = $id;
		$this->width = $width;
		$this->height = $height;
		$this->transition = $transition;
		$this->rotate_time = $rotate_time;
		
		$this->addJavaScript(BASE_URL."wsp/js/swfobject.js", "", true);
	}
	
	/**
	 * Method addImage
	 * @access public
	 * @param string $src 
	 * @param string $title 
	 * @param string $link 
	 * @return ImageRotator
	 * @since 1.0.35
	 */
	public function addImage($src, $title='', $link='') {
		if (strtoupper(substr($src, 0, 7)) != "HTTP://" && strtoupper(substr($src, 0, 8)) != "HTTPS://") {
			$src = BASE_URL.$src;
		}
		$this->array_img_src[] = $src;
		$this->array_img_title[] = $title;
		$this->array_img_link[] = $link;
		if ($link != '') {
			$this->is_link = true;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method disableNavigationBar
	 * @access public
	 * @return ImageRotator
	 * @since 1.0.35
	 */
	public function disableNavigationBar() {
		$this->navigation_bar = false;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object ImageRotator
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		// remove old cache files
		$dirname = "wsp/cache/xml/image-rotator/";
		$dir = opendir($dirname); 
		while($file = readdir($dir)) {
			if($file != '.' && $file != '..' && !is_dir($dirname.$file)) {
				$filemtime = @filemtime($dirname.$file);
				if ($filemtime!= false && (time() - $filemtime >= 1800)) { // > 30 minutes
					$filedir = $dirname.$file;
					unlink($filedir);
				}
			}
		}
		closedir($dir);
		
		$file = $dirname.$this->id."-".session_id().".xml";
		$f = new File($file, false, true);
		$f->debug_mode(true);
		$data = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$data .= "<playlist version=\"1\" xmlns=\"http://xspf.org/ns/0/\">\n";
		$data .= "	<trackList>\n";
		for ($i=0; $i < sizeof($this->array_img_src); $i++) {
			$link = new Link($this->array_img_link[$i]);
			if ($link->getUserHaveRights()) {
				$data .= "		<track>\n";
				$data .= "			<title>".utf8encode($this->array_img_title[$i])."</title>\n";
				$data .= "			<creator>".utf8encode(SITE_NAME)."</creator>\n";
				$data .= "			<location>".$this->array_img_src[$i]."</location>\n";
				$data .= "			<info>".$this->array_img_link[$i]."</info>\n";
				$data .= "		</track>\n";
			}
		}
		$data .= "	</trackList>\n";
		$data .= "</playlist>\n";
		$f->write($data);
		$f->close();
		
		$video_object = new SwfObject($this->id, BASE_URL."wsp/flash/imagerotator.swf", $this->width, $this->height);
		$video_object->addParam("allowfullscreen","true");
		$video_object->addVariable("file",$file);
		if ($this->navigation_bar==false) {
			$video_object->addVariable("shownavigation","false");
		}
		if ($this->rotate_time != '') {
			$video_object->addVariable("rotatetime",$this->rotate_time);
		}
		if ($this->transition != '') {
			$video_object->addVariable("transition",$this->transition);
		}
		if ($this->is_link) {
			$video_object->addVariable("linkfromdisplay",'true');
		}
		$this->object_change = false;
		return $video_object->render();
	}
}
?>
