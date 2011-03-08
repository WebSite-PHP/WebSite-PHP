<?php
/**
 * PHP file wsp\class\display\Link.class.php
 * @package display
 */
/**
 * Class Link
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 22/10/2010
 * @version     1.0.57
 * @access      public
 * @since       1.0.17
 */

class Link extends WebSitePhpObject {
	const TARGET_BLANK = "_blank";
	const TARGET_SELF = "_self";
	const TARGET_NONE = "";
	
	private static $array_lightbox = array();
	
	/**#@+
	* @access private
	*/
	private $link = "";
	private $target = "";
	private $content = null;
	private $tagH = "";
	private $tagH_bold = false;
	
	private $is_lightbox = false;
	private $lightbox_name = "";
	/**#@-*/
	
	/**
	 * Constructor Link
	 * @param mixed $link 
	 * @param string $target 
	 * @param object $content [default value: null]
	 */
	function __construct($link, $target='', $content=null) {
		parent::__construct();
		
		if (!isset($link)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->link = $link;
		$this->target = $target;
		$this->content = $content;
		$this->tagH = "";
	}
	
	/**
	 * Method setContent
	 * @access public
	 * @param object $content 
	 * @return Link
	 * @since 1.0.35
	 */
	public function setContent($content) {
		$this->content = $content;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setTitleTagH1
	 * @access public
	 * @param boolean $bold [default value: true]
	 * @return Link
	 * @since 1.0.35
	 */
	public function setTitleTagH1($bold=true) {
		$this->tagH = "h1";
		$this->tagH_bold = $bold;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setTitleTagH2
	 * @access public
	 * @param boolean $bold [default value: false]
	 * @return Link
	 * @since 1.0.35
	 */
	public function setTitleTagH2($bold=false) {
		$this->tagH = "h2";
		$this->tagH_bold = $bold;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setTitleTagH
	 * @access public
	 * @param mixed $value 
	 * @param boolean $bold [default value: false]
	 * @return Link
	 * @since 1.0.35
	 */
	public function setTitleTagH($value, $bold=false) {
		$this->tagH = "h".$value;
		$this->tagH_bold = $bold;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
		
	/**
	 * Method addLightbox
	 * @access public
	 * @param string $lightbox_name 
	 * @return Link
	 * @since 1.0.35
	 */
	public function addLightbox($lightbox_name='') {
		$this->is_lightbox = true;
		$this->lightbox_name = $lightbox_name;
		
		if (!isset(self::$array_lightbox[$this->lightbox_name])) {
			self::$array_lightbox[$this->lightbox_name] = false;
		}
		
		$this->addCss(BASE_URL."wsp/css/jquery.lightbox-0.5.css", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/jquery.lightbox-0.5.min.js", "", true);
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method getLink
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getLink() {
		return $this->link;
	}
	
	/**
	 * Method getTarget
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getTarget() {
		return $this->target;
	}
	
	/**
	 * Method getUserHaveRights
	 * @access public
	 * @return boolean
	 * @since 1.0.35
	 */
	public function getUserHaveRights() {
		// check user have right to view this local link
		if (gettype($this->link) == "object") {
			if (get_class($this->link) == "Link") {
				$tmp_link = $this->link->getLink();
			} else {
				if (get_class($this->link) == "DialogBox") {
					$this->link->displayFormURL();
				}
				if (method_exists($this->link, "render")) {
					$tmp_link = $this->link->render();
				} else {
					$tmp_link = $this->link;
				}
			}
		} else {
			$tmp_link = $this->link;
		}
		if (strtoupper(substr($tmp_link, 0, 11)) != "JAVASCRIPT:" && 
			strtoupper(substr($tmp_link, 0, 7)) != "MAILTO:" &&
			strtoupper(substr($tmp_link, 0, 6)) != "FTP://" &&
			strtoupper(substr($tmp_link, 0, 1)) != "#") {
			if (strtoupper(substr($tmp_link, 0, strlen(BASE_URL))) == strtoupper(BASE_URL)
				|| strtoupper(substr($tmp_link, 0, 7)) != "HTTP://") {
				
				$array_url = explode("\?", $tmp_link);
				$temp_class_name = str_replace(".html", "", str_replace(BASE_URL, "", str_replace(BASE_URL.$_SESSION['lang']."/", "", $array_url[0])));
				if ($temp_class_name == "") {
					$temp_class_name = "home";
				}
				if (file_exists("pages/".$temp_class_name.".php")) {
					$page_obj = Page::getInstance($temp_class_name);
					if (!$page_obj->userHaveRights()) {
						return false;
					}
				} else {
					$pos = find($tmp_link, "?p=", 1, 0);
					if ($pos == 0) {
						$pos = find($tmp_link, "&p=", 1, 0);
					}
					if ($pos > 0) {
						$pos2 = find($tmp_link, "&", 1, $pos)-1;
						if ($pos2 == -1) {
							$pos2 = strlen($tmp_link);
						}
						$page_name = substr($tmp_link, $pos, $pos2-$pos);
						if (file_exists("pages/".$page_name.".php")) {
							$page_obj = Page::getInstance($page_name);
							if (!$page_obj->userHaveRights()) {
								return false;
							}
						}
					}
				}
			}
			if (strtoupper(substr($tmp_link, 0, 7)) != "HTTP://") {	
				// it's a local URL
				if (strtoupper(substr($tmp_link, 0, strlen(BASE_URL))) != strtoupper(BASE_URL)) {
					$this->link = BASE_URL.$_SESSION['lang']."/".$this->link;
				}
			}
		}
		return true;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Link
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		if (!$this->getUserHaveRights()) {
			return "";
		}
		
		// write link
		$html = "";
		if ($this->tagH != "") {
			$html .= "<".$this->tagH.">";
		}
		
		$html .= "<a href=\"".createHrefLink($this->link, $this->target)."\"";
		if ($this->is_lightbox) {
			$html .= " rel=\"lightbox";
			if ($this->lightbox_name != "") {
				$html .= $this->lightbox_name;
			}
			$html .= "\"";
		}
		if ($this->tagH != "") {
			if ($this->tagH == "h1" && !$this->tagH_bold) {
				$html .= " style=\"font-weight:normal;\"";
			} else if ($this->tagH != "h1" && $this->tagH_bold) {
				$html .= " style=\"font-weight:bold;\"";
			}
		}
		$html .= ">";
		if (gettype($this->content) == "object" && method_exists($this->content, "render")) {
			$html .= $this->content->render();
		} else {
			$html .= $this->content;
		}
		$html .= "</a>";
		if ($this->tagH != "") {
			$html .= "</".$this->tagH.">";
		}
		
		if ($this->is_lightbox) {
			if (!self::$array_lightbox[$this->lightbox_name]) {
				$html .= $this->getJavascriptTagOpen();
				$html .= "$(function() { $('a[rel=lightbox";
				if ($this->lightbox_name != "") {
					$html .= $this->lightbox_name;
				}
				$html .= "]').lightBox(); });\n";
				$html .= $this->getJavascriptTagClose();
				self::$array_lightbox[$this->lightbox_name] = true;
			}
		}
		$this->object_change = false;
		return $html;
	}
}
?>
