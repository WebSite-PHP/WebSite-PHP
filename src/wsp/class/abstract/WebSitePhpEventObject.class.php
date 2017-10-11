<?php
/**
 * PHP file wsp\class\abstract\WebSitePhpEventObject.class.php
 * @package abstract
 */
/**
 * Abstract Class WebSitePhpEventObject
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2017 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package abstract
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 20/07/2016
 * @version     1.2.15
 * @access      public
 * @since       1.0.18
 */

include_once("WebSitePhpObject.class.php");

abstract class WebSitePhpEventObject extends WebSitePhpObject {
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
	 * Internal method used by an object like ComboBox or SelectList or TextBox to init it with submitted value (if not already done).
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
				decryptRequestEncryptData($this->form_object, $class_name."_".$this->form_object->getName()); // decrypt Form data
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
			} else { // form right is GET
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
	
	public function getSubmitValueIsInit() {
		return $this->is_init_submit_value;
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
	public function setAjaxEvent($bool=true) {
		$this->is_ajax_event = $bool;
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
				throw new NewException("Error ".get_class($this)."->setAjaxWaitMessage(): \$message_or_object must be an Object and not ".get_class($message_or_object).".", 0, getDebugBacktrace(1));
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
	
	public function enableAjaxWaitMessage() {
		$this->disable_ajax_wait_message = false;
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
			throw new NewException("Error ".get_class($this)."->setFormChangeMessage(): ".get_class($message_or_object)." must be associate to a Form object.", 0, getDebugBacktrace(1));
		}
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript" && !is_subclass_of($js_function, "JavaScript")) {
			throw new NewException(get_class($this)."->onFormChangeJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript" || is_subclass_of($js_function, "JavaScript")) {
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
		
		// TODO: add the posibility to do a callback to another object
		/*if (is_array($str_function)) {
			if (gettype($str_function[0]) == "object" || sizeof($str_function) != 2) {
				throw new NewException(get_class($this)."->loadCallbackMethod() error: \$str_function can be an array, but you need to define like it: array(\$this, \"methodToCall\").", 0, getDebugBacktrace(1));
			}
			$page_object = $str_function[0];
			$str_function = trim($str_function[1]);
		} else {*/
			$str_function = trim($str_function);
			if ($this->form_object == null || $this->form_object->getRealAction() == "") {
				$page_object = $this->page_object;
			} else {
				$action_page = $this->form_object->getRealAction();
				$action_page = explode('?', $action_page);
				$action_page = str_replace(".html", "", $action_page[0]);
				$page_object = Page::getInstance($action_page);
			}
		//}
		$str_function_tmp = $str_function;
		$pos = strpos($str_function_tmp, "(");
		if ($pos > 0) {
			$str_function_tmp = substr($str_function_tmp, 0, $pos);
		}
		if (method_exists($page_object, $str_function_tmp)) {
			for ($i=0; $i < sizeof($array_args); $i++) {
				if ($this->callback_args != "") { $this->callback_args .= ","; }
				if (gettype($array_args[$i]) == "object") {
					if (get_class($array_args[$i]) == "Form") {
						$array_form_object = $array_args[$i]->getFormObjects();
						$array_callback_args = "new Array('WSP_Callback_JSON'";
						for ($j=0; $j < sizeof($array_form_object); $j++) {
							if (get_class($array_form_object[$j]) != "Button") {
								$callback_arg_js = $this->getJavaScriptCallbackArgValue($array_form_object[$j], false);
								if ($callback_arg_js !== false) {
									$array_callback_args .= ",'".addslashes($array_form_object[$j]->getId())."',".$callback_arg_js;
								}
							}
						}
						$array_callback_args .= ")";
						$this->callback_args .= "\''+addslashes(json_encode(".$array_callback_args."))+'\'";
					} else if (get_class($array_args[$i]) == "JavaScript") {
						$this->callback_args .= trim($array_args[$i]->render());
					} else {
						$callback_arg_js = $this->getJavaScriptCallbackArgValue($array_args[$i]);
						if ($callback_arg_js !== false) {
							$this->callback_args .= $callback_arg_js;
						} else {
							throw new NewException(get_class($array_args[$i])." is not a valid argument for the method ".$str_function_tmp.".", 0, getDebugBacktrace(1));
						}
					}
				} else {
					$this->callback_args .= "\'".str_replace('&', '{#wsp_callback_amp}', str_replace('\'', '{#wsp_callback_quote}', str_replace('+', '{#wsp_callback_plus}', str_replace('"', '{#wsp_callback_doublequote}', ($array_args[$i])))))."\'";
				}
			}
			
			if ($this->form_object == null || ($this->form_object->getRealAction() == "" || 
				($this->form_object->getRealAction() != "" && substr($this->form_object->getRealAction(), 0, strlen($_GET['p'])) == $_GET['p']))) {
					$callback = $str_function_tmp;
			} else {
				if (find($str_function_tmp, "public_", 0, 0) > 0) {
					$callback = get_class($page_object)."().".$str_function_tmp;
				} else {
					throw new NewException("The callback method ".$str_function_tmp." must begin by 'public_' to be access from other page.", 0, getDebugBacktrace(1));
				}
			}
			
			// call callback method if not done during init
			if ($GLOBALS['__PAGE_IS_INIT__']) { 
				$this->page_object->executeCallback();
			}
		} else if ($str_function != "") {
			throw new NewException("Undefined method ".$str_function_tmp." in class ".get_class($page_object), 0, getDebugBacktrace(1));
		} else {
			$this->is_ajax_event = false;
		}
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $callback;
	}
	
	private function getJavaScriptCallbackArgValue($arg, $quote=true) {
		$quote_begin = "myReplaceAll(myReplaceAll(myReplaceAll(myReplaceAll(";
		$quote_end = ", '&', '{#wsp_callback_amp}'), '\'', '{#wsp_callback_quote}'), '+', '{#wsp_callback_plus}'), '\\\"', '{#wsp_callback_doublequote}')";
		if ($quote) {
			$quote_begin = "\''+".$quote_begin;
			$quote_end = $quote_end."+'\'";
		}
		
		$callback_arg_js = false;
		if (get_class($arg) == "TextBox" || get_class($arg) == "ColorPicker" || 
			get_class($arg) == "Button" || get_class($arg) == "Calendar" || 
			get_class($arg) == "Hidden" || get_class($arg) == "RadioButtonGroup") {
				$callback_arg_js = $quote_begin."(\$('#".trim($arg->getId())."').val()==null?'':addslashes(\$('#".trim($arg->getId())."').val()))".$quote_end;
		} else if (get_class($arg) == "TextArea") {
			$callback_arg_js = $quote_begin."(\$('#".trim($arg->getId())."').val()==null?'':myReplaceAll(myReplaceAll(addslashes(\$('#".trim($arg->getId())."').val()), '\\n', '\\\\n'), '\\r', ''))".$quote_end;
		} else if (get_class($arg) == "ComboBox" || get_class($arg) == "SelectList" || get_class($arg) == "SelectListMultiple") {
			$callback_arg_js = $quote_begin."(\$('#".trim($arg->getEventObjectName())."').val()==null?'':\$('#".trim($arg->getEventObjectName())."').val())".$quote_end;
		} else if (get_class($arg) == "CheckBox") {
			$callback_arg_js = $quote_begin."(\$('#".trim($arg->getId())."').attr('checked')?'on':'off')".$quote_end;
		} else if (get_class($arg) == "Editor") {
			$callback_arg_js = $quote_begin."getEditorContent_".trim($arg->getName())."()".$quote_end;
		}
		return $callback_arg_js;
	}
	
	/**
	 * Method getAjaxEventFunctionRender
	 * @access protected
	 * @return string
	 * @since 1.0.35
	 */
	protected function getAjaxEventFunctionRender() {
        $html = "";
        $loading_obj = null;
        if (get_class($this) == "UploadFile") {
            $loading_obj = $this->getProgressBarObject();

            if ($this->isSizeLimitJsCheckActivated() && $this->getFileSizeLimit() != -1) {
                $size_alert = new DialogBox(__(ERROR), __(UPLOAD_FILESIZE_LIMIT_ERROR_MSG, $this->getFileSizeLimitStr()));
                $size_alert->activateCloseButton()->setWidth(500);
                $size_alert->setDialogBoxLevel(rand(90000, 99999));
                $html .= "var displaySizeErrorDialogBox" . get_class($this) . "_" . $this->getEventObjectName() . " = function(filename) {\n";
                $html .= $size_alert->render();
                $html .= "};\n";
            } else {
                $html .= "var displaySizeErrorDialogBox" . get_class($this) . "_" . $this->getEventObjectName() . " = null;\n";
            }

            if ($this->isMimeTypeJsCheckActivated() && sizeof($this->getAuthorizedMimeTypes()) > 0) {
                $mime_alert = new DialogBox(__(ERROR), __(UPLOAD_MIME_TYPES_ERROR_MSG, implode(", ", $this->getAuthorizedMimeTypes())));
                $mime_alert->activateCloseButton()->setWidth(500);
                $mime_alert->setDialogBoxLevel(rand(90000, 99999));
                $html .= "var displayMimeErrorDialogBox" . get_class($this) . "_" . $this->getEventObjectName() . " = function(filename, mime_type) {\n";
                $html .= $mime_alert->render();
                $html .= "};\n";
            } else {
                $html .= "var displayMimeErrorDialogBox" . get_class($this) . "_" . $this->getEventObjectName() . " = null;\n";
            }
        }
		if (gettype($this->ajax_wait_message) != "object") {
            $loading_img = new Picture("wsp/img/loading.gif", 32, 32);
            $loading_img->setId("wspAjaxEventLoadingPic".get_class($this)."_".$this->getEventObjectName());
			$loading_modalbox = new DialogBox(__(LOADING), new Object($this->ajax_wait_message, "<br/>", $loading_img, $loading_obj));
			$loading_modalbox->setDialogBoxLevel(rand(90000, 99999))->modal();
		}
		
		$error_alert = new DialogBox(__(ERROR), __(SUBMIT_ERROR));
		$error_alert->activateCloseButton()->setWidth(500);
		$error_alert->setDialogBoxLevel(rand(90000, 99999));
		
		$error_unknow_alert = new DialogBox(__(ERROR), __(SUBMIT_UNKNOW_ERROR));
		$error_unknow_alert->activateCloseButton()->setWidth(400);
		$error_unknow_alert->setDialogBoxLevel(rand(90000, 99999));
		
		$html .= "	var isRequestedAjaxEvent".get_class($this)."_".$this->getEventObjectName()." = false;\n";
		$html .= "	var lastAjaxRequest".get_class($this)."_".$this->getEventObjectName()." = Array();\n";
		$html .= "	var nbAjaxRequest".get_class($this)."_".$this->getEventObjectName()." = 0;\n";
		if ($this->is_ajax_event) {
			$html .= "	var encryptedObjectValueArray".get_class($this)."_".$this->getEventObjectName()." = Array();\n";
		}
		$html .= "	callAjax".get_class($this)."_".$this->getEventObjectName()."_event = function(callback_value, abort_last_request) {\n";
		$html .= "		if (isRequestedAjaxEvent".get_class($this)."_".$this->getEventObjectName()." && !abort_last_request) { return; }\n";
		$html .= "		isRequestedAjaxEvent".get_class($this)."_".$this->getEventObjectName()." = true;\n";
		$html .= "		nbAjaxRequest".get_class($this)."_".$this->getEventObjectName()."++;\n";
		if (!$this->disable_ajax_wait_message) {
			if (gettype($this->ajax_wait_message) == "object") {
				$html .= "		$('#".$this->ajax_wait_message->getId()."').css('display', 'block');\n";
			} else {
				$html .= "		".$loading_modalbox->render()."\n";
			}
			$html .= "		setTimeout(\"requestAjaxEvent".get_class($this)."_".$this->getEventObjectName()."(\\\"\" + callback_value + \"\\\", \" + abort_last_request + \");\", ".(gettype($this->ajax_wait_message) == "object"?"1":"1000").");\n";
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
		
		if (get_class($this) == "UploadFile") {
			$html .= "var upload_status = $('#".$this->getId()."').upload('";
		} else {
			$html .= "		lastAjaxRequest".get_class($this)."_".$this->getEventObjectName()."[lastAjaxRequest".get_class($this)."_".$this->getEventObjectName().".length] = $.ajax({ type: '";
			if ($this->form_object != null) {
				$html .= $this->form_object->getMethod();
			} else {
				$html .= "POST";
			}
			$html .= "', url: '";
		}
		
		$html .= BASE_URL.LANGUAGE_URL."/ajax/";
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
			if ($this->form_object->getRealAction() == "") {
				$html .= $this->form_object->getPageObject()->getPage().".html";
				if (PARAMS_URL != "") {
					$pos = find(PARAMS_URL, "?", 0, $pos);
					if ($pos > 0) {
						$pos2 = strlen(PARAMS_URL);
						$html .= "?".substr(PARAMS_URL, $pos, $pos2-$pos);
					}
				}
			} else {
				$html .= $this->form_object->getRealAction();
			}
		}
		$html .= "',\n";
		
		if (get_class($this) == "UploadFile") {
			$html .= "			$('#Callback_".$this->getEventObjectName()."').serialize(),\n";
		} else {
			if ($this->form_object != null) {
				$html .= "			data: ";
				if ($this->form_object->isEncrypted()) {
					$html .= "encrypt_data";
				} else {
	        		$html .= "$('#".$this->form_object->getId()."').serialize() + '&Callback_".$this->getEventObjectName()."=' + callback_value";
				}
				$html .= ",\n";
			} else {
				$html .= "			data: 'Callback_".$this->getEventObjectName()."=' + callback_value,\n";
			}
	        $html .= "			dataType: 'json',\n";
	        $html .= "			success: ";
		}
        
        $html .= "function(ajax_event_response) {\n";
        $html .= "				isRequestedAjaxEvent".get_class($this)."_".$this->getEventObjectName()." = false;\n";
		$html .= "				if (ajax_event_response != \"\") {\n";
		$html .= "					var dialogbox_is_change = false;\n";
		if (isLocalDebug()) {
			$html .= "					var alert_local_eval_error = true;\n";
	    }
		$html .= "					for (var ajax_event_ind=0; ajax_event_ind < ajax_event_response.length; ajax_event_ind++) {\n";
		if (!$this->disable_ajax_wait_message) {
			$html .= "						if (ajax_event_response[ajax_event_ind] != null && ajax_event_response[ajax_event_ind].indexOf('wspDialogBox".$modalbox_indice."' + ' = ') != -1) {\n";
			$html .= "							dialogbox_is_change = true;\n";
			$html .= "						}\n";
		}
		if (get_class($this) == "UploadFile") {
			$html .= "						ajax_event_response[ajax_event_ind] = myReplaceAll(myReplaceAll(ajax_event_response[ajax_event_ind], '{#wsp_lt}', '<'), '{#wsp_gt}', '>');\n";
		}
		$html .= "						try {\n";
	    $html .= "							eval(ajax_event_response[ajax_event_ind]);\n";
	    $html .= "						} catch (e) {\n";
	    $html .= "							console.log('Js error: ' + e.message + '\\nCode: ' + ajax_event_response[ajax_event_ind]);\n";
	    // display ajax render error message when it's local or debug execution (useful to debug)
	    if (isLocalDebug()) {
    		$html .= "							if (alert_local_eval_error) {\n";
    		$html .= "								alert('An error appeared during Ajax event, please check the console of your browser to see the error(s).');";
    		$html .= "								alert_local_eval_error = false;\n";
    		$html .= "							}\n";
    	}
		$html .= "						}\n";
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
	    $html .= "					".$error_unknow_alert->render()."\n";
	    $html .= "				}\n";
	    $html .= "				$('#Callback_".$this->getEventObjectName()."').val('');\n";
	    if ($this->is_ajax_event) {
	    	$html .= "				restoreEncryptedObject".get_class($this)."_".$this->getEventObjectName()."();\n";
	    }
	    $html .= "			},\n";
	    
	    if (get_class($this) == "UploadFile") {
	    	$html .= "			'json', $('#wsp_object_wspAjaxEventLoadingObj".get_class($this)."_".$this->getEventObjectName()."'), $('#wspAjaxEventLoadingPic".get_class($this)."_".$this->getEventObjectName()."'), displaySizeErrorDialogBox" . get_class($this) . "_" . $this->getEventObjectName() . ", '".$this->getFileSizeLimit()."', displayMimeErrorDialogBox" . get_class($this) . "_" . $this->getEventObjectName() . ", '".implode(", ", $this->getAuthorizedMimeTypes())."');\n";
            $html .= "			isRequestedAjaxEvent".get_class($this)."_".$this->getEventObjectName()." = false;\n";
            $html .= "			if (upload_status === false) {\n";
            if (gettype($this->ajax_wait_message) == "object") {
                $html .= "					$('#".$this->ajax_wait_message->getId()."').css('display', 'none');\n";
            } else {
                $html .= "					".$loading_modalbox->close()->render()."\n";
            }
            $html .= "			}\n";
	    } else {
		    $html .= "			error: function(transport) {\n";
		    $html .= "				isRequestedAjaxEvent".get_class($this)."_".$this->getEventObjectName()." = false;\n";
		    $html .= "				if (!abort_last_request || (abort_last_request && trim(transport.statusText) != 'abort')) {\n";
		    if (gettype($this->ajax_wait_message) == "object") {
				$html .= "					$('#".$this->ajax_wait_message->getId()."').css('display', 'none');\n";
			} else {
		    	$html .= "					".$loading_modalbox->close()->render()."\n";
			}
			$html .= "					if (trim(transport.responseText) == '') {\n";
		    $html .= "						".$error_unknow_alert->render();
		    $html .= "					} else {\n";
		    $html .= "						".$error_alert->render();
		    $html .= "					}\n";
			$html .= "				}\n";
		    $html .= "				$('#Callback_".$this->getEventObjectName()."').val('');\n";
		    if ($this->is_ajax_event) {
		    	$html .= "				restoreEncryptedObject".get_class($this)."_".$this->getEventObjectName()."();\n";
		    }
		    $html .= "			}\n";
	    }
	    
	    if (get_class($this) != "UploadFile") {
			$html .= "		});\n";
	    }
		$html .= "	};\n";
		
		if ($this->is_ajax_event) {
			$html .= "	restoreEncryptedObject".get_class($this)."_".$this->getEventObjectName()." = function() {\n";
			$html .= "		for (var i=0; i < encryptedObjectValueArray".get_class($this)."_".$this->getEventObjectName().".length; i++) {\n";
			$html .= "			$('#' + encryptedObjectValueArray".get_class($this)."_".$this->getEventObjectName()."[i][0]).val(encryptedObjectValueArray".get_class($this)."_".$this->getEventObjectName()."[i][1]);\n";
			$html .= "		}\n";
			$html .= "	};\n";
		}
		
		return $html;
	}
	
	/**
	 * Method encryptObjectData
	 * @access private
	 * @param WebSitePhpObject $object 
	 * @param string $js_on_error 
	 * @param boolean $force_encrypted_obj [default value: false]
	 * @return mixed
	 * @since 1.0.67
	 */
	private function encryptObjectData($object, $js_on_error='', $force_encrypted_obj=false) {
		$html = "";
		if ($object->isEncrypted() || $force_encrypted_obj) {
			if ($force_encrypted_obj != false) {
				$public_key = str_replace("\r", "", str_replace("\n", "", $force_encrypted_obj->getEncryptObject()->getPublicKey()));
			} else {
				$public_key = str_replace("\r", "", str_replace("\n", "", $object->getEncryptObject()->getPublicKey()));
			}
			$html .= "	var public_key = RSA.getPublicKey('".addslashes($public_key)."');\n";
			if (get_class($object)=="Form") {
				$html .= "	var object_data = $('#".$object->getId()."').serialize();\n";
			} else {
				$html .= "	var object_data = $('#".$object->getId()."').val();\n";
			}
			$html .= "	var public_key_length = ((public_key.getModulus().bitLength()+7)>>3)-11;\n";
			$html .= "	var encrypt_data = '';\n";
			$html .= "	for (var i=0; i < object_data.length; i=i+public_key_length) {\n";
			$html .= "		if (encrypt_data != '') { encrypt_data += '&'; }\n";
			$html .= "		var encrypt_val = RSA.encrypt(object_data.substr(i, public_key_length), public_key);\n";
			$html .= "		if (encrypt_val==false) {\n";
			if ($force_encrypted_obj != false) {
				$html .= "			alert('Error when encrypting your ".(get_class($force_encrypted_obj)=="Form"?"formular":get_class($force_encrypted_obj)).".');".$js_on_error."return false;\n";
			} else {
				$html .= "			alert('Error when encrypting your ".(get_class($object)=="Form"?"formular":get_class($object)).".');".$js_on_error."return false;\n";
			}
			$html .= "		}\n";
			
			if (get_class($object) != "Form") {
				$html .= "urlencode(";
			}
			$html .= "		encrypt_data += 'EncryptData_".get_class($object->getPage());
			if (get_class($object) != "Form" && $object->getFormObject() != null) {
				$html .= "_".$object->getFormObject()->getName();
			}
			if (get_class($object) != "Form") {
				$html .= "_".$object->getName()."[]=' + urlencode(encrypt_val));\n";
			} else {
				$html .= "_".$object->getName()."[]=' + urlencode(encrypt_val);\n";
			}
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
				if (get_class($this) == "Button" && $this->is_link || get_class($this) == "Picture" || 
					get_class($this) == "SortableEvent" || get_class($this) == "ContextMenuEvent" || 
					get_class($this) == "DroppableEvent" || get_class($this) == "UploadFile") {
						// it's ok for these cases
				} else {
					throw new NewException("Object ".get_class($this)." must link to a Form Object when he have a callback method in a DialogBox or a Tabs", 0, getDebugBacktrace(1));
				}
		}
		
		$html = "";
		if ($this->on_form_is_changed_js != "" && $this->form_object != null && get_class($this->form_object) == "Form") {
			$obj_id = $this->getId();
			if (get_class($this) == "ComboBox" || get_class($this) == "SelectList" || get_class($this) == "SelectListMultiple") {
				$obj_id = $this->getEventObjectName();
			}
			$html .= "if ($('#".$this->form_object->getId()."_WspFormChange').val() != ';".$obj_id.";') { ";
			if ($this->on_form_is_changed_revert) {
				$html .= "revertLastFormChangeObjectToDefaultValue('".get_class($this)."', '".$obj_id."', '".$this->form_object->getId()."');";
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
					$tmp_object = $object;
					if (get_class($tmp_object) == "Editor") {
						$object = $this->page_object->getObjectId($tmp_object->getHiddenId());
					}
					if ($this->is_ajax_event) {
						$encrypt_html .= "encryptedObjectValueArray".get_class($this)."_".$this->getEventObjectName()."[encryptedObjectValueArray".get_class($this)."_".$this->getEventObjectName().".length] = new Array();\n";
						$encrypt_html .= "encryptedObjectValueArray".get_class($this)."_".$this->getEventObjectName()."[encryptedObjectValueArray".get_class($this)."_".$this->getEventObjectName().".length-1][0] = '".$object->getId()."';\n";
						$encrypt_html .= "encryptedObjectValueArray".get_class($this)."_".$this->getEventObjectName()."[encryptedObjectValueArray".get_class($this)."_".$this->getEventObjectName().".length-1][1] = $('#".$object->getId()."').val();\n";
					}
					if (get_class($tmp_object) == "Editor") {
						$encrypt_html .= $this->encryptObjectData($object, '', $tmp_object);
					} else {
						$encrypt_html .= $this->encryptObjectData($object);
					}
					$encrypt_html .= "$('#".$object->getName()."').val(encrypt_data);\n";
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
			if (($this->is_ajax_event && $callback != "") || 
					($this->form_object != null && $callback != "") || $callback != "") {
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
				if ($callback != "") {
					if ($this->is_ajax_event) {
						$html .= $encrypt_html;
						$html .= "callAjax".get_class($this)."_".$this->getEventObjectName()."_event($('#Callback_".$this->getEventObjectName()."').val(), ".($abort_last_request?"true":"false").");\n";
					} else if ($this->form_object != null) {
						$html .= $encrypt_html;
						$html .= "$('#".$this->form_object->getId()."').submit();\n";
					} else {
						$html .= "location.href='".$this->generateCurrentUrlWithCallback()."';\n";
					}
				}
			} else if ($this->form_object != null) {
				$html .= $encrypt_html;
				$html .= "$('#".$this->form_object->getId()."').submit();\n";
			} else if ($callback != "") {
				$html .= "location.href='".$this->getPage()->getBaseURL()."/".$this->generateCurrentUrlWithCallback()."';\n";
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
			if ($this->form_object->getRealAction() == "") {
				$this->setAjaxEvent();
			}
		}
	}
}
?>
