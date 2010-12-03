<?php
class CheckBox extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	protected $class_name = "";
	protected $page_object = null;
	protected $form_object = null;
	private $name = "";
	private $text = "";
	private $checked = "";
	private $default_value = "";
	/**#@-*/
	
	function __construct($page_or_form_object, $name='', $text='', $checked='') {
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
		$this->text = $text;
		if ($checked == true || $checked == "on") {
			$this->setValue("on");
		} else {
			$this->setValue("");
		}
		$this->default_value = $checked;
		
		$this->page_object->addEventObject($this, $this->form_object);
	}
	
	public function setValue($value) {
		if ($value != "on" && $value != "off" && $value != "") {
			throw new NewException("Object ".get_class($this)." don't accept the check value ".$value." (accepted values: `empty`, on, off)", 0, 8, __FILE__, __LINE__);
		}
		$this->checked = $value;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setText($text) {
		$this->text = $text;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setChecked() {
		$this->setValue("on");
		return $this;
	}

	public function setDefaultValue($value) {
		$this->default_value = $value;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	
	public function getName() {
		return $this->name;
	}
		
	public function getId() {
		return $this->name;
	}
	
	public function getEventObjectName() {
		return $this->class_name."_".$this->name;
	}

	public function getValue() {
		return $this->checked;
	}

	public function isChecked() {
		return ($this->checked == "on") ? true : false;
	}

	public function getDefaultValue() {
		return $this->default_value;
	}

	public function getFormObject() {
		return $this->form_object;
	}
	
	public function render($ajax_render=false) {
		$html = "<label for=\"".$this->getEventObjectName()."\"><input type=\"checkbox\" id=\"".$this->getEventObjectName()."\" name=\"".$this->getEventObjectName()."\"";
		if ($this->checked == "on") {
			$html .= " CHECKED";
		}
		$html .= "/> ".$this->text."</label>\n";
		$this->object_change = false;
		return $html;
	}
	
	/**
	 * function getAjaxRender
	 * @return string javascript code to update initial html with ajax call
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
		}
		return $html;
	}
	
}
?>
