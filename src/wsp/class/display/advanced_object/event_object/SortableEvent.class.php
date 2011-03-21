<?php
/**
 * PHP file wsp\class\display\advanced_object\event_object\SortableEvent.class.php
 * @package display
 * @subpackage advanced_object.event_object
 */
/**
 * Class SortableEvent
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.event_object
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 05/11/2010
 * @version     1.0.62
 * @access      public
 * @since       1.0.17
 */

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
	
	/**
	 * Constructor SortableEvent
	 * @param mixed $page_or_form_object 
	 * @param string $name 
	 * @param string $over_style [default value: droppablehover]
	 */
	function __construct($page_or_form_object, $name='', $over_style="droppablehover") {
		parent::__construct();
		
		if (!isset($page_or_form_object) || gettype($page_or_form_object) != "object" || (!is_subclass_of($page_or_form_object, "Page") && get_class($page_or_form_object) != "Form")) {
			throw new NewException("Argument page_object for ".get_class($this)."::__construct() error", 0, 8, __FILE__, __LINE__);
		}
		
		if (is_subclass_of($page_or_form_object, "Page")) {
			$this->class_name = get_class($page_or_form_object);
			$this->page_object = $page_or_form_object;
			$this->form_object = null;
		} else {
			$this->page_object = $page_or_form_object->getPageObject();
			$this->class_name = get_class($this->page_object)."_".$page_or_form_object->getName();
			$this->form_object = $page_or_form_object;
		}
		
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
	/**
	 * Method setSort
	 * @access public
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function setSort() {
		if ($GLOBALS['__LOAD_VARIABLES__']) { 
			$this->is_sorted = true; 
		}
		return $this;
	}
	
	/**
	 * Method getOnSortJs
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getOnSortJs() {
		return $this->onsort;
	}
	
	/**
	 * Method onSort
	 * @access public
	 * @param mixed $str_function 
	 * @param mixed $arg1 [default value: null]
	 * @param mixed $arg2 [default value: null]
	 * @param mixed $arg3 [default value: null]
	 * @param mixed $arg4 [default value: null]
	 * @param mixed $arg5 [default value: null]
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function onSort($str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		$args = func_get_args();
		$str_function = array_shift($args);
		$this->callback_onsort = $this->loadCallbackMethod($str_function, $args);
		return $this;
	}
	
	/**
	 * Method onSortJs
	 * @access public
	 * @param mixed $js_function 
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function onSortJs($js_function) {
		$this->onsort = trim($js_function);
		return $this;
	}
	
	/**
	 * Method onSortStartJs
	 * @access public
	 * @param mixed $js_function 
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function onSortStartJs($js_function) {
		$this->onsortstart = trim($js_function);
		return $this;
	}
	
	/**
	 * Method onSortChangeJs
	 * @access public
	 * @param mixed $js_function 
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function onSortChangeJs($js_function) {
		$this->onsortchange = trim($js_function);
		return $this;
	}
	
	/**
	 * Method onSortUpdateJs
	 * @access public
	 * @param mixed $js_function 
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function onSortUpdateJs($js_function) {
		$this->onsortupdate = trim($js_function);
		return $this;
	}
	
	/**
	 * Method onSortStopJs
	 * @access public
	 * @param mixed $js_function 
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function onSortStopJs($js_function) {
		$this->onsortstop = trim($js_function);
		return $this;
	}
	
	/**
	 * Method onSortRemoveJs
	 * @access public
	 * @param mixed $js_function 
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function onSortRemoveJs($js_function) {
		$this->onsortremove = trim($js_function);
		return $this;
	}
	
	/**
	 * Method onSortOverJs
	 * @access public
	 * @param mixed $js_function 
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function onSortOverJs($js_function) {
		$this->onsortover = trim($js_function);
		return $this;
	}
	
	/**
	 * Method onSortOutJs
	 * @access public
	 * @param mixed $js_function 
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function onSortOutJs($js_function) {
		$this->onsortout = trim($js_function);
		return $this;
	}
	
	/**
	 * Method isSorted
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function isSorted() {
		if (!$this->is_sorted) {
			$this->page_object->getUserEventObject();
		}
		return $this->is_sorted;
	}
	
	/* Intern management of SortableEvent */
	/**
	 * Method setSortableId
	 * @access public
	 * @param mixed $id 
	 * @since 1.0.59
	 */
	public function setSortableId($id) {
		$this->sortable_id = $id;
	}
	
	/**
	 * Method getSortableId
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getSortableId() {
		return $this->sortable_id;
	}
	
	/**
	 * Method getName
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object SortableEvent
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$this->automaticAjaxEvent();
		
		$html = "";
		if ($this->callback_onsort != "") {
			$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
		}
		
		$html .= $this->getJavascriptTagOpen();
		if ($this->is_ajax_event) {
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
