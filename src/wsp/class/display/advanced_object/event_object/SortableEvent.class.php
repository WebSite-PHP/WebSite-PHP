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
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.event_object
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
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
	 * @param Page|Form $page_or_form_object 
	 * @param string $name 
	 * @param string $over_style [default value: droppablehover]
	 */
	function __construct($page_or_form_object, $name='', $over_style="droppablehover") {
		parent::__construct();
		
		if (!isset($page_or_form_object) || gettype($page_or_form_object) != "object" || (!is_subclass_of($page_or_form_object, "Page") && get_class($page_or_form_object) != "Form")) {
			throw new NewException("Argument page_object for ".get_class($this)."::__construct() error", 0, getDebugBacktrace(1));
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
			$this->page_object->addEventObject($this, $this->form_object);
		}
		$this->id = $name;
		
		$this->sortable_id = "";
		$this->over_style = $over_style;
		$this->ajax_wait_message = __(SUBMIT_LOADING_2);
		
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
	 * @return string
	 * @since 1.0.35
	 */
	public function getOnSortJs() {
		return $this->onsort;
	}
	
	/**
	 * Method onSort
	 * @access public
	 * @param string $str_function 
	 * @param string $arg1 [default value: null]
	 * @param string $arg2 [default value: null]
	 * @param string $arg3 [default value: null]
	 * @param string $arg4 [default value: null]
	 * @param string $arg5 [default value: null]
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function onSort($str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		$args = func_get_args();
		$str_function = array_shift($args);
		$this->callback_onsort = $this->loadCallbackMethod($str_function, $args);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $wsp_object = $this->getPage()->getObjectId($this->sortable_id); if ($wsp_object != null) { $wsp_object->forceAjaxRender(); } }
		return $this;
	}
	
	/**
	 * Method onSortJs
	 * @access public
	 * @param string|JavaScript $js_function 
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function onSortJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onSortJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onsort = trim($js_function);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $wsp_object = $this->getPage()->getObjectId($this->sortable_id); if ($wsp_object != null) { $wsp_object->forceAjaxRender(); } }
		return $this;
	}
	
	/**
	 * Method onSortStartJs
	 * @access public
	 * @param string|JavaScript $js_function 
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function onSortStartJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onSortStartJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onsortstart = trim($js_function);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $wsp_object = $this->getPage()->getObjectId($this->sortable_id); if ($wsp_object != null) { $wsp_object->forceAjaxRender(); } }
		return $this;
	}
	
	/**
	 * Method onSortChangeJs
	 * @access public
	 * @param string|JavaScript $js_function 
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function onSortChangeJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onSortChangeJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onsortchange = trim($js_function);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $wsp_object = $this->getPage()->getObjectId($this->sortable_id); if ($wsp_object != null) { $wsp_object->forceAjaxRender(); } }
		return $this;
	}
	
	/**
	 * Method onSortUpdateJs
	 * @access public
	 * @param string|JavaScript $js_function 
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function onSortUpdateJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onSortUpdateJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onsortupdate = trim($js_function);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $wsp_object = $this->getPage()->getObjectId($this->sortable_id); if ($wsp_object != null) { $wsp_object->forceAjaxRender(); } }
		return $this;
	}
	
	/**
	 * Method onSortStopJs
	 * @access public
	 * @param string|JavaScript $js_function 
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function onSortStopJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onSortStopJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onsortstop = trim($js_function);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $wsp_object = $this->getPage()->getObjectId($this->sortable_id); if ($wsp_object != null) { $wsp_object->forceAjaxRender(); } }
		return $this;
	}
	
	/**
	 * Method onSortRemoveJs
	 * @access public
	 * @param string|JavaScript $js_function 
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function onSortRemoveJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onSortRemoveJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onsortremove = trim($js_function);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $wsp_object = $this->getPage()->getObjectId($this->sortable_id); if ($wsp_object != null) { $wsp_object->forceAjaxRender(); } }
		return $this;
	}
	
	/**
	 * Method onSortOverJs
	 * @access public
	 * @param string|JavaScript $js_function 
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function onSortOverJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onSortOverJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onsortover = trim($js_function);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $wsp_object = $this->getPage()->getObjectId($this->sortable_id); if ($wsp_object != null) { $wsp_object->forceAjaxRender(); } }
		return $this;
	}
	
	/**
	 * Method onSortOutJs
	 * @access public
	 * @param string|JavaScript $js_function 
	 * @return SortableEvent
	 * @since 1.0.35
	 */
	public function onSortOutJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onSortOutJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onsortout = trim($js_function);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $wsp_object = $this->getPage()->getObjectId($this->sortable_id); if ($wsp_object != null) { $wsp_object->forceAjaxRender(); } }
		return $this;
	}
	
	/**
	 * Method isSorted
	 * @access public
	 * @return boolean
	 * @since 1.0.35
	 */
	public function isSorted() {
		if ($this->callback_onsort == "") {
			throw new NewException(get_class($this)."->isSorted(): this method can be used only if an onSort event is defined on this ".get_class($this).".", 0, getDebugBacktrace(1));
		}
		if (!$this->is_sorted) {
			if ($this->form_object == null) {
				if (isset($_POST["Callback_".$this->getEventObjectName()]) && $_POST["Callback_".$this->getEventObjectName()] != "") {
					$this->is_sorted = true;
				} else if (isset($_GET["Callback_".$this->getEventObjectName()]) && $_GET["Callback_".$this->getEventObjectName()] != "") {
					$this->is_sorted = true;
				}
			} else {
				if ($this->form_object->getMethod() == "POST" && isset($_POST["Callback_".$this->getEventObjectName()]) && $_POST["Callback_".$this->getEventObjectName()] != "") {
					$this->is_sorted = true;
				} else if (isset($_GET["Callback_".$this->getEventObjectName()]) && $_GET["Callback_".$this->getEventObjectName()] != "") {
					$this->is_sorted = true;
				}
			}
		}
		return $this->is_sorted;
	}
	
	/* Intern management of SortableEvent */
	/**
	 * Method setSortableId
	 * @access public
	 * @param string $id 
	 * @return SortableEvent
	 * @since 1.0.59
	 */
	public function setSortableId($id) {
		$this->sortable_id = $id;
		return $this;
	}
	
	/**
	 * Method getSortableId
	 * @access public
	 * @return string
	 * @since 1.0.35
	 */
	public function getSortableId() {
		return $this->sortable_id;
	}
	
	/**
	 * Method getName
	 * @access public
	 * @return string
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
		if (!$ajax_render) {
			if ($this->callback_onsort != "") {
				$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
			}
			
			$html .= $this->getJavascriptTagOpen();
			if ($this->is_ajax_event) {
				$html .= $this->getAjaxEventFunctionRender();
			}
		}
		
		if ($this->onsort != "" || $this->callback_onsort != "") {
			$html .= "	$(document).ready(function(){ saveSerializeSortableObject('".$this->sortable_id."'); });\n";
			$html .= "	$('#".$this->sortable_id."').bind('sortstart', function(event, ui) { ".$this->onsortstart."return sortableEventStart('".$this->sortable_id."', ui); });\n";
			$html .= "	$('#".$this->sortable_id."').bind('sortstop', function(event, ui) { ".$this->onsortstop."return sortableEventStop('".$this->sortable_id."', ui); });\n";
			$html .= "	$('#".$this->sortable_id."').bind('sortupdate', function(event, ui) { ".$this->onsortupdate."return sortableEventUpdate('".$this->sortable_id."', ui); });\n";
			$html .= "	$('#".$this->sortable_id."').bind('sortchange', function(event, ui) { ".$this->onsortchange."return sortableEventChangeSaveObject('".$this->sortable_id."', ui); });\n";
			$html .= "	$('#".$this->sortable_id."').bind('sortremove', function(event, ui) { ".$this->onsortremove."return sortableEventRemove('".$this->sortable_id."', ui); });\n";
			$html .= "	$('#".$this->sortable_id."').bind('sortover', function(event, ui) { ".$this->onsortover.";return sortableEventOver('".$this->sortable_id."', ui, '".$this->over_style."'); });\n";
			$html .= "	$('#".$this->sortable_id."').bind('sortout', function(event, ui) { ".$this->onsortout.";return sortableEventOut('".$this->sortable_id."', ui, '".$this->over_style."'); });\n";
			
			$html .= "	move_".$this->sortable_id."_ObjectEvent = function(moved_object, from_object, to_object, position, old_position) {\n";
			$html .= $this->getObjectEventValidationRender($this->onsort, $this->callback_onsort, "' + moved_object + ',' + from_object + ',' + to_object + ',' + position + ',' + old_position + '");
			$html .= "	};\n";
		}
		
		if (!$ajax_render) {
			$html .= $this->getJavascriptTagClose();
		}
		
		$this->object_change = false;
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object SortableEvent (call with AJAX)
	 * @since 1.2.3
	 */
	public function getAjaxRender() {
		$this->automaticAjaxEvent();
		
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			$html = $this->render(true);
			
			$this->object_change = false;
		}
		return $html;
	}
}
?>
