<?php
/**
 * PHP file wsp\class\JavaScriptInclude.class.php
 */
/**
 * Class JavaScriptInclude
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.0.88
 * @access      public
 * @since       1.0.23
 */

function JavaScriptIncludeComparator($a, $b) {
	$array_put_js_to_begin = JavaScriptInclude::getInstance()->getArrayJsToBegin();
	$array_put_js_to_end = JavaScriptInclude::getInstance()->getArrayJsToEnd();
	
	// put to begin array_js_to_begin js
	if (sizeof($array_put_js_to_begin) > 0) {
		if (in_array(str_replace(BASE_URL, "", $a), $array_put_js_to_begin)) { return -1; }
		if (in_array(str_replace(BASE_URL, "", $b), $array_put_js_to_begin)) { return 1; }
	}
	
	// put to end array_js_to_end js
	if (sizeof($array_put_js_to_end) > 0) {
		if (in_array(str_replace(BASE_URL, "", $a), $array_put_js_to_end)) { return 1; }
		if (in_array(str_replace(BASE_URL, "", $b), $array_put_js_to_end)) { return -1; }
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
	private $script = array();
	
	private $array_put_js_to_begin = array();
	private $array_put_js_to_end = array("wsp/js/jquery.dd.js", "wsp/js/jquery.jqDock.min.js");
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
	 * @since 1.0.59
	 */
	public function add($js_url, $conditional_comment='', $combine=false, $js_script='') {
		if (!in_array($js_url, $this->js_scripts)) {
			$this->js_scripts[] = $js_url;
			$this->conditional_comment[] = $conditional_comment;
			$this->combine[] = $combine;
			if ($combine && $js_script != "") {
				throw new NewException(get_class($this)."->add() error: you can't add script with combine mode", 0, 8, __FILE__, __LINE__);
			}
			$this->script[] = $js_script;
		}
	}
	
	/**
	 * Method addToBegin
	 * @access public
	 * @param string $js_url 
	 * @param string $conditional_comment 
	 * @param boolean $combine [default value: false]
	 * @since 1.0.80
	 */
	public function addToBegin($js_url, $conditional_comment='', $combine=false) {
		$this->array_put_js_to_begin[] = $js_url;
		$this->add($js_url, $conditional_comment, $combine);
	}
	
	/**
	 * Method addToEnd
	 * @access public
	 * @param string $js_url 
	 * @param string $conditional_comment 
	 * @param boolean $combine [default value: false]
	 * @since 1.0.80
	 */
	public function addToEnd($js_url, $conditional_comment='', $combine=false) {
		$this->array_put_js_to_end[] = $js_url;
		$this->add($js_url, $conditional_comment, $combine);
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
		return $this->js_scripts;
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
