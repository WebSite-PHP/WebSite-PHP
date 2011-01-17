<?php
class AutoCompleteEvent extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $onselect = "";
	/**#@-*/
	
	function __construct() {
		parent::__construct();
	}
	
	public function onSelectJs($js_function) {
		$this->onselect = trim($js_function);
		return $this;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		$html = $this->onselect;
		
		$this->object_change = false;
		return $html;
	}
}
?>
