<?php
/**
 * PHP file wsp\class\display\SelectListMultiple.class.php
 * @package display
 */
/**
 * Class SelectListMultiple
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
 * @copyright   WebSite-PHP.com 05/02/2017
 * @version     1.2.15
 * @access      public
 * @since       1.2.15
 */

class SelectListMultiple extends SelectList {
	/**
	 * Constructor SelectListMultiple
	 * @param mixed $page_or_form_object 
	 * @param string $name 
	 * @param string $nb_lines 
	 * @param string $width 
	 */
	function __construct($page_or_form_object, $name='', $nb_lines='', $width='') {
		parent::__construct($page_or_form_object, $name, $nb_lines, $width);
		$this->item_default_selected = array();
		$this->item_selected = array();
	}
	
	/**
	 * Method setValue
	 * @access public
	 * @param mixed $value 
	 * @return SelectListMultiple
	 * @since 1.2.15
	 */
	public function setValue($value) {
		$find_item = false;
		$this->resetSelectedIndex();
		if (!is_array($value)) {
			$value = array($value);
		}
		for ($i=0; $i < sizeof($this->item_value); $i++) {
			if (in_array($this->item_value[$i], $value)) {
				$this->addSelectedIndex($i);
				$this->item_loaded = true;
				$find_item = true;
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
	 * @return SelectListMultiple
	 * @since 1.2.15
	 */
	public function setDefaultValue($value) {
		if (!is_array($value)) {
			$value = array($value);
		}
		$this->item_default_selected = array();
		$find_item = false;
		for ($i=0; $i < sizeof($this->item_value); $i++) {
			if (in_array($this->item_value[$i], $value)) {
				$this->item_default_selected[] = $i;
				$find_item = true;
			}
		}
		if ($find_item) {
			if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		}
		return $this;
	}

	/**
	 * Method setSelectedIndex
	 * @access public
	 * @param mixed $index 
	 * @since 1.2.15
	 */
	public function setSelectedIndex($index) {
		$this->resetSelectedIndex();
		$this->addSelectedIndex($index);
	}
	
	/**
	 * Method getSelectedIndex
	 * @access public
	 * @return mixed
	 * @since 1.2.15
	 */
	public function getSelectedIndex() {
		return $this->item_selected;
	}
	
	/**
	 * Method addSelectedIndex
	 * @access public
	 * @param mixed $index 
	 * @return SelectListMultiple
	 * @since 1.2.15
	 */
	public function addSelectedIndex($index) {
		if (sizeof($this->item_value) > 0) { // init selected index with submit value if not already do 
			$this->initSubmitValue();
		}
		if (isset($this->item_value[$index]) && !in_array($index, $this->item_selected)) {
			$this->item_selected[] = $index;
			$this->item_loaded = true;
			if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		}
		return $this;
	}
	
	/**
	 * Method resetSelectedIndex
	 * @access public
	 * @return SelectListMultiple
	 * @since 1.2.15
	 */
	public function resetSelectedIndex() {
		$this->item_selected = array();
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method getValue
	 * @access public
	 * @return mixed
	 * @since 1.2.15
	 */
	public function getValue() {
		parent::getValue();
		$values = array();
		for ($i=0; $i < sizeof($this->item_selected); $i++) {
			if (isset($this->item_value[$this->item_selected[$i]])) {
				$values[]=$this->item_value[$this->item_selected[$i]];
			}
		}
		return $values;
	}

	/**
	 * Method getDefaultValue
	 * @access public
	 * @return mixed
	 * @since 1.2.15
	 */
	public function getDefaultValue() {
		$values = array();
		for ($i=0; $i < sizeof($this->item_default_selected); $i++) {
			if (isset($this->item_value[$this->item_default_selected[$i]])) {
				$values[]=$this->item_value[$this->item_default_selected[$i]];
			}
		}
		return $values;
	}

	/**
	 * Method getText
	 * @access public
	 * @return mixed
	 * @since 1.2.15
	 */
	public function getText() {
		if (sizeof($this->item_value) > 0) { $this->initSubmitValue(); } // init selected index with submit value if not already do
		$values = array();
		for ($i=0; $i < sizeof($this->item_selected); $i++) {
			if (isset($this->item_text[$this->item_selected[$i]])) {
				$values[]=$this->item_text[$this->item_selected[$i]];
			}
		}
		return $values;
	}

	/**
	 * Method isChanged
	 * @access public
	 * @return mixed
	 * @since 1.2.15
	 */
	public function isChanged() {
		if ($this->callback_onchange == "") {
			$same_values = true;
			$values = $this->getValue();
			$default_values = $this->getDefaultValue();
			for ($i=0; $i < sizeof($default_values); $i++) {
				if (!in_array($default_values[$i], $values)) {
					$same_values = false;
					break;
				}
			}
			if (!$same_values) {
				return true;
			} else {
				return false;
			}
		} else {
			return $this->is_changed;
		}
	}
}
?>
