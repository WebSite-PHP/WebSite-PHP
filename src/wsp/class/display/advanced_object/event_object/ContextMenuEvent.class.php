<?php
/**
 * PHP file wsp\class\display\advanced_object\event_object\ContextMenuEvent.class.php
 * @package display
 * @subpackage advanced_object.event_object
 */
/**
 * Class ContextMenuEvent
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

class ContextMenuEvent extends WebSitePhpEventObject {
	/**#@+
	* @access private
	*/
	private $onclick = "";
	private $callback_onclick = "";
	private $is_clicked = false;
	private $is_render = false;
	/**#@-*/
	
	/**
	 * Constructor ContextMenuEvent
	 * @param Page|Form $page_or_form_object 
	 * @param string $name 
	 */
	function __construct($page_or_form_object, $name='') {
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
		$this->ajax_wait_message = __(SUBMIT_LOADING_2);
	}
	
	/* Intern management of ContextMenuEvent */
	/**
	 * Method setClick
	 * @access public
	 * @return ContextMenuEvent
	 * @since 1.0.35
	 */
	public function setClick() {
		if ($GLOBALS['__LOAD_VARIABLES__']) { 
			$this->is_clicked = true; 
		}
		return $this;
	}
	
	/**
	 * Method getOnClickJs
	 * @access public
	 * @return string
	 * @since 1.0.35
	 */
	public function getOnClickJs() {
		return $this->onclick;
	}
	
	/**
	 * Method onClick
	 * @access public
	 * @param string $str_function 
	 * @param string $arg1 [default value: null]
	 * @param string $arg2 [default value: null]
	 * @param string $arg3 [default value: null]
	 * @param string $arg4 [default value: null]
	 * @param string $arg5 [default value: null]
	 * @return ContextMenuEvent
	 * @since 1.0.35
	 */
	public function onClick($str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		$args = func_get_args();
		$str_function = array_shift($args);
		$this->callback_onclick = $this->loadCallbackMethod($str_function, $args);
		return $this;
	}
	
	/**
	 * Method onClickJs
	 * @access public
	 * @param string|JavaScript $js_function 
	 * @return ContextMenuEvent
	 * @since 1.0.35
	 */
	public function onClickJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onClickJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onclick = trim($js_function);
		return $this;
	}
	
	/**
	 * Method isClicked
	 * @access public
	 * @return boolean
	 * @since 1.0.35
	 */
	public function isClicked() {
		if ($this->callback_onclick == "") {
			throw new NewException(get_class($this)."->isClicked(): this method can be used only if an onClick event is defined on this ".get_class($this).".", 0, getDebugBacktrace(1));
		}
		return $this->is_clicked;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object ContextMenuEvent
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";
		
		if (!$this->is_render) {
			$this->automaticAjaxEvent();
			
			$event_obj = new Object();
			if ($this->callback_onclick != "") {
				$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
			}
			
			$html .= $this->getJavascriptTagOpen();
			if ($this->is_ajax_event) {
				$html .= $this->getAjaxEventFunctionRender();
			}
			
			if ($this->onclick != "" || $this->callback_onclick != "") {
				$html .= "	function onClickContextMenu_".$this->getEventObjectName()."(selected_object_id) {\n";
				$html .= $this->getObjectEventValidationRender($this->onclick, $this->callback_onclick, "' + selected_object_id + '");
				$html .= "	}\n";
			}
			$html .= $this->getJavascriptTagClose();
			
			$this->is_render = true;
			$this->object_change = false;
		}
		return $html;
	}
}
?>
