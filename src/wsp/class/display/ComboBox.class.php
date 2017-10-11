<?php
/**
 * PHP file wsp\class\display\ComboBox.class.php
 * @package display
 */
/**
 * Class ComboBox
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
	private $strip_tags = false;
	private $strip_tags_allowable = "";
	private $auto_increment_same_text = true;
	private $tabindex = -1;
	private $specific_option_attributes = array();
	
	private $list_items_change = false;
	private $is_changed = false;
	private $item_loaded = false;
	
	private $onchange = "";
	private $callback_onchange = "";
	
	protected $live_validation = null;
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
		$this->page_object->addEventObject($this, $this->form_object);
		
		$this->initSubmitValue();
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
		if ($option == "mainCSS:'dd2'") {
			$option = "mainCSS:'blue'";
		}
		$this->option = $option;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setTabIndex
	 * @access public
	 * @param mixed $tabindex 
	 * @return ComboBox
	 * @since 1.2.15
	 */
	public function setTabIndex($tabindex) {
		if (!is_numeric($tabindex) || $tabindex < 1) {
			throw new NewException(get_class($this)."->setTabIndex() error: \$tabindex need to > 0 !", 0, getDebugBacktrace(1));
		}
		$this->tabindex = $tabindex;
		return $this;
	}
	
	/**
	 * Method setLiveValidation
	 * @access public
	 * @param mixed $live_validation_object 
	 * @return ComboBox
	 * @since 1.2.15
	 */
	public function setLiveValidation($live_validation_object) {
		if (get_class($live_validation_object) != "LiveValidation") {
			throw new NewException("setLiveValidation(): \$live_validation_object must be a valid LiveValidation object", 0, getDebugBacktrace(1));
		}
		$live_validation_object->setObject($this);
		$this->live_validation = $live_validation_object;
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
	 * @param array $specific_attributes exemple array('new_attribute'=>'my_value', 'new_attribute2'=>'my_value2') [default value: array(]
	 * @return ComboBox
	 * @since 1.0.36
	 */
	public function addItem($value, $text, $selected=false, $img='', $group_name='', $specific_attributes=array()) {
		$this->item_value[] = html_entity_decode($value);
		
		if ($this->strip_tags) {
			$text = strip_tags($text, $this->strip_tags_allowable);
		}
		if ($text == "") {
			$text = "&nbsp;";
		}

		if ($this->auto_increment_same_text) {
			$ind = 1;
			$orig_text = $text;
			while (array_search($text, $this->item_text) !== false) {
				$text = $orig_text . " (" . $ind . ")";
				$ind++;
			}
		}
		$this->item_text[] = $text;
		
		if ($img != "" && strtoupper(substr($img, 0, 7)) != "HTTP://" && strtoupper(substr($img, 0, 8)) != "HTTPS://") {
			$this->item_img[] = $this->getPage()->getCDNServerURL().$img;
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
		
		$this->specific_option_attributes[] = $specific_attributes;
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; $this->list_items_change = true; }
		return $this;
	}
	
	/**
	 * Method removeItem
	 * @access public
	 * @param mixed $value 
	 * @return ComboBox
	 * @since 1.0.98
	 */
	public function removeItem($value) {
		if (($pos = array_search($value, $this->item_value)) !== false) {
			unset($this->item_value[$pos]);
			unset($this->item_text[$pos]);
			unset($this->item_img[$pos]);
			
			$this->item_value = array_values($this->item_value);
			$this->item_text = array_values($this->item_text);
			$this->item_img = array_values($this->item_img);
			
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
	 * Method setSmallIcons
	 * @access public
	 * @since 1.1.7
	 */
	public function setSmallIcons() {
		$this->page_object->addObject(New JavaScript("$(\"<style type='text/css'>.dd .ddChild a img { border:0; padding:0 2px 0 0; vertical-align:middle; height: 16px; width: 16px; }</style>\").appendTo(\"head\");"));
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
	 * @return ComboBox
	 * @since 1.1.2
	 */
	public function setStripTags($allowable_tags='') {
		$this->strip_tags = true;
		$this->strip_tags_allowable = $allowable_tags;
		return $this;
	}

	/**
	 * Method disableAutoIncrementSameText
	 * @access public
	 * @return ComboBox
	 * @since 1.2.14
	 */
	public function disableAutoIncrementSameText() {
		$this->auto_increment_same_text = false;
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
	 * Method getTabIndex
	 * @access public
	 * @return mixed
	 * @since 1.2.15
	 */
	public function getTabIndex() {
		return $this->tabindex;
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
	 * Method findIndexText
	 * @access public
	 * @param mixed $text 
	 * @return mixed
	 * @since 1.2.15
	 */
	public function findIndexText($text) {
		return array_search($text, $this->item_text);
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
	 * Method findIndexValue
	 * @access public
	 * @param mixed $value 
	 * @return mixed
	 * @since 1.2.15
	 */
	public function findIndexValue($value) {
		return array_search($value, $this->item_value);
	}
	
	/**
	 * Method getOnChangeJs
	 * @access public
	 * @return mixed
	 * @since 1.2.15
	 */
	public function getOnChangeJs() {
		return $this->onchange;
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
		
		$html = "<span id=\"".$this->getEventObjectName()."_cmb_span\">\n";
		$html .= "<select id=\"".$this->getEventObjectName()."\" name=\"".$this->getEventObjectName()."\" onChange=\"onChangeComboBox_".$this->getEventObjectName()."();\"";
		if ($this->disable) {
			$html .= " disabled";
		}
		if ($this->width != "" && $this->width > 0) {
			$html .= " style=\"width:".($this->width + 4)."px;\"";
		}
		if ($this->tabindex != -1) {
			$html .= " tabindex=\"".$this->tabindex."\"";				
		}
		$html .= " onFocus=\"if ((typeof lastCmbIdFocused === 'undefined' || lastCmbIdFocused!='".$this->getEventObjectName()."') && $('#".$this->getEventObjectName()."').data('dd')!=null) { $('#".$this->getEventObjectName()."').data('dd').open(); lastCmbIdFocused='".$this->getEventObjectName()."'; }\" onfocusout=\"if($('#".$this->getEventObjectName()."').data('dd')!=null) { $('#".$this->getEventObjectName()."').data('dd').close(); } lastCmbIdFocused='';\">\n";
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
			if (sizeof($this->specific_option_attributes[$i]) > 0) {
				foreach ($this->specific_option_attributes[$i] as $attribute => $value) {
					$html .= " ".$attribute."=\"".str_replace("\"", "\\\"", $value)."\"";
				}
			}
			$html .= ">".$this->item_text[$i]."</option>\n";
		}
		if ($last_group_name != "") {
			$html .= "	</optgroup>\n";
		}
		$html .= "</select>\n";
		
		if ($this->live_validation != null) {
			$html .= $this->live_validation->render();
		}
		
		$html .= "</span>\n";
		
		if ($this->callback_onchange != "") {
			$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
		}
		$html .= "<input type='hidden' id='Cmb_SelectedIndex_".$this->getEventObjectName()."' name='Cmb_SelectedIndex_".$this->getEventObjectName()."' value='".$this->getSelectedIndex()."'/>\n";
		
		$html .= $this->getJavascriptTagOpen();
		if ($this->is_ajax_event) {
			/*if ($this->form_object == null) {
				throw new NewException("Unable to activate action to this ".get_class($this)." : Attribut page_or_form_object must be a Form object", 0, getDebugBacktrace(1));
			}*/ // Now we can do Ajax on ComboBox without a Form object
			$html .= $this->getAjaxEventFunctionRender();
		}
		
		$html .= "	$(document).ready(function(){ $(\"#".$this->getEventObjectName()."\").msDropDown({";
		$html .= $this->option."}); ";
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
		if ($this->live_validation != null) {
			$html .= "			var lv_cmb_statut = LiveValidationForm_".$this->form_object->getName()."_".$this->getId()."();";
		}
		if ($this->callback_onchange != "") {
			if ($this->live_validation != null && $this->form_object != null && $this->callback_onchange != "") {
				$html .= "		if (lv_cmb_statut == false) { return false; }";
			}
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
			
			$refresh_selected_index = false;
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
						$refresh_selected_index = true;
					}
					$html .= "cmb_parent_node.appendChild(new_option);\n";
				}
				if ($last_group_name != "") {
					$html .= "document.getElementById('".$this->getEventObjectName()."').appendChild(cmb_parent_node);\n";
				}
				$html .= "var refreshed_cmb = $('#".$this->getEventObjectName()."').clone();\n";
				$html .= "$('#".$this->getEventObjectName()."').remove();\n";
				$html .= "refreshed_cmb.appendTo($('#".$this->getEventObjectName()."_msddHolder').parent());\n";
				$html .= "$('#".$this->getEventObjectName()."_msdd').remove();\n";
				$html .= "$('#".$this->getEventObjectName()."_msddHolder').remove();\n";
			} else if ($this->is_changed) {
				$refresh_selected_index = true;
			}
			$rand_id = rand(0, 999999999);
			$html .= "var wsp_cmb_".$rand_id." = $(\"#".$this->getEventObjectName()."\").msDropDown().data('dd');\n";
			$html .= "wsp_cmb_".$rand_id.".set('disabled', ".($this->disable?"true":"false").");\n";
			if ($refresh_selected_index) {
				$html .= "wsp_cmb_".$rand_id.".set('selectedIndex', ".$this->item_selected.");\n";
			}
		}
		return $html;
	}
	
}
?>
