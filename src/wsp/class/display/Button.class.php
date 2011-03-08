<?php
/**
 * PHP file wsp\class\display\Button.class.php
 * @package display
 */
/**
 * Class Button
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
 * @version     1.0.57
 * @access      public
 * @since       1.0.17
 */

class Button extends WebSitePhpEventObject {
	/**#@+
	* @access private
	*/
	private $value = "";
	private $default_value = "";
	private $width = 0;
	private $class = "";
	private $is_link = false;
	private $assign_enter_key = false;
	
	private $onclick = "";
	private $callback_onclick = "";
	private $is_clicked = false;
	/**#@-*/
	
	/**
	 * Constructor Button
	 * @param mixed $page_or_form_object 
	 * @param string $name 
	 * @param string $id 
	 * @param string $value 
	 * @param double $width [default value: 0]
	 * @param boolean $is_link [default value: false]
	 * @param string $class 
	 */
	function __construct($page_or_form_object, $name='', $id='', $value='', $width=0, $is_link=false, $class='') {
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
		$this->is_link = $is_link;
		$this->class = $class;
		$this->ajax_wait_message = __(SUBMIT_LOADING);
		
		$this->page_object->addEventObject($this, $this->form_object);
	}
	
	/**
	 * Method setValue
	 * @access public
	 * @param mixed $value 
	 * @return Button
	 * @since 1.0.36
	 */
	public function setValue($value) {
		$this->value = $value;
		if (!$GLOBALS['__LOAD_VARIABLES__']) { 
			if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		} else {
			$this->is_clicked = true; 
		}
		return $this;
	}

	/**
	 * Method setDefaultValue
	 * @access public
	 * @param mixed $value 
	 * @return Button
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
	 * @return Button
	 * @since 1.0.36
	 */
	public function setWidth($width) {
		$this->width = $width;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setIsLink
	 * @access public
	 * @param boolean $is_link [default value: true]
	 * @return Button
	 * @since 1.0.36
	 */
	public function setIsLink($is_link=true) {
		$this->is_link = $is_link;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setClass
	 * @access public
	 * @param mixed $class 
	 * @return Button
	 * @since 1.0.36
	 */
	public function setClass($class) {
		$this->class = $class;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setName
	 * @access public
	 * @param mixed $name 
	 * @return Button
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
	 * Method assignEnterKey
	 * @access public
	 * @return Button
	 * @since 1.0.36
	 */
	public function assignEnterKey() {
		if ($this->form_object == null) {
			throw new NewException("You can't assign enter key to Button not in a Form", 0, 8, __FILE__, __LINE__);
		}
		$this->assign_enter_key = true;
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
	 * Method getOnClickJs
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function getOnClickJs() {
		return $this->onclick;
	}
	
	/**
	 * Method onClick
	 * @access public
	 * @param mixed $str_function 
	 * @param mixed $arg1 [default value: null]
	 * @param mixed $arg2 [default value: null]
	 * @param mixed $arg3 [default value: null]
	 * @param mixed $arg4 [default value: null]
	 * @param mixed $arg5 [default value: null]
	 * @return Button
	 * @since 1.0.36
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
	 * @param mixed $js_function 
	 * @return Button
	 * @since 1.0.36
	 */
	public function onClickJs($js_function) {
		$this->onclick = trim($js_function);
		return $this;
	}
	
	/**
	 * Method isClicked
	 * @access public
	 * @return mixed
	 * @since 1.0.36
	 */
	public function isClicked() {
		if (!$this->is_clicked) {
			$this->page_object->getUserEventObject();
		}
		return $this->is_clicked;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Button
	 * @since 1.0.36
	 */
	public function render($ajax_render=false) {
		$this->automaticAjaxEvent();
		
		$html = "";
		if ($this->class_name != "") {
			if ($this->value == "") { $this->value = "&nbsp;"; }
			
			if (!$ajax_render) {
				$html .= "<div id=\"wsp_button_".$this->name."\"";
				if (!$this->is_link && $this->class == '') { // round button
					if ($this->width > 0) {
						$html .= "style=\"width:".($this->width + 2)."px;height:30px;\"";
					}
				} else if ($this->width > 0) {
					$html .= "style=\"width:".$this->width."px;height:24px;\"";
				}
				$html .= ">\n";
			}
			if ($this->callback_onclick != "") {
				$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
			}
			if ($this->is_ajax_event && !$ajax_render) {
				if ($this->form_object == null) {
					throw new NewException("Unable to activate action to this ".get_class($this)." : Attribut page_or_form_object must be a Form object", 0, 8, __FILE__, __LINE__);
				}
				
				$html .= $this->getJavascriptTagOpen();
				$html .= $this->getAjaxEventFunctionRender();
				$html .= $this->getJavascriptTagClose();
			}
			
			// Create Button
			if (!$this->is_link && $this->class != '') {
				$html .= "<input type='button' name='".$this->getEventObjectName()."' id='".$this->id."' value='".$this->value."'";
				if ($this->width > 0) {
					$html .= " style='width:".$this->width."px;'";
				}
				$html .= " onClick=\"".str_replace("\n", "", $this->getObjectEventValidationRender($this->onclick, $this->callback_onclick));
				if ($this->is_ajax_event) {
					$html .= "return false;";
				}
				$html .= "\"";
				if ($this->class != "") {
					$html .= " class='".$this->class."'";
				}
				$html .= "/>\n";
			} else {	// Link or round button
				if (!$this->is_link) { // round button
					if ($this->id == "") {
						throw new NewException("You must specified an id for a Button", 0, 8, __FILE__, __LINE__);
					}
					$html .= "<button ";
				} else {
					$html .= "<a ";
					$html .= "href=\"javascript:void(0);\" onClick=\"".str_replace("\n", "", $this->getObjectEventValidationRender($this->onclick, $this->callback_onclick));
					if ($this->is_ajax_event) {
						$html .= "return false;";
					}
					$html .= "\"";
					if ($this->class != "") {
						$html .= " class=\"".$this->class."\"";
					}
				}
				if ($this->id != "") {
					$html .= " id=\"".$this->id."\"";
				}
				$html .= ">";
				$html .= $this->value;
				if (!$this->is_link) { // round button
					$html .= "</button>\n";
					
					$html .= $this->getJavascriptTagOpen();
					$html .= "	\$(\"#".$this->getId()."\").button().click(function() { ".str_replace("\n", "", $this->getObjectEventValidationRender($this->onclick, $this->callback_onclick));
					if ($this->is_ajax_event) {
						$html .= " return false;";
					}
					$html .= " });\n";
					if ($this->assign_enter_key) {
						$html .= "	\$(\"#".$this->form_object->getId()."\").bind(\"keydown\", function(e) { if (e.keyCode == 13) { \$(\"#".$this->getId()."\").click(); return false; } });\n";
					}
					if ($this->width > 0) {
						$html .= "	\$(\"#".$this->getId()."\").css('width', '".$this->width."px');\n";
					}
					$html .= $this->getJavascriptTagClose();
				} else {
					$html .= "</a>\n";
				}
			}
			if (!$ajax_render) {
				$html .= "</div>\n";
			}
		}
		$this->object_change = false;
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object Button (call with AJAX)
	 * @since 1.0.36
	 */
	public function getAjaxRender() {
		$this->automaticAjaxEvent();
		
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			if ($this->is_ajax_event) {
				new JavaScript($this->getAjaxEventFunctionRender(), true);
			}
			$html .= "$('#wsp_button_".$this->id."').html(\"".str_replace('"', '\"', str_replace("\n", "", str_replace("\r", "", $this->render(true))))."\");\n";
		}
		return $html;
	}
	
}
?>
