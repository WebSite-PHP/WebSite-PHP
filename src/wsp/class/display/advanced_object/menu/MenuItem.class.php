<?php
/**
 * PHP file wsp\class\display\advanced_object\menu\MenuItem.class.php
 * @package display
 * @subpackage advanced_object.menu
 */
/**
 * Class MenuItem
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

class MenuItem extends WebSitePhpObject {
	/**#@+
	* MenuItem align
	* @access public
	* @var string
	*/
	const ALIGN_LEFT = "left";
	const ALIGN_CENTER = "center";
	const ALIGN_RIGHT = "right";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $value = "";
	private $link = "";
	private $img = "";
	private $current = false;
	
	private $menu_items = null;
	/**#@-*/
	
	/**
	 * Constructor MenuItem
	 * @param mixed $value 
	 * @param string $link 
	 * @param string $img 
	 * @param boolean $current [default value: false]
	 */
	function __construct($value, $link='', $img='', $current=false) {
		parent::__construct();
		
		if (!isset($value)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->value = $value;
		$this->link = $link;
		$this->img = $img;
		$this->current = $current;
	}
	
	/**
	 * Method setMenuItems
	 * @access public
	 * @param mixed $menu_items_object 
	 * @return MenuItem
	 * @since 1.0.35
	 */
	public function setMenuItems($menu_items_object) {
		if (get_class($menu_items_object) != "MenuItems") {
			throw new NewException("Error MenuItem->setMenuItems(): $menu_items_object is not a MenuItems object", 0, getDebugBacktrace(1));
		}
		$this->menu_items = $menu_items_object;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setCurrent
	 * @access public
	 * @return MenuItem
	 * @since 1.0.35
	 */
	public function setCurrent() {
		$this->current = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object MenuItem
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";
		$item_link = createHrefLink($this->link);
		
		if ($item_link != "") {
			$html = "\t<li";
			if ($this->current) {
				$html .= " class=\"current\"";
			}
			$html .= ">";
			$html .= "<a ";
			if ($this->menu_items != null && sizeof($this->menu_items) > 0) {
				$html .= "class=\"sf-with-ul\" ";
			} 
			$html .= "href=\"".$item_link."\" style=\"white-space: nowrap;\">";
			if ($this->img != "") {
				if (gettype($this->img) != "object") {
					$this->img = new Picture($this->img);
					$this->img->setAlign(Picture::ALIGN_ABSMIDDLE);
				}
				$html .= str_replace("\n", "", str_replace("\r", "", $this->img->render()))."&nbsp;";
			}
			$html .= $this->value."</a>";
			
			if ($this->menu_items != null && sizeof($this->menu_items) > 0) {
				$html .= "\n".$this->menu_items->render();
			}
			
			$html .= "</li>\n";
		}
		
		$this->object_change = false;
		return $html;
	}
}
?>
