<?php
/**
 * PHP file wsp\class\CssInclude.class.php
 */
/**
 * Class CssInclude
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
 * @version     1.0.81
 * @access      public
 * @since       1.0.23
 */

function CssIncludeComparator($a, $b) {
	$array_put_css_to_begin = CssInclude::getInstance()->getArrayCssToBegin();
	$array_put_css_to_end = CssInclude::getInstance()->getArrayCssToEnd();
	
	// put to begin array_css_to_begin css
	if (sizeof($array_put_css_to_begin) > 0) {
		if (in_array(str_replace(BASE_URL, "", $a), $array_put_css_to_begin)) { return -1; }
		if (in_array(str_replace(BASE_URL, "", $b), $array_put_css_to_begin)) { return 1; }
	}
	
	// put to end array_css_to_end css
	if (sizeof($array_put_css_to_end) > 0) {
		if (in_array(str_replace(BASE_URL, "", $a), $array_put_css_to_end)) { return 1; }
		if (in_array(str_replace(BASE_URL, "", $b), $array_put_css_to_end)) { return -1; }
	}
	
	// normal use of comparator
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
}

class CssInclude {
	/**#@+
	* @access private
	*/
	private $css_scripts = array();
	private $conditional_comment = array();
	private $combine = array();
	
	private $array_put_css_to_begin = array();
	private $array_put_css_to_end = array("wsp/css/angle.css.php");
	/**#@-*/

	/**
	 * Constructor CssInclude
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
			$instance = new CssInclude();
		}
		return $instance;
	}
	
	/**
	 * Method add
	 * @access public
	 * @param mixed $css_url 
	 * @param string $conditional_comment 
	 * @param boolean $conbine [default value: false]
	 * @since 1.0.59
	 */
	public function add($css_url, $conditional_comment='', $conbine=false) {
		if (!in_array($css_url, $this->css_scripts)) {
			$this->css_scripts[] = $css_url;
			$this->conditional_comment[] = $conditional_comment;
			$this->combine[] = $conbine;
		}
	}
	
	/**
	 * Method addToBegin
	 * @access public
	 * @param mixed $css_url 
	 * @param string $conditional_comment 
	 * @param boolean $conbine [default value: false]
	 * @since 1.0.80
	 */
	public function addToBegin($css_url, $conditional_comment='', $conbine=false) {
		$this->array_put_css_to_begin[] = $css_url;
		$this->add($css_url, $conditional_comment, $conbine);
	}
	
	/**
	 * Method addToEnd
	 * @access public
	 * @param mixed $css_url 
	 * @param string $conditional_comment 
	 * @param boolean $conbine [default value: false]
	 * @since 1.0.80
	 */
	public function addToEnd($css_url, $conditional_comment='', $conbine=false) {
		$this->array_put_css_to_end[] = $css_url;
		$this->add($css_url, $conditional_comment, $conbine);
	}
	
	/**
	 * Method getArrayCssToBegin
	 * @access public
	 * @return array
	 * @since 1.0.80
	 */
	public function getArrayCssToBegin() {
		return $this->array_put_css_to_begin;
	}
	
	/**
	 * Method getArrayCssToEnd
	 * @access public
	 * @return array
	 * @since 1.0.80
	 */
	public function getArrayCssToEnd() {
		return $this->array_put_css_to_end;
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
			uasort($this->css_scripts, "CssIncludeComparator");
		}
		return $this->css_scripts;
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
}
?>
