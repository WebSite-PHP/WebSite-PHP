<?php
/**
 * PHP file wsp\class\display\advanced_object\ColorPicker.class.php
 * @package display
 * @subpackage advanced_object
 */
/**
 * Class ColorPicker
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 22/10/2010
 * @version     1.0.62
 * @access      public
 * @since       1.0.17
 */

include_once(dirname(__FILE__)."/../TextBox.class.php");

class ColorPicker extends TextBox {
	
	/**#@+
	* ColorPicker constant
	* @access public
	* @var string
	*/
	const COLORPICKER_MODE_HSV = "HSV";
	const COLORPICKER_MODE_HVS = "HVS";
	
	const COLORPICKER_POSITION_LEFT = "left";
	const COLORPICKER_POSITION_RIGHT = "right";
	const COLORPICKER_POSITION_TOP = "top";
	/**#@-*/
	
	/**
	 * Constructor ColorPicker
	 * @param mixed $page_or_form_object 
	 * @param string $name 
	 * @param string $id 
	 * @param string $value 
	 * @param string $width 
	 * @param double $length [default value: 0]
	 */
	function __construct($page_or_form_object, $name='', $id='', $value='', $width='', $length=0) {
		parent::__construct($page_or_form_object, $name, $id, $value, $width, $length);
		$this->isButton(false);
		$this->setClass("color {}");
		$this->addJavaScript(BASE_URL."wsp/js/jscolor.js", "", true);
	}
	
	/**
	 * Method isButton
	 * @access public
	 * @param mixed $bool 
	 * @return ColorPicker
	 * @since 1.0.35
	 */
	public function isButton($bool) {
		if ($bool) {
			$this->type = "button";
		} else {
			$this->type = "";
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method required
	 * @access public
	 * @param mixed $bool 
	 * @return ColorPicker
	 * @since 1.0.35
	 */
	public function required($bool) {
		$this->setProperty("required", $bool?"true":"false");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method adjust
	 * @access public
	 * @param mixed $bool 
	 * @return ColorPicker
	 * @since 1.0.35
	 */
	public function adjust($bool) {
		$this->setProperty("adjust", $bool?"true":"false");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method hash
	 * @access public
	 * @param mixed $bool 
	 * @return ColorPicker
	 * @since 1.0.35
	 */
	public function hash($bool) {
		$this->setProperty("hash", $bool?"true":"false");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method caps
	 * @access public
	 * @param mixed $bool 
	 * @return ColorPicker
	 * @since 1.0.35
	 */
	public function caps($bool) {
		$this->setProperty("caps", $bool?"true":"false");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method pickerMode
	 * @access public
	 * @param string $mode [default value: HSV]
	 * @return ColorPicker
	 * @since 1.0.35
	 */
	public function pickerMode($mode='HSV') {
		$this->setProperty("pickerMode", "\"".$mode."\"");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method pickerPosition
	 * @access public
	 * @param string $position [default value: left]
	 * @return ColorPicker
	 * @since 1.0.35
	 */
	public function pickerPosition($position='left') {
		$this->setProperty("pickerPosition", "\"".$position."\"");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method pickerBorder
	 * @access public
	 * @param mixed $int_value 
	 * @return ColorPicker
	 * @since 1.0.35
	 */
	public function pickerBorder($int_value) {
		$this->setProperty("pickerBorder", $int_value);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method pickerInset
	 * @access public
	 * @param mixed $int_value 
	 * @return ColorPicker
	 * @since 1.0.35
	 */
	public function pickerInset($int_value) {
		$this->setProperty("pickerInset", $int_value);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method pickerFace
	 * @access public
	 * @param mixed $int_value 
	 * @return ColorPicker
	 * @since 1.0.35
	 */
	public function pickerFace($int_value) {
		$this->setProperty("pickerFace", $int_value);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method pickerBorderColor
	 * @access public
	 * @param mixed $str_color 
	 * @return ColorPicker
	 * @since 1.0.35
	 */
	public function pickerBorderColor($str_color) {
		$this->setProperty("pickerBorderColor", "\"".$str_color."\"");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method pickerInsetColor
	 * @access public
	 * @param mixed $str_color 
	 * @return ColorPicker
	 * @since 1.0.35
	 */
	public function pickerInsetColor($str_color) {
		$this->setProperty("pickerBorderColor", "\"".$str_color."\"");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method pickerFaceColor
	 * @access public
	 * @param mixed $str_color 
	 * @return ColorPicker
	 * @since 1.0.35
	 */
	public function pickerFaceColor($str_color) {
		$this->setProperty("pickerBorderColor", "\"".$str_color."\"");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method valueElement
	 * @access public
	 * @param mixed $textbox_id 
	 * @return ColorPicker
	 * @since 1.0.35
	 */
	public function valueElement($textbox_id) {
		$this->setProperty("valueElement", "\"".$textbox_id."\"");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method styleElement
	 * @access public
	 * @param mixed $textbox_id 
	 * @return ColorPicker
	 * @since 1.0.35
	 */
	public function styleElement($textbox_id) {
		$this->setProperty("styleElement", "\"".$textbox_id."\"");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method forceEmptyValue
	 * @access public
	 * @return ColorPicker
	 * @since 1.0.35
	 */
	public function forceEmptyValue() {
		$this->setValue("");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setProperty
	 * @access private
	 * @param mixed $name 
	 * @param mixed $value 
	 * @since 1.0.59
	 */
	private function setProperty($name, $value) {
		$class = $this->getClass();
		$params = "";
		
		$pos = find($class, "{", 0, 0);
		if ($pos > 0) {
			$pos2 = find($class, "}", 0, 0) - 1;
			$params = substr($class, $pos, $pos2-$pos);
		}
		
		$new_class_params = "";
		$array_params = explode(",", $params);
		for ($i = 0; $i < sizeof($array_params); $i++) {
			$array_param = explode(":", $array_params[$i]);
			if ($array_param[0] != $name) {
				if ($new_class_params != "") {
					$new_class_params .= ",";
				}
				$new_class_params .= $array_params[$i];
			}
		}
		if ($new_class_params != "") {
			$new_class_params .= ",";
		}
		$new_class_params .= $name.":".$value;
		$this->setClass("color {".$new_class_params."}");
	}
}
?>
