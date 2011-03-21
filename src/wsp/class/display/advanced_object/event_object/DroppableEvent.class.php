<?php
/**
 * PHP file wsp\class\display\advanced_object\event_object\DroppableEvent.class.php
 * @package display
 * @subpackage advanced_object.event_object
 */
/**
 * Class DroppableEvent
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
 * @copyright   WebSite-PHP.com 22/10/2010
 * @version     1.0.62
 * @access      public
 * @since       1.0.17
 */

class DroppableEvent extends WebSitePhpEventObject {
	/**#@+
	* @access private
	*/
	private $droppable_id = "";
	
	private $ondrop = "";
	private $callback_ondrop = "";
	private $is_droped = false;
	/**#@-*/
	
	/**
	 * Constructor DroppableEvent
	 * @param mixed $page_or_form_object 
	 * @param string $name 
	 */
	function __construct($page_or_form_object, $name='') {
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
		
		$this->droppable_id = "";
		$this->ajax_wait_message = __(SUBMIT_LOADING_2);
		
		$this->page_object->addEventObject($this, $this->form_object);
	}
	
	/* Intern management of DroppableEvent */
	/**
	 * Method setDrop
	 * @access public
	 * @return DroppableEvent
	 * @since 1.0.35
	 */
	public function setDrop() {
		if ($GLOBALS['__LOAD_VARIABLES__']) { 
			$this->is_droped = true; 
		}
		return $this;
	}
	
	/**
	 * Method getOnDropJs
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getOnDropJs() {
		return $this->ondrop;
	}
	
	/**
	 * Method onDrop
	 * @access public
	 * @param mixed $str_function 
	 * @param mixed $arg1 [default value: null]
	 * @param mixed $arg2 [default value: null]
	 * @param mixed $arg3 [default value: null]
	 * @param mixed $arg4 [default value: null]
	 * @param mixed $arg5 [default value: null]
	 * @return DroppableEvent
	 * @since 1.0.35
	 */
	public function onDrop($str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		$args = func_get_args();
		$str_function = array_shift($args);
		$this->callback_ondrop = $this->loadCallbackMethod($str_function, $args);
		return $this;
	}
	
	/**
	 * Method onDropJs
	 * @access public
	 * @param mixed $js_function 
	 * @return DroppableEvent
	 * @since 1.0.35
	 */
	public function onDropJs($js_function) {
		$this->ondrop = trim($js_function);
		return $this;
	}
	
	/**
	 * Method isDroped
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function isDroped() {
		if (!$this->is_droped) {
			$this->page_object->getUserEventObject();
		}
		return $this->is_droped;
	}
	
	/* Intern management of DroppableEvent */
	/**
	 * Method setDroppableId
	 * @access public
	 * @param mixed $id 
	 * @since 1.0.59
	 */
	public function setDroppableId($id) {
		$this->droppable_id = $id;
	}
	
	/**
	 * Method getDroppableId
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getDroppableId() {
		return $this->droppable_id;
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
	 * @return string html code of object DroppableEvent
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$this->automaticAjaxEvent();
		
		$html = "";
		if ($this->callback_ondrop != "") {
			$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
		}
		
		$html .= $this->getJavascriptTagOpen();
		if ($this->is_ajax_event) {
			$html .= $this->getAjaxEventFunctionRender();
		}
		
		if ($this->ondrop != "" || $this->callback_ondrop != "") {
			$html .= "	$('#".$this->droppable_id."').bind('drop', function(event, ui) {\n";
			$html .= "		if (ui.draggable[0].id != '') {\n"; 
			$html .= $this->getObjectEventValidationRender($this->ondrop, $this->callback_ondrop, "' + ui.draggable[0].id + '");
			$html .= "		}\n";
			$html .= "		return false;\n";
			$html .= "	});\n";
		}
		$html .= $this->getJavascriptTagClose();
		
		$this->object_change = false;
		return $html;
	}
}
?>
