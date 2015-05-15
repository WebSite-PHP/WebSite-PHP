<?php
/**
 * PHP file wsp\class\display\advanced_object\autocomplete\AutoCompleteEvent.class.php
 * @package display
 * @subpackage advanced_object.autocomplete
 */
/**
 * Class AutoCompleteEvent
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object.autocomplete
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

class AutoCompleteEvent extends WebSitePhpEventObject {
	/**#@+
	* @access private
	*/
	private $onselect = "";
	private $callback_onselect = "";
	private $is_selected = false;
	/**#@-*/
	
	/**
	 * Constructor AutoCompleteEvent
	 * @param mixed $page_or_form_object [default value: null]
	 * @param string $name 
	 */
	function __construct($page_or_form_object=null, $name='') {
		parent::__construct();
		
		if ($page_or_form_object == null) {
			$page_or_form_object = $this->getPage();
		}
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

	/* Intern management of AutoCompleteEvent */
	/**
	 * Method setClick
	 * @access public
	 * @return AutoCompleteEvent
	 * @since 1.0.95
	 */
	public function setClick() {
		if ($GLOBALS['__LOAD_VARIABLES__']) { 
			$this->is_selected = true; 
		}
		return $this;
	}
	
	/**
	 * Method getOnSelectJs
	 * @access public
	 * @return mixed
	 * @since 1.0.95
	 */
	public function getOnSelectJs() {
		return $this->onselect;
	}
	
	/**
	 * Method onSelect
	 * @access public
	 * @param mixed $str_function 
	 * @param mixed $arg1 [default value: null]
	 * @param mixed $arg2 [default value: null]
	 * @param mixed $arg3 [default value: null]
	 * @param mixed $arg4 [default value: null]
	 * @param mixed $arg5 [default value: null]
	 * @return AutoCompleteEvent
	 * @since 1.0.95
	 */
	public function onSelect($str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		$args = func_get_args();
		$str_function = array_shift($args);
		$args = array_merge(array(new JavaScript("\'' + ui.item.id + '\'")), $args);
		
		$this->callback_onselect = $this->loadCallbackMethod($str_function, $args);
		return $this;
	}
	
	/**
	 * Method onSelectJs
	 * @access public
	 * @param mixed $js_function 
	 * @return AutoCompleteEvent
	 * @since 1.0.35
	 */
	public function onSelectJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onSelectJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onselect = trim($js_function);
		return $this;
	}
	
	/**
	 * Method isSelected
	 * @access public
	 * @return mixed
	 * @since 1.0.95
	 */
	public function isSelected() {
		if ($this->callback_onselect == "") {
			throw new NewException(get_class($this)."->isSelected(): this method can be used only if an onSelect event is defined on this ".get_class($this).".", 0, getDebugBacktrace(1));
		}
		return $this->is_selected;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object AutoCompleteEvent
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";
		if ($this->callback_onselect != "") {
			$html .= "if ($('#Callback_".$this->getEventObjectName()."').type != 'hidden') { var \$new_hidden = $('<input type=\'hidden\' id=\'Callback_".$this->getEventObjectName()."\' name=\'Callback_".$this->getEventObjectName()."\' value=\'\'/>'); $('body').append(\$new_hidden); }\n";
		}
		
		if ($this->is_ajax_event) {
			$html .= $this->getAjaxEventFunctionRender();
		}
		
		if ($this->onselect != "" || $this->callback_onselect != "") {
			$html .= $this->getObjectEventValidationRender($this->onselect, $this->callback_onselect);
		}
		
		$this->object_change = false;
		return $html;
	}
}
?>
