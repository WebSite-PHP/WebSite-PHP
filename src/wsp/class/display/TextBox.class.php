<?php
/**
 * PHP file wsp\class\display\TextBox.class.php
 * @package display
 */
/**
 * Class TextBox
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
 * @copyright   WebSite-PHP.com 22/10/2010
 * @version     1.0.77
 * @access      public
 * @since       1.0.17
 */

class TextBox extends WebSitePhpEventObject {
	/**#@+
	* @access protected
	*/
	protected $type = "text";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $value = "";
	private $default_value = "";
	private $width = "";
	private $style = "";
	private $class = "";
	private $length = 0;
	private $disable = false;
	private $has_focus = false;
	
	private $live_validation = null;
	
	private $is_changed = false;
	private $onchange = "";
	private $callback_onchange = "";
	
	private $encrypt_object = null;
	
	private $autocomplete_object = null;
	/**#@-*/
	
	/**
	 * Constructor TextBox
	 * @param mixed $page_or_form_object 
	 * @param string $name 
	 * @param string $id 
	 * @param string $value 
	 * @param string $width 
	 * @param double $length [default value: 0]
	 */
	function __construct($page_or_form_object, $name='', $id='', $value='', $width='', $length=0) {
		parent::__construct();
		
		if (!isset($page_or_form_object) || gettype($page_or_form_object) != "object" || (!is_subclass_of($page_or_form_object, "Page") && get_class($page_or_form_object) != "Form")) {
			throw new NewException("Argument page_or_form_object for ".get_class($this)."::__construct() error", 0, 8, __FILE__, __LINE__);
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
		} else {
			$exist_object = $this->page_object->existsObjectName($name);
			if ($exist_object != false) {
				throw new NewException("Tag name \"".$name."\" for object ".get_class($this)." already use for other object ".get_class($exist_object), 0, 8, __FILE__, __LINE__);
			}
		}
		
		$this->name = $name;
		if ($id == "") {
			$this->id = $name;
		} else {
			$this->id = $id;
		}
		$this->value = $value;
		$this->default_value = $value;
		$this->width = $width;
		$this->length = $length;
		
		$this->page_object->addEventObject($this, $this->form_object);
	}
	
	/**
	 * Method setValue
	 * @access public
	 * @param mixed $value 
	 * @return TextBox
	 * @since 1.0.36
	 */
	public function setValue($value) {
		$this->value = $value;
		if (!$GLOBALS['__LOAD_VARIABLES__']) { 
			if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		} else {
			$this->is_changed = true; 
		}
		return $this;
	}

	/**
	 * Method setDefaultValue
	 * @access public
	 * @param mixed $value 
	 * @return TextBox
	 * @since 1.0.36
	 */
	public function setDefaultValue($value) {
		$this->default_value = $value;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setWidth
	 * @access public
	 * @param integer $width 
	 * @return TextBox
	 * @since 1.0.36
	 */
	public function setWidth($width) {
		$this->width = $width;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setStyle
	 * @access public
	 * @param mixed $style 
	 * @return TextBox
	 * @since 1.0.36
	 */
	public function setStyle($style) {
		$this->style = $style;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setClass
	 * @access public
	 * @param mixed $class 
	 * @return TextBox
	 * @since 1.0.36
	 */
	public function setClass($class) {
		$this->class = $class;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setLength
	 * @access public
	 * @param mixed $length 
	 * @return TextBox
	 * @since 1.0.36
	 */
	public function setLength($length) {
		$this->length = $length;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setName
	 * @access public
	 * @param mixed $name 
	 * @return TextBox
	 * @since 1.0.36
	 */
	public function setName($name) {
		$this->name = $name;
		if ($id == "") {
			$this->id = $name;
		}
		return $this;
	}
	
	/**
	 * Method setFocus
	 * @access public
	 * @return TextBox
	 * @since 1.0.36
	 */
	public function setFocus() {
		$this->has_focus = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setLiveValidation
	 * @access public
	 * @param mixed $live_validation_object 
	 * @return TextBox
	 * @since 1.0.36
	 */
	public function setLiveValidation($live_validation_object) {
		if (get_class($live_validation_object) != "LiveValidation") {
			throw new NewException("setLiveValidation(): \$live_validation_object must be a valid LiveValidation object", 0, 8, __FILE__, __LINE__);
		}
		$live_validation_object->setObject($this);
		$this->live_validation = $live_validation_object;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setAutoComplete
	 * @access public
	 * @param mixed $autocomplete_object 
	 * @return TextBox
	 * @since 1.0.36
	 */
	public function setAutoComplete($autocomplete_object) {
		if (gettype($autocomplete_object) != "object" && get_class($autocomplete_object) != "AutoComplete") {
			throw new NewException(get_class($this)."->setAutoComplete(): \$autocomplete_object must be a AutoComplete object", 0, 8, __FILE__, __LINE__);
		}
		$this->autocomplete_object = $autocomplete_object;
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setEncryptObject
	 * @access public
	 * @param mixed $encrypt_object 
	 * @return TextBox
	 * @since 1.0.67
	 */
	public function setEncryptObject($encrypt_object) {
		if ($encrypt_object == null) {
			$encrypt_object = new EncryptDataWspObject();
		}
		if (gettype($encrypt_object) != "object" || get_class($encrypt_object) != "EncryptDataWspObject") {
			throw new NewException(get_class($this)."->setEncryption(): \$encrypt_object must be a EncryptDataWspObject object.", 0, 8, __FILE__, __LINE__);
		}
		
		$this->addJavaScript(BASE_URL."wsp/js/jsbn.js", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/lowpro.jquery.js", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/rsa.js", "", true);
		
		$this->encrypt_object = $encrypt_object;
		$this->encrypt_object->setObject($this);
		
		return $this;
	}
	
	/**
	 * Method getEncryptObject
	 * @access public
	 * @return mixed
	 * @since 1.0.67
	 */
	public function getEncryptObject() {
		return $this->encrypt_object;
	}
	
	/**
	 * Method isEncrypted
	 * @access public
	 * @return mixed
	 * @since 1.0.67
	 */
	public function isEncrypted() {
		return ($this->encrypt_object==null?false:true);
	}
	
	/**
	 * Method enable
	 * @access public
	 * @return TextBox
	 * @since 1.0.36
	 */
	public function enable() {
		$this->disable = false;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method disable
	 * @access public
	 * @return TextBox
	 * @since 1.0.36
	 */
	public function disable() {
		$this->disable = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}

	/**
	 * Method getValue
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getValue() {
		$this->initSubmitValue(); // init value with submit value if not already do
		return $this->value;
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
	 * Method getClass
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getClass() {
		return $this->class;
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
	 * @return TextBox
	 * @since 1.0.36
	 */
	public function onChange($str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		$args = func_get_args();
		$str_function = array_shift($args);
		$this->callback_onchange = $this->loadCallbackMethod($str_function, $args);
		return $this;
	}
	
	/**
	 * Method onChangeJs
	 * @access public
	 * @param string|JavaScript $js_function 
	 * @return TextBox
	 * @since 1.0.36
	 */
	public function onChangeJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript") {
			throw new NewException(get_class($this)."->onChangeJs(): \$js_function must be a string or JavaScript object.", 0, 8, __FILE__, __LINE__);
		}
		if (get_class($js_function) == "JavaScript") {
			$js_function = $js_function->render();
		}
		$this->onchange = trim($js_function);
		return $this;
	}
	
	/**
	 * Method isChanged
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function isChanged() {
		if (!$this->is_changed) {
			$this->page_object->getUserEventObject();
		}
		return $this->is_changed;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object TextBox
	 * @since 1.0.36
	 */
	public function render($ajax_render=false) {
		$this->automaticAjaxEvent();
		
		$html = "";
		if ($this->class_name != "") {
			if ($this->callback_onchange != "") {
				$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
			}
			if ($this->is_ajax_event) {
				if ($this->form_object == null) {
					throw new NewException("Unable to activate action to this ".get_class($this)." : Attribut page_or_form_object must be a Form object", 0, 8, __FILE__, __LINE__);
				}
				$html .= $this->getJavascriptTagOpen();
				$html .= $this->getAjaxEventFunctionRender();
				$html .= $this->getJavascriptTagClose();
			}
			
			$html .= "<input ";
			if ($this->type != "") {
				$html .= "type='".$this->type."' ";
			}
			$html .= "name='".$this->getEventObjectName()."' id='".$this->id."' value='".$this->value."'";
			if ($this->width != "" || $this->style != "") {
				$html .= " style='";
				if ($this->width != "") {
					$html .= "width:";
					if (is_integer($this->width)) {
						$html .= $this->width."px";
					} else {
						$html .= $this->width;
					}
					$html .= ";";
				}
				if ($this->style != "") {
					$html .= $this->style.";";
				}
				$html .= "'";
			}
			if ($this->class != "") {
				$html .= " class='".$this->class."'";
			}
			if ($this->length > 0) {
				$html .= " length='".$this->length."'";
			}
			if ($this->disable) {
				$html .= " disabled";
			}
			if ($this->onchange != "" || $this->callback_onchange != "") {
				$html .= " onChange=\"".str_replace("\n", "", $this->getObjectEventValidationRender($this->onchange, $this->callback_onchange))."\"";
			}
			$html .= "/>\n";
			
			if ($this->live_validation != null) {
				$html .= $this->live_validation->render();
			}
			if (find($this->class, "color {") > 0 && ($GLOBALS['__AJAX_PAGE__'] == true || $GLOBALS['__AJAX_LOAD_PAGE__'] == true)) {
				$html .= $this->getJavascriptTagOpen();
				$html .= "jscolor.init();\n";
				$html .= $this->getJavascriptTagClose();
			}
			if ($this->has_focus) {
				$html .= $this->getJavascriptTagOpen();
				$html .= "\$('#".$this->getId()."').focus();\n";
				$html .= $this->getJavascriptTagClose();
			}
			if ($this->autocomplete_object != null) {
				if ($this->id == "") {
					throw new NewException("Error : You must specified an id for this object to use autocomplete functionality", 0, 8, __FILE__, __LINE__);
				}
				$this->autocomplete_object->setLinkObjectId($this->getId());
				$html .= $this->autocomplete_object->render();
			}
		}
		$this->object_change = false;
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object TextBox (call with AJAX)
	 * @since 1.0.36
	 */
	public function getAjaxRender() {
		$this->automaticAjaxEvent();
		
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			if ($this->isChanged()) {
				$html .= "$('#".$this->id."').val(\"".str_replace('"', '\\"', $this->value)."\");\n";
			}
			$html .= "$('#".$this->id."').css('width', \"";
			if (is_integer($this->width)) {
				$html .= $this->width."px";
			} else {
				$html .= $this->width;
			}
			$html .= "\");\n";
			$html .= "$('#".$this->id."').attr('class', \"".$this->class."\");";
			$html .= "$('#".$this->id."').attr('disabled', ".(($this->disable)?"true":"false").");\n";
			if ($this->length > 0) {
				$html .= "$('#".$this->id."').attr('maxLength', ".$this->length.");\n";
			}
			$html .= "$('#".$this->id."').attr('onChange', '".addslashes(str_replace("\n", "", $this->getObjectEventValidationRender($this->onchange, $this->callback_onchange)))."');\n";
			if ($this->has_focus) {
				$html .= "\$('#".$this->getId()."').focus();\n";
			}
		}
		return $html;
	}
	
}
?>
