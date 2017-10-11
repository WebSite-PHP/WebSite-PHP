<?php
/**
 * PHP file wsp\class\display\RadioButtonGroup.class.php
 * @package display
 */
/**
 * Class RadioButtonGroup
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2017 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 11/10/2017
 * @version     1.2.15
 * @access      public
 * @since       1.2.3
 */

class RadioButtonGroup extends WebSitePhpEventObject {
	/**#@+
	* @access private
	*/
	protected $class_name = "";
	protected $page_object = null;
	protected $form_object = null;
	protected $name = "";
	protected $value = "";
	private $default_value = "";
	private $disable = false;
	private $array_value = array();
	private $array_text = array();
	private $is_carriage_return = false;
	
	private $is_changed = false;
	private $onchange = "";
	private $callback_onchange = "";
	/**#@-*/
	
	/**
	 * Constructor RadioButtonGroup
	 * @param mixed $page_or_form_object 
	 * @param string $name 
	 */
	function __construct($page_or_form_object, $name='') {
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
	}
	
	/**
	 * Method addRadioButton
	 * @access public
	 * @param mixed $value 
	 * @param string $text 
	 * @param boolean $selected [default value: false]
	 * @return RadioButtonGroup
	 * @since 1.2.3
	 */
	public function addRadioButton($value, $text='', $selected=false) {
		if ($value != "" && $text=="") {
			$text = $value;
		}
		$this->array_value[] = $value;
		if (gettype($text) == "object" && method_exists($text, "render")) {
			$text = $text->render();
		}
		$this->array_text[] = $text;
		if ($selected) {
			$save_is_changed = $this->is_changed;
			$this->setValue($value);
			$this->is_changed = $save_is_changed;
		}
		
		return $this;
	}
	
	/**
	 * Method setValue
	 * @access public
	 * @param mixed $value 
	 * @return RadioButtonGroup
	 * @since 1.2.3
	 */
	public function setValue($value) {
		if (!$this->getSubmitValueIsInit() && $GLOBALS['__PAGE_IS_INIT__'] == true) {
			$this->setSubmitValueIsInit();
		}
		$this->value = $value;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		$this->is_changed = true;
		return $this;
	}

	/**
	 * Method setDefaultValue
	 * @access public
	 * @param mixed $value 
	 * @return RadioButtonGroup
	 * @since 1.2.3
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
	 * @return RadioButtonGroup
	 * @since 1.2.3
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	
	/**
	 * Method disable
	 * @access public
	 * @return RadioButtonGroup
	 * @since 1.2.3
	 */
	public function disable() {
		$this->disable = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method enable
	 * @access public
	 * @return RadioButtonGroup
	 * @since 1.2.3
	 */
	public function enable() {
		$this->disable = false;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method getName
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getName() {
		return $this->name;
	}
		
	/**
	 * Method getId
	 * @access public
	 * @param mixed $radio_value 
	 * @return boolean
	 * @since 1.2.3
	 */
	public function getId($radio_value) {
		for ($i=0; $i < sizeof($this->array_value); $i++) {
			if ($this->array_value[$i] === $radio_value) {
				return $this->name."_".$i;
			}
		}
		return false;
	}
	
	/**
	 * Method getEventObjectName
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getEventObjectName() {
		return $this->class_name."_".$this->name;
	}

	/**
	 * Method getValue
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getValue() {
		if (sizeof($this->array_value) > 0) { // init selected index with submit value if not already do
			$this->initSubmitValue();
		}
		return $this->value;
	}

	/**
	 * Method getDefaultValue
	 * @access public
	 * @return mixed
	 * @since 1.2.3
	 */
	public function getDefaultValue() {
		return $this->default_value;
	}

	/**
	 * Method getFormObject
	 * @access public
	 * @return mixed
	 * @since 1.2.3
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
	 * @return RadioButtonGroup
	 * @since 1.2.3
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
	 * @return RadioButtonGroup
	 * @since 1.2.3
	 */
	public function onChangeJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onChangeJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
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
	 * @since 1.2.3
	 */
	public function isChanged() {
		if ($this->callback_onchange == "") {
			if ($this->getValue() != $this->getDefaultValue()) {
				return true;
			} else {
				return false;
			}
		} else {
			if (sizeof($this->array_value) > 0) { // init selected index with submit value if not already do
				$this->initSubmitValue();
			}
			return $this->is_changed;
		}
	}
	
	/**
	 * Method activateCarriageReturn
	 * @access public
	 * @param boolean $bool [default value: true]
	 * @return RadioButtonGroup
	 * @since 1.2.15
	 */
	public function activateCarriageReturn($bool=true) {
		$this->is_carriage_return = $bool;
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object RadioButtonGroup
	 * @since 1.2.3
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
		
		for ($i=0; $i < sizeof($this->array_value); $i++) {
			$html .= "<label for=\"".$this->getId($this->array_value[$i])."\"><input type=\"radio\" id=\"".$this->getId($this->array_value[$i])."\" name=\"".$this->getEventObjectName()."\" value=\"".$this->array_value[$i]."\"";
			if ($this->array_value[$i] == $this->getValue()) {
				$html .= " CHECKED";
			}
			if ($this->onchange != "" || $this->callback_onchange != "") {
				$html .= " onChange=\"".str_replace("\n", "", $this->getObjectEventValidationRender($this->onchange, $this->callback_onchange))."\"";
			}
			if ($this->disable) {
				$html .=' disabled';
			}    
			$html .= "/>".$this->array_text[$i]."</label>";
			if ($this->is_carriage_return) {
				$html .= "<br/>";
			}
			$html .= "\n";
		}
		$this->object_change = false;
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object RadioButtonGroup (call with AJAX)
	 * @since 1.2.3
	 */
	public function getAjaxRender() {
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			$radio_checked_id = $this->getId($this->getValue());
			if ($radio_checked_id !== false) {
				$html .= "$('#".$radio_checked_id."').attr('checked', true);\n";
			}
			$html .= "$('#".$this->getEventObjectName()."').attr('onChange', '".addslashes(str_replace("\n", "", $this->getObjectEventValidationRender($this->onchange, $this->callback_onchange)))."');\n";
			$html .= "$('#".$this->getEventObjectName()."').attr('disabled', ".(($this->disable)?"true":"false").");\n";
		}
		return $html;
	}
	
}
?>
