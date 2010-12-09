<?php
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
	/**#@-*/
	
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
	
	public function setValue($value) {
		$this->value = $value;
		if (!$GLOBALS['__LOAD_VARIABLES__']) { 
			if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		} else {
			$this->is_changed = true; 
		}
		return $this;
	}

	public function setDefaultValue($value) {
		$this->default_value = $value;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setWidth($width) {
		$this->width = $width;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setStyle($style) {
		$this->style = $style;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setClass($class) {
		$this->class = $class;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setLength($length) {
		$this->length = $length;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setName($name) {
		$this->name = $name;
		if ($id == "") {
			$this->id = $name;
		}
	}
	
	public function setFocus() {
		$this->has_focus = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setLiveValidation($live_validation_object) {
		if (get_class($live_validation_object) != "LiveValidation") {
			throw new NewException("setLiveValidation(): \$live_validation_object must be a valid LiveValidation object", 0, 8, __FILE__, __LINE__);
		}
		$live_validation_object->setObject($this);
		$this->live_validation = $live_validation_object;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function enable() {
		$this->disable = false;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function disable() {
		$this->disable = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}

	public function getValue() {
		$this->initSubmitValue(); // init value with submit value if not already do
		return $this->value;
	}

	public function getDefaultValue() {
		return $this->default_value;
	}
		
	public function getClass() {
		return $this->class;
	}
	
	public function onChange($str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		$args = func_get_args();
		$str_function = array_shift($args);
		$this->callback_onchange = $this->loadCallbackMethod($str_function, $args);
		return $this;
	}
	
	public function onChangeJs($js_function) {
		$this->onchange = trim($js_function);
		return $this;
	}
	
	public function isChanged() {
		if (!$this->is_changed) {
			$this->page_object->getUserEventObject();
		}
		return $this->is_changed;
	}
	
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
		}
		$this->object_change = false;
		return $html;
	}
	
	/**
	 * function getAjaxRender
	 * @return string javascript code to update initial html with ajax call
	 */
	public function getAjaxRender() {
		$this->automaticAjaxEvent();
		
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			$html .= "$('#".$this->id."').val(\"".str_replace('"', '\\"', $this->value)."\");\n";
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
