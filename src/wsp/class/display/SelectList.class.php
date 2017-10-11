<?php
/**
 * PHP file wsp\class\display\SelectList.class.php
 * @package display
 */
/**
 * Class SelectList
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
 * @copyright   WebSite-PHP.com 20/07/2016
 * @version     1.2.15
 * @access      public
 * @since       1.2.11
 */

class SelectList extends WebSitePhpEventObject {
	/**#@+
	* @access private
	*/
	private $width = "";
	private $nb_lines = "";
	protected $item_value = array();
	protected $item_text = array();
	protected $item_selected = -1;
	protected $item_default_selected = -1;
	private $option = "";
	private $disable = false;
	private $strip_tags = false;
	private $strip_tags_allowable = "";
	
	protected $list_items_change = false;
	protected $is_changed = false;
	protected $item_loaded = false;
	
	protected $style = "";
	
	private $onchange = "";
	private $callback_onchange = "";
	/**#@-*/

	/**
	 * Constructor SelectList
	 * @param mixed $page_or_form_object 
	 * @param string $name 
	 * @param string $nb_lines 
	 * @param string $width 
	 */
	function __construct($page_or_form_object, $name='', $nb_lines='', $width='') {
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
		$this->width = $width;
		$this->nb_lines = $nb_lines;
	}
	
	/**
	 * Method setValue
	 * @access public
	 * @param mixed $value 
	 * @return SelectList
	 * @since 1.2.11
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
	 * @param mixed $value 
	 * @return SelectList
	 * @since 1.2.11
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
	 * @return SelectList
	 * @since 1.2.11
	 */
	public function setWidth($width) {
		$this->width = $width;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setNbLines
	 * @access public
	 * @param mixed $nb_lines 
	 * @return SelectList
	 * @since 1.2.11
	 */
	public function setNbLines($nb_lines) {
		$this->nb_lines = $nb_lines;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setName
	 * @access public
	 * @param mixed $name 
	 * @return SelectList
	 * @since 1.2.11
	 */
	public function setName($name) {
		$this->name = $name;
		$this->page_object->addEventObject($this, $this->form_object);
		
		$this->initSubmitValue();
		return $this;
	}
	
	/**
	 * Method setStyle
	 * @access public
	 * @param mixed $style 
	 * @return SelectList
	 * @since 1.2.15
	 */
	public function setStyle($style) {
		$this->style = $style;
		return $this;
	}
	
	/**
	 * Method addItem
	 * @access public
	 * @param mixed $value 
	 * @param mixed $text 
	 * @param boolean $selected [default value: false]
	 * @return SelectList
	 * @since 1.2.11
	 */
	public function addItem($value, $text, $selected=false) {
		$this->item_value[] = html_entity_decode($value);
		
		if ($this->strip_tags) {
			$text = strip_tags($text, $this->strip_tags_allowable);
		}
		if ($text == "") {
			$text = "&nbsp;";
		}
		
		$ind = 1;
		$orig_text = $text;
		while (array_search($text, $this->item_text) !== false) {
			$text = $orig_text." (".$ind.")";
			$ind++;
		}
		$this->item_text[] = $text;
		
		if ($selected) {
			$this->setSelectedIndex(sizeof($this->item_value)-1);
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; $this->list_items_change = true; }
		return $this;
	}
	
	/**
	 * Method removeItem
	 * @access public
	 * @param mixed $value 
	 * @return SelectList
	 * @since 1.2.11
	 */
	public function removeItem($value) {
		if (($pos = array_search($value, $this->item_value)) !== false) {
			unset($this->item_value[$pos]);
			unset($this->item_text[$pos]);
			
			$this->item_value = array_values($this->item_value);
			$this->item_text = array_values($this->item_text);
			
			if ($this->item_selected > sizeof($this->item_value)) {
				$this->setSelectedIndex(sizeof($this->item_value)-1);
			}
			if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; $this->list_items_change = true; }
		}
		return $this;
	}
	
	/**
	 * Method removeItems
	 * @access public
	 * @return SelectList
	 * @since 1.2.11
	 */
	public function removeItems() {
		$this->item_value = array();
		$this->item_text = array();
		$this->setSelectedIndex(-1);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; $this->list_items_change = true; }
		return $this;
	}
	
	/**
	 * Method setSelectedIndex
	 * @access public
	 * @param mixed $index 
	 * @return SelectList
	 * @since 1.2.11
	 */
	public function setSelectedIndex($index) {
		if (sizeof($this->item_value) > 0) { // init selected index with submit value if not already do 
			$this->initSubmitValue();
		}
		if (isset($this->item_value[$index]) || $index == -1) {
			$this->item_selected = $index;
			$this->item_loaded = true;
			if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		}
		return $this;
	}
	
	/**
	 * Method setStripTags
	 * @access public
	 * @param string $allowable_tags 
	 * @return SelectList
	 * @since 1.2.11
	 */
	public function setStripTags($allowable_tags='') {
		$this->strip_tags = true;
		$this->strip_tags_allowable = $allowable_tags;
		return $this;
	}

	/**
	 * Method getValue
	 * @access public
	 * @return mixed
	 * @since 1.2.11
	 */
	public function getValue() {
		if (sizeof($this->item_value) > 0) { // init selected index with submit value if not already do
			$this->initSubmitValue();
		}
		if (!$this->item_loaded) { // get the value when SelectList not init whith items
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
				
				if ($this->strip_tags) {
					return strip_tags($value, $this->strip_tags_allowable);
				} else {
					return $value;
				}
			} 
		} 
		return (isset($this->item_value[$this->item_selected])?$this->item_value[$this->item_selected]:"");
	}
	
	/**
	 * Method getSelectedIndex
	 * @access public
	 * @return mixed
	 * @since 1.2.11
	 */
	public function getSelectedIndex() {
		if (sizeof($this->item_value) > 0) { $this->initSubmitValue(); } // init selected index with submit value if not already do
		return $this->item_selected;
	}

	/**
	 * Method getDefaultValue
	 * @access public
	 * @return mixed
	 * @since 1.2.11
	 */
	public function getDefaultValue() {
		return $this->item_value[$this->item_default_selected];
	}

	/**
	 * Method getId
	 * @access public
	 * @return mixed
	 * @since 1.2.11
	 */
	public function getId() {
		return $this->getEventObjectName();
	}

	/**
	 * Method getText
	 * @access public
	 * @return mixed
	 * @since 1.2.11
	 */
	public function getText() {
		if (sizeof($this->item_value) > 0) { $this->initSubmitValue(); } // init selected index with submit value if not already do
		return $this->item_text[$this->item_selected];
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
	 * @return SelectList
	 * @since 1.2.11
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
	 * @param mixed $js_function 
	 * @return SelectList
	 * @since 1.2.11
	 */
	public function onChangeJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onChangeJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->onchange = trim($js_function);
		return $this;
	}
	
	/**
	 * Method isChanged
	 * @access public
	 * @return mixed
	 * @since 1.2.11
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
	 * @access public
	 * @return SelectList
	 * @since 1.2.11
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
	 * @since 1.2.11
	 */
	public function length() {
		return sizeof($this->item_value);
	}

	/**
	 * Method getItemTextAt
	 * @access public
	 * @param mixed $i 
	 * @return mixed
	 * @since 1.2.11
	 */
	public function getItemTextAt($i) {
		return $this->item_text[$i];
	}
	
	/**
	 * Method getItemValueAt
	 * @access public
	 * @param mixed $i 
	 * @return mixed
	 * @since 1.2.11
	 */
	public function getItemValueAt($i) {
		return $this->item_value[$i];
	}
	
	/**
	 * Method enable
	 * @access public
	 * @return SelectList
	 * @since 1.2.11
	 */
	public function enable() {
		$this->disable = false;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method disable
	 * @access public
	 * @return SelectList
	 * @since 1.2.11
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
	 * @return string html code of object SelectList
	 * @since 1.2.11
	 */
	public function render($ajax_render=false) {
		$this->automaticAjaxEvent();
		
		$html = "<select id=\"".$this->getEventObjectName()."\" name=\"".$this->getEventObjectName();
		if (get_class($this) == "SelectListMultiple") {
			$html .= "[]";
		}
		$html .= "\" onChange=\"onChangeSelectList_".$this->getEventObjectName()."();\"";
		if ($this->disable) {
			$html .= " disabled";
		}
		if (get_class($this) == "SelectListMultiple") {
			$html .= " multiple";
		}
		if ($this->width != "" || $this->style != "") {
			$html .= " style=\"";
			if ($this->width != "" && $this->width > 0) {
				$html .= "width:".$this->width."px;";
			}
			if ($this->style != "") {
				$html .= $this->style;
			}
			$html .= "\"";
		}
		if ($this->nb_lines != "" && is_numeric($this->nb_lines)) {
			$html .= " size=\"".$this->nb_lines."\"";
		}
		$html .= ">\n";
		for ($i=0; $i < sizeof($this->item_value); $i++) {
			$html .= "	<option value=\"".$this->item_value[$i]."\"";
			$is_selected = false;
			if (is_array($this->item_selected)) {
				if (in_array($i, $this->item_selected)) {
					$is_selected = true;
				}
			} else {
				if ($i == $this->item_selected) {
					$is_selected = true;
				}
			}
			if ($is_selected) {
					$html .= " selected=\"selected\"";
			}
			$html .= ">".$this->item_text[$i]."</option>\n";
		}
		$html .= "</select>\n";
		
		if ($this->callback_onchange != "") {
			$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
		}
		$html .= "<input type='hidden' id='SelList_SelectedIndex_".$this->getEventObjectName()."' name='SelList_SelectedIndex_".$this->getEventObjectName()."' value='".$this->getSelectedIndex()."'/>\n";
		
		$html .= $this->getJavascriptTagOpen();
		if ($this->is_ajax_event) {
			$html .= $this->getAjaxEventFunctionRender();
		}
		
		$html .= $this->htmlOnChangeFct();
		$html .= $this->getJavascriptTagClose();
		$this->object_change = false;
		
		return $html;
	}
	
	/**
	 * Method htmlOnChangeFct
	 * @access private
	 * @return mixed
	 * @since 1.2.11
	 */
	private function htmlOnChangeFct() {
		$html = "";
		$html .= "	onChangeSelectList_".$this->getEventObjectName()." = function() {\n";
		$html .= "		setTimeout(\"onChangeSelectList_".$this->getEventObjectName()."Fct();\", 1);\n";
		$html .= "	};\n";
		$html .= "	onChangeSelectList_".$this->getEventObjectName()."Fct = function() {\n";
		$html .= "		if ($('#SelList_SelectedIndex_".$this->getEventObjectName()."').val() != document.getElementById('".$this->getEventObjectName()."').selectedIndex) {\n";
		if ($this->callback_onchange != "") {
			$html .= $this->getObjectEventValidationRender($this->onchange, $this->callback_onchange);
		} else if ($this->onchange != "") {
			$html .= $this->onchange;
		}
		$html .= "		}\n";
		$html .= "		$('#SelList_SelectedIndex_".$this->getEventObjectName()."').val(document.getElementById('".$this->getEventObjectName()."').selectedIndex);\n";
		$html .= "	};\n";
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object SelectList (call with AJAX)
	 * @since 1.2.11
	 */
	public function getAjaxRender() {
		$this->automaticAjaxEvent();
		
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			$html .= "$('#SelList_SelectedIndex_".$this->getEventObjectName()."').val('".$this->getSelectedIndex()."');\n";
			$html .= $this->htmlOnChangeFct();
			
			$refresh_selected_index = false;
			if ($this->list_items_change) {
				$html .= "document.getElementById('".$this->getEventObjectName()."').options.length=0;\n";
				
				$html .= "var sellist_parent_node = document.getElementById('".$this->getEventObjectName()."');\n";
				for ($i=0; $i < sizeof($this->item_value); $i++) {
					$html .= "var new_option = document.createElement('option');\n";
					$html .= "new_option.value = '".addslashes($this->item_value[$i])."';\n";
					$html .= "new_option.appendChild(document.createTextNode('".addslashes($this->item_text[$i])."'));\n";
					$html .= "new_option.title = '".addslashes($this->item_img[$i])."';\n";
					if (is_array($this->item_selected)) {
						if (in_array($i, $this->item_selected)) {
							$refresh_selected_index = true;
						}
					} else {
						if ($i == $this->item_selected) {
							$refresh_selected_index = true;
						}
					}
					$html .= "sellist_parent_node.appendChild(new_option);\n";
				}
			} else if ($this->is_changed) {
				$refresh_selected_index = true;
			}
			if ($refresh_selected_index) {
				if (is_array($this->item_selected)) {
					$sel_values = "";
					for ($i=0; $i < sizeof($this->item_selected); $i++) {
						if ($sel_values != "") { $sel_values .= ","; }
						$sel_values .= "\"".$this->getItemValueAt($this->item_selected[$i])."\"";
					}
					$html .= "$(\"#".$this->getEventObjectName()."\").val([".$sel_values."]);\n";
				} else {
					$html .= "$(\"#".$this->getEventObjectName()."\").prop('selectedIndex', ".$this->item_selected.");\n";
				}
			}
		}
		return $html;
	}
}
?>
