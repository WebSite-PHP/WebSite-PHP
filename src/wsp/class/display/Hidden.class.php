<?php
class Hidden extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	protected $class_name = "";
	protected $page_object = null;
	protected $form_object = null;
	private $name = "";
	private $id = "";
	private $value = "";
	private $default_value = "";
	/**#@-*/
	
	function __construct($page_or_form_object, $name='', $id='', $value='') {
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
		
		$this->page_object->addEventObject($this, $this->form_object);
	}
	
	public function setValue($value) {
		$this->value = $value;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}

	public function setDefaultValue($value) {
		$this->default_value = $value;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
		
	public function getName() {
		return $this->name;
	}
		
	public function getId() {
		return $this->id;
	}
	
	public function getEventObjectName() {
		return $this->class_name."_".$this->name;
	}

	public function getValue() {
		return $this->value;
	}

	public function getDefaultValue() {
		return $this->default_value;
	}

	public function getFormObject() {
		return $this->form_object;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		if ($this->class_name != "") {
			$html .= "<input type='hidden' name='".$this->getEventObjectName()."' id='".$this->id."' value='".$this->value."'/>";
		}
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
			$html .= "$('#".$this->id."').val(\"".str_replace('"', '\\"', $this->value)."\");\n";
		}
		return $html;
	}
}
?>
