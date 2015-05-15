<?php
/**
 * PHP file wsp\class\display\ListItem.class.php
 * @package display
 */
/**
 * Class ListItem
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

class ListItem extends WebSitePhpObject {
	/**#@+
	* Align
	* @access public
	* @var string
	*/
	const ALIGN_LEFT = "left";
	const ALIGN_RIGHT = "right";
	const ALIGN_CENTER = "center";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $align = "";
	private $item_array = array();
	/**#@-*/

	/**
	 * Constructor ListItem
	 * @param string $align [default value: left]
	 */
	function __construct($align="left") {
		parent::__construct();
		
		$this->align = $align;
	}
	
	/**
	 * Method addItem
	 * @access public
	 * @param mixed $str_item 
	 * @return ListItem
	 * @since 1.0.35
	 */
	public function addItem($str_item) {
		$this->item_array[] = $str_item;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object ListItem
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "<ul style='text-align:".$this->align.";'>";
		for ($i=0; $i < sizeof($this->item_array); $i++) {
			$html .= "<li>";
			if (gettype($this->item_array[$i]) == "object") {
				$html .= $this->item_array[$i]->render();
			} else {
				$html .= $this->item_array[$i];
			}
			$html .= "</li>";
		}
		$html .= "</ul>";
			
		$this->object_change = false;
		return $html;
	}
}
?>
