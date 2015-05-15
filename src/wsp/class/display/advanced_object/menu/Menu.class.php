<?php
/**
 * PHP file wsp\class\display\advanced_object\menu\Menu.class.php
 * @package display
 * @subpackage advanced_object.menu
 */
/**
 * Class Menu
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.menu
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

// Website JS/Css => http://www.twinhelix.com/dhtml/fsmenu/

class Menu extends WebSitePhpObject {
	/**#@+
	* Menu position style
	* @access public
	* @var string
	*/
	const POSITION_VERTICAL = "Vertical";
	const POSITION_HORIZONTAL = "Horizontal";
	const POSITION_NAV_BAR = "Nav Bar";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $id = "";
	private $position = "";
	private $menu_items = null;
	private $max_width = -1;
	private $min_width = -1;
	
	private $is_supersubs = false;
	/**#@-*/
	
	/**
	 * Constructor Menu
	 * @param string $position [default value: Horizontal]
	 * @param string $id [default value: listMenu]
	 */
	function __construct($position='Horizontal', $id='listMenu') {
		parent::__construct();
		
		$this->id = $id;
		
		$this->addCss(BASE_URL."wsp/css/menu/superfish.css", "", true);
		
		$this->addJavaScript(BASE_URL."wsp/js/menu/hoverIntent.js", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/menu/jquery.bgiframe.min.js", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/menu/superfish.js", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/menu/supersubs.js", "", true);
		
		$this->setPosition($position);
	}
	
	/**
	 * Method setMenuItems
	 * @access public
	 * @param MenuItems $menu_items_object 
	 * @return Menu
	 * @since 1.0.35
	 */
	public function setMenuItems($menu_items_object) {
		if (get_class($menu_items_object) != "MenuItems") {
			throw new NewException("Error Menu->setMenuItems(): menu_items_object is not a MenuItems object", 0, getDebugBacktrace(1));
		}
		$this->menu_items = $menu_items_object;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setPosition
	 * @access public
	 * @param mixed $position 
	 * @return Menu
	 * @since 1.0.35
	 */
	public function setPosition($position) {
		if ($position != Menu::POSITION_VERTICAL && $position != Menu::POSITION_HORIZONTAL
			&& $position != Menu::POSITION_NAV_BAR) {
			throw new NewException("Menu position ".$position." doesn't exist", 0, getDebugBacktrace(1));
		}
		
		if ($position == Menu::POSITION_VERTICAL) {
			$this->addCss(BASE_URL."wsp/css/menu/superfish-vertical.css", "", true); 
		} else if ($position == Menu::POSITION_NAV_BAR) {
			$this->addCss(BASE_URL."wsp/css/menu/superfish-navbar.css", "", true); 
		}
		
		$this->position = $position;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method activateSupersubs
	 * @access public
	 * @return Menu
	 * @since 1.0.35
	 */
	public function activateSupersubs() {
		$this->is_supersubs = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setMaxWidth
	 * @access public
	 * @param mixed $max_width 
	 * @return Menu
	 * @since 1.0.35
	 */
	public function setMaxWidth($max_width) {
		$this->max_width = $max_width;
		$this->is_supersubs = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setMinWidth
	 * @access public
	 * @param mixed $min_width 
	 * @return Menu
	 * @since 1.0.35
	 */
	public function setMinWidth($min_width) {
		$this->min_width = $min_width;
		$this->is_supersubs = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Menu
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";
		
		if ($this->menu_items != null) {
			$this->menu_items->setMenuRoot($this->id)->setPosition($this->position);
			$html .= $this->menu_items->render(false);
			
			$html .= $this->getJavascriptTagOpen();
			$html .= "	if ($.browser.mozilla && parseFloat($.browser.version) < 1.9 && navigator.appVersion.indexOf('Mac') !== -1) $('body').css('-moz-opacity',.999);\n";
			$html .= "	$(document).ready(function(){\n";
			$html .= "		$(\"#".$this->id."\")";
			if ($this->is_supersubs && $this->position != Menu::POSITION_NAV_BAR) {
				$html .= ".supersubs({";
				$supersubs_option = "";
				if ($this->min_width > 0) {
					if ($supersubs_option != "") { $supersubs_option .= ", "; }
					$supersubs_option .= "minWidth: ".$this->min_width;
				}
				if ($this->max_width > 0) {
					if ($supersubs_option != "") { $supersubs_option .= ", "; }
					$supersubs_option .= "maxWidth: ".$this->max_width;
				}
				$html .= "})";
			}
			$html .= ".superfish({";
			$option = "";
			if ($this->position == Menu::POSITION_NAV_BAR) {
				if ($option != "") { $option .= ", "; }
				$option .= "pathClass: 'current'";
			}
			$html .= $option."}).find('ul').bgIframe({opacity:false});\n";
			$html .= "	});\n";
			$html .= $this->getJavascriptTagClose();
		}
		$this->object_change = false;
		return $html;
	}
}
?>
