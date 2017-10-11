<?php
/**
 * PHP file wsp\class\abstract\WebSitePhpObject.class.php
 * @package abstract
 */
/**
 * Abstract Class WebSitePhpObject
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2017 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package abstract
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 11/10/2017
 * @version     1.2.15
 * @access      public
 * @since       1.0.17
 */

abstract class WebSitePhpObject {
	/**#@+
	* @access protected
	*/
	protected $object_change = false;
	protected $is_javascript_object = false;
	protected $is_new_object_after_init = false;
	protected $tag = "";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $display_javascript_tag = false;
	private $array_js = array();
	private $array_css = array();
	/**#@-*/
	
	/**
	 * Constructor WebSitePhpObject
	 */
	function __construct() {
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->is_new_object_after_init = true; }
		$this->registerObject();
	}
	
	/**
	 * Method setTag
	 * @access public
	 * @param mixed $value 
	 * @return WebSitePhpObject
	 * @since 1.0.35
	 */
	public function setTag($value) {
		$this->tag = $value;
		return $this;
	}
	
	/**
	 * Method registerObject
	 * @access private
	 * @since 1.0.59
	 */
	private function registerObject() {
		$_SESSION['websitephp_register_object'][] = $this;
	}
	
	/**
	 * Method getRegisterObjects
	 * @access static
	 * @return mixed
	 * @since 1.0.35
	 */
	public static function getRegisterObjects() {
		if (!isset($_SESSION['websitephp_register_object'])) {
			$_SESSION['websitephp_register_object'] = array();
		}
		return $_SESSION['websitephp_register_object'];
	}
	
	/**
	 * Method addJavaScript
	 * @access protected
	 * @param mixed $js_url 
	 * @param string $conditional_comment 
	 * @param boolean $conbine [default value: false]
	 * @since 1.0.59
	 */
	protected function addJavaScript($js_url, $conditional_comment='', $conbine=false) {
		$this->array_js[] = $js_url;
		JavaScriptInclude::getInstance()->add($js_url, $conditional_comment, $conbine);
	}
	
	/**
	 * Method getJavaScriptArray
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getJavaScriptArray() {
		return $this->array_js;
	}
	
	/**
	 * Method addCss
	 * @access protected
	 * @param mixed $css_url 
	 * @param string $conditional_comment 
	 * @param boolean $conbine [default value: false]
	 * @since 1.0.59
	 */
	protected function addCss($css_url, $conditional_comment='', $conbine=false) {
		$this->array_css[] = $css_url;
		CssInclude::getInstance()->add($css_url, $conditional_comment, $conbine);
	}
	
	/**
	 * Method getCssArray
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getCssArray() {
		return $this->array_css;
	}
	
	/**
	 * Method getName
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getName() {
		if (isset($this->name)) {
			return $this->name;
		} else {
			return "";
		}
	}
	
	/**
	 * Method isEventObject
	 * @access public
	 * @return boolean
	 * @since 1.0.35
	 */
	public function isEventObject() {
		if (isset($this->page_object) && $this->page_object != null) {
			if (get_class($this->page_object) == "Form") {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * Method displayJavascriptTag
	 * @access public
	 * @return WebSitePhpObject
	 * @since 1.0.35
	 */
	public function displayJavascriptTag() {
		if (!$this->is_javascript_object) {
			throw new NewException("displayJavascriptTag Error : You display JavaScript tag only for Javascript object", 0, getDebugBacktrace(1));
		}
		$this->display_javascript_tag = true;
		return $this;
	}
	
	/**
	 * Method isJavascriptObject
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function isJavascriptObject() {
		return $this->is_javascript_object;
	}
	
	/**
	 * Method isObjectChange
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function isObjectChange() {
		return $this->object_change;
	}
	
	/**
	 * Method getTag
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getTag() {
		return $this->tag;
	}
	
	/**
	 * Method getJavascriptTagOpen
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public static function getJavascriptTagOpen() {
		return "<script type='text/javascript'>\n	//<![CDATA[\n";
	}
	
	/**
	 * Method getJavascriptTagClose
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public static function getJavascriptTagClose() {
		return "	//]]>\n</script>\n";
	}
	
	/**
	 * Method getPage
	 * @access public
	 * @return Page
	 * @since 1.0.92
	 */
	public function getPage() {
		return Page::getInstance($_GET['p']);
	}
	
	public function forceAjaxRender() {
		$this->object_change = true;
		$this->is_new_object_after_init = false;
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code from object
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		return "<!-- Warning: No render method for object ".get_class($this)." !!! -->\n";
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html with ajax call
	 * @since 1.0.35
	 */
	public function getAjaxRender() {
		if ($this->object_change && !$this->is_new_object_after_init) {
			$alert_box = new DialogBox("Ajax Error", "Warning: No Ajax render for object ".get_class($this), '');
			return $alert_box->render(true);
		}
	}

	public function getClass() {
		return get_called_class();
	}
	
	public function getType() {
		return "object";
	}
}
?>
