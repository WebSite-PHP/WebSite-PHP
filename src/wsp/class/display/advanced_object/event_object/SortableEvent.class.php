<?php
class SortableEvent extends WebSitePhpEventObject {
	/**#@+
	* @access private
	*/
	private $sortable_id = "";
	private $over_style = "";
	
	private $onsort = "";
	private $callback_onsort = "";
	private $is_sorted = false;
	
	private $onsortstart = "";
	private $onsortchange = "";
	private $onsortupdate = "";
	private $onsortstop = "";
	private $onsortremove = "";
	private $onsortover = "";
	private $onsortout = "";
	/**#@-*/
	
	function __construct($page_object, $name='', $over_style="droppablehover") {
		parent::__construct();
		
		if (!isset($page_object) || gettype($page_object) != "object" || !is_subclass_of($page_object, "Page")) {
			throw new NewException("Argument page_object for ".get_class($this)."::__construct() error", 0, 8, __FILE__, __LINE__);
		}
		
		$this->page_object = $page_object;
		$this->class_name = get_class($this->page_object);
		
		if ($name == "") {
			$this->name = $this->page_object->createObjectName($this);
		} else {
			$this->name = $name;
		}
		$this->id = $name;
		
		$this->sortable_id = "";
		$this->over_style = $over_style;
		$this->ajax_wait_message = __(SUBMIT_LOADING_2);
		
		$this->page_object->addEventObject($this, $this->form_object);
		
		$this->addJavaScript(BASE_URL."wsp/js/sortable.js", "", true);
	}
	
	/* Intern management of SortableEvent */
	public function setSort() {
		if ($GLOBALS['__LOAD_VARIABLES__']) { 
			$this->is_sorted = true; 
		}
		return $this;
	}
	
	public function getOnSortJs() {
		return $this->onsort;
	}
	
	public function onSort($str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		$args = func_get_args();
		$str_function = array_shift($args);
		$this->callback_onsort = $this->loadCallbackMethod($str_function, $args);
		return $this;
	}
	
	public function onSortJs($js_function) {
		$this->onsort = trim($js_function);
		return $this;
	}
	
	public function onSortStartJs($js_function) {
		$this->onsortstart = trim($js_function);
		return $this;
	}
	
	public function onSortChangeJs($js_function) {
		$this->onsortchange = trim($js_function);
		return $this;
	}
	
	public function onSortUpdateJs($js_function) {
		$this->onsortupdate = trim($js_function);
		return $this;
	}
	
	public function onSortStopJs($js_function) {
		$this->onsortstop = trim($js_function);
		return $this;
	}
	
	public function onSortRemoveJs($js_function) {
		$this->onsortremove = trim($js_function);
		return $this;
	}
	
	public function onSortOverJs($js_function) {
		$this->onsortover = trim($js_function);
		return $this;
	}
	
	public function onSortOutJs($js_function) {
		$this->onsortout = trim($js_function);
		return $this;
	}
	
	public function isSorted() {
		if (!$this->is_sorted) {
			$this->page_object->getUserEventObject();
		}
		return $this->is_sorted;
	}
	
	/* Intern management of SortableEvent */
	public function setSortableId($id) {
		$this->sortable_id = $id;
	}
	
	public function getSortableId() {
		return $this->sortable_id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		if ($this->callback_onsort != "") {
			$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
		}
		
		$html .= $this->getJavascriptTagOpen();
		if ($this->is_ajax_event) {
			if ($this->callback_onsort == "") {
				throw new NewException("Unable to activate action to this ".get_class($this)." : You must set a onsort event (method onChange)", 0, 8, __FILE__, __LINE__);
			}
			$html .= $this->getAjaxEventFunctionRender();
		}
		
		if ($this->onsort != "" || $this->callback_onsort != "") {
			$html .= "	$(document).ready(function(){ saveSerializeSortableObject('".$this->sortable_id."'); });\n";
			$html .= "	$('#".$this->sortable_id."').bind('sortstart', function(event, ui) { ".$this->onsortstart."return sortableEventStart('".$this->sortable_id."'); });\n";
			$html .= "	$('#".$this->sortable_id."').bind('sortstop', function(event, ui) { ".$this->onsortstop."return sortableEventStop('".$this->sortable_id."', ui); });\n";
			$html .= "	$('#".$this->sortable_id."').bind('sortupdate', function(event, ui) { ".$this->onsortupdate."return sortableEventUpdate('".$this->sortable_id."', ui); });\n";
			$html .= "	$('#".$this->sortable_id."').bind('sortchange', function(event, ui) { ".$this->onsortchange."return sortableEventChangeSaveObject('".$this->sortable_id."', ui); });\n";
			$html .= "	$('#".$this->sortable_id."').bind('sortremove', function(event, ui) { ".$this->onsortremove."return sortableEventRemove('".$this->sortable_id."', ui); });\n";
			$html .= "	$('#".$this->sortable_id."').bind('sortover', function(event, ui) { ".$this->onsortover.";return sortableEventOver('".$this->sortable_id."', ui, '".$this->over_style."'); });\n";
			$html .= "	$('#".$this->sortable_id."').bind('sortout', function(event, ui) { ".$this->onsortout.";return sortableEventOut('".$this->sortable_id."', ui, '".$this->over_style."'); });\n";
			
			$html .= "	move_".$this->sortable_id."_ObjectEvent = function(moved_object, from_object, to_object, position) {\n";
			$html .= $this->getObjectEventValidationRender($this->onsort, $this->callback_onsort, "' + moved_object + ',' + from_object + ',' + to_object + ',' + position + '");
			$html .= "	};\n";
		}
		$html .= $this->getJavascriptTagClose();
		
		$this->object_change = false;
		return $html;
	}
}
?>
