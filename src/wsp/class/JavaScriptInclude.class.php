<?php
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

	function __construct() {}
	
	final public static function getInstance() {
		static $instance = null;
		if (!isset($instance)) {
			$instance = new JavaScriptInclude();
		}
		return $instance;
	}
	
	public function add($js_url, $conditional_comment='', $conbine=false) {
		if (!in_array($js_url, $this->js_scripts)) {
			$this->js_scripts[] = $js_url;
			$this->conditional_comment[] = $conditional_comment;
			$this->combine[] = $conbine;
		}
	}
	
	public function get($sort_by_name=false) {
		if ($sort_by_name) {
			uasort($this->js_scripts, "JavaScriptIncludeComparator");
		}
		return $this->js_scripts;
	}
	
	public function getConditionalComment($indice) {
		return $this->conditional_comment[$indice];
	}
	
	public function getCombine($indice) {
		return $this->combine[$indice];
	}
}
?>
