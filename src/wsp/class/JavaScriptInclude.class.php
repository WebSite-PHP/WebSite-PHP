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
 * @copyright   WebSite-PHP.com 03/10/2010
 * @version     1.0.68
 * @access      public
 * @since       1.0.23
 */

function JavaScriptIncludeComparator($a, $b) {
	$array_put_js_to_begin = array();
	$array_put_js_to_end = array("wsp/js/jquery.dd.js", "wsp/js/jquery.jqDock.min.js");
		
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
	/**#@-*/

	/**
	 * Constructor JavaScriptInclude
	 */
	function __construct() {}
	
	/**
	 * Method getInstance
	 * @access static
	 * @return mixed
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
	 * @param mixed $js_url 
	 * @param string $conditional_comment 
	 * @param boolean $conbine [default value: false]
	 * @since 1.0.59
	 */
	public function add($js_url, $conditional_comment='', $conbine=false) {
		if (!in_array($js_url, $this->js_scripts)) {
			$this->js_scripts[] = $js_url;
			$this->conditional_comment[] = $conditional_comment;
			$this->combine[] = $conbine;
		}
	}
	
	/**
	 * Method get
	 * @access public
	 * @param boolean $sort_by_name [default value: false]
	 * @return mixed
	 * @since 1.0.35
	 */
	public function get($sort_by_name=false) {
		if ($sort_by_name) {
			uasort($this->js_scripts, "JavaScriptIncludeComparator");
		}
		return $this->js_scripts;
	}
	
	/**
	 * Method getConditionalComment
	 * @access public
	 * @param mixed $indice 
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getConditionalComment($indice) {
		return $this->conditional_comment[$indice];
	}
	
	/**
	 * Method getCombine
	 * @access public
	 * @param mixed $indice 
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getCombine($indice) {
		return $this->combine[$indice];
	}
}
?>
