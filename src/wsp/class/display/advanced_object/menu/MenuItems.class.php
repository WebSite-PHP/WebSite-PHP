<?php
/**
 * PHP file wsp\class\display\advanced_object\menu\MenuItems.class.php
 * @package display
 * @subpackage advanced_object.menu
 */
/**
 * Class MenuItems
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

class MenuItems extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $menu_items = array();
	private $root_id = "";
	private $position = "";
	/**#@-*/
	
	/**
	 * Constructor MenuItems
	 * @param mixed $menu_item_object [default value: null]
	 * @param mixed $menu_item_object2 [default value: null]
	 * @param mixed $menu_item_object3 [default value: null]
	 * @param mixed $menu_item_object4 [default value: null]
	 * @param mixed $menu_item_object5 [default value: null]
	 */
	function __construct($menu_item_object=null, $menu_item_object2=null, $menu_item_object3=null, $menu_item_object4=null, $menu_item_object5=null) {
		parent::__construct();
		
		$args = func_get_args();
		for ($i=0; $i < sizeof($args); $i++) {
    		if ($args[$i] != null) {
				$this->add($args[$i]);
    		}
    	}
	}
	
	/**
	 * Method setMenuRoot
	 * @access public
	 * @param mixed $root_id 
	 * @return MenuItems
	 * @since 1.0.35
	 */
	public function setMenuRoot($root_id) {
		$this->root_id = $root_id;
		return $this;
	}
	
	/**
	 * Method setPosition
	 * @access public
	 * @param mixed $position 
	 * @return MenuItems
	 * @since 1.0.35
	 */
	public function setPosition($position) {
		$this->position = $position;
		return $this;
	}
	
	/**
	 * Method add
	 * @access public
	 * @param mixed $menu_item_object 
	 * @param mixed $menu_item_object2 [default value: null]
	 * @param mixed $menu_item_object3 [default value: null]
	 * @param mixed $menu_item_object4 [default value: null]
	 * @param mixed $menu_item_object5 [default value: null]
	 * @return MenuItems
	 * @since 1.0.35
	 */
	public function add($menu_item_object, $menu_item_object2=null, $menu_item_object3=null, $menu_item_object4=null, $menu_item_object5=null) {
		$args = func_get_args();
		$menu_item_object = array_shift($args);
		if (get_class($menu_item_object) != "MenuItem") {
			throw new NewException("Error MenuItems->add(): menu_item_object is not a MenuItem object", 0, getDebugBacktrace(1));
		}
		$this->menu_items[] = $menu_item_object;
    	for ($i=0; $i < sizeof($args); $i++) {
    		if ($args[$i] != null) {
				if (get_class($args[$i]) != "MenuItem") {
					throw new NewException("Error MenuItems->add(): menu_item_object is not a MenuItem object", 0, getDebugBacktrace(1));
				}
				$this->menu_items[] = $args[$i];
    		}
    	}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
    	return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object MenuItems
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";
		$html .= "<ul";
		if ($this->root_id != "") {
			$html .= " id=\"".$this->root_id."\" class=\"sf-menu";
			if ($this->position == Menu::POSITION_VERTICAL) {
				$html .= " sf-vertical";
			} else if ($this->position == Menu::POSITION_NAV_BAR) {
				$html .= " sf-navbar";
			} 
			$html .= "\"";
		}
		$html .= ">\n";
		for ($i=0; $i < sizeof($this->menu_items); $i++) {
			$html .= $this->menu_items[$i]->render();
		}
		$html .= "</ul>\n";
		$this->object_change = false;
		return $html;
	}
}
?>
