<?php
/**
 * PHP file wsp\class\display\Form.class.php
 * @package display
 */
/**
 * Class Form
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2012 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 26/05/2011
 * @version     1.1.6
 * @access      public
 * @since       1.0.17
 */

class Form extends WebSitePhpObject {
	/**#@+
	* method properties
	* @access public
	* @var string
	*/
	const METHOD_POST = "POST";
	const METHOD_GET = "GET";
	/**#@-*/
	
	/**#@+
	* @access private
	*/
	protected $page_object = null;
	private $name = "";
	private $id = "";
	private $method = "POST";
	private $action = "";
	private $content = null;
	private $onsubmitjs = "";
	private $onchangejs = "";
	
	private $encrypt_object = null;
	private $register_object = array();
	private $submit_dialog_box = null;
	private $dialog_box_display_delay = 200;
	/**#@-*/
	
	/**
	 * Constructor Form
	 * @param mixed $page_object 
	 * @param string $name 
	 * @param string $id 
	 * @param string $method [default value: POST]
	 */
	function __construct($page_object, $name='', $id='', $method="POST") {
		parent::__construct();
		
		if (!isset($page_object) || gettype($page_object) != "object" || !is_subclass_of($page_object, "Page")) {
			throw new NewException("Argument page_object for ".get_class($this)."::__construct() error", 0, getDebugBacktrace(1));
		}
		
		if ($name == "") {
			$name = $page_object->createObjectName($this);
		} else {
			$exist_object = $page_object->existsObjectName($name);
			if ($exist_object != false) {
				throw new NewException("Tag name \"".$name."\" for object ".get_class($this)." already use for other object ".get_class($exist_object), 0, getDebugBacktrace(1));
			}
			$page_object->addEventObject($this);
		}
		
		$this->page_object = $page_object;
		$this->name = $name;
		if ($id == "") {
			$this->id = $name;
		} else {
			$this->id = $id;
		}
		$this->method = $method;
		JavaScriptInclude::getInstance()->add("form.js", "", true);
		
		if ($this->page_object->isAjaxLoadPage()) {
			$this->onSubmitJs("return false;");
		}
	}
	
	/**
	 * Method setName
	 * @access public
	 * @param mixed $name 
	 * @return Form
	 * @since 1.0.35
	 */
	public function setName($name) {
		$this->name = $name;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setMethod
	 * @access public
	 * @param mixed $method 
	 * @return Form
	 * @since 1.0.35
	 */
	public function setMethod($method) {
		$this->method = $method;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setContent
	 * @access public
	 * @param object $content 
	 * @return Form
	 * @since 1.0.35
	 */
	public function setContent($content) {
		$this->content = $content;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setAction
	 * @access public
	 * @param mixed $action_file_name 
	 * @return Form
	 * @since 1.0.35
	 */
	public function setAction($action_file_name) {
		if (gettype($action_file_name) == "object" && get_class($action_file_name) != "Url") {
			throw new NewException(get_class($this)."->setAction() error: \$action_file_name must be a string or a Url object", 0, getDebugBacktrace(1));
		}
		if (gettype($action_file_name) == "object" && get_class($action_file_name) == "Url") {
			$action_file_name = $action_file_name->render();
		}
		
		$this->action = str_replace(".php", ".html", str_replace(".call", ".html", str_replace(".do", ".html", str_replace(".xhtml", ".html", $action_file_name))));
		$this->action = str_replace($this->page_object->getBaseLanguageURL(), "", $this->action);
		$this->action = str_replace($this->page_object->getBaseURL(), "", $this->action);
		
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setEncryptObject
	 * @access public
	 * @param mixed $encrypt_object [default value: null]
	 * @return Form
	 * @since 1.0.67
	 */
	public function setEncryptObject($encrypt_object=null) {
		if ($encrypt_object == null) {
			$encrypt_object = new EncryptDataWspObject();
		}
		if (gettype($encrypt_object) != "object" || get_class($encrypt_object) != "EncryptDataWspObject") {
			throw new NewException(get_class($this)."->setEncryption(): \$encrypt_object must be a EncryptDataWspObject object.", 0, getDebugBacktrace(1));
		}
		
		$this->addJavaScript(BASE_URL."wsp/js/jsbn.js", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/lowpro.jquery.js", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/rsa.js", "", true);
		
		$this->encrypt_object = $encrypt_object;
		$this->encrypt_object->setObject($this);
		
		return $this;
	}
	
	/**
	 * Method setSubmitDialogBox
	 * @access public
	 * @param mixed $dialog_box 
	 * @param double $display_delay [default value: 200]
	 * @return Form
	 * @since 1.0.99
	 */
	public function setSubmitDialogBox($dialog_box, $display_delay=200) {
		if (gettype($dialog_box) != "object" || get_class($dialog_box) != "DialogBox") {
			throw new NewException(get_class($this)."->setSubmitDialogBox(): \$dialog_box must be a DialogBox object.", 0, getDebugBacktrace(1));
		}
		
		$this->submit_dialog_box = $dialog_box;
		$this->dialog_box_display_delay = $display_delay;
		return $this;
	}
	
	/**
	 * Method getEncryptObject
	 * @access public
	 * @return mixed
	 * @since 1.0.67
	 */
	public function getEncryptObject() {
		return $this->encrypt_object;
	}
	
	/**
	 * Method isEncrypted
	 * @access public
	 * @return mixed
	 * @since 1.0.67
	 */
	public function isEncrypted() {
		return ($this->encrypt_object==null?false:true);
	}
		
	/**
	 * Method getName
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getName() {
		return $this->name;
	}
		
	/**
	 * Method getMethod
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getMethod() {
		return $this->method;
	}
		
	/**
	 * Method getPageObject
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getPageObject() {
		return $this->page_object;
	}
		
	/**
	 * Method getId
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Method registerObjectToForm
	 * @access public
	 * @param mixed $object 
	 * @return Form
	 * @since 1.0.35
	 */
	public function registerObjectToForm($object) {
		if ($object->isEventObject()) {
			$this->register_object[] = $object;
		}
		return $this;
	}
	
	/**
	 * Method getFormObjects
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getFormObjects() {
		return $this->register_object;
	}
	
	/**
	 * Method getAction
	 * @access public
	 * @return mixed
	 * @since 1.0.35
	 */
	public function getAction() {
		return $this->action;
	}
	
	/**
	 * Method onSubmitJs
	 * @access public
	 * @param string|JavaScript $js_function 
	 * @return Form
	 * @since 1.0.35
	 */
	public function onSubmitJs($js_function){
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript") {
			throw new NewException(get_class($this)."->onSubmitJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript") {
			$js_function = $js_function->render();
		}
		$this->onsubmitjs = $js_function;
		return $this;
	}
	
	/**
	 * Method onChangeJs
	 * @access public
	 * @param mixed $js_function 
	 * @return Form
	 * @since 1.0.90
	 */
	public function onChangeJs($js_function){
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript") {
			throw new NewException(get_class($this)."->onChangeJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript") {
			$js_function = $js_function->render();
		}
		if (trim($this->onchangejs) == "" && $js_function != "") {
			$this->onchangejs = $js_function;
		}
		return $this;
	}
	
	/**
	 * Method resetFormChangeHiddenField
	 * @access public
	 * @return Form
	 * @since 1.0.90
	 */
	public function resetFormChangeHiddenField() {
		$_GET[$this->id."_WspFormChange"] = "";
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object Form
	 * @since 1.0.35
	 */
	public function render($ajax_render=false) {
		$html = "";
		if ($this->page_object != null) {
			if ($this->submit_dialog_box != null) {
				$html .= $this->getJavascriptTagOpen();
				$html .= "	isSubmitDialogBox".$this->submit_dialog_box->getDialogBoxLevel()."Display = false;\n";
				$html .= "	dialogBox".$this->submit_dialog_box->getDialogBoxLevel()."AlreadyDisplay = false;\n";
				$html .= "	submitForm".$this->getId()."AfterDialogBox".$this->submit_dialog_box->getDialogBoxLevel()." = function(delay) {\n";
				$html .= "		if (isSubmitDialogBox".$this->submit_dialog_box->getDialogBoxLevel()."Display == false) {\n";
				$html .= "			if (dialogBox".$this->submit_dialog_box->getDialogBoxLevel()."AlreadyDisplay == false) {\n";
				$html .= "				dialogBox".$this->submit_dialog_box->getDialogBoxLevel()."AlreadyDisplay = true;\n";
				$html .= "				".$this->submit_dialog_box->render()."\n";
				$html .= "				setTimeout(submitForm".$this->getId().", delay);\n";
				$html .= "			}";
				$html .= "			return false;\n";
				$html .= "		} else {\n";
				$html .= "			return true;\n";
				$html .= "		}";
				$html .= "	};\n";
				$html .= "	submitForm".$this->getId()." = function() {\n";
				$html .= "		isSubmitDialogBox".$this->submit_dialog_box->getDialogBoxLevel()."Display=true;\n";
				$html .= "		$('#".$this->getId()."').submit();\n";
				$html .= "	};\n";
				$html .= $this->getJavascriptTagClose();
			}
			
			$html .= "<form name=\"".get_class($this->page_object)."_".$this->name."\" ";
			if ($this->id != "") {
				$html .= "id=\"".$this->id."\" ";
			}
			$html .= "action=\"";
			if ($this->action == "") {
				$html .= str_replace("ajax/", "", $this->page_object->getCurrentURL());
			} else {
				if (strtoupper(substr($this->action, 0, 7)) != "HTTP://" && strtoupper(substr($this->action, 0, 8)) != "HTTPS://") {
					$html .= $this->page_object->getBaseLanguageURL().$this->action;
				} else {
					$html .= $this->action;
				}
			}
			$html .= "\" ";
			$html .= "method=\"".$this->method."\" ";
			if ($this->onsubmitjs != "" || $this->submit_dialog_box != null) {
				$html .= "onSubmit=\"";
				if ($this->onsubmitjs != "") {
					$html .= $this->onsubmitjs;
				}
				if ($this->submit_dialog_box != null) {
					$html .= "submitForm".$this->getId()."AfterDialogBox".$this->submit_dialog_box->getDialogBoxLevel()."(".$this->dialog_box_display_delay.");";
				}
				$html .= "\" ";
			}
			$html .= ">\n";
			if ($this->content != null) {
				if (gettype($this->content) == "object" && method_exists($this->content, "render")) {
					$html .= $this->content->render();
				} else {
					$html .= $this->content;
				}
			}
			
			$hidden_form_change_value = "";
			if ($this->getMethod() == "POST" && isset($_POST[$this->id."_WspFormChange"])) {
				$hidden_form_change_value = $_POST[$this->id."_WspFormChange"];
			} else if (isset($_GET[$this->id."_WspFormChange"])) {
				$hidden_form_change_value = $_GET[$this->id."_WspFormChange"];
			}
			$html .= "<input type=\"hidden\" id=\"".$this->id."_WspFormChange\" name=\"".$this->id."_WspFormChange\" value=\"".$hidden_form_change_value."\"/>\n";
			$html .= "<input type=\"hidden\" id=\"".$this->id."_LastChangeObjectValue\" value=\"\"/>\n";
			$html .= "</form>\n";
			if ($this->onchangejs != "") {
				$html .= $this->getJavascriptTagOpen();
				$html .= "createOnChangeFormEvent('".$this->id."');\n";
				if (trim($this->onchangejs) != "") {
					$html .= $this->onchangejs."\n";
				}
				$html .= $this->getJavascriptTagClose();
			}
		}
		$this->object_change = false;
		return $html;
	}
}
?>
