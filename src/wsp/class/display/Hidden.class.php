<?php
/**
 * PHP file wsp\class\display\Hidden.class.php
 * @package display
 */
/**
 * Class Hidden
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.17
 */

class Hidden extends WebSitePhpEventObject {
	/**#@+
	* @access private
	*/
	protected $class_name = "";
	protected $page_object = null;
	protected $form_object = null;
	private $value = "";
	private $default_value = "";
	
	private $strip_tags = false;
	private $strip_tags_allowable = "";
	private $is_not_wsp_object_name = false;
	/**#@-*/
	
	/**
	 * Constructor Hidden
	 * @param mixed $page_or_form_object 
	 * @param string $name 
	 * @param string $id 
	 * @param string $value 
	 */
	function __construct($page_or_form_object, $name='', $id='', $value='') {
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
		
		if ($id == "") {
			$this->id = $name;
		} else {
			$this->id = $id;
		}
		$this->value = $value;
		$this->default_value = $value;
	}
	
	/**
	 * Method setValue
	 * @access public
	 * @param mixed $value 
	 * @return Hidden
	 * @since 1.0.35
	 */
	public function setValue($value) {
		if ($this->strip_tags) {
			$this->value = strip_tags($value, $this->strip_tags_allowable);
		} else {
			$this->value = $value;
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}

	/**
	 * Method setDefaultValue
	 * @access public
	 * @param mixed $value 
	 * @return Hidden
	 * @since 1.0.35
	 */
	public function setDefaultValue($value) {
		$this->default_value = $value;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setStripTags
	 * @access public
	 * @param string $allowable_tags 
	 * @return Hidden
	 * @since 1.1.2
	 */
	public function setStripTags($allowable_tags='') {
		$this->strip_tags = true;
		$this->strip_tags_allowable = $allowable_tags;
		return $this;
	}
	
	/**
	 * Method setNotWspObjectName
	 * @access public
	 * @param mixed $name 
	 * @return Hidden
	 * @since 1.2.10
	 */
	public function setNotWspObjectName($name) {
		$this->name = $name;
		$this->id = $name;
		$this->is_not_wsp_object_name = true;
		return $this;
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
	 * Method getId
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Method getEventObjectName
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getEventObjectName() {
		return $this->class_name."_".$this->name;
	}

	/**
	 * Method getValue
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getValue() {
		$this->initSubmitValue(); // init value with submit value if not already do
		return $this->value;
	}

	/**
	 * Method getDefaultValue
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getDefaultValue() {
		return $this->default_value;
	}

	/**
	 * Method getFormObject
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getFormObject() {
		return $this->form_object;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Hidden
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";
		if ($this->class_name != "") {
			$html .= "<input type='hidden' name='";
			if ($this->is_not_wsp_object_name) {
				$html .= $this->getName();
			} else {
				$html .= $this->getEventObjectName();
			}
			$html .= "' id='".$this->id."' value=\"".str_replace('"', '\\"', $this->value)."\"/>";
		}
		$this->object_change = false;
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object Hidden (call with AJAX)
	 * @since 1.0.35
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
