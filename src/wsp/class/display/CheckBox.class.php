<?php
/**
 * PHP file wsp\class\display\CheckBox.class.php
 * @package display
 */
/**
 * Class CheckBox
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.0.99
 * @access      public
 * @since       1.0.17
 */

class CheckBox extends WebSitePhpEventObject {
	/**#@+
	* @access private
	*/
	protected $class_name = "";
	protected $page_object = null;
	protected $form_object = null;
	protected $name = "";
	private $text = "";
	private $checked = "";
	private $default_value = "";
	private $on_off_style = false;
	
	private $is_changed = false;
	private $onchange = "";
	private $callback_onchange = "";
	/**#@-*/
	
	/**
	 * Constructor CheckBox
	 * @param mixed $page_or_form_object 
	 * @param string $name 
	 * @param string $text 
	 * @param string $checked 
	 */
	function __construct($page_or_form_object, $name='', $text='', $checked='') {
		parent::__construct();
		
		if (!isset($page_or_form_object) || gettype($page_or_form_object) != "object" || (!is_subclass_of($page_or_form_object, "Page") && get_class($page_or_form_object) != "Form")) {
			throw new NewException("Argument page_or_form_object for ".get_class($this)."::__construct() error", 0, getDebugBacktrace(1));
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
			$name = $this->page_object->createObjectName($this);
			$this->name = $name;
		} else {
			$exist_object = $this->page_object->existsObjectName($name);
			$this->name = $name;
			if ($exist_object != false) {
				throw new NewException("Tag name \"".$name."\" for object ".get_class($this)." already use for other object ".get_class($exist_object), 0, getDebugBacktrace(1));
			}
			$this->page_object->addEventObject($this, $this->form_object);
		}
		
		$this->text = $text;
		if ($checked == true || $checked == "on") {
			$this->setValue("on");
		} else {
			$this->setValue("");
		}
		$this->default_value = $checked;
	}
	
	/**
	 * Method activateOnOffStyle
	 * @access public
	 * @return CheckBox
	 * @since 1.0.89
	 */
	public function activateOnOffStyle() {
		$this->on_off_style = true;
		
		JavaScriptInclude::getInstance()->addToEnd(BASE_URL."wsp/js/iphone-style-checkboxes.js", "", true);
		CssInclude::getInstance()->add(BASE_URL."wsp/css/iphone-style-checkboxes.css", "", true);
		
		return $this;
	}
	
	/**
	 * Method setValue
	 * @access public
	 * @param mixed $value 
	 * @return CheckBox
	 * @since 1.0.36
	 */
	public function setValue($value) {
		if ($value != "on" && $value != "off" && $value != "") {
			throw new NewException("Object ".get_class($this)." don't accept the check value ".$value." (accepted values: `empty`, on, off)", 0, getDebugBacktrace(1));
		}
		$this->checked = $value;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setText
	 * @access public
	 * @param mixed $text 
	 * @return CheckBox
	 * @since 1.0.36
	 */
	public function setText($text) {
		$this->text = $text;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setChecked
	 * @access public
	 * @return CheckBox
	 * @since 1.0.36
	 */
	public function setChecked() {
		$this->setValue("on");
		return $this;
	}

	/**
	 * Method setDefaultValue
	 * @access public
	 * @param mixed $value 
	 * @return CheckBox
	 * @since 1.0.36
	 */
	public function setDefaultValue($value) {
		$this->default_value = $value;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setName
	 * @access public
	 * @param mixed $name 
	 * @return CheckBox
	 * @since 1.0.36
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	
	/**
	 * Method getName
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getName() {
		return $this->name;
	}
		
	/**
	 * Method getId
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getId() {
		return $this->name;
	}
	
	/**
	 * Method getEventObjectName
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getEventObjectName() {
		return $this->class_name."_".$this->name;
	}

	/**
	 * Method getValue
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getValue() {
		return $this->checked;
	}

	/**
	 * Method isChecked
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function isChecked() {
		return ($this->checked == "on") ? true : false;
	}

	/**
	 * Method getDefaultValue
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getDefaultValue() {
		return $this->default_value;
	}

	/**
	 * Method getFormObject
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getFormObject() {
		return $this->form_object;
	}
	
	/**
	 * Method onChange
	 * @access public
	 * @param mixed $str_function 
	 * @param mixed $arg1 [default value: null]
	 * @param mixed $arg2 [default value: null]
	 * @param mixed $arg3 [default value: null]
	 * @param mixed $arg4 [default value: null]
	 * @param mixed $arg5 [default value: null]
	 * @return CheckBox
	 * @since 1.0.89
	 */
	public function onChange($str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		$args = func_get_args();
		$str_function = array_shift($args);
		$this->callback_onchange = $this->loadCallbackMethod($str_function, $args);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method onChangeJs
	 * @access public
	 * @param mixed $js_function 
	 * @return CheckBox
	 * @since 1.0.89
	 */
	public function onChangeJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript") {
			throw new NewException(get_class($this)."->onChangeJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript") {
			$js_function = $js_function->render();
		}
		$this->onchange = trim($js_function);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method isChanged
	 * @access public
	 * @return mixed
	 * @since 1.0.89
	 */
	public function isChanged() {
		if ($this->callback_onchange == "") {
			if ($this->getValue() != $this->getDefaultValue()) {
				return true;
			} else {
				return false;
			}
		} else {
			return $this->is_changed;
		}
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object CheckBox
	 * @since 1.0.36
	 */
	public function render($ajax_render=false) {
		$this->automaticAjaxEvent();
		
		$html = "";
		if ($this->callback_onchange != "") {
			$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
		}
		if ($this->is_ajax_event) {
			if ($this->form_object == null) {
				throw new NewException("Unable to activate action to this ".get_class($this)." : Attribut page_or_form_object must be a Form object", 0, getDebugBacktrace(1));
			}
			$html .= $this->getJavascriptTagOpen();
			$html .= $this->getAjaxEventFunctionRender();
			$html .= $this->getJavascriptTagClose();
		}
		
		$html .= "<label for=\"".$this->getEventObjectName()."\"><input type=\"checkbox\" id=\"".$this->getEventObjectName()."\" name=\"".$this->getEventObjectName()."\"";
		if ($this->checked == "on") {
			$html .= " CHECKED";
		}
		if ($this->onchange != "" || $this->callback_onchange != "") {
			$html .= " onChange=\"".str_replace("\n", "", $this->getObjectEventValidationRender($this->onchange, $this->callback_onchange))."\"";
		}
		$html .= "/> ".$this->text."</label>\n";
		if ($this->on_off_style) {
			$html .= $this->getJavascriptTagOpen();
			$html .= "$(document).ready(function() { $('#".$this->getEventObjectName()."').iphoneStyle(); });\n";
			$html .= $this->getJavascriptTagClose();
		}
		$this->object_change = false;
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object CheckBox (call with AJAX)
	 * @since 1.0.36
	 */
	public function getAjaxRender() {
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			$html .= "$('#".$this->getEventObjectName()."').attr('checked', ";
			if ($this->checked == "on") {
				$html .= "true";
			} else {
				$html .= "false";
			}
			$html .= ");\n";
			$html .= "$('#".$this->getEventObjectName()."').attr('onChange', '".addslashes(str_replace("\n", "", $this->getObjectEventValidationRender($this->onchange, $this->callback_onchange)))."');\n";
		}
		return $html;
	}
	
}
?>
