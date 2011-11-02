<?php
/**
 * PHP file wsp\class\WebSitePhpEventObject.class.php
 */
/**
 * Class WebSitePhpEventObject
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
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.0.97
 * @access      public
 * @since       1.0.18
 */

include_once("WebSitePhpObject.class.php");

class WebSitePhpEventObject extends WebSitePhpObject {
	/**#@+
	* @access protected
	*/
	protected $class_name = "";
	protected $page_object = null;
	protected $form_object = null;
	
	protected $name = "";
	protected $id = "";
	
	protected $is_ajax_event = false;
	protected $ajax_wait_message = "";
	protected $disable_ajax_wait_message = false;
	protected $on_form_is_changed_js = "";
	protected $on_form_is_changed_revert = false;
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $is_init_submit_value = false;
	private $callback_args = "";
	/**#@-*/
	
	/**
	 * Constructor WebSitePhpEventObject
	 */
	function __construct() {
		parent::__construct();
		
		$this->ajax_wait_message = __(SUBMIT_LOADING_2);
		$this->disable_ajax_wait_message = false;
	}
	
	/**
	 * Method initSubmitValue
	 * Internal method used by an object like ComboBox or TextBox to init it with submitted value (if not already done).
	 * @access protected
	 * @return boolean
	 * @since 1.0.59
	 */
	protected function initSubmitValue() {
		if (!$this->is_init_submit_value && $this->page_object != null) {
			$this->is_init_submit_value = true;
			
			// WARNING if change : This code is almost identical with: Page->getUserEventObject(), Page->loadAllVariables()
			$class_name = get_class($this->page_object);
			$form_name = "";
			if ($this->form_object != null) {
				$form_name = $this->form_object->getName();
				decryptRequestEncryptData($this->form_object, "EncryptData_".$class_name."_".$this->form_object->getName()); // decrypt Form data
			}
			if ($form_name == "") {
				$name = $class_name."_".$this->getName();
			} else {
				$name = $class_name."_".$form_name."_".$this->getName();
			}
			$name_hidden = "";
			// use for component with hidden value
			if (get_class($this) == "Editor" && $GLOBALS['__AJAX_PAGE__'] == true) { 
				if ($form_name == "") {
					$name_hidden = $class_name."_hidden_".$this->getName();
				} else {
					$name_hidden = $class_name."_".$form_name."_hidden_".$this->getName();
				}
			}
			$form_object = $this->getFormObject();
			// check object's form rights (POST or GET) before load variable
			// If this variable exists load it into the object
			if ($form_object == null) { // no form associate to event object
				if (isset($_POST[$name])) {
					if ($name_hidden != "") {
						$this->setValue(decryptRequestEncryptData($this, $name_hidden, "POST"));
						return true;
					} else {
						$this->setValue(decryptRequestEncryptData($this, $name, "POST"));
						return true;
					}
				} else if (isset($_GET[$name])) {
					if ($name_hidden != "") {
						$this->setValue(decryptRequestEncryptData($this, $name_hidden, "GET"));
						return true;
					} else {
						$this->setValue(decryptRequestEncryptData($this, $name, "GET"));
						return true;
					}
				}
			} else if ($form_object->getMethod() == "POST") { // form rights is POST
				if (isset($_POST[$name])) {
					if ($name_hidden != "") {
						$this->setValue(decryptRequestEncryptData($this, $name_hidden, "POST"));
						return true;
					} else {
						$this->setValue(decryptRequestEncryptData($this, $name, "POST"));
						return true;
					}
				}
			} else { // form rights is GET
				if (isset($_GET[$name])) {
					if ($name_hidden != "") {
						$this->setValue(decryptRequestEncryptData($this, $name_hidden, "GET"));
						return true;
					} else {
						$this->setValue(decryptRequestEncryptData($this, $name, "GET"));
						return true;
					}
				}
			}
		}
		return false;
	}
	
	/**
	 * Method setSubmitValueIsInit
	 * Internal method to set when an object have already the submitted value
	 * @access public
	 * @return WebSitePhpEventObject
	 * @since 1.0.90
	 */
	public function setSubmitValueIsInit() {
		$this->is_init_submit_value = true;
		return $this;
	}
		
	/**
	 * Method getName
	 * @access public
	 * @return string
	 * @since 1.0.35
	 */
	public function getName() {
		return $this->name;
	}
		
	/**
	 * Method getId
	 * @access public
	 * @return string
	 * @since 1.0.35
	 */
	public function getId() {
		return ($this->id==""?$this->getName():$this->id);
	}
	
	/**
	 * Method getEventObjectName
	 * @access public
	 * @return string
	 * @since 1.0.35
	 */
	public function getEventObjectName() {
		return $this->class_name."_".$this->name;
	}

	/**
	 * Method getFormObject
	 * @access public
	 * @return Form
	 * @since 1.0.35
	 */
	public function getFormObject() {
		return $this->form_object;
	}
	
	/**
	 * Method isEventObject
	 * @access public
	 * @return boolean
	 * @since 1.0.35
	 */
	public function isEventObject() {
		return true;
	}
	
	/**
	 * Method isAjaxEvent
	 * @access public
	 * @return boolean
	 * @since 1.0.35
	 */
	public function isAjaxEvent() {
		return $this->is_ajax_event;
	}
	
	/**
	 * Method setAjaxEvent
	 * @access public
	 * @return WebSitePhpEventObject
	 * @since 1.0.35
	 */
	public function setAjaxEvent() {
		$this->is_ajax_event = true;
		return $this;
	}
	
	/**
	 * Method setAjaxWaitMessage
	 * @access public
	 * @param string|Object $message_or_object 
	 * @return WebSitePhpEventObject
	 * @since 1.0.35
	 */
	public function setAjaxWaitMessage($message_or_object) {
		if (gettype($message_or_object) == "object") {
			if (get_class($message_or_object) != "Object") {
				throw new NewException("Error ".get_class($this)."->setAjaxWaitMessage(): \$message_or_object must be an Object and not ".get_class($message_or_object).".", 0, 8, __FILE__, __LINE__);
			}
			$message_or_object->hide();
		}
		$this->ajax_wait_message = $message_or_object;
		return $this;
	} 
	
	/**
	 * Method disableAjaxWaitMessage
	 * @access public
	 * @return WebSitePhpEventObject
	 * @since 1.0.35
	 */
	public function disableAjaxWaitMessage() {
		$this->disable_ajax_wait_message = true;
		return $this;
	}
	
	/**
	 * Method onFormIsChangedJs
	 * @access public
	 * @param mixed $js_function 
	 * @param boolean $revert_this_object_to_old_value [default value: false]
	 * @return WebSitePhpEventObject
	 * @since 1.0.90
	 */
	public function onFormIsChangedJs($js_function, $revert_this_object_to_old_value=false) {
		if ($this->form_object == null || get_class($this->form_object) != "Form") {
			throw new NewException("Error ".get_class($this)."->setFormChangeMessage(): ".get_class($message_or_object)." must be associate to a Form object.", 0, 8, __FILE__, __LINE__);
		}
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript") {
			throw new NewException(get_class($this)."->onFormChangeJs(): \$js_function must be a string or JavaScript object.", 0, 8, __FILE__, __LINE__);
		}
		if (get_class($js_function) == "JavaScript") {
			$js_function = $js_function->render();
		}
		$this->form_object->onChangeJs(" ");
		$this->on_form_is_changed_js = $js_function;
		$this->on_form_is_changed_revert = $revert_this_object_to_old_value;
		return $this;
	}
	
	/**
	 * Method loadCallbackMethod
	 * @access protected
	 * @param string $str_function 
	 * @param array $array_args [default value: array(]
	 * @return mixed
	 * @since 1.0.35
	 */
	protected function loadCallbackMethod($str_function, $array_args=array()) {
		$callback = "";
		$this->callback_args = "";
		$str_function = trim($str_function);
		
		if ($this->form_object == null || $this->form_object->getAction() == "") {
			$page_object = $this->page_object;
		} else {
			$action_page = $this->form_object->getAction();
			$action_page = explode('?', $action_page);
			$action_page = str_replace(".html", "", $action_page[0]);
			$page_object = Page::getInstance($action_page);
		}
		
		$str_function_tmp = $str_function;
		$pos = strpos($str_function_tmp, "(");
		if ($pos > 0) {
			$str_function_tmp = substr($str_function_tmp, 0, $pos);
		}
		
		if (method_exists($page_object, $str_function_tmp)) {
			for ($i=0; $i < sizeof($array_args); $i++) {
				if ($this->callback_args != "") { $this->callback_args .= ","; }
				if (gettype($array_args[$i]) == "object") {
					if (get_class($array_args[$i]) == "TextBox" || get_class($array_args[$i]) == "ColorPicker" || 
						get_class($array_args[$i]) == "Button" || get_class($array_args[$i]) == "ComboBox" || 
						get_class($array_args[$i]) == "CheckBox" || get_class($array_args[$i]) == "Hidden" || 
						get_class($array_args[$i]) == "Calendar") {
							$this->callback_args .= "\''+$('#".trim($array_args[$i]->getId())."').val()+'\'";
					} else if (get_class($array_args[$i]) == "Editor") {
						$this->callback_args .= "\''+getEditorContent_".trim($array_args[$i]->getName())."()+'\'";
					} else if (get_class($array_args[$i]) == "JavaScript") {
						$this->callback_args .= trim($array_args[$i]->render());
					} else {
						throw new NewException(get_class($array_args[$i])." is not a valid argument for the method ".$str_function_tmp.".", 0, 8, __FILE__, __LINE__);
					}
				} else {
					$this->callback_args .= "\'".addslashes($array_args[$i])."\'";
				}
			}
			
			if ($this->form_object == null || $this->form_object->getAction() == "") {
				$callback = $str_function_tmp;
			} else {
				if (find($str_function_tmp, "public_", 0, 0) > 0) {
					$callback = get_class($page_object)."().".$str_function_tmp;
				} else {
					throw new NewException("The callback method ".$str_function_tmp." must begin by 'public_' to be access from other page.", 0, 8, __FILE__, __LINE__);
				}
			}
			
			// call callback method if not done during init
			if ($GLOBALS['__PAGE_IS_INIT__']) { 
				$this->page_object->executeCallback();
			}
		} else if ($str_function != "") {
			throw new NewException("Undefined method ".$str_function_tmp." in class ".get_class($page_object), 0, 8, __FILE__, __LINE__);
		} else {
			$this->is_ajax_event = false;
		}
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $callback;
	}
	
	/**
	 * Method getAjaxEventFunctionRender
	 * @access protected
	 * @return string
	 * @since 1.0.35
	 */
	protected function getAjaxEventFunctionRender() {
		if (gettype($this->ajax_wait_message) != "object") {
			$loading_img = new Picture("wsp/img/loading.gif", 32, 32);
			$loading_modalbox = new DialogBox(__(LOADING), new Object($this->ajax_wait_message, "<br/>", $loading_img));
			$loading_modalbox->setDialogBoxLevel(rand(90000, 99999))->modal();
		}
		
		$error_alert = new DialogBox(__(ERROR), __(SUBMIT_ERROR));
		$error_alert->activateCloseButton();
		$error_alert->setDialogBoxLevel(rand(90000, 99999));
		
		$html = "";
		$html .= "	var isRequestedAjaxEvent".get_class($this)."_".$this->getEventObjectName()." = false;\n";
		$html .= "	var lastAjaxRequest".get_class($this)."_".$this->getEventObjectName()." = Array();\n";
		$html .= "	var nbAjaxRequest".get_class($this)."_".$this->getEventObjectName()." = 0;\n";
		$html .= "	callAjax".get_class($this)."_".$this->getEventObjectName()."_event = function(callback_value, abort_last_request) {\n";
		$html .= "		if (isRequestedAjaxEvent".get_class($this)."_".$this->getEventObjectName()." && !abort_last_request) { return; }\n";
		$html .= "		isRequestedAjaxEvent".get_class($this)."_".$this->getEventObjectName()." = true;\n";
		$html .= "		nbAjaxRequest".get_class($this)."_".$this->getEventObjectName()."++;\n";
		if (!$this->disable_ajax_wait_message) {
			if (gettype($this->ajax_wait_message) == "object") {
				$html .= "		$('#".$this->ajax_wait_message->getId()."').css('display', 'block');\n";
			} else {
				$html .= "		".$loading_modalbox->render();
			}
			$html .= "		setTimeout(\"requestAjaxEvent".get_class($this)."_".$this->getEventObjectName()."(\\\"\" + callback_value + \"\\\", \" + abort_last_request + \");\", 1000);\n";
		} else {
			$html .= "		setTimeout(\"requestAjaxEvent".get_class($this)."_".$this->getEventObjectName()."(\\\"\" + callback_value + \"\\\", \" + abort_last_request + \");\", (abort_last_request?(lastAjaxRequest".get_class($this)."_".$this->getEventObjectName().".length==0?1:200):1));\n";
		}
		$html .= "	};\n";
		
		$html .= "	requestAjaxEvent".get_class($this)."_".$this->getEventObjectName()." = function(callback_value, abort_last_request) {\n";
		$html .= "		nbAjaxRequest".get_class($this)."_".$this->getEventObjectName()."--;\n";
		$html .= "		if (abort_last_request) { for (var i=0; i < lastAjaxRequest".get_class($this)."_".$this->getEventObjectName().".length; i++) { if (lastAjaxRequest".get_class($this)."_".$this->getEventObjectName()."[i]!=null) { lastAjaxRequest".get_class($this)."_".$this->getEventObjectName()."[i].abort(); lastAjaxRequest".get_class($this)."_".$this->getEventObjectName()."[i]=null; } } if (nbAjaxRequest".get_class($this)."_".$this->getEventObjectName()." > 0) { return; } }\n";
		// encrypt formular if encrypt is active
		if ($this->form_object != null) {
			$html .= "		".$this->encryptObjectData($this->form_object, "isRequestedAjaxEvent".get_class($this)."_".$this->getEventObjectName()." = false;".($loading_modalbox==null?"":$loading_modalbox->close()->render()));
		}
		$html .= "		lastAjaxRequest".get_class($this)."_".$this->getEventObjectName()."[lastAjaxRequest".get_class($this)."_".$this->getEventObjectName().".length] = $.ajax({ type: '";
		if ($this->form_object != null) {
			$html .= $this->form_object->getMethod();
		} else {
			$html .= "POST";
		}
		$html .= "', url: '".BASE_URL.LANGUAGE_URL."/ajax/";
		if ($this->form_object == null) {
			$html .= $this->getPage()->getPage().".html";
			if (PARAMS_URL != "") {
				$pos = find(PARAMS_URL, "?", 0, $pos);
				if ($pos > 0) {
					$pos2 = strlen(PARAMS_URL);
					$html .= "?".substr(PARAMS_URL, $pos, $pos2-$pos);
				}
			}
		} else {
			if ($this->form_object->getAction() == "") {
				$html .= $this->form_object->getPageObject()->getPage().".html";
				if (PARAMS_URL != "") {
					$pos = find(PARAMS_URL, "?", 0, $pos);
					if ($pos > 0) {
						$pos2 = strlen(PARAMS_URL);
						$html .= "?".substr(PARAMS_URL, $pos, $pos2-$pos);
					}
				}
			} else {
				$html .= $this->form_object->getAction();
			}
		}
		$html .= "',\n";
		if ($this->form_object != null) {
			$html .= "			data: ";
			if ($this->form_object->isEncrypted()) {
				$html .= "'EncryptData_".$this->form_object->getPageObject()->getClassName()."_".$this->form_object->getName()."=' + urlencode(encrypt_data)";
			} else {
        		$html .= "$('#".$this->form_object->getId()."').serialize() + '&Callback_".$this->getEventObjectName()."=' + callback_value";
			}
			$html .= ",\n";
		} else {
			$html .= "			data: 'Callback_".$this->getEventObjectName()."=' + callback_value,\n";
		}
        $html .= "			dataType: 'json',\n";
        $html .= "			success: function(ajax_event_response) {\n";
        $html .= "				isRequestedAjaxEvent".get_class($this)."_".$this->getEventObjectName()." = false;\n";
		$html .= "				if (ajax_event_response != \"\") {\n";
		$html .= "					var dialogbox_is_change = false;\n";
		$html .= "					for (var ajax_event_ind=0; ajax_event_ind < ajax_event_response.length; ajax_event_ind++) {\n";
		if (!$this->disable_ajax_wait_message) {
			$html .= "						if (ajax_event_response[ajax_event_ind].indexOf('wspDialogBox".$modalbox_indice."' + ' = ') != -1) {\n";
			$html .= "							dialogbox_is_change = true;\n";
			$html .= "						}\n";
		}
	    $html .= "						eval(ajax_event_response[ajax_event_ind]);\n";
	    $html .= "					}\n";
	    if (!$this->disable_ajax_wait_message) {
	    	if (gettype($this->ajax_wait_message) == "object") {
				$html .= "					$('#".$this->ajax_wait_message->getId()."').css('display', 'none');\n";
			} else {
			    $html .= "					if (!dialogbox_is_change) {\n";
			    $html .= "						".$loading_modalbox->close()->render();
			    $html .= "					}\n";
			}
	    }
	    $html .= "				} else {\n";
	    if (gettype($this->ajax_wait_message) == "object") {
			$html .= "					$('#".$this->ajax_wait_message->getId()."').css('display', 'none');\n";
		} else {
	    	$html .= "					".$loading_modalbox->close()->render();
		}
	    $html .= "					".$error_alert->render()."\n";
	    $html .= "				}\n";
	    $html .= "				$('#Callback_".$this->getEventObjectName()."').val('');\n";
	    $html .= "			},\n";
	    $html .= "			error: function(transport) {\n";
	    $html .= "				isRequestedAjaxEvent".get_class($this)."_".$this->getEventObjectName()." = false;\n";
	    $html .= "				if (!abort_last_request || (abort_last_request && trim(transport.statusText) != 'abort')) {\n";
	    if (gettype($this->ajax_wait_message) == "object") {
			$html .= "					$('#".$this->ajax_wait_message->getId()."').css('display', 'none');\n";
		} else {
	    	$html .= "					".$loading_modalbox->close()->render()."\n";
		}
	    $html .= "					".$error_alert->render();
		$html .= "				}\n";
	    $html .= "				$('#Callback_".$this->getEventObjectName()."').val('');\n";
	    $html .= "			}\n";
		$html .= "		});\n";
		$html .= "	};\n";
		
		return $html;
	}
	
	/**
	 * Method encryptObjectData
	 * @access private
	 * @param WebSitePhpObject $object 
	 * @param string $js_on_error 
	 * @return mixed
	 * @since 1.0.67
	 */
	private function encryptObjectData($object, $js_on_error='') {
		$html = "";
		if ($object->isEncrypted()) {
			$public_key = str_replace("\r", "", str_replace("\n", "", $object->getEncryptObject()->getPublicKey()));
			$public_key_length = strlen($public_key);
			$html .= "	var public_key = '".addslashes($public_key)."';\n";
			if (get_class($object)=="Form") {
				$html .= "	var object_data = $('#".$object->getId()."').serialize();\n";
			} else {
				$html .= "	var object_data = $('#".$object->getId()."').val();\n";
			}
			$html .= "	var encrypt_data = RSA.encrypt(object_data, RSA.getPublicKey(public_key));\n";
			$html .= "	if (encrypt_data==false) {\n";
			$html .= "		var encrypt_msg_error = 'Error when encrypting your ".(get_class($object)=="Form"?"formular":get_class($object)).".';\n";
			$html .= "		encrypt_msg_error += '\\nYour public key length is probably bigger than your data (increase your private key bits value).';\n";
			// $html .= "		encrypt_msg_error += '\\n[public key length: ' + public_key.length + ', data length: ' + object_data.length + ']';\n"; 
			$html .= "		alert(encrypt_msg_error);".$js_on_error."return false;\n";
			$html .= "	}\n";
		}
		return $html;
	}
	
	/**
	 * Method getObjectEventValidationRender
	 * @access protected
	 * @param string $on_event 
	 * @param string $callback 
	 * @param string $params 
	 * @param boolean $abort_last_request [default value: false]
	 * @return string
	 * @since 1.0.35
	 */
	protected function getObjectEventValidationRender($on_event, $callback, $params='', $abort_last_request=false) {
		if ($callback != "" && $this->form_object == null && 
			(isset($_GET['dialogbox_level']) || isset($_GET['tabs_object_id']))) {
				throw new NewException("Object ".get_class($this)." must link to a Form Object when he have a callback method in a DialogBox or a Tabs", 0, 8, __FILE__, __LINE__);
		}
		
		$html = "";
		if ($this->on_form_is_changed_js != "" && $this->form_object != null && get_class($this->form_object) == "Form") {
			$html .= "if ($('#".$this->form_object->getId()."_WspFormChange').val() != ';".$this->getId().";') { ";
			if ($this->on_form_is_changed_revert) {
				$html .= "revertLastFormChangeObjectToDefaultValue('".get_class($this)."', '".$this->getId()."', '".$this->form_object->getId()."');";
			}
			$html .= $this->on_form_is_changed_js." }\n";
		}
		if ($on_event != "" || $callback != "") {
			// force Editor copy to Hidden
			$js_force_editor_copy = "";
			$event_object_name = "Editor";
			if ($this->form_object != null) {
				$event_object_name .= "_".$this->form_object->getName();
			}
			$eventObject = $this->page_object->getEventObjects($event_object_name);
			for ($i=0; $i < sizeof($eventObject); $i++) {
				$object = $eventObject[$i];
				$js_force_editor_copy .= "copyEditorContent_".$object->getName()."ToHidden();";
			}
			
			if (get_class($this) == "Object") {
				$html .= "stopEventPropagation(event);\n";
			}
			$html = $html.$js_force_editor_copy;
			
			// object encryption
			$encrypt_html = "";
			for ($i=0; $i < sizeof($_SESSION['websitephp_register_object']); $i++) {
				$object = $_SESSION['websitephp_register_object'][$i];
				if (get_class($object) != "Form" && method_exists($object, "isEncrypted") && $object->isEncrypted()) {
					$encrypt_html .= $this->encryptObjectData($object);
					if (get_class($object) == "Editor") {
						$encrypt_html .= "$('#".$object->getId()."').val('')\n;";
						$encrypt_html .= "$('#hidden_".$object->getName()."').val(encrypt_data)\n;";
					} else {
						$encrypt_html .= "$('#".$object->getId()."').val(encrypt_data)\n;";
					}
				}
			}
			
			if ($callback != "") {
				$html .= "ResetCallbackObjectValue();\n$('#Callback_".$this->getEventObjectName()."').val('".$callback."(".$params;
				if ($this->callback_args != "") {
					if ($params != "") { $html .= ","; }
					$html .= $this->callback_args;
				}
				$html .= ")');\n";
			}
			if ($this->is_ajax_event || $this->form_object != null || $callback != "") {
				$html .= "if ($('#Callback_".$this->getEventObjectName()."').val() == '') { return false; }\n";
			}
			if ($on_event != "" || $this->is_ajax_event) {
				if ($on_event != "") {
					$html .= str_replace("\"", "\\\"", $on_event);
					if ($on_event[strlen($on_event)-1] != ";") {
						$html .= ";";
					}
					$html .= "\n";
				}
				if ($this->is_ajax_event) {
					$html .= $encrypt_html;
					$html .= "callAjax".get_class($this)."_".$this->getEventObjectName()."_event($('#Callback_".$this->getEventObjectName()."').val(), ".($abort_last_request?"true":"false").");\n";
				} else if ($this->form_object != null) {
					$html .= $encrypt_html;
					$html .= "$('#".$this->form_object->getId()."').submit();\n";
				} else if ($callback != "") {
					$html .= "location.href='".$this->generateCurrentUrlWithCallback()."';\n";
				}
			} else if ($this->form_object != null) {
				$html .= $encrypt_html;
				$html .= "$('#".$this->form_object->getId()."').submit();\n";
			} else if ($callback != "") {
				$html .= "location.href='".$this->generateCurrentUrlWithCallback()."';\n";
			}
		}
		return $html;
	}
	
	/**
	 * Method generateCurrentUrlWithCallback
	 * @access private
	 * @return string
	 * @since 1.0.35
	 */
	private function generateCurrentUrlWithCallback() {
		$array_params = explode("?", PARAMS_URL);
		$base_url = $array_params[0];
		$params_url = str_replace($base_url, "", PARAMS_URL);
		
		$array_params = explode("&", $params_url);
		$params_url = "";
		for ($i=0; $i < sizeof($array_params); $i++) {
			if ($i==0 && $array_params[$i][0] != "?") {
				$params_url .= "?";
			}
			if ($array_params[$i] != "") {
				$array_param = explode("=", $array_params[$i]);
				if (find($array_param[0], "Callback_") == 0) {
					$params_url .= $array_params[$i]."&";
				}
			}
		}
		if ($params_url == "") { $params_url = "?"; }
		return $base_url.$params_url."Callback_".$this->getEventObjectName()."='+ $('#Callback_".$this->getEventObjectName()."').val() + '";
	}
	
	/**
	 * Method automaticAjaxEvent
	 * @access public
	 * @since 1.0.59
	 */
	public function automaticAjaxEvent() {
		// automatic activation of ajax when events are call from DialogBox or Tabs
		if ((isset($_GET['dialogbox_level']) || isset($_GET['tabs_object_id'])) && $this->form_object != null) {
			if ($this->form_object->getAction() == "") {
				$this->setAjaxEvent();
			}
		}
	}
}
?>
