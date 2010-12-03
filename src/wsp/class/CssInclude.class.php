<?php
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
			asort($this->css_scripts);
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
