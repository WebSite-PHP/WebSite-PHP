<?php
/**
 * PHP file wsp\class\CssInclude.class.php
 */
/**
 * Class CssInclude
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

function CssIncludeComparator($a, $b) {
	$array_put_css_to_begin = CssInclude::getInstance()->getArrayCssToBegin();
	$array_put_css_to_end = CssInclude::getInstance()->getArrayCssToEnd();
	
	// put to begin array_css_to_begin css
	if (sizeof($array_put_css_to_begin) > 0) {
		$a_array_index = array_search(str_replace(BASE_URL, "", $a), $array_put_css_to_begin);
		$b_array_index = array_search(str_replace(BASE_URL, "", $b), $array_put_css_to_begin);
		if ($a_array_index !== false && $b_array_index !== false) { 
			if ($a_array_index < $b_array_index) { return -1; }
			else { return 1; }
		}
		if ($a_array_index !== false) { return -1; }
		if ($b_array_index !== false) { return 1; }
	}
	
	// put to end array_css_to_end css
	if (sizeof($array_put_css_to_end) > 0) {
		$a_array_index = array_search(str_replace(BASE_URL, "", $a), $array_put_css_to_end);
		$b_array_index = array_search(str_replace(BASE_URL, "", $b), $array_put_css_to_end);
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

class CssInclude {
	/**#@+
	* @access private
	*/
	private $css_scripts = array();
	private $conditional_comment = array();
	private $combine = array();
	private $config_file = "";
	private $config_file_loaded = false;
	private $is_for_ajax = array();
	
	private $array_put_css_to_begin = array();
	private $array_put_css_to_end = array("wsp/css/angle.css.php");
	/**#@-*/

	/**
	 * Constructor CssInclude
	 */
	function __construct() {
		if (!isset($_SESSION['wspCssConfigFile']) || $GLOBALS['__AJAX_PAGE__'] == false) {
			$_SESSION['wspCssConfigFile'] = "";
		}
	}
	
	/**
	 * Method getInstance
	 * @access static
	 * @return CssInclude
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
	 * @param string $css_url 
	 * @param string $conditional_comment 
	 * @param boolean $conbine [default value: false]
	 * @since 1.0.59
	 */
	public function add($css_url, $conditional_comment='', $conbine=false) {
		if (!in_array($css_url, $this->css_scripts)) {
			$this->css_scripts[] = $css_url;
			$this->conditional_comment[] = $conditional_comment;
			$this->combine[] = $conbine;
			if ($GLOBALS['__AJAX_PAGE__'] == true && $GLOBALS['__AJAX_LOAD_PAGE__'] == false &&
				$GLOBALS['__PAGE_IS_INIT__'] == true) {
					$this->is_for_ajax[] = true;
			} else {
				$this->is_for_ajax[] = false;
			}
		}
	}
	
	/**
	 * Method addToBegin
	 * @access public
	 * @param string $css_url 
	 * @param string $conditional_comment 
	 * @param boolean $conbine [default value: false]
	 * @since 1.0.80
	 */
	public function addToBegin($css_url, $conditional_comment='', $conbine=false) {
		$this->array_put_css_to_begin[] = str_replace(BASE_URL, "", $css_url);
		$this->add($css_url, $conditional_comment, $conbine);
	}
	
	/**
	 * Method addToEnd
	 * @access public
	 * @param string $css_url 
	 * @param string $conditional_comment 
	 * @param boolean $conbine [default value: false]
	 * @since 1.0.80
	 */
	public function addToEnd($css_url, $conditional_comment='', $conbine=false) {
		$this->array_put_css_to_end[] = str_replace(BASE_URL, "", $css_url);
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
		if ($GLOBALS['__AJAX_PAGE__'] == true && $GLOBALS['__AJAX_LOAD_PAGE__'] == false) {
			$css_script_ajax = array();
			for ($i=0; $i < sizeof($this->css_scripts); $i++) {
				if ($this->is_for_ajax[$i] == true) {
					$css_script_ajax[] = $this->css_scripts[$i];
				}
			}
			return $css_script_ajax;
		} else {
			return $this->css_scripts;
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
	 * Method setCssConfigFile
	 * @access public
	 * @param string $file [default value: config_css.inc.php]
	 * @return CssInclude
	 * @since 1.0.83
	 */
	public function setCssConfigFile($file='config_css.inc.php') {
		if (!file_exists(dirname(__FILE__)."/../config/".$file)) {
			throw new NewException("Error ".get_class($this)."->setCssConfigFile(): Config file ".$file." doesn't exists.", 0, getDebugBacktrace(1));
		}
		if ($this->config_file_loaded) {
			throw new NewException("Error ".get_class($this)."->setCssConfigFile(): Config file is already loaded, set this configuration in the begining of your code.", 0, getDebugBacktrace(1));
		}
		$this->config_file = $file;
		$_SESSION['wspCssConfigFile'] = $this->config_file;
		$this->loadCssConfigFileInMemory();
		return $this;
	}
	
	/**
	 * Method getCssConfigFile
	 * @access public
	 * @return string
	 * @since 1.0.83
	 */
	public function getCssConfigFile() {
		return ($this->config_file=="config_css.inc.php"?"":$this->config_file);
	}
	
	/**
	 * Method loadCssConfigFileInMemory
	 * @access public
	 * @return CssInclude
	 * @since 1.0.83
	 */
	public function loadCssConfigFileInMemory() {
		if (!$this->config_file_loaded) {
			if ($this->config_file == "") {
				if ($_SESSION['wspCssConfigFile'] != "" && $GLOBALS['__AJAX_PAGE__'] == true) {
					$this->config_file = $_SESSION['wspCssConfigFile'];
				} else {
					$this->config_file = "config_css.inc.php";
				}
			}
			include(dirname(__FILE__)."/../config/".$this->config_file);
			$this->config_file_loaded = true;
		}
		return $this;
	}
	
	/**
	 * Method getLastCssConfigFileSession
	 * @access public
	 * @return mixed
	 * @since 1.1.3
	 */
	public function getLastCssConfigFileSession() {
		return ($_SESSION['wspCssConfigFile']==""?"config_css.inc.php":$_SESSION['wspCssConfigFile']);
	}
	
	/**
	 * Method isCssConfigFileLoaded
	 * @access public
	 * @return boolean
	 * @since 1.0.83
	 */
	public function isCssConfigFileLoaded() {
		return $this->config_file_loaded;
	}
}
?>
