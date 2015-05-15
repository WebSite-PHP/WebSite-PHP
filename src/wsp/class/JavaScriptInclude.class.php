<?php
/**
 * PHP file wsp\class\JavaScriptInclude.class.php
 */
/**
 * Class JavaScriptInclude
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.23
 */

function JavaScriptIncludeComparator($a, $b) {
	$array_put_js_to_begin = JavaScriptInclude::getInstance()->getArrayJsToBegin();
	$array_put_js_to_end = JavaScriptInclude::getInstance()->getArrayJsToEnd();
	
	// put to begin array_js_to_begin js
	if (sizeof($array_put_js_to_begin) > 0) {
		$a_array_index = array_search(str_replace(BASE_URL, "", $a), $array_put_js_to_begin);
		$b_array_index = array_search(str_replace(BASE_URL, "", $b), $array_put_js_to_begin);
		if ($a_array_index !== false && $b_array_index !== false) { 
			if ($a_array_index < $b_array_index) { return -1; }
			else { return 1; }
		}
		if ($a_array_index !== false) { return -1; }
		if ($b_array_index !== false) { return 1; }
	}
	
	// put to end array_js_to_end js
	if (sizeof($array_put_js_to_end) > 0) {
		$a_array_index = array_search(str_replace(BASE_URL, "", $a), $array_put_js_to_end);
		$b_array_index = array_search(str_replace(BASE_URL, "", $b), $array_put_js_to_end);
		if ($a_array_index !== false && $b_array_index !== false) {
			if ($a_array_index < $b_array_index) { return -1; }
			else { return 1; }
		}
		if ($a_array_index !== false) { return 1; }
		if ($b_array_index !== false) { return -1; }
	}
	
	// normal use of comparator
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
}

class JavaScriptInclude {
	/**#@+
	* @access private
	*/
	private $js_scripts = array();
	private $conditional_comment = array();
	private $combine = array();
	private $is_async = array();
	private $script = array();
	private $is_for_ajax = array();
	
	private $array_put_js_to_begin = array();
	private $array_put_js_to_end = array("wsp/js/jquery.jqDock.min.js", "wsp/js/jquery.dd.js");
	/**#@-*/

	/**
	 * Constructor JavaScriptInclude
	 */
	function __construct() {}
	
	/**
	 * Method getInstance
	 * @access static
	 * @return JavaScriptInclude
	 * @since 1.0.35
	 */
	final public static function getInstance() {
		static $instance = null;
		if (!isset($instance)) {
			$instance = new JavaScriptInclude();
		}
		return $instance;
	}
	
	/**
	 * Method add
	 * @access public
	 * @param string $js_url 
	 * @param string $conditional_comment 
	 * @param boolean $combine [default value: false]
	 * @param string $js_script 
	 * @param boolean $async [default value: false]
	 * @since 1.0.59
	 */
	public function add($js_url, $conditional_comment='', $combine=false, $js_script='', $async=false) {
		if (!in_array($js_url, $this->js_scripts)) {
			$this->js_scripts[] = $js_url;
			$this->conditional_comment[] = $conditional_comment;
			$this->combine[] = $combine;
			if ($GLOBALS['__AJAX_PAGE__'] == true && $GLOBALS['__AJAX_LOAD_PAGE__'] == false &&
				$GLOBALS['__PAGE_IS_INIT__'] == true) {
					$this->is_for_ajax[] = true;
			} else {
				$this->is_for_ajax[] = false;
			}
			if ($combine && $js_script != "") {
				throw new NewException(get_class($this)."->add() error: you can't add script with combine mode", 0, getDebugBacktrace(1));
			}
			$this->script[] = $js_script;
			$this->is_async[] = $async;
		}
	}
	
	/**
	 * Method addToBegin
	 * @access public
	 * @param string $js_url 
	 * @param string $conditional_comment 
	 * @param boolean $combine [default value: false]
	 * @param boolean $async [default value: false]
	 * @since 1.0.80
	 */
	public function addToBegin($js_url, $conditional_comment='', $combine=false, $async=false) {
		$this->array_put_js_to_begin[] = str_replace(BASE_URL, "", $js_url);
		$this->add($js_url, $conditional_comment, $combine, "", $async);
	}
	
	/**
	 * Method addToEnd
	 * @access public
	 * @param string $js_url 
	 * @param string $conditional_comment 
	 * @param boolean $combine [default value: false]
	 * @param boolean $async [default value: false]
	 * @since 1.0.80
	 */
	public function addToEnd($js_url, $conditional_comment='', $combine=false, $async=false) {
		$this->array_put_js_to_end[] = str_replace(BASE_URL, "", $js_url);
		$this->add($js_url, $conditional_comment, $combine, "", $async);
	}
	
	/**
	 * Method addUrlWithScript
	 * With this method you can include javascript file with script like <script src=...>$js_script</script>
	 * Warning this script can be only load in standard page (.html)
	 * @access public
	 * @param string $js_url 
	 * @param string $js_script 
	 * @param string $conditional_comment 
	 * @since 1.0.88
	 */
	public function addUrlWithScript($js_url, $js_script, $conditional_comment='') {
		$this->add($js_url, $conditional_comment, false, $js_script);
	}
	
	/**
	 * Method getArrayJsToBegin
	 * @access public
	 * @return array
	 * @since 1.0.80
	 */
	public function getArrayJsToBegin() {
		return $this->array_put_js_to_begin;
	}
	
	/**
	 * Method getArrayJsToEnd
	 * @access public
	 * @return array
	 * @since 1.0.80
	 */
	public function getArrayJsToEnd() {
		return $this->array_put_js_to_end;
	}
	
	/**
	 * Method get
	 * @access public
	 * @param boolean $sort [default value: false]
	 * @return array
	 * @since 1.0.35
	 */
	public function get($sort=false) {
		if ($sort) {
			uasort($this->js_scripts, "JavaScriptIncludeComparator");
		}
		if ($GLOBALS['__AJAX_PAGE__'] == true && $GLOBALS['__AJAX_LOAD_PAGE__'] == false) {
			$js_script_ajax = array();
			for ($i=0; $i < sizeof($this->js_scripts); $i++) {
				if ($this->is_for_ajax[$i] == true) {
					$js_script_ajax[] = $this->js_scripts[$i];
				}
			}
			return $js_script_ajax;
		} else {
			return $this->js_scripts;
		}
	}
	
	/**
	 * Method getConditionalComment
	 * @access public
	 * @param mixed $indice 
	 * @return string
	 * @since 1.0.35
	 */
	public function getConditionalComment($indice) {
		return $this->conditional_comment[$indice];
	}
	
	/**
	 * Method getCombine
	 * @access public
	 * @param mixed $indice 
	 * @return boolean
	 * @since 1.0.35
	 */
	public function getCombine($indice) {
		return $this->combine[$indice];
	}
	
	/**
	 * Method getIsAsync
	 * @access public
	 * @param mixed $indice 
	 * @return mixed
	 * @since 1.2.9
	 */
	public function getIsAsync($indice) {
		return $this->is_async[$indice];
	}
	
	/**
	 * Method getJsIncludeScript
	 * @access public
	 * @param mixed $indice 
	 * @return mixed
	 * @since 1.0.88
	 */
	public function getJsIncludeScript($indice) {
		return $this->script[$indice];
	}
}
?>
