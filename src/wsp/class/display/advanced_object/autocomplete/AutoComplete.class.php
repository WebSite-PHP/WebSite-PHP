<?php
class AutoComplete extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $autocomplete_url = null;
	private $autocomplete_min_length = 4;
	private $autocomplete_event = null;
	/**#@-*/
	
	function __construct($url_object, $min_lenght=4, $autocomplete_event=null) {
		parent::__construct();
		
		if (gettype($url_object) != "object" && get_class($url_object) != "Url") {
			throw new NewException("AutoComplete: \$url_object must be a Url object", 0, 8, __FILE__, __LINE__);
		}
		if ($autocomplete_event != null) {
			if (gettype($autocomplete_event) != "object" && get_class($autocomplete_event) != "AutoCompleteEvent") {
				throw new NewException("AutoComplete: \$autocomplete_event must be a AutoCompleteEvent object", 0, 8, __FILE__, __LINE__);
			}
		}
		$this->autocomplete_url = $url_object;
		$this->autocomplete_min_length = $min_lenght;
		$this->autocomplete_event = $autocomplete_event;
	}
	
	/* Intern management of AutoComplete */
	public function setLinkObjectId($id) {
		$this->link_object_id = $id;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		$html .= $this->getJavascriptTagOpen();
		$html .= "\$('#".$this->link_object_id."').autocomplete({ source: '".$this->autocomplete_url->render()."', minLength: ".$this->autocomplete_min_length.", select: function( event, ui ) { ";
		if ($this->autocomplete_event != null) {
			$html .= $this->autocomplete_event->render();
		}
		$html .= " } });\n";
		$html .= $this->getJavascriptTagClose();
		$this->object_change = false;
		return $html;
	}
}
?>
