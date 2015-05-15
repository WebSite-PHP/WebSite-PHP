<?php
/**
 * PHP file wsp\class\display\JavaScript.class.php
 * @package display
 */
/**
 * Class JavaScript
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

class JavaScript extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $code_javascript = "";
	private $display_from_url = false;
	/**#@-*/

	/**
	 * Constructor JavaScript
	 * @param string $code_javascript 
	 * @param boolean $add_js_to_page [default value: false]
	 */
	function __construct($code_javascript, $add_js_to_page=false) {
		parent::__construct();
		
		if (!isset($code_javascript)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->code_javascript = $code_javascript;
		$this->is_javascript_object = true;
		
		if ($add_js_to_page) {
			$page_object = Page::getInstance($_GET['p']);
			
			if (gettype($code_javascript) != "object") {
				// search in javascript if begin by $(document).ready(
				// then put javascript to the end (for AJAX because doc is already loaded)
				$tmp_code_javascript = trim(str_replace("\t", "", $code_javascript));
				$pos_doc_ready = find($tmp_code_javascript, "$(document).ready(", 1);
				$pos_jquery_ready = find($tmp_code_javascript, "jQuery(document).ready(", 1);
				if (($pos_doc_ready >= 18 && $pos_doc_ready <= 30) || 
					($pos_jquery_ready >= 23 && $pos_jquery_ready <= 35)) { // 30|35: beacause of tag //<![CDATA[
					$page_object->addObject($this, false, true);
				} else {
					$page_object->addObject($this);
				}
			} else {
				$page_object->addObject($this);
			}
		}
	}
	
	/**
	 * Method displayFormURL
	 * @access public
	 * @return JavaScript
	 * @since 1.0.63
	 */
	public function displayFormURL() {
		$this->display_from_url = true;
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return mixed
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$js = "";
		if ($this->display_from_url) {
			$js .= "javascript:";
		}
		if (gettype($this->code_javascript) == "object" && method_exists($this->code_javascript, "render")) {
			$js .= $this->code_javascript->render($ajax_render);
		} else {
			$js .= $this->code_javascript;
		}
		return $js;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html with ajax call
	 * @since 1.0.35
	 */
	public function getAjaxRender() {
		return str_replace("//<![CDATA[", "", str_replace("//]]>", "", str_replace("\n", "", str_replace("\r", "", $this->render(true)))));
	}
}
?>
