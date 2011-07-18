<?php
/**
 * PHP file wsp\class\display\ComboBox.class.php
 * @package display
 */
/**
 * Class ComboBox
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
 * @version     1.0.89
 * @access      public
 * @since       1.0.17
 */

class ComboBox extends WebSitePhpEventObject {
	/**#@+
	* @access private
	*/
	private $width = "";
	private $is_image = false;
	private $item_value = array();
	private $item_text = array();
	private $item_img = array();
	private $item_group_name = array();
	private $item_selected = -1;
	private $item_default_selected = -1;
	private $option = "";
	private $disable = false;
	
	private $list_items_change = false;
	private $is_changed = false;
	private $item_loaded = false;
	
	private $onchange = "";
	private $callback_onchange = "";
	/**#@-*/

	/**
	 * Constructor ComboBox
	 * @param Page|Form $page_or_form_object 
	 * @param string $name 
	 * @param string $width 
	 */
	function __construct($page_or_form_object, $name='', $width='') {
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
			$this->page_object->addEventObject($this, $this->form_object);
		}
		
		$this->name = $name;
		$this->width = $width;
		
		$this->addCss(BASE_URL."wsp/css/dd.css", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/jquery.dd.js", "", true);
	}
	
	/**
	 * Method setValue
	 * @access public
	 * @param string $value 
	 * @return ComboBox
	 * @since 1.0.36
	 */
	public function setValue($value) {
		$find_item = false;
		for ($i=0; $i < sizeof($this->item_value); $i++) {
			if ($this->item_value[$i] == $value) {
				$this->setSelectedIndex($i);
				$this->item_loaded = true;
				$find_item = true;
				break;
			}
		}
		if ($find_item) {
			if (!$GLOBALS['__LOAD_VARIABLES__']) { 
				if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
			}
		}
		$this->is_changed = true; 
		
		return $this;
	}

	/**
	 * Method setDefaultValue
	 * @access public
	 * @param string $value 
	 * @return ComboBox
	 * @since 1.0.36
	 */
	public function setDefaultValue($value) {
		$find_item = false;
		for ($i=0; $i < sizeof($this->item_value); $i++) {
			if ($this->item_value[$i] == $value) {
				$this->item_default_selected = $i;
				$find_item = true;
				break;
			}
		}
		if ($find_item) {
			if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		}
		return $this;
	}
	
	/**
	 * Method setWidth
	 * @access public
	 * @param integer $width 
	 * @return ComboBox
	 * @since 1.0.36
	 */
	public function setWidth($width) {
		$this->width = $width;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setName
	 * @access public
	 * @param string $name 
	 * @return ComboBox
	 * @since 1.0.36
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	
	/**
	 * Method setOption
	 * set jquery msDropDown options
	 * @access public
	 * @param string $option 
	 * @return ComboBox
	 * @since 1.0.36
	 */
	public function setOption($option) {
		$this->option = $option;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method addItem
	 * @access public
	 * @param string $value 
	 * @param string $text 
	 * @param boolean $selected [default value: false]
	 * @param string $img 
	 * @param string $group_name 
	 * @return ComboBox
	 * @since 1.0.36
	 */
	public function addItem($value, $text, $selected=false, $img='', $group_name='') {
		$this->item_value[] = html_entity_decode($value);
		$this->item_text[] = $text;
		if ($img != "" && strtoupper(substr($img, 0, 7)) != "HTTP://") {
			$this->item_img[] = BASE_URL.$img;
		} else {
			$this->item_img[] = $img;
		}
		$this->item_group_name[] = $group_name;
		if ($img != "") {
			$this->is_image = true;
		}
		if ($selected) {
			$this->setSelectedIndex(sizeof($this->item_value)-1);
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; $this->list_items_change = true; }
		return $this;
	}
	
	/**
	 * Method removeItems
	 * @access public
	 * @return ComboBox
	 * @since 1.0.36
	 */
	public function removeItems() {
		$this->item_value = array();
		$this->item_text = array();
		$this->item_img = array();
		$this->is_image = false;
		$this->setSelectedIndex(-1);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; $this->list_items_change = true; }
		return $this;
	}
	
	/**
	 * Method setSelectedIndex
	 * @access public
	 * @param integer $index 
	 * @return ComboBox
	 * @since 1.0.36
	 */
	public function setSelectedIndex($index) {
		if (sizeof($this->item_value) > 0) { // init selected index with submit value if not already do 
			$this->initSubmitValue();
		}
		if (isset($this->item_value[$index])) {
			$this->item_selected = $index;
			if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		}
		return $this;
	}

	/**
	 * Method getValue
	 * @access public
	 * @return string
	 * @since 1.0.36
	 */
	public function getValue() {
		if (sizeof($this->item_value) > 0) { // init selected index with submit value if not already do
			$this->initSubmitValue();
		}
		if (!$this->item_loaded) { // get the value when combobox not init whith items
			$class_name = get_class($this->page_object);
			$form_name = "";
			if ($this->form_object != null) {
				$form_name = $this->form_object->getName();
			}
			if ($form_name == "") {
				$name = $class_name."_".$this->getName();
				if (isset($_POST[$name])) {
					$value = $_POST[$name];
				} else {
					$value = $_GET[$name];
				}
			} else {
				$name = $class_name."_".$form_name."_".$this->getName();
				if ($this->form_object->getMethod() == "POST") {
					$value = $_POST[$name];
				} else {
					$value = $_GET[$name];
				}
			}
			if ($value != "") {
				$save_is_changed = $this->is_changed;
				$this->setValue($value);
				$this->is_changed = $save_is_changed;
				return $value;
			} 
		} 
		return (isset($this->item_value[$this->item_selected])?$this->item_value[$this->item_selected]:"");
	}
	
	/**
	 * Method getSelectedIndex
	 * @access public
	 * @return string
	 * @since 1.0.36
	 */
	public function getSelectedIndex() {
		if (sizeof($this->item_value) > 0) { $this->initSubmitValue(); } // init selected index with submit value if not already do
		return $this->item_selected;
	}

	/**
	 * Method getDefaultValue
	 * @access public
	 * @return string
	 * @since 1.0.36
	 */
	public function getDefaultValue() {
		return $this->item_value[$this->item_default_selected];
	}

	/**
	 * Method getId
	 * @access public
	 * @return string
	 * @since 1.0.36
	 */
	public function getId() {
		return $this->getEventObjectName();
	}

	/**
	 * Method getText
	 * @access public
	 * @return string
	 * @since 1.0.36
	 */
	public function getText() {
		if (sizeof($this->item_value) > 0) { $this->initSubmitValue(); } // init selected index with submit value if not already do
		return $this->item_text[$this->item_selected];
	}
	
	/**
	 * Method onChange
	 * @access public
	 * @param string $str_function 
	 * @param mixed $arg1 [default value: null]
	 * @param mixed $arg2 [default value: null]
	 * @param mixed $arg3 [default value: null]
	 * @param mixed $arg4 [default value: null]
	 * @param mixed $arg5 [default value: null]
	 * @return ComboBox
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
	 * @return ComboBox
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
	 * @return boolean
	 * @since 1.0.36
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
	 * Method setListItemsChange
	 * To be use only if your are sur ComboBox list items have been changed
	 * @access public
	 * @return ComboBox
	 * @since 1.0.36
	 */
	public function setListItemsChange() {
		$this->is_changed = true;
		$this->list_items_change = true;
		$this->object_change =true;
		return $this;
	}

	/**
	 * Method length
	 * @access public
	 * @return mixed
	 * @since 1.0.89
	 */
	public function length() {
		return sizeof($this->item_value);
	}

	/**
	 * Method getItemTextAt
	 * @access public
	 * @param mixed $i 
	 * @return mixed
	 * @since 1.0.89
	 */
	public function getItemTextAt($i) {
		return $this->item_text[$i];
	}
	
	/**
	 * Method getItemValueAt
	 * @access public
	 * @param mixed $i 
	 * @return mixed
	 * @since 1.0.89
	 */
	public function getItemValueAt($i) {
		return $this->item_value[$i];
	}
	
	/**
	 * Method enable
	 * @access public
	 * @return ComboBox
	 * @since 1.0.89
	 */
	public function enable() {
		$this->disable = false;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method disable
	 * @access public
	 * @return ComboBox
	 * @since 1.0.89
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
	 * @since 1.0.36
	 */
	public function render($ajax_render=false) {
		$this->automaticAjaxEvent();
		
		$html = "<select id=\"".$this->getEventObjectName()."\" name=\"".$this->getEventObjectName()."\" onChange=\"onChangeComboBox_".$this->getEventObjectName()."();\"";
		if ($this->width != "" && $this->width > 0) {
			$html .= " style=\"width:".($this->width + 4)."px;\"";
		}
		$html .= ">\n";
		$last_group_name = "";
		for ($i=0; $i < sizeof($this->item_value); $i++) {
			if ($this->item_group_name[$i] != $last_group_name) {
				if ($last_group_name != "") {
					$html .= "	</optgroup>\n";
				}
				if ($this->item_group_name[$i] != "") {
					$html .= "	<optgroup label=\"".$this->item_group_name[$i]."\">\n";
				}
				$last_group_name = $this->item_group_name[$i];
			}
			$html .= "	<option value=\"".$this->item_value[$i]."\"";
			if ($this->item_img[$i] != "") {
				$html .= " title=\"".$this->item_img[$i]."\"";
			}
			if ($i == $this->item_selected) {
				$html .= " selected=\"selected\"";
			}
			$html .= ">".$this->item_text[$i]."</option>\n";
		}
		if ($last_group_name != "") {
			$html .= "	</optgroup>\n";
		}
		$html .= "</select>\n";
		
		if ($this->callback_onchange != "") {
			$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
		}
		$html .= "<input type='hidden' id='Cmb_SelectedIndex_".$this->getEventObjectName()."' name='Cmb_SelectedIndex_".$this->getEventObjectName()."' value='".$this->getSelectedIndex()."'/>\n";
		
		$html .= $this->getJavascriptTagOpen();
		if ($this->is_ajax_event) {
			if ($this->form_object == null) {
				throw new NewException("Unable to activate action to this ".get_class($this)." : Attribut page_or_form_object must be a Form object", 0, 8, __FILE__, __LINE__);
			}
			$html .= $this->getAjaxEventFunctionRender();
		}
		
		$html .= "	$(document).ready(function(){ $(\"#".$this->getEventObjectName()."\").msDropDown({";
		$html .= $this->option."}); ";
		if ($this->disable) {
			$html .= "$(\"#".$this->getEventObjectName()."\").msDropDown().data('dd').disabled(true);";
		}
		$html .= "});\n";
		$html .= $this->htmlOnChangeFct();
		$html .= $this->getJavascriptTagClose();
		$this->object_change = false;
		
		return $html;
	}
	
	/**
	 * Method htmlOnChangeFct
	 * @access private
	 * @return string
	 * @since 1.0.36
	 */
	private function htmlOnChangeFct() {
		$html = "";
		$html .= "	onChangeComboBox_".$this->getEventObjectName()." = function() {\n";
		$html .= "		setTimeout(\"onChangeComboBox_".$this->getEventObjectName()."Fct();\", 1);\n";
		$html .= "	};\n";
		$html .= "	onChangeComboBox_".$this->getEventObjectName()."Fct = function() {\n";
		$html .= "		if ($('#Cmb_SelectedIndex_".$this->getEventObjectName()."').val() != document.getElementById('".$this->getEventObjectName()."').selectedIndex) {\n";
		if ($this->callback_onchange != "") {
			$html .= $this->getObjectEventValidationRender($this->onchange, $this->callback_onchange);
		} else if ($this->onchange != "") {
			$html .= $this->onchange;
		}
		$html .= "		}\n";
		$html .= "		$('#Cmb_SelectedIndex_".$this->getEventObjectName()."').val(document.getElementById('".$this->getEventObjectName()."').selectedIndex);\n";
		$html .= "	};\n";
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object ComboBox (call with AJAX)
	 * @since 1.0.36
	 */
	public function getAjaxRender() {
		$this->automaticAjaxEvent();
		
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			$html .= "$('#Cmb_SelectedIndex_".$this->getEventObjectName()."').val('".$this->getSelectedIndex()."');\n";
			$html .= $this->htmlOnChangeFct();
			
			if ($this->list_items_change) {
				$is_opt_group = false;
				for ($i=0; $i < sizeof($this->item_value); $i++) {
					if ($this->item_group_name[$i] != "") {
						$is_opt_group = true;
						break;
					}
				}
				if ($is_opt_group) {
					$html .= "while (document.getElementById('".$this->getEventObjectName()."').hasChildNodes()) {\n";
					$html .= "	document.getElementById('".$this->getEventObjectName()."').removeChild(document.getElementById('".$this->getEventObjectName()."').firstChild);\n";
					$html .= "}\n";
				} else {
					$html .= "document.getElementById('".$this->getEventObjectName()."').options.length=0;\n";
				}
				$last_group_name = "";
				$html .= "var cmb_parent_node = document.getElementById('".$this->getEventObjectName()."');\n";
				for ($i=0; $i < sizeof($this->item_value); $i++) {
					if ($this->item_group_name[$i] != $last_group_name) {
						if ($last_group_name != "") {
							$html .= "document.getElementById('".$this->getEventObjectName()."').appendChild(cmb_parent_node);\n";
						}
						if ($this->item_group_name[$i] != "") {
							$html .= "cmb_parent_node = document.createElement('optgroup');\n";
							$html .= "cmb_parent_node.label = '".addslashes($this->item_group_name[$i])."';\n";
						}
					}
					if ($this->item_group_name[$i] == "" && $last_group_name != "") {
						$html .= "cmb_parent_node = document.getElementById('".$this->getEventObjectName()."');\n";
					}
					$last_group_name = $this->item_group_name[$i];
					
					$html .= "var new_option = document.createElement('option');\n";
					$html .= "new_option.value = '".addslashes($this->item_value[$i])."';\n";
					$html .= "new_option.appendChild(document.createTextNode('".addslashes($this->item_text[$i])."'));\n";
					$html .= "new_option.title = '".addslashes($this->item_img[$i])."';\n";
					if ($i == $this->item_selected) {
						$html .= "new_option.selected = true;\n";
					}
					$html .= "cmb_parent_node.appendChild(new_option);\n";
				}
				if ($last_group_name != "") {
					$html .= "document.getElementById('".$this->getEventObjectName()."').appendChild(cmb_parent_node);\n";
				}
				$html .= "if(document.getElementById('".$this->getEventObjectName()."').refresh!=undefined) {\n";
				$html .= "	document.getElementById('".$this->getEventObjectName()."').refresh();\n";
				$html .= "}\n";
						
			} else if ($this->is_changed) {
				$html .= "document.getElementById('".$this->getEventObjectName()."').options[".$this->item_selected."].selected = true;\n";
			}
			$html .= "$(\"#".$this->getEventObjectName()."\").msDropDown().data('dd').disabled(".($this->disable?"true":"false").");";
		}
		return $html;
	}
	
}
?>
