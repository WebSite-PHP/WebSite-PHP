<?php
/**
 * PHP file wsp\class\display\LinkPage.class.php
 * @package display
 */
/**
 * Class LinkPage
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

class LinkPage extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $page = "";
	private $picture_16 = "";
	private $object = null;
	private $get = "";
	private $tagH = "";
	private $tagH_bold = false;
	
	private $track_categ = "";
	private $track_action = "";
	private $track_label = "";
	/**#@-*/
	
	/**
	 * Constructor LinkPage
	 * @param mixed $page 
	 * @param mixed $title_object 
	 * @param string $picture_16 
	 */
	function __construct($page, $title_object, $picture_16='') {
		parent::__construct();
		
		if (!isset($page) || !isset($title_object)) {
			throw new NewException("2 argument for ".get_class($this)."::__construct() are mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->page = $page;
		$this->object = $title_object;
		$this->picture_16 = $picture_16;
		$this->tagH = "";
	}
	
	/**
	 * Method setGetParameters
	 * @access public
	 * @param mixed $get 
	 * @return LinkPage
	 * @since 1.0.35
	 */
	public function setGetParameters($get) {
		$this->get = $get;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setTitleTagH1
	 * @access public
	 * @param boolean $bold [default value: true]
	 * @return LinkPage
	 * @since 1.0.35
	 */
	public function setTitleTagH1($bold=true) {
		$this->tagH = "1";
		$this->tagH_bold = $bold;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setTitleTagH2
	 * @access public
	 * @param boolean $bold [default value: false]
	 * @return LinkPage
	 * @since 1.0.35
	 */
	public function setTitleTagH2($bold=false) {
		$this->tagH = "2";
		$this->tagH_bold = $bold;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setTitleTagH
	 * @access public
	 * @param mixed $value 
	 * @param boolean $bold [default value: false]
	 * @return LinkPage
	 * @since 1.0.35
	 */
	public function setTitleTagH($value, $bold=false) {
		$this->tagH = $value;
		$this->tagH_bold = $bold;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setTrackEvent
	 * @access public
	 * @param mixed $category 
	 * @param mixed $action 
	 * @param string $label 
	 * @return LinkPage
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
	 * Method getUserHaveRights
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getUserHaveRights() {
		$tmp_link = new Link($this->page, Link::TARGET_NONE);
		return $tmp_link->getUserHaveRights();
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return mixed
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$link_obj = new Object($this->object);
		if ($this->picture_16 != "") {
			$link_obj = new Object(new Picture($this->picture_16, 16, 16, 0, Picture::ALIGN_ABSMIDDLE, $this->object), $this->object);
		} 
		if (strtoupper($this->page) == "HOME") {
			$link_url = BASE_URL.$_SESSION['lang']."/";
		} else if (find($this->page, ".html") == 0) {
			$link_url = $this->page.".html";
		} else {
			$link_url = $this->page;
		}
		if ($this->get != "") {
			if ($this->get[0] == "?") {
				$link_url .= $this->get;
			} else {
				$link_url .= "?".$this->get;
			} 
		}
		$html = new Link($link_url, Link::TARGET_NONE, $link_obj);
		if ($this->track_categ != "") {
			$html->setTrackEvent($this->track_categ, $this->track_action, $this->track_label);
		}
		if ($this->tagH != "") {
			$html->setTitleTagH($this->tagH, $this->tagH_bold);
		}
		$this->object_change = false;
		return $html->render();
	}
}
?>
