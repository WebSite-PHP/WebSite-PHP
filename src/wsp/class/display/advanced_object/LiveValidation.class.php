<?php
/**
 * PHP file wsp\class\display\advanced_object\LiveValidation.class.php
 * @package display
 * @subpackage advanced_object
 */
/**
 * Class LiveValidation
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2017 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @subpackage advanced_object
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 11/10/2017
 * @version     1.2.15
 * @access      public
 * @since       1.0.17
 */

class LiveValidation extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $object=null;
	private $onlyOnSubmit = false;
	private $alert_msg = "";
	private $field_name = "";
	
	private $validate_js = "";
	private $valid_init = false;
	/**#@-*/

	/**
	 * Constructor LiveValidation
	 * @param boolean $onlyOnSubmit [default value: false]
	 */
	function __construct($onlyOnSubmit=false) {
		parent::__construct();
		
		$this->onlyOnSubmit = $onlyOnSubmit;
		
		$this->addCss(BASE_URL."wsp/css/live_validation.css", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/livevalidation_standalone.compressed.js", "", true);
	}
	
	/**
	 * Method setObject
	 * @access public
	 * @param WebSitePhpObject $object 
	 * @return LiveValidation
	 * @since 1.0.35
	 */
	public function setObject($object) {
		if (!isset($object)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}
		
		if (!method_exists($object, "getId")) {
			throw new NewException("You can not use object ".get_class($object)." in LiveValidation object, because the method getId() doesn't exists.", 0, getDebugBacktrace(1));
		}
		
		$this->object = $object;
		return $this;
	}
	
	/**
	 * Method setFieldName
	 * @access public
	 * @param string $name 
	 * @return LiveValidation
	 * @since 1.0.35
	 */
	public function setFieldName($name) {
		$this->field_name = $name;
		return $this;
	}
	
	/**
	 * Method setAlertMessage
	 * @access public
	 * @param string $message 
	 * @return LiveValidation
	 * @since 1.0.35
	 */
	public function setAlertMessage($message) {
		$this->alert_msg = $message;
		return $this;
	}
	
	/**
	 * Method addValidatePresence
	 * @access public
	 * @return LiveValidation
	 * @since 1.0.35
	 */
	public function addValidatePresence() {
		//.add( Validate.Presence )
		$this->validate_js .= ".add(Validate.Presence)";
		return $this;
	}
	
	/**
	 * Method addValidateFormat
	 * @access public
	 * @param string $pattern 
	 * @return LiveValidation
	 * @since 1.0.35
	 */
	public function addValidateFormat($pattern) {
		//.add( Validate.Format, { pattern: /live/i } );
		$this->validate_js .= ".add(Validate.Format, {pattern: ".$pattern."})";
		return $this;
	}
	
	/**
	 * Method addValidateNumericality
	 * @access public
	 * @param boolean $onlyInteger [default value: false]
	 * @param integer $minimum 
	 * @param integer $maximum 
	 * @param integer $is 
	 * @return LiveValidation
	 * @since 1.0.35
	 */
	public function addValidateNumericality($onlyInteger=false, $minimum='', $maximum='', $is='') {
		$this->validate_js .= ".add(Validate.Numericality, {";
		$first_param = true;
		if ($is!="") {
			if (!$first_param) { $this->validate_js .= ", ";$first_param = false; }
			$this->validate_js .= "is: '".str_replace("'", "\'", $is)."'";
		}
		if ($minimum!="") {
			if (!$first_param) { $this->validate_js .= ", ";$first_param = false; }
			$this->validate_js .= "minimum: '".str_replace("'", "\'", $minimum)."'";
		}
		if ($maximum!="") {
			if (!$first_param) { $this->validate_js .= ", ";$first_param = false; }
			$this->validate_js .= "maximum: '".str_replace("'", "\'", $maximum)."'";
		}
		if ($onlyInteger) {
			if (!$first_param) { $this->validate_js .= ", ";$first_param = false; }
			$this->validate_js .= "onlyInteger: true";
		}
		$this->validate_js .= "})";
		
		return $this;
	}
	
	/**
	 * Method addValidateLength
	 * @access public
	 * @param integer $length 
	 * @return LiveValidation
	 * @since 1.0.35
	 */
	public function addValidateLength($length) {
		$this->validate_js .= ".add(Validate.Length, {is: ".$length."})";
		return $this;
	}
	
	/**
	 * Method addValidateMaxLength
	 * @access public
	 * @param mixed $length 
	 * @return LiveValidation
	 * @since 1.2.14
	 */
	public function addValidateMaxLength($length) {
		$this->validate_js .= ".add(Validate.Length, {maximum: ".$length."})";
		return $this;
	}
	
	/**
	 * Method addValidateMinLength
	 * @access public
	 * @param mixed $length 
	 * @return LiveValidation
	 * @since 1.2.14
	 */
	public function addValidateMinLength($length) {
		$this->validate_js .= ".add(Validate.Length, {minimum: ".$length."})";
		return $this;
	}
	
	/**
	 * Method addValidateInclusion
	 * @access public
	 * @return LiveValidation
	 * @since 1.0.35
	 */
	public function addValidateInclusion() {
		//add( Validate.Inclusion, { within: [ 'cow' , 'pigeon', 'giraffe' ], partialMatch: true } )
		return $this;
	}
	
	/**
	 * Method addValidateExclusion
	 * @access public
	 * @return LiveValidation
	 * @since 1.0.35
	 */
	public function addValidateExclusion() {
		//.add( Validate.Exclusion, { within: [ 'cow' , 'pigeon', 'giraffe' ], partialMatch: true } )
		return $this;
	}
	
	/**
	 * Method addValidateAcceptance
	 * @access public
	 * @return LiveValidation
	 * @since 1.0.35
	 */
	public function addValidateAcceptance() {
		//for checkbox
		//.add( Validate.Acceptance )
		return $this;
	}
	
	/**
	 * Method addValidateConfirmation
	 * @access public
	 * @param string $confirm_from_id 
	 * @return LiveValidation
	 * @since 1.0.35
	 */
	public function addValidateConfirmation($confirm_from_id) {
		$this->validate_js .= ".add(Validate.Confirmation, {match:'".$confirm_from_id."'})";
		return $this;
	}
	
	/**
	 * Method addValidateEmail
	 * @access public
	 * @return LiveValidation
	 * @since 1.0.35
	 */
	public function addValidateEmail() {
		$this->validate_js .= ".add(Validate.Email)";
		return $this;
	}
	
	/**
	 * Method addValidateCustom
	 * @access public
	 * @param mixed $js_validate 
	 * @param string $args 
	 * @return LiveValidation
	 * @since 1.0.35
	 */
	public function addValidateCustom($js_validate, $args='') {
		// Pass a function that checks if a number is divisible by one that you pass it in args object
		
		// Example:
		// $js_validate: "return !(value % args.divisibleBy)" (need to return trur or false)
		// $args: "divisibleBy: 5"
		// In this case, 5 is passed, so should return true and validation will pass
		
		// Other example:
		// $js_validate: "return value >= 0;"
		// In this case, if value greter or equal zero then true
		
		if ($js_validate instanceof JavaScript) {
			$js_validate = $js_validate->render();
		}
		
		$this->validate_js .= ".add(Validate.Custom, { against: function(value,args) { ".$js_validate." }, args: {".$args."} } )";
		
		return $this;
	}
	
	/**
	 * Method addValidateCalendar
	 * @access public
	 * @param mixed $calendar_format 
	 * @return LiveValidation
	 * @since 1.2.7
	 */
	public function addValidateCalendar($calendar_format) {
		$dateFormatRegex = array("dd/mm/yy" => "/^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]\d{4}$/",
        							"mm-dd-yy" => "/^(0?[1-9]|1[012])[\-](0?[1-9]|[12][0-9]|3[01])[\-]\d{4}$/",
        							"dd.mm.yy" => "/^(0?[1-9]|[12][0-9]|3[01])[\.](0?[1-9]|1[012])[\.]\d{4}$/",
        							"yy-mm-dd" => "/^\d{4}[\-](0?[1-9]|1[012])[\-](0?[1-9]|[12][0-9]|3[01])$/",);
		if (!isset($dateFormatRegex[$calendar_format])) {
			$ok_format = "";
			foreach ($dateFormatRegex as $key => $value) {
				if ($ok_format != "") { $ok_format .= ", "; }
				$ok_format .= $key;
			}
			throw new NewException("LiveValidation->addValidateCalendar() error: \$calendar_format not recognized. Valid format: ".$ok_format.".", 0, getDebugBacktrace(1));
		}
		$this->addValidateFormat($dateFormatRegex[$calendar_format]);
		return $this;
	}
	
	/**
	 * Method getFieldName
	 * @access public
	 * @return mixed
	 * @since 1.2.2
	 */
	public function getFieldName() {
		return $this->field_name;
	}
	
	/**
	 * Method activeValidationOnInit
	 * @access public
	 * @return LiveValidation
	 * @since 1.2.6
	 */
	public function activeValidationOnInit() {
		$this->valid_init = true;
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object LiveValidation
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		if (!isset($this->object)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, getDebugBacktrace(1));
		}
		
		if (get_class($this->object) == "Form") {
			return;
		}
		
		$html = "";
		//$html .= $this->getJavascriptTagOpen();
		
		if (get_class($this->object) == "Editor") {
			$id = $this->object->getHiddenId();
		} else {
			$id = $this->object->getId();
		}
		$html .= "	LV_".$id." = new LiveValidation('".$id."'";
		if ($this->onlyOnSubmit) {
			$html .= ", {onlyOnSubmit: true}";
		}
		$html .= ");\n";
		$html .= "	LV_".$id.$this->validate_js.";\n";
		if ($this->valid_init) {
			$html .= "	LV_".$id.".validate();\n";
		}
		
		if (method_exists($this->object, "getFormObject")) {
			$form_object = $this->object->getFormObject();
			if ($form_object != null) {
				// search all button of the form
				$event_object_name = "Button_".$form_object->getName();
				$eventObject = $form_object->getPageObject()->getEventObjects($event_object_name);
				for ($i=0; $i < sizeof($eventObject); $i++) {
					if ($eventObject[$i]->getDisableLiveValidation()) {
						continue;
					}
					if (find($eventObject[$i]->getOnClickJs(), "/*LV_condition_zone*/", 0, 0) > 0) {
						$eventObject[$i]->onClickJs(str_replace("/*LV_validate_zone*/", "LV_".$id.".validate();/*LV_validate_zone*/", $eventObject[$i]->getOnClickJs()));
						$eventObject[$i]->onClickJs(str_replace("/*LV_condition_zone*/", "&&LiveValidationForm_".$form_object->getName()."_".$id."()/*LV_condition_zone*/", $eventObject[$i]->getOnClickJs()));
					} else {
						$html .= "	lv_error_alert_id = '';\n	lv_error_alert_field_name = '';\n	lv_error_alert_msg = '';\n	LV_ErrorAlert_".$form_object->getName()." = function() { ";
						
						$error_dialogbox_msg = new DialogBox(__(ERROR), __(LIVE_VALIDATION_FORMULAR_ERROR_MSG));
						$error_dialogbox_msg->activateCloseButton("\$('#'+lv_error_alert_id).focus();");
						
						$error_dialogbox_field = new DialogBox(__(ERROR), __(LIVE_VALIDATION_FORMULAR_FIELD_ERROR));
						$error_dialogbox_field->activateCloseButton("\$('#'+lv_error_alert_id).focus();");
						
						if (DEBUG) {
							$error_dialogbox = new DialogBox(__(ERROR), __(LIVE_VALIDATION_FORMULAR_ERROR_DEBUG));
						} else {
							$error_dialogbox = new DialogBox(__(ERROR), __(LIVE_VALIDATION_FORMULAR_ERROR));
						}
						$error_dialogbox->activateCloseButton();
						
						$html .= "	if (lv_error_alert_msg != '') {\n";
						$html .= "		".$error_dialogbox_msg->render()."\n";
						$html .= "	} else if (lv_error_alert_field_name != '') {\n";
						$html .= "		".$error_dialogbox_field->render();
						$html .= "	} else {\n";
						$html .= "		".$error_dialogbox->render()."\n";	
						$html .= "	}\n";
						
						$html .= " };\n";
						$eventObject[$i]->onClickJs("LV_".$id.".validate();/*LV_validate_zone*/if(LiveValidationForm_".$form_object->getName()."_".$id."()/*LV_condition_zone*/){".$eventObject[$i]->getOnClickJs()."}else{LV_ErrorAlert_".$form_object->getName()."();return false;}");
					}
				}
				
				$html .= "	LiveValidationForm_".$form_object->getName()."_".$id." = function() {\n";
				if (get_class($this->object) == "ComboBox") {
					// To display the livevalidation flag on ComboBox
					$html .= "		$('#".$id."_cmb_span').find('.LV_validation_message').each(function() { if (\$(this).parent().hasClass('ddOutOfVision') == false) { \$(this).remove(); } });\n";
					$html .= "		var lv_msg_dom = $('#".$id."_cmb_span').find('.ddOutOfVision').find('.LV_validation_message').detach();\n";
					$html .= "		\$(lv_msg_dom).insertAfter($('#".$id."_cmb_span').find('.dd.ddcommon'));\n";
				}
				$html .= "		if ($('#".$id."').attr('disabled')) {\n";
				$html .= "			return true;\n";
				$html .= "		} else {\n";
				$html .= "			var valid=(LV_".$id.".message!='Thankyou!'||LV_".$id.".message==null)?false:true;\n";
				$html .= "			if (valid) return true;\n";
				$html .= "			lv_error_alert_id = '".$id."';\n";
				if ($this->field_name != "") {
					$html .= "			lv_error_alert_field_name = '".addslashes($this->field_name)."';\n";
				} else {
					$html .= "			lv_error_alert_field_name = '';\n";
				}
				if ($this->alert_msg != "") {
					$html .= "			lv_error_alert_msg = '".addslashes($this->alert_msg)."';\n";
				} else {
					$html .= "			lv_error_alert_msg = '';\n";
				}
				$html .= "			return false;\n";
				$html .= "		}\n";
				$html .= "	};\n";
			} else {
				throw new NewException("To use LineValidation for object ".get_class($this->object)." you must add him in a form (form object is null).", 0, getDebugBacktrace(1));
			}
		} else {
			throw new NewException("LineValidation error: method getFormObject is missing for object ".get_class($this->object).".", 0, getDebugBacktrace(1));
		}
		//$html .= $this->getJavascriptTagClose();
		$this->getPage()->addObject(new JavaScript($html), false, true);
		
		$this->object_change = false;
		return "";
	}
}
?>
