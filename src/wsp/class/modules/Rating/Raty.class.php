<?php 
/**
 * PHP file wsp\class\modules\Rating\Raty.class.php
 * @package modules
 * @subpackage Rating
 */
/**
 * Class Raty
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package modules
 * @subpackage Rating
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.0.103
 */

class Raty extends WebSitePhpEventObject {
	/**#@+
	* @access private
	*/
	protected $id = "";
	private $start = 0;
	private $readonly = false;
	private $no_rate_msg = "";
	private $hint_start_value = array();
	private $star_number = 5;
	private $cancel_button = false;
	private $cancel_button_hint = 'cancel my rating!';
	private $cancel_button_place = 'left';
	private $display_half_start = false;
	private $space = true;
	
	private $onclick = "";
	private $callback_onclick = "";
	private $onclick_readonly = false;
	/**#@-*/
	
	/**
	 * Constructor Raty
	 * @param mixed $id 
	 */
	function __construct($id) {
		parent::__construct();
		
		if (!isset($id)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}
		
		$this->id = $id;
		$this->addJavaScript(BASE_URL."wsp/js/jquery.raty.min.js", "", true);
	}
	
	/**
	 * Method setStartValue
	 * @access public
	 * @param mixed $value 
	 * @return Raty
	 * @since 1.0.103
	 */
	public function setStartValue($value) {
		$this->start = $value;
		return $this;
	}
	
	/**
	 * Method setReadOnly
	 * @access public
	 * @return Raty
	 * @since 1.0.103
	 */
	public function setReadOnly() {
		$this->readonly = true;
		return $this;
	}
	
	/**
	 * Method setNoRateMessage
	 * @access public
	 * @param mixed $msg 
	 * @return Raty
	 * @since 1.0.103
	 */
	public function setNoRateMessage($msg) {
		$this->no_rate_msg = $msg;
		return $this;
	}
	
	/**
	 * Method setHintStarValue
	 * @access public
	 * @param mixed $hint_1 
	 * @param mixed $hint_2 [default value: null]
	 * @param mixed $hint_3 [default value: null]
	 * @param mixed $hint_4 [default value: null]
	 * @param mixed $hint_5 [default value: null]
	 * @return Raty
	 * @since 1.0.103
	 */
	public function setHintStarValue($hint_1, $hint_2=null, $hint_3=null, $hint_4=null, $hint_5=null) {
		$this->hint_start_value = func_get_args();
		return $this;
	}
	
	/**
	 * Method setStarNumber
	 * @access public
	 * @param mixed $number 
	 * @return Raty
	 * @since 1.0.103
	 */
	public function setStarNumber($number) {
		$this->star_number = $number;
		return $this;
	}
	
	/**
	 * Method displayCancelButton
	 * @access public
	 * @param string $cancel_hint [default value: cancel my rating!]
	 * @param string $cancel_place [default value: left]
	 * @return Raty
	 * @since 1.0.103
	 */
	public function displayCancelButton($cancel_hint='cancel my rating!', $cancel_place='left') {
		$this->cancel_button = true;
		$this->cancel_button_hint = $cancel_hint;
		$this->cancel_button_place = $cancel_place;
		return $this;
	}
	
	/**
	 * Method displayHaflStar
	 * @access public
	 * @return Raty
	 * @since 1.0.103
	 */
	public function displayHaflStar() {
		$this->display_half_start = true;
		return $this;
	}
	
	/**
	 * Method displayBigIcon
	 * @access public
	 * @return Raty
	 * @since 1.0.103
	 */
	public function displayBigIcon() {
		$this->display_big_icon = true;
		return $this;
	}
	
	/**
	 * Method setNoSpace
	 * @access public
	 * @return Raty
	 * @since 1.0.103
	 */
	public function setNoSpace() {
		$this->space = false;
		return $this;
	}
	
	/**
	 * Method getOnClickJs
	 * @access public
	 * @return mixed
	 * @since 1.0.103
	 */
	public function getOnClickJs() {
		return $this->onclick;
	}

	/**
	 * Method onClick
	 * @access public
	 * @param mixed $page_or_form_object 
	 * @param mixed $str_function 
	 * @param mixed $arg1 [default value: null]
	 * @param mixed $arg2 [default value: null]
	 * @param mixed $arg3 [default value: null]
	 * @param mixed $arg4 [default value: null]
	 * @param mixed $arg5 [default value: null]
	 * @return Raty
	 * @since 1.0.103
	 */
	public function onClick($page_or_form_object, $str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		if ($this->id == "") {
			throw new NewException("Error ".get_class($this)."->onClick(): You must specified an id (setId())", 0, getDebugBacktrace(1));
		}
		if (!isset($page_or_form_object) || gettype($page_or_form_object) != "object" || (!is_subclass_of($page_or_form_object, "Page") && get_class($page_or_form_object) != "Form")) {
			throw new NewException("Argument page_or_form_object for ".get_class($this)."::onClick() error", 0, getDebugBacktrace(1));
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
		$this->name = $this->getId();
		$this->page_object->addEventObject($this);
		
		$args = func_get_args();
		$page_object = array_shift($args);
		$str_function = array_shift($args);
		$args = array_merge(array(new JavaScript("' + score + '")), $args);
		
		$this->callback_onclick = $this->loadCallbackMethod($str_function, $args);
		
		return $this;
	}
	
	/**
	 * Method onClickReadOnly
	 * @access public
	 * @return Raty
	 * @since 1.0.103
	 */
	public function onClickReadOnly() {
		$this->onclick_readonly = true;
		return $this;
	}
	
	/* Intern management of Object */
	/**
	 * Method setClick
	 * @access public
	 * @return Raty
	 * @since 1.0.103
	 */
	public function setClick() {
		if ($GLOBALS['__LOAD_VARIABLES__']) { 
			$this->is_clicked = true; 
		}
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Raty
	 * @since 1.0.103
	 */
	public function render($ajax_render=false) {
		$html = "<div id=\"".$this->id."\"></div>\n";
		$html .= $this->getJavascriptTagOpen();
		$html .= "$('#".$this->id."').raty({\n";
		if ($this->readonly) {
			$html .= " 	readOnly: true,\n";
		}
		if ($this->display_half_start) {
			$html .= " 	half: true,\n";
		}
		if ($this->cancel_button) {
			$html .= " 	cancel: true,\n";
			$html .= " 	cancelHint: '".addslashes($this->$cancel_hint)."',\n";
			$html .= " 	cancelPlace: '".addslashes($this->$cancel_place)."',\n";
		}
		if ($this->no_rate_msg != "") {
			$html .= " 	noRatedMsg: '".addslashes($this->no_rate_msg)."',\n";
		}
		if (sizeof($this->hint_start_value) > 0) {
			$html .= " 	hintList: [";
			for ($i=0; $i < sizeof($this->hint_start_value); $i++) {
				if ($i > 0) { $html .= ", "; }
				$html .= "'".addslashes($this->hint_start_value[$i])."'";
			}
			$html .= "],\n";
		}
		if ($this->display_big_icon) {
			if ($this->cancel_button) {
				$html .= " 	cancelOff: 'cancel-off-big.png',\n";
				$html .= " 	cancelOn: 'cancel-on-big.png',\n";
			}
			$html .= " 	size: 24,\n";
			if ($this->display_half_start) {
				$html .= " 	starHalf: 'star-half-big.png',\n";
			}
			$html .= " 	starOff: 'star-off-big.png',\n";
			$html .= " 	starOn: 'star-on-big.png',\n";
		}
		if (!$this->space) {
			$html .= " 	space: false,\n";
		}
		if ($this->callback_onclick != "" || $this->onclick != "") {
			$html .= "	click: function(score, evt) { ";
			if ($this->callback_onclick != "") {
				$html .= str_replace("\n", "", $this->getObjectEventValidationRender($this->onclick, $this->callback_onclick));
			} else if ($this->onclick != "") {
				$html .= str_replace("\n", "", $this->onclick);
			}
			if ($this->onclick_readonly) {
				$html .= "$('#".$this->id."').raty('readOnly', true);";
			}
			$html .= " },\n";
		}
		$html .= " 	number: ".$this->star_number.",\n";
		$html .= " 	start: ".$this->start."\n";
		$html .= "});\n";
		$html .= $this->getJavascriptTagClose();
		
		if ($this->callback_onclick != "") {
			$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
			if ($this->is_ajax_event && !$ajax_render) {
				$html .= $this->getJavascriptTagOpen();
				$html .= $this->getAjaxEventFunctionRender();
				$html .= $this->getJavascriptTagClose();
			}
		}
		
		return $html;
	}
}
?>
