<?php
/**
 * Description of PHP file wsp\class\display\advanced_object\menu\dockmenu\DockMenuItem.class.php
 * Class DockMenuItem
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
	
	function __construct($img, $value, $link='') {
		parent::__construct();
		
		if (!isset($img) && !isset($value)) {
			throw new NewException("2 arguments for ".get_class($this)."::__construct() are mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->img = $img;
		$this->value = $value;
		$this->link = $link;
	}
	
	public function setLink($link) {
		$this->link = $link;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
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
