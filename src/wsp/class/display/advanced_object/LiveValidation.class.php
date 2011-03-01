<?php
/**
 * Description of PHP file wsp\class\display\advanced_object\LiveValidation.class.php
 * Class LiveValidation
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 22/10/2010
 *
 * @version     1.0.30
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
	/**#@-*/

	function __construct($onlyOnSubmit=false) {
		parent::__construct();
		
		$this->onlyOnSubmit = $onlyOnSubmit;
		
		$this->addCss(BASE_URL."wsp/css/live_validation.css", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/livevalidation_standalone.compressed.js", "", true);
	}
	
	public function setObject($object) {
		if (!isset($object)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		if (!method_exists($object, "getId")) {
			throw new NewException("You can not use object ".get_class($object)." in LiveValidation object, because the method getId() doesn't exists.", 0, 8, __FILE__, __LINE__);
		}
		
		$this->object = $object;
		return $this;
	}
	
	public function setFieldName($name) {
		$this->field_name = $name;
		return $this;
	}
	
	public function setAlertMessage($message) {
		$this->alert_msg = $message;
		return $this;
	}
	
	public function addValidatePresence() {
		//.add( Validate.Presence )
		$this->validate_js .= ".add(Validate.Presence)";
		return $this;
	}
	
	public function addValidateFormat($pattern) {
		//.add( Validate.Format, { pattern: /live/i } );
		$this->validate_js .= ".add(Validate.Format, {pattern: ".$pattern."})";
		return $this;
	}
	
	/*
	 *  addValidateNumericality
	 *  notANumberMessage (optional) - {String} - message to be used when validation fails because value is not a number (DEFAULT: �Must be a number!�)
	 *	notAnIntegerMessage (optional) - {String} - message to be used when validation fails because value is not an integer (DEFAULT: �Must be an integer!�)
	 *	wrongNumberMessage (optional) - {String} - message to be used when validation fails when �is� param is used (DEFAULT: �Must be {is}!�)
	 *	tooLowMessage (optional) - {String} - message to be used when validation fails when �minimum�} param is used (DEFAULT: �Must not be less than {minimum}!�)
	 *	tooHighMessage (optional) - {String} - message to be used when validation fails when �maximum�} param is used (DEFAULT: �Must not be more than {maximum}!�)
	 *	is (optional) - {mixed} - the value must be equal to this numeric value
	 *	minimum (optional) - {mixed} - the minimum numeric allowed
	 *	maximum (optional) - {mixed} - the maximum numeric allowed
	 *	onlyInteger (optional) - {Boolean} - if true will only allow integers to be valid (DEFAULT: false) 
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
	
	public function addValidateLength($length) {
		$this->validate_js .= ".add(Validate.Length, {is: ".$length."})";
		return $this;
	}
	
	public function addValidateInclusion() {
		//add( Validate.Inclusion, { within: [ 'cow' , 'pigeon', 'giraffe' ], partialMatch: true } )
		return $this;
	}
	
	public function addValidateExclusion() {
		//.add( Validate.Exclusion, { within: [ 'cow' , 'pigeon', 'giraffe' ], partialMatch: true } )
		return $this;
	}
	
	public function addValidateAcceptance() {
		//for checkbox
		//.add( Validate.Acceptance )
		return $this;
	}
	
	public function addValidateConfirmation($confirm_from_id) {
		$this->validate_js .= ".add(Validate.Confirmation, {match:'".$confirm_from_id."'})";
		return $this;
	}
	
	public function addValidateEmail() {
		$this->validate_js .= ".add(Validate.Email)";
		return $this;
	}
	
	public function addValidateCustom() {
		// Pass a function that checks if a number is divisible by one that you pass it in args object
		// In this case, 5 is passed, so should return true and validation will pass
		// Validate.Custom( 55, { against: function(value,args){ return !(value % args.divisibleBy) }, args: {divisibleBy: 5} } );
		return $this;
	}
	
	public function render($ajax_render=false) {
		if (!isset($this->object)) {
			throw new NewException("1 argument for ".get_class($this)."::__construct() is mandatory", 0, 8, __FILE__, __LINE__);
		}
		
		if (get_class($this->object) == "Form") {
			return;
		}
		
		$html = $this->getJavascriptTagOpen();
		
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
		
		if (method_exists($this->object, "getFormObject")) {
			$form_object = $this->object->getFormObject();
			if ($form_object != null) {
				// search all button of the form
				$event_object_name = "Button_".$form_object->getName();
				$eventObject = $form_object->getPageObject()->getEventObjects($event_object_name);
				for ($i=0; $i < sizeof($eventObject); $i++) {
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
				throw new NewException("To use LineValidation for object ".get_class($this->object)." you must add him in a form (form object is null).", 0, 8, __FILE__, __LINE__);
			}
		} else {
			throw new NewException("LineValidation error: method getFormObject is missing for object ".get_class($this->object).".", 0, 8, __FILE__, __LINE__);
		}
		$html .= $this->getJavascriptTagClose();
		$this->object_change = false;
		return $html;
	}
}
?>
