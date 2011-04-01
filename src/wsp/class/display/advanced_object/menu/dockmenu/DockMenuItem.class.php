<?php
/**
 * PHP file wsp\class\display\advanced_object\menu\dockmenu\DockMenuItem.class.php
 * @package display
 * @subpackage advanced_object.menu.dockmenu
 */
/**
 * Class DockMenuItem
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.menu.dockmenu
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 22/10/2010
 * @version     1.0.68
 * @access      public
 * @since       1.0.17
 */

// Website JS/Css => http://positionabsolute.net/blog/2007/08/prototype-fisheye.php

class DockMenuItem extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $value = "";
	private $link = "";
	private $img = "";
	
	private $valign = "bottom";
	/**#@-*/
	
	/**
	 * Constructor DockMenuItem
	 * @param mixed $img 
	 * @param mixed $value 
	 * @param string $link 
	 */
	function __construct($img, $value, $link='') {
		parent::__construct();
		
		if (!isset($img) && !isset($value)) {
			throw new NewException("2 arguments for ".get_class($this)."::__construct() are mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->img = $img;
		$this->value = $value;
		$this->link = $link;
	}
	
	/**
	 * Method setLink
	 * @access public
	 * @param mixed $link 
	 * @return DockMenuItem
	 * @since 1.0.35
	 */
	public function setLink($link) {
		$this->link = $link;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object DockMenuItem
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";
		
		if (gettype($this->img) == "object") {
			$this->img = $this->img->getSrc();
		}
		
		$html .= "<a href=\"".createHrefLink($this->link)."\">"; 
		$html .= "<img src=\"".$this->img."\" border=\"0\" alt=\"".str_replace("\"", " ", $this->value)."\" title=\"".str_replace("\"", " ", $this->value)."\" />";
		$html .= "</a>\n";
		$this->object_change = false;
		return $html;
	}
}
?>
