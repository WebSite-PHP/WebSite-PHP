<?php
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
			asort($this->js_scripts);
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
