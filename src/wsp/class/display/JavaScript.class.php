<?php
/**
 * PHP file wsp\class\display\JavaScript.class.php
 * @package display
 */
/**
 * Class JavaScript
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

class JavaScript extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $code_javascript = "";
	/**#@-*/

	/**
	 * Constructor JavaScript
	 * @param mixed $code_javascript 
	 * @param boolean $force_object_change [default value: false]
	 */
	function __construct($code_javascript, $force_object_change=false) {
		parent::__construct();
		
		if (!isset($code_javascript)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->code_javascript = $code_javascript;
		$this->is_javascript_object = true;
		
		if ($force_object_change) {
			$this->object_change =true;
		} else {
			if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		}
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return mixed
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$this->object_change = false;
		if (gettype($this->code_javascript) == "object" && method_exists($this->code_javascript, "render")) {
			return $this->code_javascript->render($ajax_render);
		} else {
			return $this->code_javascript;
		}
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html with ajax call
	 * @since 1.0.35
	 */
	public function getAjaxRender() {
		if ($this->object_change) {
			return str_replace("//<![CDATA[", "", str_replace("//]]>", "", str_replace("\n", "", str_replace("\r", "", $this->render(true)))));
		} else {
			return "";
		}
	}
}
?>
