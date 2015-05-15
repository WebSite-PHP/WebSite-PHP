<?php
/**
 * PHP file wsp\class\display\advanced_object\menu\dockmenu\DockMenu.class.php
 * @package display
 * @subpackage advanced_object.menu.dockmenu
 */
/**
 * Class DockMenu
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.menu.dockmenu
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

// Website JS/Css => http://positionabsolute.net/blog/2007/08/prototype-fisheye.php

class DockMenu extends WebSitePhpObject {
	const DOCK_ALIGN_TOP = "top";
	const DOCK_ALIGN_BOTTOM = "bottom";
	const DOCK_ALIGN_LEFT = "left";
	const DOCK_ALIGN_RIGHT = "right";
	const DOCK_ALIGN_NONE = "";
	
	/**#@+
	* @access private
	*/
	private $id='menu_dock';
	private $img_size=48;
	private $align='';
	private $top=0;
	private $left=0;
	private $opacity='';
	private $labels_color="#333333";
	
	private $background_color='';
	private $border_background_color='';
	
	private $dock_menu_items = array();
	/**#@-*/
	
	/**
	 * Constructor DockMenu
	 * @param string $id [default value: menu_dock]
	 * @param string $align 
	 * @param double $top [default value: 0]
	 * @param double $left [default value: 0]
	 * @param double $img_size [default value: 48]
	 * @param string $opacity 
	 */
	function __construct($id='menu_dock', $align='', $top=0, $left=0, $img_size=48, $opacity='') {
		parent::__construct();
		
		$this->id=$id;
		$this->img_size=$img_size;
		$this->align=$align;
		$this->top=$top;
		$this->left=$left;
		$this->opacity=$opacity;
		
		$this->addJavaScript(BASE_URL."wsp/js/jquery.jqDock.min.js", "", true);
	}
	
	/**
	 * Method setDockBackground
	 * @access public
	 * @param string $color [default value: #a5b5d3]
	 * @param string $border_color [default value: #7890be]
	 * @return DockMenu
	 * @since 1.0.35
	 */
	public function setDockBackground($color='#a5b5d3', $border_color='#7890be') {
		$this->background_color=$color;
		$this->border_background_color=$border_color;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setDockOpacity
	 * @access public
	 * @param double $opacity [default value: 0.8]
	 * @return DockMenu
	 * @since 1.0.35
	 */
	public function setDockOpacity($opacity=0.8) {
		$this->opacity=$opacity;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setLabelsColor
	 * @access public
	 * @param mixed $color 
	 * @return DockMenu
	 * @since 1.0.35
	 */
	public function setLabelsColor($color) {
		$this->labels_color=$color;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method addDockMenuItem
	 * @access public
	 * @param mixed $dock_menu_item_object 
	 * @return DockMenu
	 * @since 1.0.35
	 */
	public function addDockMenuItem($dock_menu_item_object) {
		if (get_class($dock_menu_item_object) != "DockMenuItem") {
			throw new NewException("Error DockMenu->addDockMenuItem(): dock_menu_item_object is not a DockMenuItem object", 0, getDebugBacktrace(1));
		}
		$this->dock_menu_items[] = $dock_menu_item_object;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object DockMenu
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";
		
		if (sizeof($this->dock_menu_items) > 0) {
			$html .= "<style type='text/css'>\n";
			$html .= "	#".$this->id."{\n";
			if ($this->background_color != '') {
				$html .= "		background-color:".$this->background_color.";\n";
			}
			if ($this->border_background_color != '') {
				$html .= "		border:2px solid ".$this->border_background_color.";\n";
			}
			if ($this->opacity != '') {
				$html .= "		opacity: ".$this->opacity.";\n";
			}
			if ($this->align != DockMenu::DOCK_ALIGN_NONE) {
				$html .= "		position: fixed;\n";
				if ($this->align == DockMenu::DOCK_ALIGN_TOP || $this->align == DockMenu::DOCK_ALIGN_BOTTOM) {
					if ($this->align == DockMenu::DOCK_ALIGN_TOP) {
						$html .= "		top: 0;\n";
					}
					if ($this->align == DockMenu::DOCK_ALIGN_BOTTOM) {
						$html .= "		bottom: 0;\n";
					}
					$html .= "		left: 0;\n";
					$html .= "		width: 100%;\n";
				} else {
					$html .= "		top: 0;\n";
					if ($this->align == DockMenu::DOCK_ALIGN_LEFT) {
						$html .= "		left: 0;\n";
					}
					if ($this->align == DockMenu::DOCK_ALIGN_RIGHT) {
						$html .= "		left: 100%;\n";
						$html .= "		margin-left:-".$this->img_size."px;\n";
					}
					$html .= "		height: 100%;\n";
				}
			} else {
				$html .= "		position: relative;\n";
				$html .= "		top: ".$this->top."px;\n";
				$html .= "		left: ".$this->left."px;\n";
			}
			$html .= "		display:none;\n";
			$html .= "	}\n";
			if ($this->align == DockMenu::DOCK_ALIGN_TOP || $this->align == DockMenu::DOCK_ALIGN_BOTTOM) {
				$html .= "	#".$this->id." div.jqDockWrap {margin:0 auto;}\n";
			}
				$html .= "	div.jqDockLabel {font-weight:bold; white-space:nowrap; color:".$this->labels_color."; cursor:pointer;}\n";
			$html .= "</style>\n";
			
			$html .= "<div id=\"".$this->id."\">\n";
			for ($i=0; $i < sizeof($this->dock_menu_items); $i++) {
				$html .= "\t".$this->dock_menu_items[$i]->render();
			}
			$html .= "</div>\n";
			
			$html .= $this->getJavascriptTagOpen();
			$html .= "	jQuery(document).ready(function(){\n";
			$html .= "		jQuery('#".$this->id."').jqDock({";
			$options = "labels: true";
			if ($this->img_size > 0) {
				$options .= ", size: ".$this->img_size;
			}
			if ($this->align != '') {
				$options .= ", align: '".$this->align."'";
			}
			$html .= $options."});\n";
			$html .= "	});\n";
			$html .= $this->getJavascriptTagClose();
		}
		$this->object_change = false;
		return $html;
	}
}
?>
