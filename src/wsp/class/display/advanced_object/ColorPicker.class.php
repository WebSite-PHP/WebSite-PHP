<?php
include_once("TextBox.class.php");

class ColorPicker extends TextBox {
	const COLORPICKER_MODE_HSV = "HSV";
	const COLORPICKER_MODE_HVS = "HVS";
	
	const COLORPICKER_POSITION_LEFT = "left";
	const COLORPICKER_POSITION_RIGHT = "right";
	const COLORPICKER_POSITION_TOP = "top";
	
	function __construct($page_or_form_object, $name='', $id='', $value='', $width='', $length=0) {
		parent::__construct($page_or_form_object, $name, $id, $value, $width, $length);
		$this->isButton(false);
		$this->setClass("color {}");
		$this->addJavaScript(BASE_URL."wsp/js/jscolor.js", "", true);
	}
	
	public function isButton($bool) {
		if ($bool) {
			$this->type = "button";
		} else {
			$this->type = "";
		}
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function required($bool) {
		$this->setProperty("required", $bool?"true":"false");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function adjust($bool) {
		$this->setProperty("adjust", $bool?"true":"false");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function hash($bool) {
		$this->setProperty("hash", $bool?"true":"false");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function caps($bool) {
		$this->setProperty("caps", $bool?"true":"false");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function pickerMode($mode='HSV') {
		$this->setProperty("pickerMode", "\"".$mode."\"");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function pickerPosition($position='left') {
		$this->setProperty("pickerPosition", "\"".$position."\"");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function pickerBorder($int_value) {
		$this->setProperty("pickerBorder", $int_value);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function pickerInset($int_value) {
		$this->setProperty("pickerInset", $int_value);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function pickerFace($int_value) {
		$this->setProperty("pickerFace", $int_value);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function pickerBorderColor($str_color) {
		$this->setProperty("pickerBorderColor", "\"".$str_color."\"");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function pickerInsetColor($str_color) {
		$this->setProperty("pickerBorderColor", "\"".$str_color."\"");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function pickerFaceColor($str_color) {
		$this->setProperty("pickerBorderColor", "\"".$str_color."\"");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function valueElement($textbox_id) {
		$this->setProperty("valueElement", "\"".$textbox_id."\"");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function styleElement($textbox_id) {
		$this->setProperty("styleElement", "\"".$textbox_id."\"");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	public function forceEmptyValue() {
		$this->setValue("");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
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
