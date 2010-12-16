<?php
class JavaScript extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $code_javascript = "";
	/**#@-*/

	function __construct($code_javascript, $force_object_change=false) {
		parent::__construct();
		
		if (!isset($code_javascript)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		$this->code_javascript = $code_javascript;
		$this->is_javascript_object = true;
		
		if ($force_object_change) {
			$this->object_change =true;
		} else {
			if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		}
	}
	
	public function render($ajax_render=false) {
		$this->object_change = false;
		if (gettype($this->code_javascript) == "object" && method_exists($this->code_javascript, "render")) {
			return $this->code_javascript->render($ajax_render);
		} else {
			return $this->code_javascript;
		}
	}
	
	/**
	 * function getAjaxRender
	 * @return string javascript code to update initial html with ajax call
	 */
	public function getAjaxRender() {
		if ($this->object_change) {
			return str_replace("//<![CDATA[", "", str_replace("//]]>", "", str_replace("\n", "", str_replace("\r", "", $this->render(true)))));
		} else {
			return "";
		}
	}
}
?>
