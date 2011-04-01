<?php
/**
 * PHP file wsp\class\display\advanced_object\autocomplete\AutoCompleteEvent.class.php
 * @package display
 * @subpackage advanced_object.autocomplete
 */
/**
 * Class AutoCompleteEvent
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.autocomplete
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 17/01/2011
 * @version     1.0.68
 * @access      public
 * @since       1.0.17
 */

class AutoCompleteEvent extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $onselect = "";
	/**#@-*/
	
	/**
	 * Constructor AutoCompleteEvent
	 */
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * Method onSelectJs
	 * @access public
	 * @param mixed $js_function 
	 * @return AutoCompleteEvent
	 * @since 1.0.35
	 */
	public function onSelectJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript") {
			throw new NewException(get_class($this)."->onSelectJs(): \$js_function must be a string or JavaScript object.", 0, 8, __FILE__, __LINE__);
		}
		if (get_class($js_function) == "JavaScript") {
			$js_function = $js_function->render();
		}
		$this->onselect = trim($js_function);
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object AutoCompleteEvent
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";
		$html = $this->onselect;
		
		$this->object_change = false;
		return $html;
	}
}
?>
