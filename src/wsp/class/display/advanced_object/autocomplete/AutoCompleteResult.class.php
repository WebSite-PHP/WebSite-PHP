<?php
class AutoCompleteResult extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $array_result_id = array();
	private $array_result_label = array();
	private $array_result_value = array();
	/**#@-*/
	
	function __construct() {
		parent::__construct();
	}
	
	/* Intern management of ContextMenuEvent */
	public function add($id, $label, $value) {
		$this->array_result_id[] = $id;
		$this->array_result_label[] = $label;
		$this->array_result_value[] = $value;
		return $this;
	}
	
	public function render($ajax_render=false) {
		$html = "[";
		for ($i=0; $i < sizeof($this->array_result_id); $i++) {
			if ($i > 0) { $html .= ", "; }
			$html .= '{ "id": "'.$this->array_result_id[$i].'", "label": "'.$this->array_result_label[$i].'", "value": "'.$this->array_result_value[$i].'" }';
		}
		$html .= "]";
		
		$this->object_change = false;
		return $html;
	}
}
?>
