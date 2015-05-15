<?php
/**
 * PHP file wsp\class\display\advanced_object\Slider.class.php
 * @package display
 * @subpackage advanced_object
 */
/**
 * Class Slider
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.2.7
 */

class Slider extends WebSitePhpObject {
	/**#@+
	* Slider style
	* @access public
	* @var string
	*/
	const HORIZONTAL_SLIDER = "";
	const VERTICAL_SLIDER = "vertical";
	/**#@-*/
	
	private $id = "";
	private $value = 0;
	private $min_rangle_value = -1;
	private $max_rangle_value = -1;
	private $min_value = 0;
	private $max_value = 100;
	private $is_range = false;
	private $step = 1;
	private $orientation = Slider::HORIZONTAL_SLIDER;
	private $display_text = false;
	private $display_text_title = "";
	private $text_pattern = "";
	private $text_pattern_range_max = "";
	private $text_pattern_init = "";
	private $text_pattern_range_max_init = "";
	private $is_onslidejs = false;
	private $onslidejs = "";
	private $is_onchangejs = false;
	private $onchangejs = "";
	private $background_color = "";
	private $cursur_color = "";
	
	/**
	 * Constructor Slider
	 * @param double $value [default value: 0]
	 * @param double $min_value [default value: 0]
	 * @param double $max_value [default value: 100]
	 * @param string $id [default value: slider]
	 * @param mixed $orientation [default value: Slider::HORIZONTAL_SLIDER]
	 */
	function __construct($value=0, $min_value=0, $max_value=100, $id='slider', $orientation=Slider::HORIZONTAL_SLIDER) {
		$this->id = str_replace("-", "_", $id);
		$this->value = $value;
		$this->min_value = $min_value;
		$this->max_value = $max_value;
		$this->orientation = $orientation;
	}
	
	/**
	 * Method setId
	 * @access public
	 * @param mixed $id 
	 * @return Slider
	 * @since 1.2.7
	 */
	public function setId($id) {
		$this->id = str_replace("-", "_", $id);
		return $this;
	}

	/**
	 * Method setRangeValues
	 * @access public
	 * @param mixed $min_rangle_value 
	 * @param mixed $max_rangle_value 
	 * @return Slider
	 * @since 1.2.7
	 */
	public function setRangeValues($min_rangle_value, $max_rangle_value) {
		$this->is_range = true;
		$this->min_rangle_value = $min_rangle_value;
		$this->max_rangle_value = $max_rangle_value;
		return $this;
	}
	
	/**
	 * Method setValue
	 * @access public
	 * @param mixed $value 
	 * @return Slider
	 * @since 1.2.7
	 */
	public function setValue($value) {
		$this->value = $value;
		return $this;
	}
	
	/**
	 * Method setStep
	 * @access public
	 * @param mixed $step 
	 * @return Slider
	 * @since 1.2.7
	 */
	public function setStep($step) {
		$this->step = $step;
		return $this;
	}
	
	/**
	 * Method setMinValue
	 * @access public
	 * @param mixed $min_value 
	 * @return Slider
	 * @since 1.2.7
	 */
	public function setMinValue($min_value) {
		$this->min_value = $min_value;
		return $this;
	}
	
	/**
	 * Method setMaxValue
	 * @access public
	 * @param mixed $max_value 
	 * @return Slider
	 * @since 1.2.7
	 */
	public function setMaxValue($max_value) {
		$this->max_value = $max_value;
		return $this;
	}
	
	/**
	 * Method setBackgroundColor
	 * @access public
	 * @param mixed $background_color 
	 * @return Slider
	 * @since 1.2.7
	 */
	public function setBackgroundColor($background_color) {
		$this->background_color = $background_color;
		return $this;
	}
	
	/**
	 * Method setCursorColor
	 * @access public
	 * @param mixed $cursur_color 
	 * @return Slider
	 * @since 1.2.7
	 */
	public function setCursorColor($cursur_color) {
		$this->cursur_color = $cursur_color;
		return $this;
	}
	
	public function displayText($title='', $text_pattern='{#value}€', $text_pattern_range_max='{#value}€') {
		$this->display_text = true;
		$this->display_text_title = $title;
		$this->text_pattern = str_replace("{#value}", "\" + ui.values[0] + \"", $text_pattern);
		$this->text_pattern_init = str_replace("{#value}", "\" + $(\"#".$this->id."\").slider(\"values\", 0) + \"", $text_pattern);
		$this->text_pattern_range_max = str_replace("{#value}", "\" + ui.values[1] + \"", $text_pattern_range_max);
		$this->text_pattern_range_max_init = str_replace("{#value}", "\" + $(\"#".$this->id."\").slider(\"values\", 1) + \"", $text_pattern_range_max);
		return $this;
	}
	
	/**
	 * Method onSlideJs
	 * @access public
	 * @param mixed $js_function 
	 * @return Slider
	 * @since 1.2.7
	 */
	public function onSlideJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onSlideJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->is_onslidejs = true;
		$this->onslidejs = trim($js_function);
		return $this;
	}
	
	/**
	 * Method onChangeJs
	 * @access public
	 * @param mixed $js_function 
	 * @return Slider
	 * @since 1.2.7
	 */
	public function onChangeJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onChangeJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
			$js_function = $js_function->render();
		}
		$this->is_onchangejs = true;
		$this->onchangejs = trim($js_function);
		return $this;
	}
	
	/**
	 * Method getId
	 * @access public
	 * @return mixed
	 * @since 1.2.7
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Slider
	 * @since 1.2.7
	 */
	public function render($ajax_render=false) {
		$html = "";
	
		if ($this->background_color != "") {
			$html .= "<style>\n";
		 	$html .= "#".$this->id." { background: ".$this->background_color."; }\n";
		 	$html .= "</style>\n";
		}
		if ($this->cursur_color != "") {
			$html .= "<style>\n";
		 	$html .= "#".$this->id." .ui-slider-handle { background: ".$this->cursur_color."; }\n";
		 	$html .= "</style>\n";
		}
		
		if ($this->display_text) {
			$html .= $this->display_text_title."<div id=\"labelslider_".$this->id."\"></div>";
		}
		$html .= "<div id=\"".$this->id."\"></div>";
		
		$html .= $this->getJavascriptTagOpen();
		$html .= "$(function() {\n";
		$html .= "	$(\"#".$this->id."\").slider({\n";
		if ($this->orientation != Slider::HORIZONTAL_SLIDER) {
			$html .= "		orientation: \"".$this->orientation."\",\n";
		}
		if ($this->step != 1) {
			$html .= "		step: ".$this->step.",\n";
		}
		if ($this->is_range) {
			$html .= "		range: true,\n";
			$html .= "		values: [\"".$this->min_rangle_value."\", \"".$this->max_rangle_value."\"],\n";
		} else {
			$html .= "		value: ".$this->value.",\n";
		}
		if ($this->is_onslidejs) {
			$html .= "		slide: function(event, ui) {\n";
			$html .= $this->onslidejs;
			$html .= "		},\n";
		}
		if ($this->display_text || $this->is_onchangejs) {
			$html .= "		change: function(event, ui) {\n";
			if ($this->display_text) {
				$html .= "			$(\"#labelslider_".$this->id."\").html(\"";
				if ($this->is_range) {
					$html .= $this->text_pattern." - ".$this->text_pattern_range_max;
				} else {
					$html .= $this->text_pattern_init;
				}
				$html .= "\");\n";
			}
			if ($this->is_onchangejs) {
				$html .= $this->onchangejs;
			}
			$html .= "		},\n";
		}
		$html .= "		min: ".$this->min_value.",\n";
		$html .= "		max: ".$this->max_value."\n";
		$html .= "	});\n";
		if ($this->display_text) {
			$html .= "			$(\"#labelslider_".$this->id."\").html(\"".$this->text_pattern_init;
			if ($this->is_range) {
				$html .= " - ".$this->text_pattern_range_max_init;
			}
			$html .= "\");\n";
		}
		$html .= "});";
		$html .= $this->getJavascriptTagClose();
		
		return $html;
	}
}
?>
