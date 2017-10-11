<?php
/**
 * PHP file wsp\class\display\Calendar.class.php
 * @package display
 */
/**
 * Class Calendar
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
 * @since       1.0.93
 */

include_once("TextBox.class.php");

class Calendar extends TextBox {
	/**#@+
	* Calendar Animation
	* @access public
	* @var string
	*/
	const ANIMATION_SHOW = "show";
	const ANIMATION_SLIDESHOW = "slideDown";
	const ANIMATION_FADEIN = "fadeIn";
	const ANIMATION_BLIND = "blind";
	const ANIMATION_BOUNCE = "bounce";
	const ANIMATION_CLIP = "clip";
	const ANIMATION_DROP = "drop";
	const ANIMATION_FOLD = "fold";
	const ANIMATION_SLIDE = "slide";
	/**#@-*/
	
	/**#@+
	* Calendar Date Format
	* @access public
	* @var string
	*/
	const DATE_FORMAT_ENGLISH = "mm-dd-yy";
	const DATE_FORMAT_US = "yy-mm-dd";
	const DATE_FORMAT_FRENCH = "dd/mm/yy";
	const DATE_FORMAT_GERMAN = "dd.mm.yy";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $minDate = -999999999;
	private $maxDate = "";
	private $dateFormat = "mm-dd-yy";
	private $showButtonPanel = false;
	private $changeMonth = false;
	private $changeYear = false;
	private $showOtherMonths = false;
	private $selectOtherMonths = false;
	private $showWeek = false;
	private $firstDay = "";
	private $numberOfMonths = "";
	private $showAnim = "show";
	
	private $dateFormatConvertPhpFormat = array("dd/mm/yy" => "d/m/Y",
												"mm-dd-yy" => "m-d-Y",
												"dd.mm.yy" => "d.m.Y",
												"yy-mm-dd" => "Y-m-d");
	
	private $monthNames = array();
	private $monthNamesShort = array();
	private $dayNames = array();
	private $dayNamesShort = array();
	private $dayNamesMin = array();
	/**#@-*/
	
	/**
	 * Constructor Calendar
	 * @param mixed $page_or_form_object 
	 * @param string $name 
	 * @param string $id 
	 * @param string $value 
	 * @param string $width 
	 */
	function __construct($page_or_form_object, $name='', $id='', $value='', $width='') {
		parent::__construct($page_or_form_object, $name, $id, $value, $width);
		$this->type = "calendar";
		if ($this->getPage()->getLanguage() == "fr") {
			$this->setDateFormat(Calendar::DATE_FORMAT_FRENCH);
		} else if ($this->getPage()->getLanguage() == "de") {
			$this->setDateFormat(Calendar::DATE_FORMAT_GERMAN);
		}
	}
	
	/**
	 * Method getValue
	 * @access public
	 * @return mixed
	 * @since 1.0.99
	 */
	public function getValue() {
		$this->value = parent::getValue();
		
		if ($this->value == null || $this->value == "") {
			return $this->value;
		} else if (get_class($this->value) != "DateTime") {
			if (array_key_exists($this->dateFormat, $this->dateFormatConvertPhpFormat)) {
				return DateTime::createFromFormat($this->dateFormatConvertPhpFormat[$this->dateFormat], $this->value);
			}
		}
		
		return $this->value;
	}
	
	/**
	 * Method getValueStr
	 * @access public
	 * @return mixed
	 * @since 1.1.6
	 */
	public function getValueStr() {
		$this->value = parent::getValue();
		if (get_class($this->value) == "DateTime") {
			if (array_key_exists($this->dateFormat, $this->dateFormatConvertPhpFormat)) {
				return $this->value->format($this->dateFormatConvertPhpFormat[$this->dateFormat]);
			}
		}
		return $this->value;
	}
	
	/**
	 * Method setAutoComplete
	 * @access public
	 * @param mixed $autocomplete_object 
	 * @since 1.0.93
	 */
	public function setAutoComplete($autocomplete_object) {
		throw new NewException(get_class($this)."->setAutoComplete(): is not compatible with Calendar", 0, getDebugBacktrace(1));
	}
	
	/**
	 * Method setMinDate
	 * @access public
	 * @param mixed $minDate 
	 * @return Calendar
	 * @since 1.0.93
	 */
	public function setMinDate($minDate) {
		$this->minDate = $minDate;
		return $this;
	}
	
	/**
	 * Method setMaxDate
	 * @access public
	 * @param mixed $maxDate 
	 * @return Calendar
	 * @since 1.0.93
	 */
	public function setMaxDate($maxDate) {
		$this->maxDate = $maxDate;
		return $this;
	}
	
	/**
	 * Method setDateFormat
	 * @access public
	 * @param mixed $dateFormat 
	 * @return Calendar
	 * @since 1.0.93
	 */
	public function setDateFormat($dateFormat) {
		$this->dateFormat = $dateFormat;
		return $this;
	}
    
	/**
	 * Method getDateFormat
	 * @access public
	 * @return mixed
	 * @since 1.2.6
	 */
    public function getDateFormat() {
        return $this->dateFormat;
    }
    
	/**
	 * Method getConvertedDateFormat
	 * @access public
	 * @return mixed
	 * @since 1.2.6
	 */
    public function getConvertedDateFormat() {
        return $this->dateFormatConvertPhpFormat[$this->dateFormat];
    }
	
	/**
	 * Method showButtonPanel
	 * @access public
	 * @return Calendar
	 * @since 1.0.93
	 */
	public function showButtonPanel() {
		$this->showButtonPanel = true;
		return $this;
	}
	
	/**
	 * Method changeMonth
	 * @access public
	 * @return Calendar
	 * @since 1.0.93
	 */
	public function changeMonth() {
		$this->changeMonth = true;
		return $this;
	}
	
	/**
	 * Method changeYear
	 * @access public
	 * @return Calendar
	 * @since 1.0.93
	 */
	public function changeYear() {
		$this->changeYear = true;
		return $this;
	}
	
	/**
	 * Method showOtherMonths
	 * @access public
	 * @return Calendar
	 * @since 1.0.93
	 */
	public function showOtherMonths() {
		$this->showOtherMonths = true;
		return $this;
	}
	
	/**
	 * Method selectOtherMonths
	 * @access public
	 * @return Calendar
	 * @since 1.0.93
	 */
	public function selectOtherMonths() {
		$this->selectOtherMonths = true;
		return $this;
	}
	
	/**
	 * Method showWeek
	 * @access public
	 * @return Calendar
	 * @since 1.0.93
	 */
	public function showWeek() {
		$this->showWeek = true;
		return $this;
	}
	
	/**
	 * Method setFirstDay
	 * @access public
	 * @param mixed $firstDay 
	 * @return Calendar
	 * @since 1.0.93
	 */
	public function setFirstDay($firstDay) {
		$this->firstDay = $firstDay;
		return $this;
	}
	
	/**
	 * Method setNumberOfMonths
	 * @access public
	 * @param mixed $numberOfMonths 
	 * @return Calendar
	 * @since 1.0.93
	 */
	public function setNumberOfMonths($numberOfMonths) {
		$this->numberOfMonths = $numberOfMonths;
		return $this;
	}
	
	/**
	 * Method setShowAnim
	 * @access public
	 * @param mixed $showAnim 
	 * @return Calendar
	 * @since 1.0.93
	 */
	public function setShowAnim($showAnim) {
		$this->showAnim = $showAnim;
		return $this;
	}
	
	/**
	 * Method setMonthNames
	 * @access public
	 * @param mixed $monthNames [default value: array(]
	 * @return Calendar
	 * @since 1.1.11
	 */
	public function setMonthNames($monthNames=array(), $monthNamesShort=array()) {
		if (is_array($monthNames) && sizeof($monthNames) > 0) {
			$this->monthNames = $monthNames;
		}
		if (is_array($monthNamesShort) && sizeof($monthNamesShort) > 0) {
			$this->monthNamesShort = $monthNamesShort;
		}
		return $this;
	}
	
	/**
	 * Method setDayNames
	 * @access public
	 * @param mixed $dayNames [default value: array(]
	 * @return Calendar
	 * @since 1.1.11
	 */
	public function setDayNames($dayNames=array(), $dayNamesShort=array(), $dayNamesMin=array()) {
		if (is_array($dayNames) && sizeof($dayNames) > 0) {
			$this->dayNames = $dayNames;
		}
		if (is_array($dayNamesShort) && sizeof($dayNamesShort) > 0) {
			$this->dayNamesShort = $dayNamesShort;
		}
		if (is_array($dayNamesMin) && sizeof($dayNamesMin) > 0) {
			$this->dayNamesMin = $dayNamesMin;
		}
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Calendar
	 * @since 1.0.93
	 */
	public function render($ajax_render=false) {
		if ($this->live_validation != null) {
			parent::onChangeJs(parent::getOnChangeJs()."LV_".$this->getId().".validate();");
		}
		$html = parent::render($ajax_render);
		
		$html .= $this->getJavascriptTagOpen();
		$html .= "$.datepicker.setDefaults($.datepicker.regional[\"".$_SESSION['lang']."\"]);\n";
		$html .= "$(\"#".$this->getId()."\").datepicker({ ";
		if ($this->maxDate != "") {
			$html .= "maxDate: '".$this->maxDate."', ";
		}
		if ($this->dateFormat != "") {
			$html .= "dateFormat: '".$this->dateFormat."', ";
		}
		if ($this->showButtonPanel) {
			$html .= "showButtonPanel: true, ";
		}
		if ($this->changeMonth) {
			$html .= "changeMonth: true, ";
		}
		if ($this->changeYear) {
			$html .= "changeYear: true, ";
		}
		if ($this->showOtherMonths) {
			$html .= "showOtherMonths: true, ";
		}
		if ($this->selectOtherMonths) {
			$html .= "selectOtherMonths: true, ";
		}
		if ($this->showWeek) {
			$html .= "showWeek: true, ";
		}
		if ($this->firstDay != "") {
			$html .= "firstDay: ".$this->firstDay.", ";
		} else {
			$html .= "firstDay: 1, ";
		}
		if ($this->numberOfMonths != "") {
			$html .= "numberOfMonths: ".$this->numberOfMonths.", ";
		}
		if ($this->minDate != -999999999) {
			$html .= "minDate: '";
			if (get_class($this->minDate) == "DateTime") {
				if ($this->dateFormat == "") {
					$html .= $this->minDate->format("m-d-Y");
				} else if (array_key_exists($this->dateFormat, $this->dateFormatConvertPhpFormat)) {
					$html .= $this->minDate->format($this->dateFormatConvertPhpFormat[$this->dateFormat]);
				} else {
					$html .= $this->minDate->format($this->dateFormat);
				}
			} else {
				$html .= $this->minDate;
			}
			$html .= "', ";
		}
		$html .= "showAnim: '".$this->showAnim."'";
		if ($this->getPage()->getLanguage() != "en") {
			$html .= ",monthNames: [";
			if (sizeof($this->monthNames)> 0) {
				for ($i=0; $i < sizeof($this->monthNames); $i++) {
					if ($i > 0) { $html .= ","; }
					$html .= "'".addslashes($this->monthNames[$i])."'";
				}
			} else {
				$html .= "'".addslashes(utf8encode(__(__JANUARY__)))."', '".addslashes(utf8encode(__(__FEBRUARY__)))."', '".addslashes(utf8encode(__(__MARCH__)))."', '".addslashes(utf8encode(__(__APRIL__)))."', '".addslashes(utf8encode(__(__MAY__)))."', '".addslashes(utf8encode(__(__JUNE__)))."', '".addslashes(utf8encode(__(__JULY__)))."', '".addslashes(utf8encode(__(__AUGUST__)))."', '".addslashes(utf8encode(__(__SEPTEMBER__)))."', '".addslashes(utf8encode(__(__OCTOBER__)))."', '".addslashes(utf8encode(__(__NOVEMBER__)))."', '".addslashes(utf8encode(__(__DECEMBER__)))."']";
			}
			$html .= ",dayNames: [";
			if (sizeof($this->dayNames)> 0) {
				for ($i=0; $i < sizeof($this->dayNames); $i++) {
					if ($i > 0) { $html .= ","; }
					$html .= "'".addslashes($this->dayNames[$i])."'";
				}
			} else {
				$html .= "'".addslashes(utf8encode(__(__SUNDAY__)))."', '".addslashes(utf8encode(__(__MONDAY__)))."', '".addslashes(utf8encode(__(__TUESDAY__)))."', '".addslashes(utf8encode(__(__WEDNESDAY__)))."', '".addslashes(utf8encode(__(__THURSDAY__)))."', '".addslashes(utf8encode(__(__FRIDAY__)))."', '".addslashes(utf8encode(__(__SATURDAY__)))."']";
			}
			$html .= ",monthNamesShort: [";
			if (sizeof($this->monthNamesShort)> 0) {
				for ($i=0; $i < sizeof($this->monthNamesShort); $i++) {
					if ($i > 0) { $html .= ","; }
					$html .= "'".addslashes($this->monthNamesShort[$i])."'";
				}
			} else {
				$html .= "'".addslashes(utf8encode(substr(__(__JANUARY__), 0, 3)))."', '".addslashes(utf8encode(substr(__(__FEBRUARY__), 0, 3)))."', '".addslashes(utf8encode(substr(__(__MARCH__), 0, 3)))."', '".addslashes(utf8encode(substr(__(__APRIL__), 0, 3)))."', '".addslashes(utf8encode(substr(__(__MAY__), 0, 3)))."', '".addslashes(utf8encode(substr(__(__JUNE__), 0, 3)))."', '".addslashes(utf8encode(substr(__(__JULY__), 0, 3)))."', '".addslashes(utf8encode(substr(__(__AUGUST__), 0, 3)))."', '".addslashes(utf8encode(substr(__(__SEPTEMBER__), 0, 3)))."', '".addslashes(utf8encode(substr(__(__OCTOBER__), 0, 3)))."', '".addslashes(utf8encode(substr(__(__NOVEMBER__), 0, 3)))."', '".addslashes(utf8encode(substr(__(__DECEMBER__), 0, 3)))."']";
			}
			$html .= ",dayNamesShort: [";
			if (sizeof($this->dayNamesShort)> 0) {
				for ($i=0; $i < sizeof($this->dayNamesShort); $i++) {
					if ($i > 0) { $html .= ","; }
					$html .= "'".addslashes($this->dayNamesShort[$i])."'";
				}
			} else {
				$html .= "'".addslashes(utf8encode(substr(__(__SUNDAY__), 0, 3)))."', '".addslashes(utf8encode(substr(__(__MONDAY__), 0, 3)))."', '".addslashes(utf8encode(substr(__(__TUESDAY__), 0, 3)))."', '".addslashes(utf8encode(substr(__(__WEDNESDAY__), 0, 3)))."', '".addslashes(utf8encode(substr(__(__THURSDAY__), 0, 3)))."', '".addslashes(utf8encode(substr(__(__FRIDAY__), 0, 3)))."', '".addslashes(utf8encode(substr(__(__SATURDAY__), 0, 3)))."']";
			}
			$html .= ",dayNamesMin: [";
			if (sizeof($this->dayNamesMin)> 0) {
				for ($i=0; $i < sizeof($this->dayNamesMin); $i++) {
					if ($i > 0) { $html .= ","; }
					$html .= "'".addslashes($this->dayNamesMin[$i])."'";
				}
			} else {
				$html .= "'".addslashes(utf8encode(substr(__(__SUNDAY__), 0, 2)))."', '".addslashes(utf8encode(substr(__(__MONDAY__), 0, 2)))."', '".addslashes(utf8encode(substr(__(__TUESDAY__), 0, 2)))."', '".addslashes(utf8encode(substr(__(__WEDNESDAY__), 0, 2)))."', '".addslashes(utf8encode(substr(__(__THURSDAY__), 0, 2)))."', '".addslashes(utf8encode(substr(__(__FRIDAY__), 0, 2)))."', '".addslashes(utf8encode(substr(__(__SATURDAY__), 0, 2)))."']";
			}
		}
		$html .= "});\n";
		$html .= $this->getJavascriptTagClose();
		
		return $html;
	}
}
?>
