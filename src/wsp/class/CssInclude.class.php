<?php
function CssIncludeComparator($a, $b) {
	$array_put_css_to_begin = array();
	$array_put_css_to_end = array("wsp/css/angle.css.php");
		
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
	/**#@-*/

	function __construct() {}
	
	final public static function getInstance() {
		static $instance = null;
		if (!isset($instance)) {
			$instance = new CssInclude();
		}
		return $instance;
	}
	
	public function add($css_url, $conditional_comment='', $conbine=false) {
		if (!in_array($css_url, $this->css_scripts)) {
			$this->css_scripts[] = $css_url;
			$this->conditional_comment[] = $conditional_comment;
			$this->combine[] = $conbine;
		}
	}
	
	public function get($sort_by_name=false) {
		if ($sort_by_name) {
			uasort($this->css_scripts, "CssIncludeComparator");
		}
		return $this->css_scripts;
	}
	
	public function getConditionalComment($indice) {
		return $this->conditional_comment[$indice];
	}
	
	public function getCombine($indice) {
		return $this->combine[$indice];
	}
}
?>
