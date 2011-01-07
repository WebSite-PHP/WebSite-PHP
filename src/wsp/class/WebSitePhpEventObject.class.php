<?php
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
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	private $is_init_submit_value = false;
	private $callback_args = "";
	/**#@-*/
	
	function __construct() {
		parent::__construct();
		
		$this->ajax_wait_message = __(SUBMIT_LOADING_2);
		$this->disable_ajax_wait_message = false;
	}
	
	protected function initSubmitValue() {
		if (!$this->is_init_submit_value && $this->page_object != null) {
			$this->is_init_submit_value = true;
			
			// WARNING if change : This code is identical with Page->getUserEventObject()
			$class_name = get_class($this->page_object);
			$form_name = "";
			if ($this->form_object != null) {
				$form_name = $this->form_object->getName();
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
						$this->setValue($_POST[$name_hidden]);
					} else {
						$this->setValue($_POST[$name]);
					}
				} else if (isset($_GET[$name])) {
					if ($name_hidden != "") {
						$this->setValue($_GET[$name_hidden]);
					} else {
						$this->setValue($_GET[$name]);
					}
				}
			} else if ($form_object->getMethod() == "POST") { // form rights is POST
				if (isset($_POST[$name])) {
					if ($name_hidden != "") {
						$this->setValue($_POST[$name_hidden]);
					} else {
						$this->setValue($_POST[$name]);
					}
				}
			} else { // form rights is GET
				if (isset($_GET[$name])) {
					if ($name_hidden != "") {
						$this->setValue($_GET[$name_hidden]);
					} else {
						$this->setValue($_GET[$name]);
					}
				}
			}
		}
	}
		
	public function getName() {
		return $this->name;
	}
		
	public function getId() {
		return ($this->id==""?$this->getName():$this->id);
	}
	
	public function getEventObjectName() {
		return $this->class_name."_".$this->name;
	}

	public function getFormObject() {
		return $this->form_object;
	}
	
	public function isEventObject() {
		return true;
	}
	
	public function isAjaxEvent() {
		return $this->is_ajax_event;
	}
	
	public function setAjaxEvent() {
		$this->is_ajax_event = true;
		return $this;
	}
	
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
	
	public function disableAjaxWaitMessage() {
		$this->disable_ajax_wait_message = true;
		return $this;
	}
	
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
						get_class($array_args[$i]) == "Button" || get_class($array_args[$i]) == "ComboBox") {
						$this->callback_args .= "\''+$('#".trim($array_args[$i]->getId())."').val()+'\'";
					} else if (get_class($array_args[$i]) == "Editor") {
						$this->callback_args .= "\''+getEditorContent_".trim($array_args[$i]->getName())."()+'\'";
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
		} else if ($str_function != "") {
			throw new NewException("Undefined method ".$str_function_tmp." in class ".get_class($page_object), 0, 8, __FILE__, __LINE__);
		} else {
			$this->is_ajax_event = false;
		}
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $callback;
	}
	
	protected function getAjaxEventFunctionRender() {
		if (gettype($this->ajax_wait_message) != "object") {
			$loading_img = new Picture("wsp/img/loading.gif", 32, 32);
			$loading_modalbox = new DialogBox(__(LOADING), new Object($this->ajax_wait_message, "<br/>", $loading_img));
			$loading_modalbox->setDialogBoxLevel(rand(90000, 99999))->modal();
		}
		
		$error_alert = new DialogBox(__(ERROR), __(SUBMIT_ERROR));
		$error_alert->setDialogBoxLevel(rand(90000, 99999));
		
		$html = "";
		$html .= "	callAjax".get_class($this)."_".$this->getEventObjectName()."_event = function(callback_value) {\n";
		$event_object_name = "Editor";
		if ($this->form_object != null) {
			$event_object_name .= "_".$this->form_object->getName();
		}
		$eventObject = $this->page_object->getEventObjects($event_object_name);
		for ($i=0; $i < sizeof($eventObject); $i++) {
			$object = $eventObject[$i];
			$html .= "		var editor_content = getEditorContent_".$object->getName()."();\n";
			$html .= "		$('#hidden_".$object->getName()."').val(editor_content);\n";
		}
		if (!$this->disable_ajax_wait_message) {
			if (gettype($this->ajax_wait_message) == "object") {
				$html .= "		$('#".$this->ajax_wait_message->getId()."').css('display', 'block');\n";
			} else {
				$html .= "		".$loading_modalbox->render();
			}
			$html .= "		setTimeout(\"requestAjaxEvent".get_class($this)."_".$this->getEventObjectName()."(\\\"\" + callback_value + \"\\\");\", 1000);\n";
		} else {
			$html .= "		setTimeout(\"requestAjaxEvent".get_class($this)."_".$this->getEventObjectName()."(\\\"\" + callback_value + \"\\\");\", 1);\n";
		}
		$html .= "	};\n";
		$html .= "	requestAjaxEvent".get_class($this)."_".$this->getEventObjectName()." = function(callback_value) {\n";
		$html .= "		$.ajax({ type: '";
		if ($this->form_object != null) {
			$html .= $this->form_object->getMethod();
		} else {
			$html .= "POST";
		}
		$html .= "', url: '".BASE_URL.LANGUAGE_URL."/ajax/";
		if ($this->form_object == null) {
			$tmp_url = str_replace(BASE_URL.LANGUAGE_URL."/ajax/", "", "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
			$tmp_url = str_replace(BASE_URL.LANGUAGE_URL."/", "", $tmp_url);
			$tmp_url = str_replace(".php?", ".html?", str_replace(".call?", ".html?", str_replace(".do?", ".html?", str_replace(".xhtml?", ".html?", $tmp_url))));
			$html .= $tmp_url;
		} else {
			if ($this->form_object->getAction() == "") {
				if (PARAMS_URL != "") {
					$params_url = PARAMS_URL;
					$pos = find($params_url, $this->form_object->getPageObject()->getPage().".", 0, 0);
					if ($pos > 0) {
						$pos2 = find($params_url, "?", 0, $pos);
						if ($pos2 == 0) {
							$pos2 = strlen($params_url);
						} else {
							$pos2 = $pos2 - 1;
						}
						$pos = $pos - strlen($this->form_object->getPageObject()->getPage().".");
						$params_url = str_replace(substr($params_url, $pos, $pos2-$pos), $this->form_object->getPageObject()->getPage().".html", $params_url);
					}
					$html .= $params_url;
				} else {
					$html .= $this->form_object->getPageObject()->getPage().".html";
				}
			} else {
				$html .= $this->form_object->getAction();
			}
		}
		$html .= "',\n";
		if ($this->form_object != null) {
        	$html .= "			data: $('#".$this->form_object->getId()."').serialize(),\n";
		} else {
			$html .= "			data: 'Callback_".$this->getEventObjectName()."=' + callback_value,\n";
		}
        $html .= "			dataType: 'json',\n";
        $html .= "			success: function(ajax_event_response) {\n";
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
	    if (gettype($this->ajax_wait_message) == "object") {
			$html .= "				$('#".$this->ajax_wait_message->getId()."').css('display', 'none');\n";
		} else {
	    	$html .= "				".$loading_modalbox->close()->render()."\n";
		}
	    $html .= "				".$error_alert->render();
	    $html .= "				$('#Callback_".$this->getEventObjectName()."').val('');\n";
	    $html .= "			}\n";
		$html .= "		});\n";
		$html .= "	};\n";
		
		return $html;
	}
	
	protected function getObjectEventValidationRender($on_event, $callback, $params='') {
		if ($callback != "" && $this->form_object == null && 
			(isset($_GET['dialogbox_level']) || isset($_GET['tabs_object_id']))) {
				throw new NewException("Object ".get_class($this)." must link to a Form Object when he have a callback method in a DialogBox or a Tabs", 0, 8, __FILE__, __LINE__);
		}
		
		$html = "";
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
			if ($callback != "") {
				$html .= "ResetCallbackObjectValue();\n$('#Callback_".$this->getEventObjectName()."').val('".$callback."(".$params;
				if ($this->callback_args != "") {
					if ($params != "") { $html .= ","; }
					$html .= $this->callback_args;
				}
				$html .= ")');\n";
			}
			$html .= "if ($('#Callback_".$this->getEventObjectName()."').val() == '') { return false; }\n";
			if ($on_event != "" || $this->is_ajax_event) {
				if ($on_event != "") {
					$html .= str_replace("\"", "\\\"", $on_event);
					if ($on_event[strlen($on_event)-1] != ";") {
						$html .= ";";
					}
					$html .= "\n";
				}
				if ($this->is_ajax_event) {
					$html .= "callAjax".get_class($this)."_".$this->getEventObjectName()."_event($('#Callback_".$this->getEventObjectName()."').val());\n";
				} else if ($this->form_object != null) {
					$html .= "$('#".$this->form_object->getId()."').submit();\n";
				} else if ($callback != "") {
					$html .= "location.href='".$this->generateCurrentUrlWithCallback()."';\n";
				}
			} else if ($this->form_object != null) {
				$html .= "$('#".$this->form_object->getId()."').submit();\n";
			} else if ($callback != "") {
				$html .= "location.href='".$this->generateCurrentUrlWithCallback()."';\n";
			}
		}
		return $html;
	}
	
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
					$params_url .= $array_params[$i];
				}
			}
		}
		return $base_url.$params_url."&Callback_".$this->getEventObjectName()."='+ $('#Callback_".$this->getEventObjectName()."').val() + '";
	}
	
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
