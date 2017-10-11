<?php
/**
 * PHP file wsp\class\display\Button.class.php
 * @package display
 */
/**
 * Class Button
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
 * @since       1.0.17
 */

class Button extends WebSitePhpEventObject {
	/**#@+
	* @access private
	*/
	private $value = "";
	private $default_value = "";
	private $width = 0;
	private $height = 0;
	private $class = "";
	protected $is_link = false;
	private $assign_enter_key = false;
	private $hide = false;
	private $force_span_tag = false;
	private $disable = false;
	private $tooltip = "";
	private $class_jquery_ui = "";
	private $disable_livevalidation = false;
	
	private $primary_icon = "";
	private $secondary_icon = "";
	
	private $onclick = "";
	private $callback_onclick = "";
	private $is_clicked = false;
	/**#@-*/
	
	/**
	 * Constructor Button
	 * @param Page|Form $page_or_form_object 
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
		$this->width = $width;
		$this->is_link = $is_link;
		$this->class = $class;
		$this->ajax_wait_message = __(SUBMIT_LOADING);
	}
	
	/**
	 * Method setValue
	 * @access public
	 * @param string $value 
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
	 * @param string $value 
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
	 * Method setHeight
	 * @access public
	 * @param integer $height 
	 * @return Button
	 * @since 1.2.1
	 */
	public function setHeight($height) {
		$this->height = $height;
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
	 * @param string $class 
	 * @return Button
	 * @since 1.0.36
	 */
	public function setClass($class) {
		$this->class = $class;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setClassJQueryUI
	 * @access public
	 * @param mixed $class 
	 * @return Button
	 * @since 1.2.15
	 */
	public function setClassJQueryUI($class) {
		$this->class_jquery_ui = $class;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setName
	 * @access public
	 * @param string $name 
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
	 * Method setTooltip
	 * @access public
	 * @param mixed $tooltip 
	 * @return Button
	 * @since 1.2.10
	 */
	public function setTooltip($tooltip) {
		$this->tooltip = $tooltip;
		return $this;
	}
	
	/**
	 * Method setPrimaryIcon
	 * @access public
	 * @param mixed $icon_16px 
	 * @return Button
	 * @since 1.0.96
	 */
	public function setPrimaryIcon($icon_16px) {
		if (strtoupper(substr($icon_16px, 0, 7)) != "HTTP://" || strtoupper(substr($icon_16px, 0, 8)) != "HTTPS://") {
			$icon_16px = $this->getPage()->getCDNServerURL().$icon_16px;
		}
		$this->primary_icon = $icon_16px;
		return $this;
	}
	
	/**
	 * Method setSecondaryIcon
	 * @access public
	 * @param mixed $icon_16px 
	 * @return Button
	 * @since 1.0.96
	 */
	public function setSecondaryIcon($icon_16px) {
		if (strtoupper(substr($icon_16px, 0, 7)) != "HTTP://" || strtoupper(substr($icon_16px, 0, 8)) != "HTTPS://") {
			$icon_16px = $this->getPage()->getBaseURL().$icon_16px;
		}
		$this->secondary_icon = $icon_16px;
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
			throw new NewException("You can't assign enter key to Button not in a Form", 0, getDebugBacktrace(1));
		}
		$this->assign_enter_key = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method disableLiveValidation
	 * @access public
	 * @return Button
	 * @since 1.2.15
	 */
	public function disableLiveValidation() {
		$this->disable_livevalidation = true;
		return $this;
	}
	
	/**
	 * Method getDisableLiveValidation
	 * @access public
	 * @return mixed
	 * @since 1.2.15
	 */
	public function getDisableLiveValidation() {
		return $this->disable_livevalidation;
	}

	/**
	 * Method getValue
	 * @access public
	 * @return string
	 * @since 1.0.36
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * Method getDefaultValue
	 * @access public
	 * @return string
	 * @since 1.0.36
	 */
	public function getDefaultValue() {
		return $this->default_value;
	}
	
	/**
	 * Method getOnClickJs
	 * @access public
	 * @return string
	 * @since 1.0.36
	 */
	public function getOnClickJs() {
		return $this->onclick;
	}
	
	/**
	 * Method onClick
	 * @access public
	 * @param string $str_function 
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
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method onClickJs
	 * @access public
	 * @param string|JavaScript $js_function 
	 * @return Button
	 * @since 1.0.36
	 */
	public function onClickJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onClickJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onclick = trim($js_function);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method isClicked
	 * @access public
	 * @return boolean
	 * @since 1.0.36
	 */
	public function isClicked() {
		if ($this->callback_onclick == "") {
			throw new NewException(get_class($this)."->isClicked(): this method can be used only if an onClick event is defined on this ".get_class($this).".", 0, getDebugBacktrace(1));
		}
		if (!$this->is_clicked) {
			if ($this->form_object == null) {
				if (isset($_POST["Callback_".$this->getEventObjectName()]) && $_POST["Callback_".$this->getEventObjectName()] != "") {
					$this->is_clicked = true;
				} else if (isset($_GET["Callback_".$this->getEventObjectName()]) && $_GET["Callback_".$this->getEventObjectName()] != "") {
					$this->is_clicked = true;
				}
			} else {
				if ($this->form_object->getMethod() == "POST" && isset($_POST["Callback_".$this->getEventObjectName()]) && $_POST["Callback_".$this->getEventObjectName()] != "") {
					$this->is_clicked = true;
				} else if (isset($_GET["Callback_".$this->getEventObjectName()]) && $_GET["Callback_".$this->getEventObjectName()] != "") {
					$this->is_clicked = true;
				}
			}
		}
		return $this->is_clicked;
	}

	/**
	 * Method hide
	 * @access public
	 * @return Button
	 * @since 1.0.85
	 */
	public function hide() {
		$this->hide = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method show
	 * @access public
	 * @return Button
	 * @since 1.0.85
	 */
	public function show() {
		$this->hide = false;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method forceSpanTag
	 * @access public
	 * @return Button
	 * @since 1.2.1
	 */
	public function forceSpanTag() {
		$this->force_span_tag = true;
	
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method enable
	 * @access public
	 * @return Button
	 * @since 1.2.3
	 */
	public function enable() {
		$this->disable = false;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method disable
	 * @access public
	 * @return Button
	 * @since 1.2.3
	 */
	public function disable() {
		$this->disable = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
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
				$html .= "<".($this->force_span_tag?"span":"div")." id=\"wsp_button_".$this->name."\"";
				if (!$this->is_link && $this->class == '') { // round button
					if ($this->width > 0 || $this->height > 0) {
						$html .= "style=\"";
						if ($this->width > 0) {
							$html .= "width:".($this->width + 2)."px;";
						}
						if ($this->height > 0) {
							$html .= "height:".$this->height."px;";
						}
						$html .= "\";";
					}
				} else if ($this->width > 0 || $this->height > 0) {
					$html .= "style=\"";
					if ($this->width > 0) {
						$html .= "width:".$this->width."px;";
					}
					if ($this->height > 0) {
						$html .= "height:".$this->height."px;";
					}
					$html .= "\";";
				}
				$html .= ">\n";
				if ($this->hide) {
					$html .= "</".($this->force_span_tag?"span":"div").">";
					return $html;
				}
			} else if ($this->hide) { return ""; }
			
			if ($this->callback_onclick != "") {
				$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
			}
			if ($this->is_ajax_event && !$ajax_render) {
				$html .= $this->getJavascriptTagOpen();
				$html .= $this->getAjaxEventFunctionRender();
				$html .= $this->getJavascriptTagClose();
			}
			
			// Create Button
			$is_jquery_button = false;
			if (!$this->is_link && $this->class != '') {
				$html .= "<input type='button' name='".$this->getEventObjectName()."' id='".$this->id."' value=\"".str_replace('"', '\\"', $this->value)."\"";
				if ($this->width > 0) {
					$html .= " style='width:".$this->width."px;'";
				}
				if ($this->height > 0) {
					$html .= " style='height:".$this->height."px;'";
				}
				if ($this->disable) {
					$html .= " disabled";
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
						throw new NewException("You must specified an id for a Button", 0, getDebugBacktrace(1));
					}
					
					if ($this->primary_icon != "" || $this->secondary_icon != "") {
						$html .= "<style type=\"text/css\" media=\"screen\">";
						if ($this->primary_icon != "") {
							$html .= " #".$this->id." .ui-button-icon-primary { background-image: url(".$this->primary_icon."); } ";
						}
						if ($this->secondary_icon != "") {
							$html .= " #".$this->id." .ui-button-icon-secondary { background-image: url(".$this->secondary_icon."); } ";
						}
						$html .= "</style>\n";
					}
					
					$html .= "<button";
					if ($this->id != "") {
						$html .= " id=\"".$this->id."\"";
					}
					if ($this->disable) {
						$html .= " disabled";
					}
					if ($this->tooltip != "") {
						$html .= " title=\"".$this->tooltip."\"";
					}
					if ($this->class_jquery_ui != "") {
						$html .= " class=\"".$this->class_jquery_ui."\"";
					}
					$html .= ">";
					$is_jquery_button = true;
				} else {
					$html .= "<a ";
					$html .= "href=\"javascript:void(0);\"";
					if (!$this->disable) {
						$html .= " onClick=\"";
						$html .= str_replace("\n", "", $this->getObjectEventValidationRender($this->onclick, $this->callback_onclick));
						if ($this->is_ajax_event) {
							$html .= "return false;";
						}
						$html .= "\"";
					} else {
						$html .= " style=\"cursor:not-allowed;\"";
					}
					if ($this->class != "") {
						$html .= " class=\"".$this->class."\"";
					}
					if ($this->id != "") {
						$html .= " id=\"".$this->id."\"";
					}
					$html .= ">";
				}
				if (gettype($this->value) == "object" && method_exists($this->value, "render")) {
					$html .= $this->value->render();
				} else {
					$html .= $this->value;
				}
				if (!$this->is_link) { // round button
					$html .= "</button>\n";
					
					$html .= $this->getJavascriptTagOpen();
					$html .= "	\$(\"#".$this->getId()."\").button({";
					if ($is_jquery_button && ($this->primary_icon != "" || $this->secondary_icon != "")) {
						$html .= "icons: {";
						if ($this->primary_icon != "") {
				        	$html .= " primary: 'ui-button-icon-primary'";
				        }
						if ($this->secondary_icon != "") {
							if ($this->primary_icon != "") { $html .= ", "; }
				        	$html .= " secondary: 'ui-button-icon-secondary'";
				        }
				        $html .= " }";
				        if ($this->value == "" || $this->value == "&nbsp;") {
				        	$html .= ", text: false";
				        }
					}
					$html .= "}).click(function() { ".str_replace("\n", "", $this->getObjectEventValidationRender($this->onclick, $this->callback_onclick));
					if ($this->is_ajax_event) {
						$html .= " return false;";
					}
					$html .= " });\n";
					$html .= $this->getJavascriptTagClose();
				} else {
					$html .= "</a>\n";
				}
			}
			
			if (!$is_jquery_button && ($this->primary_icon != "" || $this->secondary_icon != "")) {
				throw new NewException("You can't use primary or secondary icon if you used the method setClass in the button ".$this->id.".", 0, getDebugBacktrace(1));
			}
			
			if ($this->assign_enter_key || $this->width > 0 || $this->height > 0) {
				$html .= $this->getJavascriptTagOpen();
				if ($this->assign_enter_key) {
					$html .= "	\$(\"#".$this->form_object->getId()."\").bind(\"keydown\", function(e) { if (e.keyCode == 13) { \$(\"#".$this->getId()."\").click(); return false; } });\n";
				}
				if ($this->width > 0) {
					$html .= "	\$(\"#".$this->getId()."\").css('width', '".$this->width."px');\n";
				}
				if ($this->height > 0) {
					$html .= "	\$(\"#".$this->getId()."\").css('height', '".$this->height."px');\n";
				}
				$html .= $this->getJavascriptTagClose();
			}
			if (!$ajax_render) {
				$html .= "</".($this->force_span_tag?"span":"div").">\n";
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
			// Extract JavaScript from HTML
			$array_ajax_render = extract_javascript($this->render(true));
			for ($i=1; $i < sizeof($array_ajax_render); $i++) {
				new JavaScript($array_ajax_render[$i], true);
			}
			$html .= "$('#wsp_button_".$this->id."').html(\"".str_replace("\n", "", str_replace("\r", "", addslashes($array_ajax_render[0])))."\");\n";
		}
		return $html;
	}
	
}
?>
